@extends('layouts.layout')
@section('css-export')
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/datatables.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/prism/prism.css") }}">

@endsection
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Data Treemap</h1>
		<div class="section-header-breadcrumb">
			<form class="form-inline">
				<input type="number" class="form-control mb-2 mr-sm-2" name="tahun" placeholder="Default Tahun: {{ date('Y') }}">
				<select name="jk" id="" class="form-control mb-2 mr-sm-2">
					<option value="LP">Semua Jenis Kelamin</option>
					@foreach (hJK() as $k => $v)
					<option value="{{ $k }}">{{ $v }}</option>
					@endforeach
				</select>

				<select name="usia" id="" class="form-control mb-2 mr-sm-2">
					@foreach (hUsia() as $k => $v)
					<option value="{{ $k }}">{{ $v }}</option>
					@endforeach
				</select>
				<select name="status" id="" class="form-control mb-2 mr-sm-2">
					<option value="0">Semua Status</option>
					@foreach (hStatusJemaah() as $k => $v)
					<option value="{{ $k }}">{{ $v }}</option>
					@endforeach
				</select>
				
				<select name="top" id="" class="form-control mb-2 mr-sm-2">
					@foreach (hTopBesar() as $k => $v)
					<option value="{{ $k }}">{{ $v }}</option>
					@endforeach
				</select>

				<a href="javascript:void(0)" class="btn btn-outline-primary" id="btn-update">Update Data</a>

			</form>
			<div class="breadcrumb-item active"></div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">

				<div class="card-body">
					
					<figure class="highcharts-figure">

						<div id="container"></div>
						
					</figure>
				</div>
			</div>
		</div>
	</div>



</section>


@endsection
@section('js-export')
<script src="{{ base_url("assets/modules/highcharts/highcharts.js") }}"></script>
<script src="{{ base_url("assets/modules/highcharts/modules/data.js") }}"></script>
<script src="{{ base_url("assets/modules/highcharts/modules/heatmap.js") }}"></script>
<script src="{{ base_url("assets/modules/highcharts/modules/treemap.js") }}"></script>
<script src="{{ base_url("assets/modules/highcharts/modules/offline-exporting.js") }}"></script>
<script src="{{ base_url("assets/modules/highcharts/modules/accessibility.js") }}"></script>
<script src="{{ base_url("assets/modules/highcharts/modules/boost.js") }}"></script>

@endsection
@section('js-inline')
<script>
	var insHighchart = null;
	var points = null;
	$(function() {
		
		insHighchart = generateHighTreemap();
		insHighchart.showLoading();
		fetchData("").then(r =>
		{
			points = populateData(r); 
			insHighchart.series[0].setData(points);
			insHighchart.hideLoading();

		}
		);


		$("#btn-update").click(function(e) {

			var tahun = $("input[name='tahun']").val() || "{{ date('Y') }}";
			var usia = $("select[name='usia']").val();
			var jk = $("select[name='jk']").val();
			var top = $("select[name='top']").val();
			var status = $("select[name='status']").val();
			post = {
				tahun,
				usia,
				jk,
				top,
				status
			};

			post = Object.keys(post).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post[key])).join('&')

			insHighchart.showLoading();

			fetchData(post).then(r =>
			{
				points = populateData(r); 
				insHighchart.hideLoading();
				
				insHighchart.series[0].update({data:points},false);

				insHighchart.redraw(false);
			}
			);
		});


	});

	function generateHighTreemap() {
		var options = {
			series: [{
				type: 'treemap',
				alternateStartingDirection: false,
				layoutStartingDirection: 'vertical',
				opacity: 0,
				layoutAlgorithm: 'squarified',
				allowDrillToNode: true,
				animation:false,
				dataLabels: {
					enabled: false,
					style: {
						fontSize: "10px",
						textOutline: 0
						

					}
				},

				levelIsConstant: false,
				levels: [{
					level: 1,
					dataLabels: {
						enabled: true,
					},
					borderWidth: 0,
				}
				],
				borderWidth: 0,
				data:[],
				turboThreshold: 0,
				

			}],
			

			tooltip: {
				style: {
					fontSize: "10px",
				},
				useHTML: true,
				borderRadius: 1,
				hideDelay:"0",
				padding: 0,
				backgroundColor: "#FFFFFF",

				borderColor: '#AAA',
				formatter: function () {
					return this.point.description+' ';
				}
			},

			title: {
				text: ''
			},

		};
		const chart = Highcharts.chart('container', options);
		return chart;

	}

	function populateData(result) {
		var points = [],
		kotaP,
		kotaVal,
		kotaI = 0,
		kloterP,
		kloterI,
		rombonganP,
		rombonganI,
		reguP,
		reguI,
		pesertaP,
		pesertaI,
		kota,
		kloter,
		rombongan,
		regu,
		peserta,
		data = result['data'];
		desc = result['description'];
		warna = '';
		dataPeserta = '';

		for (kota in data) {
			if (data.hasOwnProperty(kota)) {
				kotaVal = 0;
				kotaP = {
					id: 'id_' + kotaI,
					name: kota,
					description: desc[kota],
				};
				kloterI = 0;
				for (kloter in data[kota]) {
					if (data[kota].hasOwnProperty(kloter)) {
						kloterP = {
							id: kotaP.id + '_' + kloterI,
							name: kloter,
							parent: kotaP.id,
							description:desc[kota+'_'+kloter],

						};
						points.push(kloterP);
						rombonganI = 0;
						for (rombongan in data[kota][kloter]) {
							if (data[kota][kloter].hasOwnProperty(rombongan)) {
								rombonganP = {
									id: kloterP.id + '_' + rombonganI,
									name: rombongan,
									parent: kloterP.id,
									description:desc[kota+'_'+kloter+'_'+rombongan],


								};
								points.push(rombonganP);
								reguI = 0;
								for (regu in data[kota][kloter][rombongan]) {
									if (data[kota][kloter][rombongan].hasOwnProperty(regu)) {
										reguP = {
											id: rombonganP.id + '_' + reguI,
											name: regu,
											parent: rombonganP.id,
											description:desc[kota+'_'+kloter+'_'+rombongan+'_'+regu],


										};
										points.push(reguP);
										pesertaI = 0;
										for (peserta in data[kota][kloter][rombongan][regu]) {
											if (data[kota][kloter][rombongan][regu].hasOwnProperty(peserta)) {

												warna = '';

												if (data[kota][kloter][rombongan][regu][peserta] == 1) {
													warna = '#ff7675';
													dataPeserta = desc['kosong'];
												} else {
													warna = "#3742fa";
													dataPeserta = desc[kota+'_'+kloter+'_'+rombongan+'_'+regu+'_'+peserta];

												}

												pesertaP = {
													id: reguP.id + '_' + pesertaI,
													name: peserta,
													parent: reguP.id,
													value: Math.round(+data[kota][kloter][rombongan][regu][peserta]),
													description:dataPeserta,
													color: warna,
												}
												points.push(pesertaP);
												kotaVal += pesertaP.value;
												pesertaI = pesertaI + 1;
											}

										}

										reguI = reguI + 1;
									}
								}

								rombonganI = rombonganI + 1;


							}
						}
						kloterI = kloterI + 1;
					}
				}
				kotaP.value = Math.round(kotaVal);
				points.push(kotaP);
				kotaI = kotaI + 1;
			}
		}

		return points;
	}

	async function fetchData(values) {
		var url = "{{ base_url('treemap/map?') }}"+values;
		const response = await fetch(url, {
			method: 'GET',
		});
		return await response.json();
	}

</script>
@endsection
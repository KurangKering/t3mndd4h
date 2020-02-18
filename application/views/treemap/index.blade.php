@extends('layouts.layout')
@section('css-export')
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/datatables.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/prism/prism.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/select2/dist/css/select2.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/ionicons/css/ionicons.min.css") }}">
<link rel="stylesheet" href=>

@endsection
@section('css-inline')
<style>

	#table-kop  {
		font-size: 40px;
	}
	#table-kop tbody {
		/*border-collapse:collapse;
		box-sizing:border-box;
		display:table-row-group;
		font-family:Nunito, "Segoe UI", arial;
		font-size:14px;
		font-weight:400;
		height:360px;
		line-height:21px;
		pointer-events:auto;
		text-align:left;
		text-size-adjust:100%;
		vertical-align:middle;*/
		
	}
	#table-kop tr {
		/*border-collapse:collapse;
		box-sizing:border-box;
		display:table-row;
		font-family:Nunito, "Segoe UI", arial;
		font-size:14px;
		font-weight:400;
		height:60px;
		line-height:21px;
		pointer-events:auto;
		text-align:left;
		text-size-adjust:100%;
		vertical-align:middle;*/


	} 
	#table-kop th {
		width: 40%;
		display:table-cell;
		font-family:Nunito, "Segoe UI", arial;
		font-size:14px;
		font-weight:700;
		height:20px;
		line-height:21px;
		padding-bottom:0px;
		padding-left:25px;
		padding-top:0px;
		text-align:left;
		width:300px;
		


	}
	#table-kop td {
		display:table-cell;
		font-family:"Nunito", "Segoe UI", arial;
		font-size:14px;
		font-weight:400;
		height:30px;
		line-height:21px;
		padding-bottom:0px;
		padding-left:25px;
		padding-right:25px;
		padding-top:0px;
		pointer-events:auto;
		text-align:left;
		
		
	}

	#container {
		height:600px;
	}
</style>
@endsection
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Data Treemap</h1>
		<div class="section-header-breadcrumb">
			<div class="form-inline" >
				

			</div>
			
			<div class="breadcrumb-item active"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="accordion">
				<div class="accordion">
					<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
						<h4>Filter Data</h4>
					</div>
					<div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
						<div class="row">
							<div class="col-md-4">
								<div class="card ">
									<div class="card-body">
										<div class="form-group">
											<label>Status Jemaah</label>
											<select class="form-control select2" name="status">
												<option value="">Semua </option>
												@foreach (hStatusJemaah() as $k => $v)
												<option value="{{ $k }}">{{ $v }}</option>
												@endforeach

											</select>
										</div>

										<div class="form-group">
											<label>Daerah Terbanyak</label>
											<select class="form-control select2" name="top">
												<option value="">Semua </option>
												@foreach (hTopBesar() as $k => $v)
												<option value="{{ $k }}">{{ $v }}</option>
												@endforeach

											</select>
										</div>

										<div class="form-group">
											<label>Jenis Kelamin</label>
											<select class="form-control select2" name="jk">
												<option value="">Semua </option>
												@foreach (hJK() as $k => $v)
												<option value="{{ $k }}">{{ $v }}</option>
												@endforeach

											</select>
										</div>
										
									</div>


								</div>
							</div>
							<div class="col-md-4">
								<div class="card">
									<div class="card-body">
										<div class="form-group">
											<label>Usia</label>
											<select class="form-control select2" name="usia">
												<option value="">Semua </option>
												@foreach (hUsia() as $k => $v)
												<option value="{{ $k }}">{{ $v }}</option>
												@endforeach

											</select>
										</div>

										<div class="form-group">
											<label>Kota</label>
											<select class="form-control select2" name="kota" id="kota"  >
												<option value="">Semua</option>
												@foreach ($data['kota'] as $kota)
												<option value="{{ $kota->kota_id }}"
													@if ($kota->kota_nama == date('Y'))
													selected
													@endif

													>{{ $kota->kota_nama }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label>Tahun Haji</label>
												<select class="form-control select2" name="tahun" id="tahun"  >
													@foreach ($data['tahun'] as $tahun)
													<option value="{{ $tahun->haji_tahun }}"
														@if ($tahun->haji_tahun == date('Y'))
														selected
														@endif

														>{{ $tahun->haji_tahun }}</option>
														@endforeach
													</select>
												</div>

											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="card">
											<div class="card-header">
												<h4>Hirarki Data</h4>
											</div>
											<div class="card-body">
												<div id="example1" class="list-group col">
													<div class="list-group-item urutan" data-value="0"><i class="ion-arrow-move"></i> Data Kota</div>
													<div class="list-group-item urutan" data-value="1"><i class="ion-arrow-move"></i> Data Kloter</div>
													<div class="list-group-item urutan" data-value="2"><i class="ion-arrow-move"></i> Data Rombongan</div>
													<div class="list-group-item urutan" data-value="3"><i class="ion-arrow-move"></i> Data Regu</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div id="accordion-table">
						<div class="accordion">
							<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-2" aria-expanded="true">
								<h4>Table Jemaah Haji</h4>
							</div>
							<div class="accordion-body collapse show" id="panel-body-2" data-parent="#accordion-table">
								<div class="card">
									
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover table-striped" id="table-haji">
												<thead>                                 
													<tr>

														<th>No. Paspor</th>
														<th>Tahun</th>
														<th>Nama</th>
														<th>Usia</th>
														<th>Jenis Kelamin</th>
														<th>Status</th>
														<th>Regu</th>
														<th>Rombongan</th>
														<th>Kloter</th>
														<th>Kota</th>
														<th>Provinsi</th>
													</tr>
												</thead>
												<tbody>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


				</div>
				<div class="col-12">
					<div id="accordion-treemap">
						<div class="accordion">
							<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-3" aria-expanded="true">
								<h4>Treemap Jemaah Haji</h4>
							</div>
							<div class="accordion-body collapse show" id="panel-body-3" data-parent="#accordion-treemap">
								<div class="card">

									<div class="card-body">
										<div class="div-btn" style="background-color: red;">

											<div class="" style="float:right; margin-right: 12px;">

												<a style="" class="btn-md btn btn-outline-primary" id="btn-back" href="javascript:void(0);"><i class="fas fa-backward fa-5x"></i></a>


											</div>

										</div>
										<div class="clearfix"></div>


										<figure class="highcharts-figure">

											<div id="container"></div>

										</figure>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>

		</section>

		<!-- Modal -->
		<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog  modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Detail</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="content-peserta">

						</div>
					</div>
					<div class="modal-footer"></div>
				</div>
			</div>
		</div>

		@endsection
		@section('js-export')
		<script src="{{ base_url("assets/modules/datatables/datatables.min.js") }}"></script>

		<script src="{{ base_url("assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js") }}"></script>

		<script src="{{ base_url("assets/modules/datatables/DataTables-1.10.16/js/dataTables.fixedColumns.min.js") }}"></script>

		<script src="{{ base_url("assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js") }}"></script>

		<script src="{{ base_url("assets/modules/highcharts/highcharts.js") }}"></script>
		<script src="{{ base_url("assets/modules/highcharts/modules/data.js") }}"></script>
		<script src="{{ base_url("assets/modules/highcharts/modules/heatmap.js") }}"></script>
		<script src="{{ base_url("assets/modules/highcharts/modules/treemap.js") }}"></script>
		<script src="{{ base_url("assets/modules/highcharts/modules/offline-exporting.js") }}"></script>
		<script src="{{ base_url("assets/modules/highcharts/modules/accessibility.js") }}"></script>
		<script src="{{ base_url("assets/modules/highcharts/modules/boost.js") }}"></script>
		<script src="{{ base_url("assets/modules/select2/dist/js/select2.full.min.js") }}"></script>
		<script src="{{ base_url("assets/sortablejs-1.10.2/package/Sortable.min.js") }}"></script>

		@endsection
		@section('js-inline')
		<script>
			var example1 = null;

			var insHighchart = null;
			var points = null;
			var isitable = null;
			var previousLink = [];
			var idnya = null;
			var $tahun = null;
			var $usia = null;
			var $jk = null;
			var $top = null;
			var $kota = null;
			var $status = null;
			var $urutan = [];
			let $tableHaji = null;

			$(function() {
				$tahun = $("select[name=tahun]");
				$usia = $("select[name=usia]");
				$jk = $("select[name='jk']");
				$top = $("select[name=top]");
				$kota = $("select[name=kota]");
				$status = $("select[name=status]");
				$(example1).find('.urutan').each(function(i,e) {$urutan.push($(e).attr('data-value'))});

				$tableHaji = $('#table-haji').DataTable({ 
					"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
					"bAutoWidth": false ,
					scrollX:        true,
					scrollCollapse: true,
					"order": [], 
					"columns": [
					{ "data": "haji_nomor_paspor" },
					{ "data": "haji_tahun" },
					{ "data": "haji_nama" },
					{ "data": "haji_usia" },
					{ "data": "jenis_kelamin" },
					{ "data": "status_jemaah" },
					{ "data": "haji_regu_id" },
					{ "data": "haji_rombongan_id" },
					{ "data": "haji_kloter_id" },
					{ "data": "nama_kota" },
					{ "data": "nama_provinsi" },
					],

				});

				generateHighTreemap()
				.then(resp => {
					insHighchart = resp;
					insHighchart.showLoading();
					fetchData("").then(r =>
					{
						isitable = r.table;
						points = r.data;

						$tableHaji.clear();
						$tableHaji.rows.add(isitable);
						$tableHaji.draw();

						dataSet = points.filter(function($el) {
							return $el.parentt == "";
						});

						insHighchart.setTitle({text:'Data Jemaah Haji'});
						insHighchart.setSubtitle({text:r.subtitle});
						insHighchart.series[0].setData(dataSet);
						insHighchart.hideLoading();

					});

				});

				example1 = document.getElementById('example1');

				new Sortable(example1, {
					animation: 150,
					ghostClass: 'blue-background-class',

					onEnd: function (evt) {
						var itemEl = evt.item;  
						evt.to;    
						evt.from;  
						evt.oldIndex;  
						evt.newIndex;  
						evt.oldDraggableIndex;
						evt.newDraggableIndex;
						evt.clone 
						evt.pullMode;  

						previousLink = [];
						$urutan = [];
						$(example1).find('.urutan').each(function(i,e) {$urutan.push($(e).attr('data-value'))});


						updateData();

					},

				});


				$tahun.add($usia).add($jk).add($top).add($status).add($kota).change(function(event) {
					previousLink = [];

					updateData();


				});
				$("#btn-back").click(function(event) {
					if (previousLink.length <= 0) {
						return;
					}
					idnya = previousLink.pop();
					var dataSet = points.filter(function(ee) {
						return ee.parentt == idnya;
					});

					insHighchart.series[0].update({data:dataSet});
					insHighchart.hideLoading();
					if (dataSet.length > 0 ) {


					}
				});	







			});

			function updateData() {
				var tahun = $tahun.val();
				var usia =  $usia.val();
				var jk =  $jk.val();
				var top =  $top.val();
				var status =  $status.val();
				var kota =  $kota.val();
				var urutan =  $urutan;


				post = {
					tahun,
					usia,
					jk,
					top,
					status,
					kota,
					urutan
				};

				post = Object.keys(post).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post[key])).join('&')

				insHighchart.showLoading();
				fetchData(post).then(r =>
				{
					points = r.data;
					isitable = r.table;
					$tableHaji.clear();
					$tableHaji.rows.add(isitable);
					$tableHaji.draw();
					dataSet = points.filter(function($el) {
						return $el.parentt == "";
					});
					insHighchart.setSubtitle({text:r.subtitle});
					insHighchart.series[0].setData(dataSet);
					insHighchart.hideLoading();

				}
				);
			}

			function generateHighTreemap() {

				return new Promise((resolve, reject) => {
					var options = {
						series: [{
							type: 'treemap',
							alternateStartingDirection: false,
							layoutAlgorithm: 'squarified',
							allowDrillToNode: true,
							animation:true,
							dataLabels: {
								enabled: true,
								style: {
									fontSize: "14px",
							// textOutline: 0,


						}
					},
					hover: {
						color:'red'
					},
					borderWidth: 3,
					borderColor: "white",

					data:[],
					point: {
						
						events: {
							click: function(e) {
								id = this.id;
								parentt = this.parentt;
								var dataSet = points.filter(function(ee) {
									return ee.parentt == this.id;
								});

								if (dataSet.length > 0 ) {
									previousLink.push(this.parentt);

									insHighchart.series[0].update({data:dataSet});
									insHighchart.hideLoading();

								}

								if (this.status == 4) {
									$("#content-peserta").html(this.description);
									$("#modalDetail").modal('show');
								}


							},
							// mouseOver: function() {
							// 	originalColor = this.color;
							// 	originalBorderColor = this.borderColor;

							// 	this.update({
							// 		color: 'white',
							// 		borderColor: 'black',
							// 	});
							// },
							// mouseOut: function() {
							// 	this.update({
							// 		color: originalColor,
							// 		borderColor: originalBorderColor
							// 	});
							// }
						}
					},

				}],

				plotOptions: {
					treemap: {
						states: {
							hover: {
								borderColor: "#6c757d",
								borderWidth: 2,

								
								// lineWidthPlus: 10
							}
						}
					}
				},
				tooltip: {
					style: {
						fontSize: "16px",
						'z-index': '9999',
					},
					useHTML: true,
					borderRadius: 1,
					hideDelay:"0",
					backgroundColor: "#FFFFFF",

					borderColor: '#AAA',
					formatter: function () {
						if (this.point.status == 4) {
							return "Click For Detail";
						} else
						return this.point.description+' ';

					}
				},

				title: {
					text: ''
				},


			};
			const chart = Highcharts.chart('container', options);
			resolve(chart);
		});

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
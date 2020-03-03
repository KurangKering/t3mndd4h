@extends('layouts.layout')
@section('css-export')
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/datatables.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/prism/prism.css") }}">

@endsection
@section('css-inline')
<style>
	.DTFC_LeftFootWrapper {
		display:none;
	}
</style>
@endsection
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Data Haji</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="javascript:void(0)" class="btn btn-primary" id="btn-tambah">Tambah Data Haji</a>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-striped" id="table-haji">
							<thead>                                 
								<tr>
									<th class="text-center">
										ID
									</th>
									<th>No. Paspor</th>
									<th>Tahun</th>
									<th>Nama</th>
									<th>Usia</th>
									<th>Jenis Kelamin</th>
									<th>Status</th>
									<th>Regu</th>
									<th>Rombongan</th>
									<th>Kloter</th>
									<th>Kota/Kabupaten</th>
									<th>Provinsi</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>

							<tfoot>                                 
								<tr>
									<th>ID</th>
									<th>Nomor Porsi</th>
									<th>Tahun</th>
									<th>Nama</th>
									<th>Usia</th>
									<th>Jenis Kelamin</th>
									<th>Status</th>
									<th>Regu</th>
									<th>Rombongan</th>
									<th>Kloter</th>
									<th>Kota/Kabupaten</th>
									<th>Provinsi</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>



</section>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-haji">Tambah Data Haji</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form>
						<input type="hidden" id="id" value="">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="message-text" class="col-form-label">Nama Peserta:</label>
									<input type="text"  id="nama" class="form-control">
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Nomor Porsi:</label>
									<input type="text"  id="paspor" class="form-control">
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Tahun Haji:</label>
									<input type="number"  id="tahun" class="form-control">
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Usia:</label>
									<input type="number"  id="usia" class="form-control">
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Jenis Kelamin :</label>
									<select  id="jk" class="form-control">
										@foreach (hJK() as $k => $v)
										<option value="{{ $k }}">{{ $v }}</option>
										@endforeach
									</select>

									<div class="error"></div>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="message-text" class="col-form-label">Status:</label>
									<select  id="status" class="form-control">
										@foreach (hStatusJemaah() as $k => $v)
										<option value="{{ $k }}">{{ $v }}</option>
										@endforeach
									</select>
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Regu:</label>
									<select  id="regu" class="form-control">
										@foreach (hRegu() as $k => $v)
										<option value="{{ $k }}">{{ $v }}</option>
										@endforeach
									</select>
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Rombongan:</label>
									<select  id="rombongan" class="form-control">
										@foreach (hRombongan() as $k => $v)
										<option value="{{ $k }}">{{ $v }}</option>
										@endforeach
									</select>
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Kloter:</label>
									<select  id="kloter" class="form-control">
										@foreach (hKloter() as $k => $v)
										<option value="{{ $k }}">{{ $v }}</option>
										@endforeach
									</select>
									<div class="error"></div>

								</div>
								<div class="form-group">
									<label for="message-text" class="col-form-label">Kota/Kabupaten:</label>
									<select  id="kota" class="form-control">
										@foreach ($data['kota'] as $kota)
										<option value="{{ $kota->kota_id }}">{{ $kota->kota_nama }}</option>
										@endforeach
									</select>
									<div class="error"></div>

								</div>
							</div>
						</div>

						
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btn-submit" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

@endsection
@section('js-export')
<script src="{{ base_url("assets/modules/datatables/datatables.min.js") }}"></script>
<script src="{{ base_url("assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ base_url("assets/modules/datatables/DataTables-1.10.16/js/dataTables.fixedColumns.min.js") }}"></script>

<script src="{{ base_url("assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js") }}"></script>
<script src="{{ base_url("assets/modules/jquery-ui/jquery-ui.min.js") }}"></script>

<script src="{{ base_url("assets/modules/prism/prism.js") }}"></script>
<script src="{{ base_url("assets/js/page/bootstrap-modal.js") }}"></script>

@endsection
@section('js-inline')
<script src="{{ base_url('assets/js/page/modules-datatables.js') }}"></script>
<script>
	let $tableHaji = null;
	let $modalDetail = null;
	let $btnTambah = null;
	let $btnSubmit = null;
	let $nama = null;
	let $paspor = null;
	let $tahun = null;
	let $usia = null;
	let $jk = null;
	let $status = null;
	let $regu = null;
	let $rombongan = null;
	let $kloter = null;
	let $kota = null;
	let $id = null;


	let filterTahun = JSON.parse("{{ $data['filterTahun'] }}");
	let filterJK = JSON.parse("{{ $data['filterJK'] }}".replace(/&quot;/g, '"'))	
	let filterStatus = JSON.parse("{{ $data['filterStatus'] }}".replace(/&quot;/g, '"'))	
	let filterRegu = JSON.parse("{{ $data['filterRegu'] }}".replace(/&quot;/g, '"'))	
	let filterRombongan = JSON.parse("{{ $data['filterRombongan'] }}".replace(/&quot;/g, '"'))	
	let filterKloter = JSON.parse("{{ $data['filterKloter'] }}".replace(/&quot;/g, '"'))	
	let filterKota = JSON.parse("{{ $data['filterKota'] }}".replace(/&quot;/g, '"'))	
	let filterProvinsi = JSON.parse("{{ $data['filterProvinsi'] }}".replace(/&quot;/g, '"'))	
	$(function() {
		$modalDetail = $("#modalDetail");
		$btnTambah = $("#btn-tambah");
		$btnSubmit = $("#btn-submit");
		$nama = $("#nama");
		$paspor = $("#paspor");
		$tahun = $("#tahun");
		$usia = $("#usia");
		$jk = $("#jk");
		$status = $("#status");
		$regu = $("#regu");
		$rombongan = $("#rombongan");
		$kloter = $("#kloter");
		$kota = $("#kota");
		$id = $("#id");
		$('#table-haji tfoot th').each( function ($index) {

			var title = $(this).text();
			
			var select = $('<select><option value="">Semua '+title+'</option></select>')

			if ($index == 2) {

				for (var i = 0; i < filterTahun.length; i++) {
					select.append( '<option value="'+filterTahun[i]+'">'+filterTahun[i]+'</option>' )	
				}

			}
			else if ($index == 5) {

				var value = Object.keys(filterJK);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterJK[value[i]]+'</option>' )	
				}

			}

			else if ($index == 6) {
				var value = Object.keys(filterStatus);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterStatus[value[i]]+'</option>' )	
				}

			}
			else if ($index == 7) {
				var value = Object.keys(filterRegu);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterRegu[value[i]]+'</option>' )	
				}

			}

			else if ($index == 8) {
				var value = Object.keys(filterRombongan);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterRombongan[value[i]]+'</option>' )	
				}

			}
			else if ($index == 9) {
				var value = Object.keys(filterKloter);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterKloter[value[i]]+'</option>' )	
				}

			}
			else if ($index == 10) {

				var value = Object.keys(filterKota);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterKota[value[i]]+'</option>' )	
				}

			}
			else if ($index == 11) {

				var value = Object.keys(filterProvinsi);

				for (var i = 0; i < value.length; i++) {
					select.append( '<option value="'+value[i]+'">'+filterProvinsi[value[i]]+'</option>' )	
				}
			} else if ($index == 12) {
				return;
			} 
			else {
				$(this).html( '<input type="text" placeholder="Cari '+title+'" />' );
				return;
			}
			$(this).html( select );


		} );

		$tableHaji = $('#table-haji').DataTable({ 
			"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			scrollX:        true,
			scrollCollapse: true,
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-haji/jsonDataHaji'); ?>',
				"type": "POST",


			},
			"columns": [
			{"data": "haji_id", "name": "haji_id",},
			{"data": "haji_nomor_porsi", "name": "haji_nomor_porsi"},
			{"data": "haji_tahun", "name": "haji_tahun"},
			{"data": "haji_nama", "name": "haji_nama"},
			{"data": "haji_usia", "name": "haji_usia"},
			{"data": "haji_jk", "name": "haji_jk"},
			{"data": "haji_status_jemaah","name":"haji_status_jemaah"},
			{"data": "haji_regu_id","name": "haji_regu_id"},
			{"data": "haji_rombongan_id", "name": "haji_rombongan_id"},
			{"data": "haji_kloter_id", "name": "haji_kloter_id"},
			{"data": "kota_nama", "name":"kota_id"},
			{"data": "provinsi_nama", "name": "provinsi_id"},
			{"data": "action", "searchable": false},
			],
			'columnDefs': [

			{
				"targets": -1,
				"className": "action-no-wrap",
			},

			],



		});

		$tableHaji.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change clear', function () {
				if ( that.search() !== this.value ) {
					that
					.search( this.value )
					.draw();
				}
			} );

			$( 'select', this.footer() ).on( 'change', function () {
				if ( that.search() !== this.value ) {
					that
					.search( this.value )
					.draw();
				}
			} );

			
		} );





		new $.fn.dataTable.FixedColumns( $tableHaji , {
            rightColumns: 1 //specifies how many left columns should be fixed.
        });



  $btnTambah.click(function() {
  	clearData();
  	clearError();
  	$("#modal-title-haji").text("Tambah Data Haji");
  	$modalDetail.modal("show");
  })

  $btnSubmit.click(function(e) {
  	$(this).attr('disabled', true);
  	formData = {
  		nama: $nama.val(),
  		paspor: $paspor.val(),
  		tahun: $tahun.val(),
  		usia: $usia.val(),
  		jk: $jk.val(),
  		status: $status.val(),
  		regu: $regu.val(),
  		rombongan: $rombongan.val(),
  		kloter: $kloter.val(),
  		kota: $kota.val(),
  		id: $id.val(),
  	};
  	data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
  	var url = "";
  	if (formData.id) {
  		url = '{{ base_url('data-haji/update') }}';
  	} else {
  		url = '{{ base_url('data-haji/store') }}'
  	}
  	axios.post(url, data)
  	.then(res => {
  		data = res.data;
  		clearError();
  		console.log(data);
  		if (data.success == 0) {
  			$.each(data.messages, function(key, value) {

  				$('#'+key).addClass('is-invalid');
  				$('#'+key).parent('.form-group').find('.error').html(value);
  			});
  			$btnSubmit.attr('disabled', false);

  		} else if (data.success == 1){
  			toggleModal($modalDetail, false).done(function() {
  				$tableHaji.ajax.reload();
  				$btnSubmit.attr('disabled', false);
  			});



  		}



  	})
  	.catch(err => {
  		$(this).attr('disabled', false);

  	});
  });

});


function showModal(id,opsi) {
	if (opsi == 1) {
		showEdit(id);
	} else if(opsi == 2) {
		showDelete(id);
	}
}

function showEdit(id) {
	let formData = {
		id: id,
	};
	clearError();
	clearData();
	data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
	axios.post("{{ base_url("data-haji/getDataHaji") }}", data)
	.then((res) => {

		data = res.data;

		$nama.val(data.haji_nama);
		$paspor.val(data.haji_nomor_porsi);
		$tahun.val(data.haji_tahun);
		$usia.val(data.haji_usia);
		$jk.val(data.haji_jk);
		$status.val(data.haji_status_jemaah);
		$regu.val(data.haji_regu_id);
		$rombongan.val(data.haji_rombongan_id);
		$kloter.val(data.haji_kloter_id);
		$kota.val(data.haji_kota_id);

		$id.val(data.haji_id);
		$("#modal-title-haji").text("Ubah Data Haji");

		$modalDetail.modal("show");
	})
}

function showDelete(id) {
	Swal.fire({
		title: 'Delete Data',
		text: "Yakin akan menghapus data ini ?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Hapus!'
	}).then((result) => {
		if (result.value) {
			let formData = {
				id: id,
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			axios.post("{{ base_url("data-haji/delete") }}", data)
			.then((res) => {
				Swal.fire({
					title: 'Deleted!',
					text: 'Your file has been deleted.',
					icon: 'success',
					timer: 500,
					showConfirmButton: false,

				})
				.then(() => {
					$tableHaji.ajax.reload();
				})
			});


		}
	});
}




function clearData() {
	$id.val("");

	$nama.val("");
	$paspor.val("");
	$tahun.val("");
	$usia.val("");
	$jk.prop("selectedIndex",0);
	$status.prop("selectedIndex",0);
	$regu.prop("selectedIndex",0);
	$rombongan.prop("selectedIndex",0);
	$kloter.prop("selectedIndex",0);
	$kota.prop("selectedIndex",0);
	$id.val("");

}
function clearError() {
	$(".error").html("");
	$(".is-invalid").removeClass('is-invalid');
}

</script>
@endsection
@extends('layouts.layout')
@section('css-export')
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/datatables.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/prism/prism.css") }}">


@endsection
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Data Master</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"></div>
		</div>
	</div>

	<div class="row">
		

		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<a href="javascript:void(0)" class="btn btn-primary" id="btn-tambah-regu">Tambah Data Regu</a>

				</div>
				
				<div class="card-body">
					<table class="table table-hover table-striped" id="table-regu">
						<thead>                                 
							<tr>
								<th class="text-center">
									ID
								</th>
								<th>Regu</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4></h4>
					<div class="card-header-action">
						<a href="javascript:void(0)" class="btn btn-primary" id="btn-tambah-rombongan">Tambah Data Rombongan</a>
					</div>

					
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped" id="table-rombongan">
						<thead>                                 
							<tr>
								<th class="text-center">
									ID
								</th>
								<th>Rombongan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>



</section>
<div class="modal fade" id="modalDetailRegu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-regu">Tambah Regu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form onsubmit="return false">
						<input type="hidden" id="id-regu" value="">
						

						

						<div class="form-group">
							<label for="message-text" class="col-form-label">Regu:</label>
							<input type="number"  id="input-regu" class="form-control"></input>
							<div class="error"></div>

						</div>

						
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btn-submit-regu" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalDetailRombongan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-rombongan">Tambah Rombongan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form onsubmit="return false">
						<input type="hidden" id="id-rombongan" value="">
						
						
						

						<div class="form-group">
							<label for="message-text" class="col-form-label">Rombongan:</label>
							<input type="number"  id="input-rombongan" class="form-control"></input>
							<div class="error"></div>

						</div>

						
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btn-submit-rombongan" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

@endsection
@section('js-export')
<script src="{{ base_url("assets/modules/datatables/datatables.min.js") }}"></script>
<script src="{{ base_url("assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ base_url("assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js") }}"></script>
<script src="{{ base_url("assets/modules/jquery-ui/jquery-ui.min.js") }}"></script>

<script src="{{ base_url("assets/modules/prism/prism.js") }}"></script>
<script src="{{ base_url("assets/js/page/bootstrap-modal.js") }}"></script>

@endsection
@section('js-inline')
<script src="{{ base_url('assets/js/page/modules-datatables.js') }}"></script>
<script>
	let $tableRegu = null;
	let $modalDetailRegu = null;
	let $btnTambahRegu = null;
	let $btnSubmitRegu = null;
	let $ikRombongan = null;
	let $ikRegu = null;
	let $idRegu = null;

	let $tableRombongan = null;
	let $modalDetailRombongan = null;
	let $btnTambahRombongan = null;
	let $btnSubmitRombongan = null;
	let $iRombongan = null;
	let $idRombongan = null;

	$(function() {
		$modalDetailRegu = $("#modalDetailRegu");
		$btnTambahRegu = $("#btn-tambah-regu");
		$btnSubmitRegu = $("#btn-submit-regu");
		$ikRegu = $("#input-regu");
		$ikRombongan = $("#input-regu-rombongan");
		$idRegu = $("#id-regu");

		$modalDetailRombongan = $("#modalDetailRombongan");
		$btnTambahRombongan = $("#btn-tambah-rombongan");
		$btnSubmitRombongan = $("#btn-submit-rombongan");
		$iRombongan = $("#input-rombongan");
		$idRombongan = $("#id-rombongan");

		$tableRegu = $('#table-regu').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"pageLength": 5,
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-regu/jsonDataRegu'); ?>',
				"type": "POST",


			},
			"columns": [
			{"data": "regu_id"},
			{"data": "regu_nama"},
			{"data": "action"},
			],
			'columnDefs': [
			{
				"targets": 0,
				"orderable" : false,
			},
			{
				"targets": 2,
				"className": "text-center",
				"searchable" : false,
				"orderable" : false,
				"className" : 'action-no-wrap',

			}],
			


		});

		$tableRombongan = $('#table-rombongan').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"pageLength": 5,
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('data-rombongan/jsonDataRombongan'); ?>',
				"type": "POST",


			},
			"columns": [
			{"data": "rombongan_id"},
			{"data": "rombongan_nama"},
			{"data": "action"},
			],
			'columnDefs': [
			{
				"targets": 0,
				"orderable" : false,
			},
			{
				"targets": 2,
				"className": "text-center",
				"searchable" : false,
				"orderable" : false,
				"className": "action-no-wrap",


			}],
			


		});


		$btnTambahRegu.click(function() {
			clearData();
			clearError();
			$("#modal-title-regu").text("Tambah Regu");
			$modalDetailRegu.modal("show");
		})

		$btnSubmitRegu.click(function(e) {
			$(this).attr('disabled', true);

			formData = {
				regu: $ikRegu.val(),
				id: $idRegu.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-regu/update') }}';
			} else {
				url = '{{ base_url('data-regu/store') }}'
			}
			axios.post(url, data)
			.then(res => {
				data = res.data;
				clearError();
				console.log(data);
				if (data.success == 0) {
					$btnSubmitRegu.attr('disabled', false);

					$.each(data.messages, function(key, value) {

						$('#'+key).addClass('is-invalid');
						$('#'+key).parent('.form-group').find('.error').html(value);
					});
				} else if (data.success == 1){
					toggleModal($modalDetailRegu, false).done(function() {
						$tableRegu.ajax.reload();
						$btnSubmitRegu.attr('disabled', false);
					});
					


				}



			})
			.catch(err => {
				$(this).attr('disabled', true);

			});
		});


		$btnTambahRombongan.click(function() {
			clearDataRombongan();
			clearErrorRombongan();
			$("#modal-title-rombongan").text("Tambah Rombongan");
			$modalDetailRombongan.modal("show");
		})

		$btnSubmitRombongan.click(function(e) {
			$(this).attr('disabled', true);

			formData = {
				rombongan: $iRombongan.val(),
				id: $idRombongan.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-rombongan/update') }}';
			} else {
				url = '{{ base_url('data-rombongan/store') }}'
			}
			axios.post(url, data)
			.then(res => {
				data = res.data;
				clearErrorRombongan();
				// console.log(data);
				if (data.success == 0) {
					$.each(data.messages, function(key, value) {

						$('#'+key).addClass('is-invalid');
						$('#'+key).parent('.form-group').find('.error').html(value);
					});
					$(this).attr('disabled', false);

				} else if (data.success == 1){
				
					toggleModal($modalDetailRombongan, false).done(function() {
						$tableRombongan.ajax.reload();
						$btnSubmitRombongan.attr('disabled', false);
					})
					// $modalDetailRombongan.modal('hide');


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
	axios.post("{{ base_url("data-regu/getDataRegu") }}", data)
	.then((res) => {

		data = res.data;
		$ikRegu.val(data.regu_nama);
		$idRegu.val(data.regu_id);
		$("#modal-title-regu").text("Ubah Data Regu");

		$modalDetailRegu.modal("show");
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
			axios.post("{{ base_url("data-regu/delete") }}", data)
			.then((res) => {
				Swal.fire({
					title: 'Deleted!',
					text: 'Your file has been deleted.',
					icon: 'success',
					timer: 500,
					showConfirmButton: false,

				})
				.then(() => {
					$tableRegu.ajax.reload();
				})
			})
			.catch((error) => {
				Swal.fire({
					title: 'Gagal!',
					text: 'Tidak dapat menghapus data ini !!!.',
					icon: 'error',
					timer: 1500	,
					showConfirmButton: false,

				})
			});


		}
	})
	;
}




function clearData() {
	$idRegu.val("");
	$ikRombongan.prop('selectedIndex',0);
	$ikRegu.val("");

}
function clearError() {
	$(".error").html("");
	$(".is-invalid").removeClass('is-invalid');
}

function showModalRombongan(id,opsi) {
	if (opsi == 1) {
		showEditRombongan(id);
	} else if(opsi == 2) {
		showDeleteRombongan(id);
	}
}

function showEditRombongan(id) {
	let formData = {
		id: id,
	};
	clearErrorRombongan();
	clearDataRombongan();
	data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
	axios.post("{{ base_url("data-rombongan/getDataRombongan") }}", data)
	.then((res) => {

		data = res.data;
		$iRombongan.val(data.rombongan_nama);
		$idRombongan.val(data.rombongan_id);
		$("#modal-title-rombongan").text("Ubah Data Rombongan");

		$modalDetailRombongan.modal("show");
	})
}

function showDeleteRombongan(id) {
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
			axios.post("{{ base_url("data-rombongan/delete") }}", data)
			.then((res) => {
				data = res.data;
				Swal.fire({
					title: 'Deleted!',
					text: 'Your file has been deleted.',
					icon: 'success',
					timer: 500,
					showConfirmButton: false,

				})
				.then(() => {
					$ikRombongan.html("");
					var opsiRombongan = "";
					$.each(data.rombongan, function(index, val) {
						opsiRombongan += "<option value=\""+val.rombongan_id+"\">"+val.rombongan_nama+"</option>";
					});
					$ikRombongan.append(opsiRombongan);
					$tableRombongan.ajax.reload();
				})

			})
			.catch((error) => {
				Swal.fire({
					title: 'Gagal!',
					text: 'Tidak dapat menghapus data ini !!!.',
					icon: 'error',
					timer: 1500	,
					showConfirmButton: false,

				})
			});


		}
	});
}




function clearDataRombongan() {
	$idRombongan.val("");
	$iRombongan.val("");

}
function clearErrorRombongan() {
	$(".error").html("");
	$(".is-invalid").removeClass('is-invalid');
}


</script>
@endsection
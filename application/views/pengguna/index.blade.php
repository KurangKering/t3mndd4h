@extends('layouts.layout')
@section('css-export')
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/datatables.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ base_url("assets/modules/prism/prism.css") }}">


@endsection
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Data Pengguna</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"></div>
		</div>
	</div>

	<div class="row">
		

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<a href="javascript:void(0)" class="btn btn-primary" id="btn-tambah-kota">Tambah Data Pengguna</a>

				</div>
				
				<div class="card-body">
					<table class="table table-hover table-striped" id="table-pengguna">
						<thead>                                 
							<tr>
								<th class="text-center">
									ID
								</th>
								<th>Nama</th>
								<th>Username</th>
								<th>Hak Akses</th>
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
<div class="modal fade" id="modalPengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-pengguna">Tambah Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="modal-content">
					<form onsubmit="return false">
						<input type="hidden" id="id-pengguna" value="">
						
						<div class="form-group">
							<label for="message-text" class="col-form-label">Provinsi:</label>
							<select id="input-provinsi" class="form-control"

							>
							@foreach ($data['data_provinsi'] as $provinsi)
							<option value="{{ $provinsi->provinsi_id }}"

								@if ($data['auth']['role_id'] == $provinsi->provinsi_id)
								selected
								@endif
								>{{ $provinsi->provinsi_nama }}</option>
								@endforeach
							</select>
							<div class="error"></div>

						</div>

						<div class="form-group">
							<label for="message-text" class="col-form-label">Kota:</label>
							<select id="input-kota" class="form-control" 
							@if ($data['auth']['role'] == 'prov')
							required
							@endif
							>
							<option value=""></option>
							@foreach ($data['data_kota'] as $kota)
							<option data-chained="{{ $kota->kota_provinsi_id }}" value="{{ $kota->kota_id }}">{{ $kota->kota_nama }}</option>
							@endforeach
						</select>
						<div class="error"></div>

					</div>


					<div class="form-group">
						<label for="message-text" class="col-form-label">Nama:</label>
						<input type="text"  id="input-nama" class="form-control"></input>
						<div class="error"></div>

					</div>
					<div class="form-group">
						<label for="message-text" class="col-form-label">Username:</label>
						<input type="text"  id="input-username" class="form-control"></input>
						<div class="error"></div>

					</div>

					<div class="form-group">
						<label for="message-text" class="col-form-label">Password:</label>
						<input type="password"  id="input-password" class="form-control"></input>
						<div class="error"></div>

					</div>


				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" id="btn-submit-kota" class="btn btn-primary">Save changes</button>
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
<script src="{{ base_url('assets/jquery_chained-2.x/jquery.chained.min.js') }}"></script>

@endsection
@section('js-inline')
<script src="{{ base_url('assets/js/page/modules-datatables.js') }}"></script>
<script>
	let $tablePengguna = null;
	let $modalPengguna = null;
	let $btnTambahPengguna = null;
	let $btnSubmitPengguna = null;
	let $iNama = null;
	let $iUsername = null;
	let $iPassword = null;
	let $iProvinsi = null;
	let $iKota = null;
	let $idPengguna = null;



	$(function() {

		$("#input-kota").chained("#input-provinsi");

		$modalPengguna = $("#modalPengguna");
		$btnTambahPengguna = $("#btn-tambah-kota");
		$btnSubmitPengguna = $("#btn-submit-kota");
		$ikKota = $("#input-kota");
		$iNama = $("#input-nama");
		$iUsername = $("#input-username");
		$iPassword = $("#input-password");
		$iProvinsi = $("#input-provinsi");
		$iKota = $("#input-kota");
		$idPengguna = $("#id-pengguna");

		

		$tablePengguna = $('#table-pengguna').DataTable({ 
			"bAutoWidth": false ,
			"processing": true, 
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": '<?php echo base_url('pengguna/jsonDataPengguna'); ?>',
				"type": "POST",


			},
			"columns": [
			{"data": "pengguna_id"},
			{"data": "pengguna_nama"},
			{"data": "pengguna_username"},
			{"data": "pengguna_akses"},
			{"data": "action"},
			],
			'columnDefs': [
			{
				"targets": 0,
				"orderable" : false,
			},
			{
				"targets": 4,
				"className": "text-center",
				"searchable" : false,
				"orderable" : false,
				"className" : 'action-no-wrap',

			}],



		});



		$btnTambahPengguna.click(function() {
			clearData();
			clearError();
			$("#modal-title-pengguna").text("Tambah Pengguna");
			$modalPengguna.modal("show");
		})

		$btnSubmitPengguna.click(function(e) {
			$(this).attr('disabled', true);

			formData = {
				nama: $iNama.val(),
				username: $iUsername.val(),
				password: $iPassword.val(),
				provinsi: $iProvinsi.val(),
				kota: $iKota.val(),
				id: $idPengguna.val(),
			};
			data = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&')
			var url = "";
			if (formData.id) {
				url = '{{ base_url('data-pengguna/update') }}';
			} else {
				url = '{{ base_url('data-pengguna/store') }}'
			}
			axios.post(url, data)
			.then(res => {
				data = res.data;
				clearError();
				console.log(data);
				if (data.success == 0) {
					$btnSubmitPengguna.attr('disabled', false);

					$.each(data.messages, function(key, value) {

						$('#'+key).addClass('is-invalid');
						$('#'+key).parent('.form-group').find('.error').html(value);
					});
				} else if (data.success == 1){
					toggleModal($modalPengguna, false).done(function() {
						$tablePengguna.ajax.reload();
						$btnSubmitPengguna.attr('disabled', false);
					});



				}



			})
			.catch(err => {
				$(this).attr('disabled', true);

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
		axios.post("{{ base_url("data-pengguna/getDataPengguna") }}", data)
		.then((res) => {

			data = res.data;
			console.log(data);
			$iNama.val(data.pengguna_nama);
			$iUsername.val(data.pengguna_username);
			$iPassword.val("");

			if (data.kota_id) {

				$iKota.val(data.kota_id);
			}
			if (data.provinsi_id) {
				$iProvinsi.val(data.provinsi_id);
			}


			$idPengguna.val(data.pengguna_id);
			$("#modal-title-pengguna").text("Ubah Data Pengguna");

			$modalPengguna.modal("show");
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
				axios.post("{{ base_url("data-pengguna/delete") }}", data)
				.then((res) => {
					Swal.fire({
						title: 'Deleted!',
						text: 'Your file has been deleted.',
						icon: 'success',
						timer: 500,
						showConfirmButton: false,

					})
					.then(() => {
						$tablePengguna.ajax.reload();
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
		$idPengguna.val("");
		$iNama.val("");
		$iUsername.val("");
		$iPassword.val("");
		$iProvinsi.prop('selectedIndex',0);
		$iKota.prop('selectedIndex',0);
	}
	function clearError() {
		$(".error").html("");
		$(".is-invalid").removeClass('is-invalid');
	}

	
	
	

</script>
@endsection
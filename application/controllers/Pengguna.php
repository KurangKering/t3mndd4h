<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		if ($this->auth['role'] != "prov") {
			show_404();
		}
	}

	public function index()
	{
		$auth = $this->auth;

		$data['data_provinsi'] = $this->M_Provinsi;
		$data['data_kota'] = $this->M_Kota;

		if ($auth['role'] == 'prov') {
			$data['data_provinsi'] = $data['data_provinsi']->where('provinsi_id',$auth['role_id']);

			$data['data_kota'] = $data['data_kota']->where('kota_provinsi_id',$auth['role_id']);

		}
		$data['data_provinsi']  = $data['data_provinsi']->get();
		$data['data_kota'] = $data['data_kota']->get();
		$data['auth'] = $auth;
		return view('pengguna.index', compact('data'));
	}

	public function getDataPengguna()
	{
		$id = $this->input->post('id');
		$pengguna = $this->M_Pengguna->findOrFail($id);

		if ($pengguna) {
			$akses_with_id = explode('_',$pengguna->pengguna_akses);
			$akses = isset($akses_with_id[0]) ? $akses_with_id[0] : null;
			$id = isset($akses_with_id[1]) ? $akses_with_id[1] : null;


			$tmp = null;
			if ($akses == 'kota') {
				$pengguna->kota_id = $id;
			} else if ($akses == 'prov') {
				$pengguna->provinsi_id = $id;
			}
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($pengguna));
	}

	public function delete()
	{
		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();


		$id = $this->input->post('id');
		$data = $this->M_Pengguna->findOrFail($id);
		$deleteData = $data->delete();


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}
	public function update()
	{
		$this->load->library('form_validation');
		$post = $this->input->post();

		$auth = $this->auth;
		$this->form_validation->set_rules('nama', 'Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required');
		$this->form_validation->set_rules('kota', 'Kota', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'input-nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'input-username' => form_error('username', '<p class="mt-3 text-danger">', '</p>'),
				'input-provinsi' => form_error('provinsi', '<p class="mt-3 text-danger">', '</p>'),
				'input-kota' => form_error('kota', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'pengguna_nama' => $post['nama'],
				'pengguna_username' => $post['username'],
				
			);

			if ($post['password']) {
				$postData['pengguna_password'] = md5($post['password']);
			}

			if ($auth['role'] == "prov") {
				$postData['pengguna_akses'] = "kota_".$post['kota'];
				$postData['parent_id'] = $auth['user_id'];
			}

			$data = $this->M_Pengguna->findOrFail($post['id']);
			$dataUpdate = $data->update($postData);
		}


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}

	public function store()
	{
		$auth = $this->auth;
		$this->load->library('form_validation');
		$post = $this->input->post();
		$this->form_validation->set_rules('nama', 'Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[pengguna.pengguna_username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required');
		$this->form_validation->set_rules('kota', 'Kota', 'trim|required');
		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'input-nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'input-username' => form_error('username', '<p class="mt-3 text-danger">', '</p>'),
				'input-password' => form_error('password', '<p class="mt-3 text-danger">', '</p>'),
				'input-provinsi' => form_error('provinsi', '<p class="mt-3 text-danger">', '</p>'),
				'input-kota' => form_error('kota', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			
			$postData = array(
				'pengguna_nama' => $post['nama'],
				'pengguna_username' => $post['username'],
				'pengguna_password' => $post['password'],
			);

			if ($auth['role'] == "prov") {
				$postData['pengguna_akses'] = "kota_".$post['kota'];
				$postData['parent_id'] = $auth['user_id'];
			}

			$insertData = $this->M_Pengguna->insert($postData);
		}


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}


	public function jsonDataPengguna()
	{
		$auth_session = $this->session->userdata('auth');

		$parent = $auth_session['user_id'];
		
		$this->dt->select('
			p.pengguna_id,
			p.pengguna_nama,
			p.pengguna_username,
			p.pengguna_akses
			');
		$this->dt->from('pengguna p');
		$this->dt->where('parent_id', $parent);
		$this->dt->add_column('nomor', '');
		$this->dt->add_column('action',
			'<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModal($1,1)">Ubah</a>
			<a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModal($1,2)">Hapus</a>'
			, 'pengguna_id'
		);

		function callback_akses($akses) 
		{
			return hAkses($akses);
			
		}
		$this->dt->edit_column('pengguna_akses', '$1', "callback_akses(pengguna_akses)");
		echo $this->dt->generate();
		die();
	}
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		
	}


	public function login_page()
	{
		return view('login');
	}

	public function login()
	{
		
		$this->load->model('M_Pengguna');
		$data = $this->input->post();
		$post_data = array(
			'pengguna_username' => $data['username'],
			'pengguna_password' => md5($data['password']),
		);

		
		$pengguna = $this->M_Pengguna->where($post_data)->first();
		$response = array (
			'message' => '',
			'success' => 0,
		);
		if (!$pengguna) {
			$response['message'] = 'Username / Password Salah';
		} else {
			$akses_with_id = explode('_',$pengguna->pengguna_akses);
			$akses = isset($akses_with_id[0]) ? $akses_with_id[0] : null;
			$id = isset($akses_with_id[1]) ? $akses_with_id[1] : null;


			$tmp = null;
			if ($akses == 'kota') {
				$tmp = $this->M_Kota->findOrFail($id);
				$tmp = $tmp->kota_nama;
				$tmp = $tmp;
			} else if ($akses == 'prov') {
				$tmp = $this->M_Provinsi->findOrFail($id);
				$tmp = $tmp->provinsi_nama;
				$tmp = $tmp;
			}


			$sess_data = array(
				'tempat' => $tmp,
				'role' => $akses,
				'role_id' => $id,
				'nama' => $pengguna->pengguna_nama,
				'user_id' => $pengguna->pengguna_id,
			);


			$this->session->set_userdata(array( 'auth' => $sess_data) );
			$response['success'] = 1;
		}


		echo json_encode($response);
		die();

	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
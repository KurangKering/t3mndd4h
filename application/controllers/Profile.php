<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
		$data['profile'] = $this->M_Pengguna->findOrFail($this->auth['user_id']);

		return view('profile', compact('data'));	
	}

	public function update()
	{
		
		$this->load->library('form_validation');
		$post = $this->input->post();

		$auth = $this->auth;
		$id = $this->auth['user_id'];
		$this->form_validation->set_rules('nama', 'Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'input-nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'input-username' => form_error('username', '<p class="mt-3 text-danger">', '</p>'),
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


			
			$data = $this->M_Pengguna->findOrFail($id);
			$dataUpdate = $data->update($postData);

			$session_auth = $this->auth;
			$session_auth['nama'] = $data->pengguna_nama;

			
			
			$this->session->set_userdata(array( 'auth' => $session_auth) );

		}


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}

}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */
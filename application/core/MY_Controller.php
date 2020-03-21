<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $auth = array();
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('auth');


		if (!$user) {
			redirect('login');
			return;
		} 


		$this->auth = $user;

	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
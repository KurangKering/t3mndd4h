<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Regu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth['role'] != "kota") {
            show_404();
        }
    }
    public function index()
    {

       
    }


    public function getDataRegu()
    {
        $id = $this->input->post('id');
        $regu = $this->M_Regu->findOrFail($id);


        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($regu));
    }
    
    public function delete()
    {
        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        

        $id = $this->input->post('id');
        $data = $this->M_Regu->findOrFail($id);
        $deleteData = $data->delete();
        

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));

    }
    public function update()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        

        $this->form_validation->set_rules('regu', 'Regu', 'trim|required');

        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'input-regu' => form_error('regu', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
                'regu_nama' => $post['regu'],
            );

            $data = $this->M_Regu->findOrFail($post['id']);
            $dataUpdate = $data->update($postData);
        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function store()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        $this->form_validation->set_rules('regu', 'Regu', 'trim|required');


        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
             'input-regu' => form_error('regu', '<p class="mt-3 text-danger">', '</p>'),
         );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
               'regu_nama' => $post['regu'],
           );

            $insertData = $this->M_Regu->insert($postData);
        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function jsonDataRegu()
    {
        $auth = $this->auth;

        $this->dt->select('
        	regu_id,
            regu_nama
            ');
        $this->dt->from('regu');
        $this->dt->add_column('nomor', '');
        $this->dt->add_column('action',
            '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModal($1,1)">Ubah</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModal($1,2)">Hapus</a>'
            , 'regu_id'
        );
        echo $this->dt->generate();
        die();
    }
}

/* End of file Regu.php */
/* Location: ./application/controllers/Regu.php */

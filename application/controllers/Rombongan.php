<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rombongan extends MY_Controller
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


    public function getDataRombongan()
    {
        $id = $this->input->post('id');
        $rombongan = $this->M_Rombongan->findOrFail($id);


        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($rombongan));
    }
    
    public function delete()
    {
        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        

        $id = $this->input->post('id');
        $data = $this->M_Rombongan->findOrFail($id);
        $deleteData = $data->delete();
        

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));

    }
    public function update()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        

        $this->form_validation->set_rules('rombongan', 'Rombongan', 'trim|required');

        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'input-rombongan' => form_error('rombongan', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
                'rombongan_nama' => $post['rombongan'],
            );

            $data = $this->M_Rombongan->findOrFail($post['id']);
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
        $this->form_validation->set_rules('rombongan', 'Rombongan', 'trim|required');


        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
             'input-rombongan' => form_error('rombongan', '<p class="mt-3 text-danger">', '</p>'),
         );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
               'rombongan_nama' => $post['rombongan'],
           );

            $insertData = $this->M_Rombongan->insert($postData);
        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function jsonDataRombongan()
    {
        $auth = $this->auth;

        $this->dt->select('
            rombongan_id,
            rombongan_nama
            ');
        $this->dt->from('rombongan');
        $this->dt->add_column('nomor', '');
        $this->dt->add_column('action',
            '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModalRombongan($1,1)">Ubah</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModalRombongan($1,2)">Hapus</a>'
            , 'rombongan_id'
        );
        echo $this->dt->generate();
        die();
    }
}

/* End of file Rombongan.php */
/* Location: ./application/controllers/Rombongan.php */

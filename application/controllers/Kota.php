<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kota extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->auth['role'] != "prov") {
            show_404();
        }
    }
    public function index()
    {

        $data['provinsi'] = $this->M_Provinsi;
        if ($this->auth['role'] == 'prov') {
            $data['provinsi'] = $data['provinsi']->where('provinsi_id', $this->auth['role_id']);
        }
        $data['provinsi'] = $data['provinsi']->get();
        $data['auth'] = $this->auth;
        return view('kota.index', compact('data'));
    }


    public function getDataKota()
    {
        $id = $this->input->post('id');
        $kota = $this->M_Kota->findOrFail($id);


        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($kota));
    }
    
    public function delete()
    {
        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        

        $id = $this->input->post('id');
        $data = $this->M_Kota->findOrFail($id);
        $deleteData = $data->delete();
        

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));

    }
    public function update()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        

        $this->form_validation->set_rules('provinsi', 'Nama Provinsi', 'trim|required');
        $this->form_validation->set_rules('kota', 'Nama Kota', 'trim|required');

        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'input-kota-provinsi' => form_error('provinsi', '<p class="mt-3 text-danger">', '</p>'),
                'input-kota' => form_error('kota', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
                'kota_provinsi_id' => $post['provinsi'],
                'kota_nama' => $post['kota'],
            );

            $data = $this->M_Kota->findOrFail($post['id']);
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
        $this->form_validation->set_rules('provinsi', 'Nama Provinsi', 'trim|required');
        $this->form_validation->set_rules('kota', 'Nama Kota', 'trim|required');


        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
               'input-kota-provinsi' => form_error('provinsi', '<p class="mt-3 text-danger">', '</p>'),
               'input-kota' => form_error('kota', '<p class="mt-3 text-danger">', '</p>'),
           );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
             'kota_provinsi_id' => $post['provinsi'],
             'kota_nama' => $post['kota'],
         );

            $insertData = $this->M_Kota->insert($postData);
        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function jsonDataKota()
    {
        $auth = $this->auth;

        $this->dt->select('
        	k.kota_id,
        	k.kota_nama,
        	p.provinsi_nama
        	');
        $this->dt->from('kota k');
        if ($auth['role'] == 'prov') {
            $this->dt->where('k.kota_provinsi_id', $auth['role_id']);
        }
        $this->dt->join('provinsi p',
            'k.kota_provinsi_id = p.provinsi_id');
        $this->dt->add_column('nomor', '');
        $this->dt->add_column('action',
            '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModal($1,1)">Ubah</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModal($1,2)">Hapus</a>'
            , 'kota_id'
        );
        echo $this->dt->generate();
        die();
    }
}

/* End of file Kota.php */
/* Location: ./application/controllers/Kota.php */

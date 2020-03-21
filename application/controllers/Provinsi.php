<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provinsi extends MY_Controller
{

    // public function index()
    // {
    //     $data['provinsi'] = $this->M_Provinsi->get();
    //     return view('kota.index', compact('data'));
    // }


    public function getDataProvinsi()
    {
        $id = $this->input->post('id');
        $provinsi = $this->M_Provinsi->findOrFail($id);


        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($provinsi));
    }
    
    public function delete()
    {
        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        

        $id = $this->input->post('id');
        $data = $this->M_Provinsi->findOrFail($id);
        $deleteData = $data->delete();
        $json['provinsi'] = $this->getAllProvinsi();
        

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));

    }
    public function update()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        

        $this->form_validation->set_rules('provinsi', 'Nama Provinsi', 'trim|required');

        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'input-provinsi' => form_error('provinsi', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
                'provinsi_nama' => $post['provinsi'],
            );

            $data = $this->M_Provinsi->findOrFail($post['id']);
            $dataUpdate = $data->update($postData);
            $json['provinsi'] = $this->getAllProvinsi();

        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function getAllProvinsi()
    {
        $json = $this->M_Provinsi->orderBy('provinsi_nama')->get();
        return $json;
    }

    public function store()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        $this->form_validation->set_rules('provinsi', 'Nama Provinsi', 'trim|required');


        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
               'input-provinsi' => form_error('provinsi', '<p class="mt-3 text-danger">', '</p>'),
           );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
             'provinsi_nama' => $post['provinsi'],
         );

            $insertData = $this->M_Provinsi->insert($postData);
            $json['provinsi'] = $this->getAllProvinsi();
        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function jsonDTProvinsi()
    {
        $this->dt->select('
            p.provinsi_id,
            p.provinsi_nama
            ');
        $this->dt->from('provinsi p');
        $this->dt->add_column('nomor', '');
        $this->dt->add_column('action',
            '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModalProvinsi($1,1)">Ubah</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModalProvinsi($1,2)">Hapus</a>'
            , 'provinsi_id'
        );
        echo $this->dt->generate();
        die();
    }
}

/* End of file Provinsi.php */
/* Location: ./application/controllers/Provinsi.php */

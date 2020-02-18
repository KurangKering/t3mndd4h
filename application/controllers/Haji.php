<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Haji extends CI_Controller
{

    public function index()
    {
        $data['kota'] = $this->M_Kota->orderBy('kota_nama')->get();
        return view('haji.index', compact('data'));
    }

    public function getDataHaji()
    {
        $id = $this->input->post('id');
        $haji = $this->M_Haji->findOrFail($id);


        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($haji));
    }
    
    public function delete()
    {
        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        

        $id = $this->input->post('id');
        $data = $this->M_Haji->findOrFail($id);
        $deleteData = $data->delete();
        

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));

    }
    public function update()
    {
        $this->load->library('form_validation');
        $post = $this->input->post();
        

        $this->form_validation->set_rules('nama', 'Nama Peserta', 'trim|required');
        $this->form_validation->set_rules('paspor', 'Nomor Paspor', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun Haji', 'trim|required');
        $this->form_validation->set_rules('usia', 'Usia', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('status', 'Status Jemaah', 'trim|required');
        $this->form_validation->set_rules('regu', 'Regu', 'trim|required');
        $this->form_validation->set_rules('rombongan', 'Rombongan', 'trim|required');
        $this->form_validation->set_rules('kloter', 'Kloter', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');

        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
                'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
                'paspor' => form_error('paspor', '<p class="mt-3 text-danger">', '</p>'),
                'tahun' => form_error('tahun', '<p class="mt-3 text-danger">', '</p>'),
                'usia' => form_error('usia', '<p class="mt-3 text-danger">', '</p>'),
                'jk' => form_error('jk', '<p class="mt-3 text-danger">', '</p>'),
                'status' => form_error('status', '<p class="mt-3 text-danger">', '</p>'),
                'regu' => form_error('regu', '<p class="mt-3 text-danger">', '</p>'),
                'rombongan' => form_error('rombongan', '<p class="mt-3 text-danger">', '</p>'),
                'kloter' => form_error('kloter', '<p class="mt-3 text-danger">', '</p>'),
                'kota' => form_error('kota', '<p class="mt-3 text-danger">', '</p>'),
            );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
                'haji_nama' => $post['nama'],
                'haji_nomor_paspor' => $post['paspor'],
                'haji_tahun' => $post['tahun'],
                'haji_usia' => $post['usia'],
                'haji_jk' => $post['jk'],
                'haji_status_jemaah' => $post['status'],
                'haji_regu_id' => $post['regu'],
                'haji_rombongan_id' => $post['rombongan'],
                'haji_kloter_id' => $post['kloter'],
                'haji_kota_id' => $post['kota'],

            );

            $data = $this->M_Haji->findOrFail($post['id']);
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

        $this->form_validation->set_rules('nama', 'Nama Peserta', 'trim|required');
        $this->form_validation->set_rules('paspor', 'Nomor Paspor', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun Haji', 'trim|required');
        $this->form_validation->set_rules('usia', 'Usia', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('status', 'Status Jemaah', 'trim|required');
        $this->form_validation->set_rules('regu', 'Regu', 'trim|required');
        $this->form_validation->set_rules('rombongan', 'Rombongan', 'trim|required');
        $this->form_validation->set_rules('kloter', 'Kloter', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');

        $json = array();
        $json['success'] = 1;
        $json['messages'] = array();
        if (!$this->form_validation->run()) {
            $json['messages'] = array(
             'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
             'paspor' => form_error('paspor', '<p class="mt-3 text-danger">', '</p>'),
             'tahun' => form_error('tahun', '<p class="mt-3 text-danger">', '</p>'),
             'usia' => form_error('usia', '<p class="mt-3 text-danger">', '</p>'),
             'jk' => form_error('jk', '<p class="mt-3 text-danger">', '</p>'),
             'status' => form_error('status', '<p class="mt-3 text-danger">', '</p>'),
             'regu' => form_error('regu', '<p class="mt-3 text-danger">', '</p>'),
             'rombongan' => form_error('rombongan', '<p class="mt-3 text-danger">', '</p>'),
             'kloter' => form_error('kloter', '<p class="mt-3 text-danger">', '</p>'),
             'kota' => form_error('kota', '<p class="mt-3 text-danger">', '</p>'),
         );
            $json['messages'] = array_filter($json['messages']);
            $json['success'] = 0;
        } else {
            $postData = array(
               'haji_nama' => $post['nama'],
               'haji_nomor_paspor' => $post['paspor'],
               'haji_tahun' => $post['tahun'],
               'haji_usia' => $post['usia'],
               'haji_jk' => $post['jk'],
               'haji_status_jemaah' => $post['status'],
               'haji_regu_id' => $post['regu'],
               'haji_rombongan_id' => $post['rombongan'],
               'haji_kloter_id' => $post['kloter'],
               'haji_kota_id' => $post['kota'],
           );

            $insertData = $this->M_Haji->insert($postData);
        }

        
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($json));
    }

    public function jsonDataHaji()
    {
        $this->dt->select('
           h.haji_id,
           h.haji_nomor_paspor,
           h.haji_tahun,
           h.haji_nama,
           h.haji_usia,
           h.haji_kloter_id,
           h.haji_regu_id,
           h.haji_rombongan_id,
           h.haji_jk,
           h.haji_status_jemaah,
           ko.kota_nama,
           pro.provinsi_nama
           ');
        $this->dt->from('haji h');

        $this->dt->join('kota ko',
            'h.haji_kota_id = ko.kota_id');

        $this->dt->join('provinsi pro',
            'ko.kota_provinsi_id = pro.provinsi_id');

        $this->dt->add_column('nomor', '');

        function callback_jk($jk)
        {
            return hJK($jk);
        }
        $this->dt->edit_column('haji_jk', '$1', "callback_jk(haji_jk)");

        function callback_status($jk)
        {
            return hStatusJemaah($jk);
        }
        $this->dt->edit_column('haji_status_jemaah', '$1', "callback_status(haji_status_jemaah)");

        function callback_regu($regu)
        {
            return hRegu($regu);
        }
        $this->dt->edit_column('haji_regu_id', '$1', "callback_regu(haji_regu_id)");

        function callback_rombongan($rombongan)
        {
            return hRombongan($rombongan);
        }
        $this->dt->edit_column('haji_rombongan_id', '$1', "callback_rombongan(haji_rombongan_id)");

        function callback_kloter($kloter)
        {
            return hKloter($kloter);
        }
        $this->dt->edit_column('haji_kloter_id', '$1', "callback_kloter(haji_kloter_id)");

        $this->dt->add_column('action',
            '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModal($1,1)">Ubah</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModal($1,2)">Hapus</a>'
            , 'haji_id'
        );
     
        echo $this->dt->generate();
        die();
    }

}

/* End of file Haji.php */
/* Location: ./application/controllers/Haji.php */

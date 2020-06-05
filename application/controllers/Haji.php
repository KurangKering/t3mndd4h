<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Haji extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        $haji = $this->M_Haji->get();

        $kota = $this->M_Kota->orderBy('kota_nama');
        $provinsi = $this->M_Provinsi;

        if ($this->auth['role'] == "kota") {
            $kota = $kota->where('kota_id', $this->auth['role_id'])->get();
            $provinsi = $provinsi->where('provinsi_id', $kota[0]->kota_provinsi_id);
        } else if ($this->auth['role'] == "prov"){
            $kota = $kota->where('kota_provinsi_id', $this->auth['role_id']);
            $provinsi = $provinsi->where('provinsi_id', $this->auth['role_id']);

        }
        $provinsi = $provinsi->get();

        $rombongan = $this->M_Rombongan->get();
        $regu = $this->M_Regu->get();
        $pluckRombongan = $rombongan->pluck('rombongan_nama', 'rombongan_id');
        $pluckRegu = $regu->pluck('regu_nama', 'regu_id');
        $filterTahun = json_encode($haji->pluck('haji_tahun')->unique()->flatten());
        $filterJK = json_encode(hJK());
        $filterStatus = json_encode(hStatusJemaah());
        $filterRegu = json_encode($pluckRegu->map(function($q) {return "Regu ". $q;}));
        $filterRombongan = json_encode($pluckRombongan->map(function($q) {return "Rombongan ". $q;}));
        $filterKloter = $haji->pluck('haji_kloter_id','haji_kloter_id');
        $filterKloter = $filterKloter->map(function($q) {
            return "Kloter {$q}";
        })->toArray();
        $filterKloter = json_encode($filterKloter);
        $filterKota = json_encode($kota->pluck('kota_nama', 'kota_id'));
        $filterProvinsi = json_encode($provinsi->pluck('provinsi_nama', 'provinsi_id'));

        $data['kota'] = $kota;
        $data['regu'] = $regu;
        $data['rombongan'] = $rombongan;
        $data['filterTahun'] = $filterTahun;
        $data['filterJK'] = $filterJK;
        $data['filterStatus'] = $filterStatus;
        $data['filterRegu'] = $filterRegu;
        $data['filterRombongan'] = $filterRombongan;
        $data['filterKloter'] = $filterKloter;
        $data['filterKota'] = $filterKota;
        $data['filterProvinsi'] = $filterProvinsi;
        $data['auth'] = $this->auth;
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
        $this->form_validation->set_rules('porsi', 'Nomor Porsi', 'trim|required');
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
                'porsi' => form_error('porsi', '<p class="mt-3 text-danger">', '</p>'),
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
                'haji_nomor_porsi' => $post['porsi'],
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
        $this->form_validation->set_rules('porsi', 'Nomor Porsi', 'trim|required');
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
             'porsi' => form_error('porsi', '<p class="mt-3 text-danger">', '</p>'),
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
               'haji_nomor_porsi' => $post['porsi'],
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
           h.haji_nomor_porsi,
           h.haji_tahun,
           h.haji_nama,
           h.haji_usia,
           h.haji_kloter_id,
           h.haji_regu_id,
           re.regu_nama,
           h.haji_rombongan_id,
           rom.rombongan_nama,
           h.haji_jk,
           h.haji_status_jemaah,
           ko.kota_id,
           pro.provinsi_id,
           ko.kota_nama,
           pro.provinsi_nama
           ');
        $this->dt->from('haji h');

        if ($this->auth['role'] == "prov") {
            $this->dt->where('pro.provinsi_id', $this->auth['role_id']);
        } else if ($this->auth['role'] == "kota") {
            $this->dt->where('h.haji_kota_id', $this->auth['role_id']);

        }

        $this->dt->join('kota ko',
            'h.haji_kota_id = ko.kota_id');

        $this->dt->join('provinsi pro',
            'ko.kota_provinsi_id = pro.provinsi_id');

        $this->dt->join('regu re',
            'h.haji_regu_id = re.regu_id');

        $this->dt->join('rombongan rom',
            'h.haji_rombongan_id = rom.rombongan_id');

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
            return "Regu ". $regu;
        }
        $this->dt->edit_column('regu_nama', '$1', "callback_regu(regu_nama)");

        function callback_rombongan($rombongan)
        {
            return "Rombongan ". $rombongan;
        }
        $this->dt->edit_column('rombongan_nama', '$1', "callback_rombongan(rombongan_nama)");

        function callback_kloter($kloter)
        {
            return hKloter($kloter);
        }
        $this->dt->edit_column('haji_kloter_id', '$1', "callback_kloter(haji_kloter_id)");

        if ($this->auth['role'] == "kota") {

            $this->dt->add_column('action',
                '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onClick="showModal($1,1)">Ubah</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="showModal($1,2)">Hapus</a>'
                , 'haji_id'
            );
        }

        $mColArray  = $this->input->post('columns');
        // $this->dt->filter('haji_tahun', 2020);
        // 
        $fieldLike = array(
            'haji_id',
            'haji_nomor_porsi',
            'haji_nama',
            'haji_usia',
        );
        
        for ($i = 0; $i < count($mColArray); $i++) {

            if ($mColArray[$i]['searchable'] == 'true' && $mColArray[$i]['search']['value']) {
                if (in_array($mColArray[$i]['name'], $fieldLike)) {
                    $this->dt->like($mColArray[$i]['name'], $mColArray[$i]['search']['value'] );

                } else {

                    $this->dt->filter($mColArray[$i]['name'], $mColArray[$i]['search']['value'] );
                }


            }

        }

        echo $this->dt->generate();
        die();
    }

}

/* End of file Haji.php */
/* Location: ./application/controllers/Haji.php */

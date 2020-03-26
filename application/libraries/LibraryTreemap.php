<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \Colors\RandomColor;

class LibraryTreemap
{
    protected $_ci;
    protected $_db;

    protected $_pure_cond = array();

    protected $_ex_cond = array();

    protected $_datatable = array();

    protected $_top_data;

    protected $_urutan;

    protected $_result_data;

    public function __construct($params)
    {
        $this->_ci              = &get_instance();
        $this->_db       = $this->_ci->db;
        $this->_top_data = $params['top_data'];
        $this->_urutan   = $params['urutan'];

        $this->extractCondition($params['conditions']);
        $this->_ci->load->helper('helper');

        $this->_ci->load->model('M_Kota');


    }

    public function generate()
    {

        $array_data = array(
            'data'     => [],
            'table'    => [],
            'subtitle' => '',
        );

        $this->start();

        if ($this->_result_data) {
            $array_data['data']     = array_values($this->_result_data);
            $array_data['rekomendasi']     = ($this->_getRekomendasi());
            // $array_data['table']    = $this->_datatable;
            $array_data['subtitle'] = $this->makeSubtitle();
        }

        $json = gzencode(json_encode($array_data));

        return $json;

    }

    public function extractCondition($params)
    {

        $conditions = array();

        if (!is_array($params)) {
            return $conditions;
        }

        $params = array_filter($params);

        if (isset($params['tahun'])) {
            $conditions[] = 'hj.haji_tahun = ' . $params['tahun'];
        } else {
            $params['tahun'] = date('Y');
            $conditions[]    = 'hj.haji_tahun = ' . date('Y');

        }
        if (isset($params['jk'])) {
            $conditions[] = 'hj.haji_jk = ' . '"' . $params['jk'] . '"';
        }

        if (isset($params['usia'])) {
            $usia = $params['usia'];

            if ($usia == '1') {
                $conditions[] = 'hj.haji_usia >= 18 AND hj.haji_usia <= 64';
            } else if ($usia == '2') {
                $conditions[] = 'hj.haji_usia > 64';

            }
        }

        if (isset($params['kota'])) {
            $conditions[] = 'hj.haji_kota_id = ' . $params['kota'];
        }

        if (isset($params['status'])) {
            $conditions[] = 'hj.haji_status_jemaah = ' . $params['status'];
        }

        $this->_pure_cond = $params;
        $this->_ex_cond   = implode(' AND ', $conditions);

    }

    protected function start()
    {

        $d_haji = collect($this->getDataFromDB());

        if (!$d_haji) {
            return false;
        }

        $d_haji->each(function ($q) {
            $q->jenis_kelamin = hJK($q->haji_jk);
            $q->status_jemaah = hStatusJemaah($q->haji_status_jemaah);
        });

        $d_kota = $d_haji->unique(function ($q) {return $q->haji_kota_id;});
        $d_kloter = $d_haji->unique(function ($q) {return $q->haji_kloter_id;});
        $d_romb = $d_haji->unique(function ($q) {return $q->haji_rombongan_id;});
        $d_regu = $d_haji->unique(function ($q) {return $q->haji_regu_id;});

        $w_kota   = RandomColor::many(count($d_kota));
        $w_kloter = RandomColor::many(count($d_kloter));
        $w_romb   = RandomColor::many(count($d_romb));
        $w_regu   = RandomColor::many(count($d_regu));

        $h_kloter = hKloter();
        $h_romb   = hRombongan();
        $h_regu   = hRegu();

        $container    = array();
        $description  = array();
        $valueCapture = array();

        $iwkota = 0;
        foreach ($d_kota as $kko => $vko) {

            $q_jj_kota   = $d_haji->where('haji_kota_id', $vko->kota_id);
            $c_jj_kota   = $q_jj_kota->count();
            $c_ji_kloter = $q_jj_kota->unique('haji_kloter_id')->count();

            if ($c_jj_kota <= 0) {
                $iwkota++;
                continue;
            }
            $content_kota = array(
                'Provinsi'             => $vko->provinsi_nama,
                'Kota / Kabupaten'     => $vko->kota_nama,
                'Jumlah Kloter Terisi' => $c_ji_kloter,
                'Jumlah Jemaah'        => $c_jj_kota,
            );
            $html_kota = $this->genRow($content_kota);

            $array_kota = array(
                'id'          => md5("kota {$vko->kota_id}"),
                'name'        => $vko->kota_nama,
                'value'       => $c_jj_kota,
                'description' => $html_kota,
                'color'       => $w_kota[$iwkota++],
                'status'      => 1,
                'values'      => $c_jj_kota,

            );

            $iwkloter = 0;
            foreach ($d_kloter as $vklo) {

                $q_jj_kloter = $q_jj_kota->where('haji_kloter_id', $vklo->haji_kloter_id);
                $c_jj_kloter = $q_jj_kloter->count();
                $c_ji_romb   = $q_jj_kloter->unique('haji_rombongan_id')->count();

                if ($c_jj_kloter <= 0) {
                    $iwkloter++;
                    continue;
                }
                $content_kloter = array(
                    'Provinsi'                => $vko->provinsi_nama,
                    'Kota / Kabupaten'        => $vko->kota_nama,
                    'Kloter'                  => $h_kloter[$vklo->haji_kloter_id],
                    'Jumlah Rombongan Terisi' => $c_ji_romb,
                    'Jumlah Jemaah'           => $c_jj_kloter,
                );
                $html_kloter = $this->genRow($content_kloter);

                $array_kloter = array(
                    'id'          => md5("kloter {$vklo->haji_kloter_id}"),
                    'name'        => $h_kloter[$vklo->haji_kloter_id],
                    'value'       => $c_jj_kloter,
                    'description' => $html_kloter,
                    'color'       => $w_kloter[$iwkloter++],
                    'status'      => 2,
                    'values'      => $c_jj_kloter,
                );

                $iwromb = 0;
                foreach ($d_romb as $vro) {

                    $q_jj_romb = $q_jj_kloter->where('haji_rombongan_id', $vro->haji_rombongan_id);
                    $c_jj_romb = $q_jj_romb->count();
                    $c_ji_regu = $q_jj_romb->unique('haji_regu_id')->count();

                    if ($c_jj_romb <= 0) {
                        $iwromb++;
                        continue;
                    }

                    $content_romb = array(
                        'Provinsi'           => $vko->provinsi_nama,
                        'Kota / Kabupaten'   => $vko->kota_nama,
                        'Kloter'             => $h_kloter[$vklo->haji_kloter_id],
                        'Rombongan'          => $h_romb[$vro->haji_rombongan_id],
                        'Jumlah Regu Terisi' => $c_ji_regu,
                        'Jumlah Jemaah'      => $c_jj_romb,
                    );
                    $html_romb = $this->genRow($content_romb);

                    $array_romb = array(
                        'id'          => md5("rombongan {$vro->haji_rombongan_id}"),
                        'name'        => $h_romb[$vro->haji_rombongan_id],
                        'value'       => $c_jj_romb,
                        'description' => $html_romb,
                        'color'       => $w_romb[$iwromb++],
                        'status'      => 3,
                        'values'      => $c_jj_romb,

                    );

                    $iwregu = 0;
                    foreach ($d_regu as $vre) {
                        $q_jj_regu = $q_jj_romb->where('haji_regu_id', $vre->haji_regu_id);
                        $c_jj_regu = $q_jj_regu->count();

                        if ($c_jj_regu <= 0) {
                            $iwregu++;
                            continue;
                        }

                        $content_regu = array(
                            'Provinsi'         => $vko->provinsi_nama,
                            'Kota / Kabupaten' => $vko->kota_nama,
                            'Kloter'           => $h_kloter[$vklo->haji_kloter_id],
                            'Rombongan'        => $h_romb[$vro->haji_rombongan_id],
                            'Regu'             => $h_regu[$vre->haji_regu_id],
                            'Jumlah Jemaah'    => $c_jj_regu,
                        );
                        $html_regu = $this->genRow($content_regu);

                        $content_peserta = [
                            'header' => [
                                'No',
                                'Nama',
                                'Jenis Kelamin',
                                'Usia',
                                'Status Jemaah',
                            ],
                        ];
                        $jemaah_urut = $q_jj_regu->sortBy(function ($q) {
                            return $q->haji_nama;
                        });

                        $no_peserta = 1;
                        foreach ($jemaah_urut as $kpes => $vpes) {
                            $content_peserta['isi'][] = [
                                $no_peserta++,
                                $vpes->haji_nama,
                                hJK($vpes->haji_jk),
                                $vpes->haji_usia . " Tahun",
                                hStatusJemaah($vpes->haji_status_jemaah),
                            ];
                        }
                        $html_peserta = "<hr>";
                        $html_peserta .= $this->genRow($content_regu, "<table class=\" \" id=\"table-kop\">");
                        $html_peserta .= "<hr>";
                        $html_peserta .= $this->genRowTopHeader($content_peserta);
                        $html_peserta .= "<br>";
                        $array_regu = array(
                            'id'           => md5("regu {$vre->haji_regu_id}"),
                            'name'         => $h_regu[$vre->haji_regu_id],
                            'value'        => $c_jj_regu,
                            'description2' => $html_regu,
                            'description'  => $html_peserta,
                            'color'        => $w_regu[$iwregu++],
                            'status'       => 4,
                            'values'       => $c_jj_regu,

                        );

                        $tmpp = array(
                            $array_kota,
                            $array_kloter,
                            $array_romb,
                            $array_regu,
                        );
                        if ($this->_urutan != "sama") {

                            $urutan   = explode(',', $this->_urutan);
                            $tmp      = array();
                            $countTmp = count($tmpp);
                            foreach ($tmpp as $i => $vtmpp) {
                                $tmp[$i]           = $tmpp[$urutan[$i]];
                                $tmp[$i]['status'] = $i + 1;
                                if ($i + 1 < $countTmp) {
                                    $tmp[$i]['description'] = '';
                                } else {
                                    $tmp[$i]['description'] = $vtmpp['description'];
                                }
                            }

                        } else {
                            $tmp = $tmpp;
                        }

                        $tmp[0]['id']      = ($tmp[0]['id']);
                        $tmp[0]['parentt'] = '';

                        foreach ($tmp as $i => $vtmp) {
                            if ($i > 0) {
                                $tmp[$i]['id']      = md5($tmp[$i - 1]['id'] . $tmp[$i]['id']);
                                $tmp[$i]['parentt'] = $tmp[$i - 1]['id'];
                            }

                            if (!isset($container[$tmp[$i]['id']])) {
                                $container[$tmp[$i]['id']] = $tmp[$i];
                            }

                        }

                    }
                }
            }
        }

        $this->_datatable = $d_haji->map(function ($q) {

            return array(
                "haji_nomor_porsi"  => $q->haji_nomor_porsi,
                "haji_tahun"        => $q->haji_tahun,
                "haji_nama"         => $q->haji_nama,
                "haji_usia"         => $q->haji_usia,
                "jenis_kelamin"     => $q->jenis_kelamin,
                "status_jemaah"     => $q->status_jemaah,
                "haji_regu_id"      => $q->haji_regu_id,
                "haji_rombongan_id" => $q->haji_rombongan_id,
                "haji_kloter_id"    => $q->haji_kloter_id,
                "kota_nama"         => $q->kota_nama,
                "provinsi_nama"     => $q->provinsi_nama,
            );

        });
        $this->_result_data = $container;

    }

    protected function makeSubtitle()
    {

        $conditions = $this->_pure_cond;
        $subtitle   = array();

        if (!empty($conditions['tahun'])) {
            $subtitle[] = 'Tahun ' . $conditions['tahun'];
        }

        if (!empty($conditions['jk'])) {
            $subtitle[] = 'Jenis Kelamin ' . hJK($conditions['jk']);

        }

        if (!empty($conditions['usia'])) {
            $usia = '';
            if ($conditions['usia'] == '1') {
                $usia = 'Diantara 18 Sampai 64 Tahun';
            } else {
                $usia = 'Diatas 64 Tahun';
            }
            $subtitle[] = 'Usia ' . $usia;

        }

        if (!empty($conditions['kota'])) {
            $kota = $this->_ci->M_Kota->findOrFail($conditions['kota']);
            $subtitle[] = 'Kota ' . $kota->kota_nama;

        }

        if (!empty($conditions['status'])) {

            $subtitle[] = 'Status ' . hStatusJemaah($conditions['status']);

        }

        return implode(', ', $subtitle);


    }


    private function _queryGetData()
    {
        $ids_top = null;
        if ($this->_top_data) {
            $ids_top = $this->getIdsTopData($this->_top_data);
        }
        $this->_db->select('hj.*, kt.*, pr.*');
        if ($this->_ex_cond) {
            $this->_db->where($this->_ex_cond);
        }
        if (!empty($ids_top)) {
            $this->_db->where_in('hj.haji_kota_id', $ids_top, false);
        }
        $this->_db->from('haji hj');
        $this->_db->join('kota kt', 'hj.haji_kota_id = kt.kota_id');
        $this->_db->join('provinsi pr', 'kt.kota_provinsi_id = pr.provinsi_id');
        $query = $this->_db->get_compiled_select();
        return $query;
    }

    private function _getRekomendasi() 
    {
        $output = array();
        $conditions = $this->_pure_cond;

        if (isset($conditions['jk']) || isset($conditions['usia']) || isset($conditions['status'])) {
            
            return $output;
        }

        $q_get_data = $this->_queryGetData();
        $q_rekom = "SELECT 
        SUM(CASE when haji_usia > 64 then 1 ELSE 0 END) jumlah_tua,
        SUM(CASE when haji_status_jemaah = 8 then 1 ELSE 0 END) jumlah_paramedis,
        kota_nama, 
        haji_kloter_id
        FROM ({$q_get_data}) rekom       
        GROUP BY haji_kota_id, haji_kloter_id";

        $result = $this->_db->query($q_rekom)->result_array();

        foreach ($result as $kres => $vres) {
            $hitung = ceil($vres['jumlah_tua'] / 40);
            if ($hitung > 0 && ($hitung > $vres['jumlah_paramedis'])) {
                $output[] = array(
                    'kota_nama' => $vres['kota_nama'],
                    'haji_kloter_id' => $vres['haji_kloter_id'],
                    'jumlah_tua' => $vres['jumlah_tua'],
                    'jumlah_paramedis' => $vres['jumlah_paramedis'],
                    'kebutuhan' => $hitung,
                );
            }
            continue;
        }
        return $output;
    }

    public function getDataFromDB()
    {
        $query = $this->_queryGetData();
        $d_kes = $this->_db->query($query);
        $d_kes = $d_kes->result();
        return $d_kes;

    }

    public function getIdsTopData()
    {

        $this->_db->select('hj.haji_kota_id');
        if ($this->_ex_cond) {
            $this->_db->where($this->_ex_cond);

        }
        $this->_db->from('haji hj');
        $this->_db->join('kota kt', 'hj.haji_kota_id = kt.kota_id');
        $this->_db->join('provinsi pr', 'kt.kota_provinsi_id = pr.provinsi_id');
        $this->_db->group_by('hj.haji_kota_id');
        $this->_db->order_by('COUNT(*) desc');
        $this->_db->limit($this->_top_data);
        $ids_top = $this->_db->get();
        $ids_top = array_values(array_column($ids_top->result_array(), 'haji_kota_id'));
        return $ids_top;

    }

    protected function htmlVerticalHeaderTable($items,
        $open_tag = "<table class=\"table table-tooltip\">",
        $close_tag = "</table>") {

        $rows = $open_tag;
        $rows .= "<tbody>";
        foreach ($items as $key => $item) {
            $rows .=
            "<tr><th>{$key}</th><td>: {$item}</td></tr>";
        }
        $rows . "</tbody>";
        $rows .= $close_tag;
        return $rows;
    }

    protected function htmlHorizontalHeaderTable($items,
        $open_tag,
        $close_tag) {

    }

    private function genRow($data,
        $openTag = "<table class=\"table table-tooltip\">", $closeTag = "</table>") {
        $rows = $openTag;
        $rows .= "<tbody>";
        foreach ($data as $k => $v) {
            $rows .=
            "<tr><th>{$k}</th><td>: {$v}</td></tr>";
        }
        $rows . "</tbody>";
        $rows .= $closeTag;
        return $rows;
    }
    private function genRowTopHeader($data,
        $openTag = "<table class=\"table table-striped\"", $closeTag = "</table>") {
        $rows = "<div class=\"card\">";
        $rows .= "<div class=\"card-body p-0\">
        <div class=\"table-responsive table-invoice\">";
        $rows .= $openTag;
        $rows .= "<thead>";
        $rows .= "<tr>";
        foreach ($data['header'] as $k => $v) {
            $rows .=
            "<th>{$v}</th>";
        }
        $rows .= "</tr>";
        $rows .= "</thead>";
        $rows .= "<tbody>";
        foreach ($data['isi'] as $k => $v) {
            $rows .= "<tr>";
            foreach ($v as $kk => $vv) {
                $rows .= "<td>{$vv}</td>";
            }
            $rows .= "</tr>";
        }
        $rows . "</tbody>";
        $rows .= $closeTag;
        $rows . "</div>";
        $rows . "</div>";
        $rows . "</div>";
        return $rows;
    }
}

/* End of file Treemap.php */
/* Location: ./application/libraries/Treemap.php */

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestTestTreemap extends CI_Controller
{

	static public $TUA = 2;
	static public $MUDA = 1;
	public function index()
	{
		$d = $this->M_Haji->select('haji_tahun')->groupBy('haji_tahun')->get();
		$data['tahun'] = $d;

		return view('testtesttreemap.index', compact('data'));
	}

	public function map()
	{
		$this->benchmark->mark('doggy');

		$tahun  = $this->input->get('tahun') ?? date('Y');
		$jk     = $this->input->get('jk');
		$usia   = $this->input->get('usia');
		$status = $this->input->get('status');
		$top    = $this->input->get('top');


		$conditions = array(
			'haji_jk' => $jk,
			'haji_status_jemaah' => $status,
			'haji_tahun' => $tahun,
		);
		$conditionUsia = null;
		if ($usia == '1') {
			$conditionUsia = "haji_usia >= 18 AND haji_usia <= 64";
		} else if($usia == '2') {
			$conditionUsia = "haji_usia > 64";
		}

		$conditions = array_filter($conditions);
		$daerahTerbanyak = array();
		if ($top) {
			$daerahTerbanyak = $this->M_Haji->select('haji_kota_id')
			->from('haji')
			->where($conditions);
			if ($usia) {
				$daerahTerbanyak = $daerahTerbanyak->whereRaw($conditionUsia);
			} 
			$daerahTerbanyak = $daerahTerbanyak->groupBy('haji_kota_id')
			->orderByRaw('COUNT(*) desc')
			->limit($top);
			$daerahTerbanyak     = $daerahTerbanyak->pluck('haji_kota_id');
		}


		$qDataHaji = $this->M_Haji->where($conditions);
		if (count($daerahTerbanyak) > 0 ) {
			$qDataHaji = $qDataHaji->whereIn('haji_kota_id', $daerahTerbanyak);
		}
		if ($conditionUsia) {
			$qDataHaji = $qDataHaji->whereRaw($conditionUsia);
		} 
		$dataHaji = $qDataHaji->with('dataKota')->get();

		$dKota      = $dataHaji->pluck('dataKota')->flatten()->unique();
		$dKloter    = $dataHaji->pluck('haji_kloter_id')->flatten()->unique();
		$dRombongan = $dataHaji->pluck('haji_rombongan_id')->flatten()->unique();
		$dRegu      = $dataHaji->pluck('haji_regu_id')->flatten()->unique();

		
		$hKloter    = hKloter();
		$hRombongan = hRombongan();
		$hRegu      = hRegu();

		$colorSuccess = "#badc58";
		$colorFailed = "#ff7979";
		$container   = array();
		$description = array();
		$valueCapture = array();
		$indexKota = 0;
		foreach ($dKota as $kko => $vko) {

			$qJumlahJemaahKota = $dataHaji->where('haji_kota_id', $vko->kota_id);
			$cJumlahJemaahKota = $qJumlahJemaahKota->count();
			$cJumlahIsiKloter  = $qJumlahJemaahKota->unique('haji_kloter_id')->count();

			if ($cJumlahJemaahKota <= 0) {
				continue;
			}
			$isiTableKota = array(
				'Provinsi'             => $vko->dataProvinsi->provinsi_nama,
				'Kota / Kabupaten'     => $vko->kota_nama,
				'Jumlah Kloter Terisi' => $cJumlahIsiKloter,
				'Jumlah Jemaah'        => $cJumlahJemaahKota,
			);
			$rawTableKota = $this->genRow($isiTableKota);
			$idKota = md5($vko->kota_nama);
			
			$container[] = array(
				'id' => $idKota,
				'name' => $vko->kota_nama,
				'value' => $cJumlahIsiKloter,
				'parentt' => "",
				'description' => $rawTableKota,
				'status' => 1,
				'values' => $cJumlahJemaahKota,

			);
			
			foreach ($dKloter as $vklo) {

				$qJumlahJemaahKloter = $qJumlahJemaahKota->where('haji_kloter_id', $vklo);
				$cJumlahJemaahKloter = $qJumlahJemaahKloter->count();
				$cJumlahIsiRombongan = $qJumlahJemaahKloter->unique('haji_rombongan_id')->count();

				if ($cJumlahJemaahKloter <= 0) {
					continue;
				}
				$isiTableKloter = array(
					'Provinsi'                => $vko->dataProvinsi->provinsi_nama,
					'Kota / Kabupaten'        => $vko->kota_nama,
					'Kloter'                  => $hKloter[$vklo],
					'Jumlah Rombongan Terisi' => $cJumlahIsiRombongan,
					'Jumlah Jemaah'           => $cJumlahJemaahKloter,
				);
				$rawTableKloter = $this->genRow($isiTableKloter);
				$idKloter = md5($vko->kota_nama.$hKloter[$vklo]);



				$container[] = array(
					'id' => $idKloter,
					'name' => $hKloter[$vklo],
					'value' => $cJumlahIsiRombongan,
					'parentt' => $idKota,
					'description' => $rawTableKloter,
					'status' => 2,
					'values' => $cJumlahJemaahKloter,
				);

				foreach ($dRombongan as $vro) {

					$qJumlahJemaahRombongan = $qJumlahJemaahKloter->where('haji_rombongan_id', $vro);
					$cJumlahJemaahRombongan = $qJumlahJemaahRombongan->count();
					$cJumlahIsiRegu         = $qJumlahJemaahRombongan->unique('haji_regu_id')->count();

					if ($cJumlahJemaahRombongan <= 0) {
						continue;
					}

					$isiTableRombongan = array(
						'Provinsi'           => $vko->dataProvinsi->provinsi_nama,
						'Kota / Kabupaten'   => $vko->kota_nama,
						'Kloter'             => $hKloter[$vklo],
						'Rombongan'          => $hRombongan[$vro],
						'Jumlah Regu Terisi' => $cJumlahIsiRegu,
						'Jumlah Jemaah'      => $cJumlahJemaahRombongan,
					);
					$rawTableRombongan = $this->genRow($isiTableRombongan);

					$idRombongan = md5($vko->kota_nama.$hKloter[$vklo].$hRombongan[$vro]);




					$container[] = array(
						'id' => $idRombongan,
						'name' => $hRombongan[$vro],
						'value' => $cJumlahIsiRegu,
						'parentt' => $idKloter,
						'description' => $rawTableRombongan,
						'status' => 3,
						'values' => $cJumlahJemaahRombongan,

					);

					foreach ($dRegu as $vre) {
						$qJumlahJemaahRegu = $qJumlahJemaahRombongan->where('haji_regu_id', $vre);
						$cJumlahJemaahRegu = $qJumlahJemaahRegu->count();

						if ($cJumlahJemaahRegu <= 0) {
							continue;
						}

						$isiTableRegu = array(
							'Provinsi'         => $vko->dataProvinsi->provinsi_nama,
							'Kota / Kabupaten' => $vko->kota_nama,
							'Kloter'           => $hKloter[$vklo],
							'Rombongan'        => $hRombongan[$vro],
							'Regu'             => $hRegu[$vre],
							'Jumlah Jemaah'    => $cJumlahJemaahRegu,
						);
						$rawTableRegu = $this->genRow($isiTableRegu);
						$idRegu = md5($vko->kota_nama.$hKloter[$vklo].$hRombongan[$vro].$hRegu[$vre]);



						$kerangkaTablePeserta = [
							'header' => [
								'No',
								'Nama',
								'Jenis Kelamin',
								'Usia',
								'Status Jemaah',
							],
						];
						$orderedJemaah = $qJumlahJemaahRegu->sortBy(function($q) {
							return $q->haji_nama;
						});

						$noPeserta = 1;
						foreach ($orderedJemaah as $kpes => $vpes) {
							$kerangkaTablePeserta['isi'][] = [
								$noPeserta++,
								$vpes->haji_nama,
								hJK($vpes->haji_jk),
								$vpes->haji_usia . " Tahun",
								hStatusJemaah($vpes->haji_status_jemaah),
							];
						}
						$rawTablePeserta = "<hr>";
						$rawTablePeserta .=  $this->genRow($isiTableRegu, "<table class=\" \" id=\"table-kop\">");
						$rawTablePeserta .=  "<hr>";
						$rawTablePeserta .=  $this->genRowTopHeader($kerangkaTablePeserta);
						$rawTablePeserta .= "<br>";
						$container[] = array(
							'id' => $idRegu,
							'name' => $hRegu[$vre],
							'value' => $cJumlahJemaahRegu,
							'parentt' => $idRombongan,
							'description' => $rawTablePeserta,
							'status' => 5,
							'values' => $cJumlahJemaahRegu,

						);

					}
				}
			}
			$indexKota++;
		}

		
		$cKotaIndex=  array_keys(array_column($container, 'status'), 1);
		$cKloterIndex=  array_keys(array_column($container, 'status'), 2);
		$cRombonganIndex=  array_keys(array_column($container, 'status'), 3);
		$cReguIndex=  array_keys(array_column($container, 'status'), 5);

		$maxVKota = 0;
		foreach ($cKotaIndex as $key => $value) {
			if ($container[$value]['values'] > $maxVKota) {
				$maxVKota = $container[$value]['values'];
			}
		}

		foreach ($cKotaIndex as $key => $value) {
			$weight = (($container[$value]['values'] / $maxVKota));
			$color = $this->pickHex($weight);
			$container[$value]['color'] = $color;

			

		}

		$maxVKloter = 0;
		foreach ($cKloterIndex as $key => $value) {
			if ($container[$value]['values'] > $maxVKloter) {
				$maxVKloter = $container[$value]['values'];
			}
		}

		foreach ($cKloterIndex as $key => $value) {
			$weight = (($container[$value]['values'] / $maxVKloter));
			$color = $this->pickHex($weight);
			$container[$value]['color'] = $color;
		}

		$maxVRombongan = 0;
		foreach ($cRombonganIndex as $key => $value) {
			if ($container[$value]['values'] > $maxVRombongan) {
				$maxVRombongan = $container[$value]['values'];
			}
		}

		foreach ($cRombonganIndex as $key => $value) {
			$weight = (($container[$value]['values'] / $maxVRombongan));
			$color = $this->pickHex($weight);
			$container[$value]['color'] = $color;
		}

		$maxVRegu = 0;
		foreach ($cReguIndex as $key => $value) {
			if ($container[$value]['values'] > $maxVRegu) {
				$maxVRegu = $container[$value]['values'];
			}
		}

		foreach ($cReguIndex as $key => $value) {
			$weight = (($container[$value]['values'] / $maxVRegu));
			$color = $this->pickHex($weight);
			$container[$value]['color'] = $color;
		}
		$subtitle = array();
		if (count($container) > 0 ) {
			if ($tahun) {
				$subtitle[] = "Tahun {$tahun}";
			}
			if ($usia == self::$MUDA) {
				$subtitle[] = "Usia Diatas 18 Tahun";
			} else if($usia == self::$TUA) {
				$subtitle[] = "Usia Diatas 64 Tahun";
			}
			if ($jk) {
				$subtitle[] = "Jenis Kelamin ". hJK($jk);
			} 
			if ($status) {
				$subtitle[] = "Status Jemaah ". hStatusJemaah($status);
			}
			if ($top) {
				$subtitle[] = "{$top} Besar";
			}
		}

		$json = array(
			'data' => $container,
			'subtitle' => implode(', ', $subtitle),
		);
		$this->output
		->set_content_type('application/json', 'utf-8')
		->set_output(json_encode($json, JSON_PRETTY_PRINT))
		->_display();
		exit;

	}	
	private function pickHex($weight) {
		$color1 =array(0, 159, 255);
		$color2 =array(236, 47, 75);
		$w1 = $weight;
		$w2 = 1 - $w1;
		$rgb = [round($color1[0] * $w1 + $color2[0] * $w2),
		round($color1[1] * $w1 + $color2[1] * $w2),
		round($color1[2] * $w1 + $color2[2] * $w2)];

		$rgb = "rgb({$rgb[0]},{$rgb[1]},{$rgb[2]})";
		return $rgb;
	}

	private function getDynamicRGB($percent) {
		$percent = $percent;
		$o2 = (100 - $percent) * 2.56;
		$o1 = ($percent) * 2.56;
		$color = "rgb({$o1},{$o2},100)";
		return $color;
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
/* Location: ./application/controllers/Treemap.php */

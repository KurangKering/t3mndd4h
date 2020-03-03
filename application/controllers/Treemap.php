<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Treemap extends CI_Controller
{

	static public $TUA = 2;
	static public $MUDA = 1;
	public function index()
	{
		$d = $this->M_Haji->pluck('haji_tahun')->unique();
		if (!$d->contains(date('Y'))) {
			$d->push((int) date('Y'));
		}
		$kota = $this->M_Kota->get();
		$data['tahun'] = $d;

		$data['kota'] = $kota;

		return view('treemap.index', compact('data'));
	}

	public function map()
	{

		$tahun  = $this->input->get('tahun');
		$jk     = $this->input->get('jk');
		$usia   = $this->input->get('usia');
		$kota   = $this->input->get('kota');
		$status = $this->input->get('status');
		$top    = $this->input->get('top');
		$urutan    = $this->input->get('urutan');



		$params = array(
			'conditions' => array(
				'tahun' => $tahun,
				'jk' => $jk,
				'usia' => $usia,
				'kota' => $kota,
				'status' => $status,

			),
			'top_data' => $top,
			'urutan' => $urutan ?? 'sama',
		);
		$this->load->library('LibraryTreemap', $params);

		$result = $this->librarytreemap->generate();
		$this->output
		->set_header('Content-Encoding: gzip')
		->set_content_type('application/json', 'utf-8')
		->set_output($result)
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

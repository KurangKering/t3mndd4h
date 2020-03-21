<?php
Use eftec\bladeone;

if (!function_exists('view')) {
	function view($view, $data = []) {
		$views = APPPATH .'/views';
		$cache = APPPATH . '/cache';
		define("BLADEONE_MODE",1); 
		$blade=new bladeone\BladeOne($views,$cache);
		echo $blade->run($view,$data);
	}
}
if (!function_exists('hBulan')) {
	function hBulan($bulan = null) {
		$daftar =  array(
			'1' => 'Januari',
			'2' => 'Februari',
			'3' => 'Maret',
			'4' => 'April',
			'5' => 'Mei',
			'6' => 'Juni',
			'7' => 'Juli',
			'8' => 'Agustus',
			'9' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
		if ($bulan) {
			return $daftar[$bulan];
		} 
		return $daftar;
	}
}
if (!function_exists('hStatusJemaah')) {
	function hStatusJemaah($status = null) {
		$daftar =  array(
			'1' => 'Jemaah',
			'2' => 'KARU',
			'3' => 'KAROM',
			'4' => 'TKHI',
			'5' => 'TPHI',
			'6' => 'TPIHI',
			'7' => 'TPHD / TKHD',
			'8' => 'PARAMEDIS',
		);
		if ($status) {
			return $daftar[$status];
		} 
		return $daftar;
	}
}

if (!function_exists('hJK')) {
	function hJK($status = null) {
		$daftar =  array(
			'L' => 'Laki-Laki',
			'P' => 'Perempuan',

		);
		if ($status) {
			return $daftar[$status];
		} 
		return $daftar;
	}
}

if (!function_exists('hGenRow')) {
	function hGenRow($data = null) {
		$rows = "";
		foreach ($data as $k => $v) {
			$rows .= 
			"<tr><th>{$k}</th><td>{$v}</td></tr>";
		}
		return $rows;
	}
}


if (!function_exists('hTopBesar')) {
	function hTopBesar($data = null) {
		$arr = array(
			'1' => '1 Besar Daerah',
			'5' => '5 Besar Daerah',
			'10' => '10 Besar Daerah',
		);
		if ($data != null) {
			return $arr[$data];
		}
		return $arr;
	}
}

if (!function_exists('hUsia')) {
	function hUsia($data = null) {
		$arr = array(
			'1' => 'Dewasa',
			'2' => 'Tua',
		);
		if ($data != null) {
			return $arr[$data];
		}
		return $arr;
	}
}
if (!function_exists('hRegu')) {
	function hRegu($data = null) {
		$arr = array(
			'1' => 'Regu 1',
			'2' => 'Regu 2',
			'3' => 'Regu 3',
			'4' => 'Regu 4',

			
		);
		if ($data != null) {
			return $arr[$data];
		}
		return $arr;
	}
}
if (!function_exists('hRombongan')) {
	function hRombongan($data = null) {
		$arr = array(
			'1' => 'Rombongan 1',
			'2' => 'Rombongan 2',
			'3' => 'Rombongan 3',
			'4' => 'Rombongan 4',
			'5' => 'Rombongan 5',
			'6' => 'Rombongan 6',
			'7' => 'Rombongan 7',
			'8' => 'Rombongan 8',
			'9' => 'Rombongan 9',
			'10' => 'Rombongan 10',

		);
		if ($data != null) {
			return $arr[$data];
		}
		return $arr;
	}
}

if (!function_exists('hKloter')) {
	function hKloter($data = null) {
		$arr = array(
			'2' => 'Kloter 2',
			'3' => 'Kloter 3',
			'4' => 'Kloter 4',
			'5' => 'Kloter 5',
			'6' => 'Kloter 6',
			'7' => 'Kloter 7',
			'8' => 'Kloter 8',
			'9' => 'Kloter 9',
			'10' => 'Kloter 10',
			'18' => 'Kloter 18',
			'19' => 'Kloter 19',
			'20' => 'Kloter 20',

		);
		if ($data != null) {
			return $arr[$data];
		}
		return $arr;
	}
}


if (!function_exists('hAkses')) {
	function hAkses($akses = null) {
		$CI =& get_instance();

		

		$pecah = explode("_", $akses);
		$role = isset($pecah[0]) ? $pecah[0] : null ;
		$id = isset($pecah[1]) ? $pecah[1] : null;

		$hakAkses = null;

		if ($role == 'kota') {
			$CI->load->model('M_Kota');
			if (isset($id)) {
				$kota = $CI->M_Kota->findOrFail($id);

				$hakAkses = "Kota/Kab {$kota->kota_nama}";
			}
		} else if ($role == "prov") {
			$CI->load->model('M_Provinsi');
			if (isset($id)) {
				$provinsi = $CI->M_Provinsi->findOrFail($id);

				$hakAkses = "Provinsi {$provinsi->provinsi_nama}";
			}
		}
		return $hakAkses;
	}
}


if (!function_exists('hRole')) {
	function hRole($role = null) {

	}
}

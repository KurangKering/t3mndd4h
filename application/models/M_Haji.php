<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Haji extends Eloquent
{	
	public $timestamps = false;
	protected $table = 'haji';
	protected $primaryKey = 'haji_id';
	protected $appends = ['nama_kota', 'nama_provinsi', 'jenis_kelamin'];
	protected $fillable = [
		'haji_nomor_paspor',
		'haji_tahun',
		'haji_nama',
		'haji_usia',
		'haji_jk',
		'haji_status_jemaah',
		'haji_regu_id',
		'haji_rombongan_id',
		'haji_kloter_id',
		'haji_kota_id',
	];

	public function dataRegu()
	{
		return $this->belongsTo(new M_Regu(), 'haji_regu_id');
	}
	public function dataRombongan()
	{
		return $this->belongsTo(new M_Rombongan(), 'haji_rombongan_id');
	}
	public function dataKloter()
	{
		return $this->belongsTo(new M_Kloter(), 'haji_kloter_id');
	}
	public function dataKota()
	{
		return $this->belongsTo(new M_Kota(), 'haji_kota_id');
	}
	public function getNamaKotaAttribute()
	{
		return $this->dataKota->kota_nama;
	}
	public function getNamaProvinsiAttribute()
	{
		return $this->dataKota->dataProvinsi->provinsi_nama;
	}
	public function getJenisKelaminAttribute()
	{
		return hJK($this->haji_jk);
	}

	public function getStatusJemaahAttribute()
	{
		return hStatusJemaah($this->haji_status_jemaah);
	}

	

}
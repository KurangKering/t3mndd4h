<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kota extends Eloquent
{
	public $timestamps = false;
	protected $table = 'kota';
	protected $primaryKey = 'kota_id';
	protected $fillable = [
		'kota_nama',
		'kota_provinsi_id',
	];

	public function dataProvinsi()
	{
		return $this->belongsTo(new M_Provinsi(), 'kota_provinsi_id');
	}

	public function dataHaji()
	{
		return $this->hasMany(new M_Haji(), 'haji_kota_id','kota_id');
	}
}
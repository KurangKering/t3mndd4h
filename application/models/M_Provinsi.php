<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Provinsi extends Eloquent
{
	public $timestamps = false;
	protected $table = 'provinsi';
	protected $primaryKey = 'provinsi_id';
	protected $fillable = [
		'provinsi_nama',
	];

	public function dataKota()
	{
		return $this->hasMany(new M_Kota(), 'kota_provinsi_id','provinsi_id');
	}

}
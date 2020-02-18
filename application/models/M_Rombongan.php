<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Rombongan extends Eloquent
{
	public $timestamps = false;
	protected $table = 'rombongan';
	protected $primaryKey = 'rombongan_id';
	protected $fillable = [
		'rombongan_nama',
	];

	
	public function dataHaji()
	{
		return $this->hasMany(new M_Haji(), 'haji_rombongan_id','rombongan_id');
	}
}
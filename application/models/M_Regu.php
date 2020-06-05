<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Regu extends Eloquent
{
	public $timestamps = false;
	protected $table = 'regu';
	protected $primaryKey = 'regu_id';
	protected $fillable = [
		'regu_nama',
	];

	public function dataHaji()
	{
		return $this->hasMany(new M_Haji(), 'haji_regu_id','regu_id');
	}

}
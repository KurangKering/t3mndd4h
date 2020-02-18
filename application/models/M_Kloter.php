<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Kloter extends Eloquent
{
	public $timestamps = false;
	protected $table = 'kloter';
	protected $primaryKey = 'kloter_id';
	protected $fillable = [
		'kloter_nama',
	];

	public function dataHaji()
	{
		return $this->hasMany(new M_Haji(), 'haji_kloter_id','kloter_id');
	}

}
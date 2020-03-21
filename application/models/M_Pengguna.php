<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model as Eloquent;
class M_Pengguna extends Eloquent
{	
	public $timestamps = false;
	protected $table = 'pengguna';
	protected $primaryKey = 'pengguna_id';
	protected $fillable = [
		'pengguna_nama',
		'pengguna_username',
		'pengguna_password',
		'pengguna_akses',
		'parent_id',
	];
}
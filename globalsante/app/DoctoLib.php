<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctoLib extends Model
{
    //

    protected $table = 'tbl_doctor';


	public $timestamps = false;

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'sex',
		'birthdate',
		'title',
		'smartphone',
		'tablette',		
		'info',
		'photo',
		'phone',		
		'number_rpps',
		'number_inscription_ordre',
		'carte_vitale',
		'tiers_payant',
		'website',
		'id_convention'
	];


	// public function user(){
	// 	return $this->belongsTo('biomotion\User','user_id');

	// }
	// public function mission_client(){
		
	// 	return $this->belongsToMany('biomotion\Mission','fiche_client_id');

	// }
}

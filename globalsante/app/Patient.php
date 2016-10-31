<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = "tbl_patient";
    public $timestamps = false;
    protected $fillable = [
    	'id',
		'title',
		'name',
		'maiden_name',
		'first_name',
		'last_name',
		'mobile_phone',		
		'home_phone',
		'birthdate',
		'email',
		'email_confirmed',
		'password',
		'user_address',
		'accept_cgu',
		'cpcode',
		'quartier',
		'id_city',
		'id_insurance'
	];
}

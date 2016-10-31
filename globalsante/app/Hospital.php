<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    //
    protected $table = 'tbl_hospital';
     public $timestamps = false;
     protected $fillable = [
		'name_hospital',
		'address_hospital',
		'lat',
		'long',
		'tbl_doctor_id'
	];
}

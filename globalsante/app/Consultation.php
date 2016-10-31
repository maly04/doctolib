<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    //
    protected $table = "tbl_consultation";
    public $timestamps = false;
    protected $fillable = [
		'name',
		'datetime',
		'mail',
		'tbl_doctor_id'
	];
}

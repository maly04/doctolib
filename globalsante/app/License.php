<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
     //
    protected $table = "tbl_license";
    public $timestamps = false;
    protected $fillable = [
		'tbl_doctor_id',
		'payment',
		'payment_date',
		'payment_methode',
		'date_license_start',
		'date_license_end'
	];
}

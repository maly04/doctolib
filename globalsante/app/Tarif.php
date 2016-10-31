<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    //
    protected $table = "tbl_tarif";
    public $timestamps = false;
    protected $fillable = [
		'tarif_name',
		'price',
		'order',
		'tbl_doctor_id'
	];
}

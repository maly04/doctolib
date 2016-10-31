<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctoLibSpecialist extends Model
{
    //
     protected $table = 'tbl_spe_doc';
     public $timestamps = false;
     protected $fillable = [
		'tbl_specialties_id',
		'tbl_doctor_id'
	];
}

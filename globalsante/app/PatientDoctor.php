<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientDoctor extends Model
{
    //
    protected $table = "tbl_patient_doctor";
    public $timestamps = false;
    protected $fillable = [    
		'tbl_patient_pid',
		'tbl_doctor_id'
	];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoyenDoctor extends Model
{
    //
     protected $table = "tbl_moyen_paiement_doc";
    public $timestamps = false;
    protected $fillable = [
		'tbl_moyen_id',
		'tbl_doctor_id'
	];
}

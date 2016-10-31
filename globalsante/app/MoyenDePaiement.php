<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoyenDePaiement extends Model
{
    //
    protected $table = "tbl_moyen_paiement";
    public $timestamps = false;
    protected $fillable = [
		'moyen_name',
		'moyen_icon'
	];
}

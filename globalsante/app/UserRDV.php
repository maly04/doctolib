<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRDV extends Model
{
    //
    protected $table = "tbl_userrdv";
    public $timestamps = false;
    protected $fillable = [
		'prenom',
		'nom_usage',
		'mail',
		'password'
	];
}

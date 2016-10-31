<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    //
    protected $table = "tbl_motif";
    public $timestamps = false;
    protected $fillable = [
    	'id',
		'motif',
		'id_specialities'
	];
}

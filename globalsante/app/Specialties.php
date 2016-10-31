<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialties extends Model
{
    //
    protected $table = "tbl_specialties";
    public $timestamps = false;
    protected $fillable = [
		'name'
	];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    //
    protected $table = "tbl_insurance";
    public $timestamps = false;
    protected $fillable = [
		'id',
		'name'
	];
}

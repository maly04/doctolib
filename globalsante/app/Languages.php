<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    //
    protected $table = "tbl_language";
    public $timestamps = false;
    protected $fillable = [
		'language_name',
		'language_icon'
	];
}

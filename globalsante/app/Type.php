<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $table = "tbl_type";
    public $timestamps = false;
    protected $fillable = [
		'type_name',
		'icon'
	];
}

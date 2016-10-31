<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //
    protected $table = "tbl_carte";
    public $timestamps = false;
    protected $fillable = [
		'carte_name',
		'carte_icon'
	];
}

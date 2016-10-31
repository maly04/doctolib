<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $table = 'tbl_import';
     public $timestamps = false;
     protected $fillable = [
		'file_name',
		'comment',
		'type',
		'count',
		'status',
		'date'
	];

}

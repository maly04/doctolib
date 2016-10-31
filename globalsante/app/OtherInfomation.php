<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherInfomation extends Model
{
    //
    protected $table = "tbl_other_info_doc";
    public $timestamps = false;
    protected $fillable = [
		'type',
		'info',
		'tbl_doctor_id',
		'tbl_type_id'
	];
}

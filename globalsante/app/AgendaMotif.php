<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaMotif extends Model
{
    protected $table = "tbl_agenda_motif";
    public $timestamps = false;
    protected $fillable = [  
    	'id',  
		'id_agenda',
		'id_motif'
	];
}

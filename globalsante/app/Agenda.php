<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    //
    protected $table = "tbl_agenda";
    public $timestamps = false;
    protected $fillable = [
		'date_start',
		'date_end',
		'datetime_consultant',
		'id_motif',
		'duration',
		'id_patient',
		'origin',
		'tage',
		'notes',
		'repeat_active',
		'journee',
		'step',
		'motifcheck',
		'days',
		'frequency',
		'subject',
		'replacement',
		'description',
		'color',
		'id_meeting_type'
	];
}

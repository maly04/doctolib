<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    //

    protected $table = "tbl_ville";
    public $timestamps = false;
    protected $fillable = [
    	'ville_id',
    	'ville_departement',
		'ville_slug',
		'ville_nom',
		'ville_nom_simple',
		'ville_nom_reel',
		'ville_nom_soundex',
		'ville_nom_metaphone',
		'ville_code_postal',
		'ville_commune',
		'ville_code_commune',
		'ville_arrondissement',
		'ville_canton',
		'ville_amdi',
		'ville_population_2010',
		'ville_population_1999',
		'ville_population_2012',
		'ville_densite_2010',
		'ville_surface',
		'ville_longitude_deg',
		'ville_latitude_deg',
		'ville_longitude_grd',
		'ville_latitude_grd',
		'ville_longitude_dms',
		'ville_latitude_dms',
		'ville_zmin',
		'ville_zmax'

	];
}

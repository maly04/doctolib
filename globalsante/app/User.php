<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tbl_doctor';
    protected $primaryKey  = 'id';

    protected $fillable = [
       // 'name', 'email', 'password',
           'first_name',
            'last_name',
            'email',
            'password',
            'sex',
            'birthdate',
            'title',
            'smartphone',
            'tablette',     
            'info',
            'photo',
            'phone',        
            'number_rpps',
            'number_inscription_ordre',
            'carte_vitale',
            'tiers_payant',
            'website',
            'id_convention'

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword(){
        return $this->password;
    }
}

<?php
	namespace App;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Contracts\Auth\UserProvider;
	use Illuminate\Contracts\Auth\CanResetPassword;
	//use Illuminate\Auth\EloquentUserProvider as EloquentUserProvider;
	class UserPatient extends Authenticatable
	{
		protected $table = 'tbl_patient';
	    protected $primaryKey  = 'id';
	    protected $fillable = [
		    'title',
			'name',
			'maiden_name',
			'first_name',
			'last_name',
			'mobile_phone',		
			'home_phone',
			'birthdate',
			'email',
			'email_confirmed',
			'password',
			'user_address',
			'accept_cgu',
			'cpcode',
			'quartier',
			'id_city',
			'id_insurance'

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
?>
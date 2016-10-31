<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/





/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']], function () {
   Route::auth();
   Route::group(['middleware' => ['patient']], function () {
   		Route::controllers([
		 'auth' => 'PatientAuth\AuthController',
		 'password' => 'PatientAuth\PasswordController',
		]);
		Route::get('patient/password/reset', 'PatientAuth\AuthController@resetPassword');
	    Route::post('patient/password/email', 'PatientAuth\PasswordController@sendResetLinkEmail');

		Route::get('patient/password/reset/{token?}', 'PatientAuth\PasswordController@showResetForm');  
        Route::post('patient/password/reset', 'PatientAuth\PasswordController@reset');
	    
	});
	
	Route::get('/login','UserController@login');
	Route::post('/login','UserController@submitLogin');

	Route::post('/loginPatient','UserController@submitLoginPatient');
	

	Route::get('/signup','UserController@index');
	Route::post('/signup','UserController@signup');
	Route::post('/signupPatient','UserController@signupPatient');	
	Route::get('/logout','UserController@getLogout');
	Route::get('/loadform','UserController@loadform');

	Route::group(['prefix' => 'agenda'], function() {
		Route::get('/','UserController@useraccount');
	});
	Route::group(['prefix' => 'account'], function() {		
		Route::get('/appointments','UserController@patientrendezvous');
		Route::get('/profile','UserController@patientProfile');
		Route::post('/updateprofile','UserController@updatePatientProfile');
		Route::post('/patientPassword','UserController@patientPassword');
		Route::get('/cancelMetting','UserController@cancelMetting');
		
	});

	//Front end
   Route::group(['prefix' => 'recherche'], function() {
   		Route::post('/','FrontendController@search');	    
		Route::get('{sid}/{ville}/{spe_id}','DoctoLibController@searchreult'); 
		Route::get('{sp}/{vil}/{doctoName}/{doctoid}','DoctoLibController@doctoInfo');
		//Define route when select doctor name or hospital
		Route::get('{type}/{sp}/{doctoid}/{doctoName}/','DoctoLibController@searchDoctorAndHospital');
		Route::get('/doctor','DoctoLibController@autocompleteDoctor');

		
   });
    Route::group(['prefix' => 'details'], function() {
   		Route::get('/{id}/{special}/{nometprenom}','DoctoLibController@searchDoctorAndHospital');
    });

   Route::group(['prefix' => 'appointments'], function() {
   		Route::get('/{id}/{timestamp}','DoctoLibController@appointments');
		Route::get('/step1','DoctoLibController@sendsms');
		Route::get('/step2','DoctoLibController@validateConfirmCode');
		Route::get('/email_error','DoctoLibController@checkPatientCreateDate');
		Route::get('/resetPhoneNumber','DoctoLibController@resetPhoneNumber');
		Route::get('/update_phoneNumber','DoctoLibController@updatePhoneNumber');
		Route::get('/infoPatient','DoctoLibController@infoPatient');			
   });
    
	Route::get('/', 'FrontendController@index');
	Route::get('/autocomplete','FrontendController@autocomplete');
	Route::get('/searchnearby','FrontendController@searchnearby'); 

	// agenda
	Route::post('/consultant','AgendaController@submitConsultant');
	Route::get('/villeauto','AgendaController@villeAutocomplete');
	Route::get('/autopatient','AgendaController@patientAutocomplete'); 
	Route::post('/absence','AgendaController@submitAbsence');
	Route::post('/ouverture','AgendaController@submitouverture');

	Route::get('listagenda','AgendaController@agendaList');
	Route::get('aid','AgendaController@editagenda');

	Route::post('agendaedit','AgendaController@updateConsultant');

	Route::get('/agendadestroy','AgendaController@destroy');

	Route::get('/agendaAbsence','AgendaController@editagendaAbsence');
	Route::post('/agendaAbsence','AgendaController@updateAbsence');
	Route::get('/dragAgenda','AgendaController@dragAgendaById');
	Route::get('/deleteGcalendar','AgendaController@deleteGcalendar');
	Route::get('/savegoogleid','AgendaController@saveEventsId');	

	// Delete absence
	Route::get('/destroyAbsence','AgendaController@destroyAbsence');
	//ouverture
	Route::get('/ouvertureedit','AgendaController@editagendaOuverture');
	Route::post('/ouvertureedit','AgendaController@updateagendaOuverture');
	Route::get('/destroyOuverture','AgendaController@destroyOuverture');

	Route::group(['prefix' => 'configuration'], function() {
	 	//doctor profil
		Route::get('/mon-compte','ConfigurationController@moncompte');
		//upload photo
		Route::post('/uploadfile','ConfigurationController@uploadFile');
		Route::post('/updateprofile','ConfigurationController@updateprofil');
		Route::post('/lostpassword','ConfigurationController@lostpassword');
		//configuration partient
		Route::get('/patients','ConfigurationController@patients');
		Route::post('/createPatient','ConfigurationController@createPatient');
		Route::get('/editpatients','ConfigurationController@editPatient');
		Route::post('/updatePatient','ConfigurationController@updatePatient');
		Route::get('/destroypatients','ConfigurationController@destroyPatient');
		Route::get('/sendmail','ConfigurationController@sendmail');

	 });
	


	
	//Parameter page
	Route::group(['prefix' => 'parameters'], function() {
		Route::get('/agenda','ParametersController@showagenda');
		Route::get('/lieu_consultation','ParametersController@showLieu');
		Route::post('/lieu_consultation','ParametersController@submitHospital');
		Route::get('/informer_patients','ParametersController@showinformer');
		Route::get('/imports','ParametersController@importdonne');
		Route::get('/export','ParametersController@export');
		Route::post('/submitimport','ParametersController@submitimport');
		Route::post('/extrafield','ParametersController@submitextrafield');
		Route::get('/suprimmer_hospital','ParametersController@supprimerHospital');
		Route::get('/updateduration','ParametersController@updateduration');
		Route::get('/updatetime','ParametersController@updateOpeningTime');
		Route::get('/updatechk','ParametersController@updatecheckDay');
	});	
	Route::group(['prefix' => 'profil-global-sante'], function() {
		Route::get('/moyens-de-paiement','ProfilGlobalSanteController@index');

		Route::post('/moyens-de-paiement','ProfilGlobalSanteController@submitMoyens');

		Route::get('/formations','ProfilGlobalSanteController@formations');
		Route::post('/formations','ProfilGlobalSanteController@submitFormation');
		Route::get('/delete','ProfilGlobalSanteController@deleteoi');
		Route::get('/edit','ProfilGlobalSanteController@editoi');
		Route::get('/autres-informations','ProfilGlobalSanteController@autresInformations');
		Route::post('/autres-informations','ProfilGlobalSanteController@submitAutre');

		



		
	});
	
 

	//user confirmation
	Route::get('email/confirmation/{userType}/id/{userid}','UserController@userConfirm');
	Route::get('emails/message','UserController@emailMessage');
	Route::get('emails/messagePatient','UserController@emailMessagePatient');

});


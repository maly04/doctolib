<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator as Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\userRDV as User;
use App\DoctoLib as Doctor;
use App\Consultation as Consultation;
use App\Insurance as Insurance;
use App\Agenda as Agenda;
use App\Patient as Patient;
use App\Motif as Motif;

use App\Specialties as Specialties;
use App\SpecialityDoctor as SD;
use App\License as License;
use App\Hospital as Hospital;
use App\Ville as Ville;

use Session;
use Auth;
use DB;
use Hash;
use Mail;
use DateTime;
use Crypt;
use URL;

class UserController extends Controller
{
    //
	// public function __construct()
 //    {
 //        $this->middleware('auth');
 //    }
	public function index(){
		$specialties = Specialties::all();
		return view("user/signup",['specialties' => $specialties]);
	} 
	public function login(){
		$userid =Session::get('user-id');
		if (empty($userid)) {
			return view("user/login");
		}
		else{
			return redirect('/');
		}
		
	}
	public function submitLogin(Request $r){
		
		$email = $r->input("email");
		$pwd = $r->input("password");	

		$user = Validator::make($r->all(),[
			'email' => 'required|email',
	        'password' => 'required'

		]);
			if ($user->fails()){				
				echo "errors";
			}
			else{
					$findUser = Doctor::where("email","=",$email)->get()->first();
					if ($findUser != null) {
						if ($findUser->confirmed ==1) {
							if (Hash::check($pwd, $findUser->password)) {
								if($findUser->login_status == 1){
									$updatefirst = Doctor::findOrFail($findUser->id);
									$updatefirst->login_status = 0;
									$updatefirst->save();
									Session::put('user-email', $email);
									Session::put('user-id', $findUser->id);
									echo "firstlogin";
								}
								else{
									$userid = $findUser->id; 
									$getLicense = License::where("tbl_doctor_id","=",$userid)->get()->first();
									$today = (new DateTime())->format('Y-m-d');
									if (sizeof($getLicense) > 0) {
										if ($today >= $getLicense->date_license_start && $today <= $getLicense->date_license_end) {
											Session::put('user-email', $email);
											Session::put('user-id', $userid);
											echo "success";
										}
										else{
											echo "expireduser";
										}
									}
									else{
											echo "expireduser";
										}
										
								}	
		    										

							}
							else{
								echo 'errorsMsg';				

							}
						}
						else{
							echo 'errorsMsg';
						}
						
					}
					else{						
						echo 'errorsMsg';
					}
				
			}
	}
	public function submitLoginPatient(Request $r){
		$email = $r->input("email");
		$pwd = $r->input("password");
		$user = Validator::make($r->all(),[
				'email' => 'required|email',
		        'password' => 'required'

		]);

		if ($user->fails()){				
			echo "errors";
		}
		else{
			$findUser = Patient::where("email","=",$email)->get()->first();
			
			if (sizeof($findUser) > 0) {
				if (Hash::check($pwd, $findUser->password)) {
					if ($findUser->confirmed == 1) {
						Session::put('user-email', $email);
						Session::put('user-id', $findUser->id);
						Session::put('type', "patient");
						echo "success";
					}
					else{
						echo "0";
					}
					
				}
				else{

					echo "0";
				}
			}
			else{
				echo "0";
			}
			

		}

		
	}
	public function signup(Request $r){
		//case profestional submit		
		$nom = $r->input('nom');
		$prenom = $r->input('prenom');
		$cp = $r->input('cp');
		$tel = $r->input('tel');
		$speciality = $r->input("speciality");

		$email = $r->input('email');
		$pwd = Hash::make($r->input('pwd'));
		$comment = $r->input('comment');
		$datecreate = date('Y-m-d H:i');

			$doctor = Validator::make($r->all(),[
				'nom' => 'required',
		        'prenom' => 'required',
		        'cp' => 'required',
		        'email' => 'required|email',
		        'speciality' => 'required',
		        'pwd' => 'required',
		        'tel' => 'required'		        

			]);
			// dd($doctor);
			$x = "";
			
			if ($doctor->fails()){
				$x = "0";
				echo $x;
				exit();
			}
			$x = "1";
				// return redirect()->back()->withErrors($doctor->errors());
			
			if ($x != "0") {
				$statusEmail = Doctor::where("email",$email)->get()->first();
				if (sizeof($statusEmail) > 0) {
					//email already exists
					echo "2";
				}
				else{
					$doctors = new Doctor;
					$doctors->first_name = $nom;
					$doctors->last_name = $prenom; 
					$doctors->email = $email; 
					$doctors->password = $pwd;
					$doctors->info = $comment;
					$doctors->phone = $tel;					
					$doctors->cp = $cp; 
					$doctors->created_at = $datecreate;
					$doctors->login_status = 1;
					if ($doctors->save()){
						$did = $doctors->id;
						$sd = new SD;
						$sd->tbl_specialties_id = $speciality;
						$sd->tbl_doctor_id = $did;
						if ($sd->save()) {
							$getCurentUser = Doctor::findOrFail($did);
							$getSpe = Specialties::where("id","=",$speciality)->get()->first();
							//start send sent to admin
							Mail::send('emails.admin', ['user' => $getCurentUser,'speciality' => $getSpe], function ($m) use ($getCurentUser) {
			            		$m->from('contact@globalsante.fr', 'Global Santé');

			            		$m->to('contact@globalsante.fr', $getCurentUser->first_name.' '.$getCurentUser->last_name)->subject("Un nouvel utilisateur PRO vient de s'enregistrer");
			        		});				

							//generate url for confirmation	 						
			                $id_encrypted = Crypt::encrypt($did);
			                $url = url('email/confirmation/'.'pro/id/'.$id_encrypted);
							//start send email to user
							Mail::send('emails.professionel', ['url' => $url], function ($m) use ($getCurentUser) {
			            		$m->from('contact@globalsante.fr', 'Global Santé');

			            		$m->to($getCurentUser->email, $getCurentUser->first_name.' '.$getCurentUser->last_name)->subject("Veuillez confirmer votre inscription sur Global Santé");
			        		});

			        		$this->openingHourDoctor($did,$datecreate);								
							echo "success";							
									
						}				
					}
				}
					
			}
			
	}
	public function signupPatient(Request $r){
		$nom = $r->input('nom');
		$prenom = $r->input('prenom');
		$tel = $r->input("tel");
		$email = $r->input('email');
		$pwd = Hash::make($r->input('pwd'));
		$create_date = date("Y-m-d H:i:s");
		Session::put('pass', $r->input('pwd'));

			$user = Validator::make($r->all(), [	 
		        'nom' => 'required',
		        'prenom' => 'required',
		        'tel' => 'required',
		        'email' => 'required|email',
		        'pwd' => 'required'
    		]);

			$x = "";
	    	if ($user->fails()){
	    		$x = "0";
				echo $x;
				exit();
	    	}
	    	$x = "1";
			if ($x != "0") {
				$chkEmail = Patient::where("email","=",$email)->get()->first();
				if (sizeof($chkEmail) > 0) {
					//email already exists
					echo "2";
				}
				else{
					
					// $inputs = $r->all();
					// $inputs["first_name"] = $nom;
					// $inputs["last_name"] = $prenom;
					// $inputs["email"] = $email;
					// // $inputs["password"] = bcrypt($pwd);
					// $inputs["password"] = $pwd;
					// $inputs["mobile_phone"] = $tel;
					// $inputs["created_at"] = $create_date;						
					$users = new Patient;
					$users->first_name = $nom;
					$users->last_name = $prenom;
					$users->email = $email;
					$users->password = $pwd;
					$users->mobile_phone = $tel;
					$users->created_at = $create_date;



					if ($users->save()){
						$id = $users->id;
						//echo "<script>alert(".$id.");</script>";
							$getCurentUser = Patient::findOrFail($id);
							//start send sent to admin
							Mail::send('emails.user', ['user' => $getCurentUser], function ($m) use ($getCurentUser) {
			            		$m->from('contact@globalsante.fr', 'Global Santé');

			            		$m->to('contact@globalsante.fr', $getCurentUser->first_name.' '.$getCurentUser->last_name)->subject("Un nouvel utilisateur Patient vient de s'enregistrer");
			        		});				

							//generate url for confirmation							
			                $id_encrypted = Crypt::encrypt($id);
			                $url = url('email/confirmation/'.'patient/id/'.$id_encrypted);
							//start send email to user
							Mail::send('emails.patient', ['url' => $url], function ($m) use ($getCurentUser) {
			            		$m->from('contact@globalsante.fr', 'Global Santé');

			            		$m->to($getCurentUser->email, $getCurentUser->first_name.' '.$getCurentUser->last_name)->subject("Veuillez confirmer votre inscription sur Global Santé");
			        		});
								
							echo "success";
					}	
				}
	    		
	    	}
	}
	public function userConfirm($userType,$userid){
		$id_decrypte = Crypt::decrypt($userid);
		if ($userType == "pro") {
			$findDoc = Doctor::where("id","=",$id_decrypte)->get()->first();
			if ($findDoc->confirmed != 1) {
				$findUser = Doctor::findOrFail($id_decrypte);
				$findUser->confirmed = 1;
				$findUser->update();
				return redirect("/emails/message");				
				
				
			}
			else{
				return redirect("/emails/message");
			}
			
		}
		if ($userType == "patient") {
			//echo $id_decrypte;
			$findpat = Patient::where("id","=",$id_decrypte)->get()->first();
			//echo sizeof($findpat);
			if (sizeof($findpat) > 0) {
				if ($findpat->confirmed != 1) {
					$findUser = Patient::findOrFail($id_decrypte);
					$findUser->confirmed = 1;
					
					if ($findUser->update()) {
						$pass = Session::get("pass");;
						//start send email confirm password
						$info = Mail::send('emails.user_info', ['email' => $findpat->email,'password' => $pass ], function ($m) use ($findpat) {
		            		$m->from('contact@globalsante.fr', 'Global Santé');

		            		$m->to($findpat->email, $findpat->first_name.' '.$findpat->last_name)->subject("Création de votre compte sur Global Santé");
		        		});
		        		//if ($info) {
						//echo "true";
		        			return redirect("/emails/messagePatient");
		        		//}
					}
					
				}
				else{
					//echo "false";
					return redirect("/emails/messagePatient");
				}
			}
				
		}

	}
	public function emailMessage(){
		return view("emails/professionel_message");
	}
	public function emailMessagePatient(){
		return view("emails/patient_message");
	}
	public function useraccount(){
		 $type = Session::get('type');
		 $userid =Session::get('user-id');
		 if (!empty($userid)) {
		 	if (!empty($type)) {
		 		return redirect('/');
		 	}
		 	else{
				$motif_spe = DB::table('tbl_motif')				   
							   ->Join('tbl_specialties_motif','tbl_specialties_motif.id_motif', '=', 'tbl_motif.id')
							   ->Join('tbl_specialties','tbl_specialties.id', '=', 'tbl_specialties_motif.tbl_specialties_id')
							   ->Join('tbl_spe_doc','tbl_spe_doc.tbl_specialties_id', '=', 'tbl_specialties_motif.tbl_specialties_id')
							   ->where('tbl_spe_doc.tbl_doctor_id','=',$userid)
							   ->get();



				//Get Insurrence for user 
				$insurrence = Insurance::all();
				$eventConsultant =  DB::table('tbl_agenda')
						->select('tbl_agenda.id as aid','tbl_agenda.date_start','tbl_agenda.date_end','tbl_agenda.color','tbl_agenda.id_meeting_type','tbl_patient.first_name','tbl_patient.last_name')
					    //->leftJoin('tbl_doctor','tbl_doctor.id', '=', 'tbl_agenda.tbl_doctor_id')
					    //->Join('tbl_agenda_motif','tbl_agenda_motif.id_agenda', '=', 'tbl_agenda.id')				   
					   // ->Join('tbl_motif','tbl_motif.id', '=', 'tbl_agenda_motif.id_motif')
					   //->Join('tbl_motif','tbl_motif.id', '=', 'tbl_agenda.id_motif')
					   ->Join('tbl_patient','tbl_patient.id', '=', 'tbl_agenda.id_patient')					  
					   ->where('tbl_agenda.tbl_doctor_id','=',$userid)
					   ->get();
				
					 // DB::connection()->enableQueryLog();
					// $count_pid = Agenda::select( DB::raw('DAY(date_start) as d,count(id_patient) as pid'))
					// //->where('id_meeting_type','=',2) 
					// ->groupBy(DB::raw('DAY(date_start)'))
					// ->get();
				$count_pid  = DB::select('SELECT count(distinct id_patient) as pid,DAY(date_start) as d,WEEKDAY(date_start)+1 as weekinday,MONTH(date_start) as m,YEAR(date_start) as y FROM tbl_agenda where id_meeting_type = ? GROUP BY DAY(date_start)', [2] ); 
					//$count_pid_month  = DB::select('SELECT count(id_patient) as pid,DAY(date_start) as d,MONTH(date_start) as m,YEAR(date_start) as y FROM tbl_agenda where id_meeting_type = ? GROUP BY DAY(date_start),MONTH(date_start)', [2] );
				    // var_dump($count_pid);
					// var_dump($count_pid);
					 // $query = DB::getQueryLog();
					// print_r($query);
					// die();
				$getdoctor = Doctor::where('id','=',$userid)->get()->first();
				$hospital = DB::table("tbl_hospital")
	    				  ->select("tbl_hospital.id as hid","tbl_hospital.address_hospital as haddress","tbl_hospital.name_hospital as hname")
						  ->join('tbl_doctor','tbl_doctor.id','=','tbl_hospital.tbl_doctor_id')
			    	 	  ->where('tbl_doctor.id','=',$userid)
			    	 	  ->get();
		    	$event = DB::table('tbl_agenda')					   
					   ->where('tbl_agenda.tbl_doctor_id','=',$userid)
					   ->get();
				$patient =  DB::table("tbl_patient_doctor")
			    			->select('tbl_patient.id','tbl_patient.first_name','tbl_patient.last_name','tbl_patient.birthdate')
			    			->join('tbl_patient','tbl_patient_doctor.tbl_patient_pid','=','tbl_patient.id')
			    			->where('tbl_patient_doctor.tbl_doctor_id','=',$userid)
			    			->groupBy("tbl_patient.birthdate")
			    			->get();

					if (sizeof($event) > 0) {
					   return view("user/doctor",['doctorInfo'=> $getdoctor,'insurrence' => $insurrence,'userid' => $userid,'motif' => $motif_spe,'event' => $event,'evenCon' => $eventConsultant,'pcount' => $count_pid,'hospital' => $hospital,"patient" => $patient]);
					}
					else{
						 return view("user/doctor",['doctorInfo'=> $getdoctor,'insurrence' => $insurrence,'userid' => $userid,'motif' => $motif_spe,'event' => null,'evenCon' => $eventConsultant,'pcount' => $count_pid,'hospital' => $hospital,"patient" => $patient]);
					}  
			}		
			
		 }
		 else{
		 	return redirect('/login');
		 }
			
		
	}
	public function setUserId($id){
		Session::put('user-id', $id);
	}
	public function getLogout(){
        Auth::logout();
        Session::flush();
        return redirect('/login');
        //return Redirect::to('/');
        //return \View::make('home.index');
    }
    public function loadform(){	
		return view("user/doctorForm")->render();
	}

	//patient account
	public function patientrendezvous(){
		$userid = Session::get('user-id');
		 if (Session::has('type')) {
		 	if (!empty($userid)) {
		 		
		 		//meeting will be coming soon
		 		$rdv_info_a_venir = $this->rdvInfo($userid,'>',"venir");
		 		//metting in the past
		 		$rdv_a_pass = $this->rdvInfo($userid,'<=',"past");

		 		return view("user/mesRendezVous",["rdv_info"=>$rdv_info_a_venir,"rdv_pass"=>$rdv_a_pass]);
		 	}
		 	else{
		 		 return redirect('/login');
		 	}
		 }
		 else{
		 		 return redirect('/login');
		 }
		
	}
	public function cancelMetting(){
		$userid = Session::get('user-id');		
		$aid = $_GET["aid"];
		$date = $_GET["date"];
		$did = $_GET["did"];
		Agenda::destroy($aid);
		self::cancelEmail($did,$userid,$date);
		echo 1;
	}
	public function patientProfile(){
		$userid = Session::get('user-id');
		if (!empty($userid)) {			
			if (Session::has('type')) {
			 	if (!empty($userid)) {
			 		$getpatient = patient::where("id","=",$userid)->get()->first();
			 			if (!empty($getpatient->id_city)) {
					   		 $vile = Ville::where("ville_id","=",$getpatient->id_city)->get()->first();
						    	$getVille =  $vile->ville_id;
						    	$vileNom = $vile->ville_nom_reel;
					    }
					    else{
					    	$getVille = "";
					    	$vileNom = "";
					    }
					 //get title
				    $titleRadio1 = "";
				    $titleRadio2 = "";
				    if ($getpatient->title == "Mme") {
				    	# code...
				    	$titleRadio1 = "selected=selected";
				    }
				    if($getpatient->title == "M.") {
				    	$titleRadio2 = "selected=selected";
				    }
				    $getdate = array("","","");
				    if (!empty($getpatient->birthdate)) {
				    	$getdate = explode('-', $getpatient->birthdate);
				    }
					

			 		return view("user/monprofile",["patient"=>$getpatient,'nomville'=>$vileNom,'getDOB'=>$getdate,"title1"=>$titleRadio1,"title2"=>$titleRadio2]);
			 	}
			 	else{
			 		 return redirect('/login');
			 	}
			}
			else{
			 		 return redirect('/login');
			}
		}
		else{
		 		 return redirect('/login');
		}
		
	}
	public function updatePatientProfile(Request $r){
		$userid = Session::get('user-id');
		if (!empty($userid)) {
			$day = $r->input("day");
    		$month = $r->input("month");
    		$year = $r->input("year");    		
    		$realYear = $day."-".$month."-".$year;

    		$patient_check = Validator::make($r->all(),[
		        'email' => 'required|email'
			]);
			$x= 1;
			if ($patient_check->fails()){
				echo 0;
				$x = 0;
				exit();
			}
			if ($x == 1) {
				$pid = $userid;
				$partience = patient::findOrFail($pid);
		    	$partience->title =  $r->input("title");
		    	$partience->first_name =  $r->input("nom_de_famile");
		    	$partience->last_name =  $r->input("prenom");
		    	$partience->mobile_phone =  $r->input("mobilephone");
		    	$partience->birthdate =  $realYear;
		    	$partience->email =  $r->input("email");
		    	$partience->user_address =  $r->input("adresse");
		    	$partience->cpcode =  $r->input("cp");
		    	$partience->id_city =  $r->input("hidenvilleid");
			    	if ($partience->update()){
			    		echo 1;
			    	}
			}
			
		}
		else{
			return view("user/login",['loginerror' => '']);
		}
	}
	public function patientPassword(Request $r){
		$userid = Session::get('user-id');
		if (!empty($userid)) {
			if (Session::has('type')) {
			 	$newpwd = Hash::make($r->input("newpwd"));
				$updatepwd = patient::findOrFail($userid);
				$updatepwd->password = $newpwd;
				 if ($updatepwd->save()) {
		    		return  redirect()->action('UserController@patientProfile');	 	
				 } 
			}
		}
		else{
			return redirect('/login');
		}
		
	}
	public static function cancelEmail($did,$pid,$date){
		$getdoctor = Doctor::where("id","=",$did)->get()->first();
		$getpatient = patient::where("id","=",$pid)->get()->first();
		$subjectdate = DoctoLibController::generateDateSubjectEmail($date);

		//start send email to admin
		Mail::send('emails.appointments.cancel.doctor', ['doctor' => $getdoctor,'patient'=>$getpatient,"date_email"=>$subjectdate], function ($m) use ($getpatient,$getdoctor,$subjectdate) {
        		$m->from('contact@globalsante.fr', 'Global Santé');
        		$m->to($getdoctor->email, $getdoctor->first_name.' '.$getdoctor->last_name)->subject("Global Santé : Annulation de votre RDV du ".$subjectdate." avec le patient ".$getpatient->first_name." ".$getpatient->last_name);
    	});
    	//start send email to patient
    	Mail::send('emails.appointments.cancel.patient', ['doctor' => $getdoctor,'patient' => $getpatient,"date_email"=>$subjectdate], function ($m) use ($getpatient,$getdoctor,$subjectdate) {
    		$m->from('contact@globalsante.fr', 'Global Santé');

    		$m->to($getpatient->email, $getpatient->first_name.' '.$getpatient->last_name)->subject("Global Santé : Annulation de votre RDV du ".$subjectdate." avec le Dr ".$getdoctor->first_name);
		});

	}	
	protected function rdvInfo($userid,$sep,$type){
		//echo $userid;
		$getinfo = DB::table("tbl_agenda")
 				 ->select("tbl_patient.title as sex","tbl_patient.first_name as pnom","tbl_patient.last_name as pprenom","tbl_agenda.id as aid","tbl_doctor.first_name as dnom","tbl_doctor.last_name as dprenom","tbl_doctor.photo as dphoto","tbl_agenda.date_start as dstart","tbl_doctor.id as did")
 				 ->Join('tbl_doctor','tbl_agenda.tbl_doctor_id', '=', 'tbl_doctor.id')
 				 ->Join('tbl_patient','tbl_patient.id', '=', "tbl_agenda.id_patient")
 				 ->whereDate("tbl_agenda.date_start","$sep",date("Y-m-d H:m:i")) 	
 				 ->where("tbl_agenda.id_patient","=",$userid) 				 				 
 				 // ->groupBy("tbl_agenda.date_start")
 				 ->get();
 			// 	 echo "=================================<br>";
 			// 	 \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
 			// 	 	echo "<pre>";
				//     var_dump($query->sql);
				//     var_dump($query->bindings);
				//     var_dump($query->time);
 			// 	 	echo "</pre>";

				// });
 				 // echo "<pre>";
 					// var_dump($getinfo);
 				 // echo "</pre>";
 				 // 	$getinfo1 = DB::table("tbl_agenda")
 					// ->select("tbl_patient.title as sex","tbl_patient.first_name as pnom","tbl_patient.last_name as pprenom","tbl_agenda.id as aid","tbl_doctor.first_name as dnom","tbl_doctor.last_name as dprenom","tbl_doctor.photo as dphoto","tbl_agenda.date_start as dstart","tbl_doctor.id as did")
 				 // ->Join('tbl_doctor','tbl_agenda.tbl_doctor_id', '=', 'tbl_doctor.id')
 				 // ->Join('tbl_patient_doctor','tbl_patient_doctor.tbl_doctor_id', '=', 'tbl_agenda.tbl_doctor_id')
 				 // ->Join('tbl_patient','tbl_patient.id', '=', "tbl_patient_doctor.tbl_patient_pid")
 				 // ->whereDate("tbl_agenda.date_start","$sep",date("Y-m-d H:m:i")) 	
 				 // ->where("tbl_patient_doctor.tbl_patient_pid","=",$userid) 				 				 
 				 // ->groupBy("tbl_agenda.date_start")
 				 // ->get();
 				//dd($getinfo);


 				 // echo $getinfo;
 				$str_info = "";
 				if (sizeof($getinfo) > 0) {
 					foreach ($getinfo as $key) {
 					$photo = "default_logo.jpg";
 					if (!empty($key->dphoto)) {
 						$photo = $key->dphoto;
 					}
 					//get speciality
 					$getSpe = DB::table("tbl_specialties")
 							->select("tbl_specialties.name")
 							->join("tbl_spe_doc",'tbl_specialties.id', '=','tbl_spe_doc.tbl_specialties_id')
 							->where("tbl_spe_doc.tbl_doctor_id","=",$key->did)
 							->get();

 					$speciality = "";
 					if (sizeof($getSpe) >0 ) {
 						foreach($getSpe as $secial){
	 							$speciality .= $secial->name.",";
	 					}
 					}
 					
 					$sex = "<b>Patiente:</b>";
 					if($key->sex == "M."){
 						$sex = "<b>Patient:</b>";
 					}
 					//get hospital addresse with only the first one(will fix this latter)
 					$getHospital = Hospital::where("tbl_doctor_id","=",$key->did)->get()->first();
 					$haddress = "";
 					$hnumber = "";
 					if (sizeof($getHospital) > 0 ) {
 						$haddress = $getHospital->address_hospital;
 						$hnumber = $getHospital->number_cabinet;
 					}
 					$number_day = date('w', strtotime($key->dstart));
					$thday = date('d', strtotime($key->dstart));
					$str_month = date('m', strtotime($key->dstart));
					$str_year = date('Y', strtotime($key->dstart));
					$dayMonth = $thday." ".DoctoLibController::frenchMonth($str_month);
					$hour = date('H:i', strtotime($key->dstart));	
					$date_metting = $dayMonth .' '.$str_year." à ".$hour;
					$delete_str = "";
					if ($type != "past") {
						$delete_str = '
								<a class="cancel-rdv cancel" data-did = "'.$key->did.'" data-aid = "'.$key->aid.'" data-date="'.$key->dstart.'"><span class="glyphicon glyphicon-remove"></span> Annuler ce rendez-vous</a>
						';
					}
 					$str_info .= '
 						<div class="col-md-12 col-xs-12 col-sm-12 removemetting'.$key->aid.' mobile-form" >
 							<div class="col-md-3 col-xs-12 col-sm-12 mobile-form">
				 				<img src="'.url("/").'/img/uploads/'.$photo.'" id="default_photo"   class="img-profile img-responsive" alt='.$key->dnom.' '.$key->dprenom.'>
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12 mobile-form">
								<p>
									<span class="doctorname">'.$key->dprenom.' '.$key->dnom.' </span>
								</p>
								<p class="specialist">
									'.rtrim($speciality,',').'
								</p>
								<p>
									<span class="address">'.$haddress.'</span>
								</p>
								<p>
									<span class="phonenumber">'.$hnumber.'</span>
								</p>
								
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12 mobile-form">
								<p><span class="date-rdv">'.$date_metting.'</span></p>
								<p><span class="patient-name">
								'.$sex.'
								 '.$key->sex.' '.$key->pnom.' '.$key->pprenom.' </span></p>
								
							</div>
							<div class="col-md-3 col-xs-12 col-sm-12 mobile-form">
							'.$delete_str.'
							</div>
 						</div>
 						<div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>

 					';
 					}
 				}
 				else{
 					if ($type == "venir") {
 						$str_info = "<p class='nometting'>Vous n'avez pas encore pris de rendez-vous.</p><p class='rdvagain'><a href=".URL::to('/')." class='rdvagain'>Prenez un rendez-vous en ligne maintenant.</a></p>";
 					}
 					else{
 						$str_info = "<p class='nometting'>Il n'y a pas de rendez-vous passé.</p>";
 					}
 					
 				}
 				
 			return $str_info;
	}
	//create function for opening hours of doctor+++++Default insert after create doctor
	public function openingHourDoctor($id,$datecreate){
		$date = date('Y-m-d');
		$end  = '2020-12-31';
		$datestart = $date.' '.'8:00';
		$dateend = $end.' '.'17:00';		
		$day = '1000000';		
		$findRepeat = "jamais";
		$daycheck = 1;
		
		for($i=1;$i<=7;$i++){
			if ($i == 1) {
				$day = '1000000';
			}
			else if($i == 2){
				$day = '0100000';
			}
			else if($i == 3){
				$day = '0010000';
			}
			else if($i == 4){
				$day = '0001000';
			}
			else if($i == 5){
				$day = '0000100';
			}
			else if($i == 6){
				$daycheck = 0;
				$day = '0000010';
			}
			else if($i == 7){
				$daycheck = 0;
				$day = '0000001';
			}
			$agenda = new Agenda;
			$agenda->date_start = $datestart;
			$agenda->date_end = $dateend;
			$agenda->id_meeting_type = 4;
			$agenda->days = $day;
			$agenda->repeat_active = 1;
			$agenda->daycheck = $daycheck;
			$agenda->tbl_doctor_id = $id;
			$agenda->save();
		}
		




	}
}

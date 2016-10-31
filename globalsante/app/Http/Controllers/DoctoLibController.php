<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DoctoLib as doctoLib;
use App\Patient as patient;
use App\Specialties as Specialty;
use App\DoctoLibSpecialist as DS;
use App\Hospital as hospital;
use App\Ville as ville;
use App\Tarif as tarif;
use App\OtherInfomation as otherInfo;
use App\MoyenDePaiement as moyen;
use App\Languages as languages;
use App\Agenda as Agenda;
use App\PatientDoctor as PD;
use App\OtherInfomation as OI;
use App\MoyenDePaiement as MP;
use App\MoyenDoctor as MD;



// use DateInterval;
use DateTime;
use URL;
use Session;
use Hash;
use Response;
use Mail;

class DoctoLibController extends Controller
{
    
    public function index()
	{
		$getspe = Specialty::all();
		return view("doctoLib/index",["specialty" => $getspe]);
	}
	public function autocompleteDoctor(Request $r){
		$query = $r->get("q");
    	$results = array();
    	$search = DB::table("tbl_doctor")
    			->select('id', 'first_name','last_name')
    			->where('first_name', 'LIKE',  '%' . $query . '%')
    			->orwhere('last_name', 'LIKE',  '%' . $query . '%')
    			->get();
    			$url = "";
    			foreach ($search as $keysearch) {
    				$str =  $keysearch->first_name.' '.$keysearch->last_name;
    				$url = $this->urlSpecialCharacter($str);
    				$getspecialId = DS::where("tbl_doctor_id","=",$keysearch->id)->get()->first();
    				if (sizeof($getspecialId) > 0) {
    					$getspecial = Specialty::where("id","=",$getspecialId->tbl_specialties_id)->get()->first();
    					if (sizeof($getspecial) > 0) {
    						$url = $this->urlSpecialCharacter($getspecial->name).'/'.$this->urlSpecialCharacter($str);
    					}
    				}
    				
    				$results[] = ['url' => $url,'id' => $keysearch->id,'value' => $keysearch->first_name.' '.$keysearch->last_name];
    			}
    			//var_dump($search);
    			return Response::json($results);
	}
	public function searchreult($sid,$ville,$spe_id){
			
		$sepecialist_id = Specialty::all();	
		$vile = str_replace('-', ',', $ville);
		$vile = ucfirst(str_replace('e', 'é', str_replace('-', ',', $vile)));
		$arr_city = array();
		$getville = "";
		if(Session::has('getville'))
		{
			$getville = Session::get('getville');
		}
		if(Session::has('arr_city')){
			$arr_city = Session::get('arr_city');
		}
		// echo "<pre>";
		// var_dump($arr_city);
		// echo "</pre>";

		if (sizeof($arr_city) > 0) {
			$list_docto = DB::table('tbl_hospital')
			->select("tbl_doctor.id as did","tbl_doctor.first_name as first_name","tbl_doctor.last_name as last_name","tbl_specialties.name as name","tbl_specialties.name as name","tbl_hospital.address_hospital as address_hospital","tbl_hospital.name_hospital as name_hospital")
			->join('tbl_doctor', 'tbl_hospital.tbl_doctor_id','=', 'tbl_doctor.id')
	        ->join('tbl_spe_doc', 'tbl_doctor.id', '=', 'tbl_spe_doc.tbl_doctor_id')
	        ->join('tbl_specialties', 'tbl_specialties.id', '=', 'tbl_spe_doc.tbl_specialties_id')        
	        ->where('tbl_specialties.id', $spe_id)
	        // ->where('tbl_hospital.address_hospital','LIKE','%'.$getville.'%')
	        ->where(function ($q) use ($arr_city) {
				  foreach ($arr_city as $value) {
				    $q->orWhere('tbl_hospital.address_hospital', 'like', "%{$value}%");
				  }
			 })
	        ->groupBy("tbl_doctor.id")
	        ->get();

	      
        }
        else{
        	$list_docto = DB::table('tbl_hospital')
			->select("tbl_doctor.id as did","tbl_doctor.first_name as first_name","tbl_doctor.last_name as last_name","tbl_specialties.name as name","tbl_specialties.name as name","tbl_hospital.address_hospital as address_hospital","tbl_hospital.name_hospital as name_hospital")
			->join('tbl_doctor', 'tbl_hospital.tbl_doctor_id','=', 'tbl_doctor.id')
	        ->join('tbl_spe_doc', 'tbl_doctor.id', '=', 'tbl_spe_doc.tbl_doctor_id')
	        ->join('tbl_specialties', 'tbl_specialties.id', '=', 'tbl_spe_doc.tbl_specialties_id')        
	        ->where('tbl_specialties.id', $spe_id)
	        ->where('tbl_hospital.address_hospital','LIKE','%'.$vile.'%')
	        ->groupBy("tbl_doctor.id")
	        ->get(); 
        }
          
        $count_total = count($list_docto);  
		$getSpe = Specialty::where('id','=',$spe_id)->get()->first();
		
		// echo "<pre>";
		// var_dump($ville);
		// echo "</pre>";
		// die();
		//var_dump( $spe_id);  
		//echo $sid;
		if (sizeof($list_docto) > 0) {
			return view("doctoLib/index",["specialty" =>$sepecialist_id,"spec_id"=>$sid,"ville"=>$getville,"docto"=>$list_docto,"total_result"=>$count_total,"speName"=>$getSpe,'speid'=>$spe_id,'ville_link'=>$ville]);
		}
		else{
			return redirect()->back()->with('message', 'Il n\'y a pas de résultat pour votre recherche');
		}
		
		
	}
	public function setDoctorId($id){
		Session::put('doctor-id', $id);
	}
	public function doctoInfo($speciality,$ville,$dname,$did){
		$detailDoctor =  DB::table('tbl_doctor')
					  // ->leftJoin('tbl_spe_doc', 'tbl_doctor.id', '=', 'tbl_spe_doc.tbl_doctor_id')
					  ->leftJoin('tbl_tarif','tbl_tarif.tbl_doctor_id','=','tbl_doctor.id')
					  // ->leftJoin('tbl_hospital','tbl_hospital.tbl_doctor_id','=','tbl_doctor.id')
					  ->leftJoin('tbl_other_info_doc','tbl_other_info_doc.tbl_doctor_id','=','tbl_doctor.id')
					  ->leftJoin('tbl_language_doc','tbl_language_doc.tbl_doctor_id','=','tbl_doctor.id')
					  ->leftJoin('tbl_moyen_paiement_doc','tbl_moyen_paiement_doc.tbl_doctor_id','=','tbl_doctor.id')
					  ->where('tbl_doctor.id','=',$did)
					  ->groupBy("tbl_doctor.first_name")
					  ->get();
		$getSpecialist = DB::table('tbl_specialties')
					   ->leftJoin('tbl_spe_doc', 'tbl_spe_doc.tbl_specialties_id', '=', 'tbl_specialties.id')
					   ->where("tbl_spe_doc.tbl_doctor_id","=",$did)
					   ->get();

		$getHospital = hospital::where("tbl_doctor_id","=",$did)->get();
		$getFirstHospital = hospital::where("tbl_doctor_id","=",$did)->where("active","=",1)->get()->first();

		$formation = OI::where("tbl_doctor_id","=",$did)->where("tbl_type_id","=",1)->get();
		$autre = OI::where("tbl_doctor_id","=",$did)->where("tbl_type_id","=",2)->get();
		$moyens = DB::table("tbl_moyen_paiement")
				->select("tbl_moyen_paiement.name as name","tbl_moyen_paiement.id as id")
				->join('tbl_moyen_paiement_doc','tbl_moyen_paiement_doc.tbl_moyen_id','=','tbl_moyen_paiement.id')
				->where("tbl_moyen_paiement_doc.tbl_doctor_id","=",$did)
				->get();

		return view("doctoLib/detail",["doctor_info"=>$detailDoctor,"speciality" => $getSpecialist,"hospital" => $getHospital,"timeAvaliability" => $this->generateDoctoAvailability($did),"firstHospital" =>$getFirstHospital,'formation' => $formation,'autre' => $autre,'moyen' => $moyens]);

		// return view("doctoLib/detail",["doctor_info"=>$detailDoctor]);
	}

	public function searchDoctorAndHospital($id,$name){		
		$detailDoctor =  DB::table('tbl_doctor')
		  ->leftJoin('tbl_tarif','tbl_tarif.tbl_doctor_id','=','tbl_doctor.id')
		  ->leftJoin('tbl_other_info_doc','tbl_other_info_doc.tbl_doctor_id','=','tbl_doctor.id')
		  ->leftJoin('tbl_language_doc','tbl_language_doc.tbl_doctor_id','=','tbl_doctor.id')	
		  ->leftJoin('tbl_moyen_paiement_doc','tbl_moyen_paiement_doc.tbl_doctor_id','=','tbl_doctor.id')		  
		  ->where('tbl_doctor.id','=',$id)
		  ->groupBy("tbl_doctor.first_name")
		  ->get();

		$getSpecialist = DB::table('tbl_specialties')
					   ->leftJoin('tbl_spe_doc', 'tbl_spe_doc.tbl_specialties_id', '=', 'tbl_specialties.id')
					   ->where("tbl_spe_doc.tbl_doctor_id","=",$id)
					   ->get();

		  // echo "<pre>";
		  // var_dump($getSpecialist);
		  // echo "</pre>";
		$formation = OI::where("tbl_doctor_id","=",$id)->where("tbl_type_id","=",1)->get();
		$autre = OI::where("tbl_doctor_id","=",$id)->where("tbl_type_id","=",2)->get();
		$moyens = DB::table("tbl_moyen_paiement")
				->select("tbl_moyen_paiement.name as name","tbl_moyen_paiement.id as id")
				->join('tbl_moyen_paiement_doc','tbl_moyen_paiement_doc.tbl_moyen_id','=','tbl_moyen_paiement.id')
				->where("tbl_moyen_paiement_doc.tbl_doctor_id","=",$id)
				->get();
		$getHospital = hospital::where("tbl_doctor_id","=",$id)->where("active","=",1)->get();
		$getFirstHospital = hospital::where("tbl_doctor_id","=",$id)->where("active","=",1)->get()->first();

		return view("doctoLib/detail",["doctor_info"=>$detailDoctor,"speciality" => $getSpecialist,"hospital" => $getHospital,"timeAvaliability" => self::generateDoctoAvailability($id),"firstHospital" =>$getFirstHospital,'formation' => $formation,'autre' => $autre,'moyen' => $moyens ]);
		
	}
	public function appointments($id,$timestamp){
		$userid = Session::get('user-id'); 
		$usertype = Session::get('type'); 
		$getDocto = doctoLib::where("id","=",$id)
					  ->get()
					  ->first();
		$timestamp2Date = date('Y-m-d', $timestamp);
		$timestamp2DateTime = date('Y-m-d H:i:s', $timestamp);
		$str_date = $this->generateStringDay($timestamp2Date);
		$duration = $this->getDurationDoctor($id);	
		$getSession = array();			
		$getSession = patient::where("id","=",$userid)->get()->first();
		if (Session::has('type')) {	
			if (sizeof($getSession) > 0) {							
				if ($getSession->session == "step4") {
					//check date of patient 

					//start insert into agenda automatique
					$datestart = $timestamp2DateTime;
					$time_cal = explode(' ',$datestart);
					$time_result = strtotime($time_cal[1])+strtotime($duration);
					$hour = $time_result / 3600 % 24;    // to get hours
					$minute = $time_result / 60 % 60;    // to get minutes
					$second = $time_result % 60; 
			    	$dateend = $time_cal[0].' '.$hour.':'.$minute;

					$agenda = new Agenda;
					$agenda->date_start= $datestart;
					$agenda->date_end= $dateend;
					$agenda->duration = $duration;
					$agenda->id_patient = $userid;
					$agenda->ptype = "noveau";
					$agenda->id_meeting_type= "2";
					$agenda->tbl_doctor_id= $id;
					if ($agenda->save()) {
						//save into patient doctor
						$pd = new PD;
						$pd->tbl_patient_pid = $userid;
						$pd->tbl_doctor_id = $id;
						if ($pd->save()) {
							//send email
							$this->appointmentsEmail($id,$userid,"doctor",$timestamp);
							$this->appointmentsEmail($id,$userid,"patient",$timestamp);
							echo 1;

						}
						

						
					}

				}
				if (empty($getSession->session)) {
					$updateSession = patient::findOrFail($userid);

					//first create RDV
					if ($getSession->confirmed == 1 && empty($getSession->cpcode)) {
						$updateSession->session = "step2";						
						if ($updateSession->save()) {
							//start send sms
							$this->configSMS($userid,$getSession->mobile_phone);
						}					

					}
					else{
						//update sesstion = step4						
						$updateSession->session = "step4";
						$updateSession->save();						
						//start insert into agenda automatique
						$datestart = $timestamp2DateTime;
						$time_cal = explode(' ',$datestart);
						$time_result = strtotime($time_cal[1])+strtotime($duration);
						$hour = $time_result / 3600 % 24;    // to get hours
						$minute = $time_result / 60 % 60;    // to get minutes
						$second = $time_result % 60; 
				    	$dateend = $time_cal[0].' '.$hour.':'.$minute;

						$agenda = new Agenda;
						$agenda->date_start= $datestart;
						$agenda->date_end= $dateend;
						$agenda->duration = $duration;
						$agenda->id_patient = $userid;
						$agenda->ptype = "noveau";
						$agenda->id_meeting_type= "2";
						$agenda->tbl_doctor_id= $id;
						if ($agenda->save()) {
							//save into patient doctor
							$pd = new PD;
							$pd->tbl_patient_pid = $userid;
							$pd->tbl_doctor_id = $id;
							if ($pd->save()) {
								//send email
								$this->appointmentsEmail($id,$userid,"doctor",$timestamp);
								$this->appointmentsEmail($id,$userid,"patient",$timestamp);
								// echo 1;

							}
							

							
						}
					}
					
				}

			}
			$getSession = patient::where("id","=",$userid)->get()->first();

		}
		// echo "<pre>";
		// var_dump($getSession);
		// echo "</pre>";

		//echo $timestamp2DateTime;
			return view("doctoLib/appointments",["docto"=>$getDocto,"str_date"=>$str_date,"session"=>$getSession,"dataStart"=>$timestamp2DateTime]);
	
	}

	public function sendsms(){
		$getPhoneNumber = $_GET["phone"];
		$getEmail = $_GET["email"];
		$getPassword = Hash::make($_GET["password"]);
		$create_date = date("Y-m-d H:i:s");
		$err = "";
		if ($this->isEmailValid($getEmail) == 1) {
			$checkEmail = patient::where("email","=",$getEmail)->get();
			if (sizeof($checkEmail)>0) {
				//email already exists
				$err = 1;
			}
			else{
				//start insert into patient
				$newPatient = new patient;
				$newPatient->mobile_phone = $getPhoneNumber;
				$newPatient->email = $getEmail;
				$newPatient->password = $getPassword;
				$newPatient->created_at = $create_date;
				$newPatient->session = "step2";
				if ($newPatient->save()) {
					$id = $newPatient->id;


					//start send sms to mobile
					$this->configSMS($id,$getPhoneNumber);
					//store session
					Session::put('user-email', $getEmail);
					Session::put('user-id', $id);
					Session::put('type', "patient");
					$err = $id;
				}
			}
		}
		else{
			//error email format
			$err = 0;
		}
		return $err;
		// echo $getPhoneNumber."=>".$getEmail."=>".$getPassword;
	}
	
	public function validateConfirmCode(){
		$getPid = $_GET["pid"];
		$getCode = $_GET["code"];
		$getdid = $_GET["did"];
		$confirm = "";
		$findCode = patient::where("id","=",$getPid)
				  ->where("confirmed_code","=",$getCode)
				  ->get()
				  ->first();
		if (sizeof($findCode) > 0) {
			//code match
			$confirm =  1;
			$updateSession = patient::findOrFail($getPid);
			$updateSession->session = "step3";
			$updateSession->save(); 
			
		}
		else{
			//error
			$confirm = 0;
		}
		return $confirm;
	}
	public function checkPatientCreateDate(){
		$mail = $_GET["email"];
		$checkEmail = patient::where("email","=",$mail)->get()->first();
		$createDate = $this->generateEmailCreateDate($checkEmail->created_at);
		echo $createDate;
	}
	public function resetPhoneNumber(){
		$pid = $_GET["pid"];
		$findphone = patient::where("id","=",$pid)->get()->first();
		$html = '
				<h3>Renseignez votre numéro de téléphone</h3>
				<div class="form-group">
					<input type="hidden" value="'.$pid.'" id="getpid">
                    <input  maxlength="10" type="text" required="required" class="form-control" placeholder="Téléphone portable" id="phonenumberedit" value="'.$findphone->mobile_phone.'"/>
                    <span class="error_phone">Numéro de téléphone invalide</span>
                </div>
                <p class="txt-small">Pour plus de sécurité, vous allez recevoir un appel automatisé gratuit contenant un code temporaire.</p>
                <button class="btn btn-primary  form-control center-block custombtn resetbtn" type="button" >Vérifier mon numéro</button><br>

                <p class="txt-small">En cas de difficulté, vous pouvez nous appeler au 01 83 355 358.</p>
               
		';
	?>
		<script type="text/javascript">
			$(document).ready(function(e){
				$(".error_phone").hide();
				$("#phonenumberedit").on("change",function(e){
			        $(".error_phone").hide();
			        var phone = $(this).val();
			        var phonePattern = /^0[6-7]\d{8}$/g;
			        if (!phonePattern.test(phone)){
			            $(".error_phone").show();
			            $(".error_phone").css("color","red");
			            return false;
			        }

	   			});
	   			 $(".resetbtn").on("click",function(e){
	   			 	//alert(1);
		        	var phone = $("#phonenumberedit").val();
		        	var pid = $("#getpid").val();
		        	$.ajax({            
			           url: "/appointments/update_phoneNumber",
			           //url: "/doctoLib/public/index.php/appointments/update_phoneNumber",
			           type: "get",
			           data: "pid="+pid+"&phone="+phone,
			           success:function(res){
			           		window.location.reload();
			           }
			        }); 
		        });
			});
		</script>
	<?php
		echo $html;

	}
	public function updatePhoneNumber(){
		$pid = $_GET["pid"];
		$phone = $_GET["phone"];
		$updatePhone = patient::findOrFail($pid);
		$updatePhone->mobile_phone = $phone;
		if ($updatePhone->save()) {
			//start send sms
			$this->configSMS($pid,$phone);
			//store session
			Session::put('user-email', $updatePhone->email);
			Session::put('user-id', $pid);
			Session::put('type', "patient");
			

		}
		
	}
	public function infoPatient(){
		$pid = $_GET["pid"];
		$did = $_GET["did"];
		$sex = $_GET["sex"];
		$prenom = $_GET["prenom"];
		$nom_famile = $_GET["nom_famile"];
		$nomjeun = $_GET["nomjeun"];
		$dob = $_GET["date_str"];
		$address = $_GET["address"];
		$cp = $_GET["cp"];
		$ddurantion = $this->getDurationDoctor($did);
		$ville = $_GET["ville"];
		$datestart = $_GET["datestart"];
		$timestamp = strtotime($datestart);
		$time_cal = explode(' ',$datestart);
		$time_result = strtotime($time_cal[1])+strtotime($ddurantion);
		$hour = $time_result / 3600 % 24;    // to get hours
		$minute = $time_result / 60 % 60;    // to get minutes
		$second = $time_result % 60; 
    	$dateend = $time_cal[0].' '.$hour.':'.$minute;

		$updatePatient = patient::findOrFail($pid);
		$updatePatient->title = $sex;
		$updatePatient->first_name = $prenom;
		$updatePatient->last_name = $nom_famile; 
		$updatePatient->maiden_name = $nomjeun;
		$updatePatient->birthdate = $dob;
		$updatePatient->user_address = $address;
		$updatePatient->cpcode = $cp;
		$updatePatient->id_city = $ville;
		$updatePatient->confirmed = 1;
		$updatePatient->session = "step4";

		if ($updatePatient->save()) {
			//start insert data into agenda
			$agenda = new Agenda;
			$agenda->date_start= $datestart;
			$agenda->date_end= $dateend;
			$agenda->duration = $ddurantion;
			$agenda->id_patient = $pid;
			$agenda->ptype = "noveau";
			$agenda->id_meeting_type= "2";
			$agenda->tbl_doctor_id= $did;
			if ($agenda->save()) {
				//save into patient doctor
				$pd = new PD;
				$pd->tbl_patient_pid = $pid;
				$pd->tbl_doctor_id = $did;
				if ($pd->save()) {
					//send email
					$this->appointmentsEmail($did,$pid,"doctor",$timestamp);
					$this->appointmentsEmail($did,$pid,"patient",$timestamp);
					echo 1;
				}
				
			}
			
		}

	}
	protected function checkavailableTime($did,$pid,$timestamp){

	}
	protected function urlSpecialCharacter($str){
           $unwanted_array = array('Š'=>'s', 'š'=>'s', 'Ž'=>'z', 'ž'=>'z', 'À'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a', 'Å'=>'a', 'Æ'=>'a', 'Ç'=>'c', 'È'=>'e', 'É'=>'e',
                      'Ê'=>'e', 'Ë'=>'e', 'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i', 'Ñ'=>'n', 'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o', 'Ø'=>'o', 'Ù'=>'u',
                      'Ú'=>'u', 'Û'=>'u', 'Ü'=>'u', 'Ý'=>'y', 'Þ'=>'b', 'ß'=>'ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                      'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                      'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y',' et '=>'-',' a '=>'-',' h/f'=>'',' '=> '-',' hf'=>'',' H/F'=>'',' HF'=>'',' et/ou '=>'-',' & '=>'-','"'=>'','  '=>'-',' - '=>'','§§'=>'');
           

              $final = strtr($str, $unwanted_array);
              return strtolower($final);  
    }
   	protected function generateEmailCreateDate($d){
		$thday = date('d', strtotime($d));
		$str_month = date('m', strtotime($d));
		$str_year = date('Y', strtotime($d));		
		$str = 	$thday." ".self::frenchMonth($str_month)." ".$str_year;
		return $str;
	}

	public static function generateDoctoAvailability($id){
		// echo "fhjdfhgjdfhgj".$id;
		// die();
		//get doctor agenda		
		$agenda = Agenda::where("tbl_doctor_id","=",$id)
				->where("id_meeting_type","=",2)
				->whereDate("date_start",">=",date("Y-m-d"))
				->get();
		$arr_day = array();
		
		//define start date with current date and end date with date with limit
		$start = date("Y-m-d");
		$end = '2016-11-07';

		$num_days = floor((strtotime($end)-strtotime($start))/(60*60*24));
		$days = array();
		$timeAvailable = "";
		$timeAvailable_1 = "";
		$date_time_avalable = array();
		$arr_date = array();
		
		for ($i=0; $i<$num_days; $i++){
		    	array_push($days, date('Y-m-d', strtotime($start . "+ $i days")));
		}

		//To find the time and date already book for patient advoid book duplicate
		$arr_already_book_time = array();		 
		$usertype = Session::get('type');
		if (!empty($usertype)) {
			$userid = Session::get('user-id');
			$findPatientTime = DB::table("tbl_agenda")
							 ->select("tbl_agenda.date_start as dstart")
							 ->join("tbl_patient_doctor","tbl_patient_doctor.tbl_doctor_id","=","tbl_agenda.tbl_doctor_id")
							 ->where("tbl_patient_doctor.tbl_patient_pid","=",$userid)
							 ->whereDate("tbl_agenda.date_start",">=",date("Y-m-d H:m:i"))
							 ->get();
			

			foreach ($findPatientTime as $docto) {
				$newdatetime = date('Y-m-d H:i', strtotime($docto->dstart));
				array_push($arr_already_book_time,$newdatetime);
			}
		}
		//=========end finding=============//
		// echo "<pre>";
		// var_dump($agenda);
		// echo "</pre>";
		// die();

		//get time availability doctor set in setting
		// $arr_date_time = $this->finddurationOfDoctor($id," ");		
		
		// die();
		$arr_remove_duplicate = array();
		$arr_store_all_date = array();
		$arr_key = array();
		$arr_value = array();
		$arr_combine = array();
		$arr_store_date_time =[];
		// if (sizeof($agenda) > 0) {
			foreach ($agenda as $key) {
				$timestart = date("H:i",strtotime($key->date_start));
				$timeend = date("H:i",strtotime($key->date_end));
				$date = date("Y-m-d",strtotime($key->date_start));
				array_push($arr_date, $date);
				//push an array for store date as key and time as value	
				$arr_store_all_date[$date] = array($timestart,$timeend);
				array_push($arr_key, $date);
				array_push($arr_value, array("min"=>$timestart,"max"=>$timeend));

			}
		// }
		
		$arr_combine = self::array_combine_($arr_key, $arr_value);

		for ($j=0; $j < sizeof($days) ; $j++) { 
			$working_hour = "";
			$working_hour_1 = "";
			$str_working_hour = "";
			$url = "";
			//03-04-2026
			$url = URL::to('/appointments/'.$id);
			//remove unavalability time of doctor from table
			
			$arr = array();
			$new_arr = array();
			// echo "<pre>";
			// var_dump($arr_combine);
			// echo "</pre>";
			// die();
			$arr_date_time = self::finddurationOfDoctor($id,$days[$j]);
			foreach ($arr_combine as $key => $value) {
				
				// die();
				// echo $key."<br>";
				$voir = '<div class="dr-work-time">
							<a href="#" class="voir-plus">Voir Plus</a>
						</div>';
							
				// if (sizeof($arr_date_time) > 0) {										
					if ($key == $days[$j]) {
						for($i=0;$i<sizeof($value);$i++){
							$min = $value[$i]["min"];
							$max = $value[$i]["max"];
							if(in_array($min, $arr_date_time) && in_array($max, $arr_date_time)){
								$start = array_search($min, $arr_date_time);
								$end = array_search($max, $arr_date_time);
								for($t=$start;$t<=$end;$t++){
									unset($arr_date_time[$t]);
								}
							}
							else{
								// echo $min." => ".$max."<br>";
								$arr_date_time = self::removeTimeBetweenMinMax($arr_date_time,$min,$max);
								// die();
							}

						}
						$new_arr_date_time = array_values($arr_date_time);
						
						for($b=0;$b < sizeof($new_arr_date_time);$b++){
							$date_time = $days[$j].' '.$new_arr_date_time[$b];
							$timestamp = "";
							$timestamp = strtotime($days[$j].' '.$new_arr_date_time[$b]);					
								// check if time already book or not yet
								if (!in_array($date_time, $arr_already_book_time)) {
									if ($b<4) {
										$working_hour .= '
												<div class="dr-work-time">
													<a href="'.$url.'/'.$timestamp.'">'.$new_arr_date_time[$b].'</a>
												</div>';
									}
											
									if ($b>= 4) {								
										$working_hour .= '
													<div class="dr-work-time dr-work-time-hide">
														<a href="'.$url.'/'.$timestamp.'">'.$new_arr_date_time[$b].'</a>
													</div>
													';
									}
								}
							
						}
					
					}
				// }
				// else{
				// 	$working_hour .= '
				// 				<div class="dr-work-time">
				// 					<a href="">Not work</a>
				// 				</div>';
				// }
				// else{
				// 	for($i=0;$i<sizeof($value);$i++){
				// 		$min = $value[$i]["min"];
				// 		$max = $value[$i]["max"];						
				// 		if(in_array($min, $arr_date_time) && in_array($max, $arr_date_time)){
				// 			$start = array_search($min, $arr_date_time);
				// 			$end = array_search($max, $arr_date_time);
				// 			for($t=$start;$t<=$end;$t++){
				// 				unset($arr_date_time[$t]);
				// 			}
				// 		}
				// 		else{							
				// 			// $arr_date_time = $this->removeTimeBetweenMinMax($arr_date_time,$min,$max);

							
				// 		}						

				// 	}
				
					
				}

				
				
				
					
				
			// }	

		
		$arr_get_time = array();	

			// other day 
			if (!in_array($days[$j], $arr_date) ) {
				//get time availability doctor set in setting again
				$arr_date_time = self::finddurationOfDoctor($id,$days[$j]);
				if (sizeof($arr_date_time)>0) {					
					for($k=0;$k < sizeof($arr_date_time);$k++){
						$timestamp = "";
						$timestamp = strtotime($days[$j].' '.$arr_date_time[$k]);
						$date_time = $days[$j].' '.$arr_date_time[$k];
						//check if time already book or not yet
						if (!in_array($date_time, $arr_already_book_time)) {
							if ($k<4) {
								$working_hour .= '
									<div class="dr-work-time">
										<a href="'.$url.'/'.$timestamp.'">'.$arr_date_time[$k].'</a>
									</div>
									';
							}
							if ($k>=4) {
								$working_hour .= '
									<div class="dr-work-time dr-work-time-hide">
										<a href="'.$url.'/'.$timestamp.'">'.$arr_date_time[$k].'</a>
									</div>
									';
							}
						}
					}
				}//if arr_date_time >0
				else{
					$working_hour .= '
							<div class="dr-work-time">
								<a href="">Not work</a>
							</div>';
				}
			}
			
			if (sizeof($arr_date_time)>0) {
				$timeAvailable .= '
					<div>
						<div class="active eachday">
							<div class="day">
		    					'.self::generateDay($days[$j]).'
		    				</div>

		    				 <div class="working-hour">
								'.$working_hour.'
								<div class="dr-work-time">
									<a href="#" class="voir-plus">Voir Plus</a>
								</div>
								
							</div>
						</div>		        				
					</div>
				';	
			}
			else{
				$timeAvailable .= '
					<div>
						<div class="active eachday customeachday">
							<div class="day customday">
		    					'.self::generateDay($days[$j]).'
		    				</div>

		    				 <div class="working-hour">
		    				 
								
							</div>
						</div>		        				
					</div>
				';	
			}	
		}
		// echo "<pre>";
		// var_dump($timeAvailable);
		// echo "</pre>";
		// die();
		return $timeAvailable;
		// die();	
	}
	public static function removeTimeBetweenMinMax($arr,$min,$max){
		$new_array = array();
		$arr_result = array();
		foreach ($arr as $key) {
			array_push($new_array, strtotime($key));			
		}
		foreach ($new_array as $k) {
			if (!in_array(strtotime($min), $new_array)) {
				if (strtotime($k) > strtotime($min)) {
					$index = array_search($k, $new_array);
					array_splice( $new_array, $index, 0, strtotime($min) );
				}
			}
			if (!in_array(strtotime($max), $new_array)) {
				if ($k > strtotime($max)) {
					$index = array_search($k, $new_array);
					array_splice($new_array, $index, 0, strtotime($max));
				}
			}
		}


			// echo $min."ghjghj<br>";
			// echo $max."ghjhgj<br>";
			// echo $minIndex."ghjghj<br>";
			// echo $maxIndex."ghjhgj<br>";	
			// for($t=$minIndex;$t<=$maxIndex;$t++){				
			// 	unset($new_array[$t]);
			// }

		if (in_array(strtotime($min), $new_array) && in_array(strtotime($max), $new_array)) {
			$minIndex = array_search(strtotime($min), $new_array);
			$maxIndex = array_search(strtotime($max), $new_array);	
			for($t=$minIndex;$t<=$maxIndex;$t++){			
				unset($new_array[$t]);
			}
		}
		else{
			
		}		
		
		foreach ($new_array as $val) {
			$time = date("H:i",$val);
			array_push($arr_result, $time);
		}
			
		
		return $arr_result;
		
	}
	public static function frenchDay($d){
		$day = "";
		switch ($d) {
			case 0:
				$day = "dimanche";
				break;
			case 1:
				$day = "lundi";
				break;
			case 2:
				$day = "mardi";
				break;
			case 3:
				$day = "mercredi";
				break;
			case 4:
				$day = "jeudi";
				break;
			case 5:
				$day = "vendredi";
				break;
			case 6:
				$day = "samedi";
				break;
			
			default:
				break;
		}
		return $day;

	}
	public static function finddurationOfDoctor($id,$dateInDay){
		$arr_fun_doctor_duration = array();
		$arr_duration_mon = array();
		$arr_duration_tue = array();
		$arr_duration_wed = array();
		$arr_duration_thu = array();
		$arr_duration_fri = array();
		$arr_duration_sar = array();
		$arr_duration_sun = array();

		$number_day = date('w', strtotime( $dateInDay));
		$findAgendaDoctor = Agenda::where("tbl_doctor_id","=",$id)
						  ->where("id_meeting_type","=",4)->get();
		$findduration = doctoLib::where("id","=",$id)->get()->first();

		if (sizeof($findAgendaDoctor) > 0) {			

			foreach ($findAgendaDoctor as $k) {			
				$timestart = strtotime(date("H:i",strtotime($k->date_start)));
				$timeend  = strtotime(date("H:i",strtotime($k->date_end)));
				// echo $k->daycheck."=> $k->days<br>";


				if ($k->daycheck == 1) {
					if ($k->days == "1000000") {
						$arr_duration_mon = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);	
					}
					else if ($k->days == "0100000") {
						$arr_duration_tue = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);
					}
					else if ($k->days == "0010000") {
						$arr_duration_wed = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);
					}
					else if ($k->days == "0001000") {
						$arr_duration_thu = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);
						// echo "It is thursday => $timestart==== $timeend<br>";
						// echo date("H:i",$timestart)."<br>";
						// echo date("H:i",$timeend)."<br>";

						// echo "<pre>";
						// var_dump($arr_duration_thu);
						// echo "</pre>";
					}
					else if ($k->days == "0000100") {
						$arr_duration_fri = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);
						// echo "It is friday<br>";
						// echo "<pre>";
						// var_dump($arr_duration_fri);
						// echo "</pre>";

					}
					else if ($k->days == "0000010") {
						$arr_duration_sar = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);
					}
					else if ($k->days == "0000001") {
						$arr_duration_sun = self::calculationDuration($timestart,$timeend,$findduration->duree_creneau);
					}
				}
				
			}
			// die();
		}
			// 	echo "it is sunday.............<br>";
			// 	echo "<pre>";
			// 	var_dump($arr_duration_sun);
			// 	echo "</pre>";
			// 	echo "it is monday.............<br>";
			// 	echo "<pre>";
			// 	var_dump($arr_duration_mon);
			// 	echo "</pre>";
			// 	echo "it is tuesday.............<br>";
			// 	echo "<pre>";
			// 	var_dump($arr_duration_tue);
			// 	echo "</pre>";
			// 	echo "it is wednesday.............<br>";
			// 	echo "<pre>";
			// 	var_dump($arr_duration_wed);
			// 	echo "</pre>";
			// 	echo "it is thursday.............<br>";

			// 	echo "<pre>";
			// 	var_dump($arr_duration_thu);
			// 	echo "</pre>";
			// 	echo "it is friday.............<br>";

			// 	echo "<pre>";
			// 	var_dump($arr_duration_fri);
			// 	echo "</pre>";
			// 	echo "it is sartuday.............<br>";

			// 	echo "<pre>";
			// 	var_dump($arr_duration_sar);
			// 	echo "</pre>";
			// die();
		// echo $number_day."<br>";
		// die();
		if ($number_day == 0) {
			$arr_fun_doctor_duration = $arr_duration_sun;
		}
		if ($number_day == 1) {
			$arr_fun_doctor_duration = $arr_duration_mon;
		}
		if ($number_day == 2) {
			$arr_fun_doctor_duration = $arr_duration_tue;
		}
		if ($number_day == 3) {
			$arr_fun_doctor_duration = $arr_duration_wed;
		}
		if ($number_day == 4) {
			$arr_fun_doctor_duration = $arr_duration_thu;
		}
		if ($number_day == 5) {
			$arr_fun_doctor_duration = $arr_duration_fri;
		}
		if ($number_day == 6) {
			$arr_fun_doctor_duration = $arr_duration_sar;
		}
		
		

		return $arr_fun_doctor_duration;
	}
	public static function calculationDuration($timestart,$timeend,$duration){
		$arr_duration = array();
		while ($timestart<=$timeend) {
 			array_push($arr_duration, date("H:i",$timestart));
 			$timestart = $timestart+($duration*60);
 		}	
 		return $arr_duration;
	}
	public function getDurationDoctor($id){
		$findduration = doctoLib::where("id","=",$id)->get()->first();
		$doctor_duration = "";
		if ($findduration->duree_creneau == 30) {
			$doctor_duration = "00:30";
		}
		else if ($findduration->duree_creneau == 45) {
			$doctor_duration = "00:45";
		}
		else if($findduration->duree_creneau == 60){
			$doctor_duration = "01:00";
		}
		else{
			$doctor_duration = "00:15";
		}
		return $doctor_duration;
	}
	public static function frenchMonth($m){
		$month = "";		
		switch ($m) {
			case 1:
				$month = "janvier";
				break;
			case 2:
				$month = "février";
				break;
			case 3:
				$month = "mars";
				break;
			case 4:
				$month = "avril";
				break;
			case 5:
				$month = "mai";
				break;
			case 6:
				$month = "juin";
				break;
			case 7:
				$month = "juillet";
				break;
			case 8:
				$month = "août";
				break;
			case 9:
				$month = "septembre";
				break;
			case 10:
				$month = "octobre";
				break;
			case 11:
				$month = "novembre";
				break;
			case 12:
				$month = "décembre";
				break;
			
			default:
				# code...
				break;
		}
		return $month;
	}
	protected function configSMS($id,$phoneNumber){
		$myaccount=urlencode("takvikalou");
		$mypasswd=urlencode("123456789");
		// $random_code = md5(uniqid(rand(), true));
		// $random_code = substr(md5(uniqid(rand(), true)), 3, 3); 
		$random_code = mt_rand(100, 999);

		$sms_str = mb_convert_encoding("Bienvenue sur Global Santé ! Voici votre code de validation ".$random_code.". Vous devez le rentrer sur l'interface web pour confirmer votre RDV",'ISO-8859-1', 'auto');
		$mymsg = urlencode($sms_str);

		// $myto = "85595755536";
		// $myto = "85570483107";//vuthy
		// $myto = "85570394220";
		 //$myto = "85570394220";
		
		 //$myto = "85512284989";
		$myto = trim($phoneNumber);
		//$sms_title = mb_convert_encoding("Global Santé",'ISO-8859-1', 'auto'); 
		$myfrom=urlencode("GlobalSante");
		$route="G42";

		$sendsms = "http://imghttp.fortytwotele.com/api/current/send/message.php" . "?username=$myaccount" .
"&password=$mypasswd" . "&to=$myto" . "&from=$myfrom" . "&message=$mymsg" . "&route=$route";

		//dd($sendsms);
		$getsmsstatus=file($sendsms);
		// dd($getsmsstatus);
		$splitstatus = explode(",",$getsmsstatus[0]); 
		if ($splitstatus[0] == "1") {
			$msgid = trim($splitstatus[1]);
			$updateConfirm = patient::findOrFail($id);
			$updateConfirm->confirmed_code = $random_code;
			$updateConfirm->save();
			//echo "Message sent to gateway. smsid:" . $msgid;
		} else {
			$msgerror=trim($splitstatus[1]);
			echo "Couldn't send message. Errorcode:" . $msgerror;
		}

	}
	public static function appointmentsEmail($doctorid,$patientid,$type,$timestamp){
		$getdoctor = doctoLib::where("id","=",$doctorid)->get()->first();
		$getpatient = patient::where("id","=",$patientid)->get()->first();
		$date = date('Y-m-d H:i:s', $timestamp);
		$number_day = date('w', strtotime( $timestamp));
		$time = date('H:i', $timestamp);
		$subjectdate = self::generateDateSubjectEmail($date);
		$date_content = $subjectdate." à ".$time;
		$getHospital = hospital::where("tbl_doctor_id","=",$doctorid)->get();
		$address = "";
		$day=self::frenchDay($number_day);

		if (sizeof(sizeof($getHospital)>0)) {
			foreach ($getHospital as $key) {
				$address .= $key->name_hospital.' '.$key->address_hospital.',';
			}
			$address = rtrim($address,',');
		}
		
		if ($type == "doctor") {
			//start send to doctor
			Mail::send('emails.appointments.doctor', ['doctor' => $getdoctor,'patient'=>$getpatient,"date_email"=>$date_content,"address"=>$address], function ($m) use ($getpatient,$getdoctor,$subjectdate,$time,$day) {
			            		$m->from('contact@globalsante.fr', 'Global Santé');
			            		$m->to($getdoctor->email, $getdoctor->first_name.' '.$getdoctor->last_name)
			            		->subject("Global Santé : RDV le ".$day." ".$subjectdate." à ".$time." avec ".$getpatient->first_name." ".$getpatient->last_name);
			        		});
		}
		if ($type == "patient") {
			Mail::send('emails.appointments.patient', ['doctor' => $getdoctor,'patient' => $getpatient,"date_email"=>$date_content,"address"=>$address], function ($m) use ($getpatient,$getdoctor,$subjectdate,$time,$day) {
			            		$m->from('contact@globalsante.fr', 'Global Santé');
			            		$m->to($getpatient->email, $getpatient->first_name.' '.$getpatient->last_name)->subject("Global Santé : RDV le ".$day." ".$subjectdate." à ".$time." avec le docteur ".$getdoctor->first_name);
			        		});
		}

	}
	public static function generateDay($dateInDay){ 
		$number_day = date('w', strtotime( $dateInDay));
		$thday = date('d', strtotime( $dateInDay));
		$str_month = date('m', strtotime( $dateInDay));
		$dayOfweek = '';
		$dayMonth = $thday." ".self::frenchMonth($str_month);		
		$str = '<span class="day-of-week">'.self::frenchDay($number_day).'</span><br>'.$dayMonth;
		return $str;
		
	}
	protected function generateStringDay($dateInDay){
		$number_day = date('w', strtotime( $dateInDay));
		$thday = date('d', strtotime( $dateInDay));
		$str_month = date('m', strtotime( $dateInDay));
		$dayOfweek = '';
		$dayMonth = $thday." ".self::frenchMonth($str_month);		
		$str = self::frenchDay($number_day).' '.$dayMonth;
		return $str;
		
	}
	public static function generateDateSubjectEmail($dateInDay){
		$number_day = date('w', strtotime( $dateInDay));
		$thday = date('d', strtotime( $dateInDay));
		$str_month = date('m', strtotime( $dateInDay));
		$str_year = date('Y', strtotime( $dateInDay));
		$dayMonth = $thday." ".self::frenchMonth($str_month);		
		$str = $dayMonth.' '.$str_year;
		return $str;
	}
	
	protected function isEmailValid($email){
		//$email = test_input($oriemail);
		$emailErr = "";
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = 0;
		}
		else{
		  $emailErr = 1;
		}
		return $emailErr;
	}
	
	public function doctorTime(){
		return view("doctoLib/time");
	}
	public static function array_combine_($keys, $values){
	    $result = array();
	    foreach ($keys as $i => $k) {
	        $result[$k][] = $values[$i];
	    }
	    array_walk($result, create_function('&$v', '$v = (count($v) == 0)? array_pop($v): $v;'));
	    return    $result;
	}


}

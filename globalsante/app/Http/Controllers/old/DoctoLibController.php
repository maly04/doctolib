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
// use DateInterval;
use DateTime;
use URL;
use Session;
use Hash;

class DoctoLibController extends Controller
{
    //
    public function index()
	{
		$getspe = Specialty::all();
		return view("doctoLib/index",["specialty" => $getspe]);
	}
	public function searchreult($sid,$ville,$spe_id){		
		$sepecialist_id = Specialty::all();	
		$vile = str_replace('-', ',', $ville);
		$vile = ucfirst(str_replace('e', 'é', str_replace('-', ',', $vile)));


		$list_docto = DB::table('tbl_doctor')
        ->leftJoin('tbl_spe_doc', 'tbl_doctor.id', '=', 'tbl_spe_doc.tbl_doctor_id')
        ->leftJoin('tbl_specialties', 'tbl_specialties.id', '=', 'tbl_spe_doc.tbl_specialties_id')
        ->leftJoin('tbl_hospital', 'tbl_hospital.tbl_doctor_id','=', 'tbl_doctor.id')
        ->where('tbl_specialties.id', $spe_id)
        ->groupBy("tbl_doctor.first_name")
        ->get(); 
          
        $count_total = count($list_docto);  
		$getSpe = Specialty::where('id','=',$spe_id)->get()->first();
		//var_dump( $spe_id); 
		//echo $sid;
		return view("doctoLib/index",["specialty" =>$sepecialist_id,"spec_id"=>$sid,"ville"=>$vile,"docto"=>$list_docto,"total_result"=>$count_total,"speName"=>$getSpe,'speid'=>$spe_id,'ville_link'=>$ville]);
		
	}
	public function setDoctorId($id){
		Session::put('doctor-id', $id);
	}
	public function doctoInfo($speciality,$ville,$dname,$did){
		//$getid = $r->get("did");
		
		//echo $getid;
		//echo $speciality." ".$ville."Docto=>".$dname."ID=>".$did;
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

		return view("doctoLib/detail",["doctor_info"=>$detailDoctor,"speciality" => $getSpecialist,"hospital" => $getHospital,"timeAvaliability" => $this->generateDoctoAvailability($did)]);

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

		$getHospital = hospital::where("tbl_doctor_id","=",$id)->get();

		return view("doctoLib/detail",["doctor_info"=>$detailDoctor,"speciality" => $getSpecialist,"hospital" => $getHospital,"timeAvaliability" => $this->generateDoctoAvailability($id)]);
		
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
		$getSession = array();			
		$getSession = patient::where("id","=",$userid)->get()->first();
		if (Session::has('type')) {			
			if ($getSession->session == "step4") {
				//start insert into agenda automatique
				$datestart = $timestamp2DateTime;
				$time_cal = explode(' ',$datestart);
				$time_result = strtotime($time_cal[1])+strtotime("00:15");
				$hour = $time_result / 3600 % 24;    // to get hours
				$minute = $time_result / 60 % 60;    // to get minutes
				$second = $time_result % 60; 
		    	$dateend = $time_cal[0].' '.$hour.':'.$minute;

				$agenda = new Agenda;
				$agenda->date_start= $datestart;
				$agenda->date_end= $dateend;
				$agenda->duration = "00:15";
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
						echo 1;
					}
					
				}

			}

			

		}
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
		$ville = $_GET["ville"];
		$datestart = $_GET["datestart"];
		$time_cal = explode(' ',$datestart);
		$time_result = strtotime($time_cal[1])+strtotime("00:15");
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
			$agenda->duration = "00:15";
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
					echo 1;
				}
				
			}
			
		}

	}
	protected function generateEmailCreateDate($d){
		$thday = date('d', strtotime($d));
		$str_month = date('m', strtotime($d));
		$str_year = date('Y', strtotime($d));		
		$str = 	$thday." ".$this->frenchMonth($str_month)." ".$str_year;
		return $str;
	}

	protected function generateDoctoAvailability($id){
		//get doctor agenda		
		$agenda = Agenda::where("tbl_doctor_id","=",$id)
				//->where("tbl_doctor_id","=",$id)
				->whereDate("date_start",">=",date("Y-m-d"))
				->get();
		$arr_day = array();
		foreach ($agenda as $key) {
			$timestart = date("H:i",strtotime($key->date_start));
			$timeend = date("H:i",strtotime($key->date_end));
			$date = date("Y-m-d",strtotime($key->date_start));
			$getday = array($date =>$timestart,$date => $timeend);
			array_push($arr_day,$getday);
			//echo $date."==>".$timestart."=>".$timeend."<br>";

		}

		// echo "<pre>";
		// var_dump($arr_day);
		// echo "</pre>";



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
		$arr_date_time = array("9:00","9:15","9:30","9:45","10:00",
								"10:15","10:30","10:45","11:00",
								"11:15","11:30","11:45","12:00",
								"12:15","12:30","12:45","13:00",
								"13:15","13:30","13:45","14:00",
								"14:15","14:30","14:45","15:00",
								"15:15","15:30","15:45","16:00",
								"16:15","16:30","16:45","17:00");
		
		for ($j=0; $j < sizeof($days) ; $j++) { 
			// $arr_date_time = array(
			// 						$days[$j]=>"9:00",
			// 						$days[$j]=>"9:15",
			// 						$days[$j]=>"9:30",
			// 						$days[$j]=>"9:45",
			// 						$days[$j]=>"10:00",
			// 						$days[$j]=>"10:15",
			// 						$days[$j]=>"10:30",
			// 						$days[$j]=>"10:45",
			// 						$days[$j]=>"11:00",
			// 						$days[$j]=>"11:15",
			// 						$days[$j]=>"11:30",
			// 						$days[$j]=>"11:45",
			// 						$days[$j]=>"12:00",
			// 						$days[$j]=>"12:15",
			// 						$days[$j]=>"12:30",
			// 						$days[$j]=>"12:45",
			// 						$days[$j]=>"1:00",
			// 						$days[$j]=>"2:00",
			// 						$days[$j]=>"3:00",
			// 						$days[$j]=>"4:00",
			// 						$days[$j]=>"5:00"
			// 				);
			// array_push($date_time_avalable, $arr_date_time);

			$working_hour = "";
			$working_hour_1 = "";
			$str_working_hour = "";
			$url = "";
			
			$url = URL::to('/appointments/'.$id);
			//remove unavalability time of doctor from table
			foreach ($agenda as $key) {
				$timestart = date("H:i",strtotime($key->date_start));
				$timeend = date("H:i",strtotime($key->date_end));
				$date = date("Y-m-d",strtotime($key->date_start));
				array_push($arr_date, $date);
				$voir = '<div class="dr-work-time">
							<a href="#" class="voir-plus">Voir Plus</a>
						</div>';
				
				if ($date == $days[$j]) {
				//echo 1;					
					for($k=0;$k < sizeof($arr_date_time);$k++){
						if ( $arr_date_time[$k] != $timeend && $arr_date_time[$k] != $timestart) {
							//$k++;
							$timestamp = "";
							$timestamp = strtotime($days[$j].' '.$arr_date_time[$k]);
							if ($k<6) {
								$working_hour .= '
										<div class="dr-work-time">
											<a href="'.$url.'/'.$timestamp.'">'.$arr_date_time[$k].'</a>
										</div>';
							}
							
							if ($k > 6) {								
								$working_hour .= '
											<div class="dr-work-time dr-work-time-hide">
												<a href="'.$url.'/'.$timestamp.'">'.$arr_date_time[$k].'</a>
											</div>
											';
							}	
							
						}
						
						
					}//end loop
					
				}
				

			}
			//other day 
			if (!in_array($days[$j], $arr_date) ) {
					for($k=0;$k < sizeof($arr_date_time);$k++){
						$timestamp = "";
						$timestamp = strtotime($days[$j].' '.$arr_date_time[$k]);
						if ($k<6) {
							$working_hour .= '
								<div class="dr-work-time">
									<a href="'.$url.'/'.$timestamp.'">'.$arr_date_time[$k].'</a>
								</div>
								';
						}
						if ($k>6) {
							$working_hour .= '
								<div class="dr-work-time dr-work-time-hide">
									<a href="'.$url.'/'.$timestamp.'">'.$arr_date_time[$k].'</a>
								</div>
								';
						}
					}
			}

			$timeAvailable .= '
				<div>
					<div class="active eachday">
						<div class="day">
	    					'.$this->generateDay($days[$j]).'
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
		// echo "<pre>";
		// var_dump($date_time_avalable);
		// echo "</pre>";

		return $timeAvailable;
	}
	
	protected function frenchDay($d){
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
	protected function frenchMonth($m){
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
		$myaccount=urlencode("seamaly");
		$mypasswd=urlencode("123456Maly");
		// $random_code = md5(uniqid(rand(), true));
		// $random_code = substr(md5(uniqid(rand(), true)), 3, 3); 
		$random_code = mt_rand(100, 999);

		$sms_str = mb_convert_encoding("Bienvenue sur Global Santé ! Voici votre code de validation ".$random_code.". Vous devez le rentrer sur l'interface web pour confirmer votre RDV",'ISO-8859-1', 'auto');
		$mymsg = urlencode($sms_str);

		// $myto = "85595755536";
		$myto = "85516998240";
		$sms_title = mb_convert_encoding("Global Santé",'ISO-8859-1', 'auto'); 
		$myfrom=urlencode($sms_title);
		$route="G42";

		$sendsms = "http://imghttp.fortytwotele.com/api/current/send/message.php" . "?username=$myaccount" .
"&password=$mypasswd" . "&to=$myto" . "&from=$myfrom" . "&message=$mymsg" . "&route=$route";

		$getsmsstatus=file($sendsms);
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
	protected function generateDay($dateInDay){
		$number_day = date('w', strtotime( $dateInDay));
		$thday = date('d', strtotime( $dateInDay));
		$str_month = date('m', strtotime( $dateInDay));
		$dayOfweek = '';
		$dayMonth = $thday." ".$this->frenchMonth($str_month);		
		$str = '<span class="day-of-week">'.$this->frenchDay($number_day).'</span><br>'.$dayMonth;
		return $str;
		
	}
	protected function generateStringDay($dateInDay){
		$number_day = date('w', strtotime( $dateInDay));
		$thday = date('d', strtotime( $dateInDay));
		$str_month = date('m', strtotime( $dateInDay));
		$dayOfweek = '';
		$dayMonth = $thday." ".$this->frenchMonth($str_month);		
		$str = $this->frenchDay($number_day).' '.$dayMonth;
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

}

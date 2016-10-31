<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as Validator;

use App\Patient as Patient;
use App\Motif as Motif;
use App\Ville as Ville;
use App\Agenda as Agenda;
use App\PatientDoctor as PD;
use App\Insurance as Insurance;
use App\AgendaMotif as AgendaMotif;
use App\Hospital as Hospital;
use App\DoctoLib as Doctor;

use DB;
use Response;
use Session;
use DateTime;
use Mail;

class AgendaController extends Controller
{
    //

    public function submitConsultant(Request $r){
    	$horaire = $r->input("dhour");
    	//$motif = $r->input("motif");
    	$duration = $r->input("duration");
    	$hiddendate = $r->input("hiddendate");
    	// $typepatient = $r->input("chkpatient");
    	$typepatient = "exist";

    	$lieu_rdv = $r->input("lieu_rdv");
    	$origin = $r->input("origin");
    	$tage = $r->input("tags");
    	$note = $r->input("note");

    	$userid = $r->input("userid");

    	$time_cal = explode(' ', $horaire);
		$time_result = strtotime($time_cal[1])+strtotime($duration);
		$hour = $time_result / 3600 % 24;    // to get hours
		$minute = $time_result / 60 % 60;    // to get minutes
		$second = $time_result % 60; 

    	$dateEnd = $time_cal[0].' '.$hour.':'.$minute;
    	$getpid = "";

    	// if ($typepatient == "noveau") {
    	// 	//Starting get value for patient
    	// 	//get birtdate
    	// 	$day = $r->input("day");
    	// 	$month = $r->input("month");
    	// 	$year = $r->input("year");    		
    	// 	$realYear = $day."-".$month."-".$year;

	    // 	$title = $r->input("title");
	    // 	$nom_de_famile = $r->input("nom_de_famile");
	    // 	$prenom = $r->input("prenom");
	    // 	$nom_jeun_file = $r->input("nom_jeun");
	    // 	$tel_portable = $r->input("tel_portable");
	    // 	$email_patient = $r->input("email_patient");
	    // 	$tel_fix = $r->input("tel_fix");
	    // 	$birthdate = $realYear;
	    // 	// $password = $r->input("password");
	    // 	$adress = $r->input("adresse");
	    // 	$cp = $r->input("cp"); 
	    // 	$insurent = $r->input("insurent");
	    // 	$quartier = $r->input("quartier");
	    // 	$city = $r->input("hidenvilleid");
	    // 	//end partient
	    // 	$checkUser = DB::table("tbl_patient_doctor")
    	// 		->select('tbl_patient.email')
    	// 		->join('tbl_patient','tbl_patient_doctor.tbl_patient_pid','=','tbl_patient.id')
    	// 		->where('tbl_patient_doctor.tbl_doctor_id','=',$userid)
    	// 		->where('tbl_patient.email','=',$email_patient)->get(); 
	    // 	$checkpatientallDocto = Patient::where("email","=",$email_patient)->get()->first();
	    // 	if (sizeof($checkUser) > 0) {
	    // 		echo "0";
	    // 		exit();
	    // 	}
	    // 	else if(sizeof($checkpatientallDocto) > 0){
	    // 		//send email confirm RDV
	    // 		// DoctoLibController::appointmentsEmail($userid,$checkpatientallDocto->id,"patient",strtotime($horaire));

	    // 	}
	    // 	else{
	    // 		$partience = new Patient;
		   //  	$partience->title =  $title;
		   //  	$partience->first_name =  $nom_de_famile;
		   //  	$partience->maiden_name =  $nom_jeun_file;
		   //  	$partience->last_name =  $prenom;
		   //  	$partience->mobile_phone =  $tel_portable;
		   //  	$partience->home_phone =  $tel_fix;
		   //  	$partience->birthdate =  $birthdate;
		   //  	$partience->email =  $email_patient;
		   //  	// $partience->password =  $password;
		   //  	$partience->user_address =  $adress;
		   //  	$partience->cpcode =  $cp;
		   //  	$partience->quartier = $quartier;
		   //  	$partience->id_city =  $city;
		   //  	$partience->id_insurance =  $insurent;
		   //  	$partience->save();
		   //  	$getpid = $partience->id;
		   //  	//send reset password email
		   //  	$this->sendResetPasswordLinkToPatient($userid,$getpid,$horaire);
	    // 	}
	    	
    	// }
    	// else{
    		$getpid = $r->input("hiddepid");
    		$day = $r->input("day");
    		$month = $r->input("month");
    		$year = $r->input("year");    		
    		$realYear = $day."-".$month."-".$year;
    		
    		// echo $r->input("nom_de_famile")."<br>";
    		// die();
    		$partience = Patient::findOrFail($getpid);
	    	$partience->title =  $r->input("title");;
	    	$partience->first_name =  $r->input("nom_de_famile");
	    	$partience->maiden_name = $r->input("nom_jeun");
	    	$partience->last_name =  $r->input("prenom");;
	    	$partience->mobile_phone =  $r->input("tel_portable");
	    	$partience->home_phone =  $r->input("tel_fix");
	    	$partience->birthdate =  $realYear;
	    	$partience->email =  $r->input("email_patient");
	    	// $partience->password =  $r->input("password");
	    	$partience->user_address =  $r->input("adresse");
	    	$partience->cpcode =  $r->input("cp");
	    	$partience->quartier = $r->input("quartier");
	    	$partience->id_city =  $r->input("hidenvilleid");
	    	$partience->id_insurance =  $r->input("insurent");
		    $partience->update();
		    //send the confirm email to patient
		    DoctoLibController::appointmentsEmail($userid,$getpid,"patient",strtotime($horaire));

    	// }

		$agenda = new Agenda;
		$agenda->date_start= $horaire;
		$agenda->date_end= $dateEnd;
		$agenda->duration = $duration;
		$agenda->id_patient = $getpid;
		$agenda->ptype = $typepatient;
		$agenda->origin = $origin;
		$agenda->lieu_rdv = $lieu_rdv;
		$agenda->tage= $tage;
		$agenda->notes= $note;
		$agenda->id_meeting_type= "2";
		$agenda->tbl_doctor_id= $userid;
		$agenda->save();

		//save data into table tbl_patient_doctor

		$pd = new PD;
		$pd->tbl_patient_pid = $getpid;
		$pd->tbl_doctor_id = $userid;

		$agendaid = $agenda->id;
		if ($pd->save()) { 
	
			$getpatient = Patient::where('id','=',$getpid)->get()->first();
			$pname = $getpatient->first_name.' '.$getpatient->last_name;
			//return redirect()->action('UserController@useraccount');
			$datetimestart = new DateTime($horaire);
			$dstart =  $datetimestart->format(DateTime::ISO8601);

			$datetimeend = new DateTime($dateEnd);
			$dateend =  $datetimeend->format(DateTime::ISO8601);
			$getlocation = Hospital::where("id","=",$lieu_rdv)->get()->first();
			$description = "";
			if (!empty($getpatient->home_phone)) {
				$description = $getpatient->first_name.' '.$getpatient->last_name."\r\n"
							.$getpatient->email."\r\n"
							.$getpatient->mobile_phone.' - '.$getpatient->home_phone."\r\n"
							.'Note : '.$note."\r\n";
			}
			else{
				$description = $getpatient->first_name.' '.$getpatient->last_name."\r\n"
							.$getpatient->email."\r\n"
							.$getpatient->mobile_phone."\r\n"
							.'Note : '.$note."\r\n";
			}
			$locate = " ";
			if (!empty($getlocation->address_hospital)) {				
				$locate = $getlocation->address_hospital;
			}


			echo $dstart.'|'.$dateend.'|'.$pname.'|'.$agendaid.'|'.$locate.'|'.$description;

		}

    }

    public function submitAbsence(Request $r){
    	//get data from request
    	$dateStat = $r->input("absence_start");
    	$dateEnd = $r->input("absence_end");


    	$obj = $r->input("obj");
    	$note = $r->input("note");
    	$userid = $r->input("userid");
    	
    	if (empty($r->input("color"))) {
    		$color = "#cccccc";
    	}
    	else{
    		$color = $r->input("color");
    	}

    	//check journee
    	$journee = $r->input("journee");

    	//0 = non; 1 = oui
    	$repete = $r->input("chkon");

    	//start get value from absence clock
		$absenceClock = $r->input("absence-clock");
		$absenceClockFin = $r->input("absence-clock-fin");

		//In case repeat = 1
		$absencetimeinput = $r->input("absencetimeinput");
		$time_clock_start = $r->input("time_clock_start");
		$time_clock_fin = $r->input("time_clock_fin");

		//Day
		$days = "0000000";
		$getDateLe = "";
		//get semaines
	    $semaines = $r->input("semaines");
	    $absenceDateStart = "";
	    $absenceDateEnd = "";
	    $agenda = new Agenda;
    	//generall insert
    	if ($journee != "on" && $repete =="0") {
	    	//modify date
	    	$absenceDateStart = $dateStat.' '.$absenceClock;
	    	$absenceDateEnd = $dateEnd.' '.$absenceClockFin;
		}
		else if ($journee == "on" && $repete =="0") {
			$absenceDateStart = $dateStat.' '.'00:00';
	    	$absenceDateEnd = $dateEnd.' '.'00:00';
		}
		else if ($repete == "1" ) {
			# code...
			$absenceDateStart = $absencetimeinput.' '.$time_clock_start;
	    	$absenceDateEnd = $absencetimeinput.' '.$time_clock_fin;

	    	$chk = $r->input("chk");
	    	$days = "0000000";
	    	$inputday = "0000000";
	    	if (sizeof($chk) > 0) {
	    		$days = array_sum($chk);
	    		if (strlen($days)<7) {
	    			if (strlen($days) == 6) {
	    				$inputday = "0".$days;
	    			}
	    			else if (strlen($days) == 5) {
	    				$inputday = "00".$days;
	    			}
	    			else if (strlen($days) == 4) {
	    				$inputday = "000".$days;
	    			}
	    			else if (strlen($days) == 3) {
	    				$inputday = "0000".$days;
	    			}
	    			else if (strlen($days) == 2) {
	    				$inputday = "00000".$days;
	    			}
	    			else if (strlen($days) == 1) {
	    				$inputday = "000000".$days;
	    			}
	    		}
	    		else{
	    			$inputday = $days;
	    		}
	    		
	    	}
	    	else{
	    		$inputday = $days;
	    	}
	    	$radiojamaia = $r->input("jamain");

	    	if ($radiojamaia == "le") {
	    		# code...
	    		$getDateLe = $r->input("le");
	    	}
	    	else{
	    		$getDateLe = "jamais";
	    	}

	    	//case repete = 1
			$agenda->days = $inputday;
			$agenda->fin_repete = $getDateLe;
			$agenda->semaines = $semaines;

		}

			
			$agenda->date_start = $absenceDateStart;
			$agenda->date_end = $absenceDateEnd;

			$agenda->repeat_active = $repete;
			$agenda->journee = $journee;
			$agenda->subject = $obj;
			$agenda->notes= $note;
			$agenda->tbl_doctor_id = $userid;
			$agenda->id_meeting_type= "3";
			$agenda->color = $color;

			
			if ($agenda->save()) {
				# code...
				return redirect()->action('UserController@useraccount');
			}

    }

    public function submitouverture(Request $r){

    	$ouverturedatehour = $r->input("ouverturedatehour");
    	$ouverture_clock_start = $r->input("ouverture_clock_start");
    	$ouverture_clock_fin = $r->input("ouverture_clock_fin");

    	$datestart = $ouverturedatehour.' '.$ouverture_clock_start;
    	$dateend = $ouverturedatehour.' '.$ouverture_clock_fin;


    	$radiocheck = $r->input("radiocheck");
    	$step = $r->input("un_duration");
    	$remplacant = $r->input("remplacant");
    	$description = $r->input("description");
    	$ouvertColor = $r->input("ouvertColor");
    	$userid = $r->input("userid");
    	//$motif_chk = $r->input("motif_chk");
    	//var_dump($motif_chk);

    	$agenda = new Agenda;
    	$agenda->date_start = $datestart;
		$agenda->date_end = $dateend;
		if (!empty($step)) {
			$agenda->step = $step;
		}
		
		//$agenda->motifcheck = $radiocheck;
		$agenda->replacement = $remplacant;
		$agenda->description= $description;
		$agenda->tbl_doctor_id = $userid;
		$agenda->id_meeting_type= "4";
		$agenda->color = $ouvertColor;

		if ($agenda->save()) {
			return redirect()->action('UserController@useraccount');
			// // $agendaid = $agenda->id;
			

			// // if ($radiocheck == "limit") {
			// // 	# code...
			// // 	if (sizeof($motif_chk) > 0) {
				
			// // 		foreach ($motif_chk as $mo_key) {
	  // //   				// # code...
	  // //   				$am = new AgendaMotif;
	  // //   				$am->id_agenda = $agendaid;
	  // //   				$am->id_motif = $mo_key;
	  // //   				$am->save();
	  // //   			}

			// // 	}
			// // 	return redirect()->action('UserController@useraccount');	
    			 
			// // }
			// // else{

			// // 	$getmotif = Motif::all();
			// // 	foreach ($getmotif as $key) {
			// // 		$am = new AgendaMotif;
			// // 		# code...
			// // 		$am->id_agenda = $agendaid;
   // //  				$am->id_motif = $key->id;
   // //  				$am->save();

			// // 	}
				


			// }
    			  
		}
    }


    public function updateConsultant(Request $r){
    	$agendaId = $r->input("aid");

    	$getpid = "";
    	$getpid = $r->input("pid");
    	$userid = $r->input("userid");

		$agenda = Agenda::findOrFail($agendaId);
		$partience = Patient::findOrFail($getpid);
			//Starting get value for patient
			$day = $r->input("day");
    		$month = $r->input("month");
    		$year = $r->input("year");    		
    		$realYear = $day."-".$month."-".$year;

	    	$partience->title = $r->input("title");
	    	$partience->first_name = $r->input("nom_de_famile");
	    	$partience->last_name = $r->input("prenom");
	    	$partience->maiden_name = $r->input("nom_jeun");
	    	$partience->mobile_phone = $r->input("tel_portable");
	    	$partience->email = $r->input("email_patient");
	    	$partience->home_phone = $r->input("tel_fix");
	    	$partience->birthdate = $realYear;
	    	// $partience->password = $r->input("password");
	    	$partience->user_address = $r->input("adresse");
	    	$partience->cpcode = $r->input("cp"); 

	    	$partience->quartier = $r->input("quartier");
	    	$partience->id_insurance = $r->input("insurent");
	    	$partience->id_city = $r->input("hidenvilleid");
	    	//end partient
	    	$partience->save();
	    	$getpid = $partience->id;
		
		$horaire = $r->input("dhour");
		$agenda->date_start  = $r->input("dhour");
    	$agenda->id_motif = $r->input("motif");
    	$agenda->duration = $r->input("duration");
      //	$agenda->ptype = $typepatient;
      	$agenda->id_patient = $getpid;
    	//$agenda->duration = $r->input("hiddendate");

    	
    	$agenda->origin = $r->input("origin");
    	$agenda->tage= $r->input("tags");
    	$agenda->notes = $r->input("note");
    	$agenda->lieu_rdv = $r->input("lieu_rdv");

    	$datefin = explode(' ', $r->input("dfin"));
    	$time_cal = explode(' ', $r->input("dhour"));
		$time_result = strtotime($time_cal[1])+strtotime($r->input("duration"));
		$hour = $time_result / 3600 % 24;    // to get hours
		$minute = $time_result / 60 % 60;    // to get minutes
		$second = $time_result % 60; 

    	$dateEnd = $datefin[0].' '.$hour.':'.$minute;

    	$agenda->notes = $r->input("note");
    	$agenda->id_meeting_type= "2";
    	$agenda->tbl_doctor_id= $userid;
    	$agenda->date_end= $dateEnd;   	
    	$agenda->save(); 		
    		//$getpatient = Patient::where('id','=',$getpid)->get()->first();
			$pname = $partience->first_name.' '.$partience->last_name;

			//$agendar = Agenda::where('id','=',$aid)->get()->first();
			//return redirect()->action('UserController@useraccount');
			$datetimestart = new DateTime($horaire);
			$dstart =  $datetimestart->format(DateTime::ISO8601);

			$datetimeend = new DateTime($dateEnd);
			$dateend =  $datetimeend->format(DateTime::ISO8601);

			$getlocation = Hospital::where("id","=",$r->input("lieu_rdv"))->get()->first();
			$description = "";
			if (!empty($partience->home_phone)) {
				$description = $partience->first_name.' '.$partience->last_name."\r\n"
							.$partience->email."\r\n"
							.$partience->mobile_phone.' - '.$partience->home_phone."\r\n"
							.'Note : '.$note."\r\n";
			}
			else{
				$description = $partience->first_name.' '.$partience->last_name."\r\n"
							.$partience->email."\r\n"
							.$partience->mobile_phone."\r\n"
							.'Note : '.$r->input("note")."\r\n";
			}


			echo $dstart.'|'.$dateend.'|'.$pname.'|'.$agenda->google_id.'|'.$getlocation->address_hospital.'|'.$description;
    	//}

    	//return redirect()->action('UserController@useraccount');


    }

    public function updateAbsence(Request $r){
    	$agendaId = $r->input("aid");
    	$agenda = Agenda::findOrFail($agendaId);

    	//get data from request
    	$dateStat = $r->input("absence_start");
    	$dateEnd = $r->input("absence_end");


    	$obj = $r->input("obj");
    	$note = $r->input("note");
    	$userid = $r->input("userid");
    	$color = $r->input("color");

    	//check journee
    	$journee = $r->input("journee");

    	//0 = non; 1 = oui
    	$repete = $r->input("chkon");

    	//start get value from absence clock
		$absenceClock = $r->input("absence-clock");
		$absenceClockFin = $r->input("absence-clock-fin");

		//In case repeat = 1
		$absencetimeinput = $r->input("absencetimeinput");
		$time_clock_start = $r->input("time_clock_start");
		$time_clock_fin = $r->input("time_clock_fin");

		//Day
		$days = "0000000";
		$getDateLe = "";
		$absenceDateStart = "";
	    $absenceDateEnd = "";
		//get semaines
	    $semaines = $r->input("semaines");

	   
    	//generall insert
    	if ($journee != "on" && $repete =="0") {
	    	//modify date
	    	$absenceDateStart = $dateStat.' '.$absenceClock;
	    	$absenceDateEnd = $dateEnd.' '.$absenceClockFin;
		}
		else if ($journee == "on" && $repete =="0") {
			$absenceDateStart = $dateStat.' '.'00:00';
	    	$absenceDateEnd = $dateEnd.' '.'00:00';
		}
		else if ($repete == "1" ) {
			# code...
			$absenceDateStart = $absencetimeinput.' '.$time_clock_start;
	    	$absenceDateEnd = $absencetimeinput.' '.$time_clock_fin;

	    	$chk = $r->input("chk");
	    	$days = "0000000";
	    	$inputday = "0000000";
	    	if (sizeof($chk) > 0) {
	    		$days = array_sum($chk);
	    		if (strlen($days)<7) {
	    			if (strlen($days) == 6) {
	    				$inputday = "0".$days;
	    			}
	    			else if (strlen($days) == 5) {
	    				$inputday = "00".$days;
	    			}
	    			else if (strlen($days) == 4) {
	    				$inputday = "000".$days;
	    			}
	    			else if (strlen($days) == 3) {
	    				$inputday = "0000".$days;
	    			}
	    			else if (strlen($days) == 2) {
	    				$inputday = "00000".$days;
	    			}
	    			else if (strlen($days) == 1) {
	    				$inputday = "000000".$days;
	    			}
	    		}
	    		else{
	    			$inputday = $days;
	    		}
	    		
	    	}
	    	else{
	    		$inputday = $days;
	    	}	    
	    	

	    	
	    	$radiojamaia = $r->input("jamain");

	    	if ($radiojamaia == "le") {
	    		# code...
	    		$getDateLe = $r->input("le");
	    	}
	    	else{
	    		$getDateLe = "jamais";
	    	}

	    	//case repete = 1
			$agenda->days = $inputday;
			$agenda->fin_repete = $getDateLe;
			$agenda->semaines = $semaines;

		}

			
			$agenda->date_start = $absenceDateStart;
			$agenda->date_end = $absenceDateEnd;

			$agenda->repeat_active = $repete;
			$agenda->journee = $journee;
			$agenda->subject = $obj;
			$agenda->notes= $note;
			$agenda->tbl_doctor_id = $userid;
			$agenda->id_meeting_type= "3";
			$agenda->color = $color;

			
			if ($agenda->save()) {
				# code...
				return redirect()->action('UserController@useraccount');
			}
    }
    public function updateagendaOuverture(Request $r){

    	$aid = $r->input("hiddenaid");
    	//echo "sdfsdf".$aid;
    	$agenda = Agenda::findOrFail($aid);


    	$ouverturedatehour = $r->input("ouverturedatehour");
    	$ouverture_clock_start = $r->input("ouverture_clock_start");
    	$ouverture_clock_fin = $r->input("ouverture_clock_fin");

    	$datestart = $ouverturedatehour.' '.$ouverture_clock_start;
    	$dateend = $ouverturedatehour.' '.$ouverture_clock_fin;


    	$radiocheck = $r->input("radiocheck");
    	if (!empty($radiocheck)) {
    		# code...
    		$step = "";
    	}
    	else{

    		$step = $r->input("un_duration");
    	}
    	
    	$remplacant = $r->input("remplacant");
    	$description = $r->input("description");
    	$ouvertColor = $r->input("ouvertColor");
    	$userid = $r->input("userid");
    	//$motif_chk = $r->input("motif_chk");

    	$agenda->date_start = $datestart;
		$agenda->date_end = $dateend;

		$agenda->step = $step;
		$agenda->motifcheck = $radiocheck;
		$agenda->replacement = $remplacant;
		$agenda->description= $description;
		$agenda->tbl_doctor_id = $userid;
		$agenda->id_meeting_type= "4";
		$agenda->color = $ouvertColor;

		if ($agenda->save()) {
			return redirect()->action('UserController@useraccount');

			// if ($radiocheck  == "limit") {
			// 	# code...
			// 	//var_dump($motif_chk);
			// 	if (sizeof($motif_chk) > 0) {
			// 		$deleteam = AgendaMotif::where("id_agenda",$aid)->delete();
			// 		//if ($deleteam) {
			// 			//var_dump($motif_chk);
						
			// 			foreach ($motif_chk as $mo_key) {
			// 				 $am = new AgendaMotif;
			// 				 $am->id_agenda = $aid;
	  //   					 $am->id_motif = $mo_key;
	  //   					 $am->save();
		 //    				// $am = DB::update('update tbl_agenda_motif set id_motif ='.$mo_key.' where id_agenda='.$aid);
			// 		     //    var_dump($am);
			// 		     //    echo 'update tbl_agenda_motif set id_motif ='.$mo_key.' where id_agenda='.$aid;
		 //    			}
			// 		//}
					

			// 	}
			// 	return redirect()->action('UserController@useraccount');	
    			 
			// }
			// else if ($radiocheck  == "tout"){

			// 	$getmotif = Motif::all();
			// 	$deleteam = AgendaMotif::where("id_agenda",$aid)->delete();
			// 	//if ($deleteam) {
			// 		foreach ($getmotif as $key) {
			// 			 $am = new AgendaMotif;
			// 			 $am->id_agenda = $aid;
   //  					 $am->id_motif = $key->id;
   //  					 $am->save();						
			// 		}
			// 		return redirect()->action('UserController@useraccount');
			// 	//}


			// }
			// else{
				
			// }
    			  
		}
    }

    public function agendaList(){
    	
		$userid = Session::get('user-id');
    	$getAgenda = Agenda::where("tbl_doctor_id","=",$userid )->where("id_meeting_type","=",2);
    
  //   	echo $b;
    	return view('agenda/index',['agenda' => $getAgenda]);
    }

    public function editagenda(){    	

    	$getid = $_GET["aid"];
    	$userid = Session::get('user-id');
    	$getVille = "";
    	$vileNom = "";
    	$getpatient = "";
    	$pnom = "";
    	//echo $getid;
    	 $edit = DB::table('tbl_agenda') 
    	 		//Agenda::where('id','=',$getid)
    	 	   ->join('tbl_patient','tbl_patient.id','=','tbl_agenda.id_patient')
    	 	   ->where('tbl_agenda.id','=',$getid)
    	 	   ->get();
    	$dura1 = "";
    	$dura2 = "";
    	$dura3 = "";
    	$dura4 = "";
    	$dura5 = "";
    	$dura6 = "";
    	$dura7 = "";

    	$editform = "";
    	foreach ($edit as $keyedit) {
			   if ($keyedit->duration == "00:10") {
			    	# code...
			    	$dura1 = 'selected = selected';
			    }
			   if ($keyedit->duration == "00:15") {			    	
			    	//$dura = '<option value="00:15" selected="selected">15mn</option>';
			    	$dura2 = 'selected = selected';
			    }
			   if ($keyedit->duration == "00:20") {
			    	# code...
			    	$dura3 = 'selected = selected';
			    	//$dura = '<option value="00:20" selected="selected">20mn</option>';
			    }
			   if ($keyedit->duration == "00:30") {
			    	# code...
			    	//$dura = '<option value="00:30" selected="selected">30mn</option>';
			    	$dura4 = 'selected = selected';
			    }
			    if ($keyedit->duration == "1:00") {
			    	# code...
			    	//$dura = '<option value="1:00" selected="selected">60mn</option>';
			    	$dura5 = 'selected = selected';
			    }
			    if ($keyedit->duration == "1:30") {
			    	# code...
			    	//$dura = '<option value="1:30" selected="selected">90mn</option>';
			    	$dura6 = 'selected = selected';
			    }
			    if ($keyedit->duration == "2:00") {
			    	# code...
			    	//$dura = '<option value="2:00" selected="selected">120mn</option>';
			    	$dura7 = 'selected = selected';
			    }


			    if (!empty($keyedit->id_city)) {
			   		 $vile = Ville::where("ville_id","=",$keyedit->id_city)->get()->first();
			    	$getVille =  $vile->ville_id;
			    	$vileNom = $vile->ville_nom_reel;
			    }
			    else{
			    	$getVille = "";
			    	$vileNom = "";
			    }

			    if (!empty($keyedit->id_patient)) {
			    	$patient = Patient::where("id","=",$keyedit->id_patient)->get()->first();
			    	$getpatient = $patient->id;
			    	$pnom = $patient->first_name.' '.$patient->last_name;

			    }
			    else{
			    	$getpatient = "";
			    	$pnom = "";
			    }

			    $insur = Insurance::all();

			    $getInsurence = "";
			    foreach ($insur as $keyinsu) {
			    	# code...
			    	if ($keyinsu->id == $keyedit->id_insurance) {
			    		$getInsurence .= '<option value="'.$keyinsu->id.'" selected="selected">'.$keyinsu->name.'</option>';
			    	}
			    	else{
			    		$getInsurence .= '<option value="'.$keyinsu->id.'">'.$keyinsu->name.'</option>';
			    	}
			    	
			    }
			    

			    //get title
			    $titleRadio1 = "";
			    $titleRadio2 = "";
			    if ($keyedit->title == "Mme") {
			    	# code...
			    	$titleRadio1 = "checked";
			    }
			    else if($keyedit->title == "M.") {
			    	$titleRadio2 = "checked";
			    }
			    $getdate = array("","","");
			    if (!empty($keyedit->birthdate)) {
			    	$getdate = explode('-', $keyedit->birthdate);
			    }			    
			    
			    $hospital = DB::table("tbl_hospital")
    				  ->select("tbl_hospital.id as hid","tbl_hospital.address_hospital as haddress","tbl_hospital.name_hospital as hname")
					  ->join('tbl_doctor','tbl_doctor.id','=','tbl_hospital.tbl_doctor_id')
		    	 	  ->where('tbl_doctor.id','=',$userid)
		    	 	  ->get();
		    	$lieu = "";
		    	if (sizeof($hospital) > 1) {
		    		$lieu .= '<select class="form-control" name="lieu_rdv">';
		    			foreach ($hospital as $hos) {
		    				if ($hos->hid == $keyedit->lieu_rdv) {
		    					$lieu .= '<option value="'.$hos->hid.'" selected="selected">'.$hos->haddress.'</option>';		    					
		    				}
		    				else{
		    					$lieu .= '<option value="'.$hos->hid.'" >'.$hos->hname.' - '.$hos->haddress.'</option>';
		    				}
		    			}
		    		$lieu .= '</select>';			
		    	}
		    	else if (sizeof($hospital) == 1){
		    		foreach ($hospital as $hos) {
			    		$lieu = '
			    					<input type="text" name="" value="'.$hos->hname.' - '.$hos->haddress.'" class="form-control">
		    						<input type="hidden" name="lieu_rdv" value="'.$hos->hid.'">
			    				';
			    	}
		    	}
			   
	    		$editform = '
               			<input type="hidden" name="userid" value="'.$userid.'">
               			<input type="hidden" name="aid" value="'.$getid.'" id="aid">
               			<input type="hidden" name="pid" value="'.$keyedit->id_patient.'">
               			<input type="hidden" name="date_start" value="'.$keyedit->date_start.'" id="date_start">

               			<input type="hidden" name="hiddenModaltitle" value="Rendez-vous avec '.$keyedit->first_name.'" class="hiddenModaltitle">
	    			<div class="col-md-3"><span class="text-control">Horaire</span></div>
	            	<div class="col-md-5 nopadding">					            
	                  <div class="form-group">
		                <div class="input-group date datetimepicker2" id="datetimepickeredit'.$getid.'">
		                    <input type="text" class="form-control" id="dhour" name="dhour"  required value="'.$keyedit->date_start.'"/>	                    
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
		        	</div>
		        	<div class="col-md-3">
		        		<div class="form-group">
		            		<select class="form-control" name="duration" required>
		            			
		            			<option value="00:10" '.$dura1.'>10mn</option>
		            			<option value="00:15" '.$dura2.'>15mn</option>
		            			<option value="00:20" '.$dura3.'>20mn</option>
		            			<option value="00:30" '.$dura4.'>30mn</option>
		            			<option value="1:00" '.$dura5.'>60mn</option>
		            			<option value="1:30" '.$dura6.'>90mn</option>
		            			<option value="2:00" '.$dura7.'>120mn</option>
		            		</select>
		            		<input type="hidden" name="dfin" id="dfin" value="'.$keyedit->date_start.'">
		            	</div>
					</div>
		        	<div class="col-md-1"></div>
		        	<div class="col-md-12">&nbsp;</div>
	            	<div class="col-md-12 nopadding">
			        	<div class="col-md-3">Patient</div>
			        	<div class="col-md-3 nopadding">
			        		<div class="col-md-6 nopadding"><span class="text-control"><input type="radio" name="title" class="" value="Mme" '.$titleRadio1.'> Mme</span></div>
			        		<div class="col-md-6 nopadding"><span class="text-control"><input type="radio" name="title" class="" value="M." '.$titleRadio2.'> M.</span></div>
			        	</div>
			        	<div class="col-md-3 nopadding">				            		
			                 <div class="form-group">
			        			<input type="text" class="form-control" name="nom_de_famile" placeholder="Nom de famile" required value="'.$keyedit->first_name.'">
			        		</div>
			        	</div>
			        	<div class="col-md-3">				            		
			                <div class="form-group">
			        			<input type="text" class="form-control" name="prenom" placeholder="Prénom" required value="'.$keyedit->last_name.'">  
			        		</div>          		
			        	</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-5">&nbsp;</div>
						<div class="col-md-3 nopaddingleft">
			        		<input type="text" class="form-control nom_jeun" name="nom_jeun" placeholder="Nom de jeune fille" value="'.$keyedit->maiden_name.'"> 
						</div>
						<div class="col-md-4 nopadding">
							<div class="col-md-3 nopaddingleft">
				                    <input type="text" class="form-control"  name="day"  placeholder="JJ" required id="dayValue'.$getid.'" onkeypress="return isNumberDay'.$getid.'(event,this)" maxlength="2" value = "'.$getdate[0].'" onfocus=this.value="" pattern="\d*" />					
							</div>
							<div class="col-md-3 nopaddingleft">
				                    <input type="text" class="form-control"  name="month"  placeholder="MM" required id="monthValue'.$getid.'" onkeypress="return isNumberMonth'.$getid.'(event,this)"  maxlength="2" value = "'.$getdate[1].'" onfocus=this.value="" pattern="\d*" />				
								
							</div>
							<div class="col-md-6">
				                    <input type="text" class="form-control"  name="year"  placeholder="AAAA" required id="yearValue'.$getid.'" onkeypress="return isNumberYear(event,this)"  maxlength="4" value = "'.$getdate[2].'" onfocus=this.value="" pattern="\d*"/>						
							</div>							
		
						</div>
						<div class="col-md-12">&nbsp;</div>

						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-4">									
			                <div class="form-group">
			        			<input type="email" class="form-control" name="email_patient" placeholder="Email du patient" data-error="Bruh, that email address is invalid"  value="'.$keyedit->email.'">
								<div class="help-block with-errors"></div>
							</div>									
						</div>
						<div class="col-md-5">
							 <div class="form-group">
							 								 	
							 </div>
						</div>

						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-4">									
			                <div class="form-group">
			        			<input type="text" class="form-control" name="tel_portable" placeholder="Téléphone portable" required value="'.$keyedit->mobile_phone.'" maxlength="10" id="tel_port'.$getid.'">  
			        				<span class="error_phone_tel'.$getid.'">Numéro de téléphone invalide</span>        		
							</div>
						</div>
						<div class="col-md-5">				            		
				            <div class="form-group">
			        			<input type="text" class="form-control" name="tel_fix" placeholder="Téléphone fixe" value="'.$keyedit->home_phone.'" maxlength="10" id="tel_fix'.$getid.'">
			        			<span class="error_phone_tel_fix'.$getid.'">Numéro de téléphone invalide</span>
							</div>
						</div>
						

						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-9">
							<div class="form-group">
			        			<input type="text" class="form-control" name="adresse" placeholder="Adresse" required value="'.$keyedit->user_address.'">					
							</div>
						</div>

						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
					        <input type="text" class="form-control" name="quartier" placeholder="Quartier"  data-maxlength="20" value="'.$keyedit->quartier.'">					

						</div>
						<div class="col-md-6">
			                <div class="form-group">                
			        			<input type="text" class="form-control" name="ville" placeholder="Ville" id="ville_auto_edit'.$getid.'" value="'.$vileNom.'" required>					
			                    <input type="hidden" name="hidenvilleid" id="hidenvilleidedit" value="'.$getVille.'">
			                </div>
						</div>

						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
			        		<input type="text" class="form-control cp" name="cp" placeholder="Postal Code" maxlength="5" value="'.$keyedit->cpcode.'" id="cp'.$getid.'">					

			        					
						</div>
						<div class="col-md-6">
			        		<select class="form-control" name="insurent" >
			        		  '.$getInsurence.'
			        		</select>					
						</div>
					</div>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-3"><span class="text-control">Lieu du rdv</span></div>
					<div class="col-md-9 ">'.$lieu.'</div>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-3"><span class="text-control">Provenance</span></div>
					<div class="col-md-9">									
		                <div class="form-group">
		        			<input type="text" class="form-control" name="origin" placeholder="Ex : généraliste, dentiste, pharmacien, patient..." value="'.$keyedit->origin.'">	
						</div>
					</div>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-3"><span class="text-control">Tags</span></div>
					<div class="col-md-9">									
		                <div class="form-group">
		        			<input type="text" class="form-control" name="tags" placeholder="Tags" value="'.$keyedit->tage.'">
		        		</div>	
					</div>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-3"><span class="text-control">Note</span></div>
					<div class="col-md-9">								
		                <div class="form-group">
		        			<textarea name="note" class="form-control" >'.$keyedit->notes.'</textarea>
		        		</div>
					</div>
						<div class="col-md-12">&nbsp;</div>	
								<div class="clear"></div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					                <button class="btn btn-primary cutom-btn btnupdate" type="submit"><a id="eventUrl" target="_blank">Modifier le rendez-vous</a></button>
					            </div>	
					
					 <div class="modal-sidebar">
					 		<div class="action-modal">
					 			<h3>action</h3>				 			

					 			<a  class="btn btn-danger delete_agenda" data-id="'.$getid.'" data-p="'.$keyedit->id_patient.'" data-date="'.$keyedit->date_start.'" data-did="'.$keyedit->tbl_doctor_id.'" ><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Supprimer</a>
					 		</div>
					 </div>

		    		';

				echo $editform;
	?>

		<script>			
		//<![CDATA[
			$(document).ready(function(){
			validateCP("cp");
				$(".error_phone_tel<?php echo $getid ?>").hide();
				$(".error_phone_tel_fix<?php echo $getid ?>").hide();
				phonenumbervalidation("tel_port<?php echo $getid ?>","error_phone_tel<?php echo $getid ?>");
				phonenumbervalidation("tel_fix<?php echo $getid ?>","error_phone_tel_fix<?php echo $getid ?>");


				$('#datetimepickeredit<?php echo $getid;?>').datetimepicker({
		            locale: 'fr',
		            // format: 'dd DD MMM hh:mm'
		             format: 'YYYY-MM-DD HH:mm'
		        });
				 //edit consultant
				$("#ville_auto_edit<?php echo $getid;?>").autocomplete({
					source: function( request, response ) {
			            $.ajax({
			                url: '<?php echo url('/villeauto');?>',
			                dataType: "json",
			                data: {
			                    q: request.term
			                },
			                success: function(data) {

			                	if(!data.length){
			                		alert(2);
								      var result = [
								       {
								       label: 'Aucun résultat.', 
								       value: response.term
								       }
								     ];
								     
							       response(result);
							     }
							     else{


								    response($.map(data, function(obj) {
				                    	//alert(12);
					                     return {
					                     	label: obj.value,
					                        value: obj.value,
					                         id: obj.id, 
					                    	cp:obj.cp
					                     
					                     };


			                		}));
							     }
			                    
			                }
			            });
			        },
			        minLength: 3,
			        select: function(event, ui) { 

			        	console.log(ui);
				        $("#hidenvilleidedit").val(ui.item.id);
				         $("#cp<?php echo $getid;?>").val(ui.item.cp);
				    },
			        cache: false

				});

				


				$('input:radio[name="title"]').change(function(){
			        if (this.checked && this.value == 'Mme') {
			           $(".nom_jeun").show();
			        }
			        else{
			        	 $(".nom_jeun").hide();
			        }
				    
		    	});

			    if($('input:radio[name="title"]:checked').val() == "Mme"){
			    	 $(".nom_jeun").show();
			    }
			    else{
			    	$(".nom_jeun").hide();
			    }


			    $("#dateofbirth<?php echo $getid;?>").on("change",function(){
				  	var date_value = $(this).val();
				  	var pattern =/^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
			   		var testDate = pattern.test(date_value);
			   		if (testDate == true) {
			   			$(".btnupdate").prop('disabled', false);
			   			$(".dateerror").text("");
			   		}
			   		else{
			   			$(".dateerror").text("invalide date format.").css("color","red");
			   			$(".btnupdate").prop('disabled', true);
			   		}
				  });
			});
			function isNumberDay<?php echo $getid;?>(evt,val) {
				//alert(111);
					var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};

					var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;					

					if( key >= 48 && key <= 57 ){
						var valueKey = numArray[key];
						var ex = /^(0?[0-9]|[0-9][0-9]){1}$/;
						if (val.value){
							var value = val.value + "" + valueKey;
					    	
					    }else{
					    	var value = valueKey;
					    }
						if (value<32)
						{
							var returned =  ex.test(value);
							var valTxt = "" + value;
							if (numArray[key] > 3 || value > 9 || valTxt.length == 2) 
							{
								//alert(1);
								$('#monthValue<?php echo $getid;?>').focus();
								$('#dayValue<?php echo $getid;?>').val($('#dayValue<?php echo $getid;?>').val()+""+numArray[key]);
								

								if (value <10 && $('#dayValue').val().length <2)
									$('#dayValue<?php echo $getid;?>').val("0"+value);
								else $('#dayValue<?php echo $getid;?>').val(value);
									returned = false;
							}
							return returned;
						}
						else {
							//alert(2);
							//console.log($('#monthValue').focus());
							$('#monthValue<?php echo $getid;?>').focus();
							$('#monthValue<?php echo $getid;?>').val(numArray[key]);
							///alert(numArray[key]);
							return false;
						}
					}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
						return true;
					
					}else{
						return false;
					}
			    
			}

			function isNumberMonth<?php echo $getid;?>(evt,val) {
				var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};

				var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;			
				if( key >= 48 && key <= 57 ){
					var valueKey = numArray[key];
					// alert(valueKey);
					// alert(val.value);
					var ex = /^(0?[0-9]|[0-9][0-9]){1}$/;
					var ex2 = /^([0-9]){2}$/;
					//var value;
					if (val.value == 1 ){
						// if(val.value < 100 ){
						// 	var value = valueKey;
						// }else{
							var value = val.value+ "" + valueKey;
						// }
				    	
				    }else{
				    	var value = "" +valueKey;
				    }
					if (value<13)
					{
						//alert(value);
						var returned =  ex.test(value);
						var valTxt = "" + value.toString();
						
						//console.log (ex2.test(value) + " " +$('#monthValue').val() + " " + valTxt.length + " "+value.length );
						//alert(value + " - "+ $('#monthValue').val()+ " - "+numArray[key]);
						if ( value > 1 || ex2.test(value)) {
							
							$('#yearValue<?php echo $getid;?>').focus();
							if (value <10)
							$('#monthValue<?php echo $getid;?>').val("0"+value);
							else $('#monthValue<?php echo $getid;?>').val(value);
							returned = false;
							//alert(value + " - "+ $('#monthValue').val()+ " - "+numArray[key]);
						}
						setTimeout(function(){
							if ($('#monthValue<?php echo $getid;?>').val().length==2)
							$('#yearValue<?php echo $getid;?>').focus();//console.log($('#monthValue').val().length);
						}, 100);
						//console.log (ex2.test(value) + " " +$('#monthValue').val() + " " + valTxt.length + " "+value.length );
						return returned;
					} else {
						//alert(3);
						$('#yearValue<?php echo $getid;?>').focus();
						$('#yearValue<?php echo $getid;?>').val(numArray[key]);
						return false;
					}
				}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
					return true;
				
				}else{
					return false;
				}
			    
			}

			function isNumberYear(evt,val) {

				var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};

				var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;
				//alert(key);
				if( key >= 48 && key <= 57 ){
					//alert(123);
					var valueKey = numArray[key];
					// alert(valueKey);
					// alert(val.value);
					var ex = /^([0-9][0-9][0-9][0-9]){1}$/;
					//var ex = /^(181[2-9]|18[2-9]\d|19\d\d|2\d{3}|30[0-3]\d|304[0-8])$/;
					if (val.value){
						// if(val.value < 100 ){
						// 	var value = valueKey;
						// }else{
							var value = val.value+ "" + valueKey;
						// }
				    	
				    }else{
				    	var value = valueKey;
				    }
				    //alert(value);
					//console.log(ex.test(value));
					//return ex.test(value);
				}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
					return true;
				
				}else{
					return false;
				}
			    
			}
			//]]>
		</script>

	<?php

	    	}//end loop foreach 
    }


public function editagendaAbsence(){
	$getid = $_GET["aid"];

	$agenda = Agenda::where("id","=",$getid)
			->where("id_meeting_type","=",3)
			->get();
	$absence = "";
	$journeeChk = "";
	$repeat_absence1 = "";
	$repeat_absence2 = "";
	$chkday1 = "";
	$chkday2 = "";
	$chkday3 = "";
	$chkday4 = "";
	$chkday5 = "";
	$chkday6 = "";
	$chkday7 = "";
	$jamain1 = "";
	$jamain2 = "";
	$datele = "";
	$semainesselected1 = "";
	$semainesselected2 = "";
	$semainesselected3 = "";
	$semainesselected4 = "";
	$semainesselected5 = "";
	$semainesselected6 = "";
	$semainesselected7 = "";
	$semainesselected8 = "";
	$semainesselected9 = "";
	$semainesselected10 = "";
	$semainesselected11 = "";
	foreach ($agenda as $keyagenda) {
		# code...
		if ($keyagenda->journee == "on") {
			$journeeChk = "checked";
		}
		if ($keyagenda->repeat_active == 1) {		
			$repeat_absence1 = "checked";
			$chkday = str_split($keyagenda->days);
			if ($chkday[0] == 1) {
				$chkday1 = "checked";
			}
			if ($chkday[1] == 1) {
				$chkday2 = "checked";
			}
			if ($chkday[2] == 1) {
				$chkday3 = "checked";
			}
			if ($chkday[3] == 1) {
				$chkday4 = "checked";
			}
			if ($chkday[4] == 1) {
				$chkday5 = "checked";
			}
			if ($chkday[5] == 1) {
				$chkday6 = "checked";
			}
			if ($chkday[6] == 1) {
				$chkday7 = "checked";
			}
		}
		if ($keyagenda->repeat_active == 0) {
			$repeat_absence2 = "checked";
		}
		if ($keyagenda->fin_repete == "jamais") {
			$jamain1 = "checked";
		}
		if ($keyagenda->fin_repete != "jamais") {
			$jamain2 = "checked";
			$datele =$keyagenda->fin_repete;
		}

		if ($keyagenda->semaines == 2) {
			# code...
			$semainesselected1 = "selected='selected'";
		}
		if ($keyagenda->semaines == 3) {
			# code...
			$semainesselected2 = "selected='selected'";
		}
		if ($keyagenda->semaines == 4) {
			# code...
			$semainesselected3 = "selected='selected'";
		}
		if ($keyagenda->semaines == 5) {
			# code...
			$semainesselected4 = "selected='selected'";
		}
		if ($keyagenda->semaines == 6) {
			# code...
			$semainesselected5 = "selected='selected'";
		}
		if ($keyagenda->semaines == 7) {
			# code...
			$semainesselected6 = "selected='selected'";
		}
		if ($keyagenda->semaines == 8) {
			# code...
			$semainesselected7 = "selected='selected'";
		}
		if ($keyagenda->semaines == 9) {
			# code...
			$semainesselected8 = "selected='selected'";
		}
		if ($keyagenda->semaines == 10) {
			# code...
			$semainesselected9 = "selected='selected'";
		}
		if ($keyagenda->semaines == 11) {
			# code...
			$semainesselected10 = "selected='selected'";
		}
		if ($keyagenda->semaines == 12) {
			# code...
			$semainesselected11 = "selected='selected'";
		}
		//case simple form		
			# code...
			$dstart = explode(" ", $keyagenda->date_start);
			$dend = explode(" ", $keyagenda->date_end);
			$timestartArr = explode(':', $dstart[1]);
			$timeendArr = explode(':', $dend[1]);

			$timestart = $timestartArr[0].':'.$timestartArr[1];
			$timeend = $timeendArr[0].':'.$timeendArr[1];
		

			$absence = '
							<!-- Repeter -->					        	
					        	<div class="col-md-3"><span class="text-control">Absence récurrente</span></div>
					        	<div class="col-md-2">
					        		<input type="radio"  name="chkon" value="1" '.$repeat_absence1.'> Oui
					        	</div>
					        	<div class="col-md-2">
					        		<input type="radio"  name="chkon" value="0" '.$repeat_absence2.' > Non
					        	</div>
					        	<div class="col-md-5">&nbsp;</div>

					<div class="col-md-12 nopadding chkoui">
						        	<div class="col-md-3"><span class="text-control">Horaire</span></div>	
						        	<div class="col-md-2 nopadding"><span class="text-control">Début :</span></div>
						        	<div class="col-md-4">
						        		<div class="form-group">
							                <div class="input-group date" id="absencehour">
							                    <input type="text" class="form-control" name="absence_start" id="absencehourinput'.$getid.'" required value="'.$dstart[0].'"/>
							                    <input type="hidden" name="aid" value="'.$getid.'">
							                    <span class="input-group-addon">
							                        <span class="glyphicon glyphicon-calendar"></span>
							                    </span>
							                </div>
							            </div>
						        	</div>
						        	<div class="col-md-3">
						        		<div class="input-group absence-clock">
										    <input type="text" class="form-control" value="'.$timestart.'" name="absence-clock" id="setabsencetime'.$getid.'">
										    <span class="input-group-addon">
										        <span class="glyphicon glyphicon-time"></span>
										    </span>
										</div>
						        	</div>


						        	<div class="clear"></div>

						        	<div class="col-md-3">&nbsp;</div>	
						        	<div class="col-md-2 nopadding"><span class="text-control">Fin :</span></div>
						        	<div class="col-md-4">
						        		<div class="form-group">
							                <div class="input-group date" id="finabsencehour'.$getid.'">
							                    <input type="text" class="form-control" name="absence_end" id="finhour'.$getid.'" required value="'.$dend[0].'"/>
							                    <span class="input-group-addon">
							                        <span class="glyphicon glyphicon-calendar"></span>
							                    </span>
							                </div>
							            </div>
						        	</div>
						        	<div class="col-md-3">
						        		<div class="input-group absence-clock-fin" >
										    <input type="text" class="form-control" value="'.$timeend.'" name="absence-clock-fin" id="setabsencetime_fin'.$getid.'">
										    <span class="input-group-addon">
										        <span class="glyphicon glyphicon-time"></span>
										    </span>
										</div>

						        	</div>

						        	<!-- Checkbox -->
						        	<div class="clear"></div>
						        	<div class="col-md-3">&nbsp;</div>
						        	<div class="col-md-1">
						        		<input type="checkbox"  name="journee" id="chkjour'.$getid.'" '.$journeeChk.'> 
						        	</div>
						        	<div class="col-md-3">Journée entière</div>
						        	<div class="col-md-5">&nbsp;</div>
						        </div>

					        	<div class="col-md-12 nopadding chknon">
					        			<div class="col-md-3">
							       			<span class="text-control">Horaire</span>
							       		</div>	
							       		<div class="col-md-3">
							       			<div class="form-group">
								                <div class="input-group date" id="absencetime'.$getid.'">
								                    <input type="text" class="form-control" id="absencetimeinput'.$getid.'" name="absencetimeinput" value="'.$dstart[0].'"/>
								                    <span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
								                </div>
								            </div>
							       		</div>
							       		<div class="col-md-2 nopaddingright">
							       			<div class="input-group time-clock-start" >
											    <input type="text" class="form-control" value="'.$timestart.'" name="time_clock_start" id="time_start'.$getid.'">
											    <span class="input-group-addon">
											        <span class="glyphicon glyphicon-time"></span>
											    </span>
											</div>
							       		</div>
							       		<div class="col-md-1">
							       			<span class="text-control"> à </span>
							       		</div>
							       		<div class="col-md-3">
							       			<div class="input-group time-clock-fin" >
											    <input type="text" class="form-control" value="'.$timeend.'" name="time_clock_fin" id="time_fin'.$getid.'">
											    <span class="input-group-addon">
											        <span class="glyphicon glyphicon-time"></span>
											    </span>
											</div>
							       		</div>	
					        	</div>
								<div class="clear"></div>
					        	<div class="col-md-12">&nbsp;</div>					        	
					        	<div class="col-md-12 nopadding repeter-show">
						        	<div class="col-md-3">&nbsp;</div>
						        	<div class="col-md-2">Répéter le :</div>
						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="1000000" '.$chkday1.'> lun
						        	</div>
						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="0100000" '.$chkday2.'> mar
						        	</div>

						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="0010000" '.$chkday3.'> mer
						        	</div>
						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="0001000" '.$chkday4.'> jeu
						        	</div>
						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="0000100" '.$chkday5.'> ven
						        	</div>
						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="0000010" '.$chkday6.'> sam
						        	</div>
						        	<div class="col-md-1 nopadding">
						        		<input type="checkbox" name="chk[]" value="0000001" '.$chkday7.'> dim
						        	</div>
						        	<div class="col-md-12">&nbsp;</div>
						        	<div class="col-md-3">&nbsp;</div>
						        	<div class="col-md-9">
						        		<select class="form-control" name="semaines">
						        			<option value="0">Toutes les  semaines</option>
						        			<option value="2" '.$semainesselected1.' >Toutes les 2 semaines</option>
						        			<option value="3" '.$semainesselected2.'>Toutes les 3 semaines</option>
						        			<option value="4" '.$semainesselected3.'>Toutes les 4 semaines</option>
						        			<option value="5" '.$semainesselected4.'>Toutes les 5 semaines</option>
						        			<option value="6" '.$semainesselected5.'>Toutes les 6 semaines</option>
						        			<option value="7" '.$semainesselected6.'>Toutes les 7 semaines</option>
						        			<option value="8" '.$semainesselected7.'>Toutes les 8 semaines</option>
						        			<option value="9" '.$semainesselected8.'>Toutes les 9 semaines</option>
						        			<option value="10" '.$semainesselected9.'>Toutes les 10 semaines</option>
						        			<option value="11" '.$semainesselected10.'>Toutes les 11 semaines</option>
						        			<option value="12" '.$semainesselected11.'>Toutes les 12 semaines</option>

						        		</select>
						        	</div>
						        	<div class="col-md-12">&nbsp;</div>
						        	<div class="col-md-3">&nbsp;</div>
						        	<div class="col-md-2">Fin :</div>
						        	<div class="col-md-2">
						        		<input type="radio" name="jamain" value="jamain" '.$jamain1.'> jamais
						        	</div>
						        	<div class="col-md-1">
						        		<input type="radio" name="jamain" value="le" '.$jamain2.'> Le
						        	</div>
						        	<div class="col-md-4">
						        		<div class="form-group">
							                <div class="input-group date" id="le'.$getid.'">
							                    <input type="text" class="form-control" name="le" id="leinput'.$getid.'" value="'.$datele.'"/>
							                   
							                    <span class="input-group-addon">
							                        <span class="glyphicon glyphicon-calendar"></span>
							                    </span>
							                </div>
							            </div>
						        	</div>

						        </div>
					        	<!-- Objet -->
					        	<div class="clear"></div>
					        	<div class="col-md-12">&nbsp;</div>
					        	<div class="col-md-3"><span class="text-control">Objet</span></div>
					        	<div class="col-md-9">
					        		<input type="text"  name="obj" class="form-control" placeholder="Entrez l\'objet de l\'absence" value="'.$keyagenda->subject.'">
					        	</div>

					        	<!-- Notes -->
					        	<div class="clear"></div>
					        	<div class="col-md-12">&nbsp;</div>
					        	<div class="col-md-3"><span class="text-control">Notes</span></div>
					        	<div class="col-md-9">
					        		<textarea class="form-control" name="note">'.$keyagenda->notes.'</textarea>
					        	</div>
					        	<!-- Color -->
					        	<div class="clear"></div>
					        	<div class="col-md-12">&nbsp;</div>
					        	<div class="col-md-3">&nbsp;</div>
					        	<div class="col-md-9">
					        		<div class="input-group color">
									    <input type="text" value="'.$keyagenda->color.'" class="form-control" name="color" />
									    <span class="input-group-addon"><i></i></span>
									</div>
					        	</div>
					        	<div class="col-md-12">&nbsp;</div>

					        	<div class="clear"></div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					                <button class="btn btn-danger cutom-btn" type="submit"><a id="eventUrl" target="_blank">Modifier l\'absence</a></button>
					            </div>

					            <div class="modal-sidebar">
							 		<div class="action-modal">
							 			<h3>action</h3>
							 			<a  class="btn btn-danger delete_absence" data-id="'.$getid.'" data-p="0"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Supprimer</a>
							 		</div>
					 			</div>
			';
		


?>

		<script type="text/javascript">
			//<![CDATA[
			$(document).ready(function(){
				//set date
				$("#le<?php echo $getid; ?>").datetimepicker({
		            locale: 'fr',
		            format: 'YYYY-MM-DD'
		        });
		        $("#absencetime<?php echo $getid; ?>").datetimepicker({
		            locale: 'fr',
		            format: 'YYYY-MM-DD'
		        });

		        $(".absence-clock").clockpicker({
		        	 donetext: 'Validez'
		        });
		        $(".absence-clock-fin").clockpicker({
		        	 donetext: 'Validez'
		        });
		        $(".time-clock-start").clockpicker({
		        	 donetext: 'Validez'
		        });
		        $(".time-clock-fin").clockpicker({
		        	 donetext: 'Validez'
		        });
		        $('.color').colorpicker();

				// Check if checkbox is change
				$(".absence-clock-fin").show();
				$(".absence-clock").show();

				if($("#chkjour<?php echo $getid; ?>").is(':checked')){
					$(".absence-clock-fin").hide();
				    $(".absence-clock").hide();
				}

				$("#chkjour<?php echo $getid; ?>").change(function() {
				    if(this.checked) {
				        //Do stuff
				        $(".absence-clock-fin").hide();
				        $(".absence-clock").hide();
				    }
				    else{
				    	$(".absence-clock-fin").show();
				        $(".absence-clock").show();
				    
				    }
				});


				// $(".repeter-show").hide();
				// $(".chkoui").show();
				// $(".chknon").hide();
				if ($('input:radio[name="chkon"]:checked').val() == 1 ) {
					$(".repeter-show").show();
		    		$(".chkoui").hide();
		    		$(".chknon").show();
				};
				if ($('input:radio[name="chkon"]:checked').val() == 0 ) {
						$(".repeter-show").hide();
			    		$(".chkoui").show();
			    		$(".chknon").hide();
				};


			    $('input:radio[name="chkon"]').change(function(){
			    	if (this.checked && this.value == '1') {
			    		$(".repeter-show").show();
			    		$(".chkoui").hide();
			    		$(".chknon").show();
			    	}
			    	else{
			    		$(".repeter-show").hide();
			    		$(".chkoui").show();
			    		$(".chknon").hide();
			    	}
			    });
			});
		   //]]>
		</script>
<?php
		echo $absence;
	}




}


public function editagendaOuverture(){
		$getid = $_GET["aid"];
		$userid = Session::get('user-id');
		$agenda = Agenda::where("id","=",$getid)
				->where("id_meeting_type","=",4)
				->get();

		$ouverture = "";
		$motifCheck1 = "";
		$motifCheck2 = "";
		$chkMotif = "";
		$arr_motif = array();
		$step = "";
		$step1 = "";
		$step2 = "";
		$step3 = "";
		$step4 = "";
		$step5 = "";
		$step6 = "";
		$step7 = "";
		foreach ($agenda as $keyOuverture) {
			$dstart = explode(" ", $keyOuverture->date_start);
			$dend = explode(" ", $keyOuverture->date_end);

			// if ($keyOuverture->motifcheck == "limit") {
			// 	$motifCheck1  = "checked";
			// 	}


		 //    if ($keyOuverture->motifcheck == "tout") {
			// 	$motifCheck2  = "checked";
			// }

			if (!empty($keyOuverture->step) ) {
				# code...
				$step = $keyOuverture->step;
				 if ($step == "00:15") {
					# code...
					$step1 = "selected='selected'";
				}
				else if ($step == "00:30") {
					# code...
					$step2 = "selected='selected'";
				}
				else if ($step == "00:45") {
					# code...
					$step3 = "selected='selected'";
				}
				else if ($step == "1:00") {
					# code...
					$step4 = "selected='selected'";
				}

			}



			//chk-group
			$queryAM = DB::table("tbl_agenda_motif")->where("id_agenda","=",$getid)->get();

				foreach ($queryAM as $keyAM) {
					# code...
					array_push($arr_motif,$keyAM->id_motif );
				}

				//get all motif relate doctor
				// $motif_spe = DB::table('tbl_motif')				   
				// 			   ->Join('tbl_specialties_motif','tbl_specialties_motif.id_motif', '=', 'tbl_motif.id')
				// 			   ->Join('tbl_specialties','tbl_specialties.id', '=', 'tbl_specialties_motif.tbl_specialties_id')
				// 			   ->Join('tbl_spe_doc','tbl_spe_doc.tbl_specialties_id', '=', 'tbl_specialties_motif.tbl_specialties_id')
				// 			   ->where('tbl_spe_doc.tbl_doctor_id','=',$userid)
				// 			   ->get();	

					// foreach ($motif_spe as $ms) {
					// 	if (in_array($ms->id_motif, $arr_motif)) {
					// 		$chkMotif .= '<div class="col-md-12">
					//        					<input type="checkbox" name="motif_chk[]" value="'.$ms->id_motif.'" checked> '.$ms->motif.'
					//        				</div>';
					// 	}
					// 	else{
					// 		$chkMotif .= '<div class="col-md-12">
					//        					<input type="checkbox" name="motif_chk[]" value="'.$ms->id_motif.'"> '.$ms->motif.'
					//        				</div>';
					// 	}
					// }
			$ouverture = '
		       		<div class="col-md-2">
		       			<span class="text-control">Horaire </span>
		       		</div>	
		       		<div class="col-md-3 nopadding">
		       			<div class="form-group">
		       				<input type="hidden" value="'.$getid.'" name="hiddenaid">
			                <div class="input-group date" id="ouverturehour'.$getid.'">
			                    <input type="text" class="form-control" id="ouverturedatehour" name="ouverturedatehour" value="'.$dstart[0].'"/>

			                	
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			            </div>
		       		</div>
		       		<div class="col-md-3">
		       			<div class="input-group time-clock-start" >
						    <input type="text" class="form-control" value="'.$dstart[1].'" name="ouverture_clock_start" id="ouverture_clock_start">
						    <span class="input-group-addon">
						        <span class="glyphicon glyphicon-time"></span>
						    </span>
						</div>
		       		</div>
		       		<div class="col-md-1 ">
		       			<span class="text-control"> à </span>
		       		</div>
		       		<div class="col-md-3">
		       			<div class="input-group time-clock-fin" >
						    <input type="text" class="form-control" value="'.$dend[1].'" name="ouverture_clock_fin" id="ouverture_clock_fin">
						    <span class="input-group-addon">
						        <span class="glyphicon glyphicon-time"></span>
						    </span>
						</div>
		       		</div>	
		       		<div class="clear"></div>
		       		<div class="col-md-2">
		       			
		       		</div>
		       		<div class="col-md-6">
		       			
		       		</div>	
		       		<div class="col-md-4">
		       		
		       		</div>

		       		<div class="clear"></div>
		       		<div class="col-md-2"><span class="text-control">Durée d’un créneau</span></div>
		       		<div class="col-md-5 nopadding">
		       				<div class="col-md-7 nopadding">
		       					<select class="form-control step_select" name="un_duration">
		       						<option value=""></option>
		       						<option value="00:15" '.$step1.'>15mn</option>
		       						<option value="00:30" '.$step2.'>30mn</option>
		       						<option value="00:45" '.$step3.'>45mn</option>
		       						<option value="1:00" '.$step4.'>60mn</option>
		       					</select>
		       				</div>
		       		</div>
		       		<div class="col-md-5">&nbsp;</div>

		       		<div class="clear"></div>
		       		<div class="col-md-12">&nbsp;</div>
		       		<div class="col-md-2">
		       			<span class="text-control">Remplaçant</span>
		       		</div>
		       		<div class="col-md-10 nopadding">
		       			<input type="text" name="remplacant" class="form-control" placeholder="Entrez le nom de votre remplaçant" value="'.$keyOuverture->replacement.'">
		       		</div>

		       		<div class="clear"></div>
		       		<div class="col-md-12">&nbsp;</div>
		       		<div class="col-md-2">
		       			<span class="text-control">Description</span>
		       		</div>
		       		<div class="col-md-10 nopadding">
		       			<input type="text" name="description" class="form-control" placeholder="Entrez une description (uniquement visible en interne)" value="'.$keyOuverture->description.'">
		       		</div>

		       		<div  class="clear"></div>
		       		<div class="col-md-12">&nbsp;</div>
		       		<div class="col-md-2">&nbsp;</div>
		       		<div class="col-md-10 nopadding">
		       			<div class="input-group ouvertColor">
						    <input type="text" value="'.$keyOuverture->color.'" class="form-control" name="ouvertColor" />
						    <span class="input-group-addon"><i></i></span>
						</div>
		       		</div>
		       		<div class="col-md-12">&nbsp;</div>

		        	<div class="clear"></div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		                <button class="btn btn-warning cutom-btn"><a id="eventUrl" target="_blank">Modifier d\'ouverture</a></button>
		            </div>

		             <div class="modal-sidebar">
				 		<div class="action-modal">
				 			<h3>action</h3>
				 			<a  class="btn btn-danger delete_ouverture" data-id="'.$getid.'" data-p="ouverture"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Supprimer</a>
				 		</div>
		 			</div>
			';
?>
<script type="text/javascript">
	$(document).ready(function(){
		//alert($(".step_select").val());
		if ($(".step_select").val() != "") {
			$(".step").show();
			$("#config-avance<?php echo $getid; ?>").hide();
			$("#config-standard<?php echo $getid; ?>").show();
			// $(".chk-group").hide();
			// $('.hideradio input:radio[name="radiocheck"]').removeAttr('required');
			// $(".hideradio").hide();

		}else{
			$(".step").hide();
			$("#config-standard<?php echo $getid; ?>").hide();
		}
		

		//Click on configuration avance
		$("#config-avance<?php echo $getid; ?>").on("click",function(){
			$(this).hide();
			$(".step").show();
			//$(".chk-group").hide();
			// $('.hideradio input:radio[name="radiocheck"]').removeAttr('checked');
			// $('.hideradio input:radio[name="radiocheck"]').removeAttr('required');
			$(".hideradio").hide();
			
			$("#config-standard<?php echo $getid; ?>").show();
		});
		$("#config-standard<?php echo $getid; ?>").on("click",function(){
			$(this).hide();
			$("#config-avance<?php echo $getid; ?>").show();
			$(".step_select").val("");
			//$('input:radio[name="radiocheck"]').attr('required');
			$(".step").hide();
			// $(".chk-group").show();
			// $(".hideradio").show();
			//$('.chk-group input:checkbox').removeAttr('checked');
		});

		//check on radio tout or limit
		// $('input:radio[name="radiocheck"]').change(function(){
		// 	//alert($(this).val());
	 //        if (this.checked && this.value == 'tout') {
	 //            $(".chk-group").hide();
	            
	 //        }
	 //        else{
	 //        	$(".chk-group").show();
	 //        	$('.chk-group input:checkbox').removeAttr('checked');
	 //        }

	 //    });
		// if ( $('input:radio[name="radiocheck"]:checked').val()== 'tout') {
		// 	 $(".chk-group").hide();
		// 	 $(".step").hide();
		// 	 $("#config-standard<?php echo $getid; ?>").hide();
		// }
		// if ( $('input:radio[name="radiocheck"]:checked').val()== 'limit') {
		// 	 $(".chk-group").show();
		// 	 $(".step").hide();
		// 	 $("#config-standard<?php echo $getid; ?>").hide();

		// }


	    $(".ouvertColor").colorpicker();
	    $(".time-clock-start").clockpicker({
        	 donetext: 'Validez'
        });
        $(".time-clock-fin").clockpicker({
        	 donetext: 'Validez'
        });
        $("#ouverturehour<?php echo $getid; ?>").datetimepicker({
            locale: 'fr',
            format: 'YYYY-MM-DD'
        });
        
	});
</script>

<?php
		}

		echo $ouverture;
	}

	public function dragAgendaById(){
		$date = "";
		$dateEnd = "";
		$getid = $_GET["aid"];
		$date = $_GET["date"];
		if (isset($_GET['dend'])) {
			$end = $_GET['dend'];

			$duration = Agenda::where("id",$getid)->get()->first();
			$time_cal = explode(' ', $end);
			$time_result = strtotime($time_cal[1])+strtotime($duration->duration);
			
			$hour = $time_result / 3600 % 24;    // to get hours
			$minute = $time_result / 60 % 60;    // to get minutes
			$second = $time_result % 60; 
	    	//$dateEnd = $time_cal[0].' '.$hour.':'.$minute;
	    	$dateEnd = $end;
		}
		else{
			//get duration
			$duration = Agenda::where("id",$getid)->get()->first();
			$datefin = explode(' ', $end);
			$time_cal = explode(' ', $date);
			$time_result = strtotime($time_cal[1])+strtotime($duration->duration);
			$hour = $time_result / 3600 % 24;    // to get hours
			$minute = $time_result / 60 % 60;    // to get minutes
			$second = $time_result % 60; 
	    	$dateEnd = $time_cal[0].' '.$hour.':'.$minute;
		}
			$updateDrag = Agenda::findOrFail($getid);
	    	$updateDrag->date_start = $date;
	    	$updateDrag->date_end = $dateEnd;
	    	if ($updateDrag->update()) {
	    		$getpid = $updateDrag->id_patient;
	    		$getpatient = Patient::where('id','=',$getpid)->get()->first();
				$pname = $getpatient->first_name.' '.$getpatient->last_name;

				//$agendar = Agenda::where('id','=',$aid)->get()->first();
				//return redirect()->action('UserController@useraccount');
				$datetimestart = new DateTime($date);
				$dstart =  $datetimestart->format(DateTime::ISO8601);

				$datetimeend = new DateTime($dateEnd);
				$dateend =  $datetimeend->format(DateTime::ISO8601);

				echo $dstart.'|'.$dateend.'|'.$pname.'|'.$updateDrag->google_id;
	    	}
		
		
	}

    public function destroy(){
    	$id = $_GET["id"];
    	$pid = $_GET["pid"];
    	$did = $_GET["did"];
    	$date = $_GET["date"];
    	// echo $date.'=>'.$did;
    	Agenda::destroy($id);
    	//send email to doctor
    	UserController::cancelEmail($did,$pid,$date);





    	//Patient::destroy($pid);
    	//AgendaMotif::where("id_agenda","=",$id)->delete();

    	//return redirect()->action('UserController@useraccount');


    	
    }

    public function destroyAbsence(){
    	$id = $_GET["id"];
    	Agenda::destroy($id);
    	//echo $id;
    	//return redirect()->action('UserController@useraccount');
    }

    public function destroyOuverture(){
    	$id =  $_GET["id"];
    	Agenda::destroy($id);
    	//AgendaMotif::where("id_agenda","=",$id)->delete();
    }

    public function villeAutocomplete(Request $r){
    	$query = $r->get("q");
    	$results = array();
    	$search = DB::table("tbl_ville")
    			->select('ville_id', 'ville_nom_reel','ville_code_postal')
    			->where('ville_nom_reel', 'LIKE',  '%' . $query . '%')
    			->get();

    			foreach ($search as $keysearch) {
    				# code...

    				$results[] = ['id' => $keysearch->ville_id,'value' => $keysearch->ville_nom_reel.' - '.$keysearch->ville_code_postal,"cp"=>$keysearch->ville_code_postal];

    			}
    			//var_dump($search);
    			return Response::json($results);

    }

    public function patientAutocomplete(Request $r){
    	$userid = Session::get('user-id');
    	$query = $r->get("q");
    	$results = array();

    	// $search = DB::table("tbl_patient")
    	// 		->select('tbl_patient.id','tbl_patient.first_name','tbl_patient.last_name','tbl_patient.birthdate')
    	// 		->join('tbl_patient_doctor','tbl_patient_doctor.tbl_patient_pid','=','tbl_patient.id')    			
    	// 		->where('tbl_patient.first_name', 'LIKE',  '%' . $query . '%')
    	// 		->orwhere('tbl_patient.last_name', 'LIKE',  '%' . $query . '%')
    	// 		->orwhere('tbl_patient.birthdate', 'LIKE',  '%' . $query . '%')
    	// 		->where('tbl_patient_doctor.tbl_doctor_id','=',$userid)
    	// 		->get();
    	$search = DB::table("tbl_patient_doctor")
    			->select('tbl_patient.id','tbl_patient.first_name','tbl_patient.last_name','tbl_patient.birthdate')
    			->join('tbl_patient','tbl_patient_doctor.tbl_patient_pid','=','tbl_patient.id')
    			->where('tbl_patient_doctor.tbl_doctor_id','=',$userid)  
    			->where(function ($sql) use ($query) {
		                $sql->where('tbl_patient.first_name', 'LIKE',  '%' . $query . '%')
		                      ->orwhere('tbl_patient.last_name', 'LIKE',  '%' . $query . '%')
		                      ->orwhere('tbl_patient.birthdate', 'LIKE',  '%' . $query . '%');
            	})
            	->groupBy("tbl_patient.birthdate")  			
    			
    			
    			->get();

    			foreach ($search as $keysearch) {
    				$results[] = ['id' => $keysearch->id,'value' => $keysearch->first_name.' '.$keysearch->last_name.' '.$keysearch->birthdate];
    			}
    			return Response::json($results);
    }

    public function sumTime($time1, $time2){
		  $times = array($time1, $time2);
		  $seconds = 0;
		  foreach ($times as $time)
		  {
		    list($hour,$minute,$second) = explode(':', $time);
		    $seconds += $hour*3600;
		    $seconds += $minute*60;
		    $seconds += $second;
		  }
		  $hours = floor($seconds/3600);
		  $seconds -= $hours*3600;
		  $minutes  = floor($seconds/60);
		  $seconds -= $minutes*60;
		  //return "$hours:$minutes";
		  return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); 
	}

	public function deleteGcalendar(){
		$aid = $_GET['id'];

		$agendar = Agenda::where('id','=',$aid)->get()->first();
		$getpatient = Patient::where('id','=',$agendar->id_patient)->get()->first();
		$pname = $getpatient->first_name.' '.$getpatient->last_name;
		//return redirect()->action('UserController@useraccount');
		$datetimestart = new DateTime($agendar->date_start);
		$dstart =  $datetimestart->format(DateTime::ISO8601);

		$datetimeend = new DateTime($agendar->date_end);
		$dateend =  $datetimeend->format(DateTime::ISO8601);
		//start send email		
		//UserController::cancelEmail($did,$pid,$date);

		echo $dstart.'|'.$dateend.'|'.$pname.'|'.$agendar->google_id;
	}
	public function saveEventsId(){
		$aid = $_GET['aid'];
		$googleId = $_GET['googleid'];
		$insertGoogleid = Agenda::findOrFail($aid);
		$insertGoogleid->google_id = $googleId;
		if ($insertGoogleid->save()) {
			echo 1;
		}
	}
	protected function sendResetPasswordLinkToPatient($did,$pid,$date){
		$getpatient = Patient::where("id","=",$pid)->get()->first();
		$getdoctor = Doctor::where("id","=",$did)->get()->first();
		$subjectdate = DoctoLibController::generateDateSubjectEmail($date);
		$time = date('H:i', strtotime($date));

		$getHospital = hospital::where("tbl_doctor_id","=",$did)->get();
		$address = "";
		if (sizeof(sizeof($getHospital)>0)) {
			foreach ($getHospital as $key) {
				$address .= $key->address_hospital.',';
			}
			$address = rtrim($address,',');
		}


		Mail::send('emails.appointments.patientReset', ['doctor' => $getdoctor,'patient' => $getpatient,"date_email"=>$subjectdate,"time"=>$time,"address"=>$address], function ($m) use ($getpatient,$getdoctor,$subjectdate) {
    		$m->from('contact@globalsante.fr', 'Global Santé');

    		$m->to($getpatient->email, $getpatient->first_name.' '.$getpatient->last_name)->subject("Global Santé : RDV le ".$subjectdate." avec le docteur ".$getdoctor->first_name);
		});
	} 
}

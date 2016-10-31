<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\userRDV as User;
use App\DoctoLib as Doctor;
use App\Consultation as Consultation;
use App\Insurance as Insurance;
use App\Agenda as Agenda;
use App\Patient as Patient;
use App\Motif as Motif;
use App\Hospital as Hospital;
use App\Ville as Ville;
use App\Import as Import;
use App\PatientDoctor as PD;

use Session;
use Auth;
use DB;
use Hash;

class ParametersController extends Controller
{
    //
    public function showParameters(){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		return view("parameters/motifs_consultantion");
    	}
    	else{    		
    		return view("user/login",['loginerror' => '']);
    	}
    	
    }
    public function showLieu(){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		$hospital = DB::table("tbl_hospital")
    				  ->select("tbl_hospital.id as hid","tbl_hospital.name_hospital as hname","tbl_hospital.address_hospital as haddress","tbl_hospital.number_cabinet as ncabinet","tbl_hospital.fax as fax","tbl_hospital.accessibility as accessibility","tbl_hospital.interphone as interphone","tbl_hospital.digicode1 as digicode1","tbl_hospital.digicode2 as digicode2","tbl_hospital.number_depart as number_depart")
					  ->join('tbl_doctor','tbl_doctor.id','=','tbl_hospital.tbl_doctor_id')
		    	 	  ->where('tbl_doctor.id','=',$userid)
                      ->where("tbl_hospital.active","=",1)
		    	 	  ->get();
		    	 	  $chaccess1 = "";
		    	 	  $chaccess2 = "";
		    	 	  $chaccess3 = "";

		    	 	  
    			return view("parameters/lieu_consultantion",['hospital' => $hospital]);
    	}
    	else{    		
    		return view("user/login",['loginerror' => '']);
    	}
    }
    public function showinformer(){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		return view("parameters/informer_patients");
    	}
    	else{    		
    		return view("user/login",['loginerror' => '']);
    	}
    }
    public function importdonne(){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
            $getimport = Import::all();

    		return view("parameters/import",['msg' => '','imports' => $getimport]);
    	}
    	else{    		
    		return view("user/login",['loginerror' => '']);
    	}
    }

    public function submitimport(Request $r){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		$type = $r->input("type");
	    	$import = $r->file("import");
	    	$comment = $r->input("comment");
	    	$extension = $import->getClientOriginalExtension();
            $destinationPath = public_path() . "/img/file/";
	    	$size = $import->getSize();
            $name = $import->getClientOriginalName();
	    	if ($r->hasFile('import')) {
	    		if($extension == "csv" || $extension == "txt"){
	    			if ($size <= 5242880) {
	    				
                        // Move file
                        $import->move($destinationPath,$name);
                        //Read data from file
                         $handle = fopen($destinationPath.$name, "r");
                         
                         $i = 1;
                         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $partient = new Patient;
                            $partient->title = $data[0];
                            $partient->maiden_name = $data[1];
                            $partient->first_name = $data[2];
                            $partient->last_name = $data[3];
                            $partient->mobile_phone = $data[4];
                            $partient->home_phone = $data[5];
                            $partient->birthdate = $data[6];
                            $partient->email = $data[7];
                            $partient->password = $data[8];
                            $partient->user_address = $data[9];
                            $partient->cpcode = $data[10];
                            $partient->quartier = $data[11];
                            $partient->id_city = $data[12];
                            $partient->id_insurance = $data[13];
                            if ($partient->save()) {
                                $pid = $partient->id;
                                $pd = new PD;
                                $pd->tbl_patient_pid = $pid;
                                $pd->tbl_doctor_id = $userid;
                                $pd->save();
                            }

                            $i++;
                        } //end while 
 
                        $importData = new Import;
                        $importData->file_name = $name;
                        $importData->type = $type;
                        $importData->count = $i;
                        $importData->status = "Importé";
                        $importData->comment = $comment;
                        $importData->date = date('Y-m-d H:i:s');
                        if ($importData->save()) {
                             $getimport = Import::all();
                             return view("parameters/imports",['msg' => 'Les données importées','import' => $getimport]);
                        }   

                        fclose($handle);
                       
	    			}
	    		}
                else{
                    $importData = new Import;
                    $importData->file_name = $name;
                    $importData->type = $type;
                    $importData->status = "Rejeté";
                    $importData->comment = $comment;
                    $importData->date = date('Y-m-d H:i:s');

                    if ($importData->save()) {
                        $getimport = Import::all();
                        return view("parameters/import",['msg' => 'Les données importées','imports' => $getimport]);
                    }
                }
	    	}
    	}
    	else{    		
    		return view("user/login",['loginerror' => '']);
    	}    	

    }
    public function submitextrafield(Request $r){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		$hid = $r->input("hid");
            $hospital_name = $r->input("hopital");
            $adresse = $r->input("adresse");

    		$number_du_cabinet = $r->input("phone");
	    	$fax = $r->input("fax");
	    	$access = $r->input("access");
	    	$interphone = $r->input("nom");
	    	$code = $r->input("code");
	    	$code2 = $r->input("code2");
	    	$number_depart = $r->input("number_depart");
	    	//var_dump($access);
	    	$inputAcess = "000";
	    	if (sizeof($access) >0) {
	    		$sumAcess = array_sum($access);		    	
		    	if ($sumAcess == 11) {
		    		$inputAcess = "011";
		    	}
		    	else if ($sumAcess == 10) {
		    		$inputAcess = "010";
		    	}
		    	else if ($sumAcess == 1) {
		    		$inputAcess = "001";
		    	}
		    	else{
		    		$inputAcess = $sumAcess;
		    	}
	    	}
	    	else{
	    		$inputAcess = "000";
	    	}
	    	
	    	//echo $inputAcess;
	    	$updateHospital = Hospital::where('id', $hid)
	    					->update(['name_hospital' => $hospital_name,'address_hospital' => $adresse,'number_cabinet' => $number_du_cabinet,'fax' => $fax,'accessibility' => $inputAcess, 'interphone' => $interphone, 'digicode1' => $code, 'digicode2' => $code2,'number_depart' => $number_depart]);
    	
	   	 	 		    	 	  
			 return redirect('/parameters/lieu_consultation');
    		
    		
    	}
    	else{    		
    		 return redirect('/login');
    	}  
    	
    }
    public function submitHospital(Request $r){
       // echo "hello";
        $userid = Session::get('user-id');
        if (!empty($userid)) {                
            $hospital_name = $r->input("hopital");
            $adresse = $r->input("adresse");

            $number_du_cabinet = $r->input("phone");
            $fax = $r->input("fax");
            $access = $r->input("access");
            $interphone = $r->input("nom");
            $code = $r->input("code");
            $code2 = $r->input("code2");
            $number_depart = $r->input("number_depart");
            //var_dump($access);
            $inputAcess = "000";
            if (sizeof($access) >0) {
                $sumAcess = array_sum($access);             
                if ($sumAcess == 11) {
                    $inputAcess = "011";
                }
                else if ($sumAcess == 10) {
                    $inputAcess = "010";
                }
                else if ($sumAcess == 1) {
                    $inputAcess = "001";
                }
                else{
                    $inputAcess = $sumAcess;
                }
            }
            else{
                $inputAcess = "000";
            }
            $hospital = new Hospital;
            $hospital->name_hospital = $hospital_name;
            $hospital->address_hospital = $adresse;

            $hospital->number_cabinet = $number_du_cabinet;
            $hospital->fax = $fax;
            $hospital->accessibility =$inputAcess; 
            $hospital->interphone = $interphone;
            $hospital->digicode1 = $code;
            $hospital->digicode2 = $code2;
            $hospital->number_depart = $number_depart;
            $hospital->tbl_doctor_id =$userid; 
            $hospital->active =1; 
            if ($hospital->save()) {
                //echo "1";
                return redirect('/parameters/lieu_consultation');
            }
            
        }
        else{           
         return redirect('/login');
        }  
    }
    public function supprimerHospital(){
        $hid = $_GET["hid"];
        $updateHospital = Hospital::findOrFail($hid);        
        $updateHospital->active = 0;
        $updateHospital->save();
    }

    public function export(){
    	 return view("parameters/export");
    }
    public function showagenda(){
        $userid = Session::get('user-id');
        $type = Session::get('type');
        if (empty($type)) {
            if (!empty($userid)) {
                $findduration = Doctor::where("id","=",$userid)->get()->first();                
                 // for geting opening hours of doctor
                 $getopening = Agenda::where("tbl_doctor_id","=",$userid)
                             ->where("id_meeting_type","=",4)
                             ->get();
                // echo "<pre>";
                // var_dump($getopening[1]);
                // echo "</pre>";
                // echo sizeof($getopening);
                $time = "";
                $str = "";
                $str_end = '';
                $str_chk= '';                
                $str = '<tr><td>Début</td>';
                $str_end = '<tr><td>Fin</td>';
                $str_chk= '<tr><td></td>';
                foreach ($getopening as $key) {
                  $ex = explode(' ', $key->date_end);
                  $gettime = date("H:i",strtotime($key->date_start));
                  $gettimeend = date("H:i",strtotime($ex[1]));
                  $daycheck = "";
                  if ($key->daycheck == 1) {
                     $daycheck = 'checked="checked"';
                  }
                   $str_chk .= '<td><input type="checkbox" name="'.$key->daycheck.'" value="'.$key->daycheck.'" class="agenda-chk " data-day="'.$key->days.'" '.$daycheck.' data-aid = "'.$key->id.'"></td>';
                   $str .= '<td><input type="text" value="'. $gettime.'" class="inputtime '.$key->days.'" data-start= "'.$key->days.'" data-aid = "'.$key->id.'"></td>';
                   $str_end .= '<td><input type="text" value="'.$gettimeend.'" class="inputtime '.$key->days.'" data-end= "'.$key->days.'" data-aid = "'.$key->id.'"></td>';
                }
                $str .= '</tr>';
                $str_end .= '</tr>';
                $str_chk .= '</tr>';
                $time = $str_chk.''.$str.''.$str_end;
                return view("parameters/showagenda",["duration"=>$findduration->duree_creneau,"doctorid"=>$userid,'openingTime'=>$time]);

            }
            else{
                return redirect("/login");
            }
        }
        else{
            return redirect("/");
        }
       
       
    }
    public function updateduration(){
        $did = $_GET["did"];
        $duration = $_GET["duration"];
        $updatedoctoravai = Doctor::findOrFail($did);
        $updatedoctoravai->duree_creneau = $duration;
        $updatedoctoravai->update();
    }

    public function updateOpeningTime(){
        $userid = Session::get('user-id');
        if (!empty($userid)) {
           $dateType = $_GET['dateType'];
           $dayType = $_GET['dayType'];
           $time = $_GET['time'];
           $aid = $_GET['aid'];

           $find = Agenda::where("id","=",$aid)->get()->first();           
           if ( $dateType == "start") {
              $newtime = explode(' ', $find->date_start);
           }
           else{
             $newtime = explode(' ', $find->date_end);
           }
           $newdateTime = $newtime[1].' '.$time;
           $findagenda = Agenda::findOrFail($aid);
           if ( $dateType == "start") {
                $findagenda->date_start = $newdateTime;
           }
           else{
             $findagenda->date_end = $newdateTime;
           }
            $findagenda->save();
        }
        else{
          return view("user/login",['loginerror' => '']);  
        }
    }
    public function updatecheckDay(){
          $userid = Session::get('user-id');
        if (!empty($userid)) {
            $chk = $_GET["chk"];
            $aid = $_GET["aid"];
            $findchk = Agenda::findOrFail($aid);
            $findchk->daycheck = $chk;
            $findchk->save();
        }else{
          return view("user/login",['loginerror' => '']);  
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DoctoLib as Doctor;
use App\Patient as Patient;
use App\Motif as Motif;
use App\Ville as Ville;
use App\Agenda as Agenda;
use App\PatientDoctor as PD;
use App\Insurance as Insurance;
use App\AgendaMotif as AgendaMotif;
use DB;
use Response;
use Session;
use Hash;
use Mail;
use DateTime;
use Crypt;
class ConfigurationController extends Controller
{
    //

    public function moncompte(){
    	//echo "123";
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		$doctor = Doctor::where("id","=",$userid)->get()->first();
	    	$arr_smart = null;
	    	$arr_tablete = null;
	    	if (!empty($doctor->smartphone)) {
	    		$arr_smart = str_split($doctor->smartphone); 
	    	}
	    	if (!empty($doctor->tablette)) {
	    		$arr_tablete = str_split($doctor->tablette);
	    	}
	    	
	    	 
	    	return view("configuration/mon-compte",["doctor" => $doctor,"arr_smart" => $arr_smart,"arr_tablete" => $arr_tablete,'imgerror' => '']);
    	}
    	else{
    		return redirect('/login');
    	}
    	
    }
    public function uploadFile(Request $request){
		//get name
		$userid = Session::get('user-id');
		//$fun = $request->get("name");

		//get file name
		$file = $request->file('photo');
		$destinationPath = "img/uploads/";
		//$filename = "test";
		$extension = $file->getClientOriginalExtension();
		$size = $file->getSize();


		if ($request->hasFile('photo'))
		{
				// echo "string".$extension;
			if($extension == "jpeg" || $extension == "jpg" || $extension == "png" || $extension == "gif"){
			   //if file size smaller then 5MB = 5120KB =5242880byte
			   if ($size <= 5242880) {
				   	# code...
				   	$name = $file->getClientOriginalName();			  		 
				   	$file->move($destinationPath,$name);
				   //	echo $name;	
				   	$updatephoto = Doctor::findOrFail($userid);
				   	$updatephoto->photo = $name;
				   	$updatephoto->save();

				   return  redirect()->action('ConfigurationController@moncompte');

			   }
			   else{
			   		echo "big file size";

			   }
			   	
			}
			else{
					$doctor = Doctor::where("id","=",$userid)->get()->first();
			    	$arr_smart = str_split($doctor->smartphone); 
			    	$arr_tablete = str_split($doctor->tablette); 			    	
			    	return view("configuration/mon-compte",["doctor" => $doctor,"arr_smart" => $arr_smart,"arr_tablete" => $arr_tablete,'imgerror' => 'invalide type d\'image , s\'il vous plaît essayer à nouveau !']);

				   //return  redirect()->action('ConfigurationController@moncompte',['imgerror' => 'invalid image type.']);

				//return view('configuration/mon-compte', ['imgerror' => 'invalid image type.']);					
				
			}
		    
		  // 
		   
		}
		else{
		   echo "ko";
		}
	}

	public function updateprofil(Request $r){
		$userid = Session::get('user-id');
		if (!empty($userid)) {
			$fname = $r->input("first_name");
			$lname = $r->input("last_name");
			$email = $r->input("email");
			//add more fields
			$calendarapikey = $r->input("apikey");
			$calendarid = $r->input("calendarid");
			$clientid = $r->input("clientid");
			//end
			$tel = $r->input("tel");
			$sex = $r->input("homme");
			$dob = $r->input("dateofbirth");
			$fonction = $r->input("fonction");
			$smartphone = $r->input("chkphone");
			$tablette = $r->input("tablette");

			$smartphone_sum = array_sum($smartphone);
			$tablette_sum = array_sum($tablette);

			$updateProfile = Doctor::findOrFail($userid);
			$updateProfile->first_name = $fname;
			$updateProfile->last_name = $lname; 
			$updateProfile->email = $email;
			
			$updateProfile->google_calendar_apikey = $calendarapikey;
			$updateProfile->google_calendar_id = $calendarid;
			$updateProfile->google_client_id = $clientid;

			$updateProfile->phone = $tel; 
			$updateProfile->sex = $sex;
			$updateProfile->birthdate = $dob;
			$updateProfile->title = $fonction;

			$updateProfile->smartphone = $smartphone_sum;
			$updateProfile->tablette = $tablette_sum;


			if ($updateProfile->save()) {
				# code...
	    		return  redirect()->action('ConfigurationController@moncompte');
			}
		}
		else{
			return redirect('/login');
		}
		
	}

	public function lostpassword(Request $r){
		$doctorId = $r->input("doctorid");
		if (!empty($doctorId)) {
			$newpwd = Hash::make($r->input("newpwd"));
			$updatepwd = Doctor::findOrFail($doctorId);
			$updatepwd->pwd = $newpwd;
			 if ($updatepwd->save()) {
	    		return  redirect()->action('UserController@getLogout');		 	
			 } 
		}
		else{
			return redirect('/login');
		}
		
	}


	public function patients(){
		$userid = Session::get('user-id');
		//echo $userid;
		if (!empty($userid)) {
			$listPartient = DB::table('tbl_patient')
					   ->select('tbl_patient.id as pid','tbl_patient.first_name as pfirstname','tbl_patient.last_name as lname','tbl_patient.mobile_phone as phonenumber','tbl_patient.birthdate as birthdate')
					    
					   ->Join('tbl_patient_doctor','tbl_patient.id', '=', 'tbl_patient_doctor.tbl_patient_pid')					  
					   ->Join('tbl_doctor','tbl_doctor.id', '=', 'tbl_patient_doctor.tbl_doctor_id')
					   ->groupBy('tbl_patient_doctor.tbl_patient_pid')
					   ->where('tbl_doctor.id','=',$userid)
					   ->paginate(100);
			$html = "";
		

			foreach ($listPartient as $list) {
				$birthDate = "";
				$birthDate = explode("-", $list->birthdate);
				$age = "";
				//$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")? ((date("Y") - $birthDate[2]) - 1): (date("Y") - $birthDate[2]));
				$html .= '
							<tr id="tr'.$list->pid.'">
						        <td>'.$list->pid.'</td>
						        <td>'.$list->pfirstname.' '.$list->lname.'</td>
						        <td>'.$age.'</td>
						        <td>'.$list->phonenumber.'</td>
						        <td>-</td>
						        <td></td>
						        <td><a data-toggle="modal" data-pid="'.$list->pid.'" data-target="#editPatient" class="editPatient setCustor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a  class="supprimmer setCustor" style="color:red;" data-pid="'.$list->pid.'"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a style="color:#0596de;" class="setCustor sendmail" data-pid="'.$list->pid.'"><i class="fa fa-envelope" aria-hidden="true"></i></a></td>
					      	</tr> 
						';
			}

			$insurrence = Insurance::all();
			return view("configuration/patients",['partient' => $listPartient,'insurrence' =>$insurrence,'trhtml' =>$html]);
		}
		else{
			return view("user/login",['loginerror' => '']);
		}
		
	}

	public function createPatient(Request $r){
		$userid = Session::get('user-id');
		if (!empty($userid)) {
			//Insert into table partience
			//get birtdate
    		$day = $r->input("day");
    		$month = $r->input("month");
    		$year = $r->input("year");    		
    		$realYear = $day."-".$month."-".$year;
    		$checkPatient = Patient::where("email","=", $r->input("email_patient"))->get()->first();
    		if (sizeof($checkPatient) > 0) {
    			echo "0";
    		}else{
    			$partience = new Patient;
		    	$partience->title =  $r->input("title");;
		    	$partience->first_name =  $r->input("nom_de_famile");
		    	$partience->maiden_name = $r->input("nom_jeun");
		    	$partience->last_name =  $r->input("prenom");;
		    	$partience->mobile_phone =  $r->input("tel_portable");
		    	$partience->home_phone =  $r->input("tel_fix");
		    	$partience->birthdate =  $realYear;
		    	$partience->email =  $r->input("email_patient"); 
		    	$partience->password =  $r->input("password");
		    	$partience->user_address =  $r->input("adresse");
		    	$partience->cpcode =  $r->input("cp");
		    	$partience->quartier = $r->input("quartier");
		    	$partience->id_city =  $r->input("hidenvilleid");
		    	$partience->id_insurance =  $r->input("insurent");
		    	if ($partience->save()){
		    		$pid = $partience->id;
		    		$pd = new PD;
		    		$pd->tbl_patient_pid = $pid;
		    		$pd->tbl_doctor_id = $userid;
		    		if ($pd->save()) {	    			
						$listPartient = DB::table('tbl_patient')
						   ->select('tbl_patient.id as pid','tbl_patient.first_name as pfirstname','tbl_patient.last_name as lname','tbl_patient.mobile_phone as phonenumber','tbl_patient.birthdate as birthdate')					    
						   ->Join('tbl_patient_doctor','tbl_patient.id', '=', 'tbl_patient_doctor.tbl_patient_pid')					  
						   ->Join('tbl_doctor','tbl_doctor.id', '=', 'tbl_patient_doctor.tbl_doctor_id')
						   ->groupBy('tbl_patient_doctor.tbl_patient_pid')					   
						   ->where('tbl_doctor.id','=',$userid)
						   ->paginate(100);
		    			$html = "";

						foreach ($listPartient as $list) {
							$birthDate = "";
							$birthDate = explode("-", $list->birthdate);
							$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")? ((date("Y") - $birthDate[2]) - 1): (date("Y") - $birthDate[2]));
							$html .= '

								<tr id="tr'.$list->pid.'">
							        <td>'.$list->pid.'</td>
							        <td>'.$list->pfirstname.' '.$list->lname.'</td>
							        <td>'.$age.'</td>
							        <td>'.$list->phonenumber.'</td>
							        <td>-</td>
							        <td></td>
							        <td><a data-toggle="modal" data-pid="'.$list->pid.'" data-target="#editPatient" class="editPatient setCustor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a  class="supprimmer setCustor" style="color:red;" data-pid="'.$list->pid.'"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a style="color:#0596de;" class="setCustor sendmail" data-pid="'.$list->pid.'"><i class="fa fa-envelope" aria-hidden="true"></i></a></td>
						      	</tr> 
							';
						}
						echo "1";

						
		    		}	
		    	}
    		}
	    	
		}
		else{
			echo "2";
			//return view("user/login",['loginerror' => '']);
		}
    	
	}
 
	public function editPatient(){
		$pid = $_GET["pid"];
		
		$getPatient = Patient::where("id",$pid)->get()->first();		
    	$editform = "";
    	$getVille = "";
    	$vileNom = "";
	    if (!empty($getPatient->id_city)) {
	   		 $vile = Ville::where("ville_id","=",$getPatient->id_city)->get()->first();
		    	$getVille =  $vile->ville_id;
		    	$vileNom = $vile->ville_nom_reel;
	    }
	    else{
	    	$getVille = "";
	    	$vileNom = "";
	    }

	    $insur = Insurance::all();
	    $getInsurence = "";
	    foreach ($insur as $keyinsu) {
	    	if ($keyinsu->id == $getPatient->id_insurance) {
	    		$getInsurence .= '<option value="'.$keyinsu->id.'" selected="selected">'.$keyinsu->name.'</option>';
	    	}
	    	else{
	    		$getInsurence .= '<option value="'.$keyinsu->id.'">'.$keyinsu->name.'</option>';
	    	}
	    	
	    }

	    //get title
	    $titleRadio1 = "";
	    $titleRadio2 = "";
	    if ($getPatient->title == "Mme") {
	    	# code...
	    	$titleRadio1 = "checked";
	    }
	    else if($getPatient->title == "M.") {
	    	$titleRadio2 = "checked";
	    }
	    $getdate = array("","","");
	    if (!empty($getPatient->birthdate)) {	    	
	    	$getdate = explode('-', $getPatient->birthdate);
	    }
		$patient = '
				        		
        	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
        		<div class="col-md-6 padding "><span class="text-control-p"><input type="radio" name="title" class="radiotitle" value="Mme" required '.$titleRadio1.'> Mme</span></div>

        		<div class="col-md-6 padding"><span class="text-control-p"><input type="radio" name="title" class="radiotitle" value="M." required '.$titleRadio2.'> M.</span></div>
        	</div>
        	<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
        	<div class="col-md-6 col-sm-6 col-xs-6 padding">				            		
                <div class="form-group">
                	<input type="hidden" value="'.$pid.'" name="pid">
        			<input type="text" class="form-control" name="nom_de_famile" placeholder="Nom de famile" required value="'.$getPatient->first_name.'" id="nom_de_famile'.$pid.'">
        		</div>
        	</div>
        	<div class="col-md-6 col-sm-6 col-xs-6 paddingright">				            		
                <div class="form-group">
        			<input type="text" class="form-control" name="prenom" placeholder="Prénom" required value="'.$getPatient->last_name.'" id="prenom'.$pid.'">  
        		</div>          		
        	</div>
			<div class="col-md-12 col-sm-12 col-xs-12"></div>
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12 padding">
        		<input type="text" class="form-control nom_jeun" name="nom_jeun" placeholder="Nom de jeune fille" value="'.$getPatient->maiden_name.'" >
        		<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div> 
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 nopaddingright">
				<div class="col-md-4 nopaddingleft">
	                    <input type="text" class="form-control"  name="day"  placeholder="JJ" required id="dayValue'.$pid.'" onkeypress="return isNumberDay'.$pid.'(event,this)" maxlength="2" value = "'.$getdate[0].'" onfocus=this.value=""  pattern="\d*"/>					
				</div>
				<div class="col-md-4 nopaddingleft">
	                    <input type="text" class="form-control"  name="month"  placeholder="MM" required id="monthValue'.$pid.'" onkeypress="return isNumberMonth'.$pid.'(event,this)"  maxlength="2" value = "'.$getdate[1].'" onfocus=this.value="" pattern="\d*" />				
					
				</div>
				<div class="col-md-4 nopaddingleft">
	                    <input type="text" class="form-control"  name="year"  placeholder="AAAA" required id="yearValue'.$pid.'" onkeypress="return isNumberYear(event,this)"  maxlength="4" value = "'.$getdate[2].'" onfocus=this.value="" pattern="\d*"/>						
				</div>

			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12 padding">	
				<div class="control-group">
					<div class="form-group controls">
            			<input type="email" class="form-control" name="email_patient" id ="email_patient" placeholder="Email du patient"   value="'.$getPatient->email.'">
						<div class="help-block"></div>
					</div>	
				</div>								
                								
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 nopaddingright">
				 <div class="form-group">
				 									 	
				 </div>
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12"></div>
			<div class="col-md-6 col-sm-6 col-xs-6 padding">									
                <div class="form-group">
        			<input type="text" class="form-control" name="tel_portable" placeholder="Téléphone portable" required value="'.$getPatient->mobile_phone.'" maxlength="10" maxlength="10" id="tel_portable'.$pid.'">  
        				<span class="error_phone_tel'.$pid.'">Numéro de téléphone invalide</span>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 paddingright">				            		
	            <div class="form-group">
        			<input type="text" class="form-control" name="tel_fix" placeholder="Téléphone fixe" value="'.$getPatient->home_phone.'" maxlength="10" id="tel_fix'.$pid.'">
        			<span class="error_phone_tel_fix'.$pid.'">Numéro de téléphone invalide</span>
				</div>
			</div>
			

			<div class="col-md-12 col-sm-12 col-xs-12 ">&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12 padding">
				<div class="form-group">
        			<input type="text" class="form-control" name="adresse" placeholder="Adresse" required value="'.$getPatient->user_address.'">					
				</div>
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-md-4 col-sm-4 col-xs-4 padding">
				
        		<input type="text" class="form-control" name="quartier" placeholder="Quartier"  data-maxlength="20" value="'.$getPatient->quartier.'">					

			</div>
			<div class="col-md-8 col-sm-8 col-xs-8 paddingright">
                <div class="form-group">                
        			<input type="text" class="form-control" name="ville" placeholder="Ville" id="ville_auto_edit'.$pid.'" value="'.$vileNom.'" required>					
                    <input type="hidden" name="hidenvilleid" id="hidenvilleidedit" value="'.$getVille.'">
                </div>
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-md-4 col-sm-4 col-xs-4 padding">				            		
        		<div class="form-group"> 
        			<input type="text" class="form-control cp" name="cp" placeholder="Code postal"  maxlength="5" value="'.$getPatient->cpcode.'" id="cp'.$pid.'">					
				</div>				
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8 paddingright">
				<select class="form-control" name="insurent" >
        		  '.$getInsurence.'
        		</select>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
        	<div class="clear"> </div>
        	<div class="modal-footer remove-modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
	          <button type="submit" class="btn btn-primary btnupdate custombtn">Modifier</button>
	        </div> 
	';
	echo $patient;
?>
	<script type="text/javascript">
		//<![CDATA[
		$(document).ready(function(){
			validateCP("cp");
			$(".error_phone_tel<?php echo $pid ?>").hide();
			$(".error_phone_tel_fix<?php echo $pid ?>").hide();
			phonenumbervalidation("tel_portable<?php echo $pid ?>","error_phone_tel<?php echo $pid ?>");
			phonenumbervalidation("tel_fix<?php echo $pid ?>","error_phone_tel_fix<?php echo $pid ?>");
				$("#ville_auto_edit<?php echo $pid;?>").autocomplete({
				  source: function( request, response ) {
		            $.ajax({
		                url: '<?php echo url('/villeauto');?>',
		                dataType: "json",
		                data: {
		                    q: request.term
		                },
		                success: function(data) {
		                	//alert(data);
		                	if(!data.length){
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
				                        cp: obj.cp
				                    };
		                		}));
						     }
		                    
		                }
		            });
		        },
		        minLength: 3,
		        select: function(event, ui) { 
			        $("#hidenvilleidedit").val(ui.item.id);
			        $("#cp<?php echo $pid; ?>").val(ui.item.cp);
			        
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
		    customTextStyle("nom_de_famile<?php echo $pid;?>","uppercase");
			customTextStyle("prenom<?php echo $pid;?>","capitalize");
		    
		});
		//]]>
			function isNumberDay<?php echo $pid;?>(evt,val) {
					var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};

					var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;
					

					if( key >= 48 && key <= 57 ){

						var valueKey = numArray[key];
						// alert(valueKey);
						// alert(val.value);
						var ex = /^(0?[0-9]|[0-9][0-9]){1}$/;
						//var value;
						if (val.value){
							// if(val.value < 100 ){
							// 	var value = valueKey;
							// }else{
							var value = val.value + "" + valueKey;
							// }
					    	
					    }else{
					    	var value = valueKey;
					    }
						//alert(value);
						if (value<32)
						{
							var returned =  ex.test(value);
							var valTxt = "" + value;
							//alert(valTxt.length);
							if (numArray[key] > 3 || value > 9 || valTxt.length == 2) 
							{
								//alert(4534534);
								$('#monthValue<?php echo $pid;?>').focus();
								$('#dayValue<?php echo $pid;?>').val($('#dayValue<?php echo $pid;?>').val()+""+numArray[key]);
								// $("#dayValue").next('#monthValue').focus();
		   			// 			$('#monthValue').val(numArray[key]);

								if (value <10 && $('#dayValue').val().length <2)
									$('#dayValue<?php echo $pid;?>').val("0"+value);
								else $('#dayValue<?php echo $pid;?>').val(value);
									returned = false;
							}
							return returned;
						}
						else {
							//alert(2);
							//console.log($('#monthValue').focus());
							$('#monthValue<?php echo $pid;?>').focus();
							$('#monthValue<?php echo $pid;?>').val(numArray[key]);
							///alert(numArray[key]);
							return false;
						}
					}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
						return true;
					
					}else{
						return false;
					}
			    
			}

			function isNumberMonth<?php echo $pid;?>(evt,val) {
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
							
							$('#yearValue<?php echo $pid;?>').focus();
							if (value <10)
							$('#monthValue<?php echo $pid;?>').val("0"+value);
							else $('#monthValue<?php echo $pid;?>').val(value);
							returned = false;
							//alert(value + " - "+ $('#monthValue').val()+ " - "+numArray[key]);
						}
						setTimeout(function(){
							if ($('#monthValue<?php echo $pid;?>').val().length==2)
							$('#yearValue<?php echo $pid;?>').focus();//console.log($('#monthValue').val().length);
						}, 100);
						//console.log (ex2.test(value) + " " +$('#monthValue').val() + " " + valTxt.length + " "+value.length );
						return returned;
					} else {
						$('#yearValue<?php echo $pid;?>').focus();
						$('#yearValue<?php echo $pid;?>').val(numArray[key]);
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
			function customTextStyle(ele,type){
				$("#"+ele).bind('keyup', function (e) {
				if (e.which >= 97 && e.which <= 122) {
			        var newKey = e.which - 32;
			        // I have tried setting those
			        e.keyCode = newKey;
			        e.charCode = newKey;
			    }

			    if (type == "uppercase") {
			    	$("#"+ele).val(($("#"+ele).val()).toUpperCase());
			    }
			    else{
			    	var str = $("#"+ele).val();
				    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					    return letter.toUpperCase();
					});
					$("#"+ele).val(str);
			    }
			});
			 
	}
	</script>
<?php
	}


	public function updatePatient(Request $r){
		$userid = Session::get('user-id');
		if (!empty($userid)) {
			$day = $r->input("day");
    		$month = $r->input("month");
    		$year = $r->input("year");    		
    		$realYear = $day."-".$month."-".$year;

			$pid = $r->input("pid");
			$partience = Patient::findOrFail($pid);
	    	$partience->title =  $r->input("title");
	    	$partience->first_name =  $r->input("nom_de_famile");
	    	$partience->maiden_name = $r->input("nom_jeun");
	    	$partience->last_name =  $r->input("prenom");
	    	$partience->mobile_phone =  $r->input("tel_portable");
	    	$partience->home_phone =  $r->input("tel_fix");
	    	$partience->birthdate =  $realYear;
	    	$partience->email =  $r->input("email_patient");
	    	$partience->password =  $r->input("password");
	    	$partience->user_address =  $r->input("adresse");
	    	$partience->cpcode =  $r->input("cp");
	    	$partience->quartier = $r->input("quartier");
	    	$partience->id_city =  $r->input("hidenvilleid");
	    	$partience->id_insurance =  $r->input("insurent");
		    	if ($partience->update()){
		    		$listPartient = DB::table('tbl_patient')
						   ->select('tbl_patient.id as pid','tbl_patient.first_name as pfirstname','tbl_patient.last_name as lname','tbl_patient.mobile_phone as phonenumber')
						    
						   ->Join('tbl_patient_doctor','tbl_patient.id', '=', 'tbl_patient_doctor.tbl_patient_pid')					  
						   ->Join('tbl_doctor','tbl_doctor.id', '=', 'tbl_patient_doctor.tbl_doctor_id')
						   ->where('tbl_doctor.id','=',$userid)
						   ->paginate(5);
		    			$insurrence = Insurance::all();
						return  redirect()->action('ConfigurationController@patients',['partient' => $listPartient,'insurrence' =>$insurrence]);
		    	}
		}
		else{
			return view("user/login",['loginerror' => '']);
		}
	}

	public function destroyPatient(){
		$pid = $_GET["pid"];
		Patient::destroy($pid);
		PD::where("tbl_patient_pid","=",$pid)->delete();

	}
	public function sendmail(){
		$id = $_GET["pid"];

		$getCurentUser = Patient::findOrFail($id);
			//start send sent to admin
			$admin = Mail::send('emails.user', ['user' => $getCurentUser], function ($m) use ($getCurentUser) {
        		$m->from('contact@globalsante.fr', 'Global Santé');

        		$m->to('contact@globalsante.fr', $getCurentUser->first_name.' '.$getCurentUser->last_name)->subject("Un nouvel utilisateur Patient vient de s'enregistrer");
    		});				
			Session::put('pass', $getCurentUser->password);
			//generate url for confirmation							
            $id_encrypted = Crypt::encrypt($id);
            $url = url('email/confirmation/'.'patient/id/'.$id_encrypted);
			//start send email to user
			$user = Mail::send('emails.patient', ['url' => $url], function ($m) use ($getCurentUser) {
        		$m->from('contact@globalsante.fr', 'Global Santé');

        		$m->to($getCurentUser->email, $getCurentUser->first_name.' '.$getCurentUser->last_name)->subject("Veuillez confirmer votre inscription sur Global Santé");
    		});

			$pass = Hash::make($getCurentUser->password);
			$getCurentUser->password = $pass;
			$getCurentUser->save();


	}
	
}

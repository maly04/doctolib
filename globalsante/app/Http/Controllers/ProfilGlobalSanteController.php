<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OtherInfomation as OI;
use App\MoyenDoctor as MD;

use Session;

class ProfilGlobalSanteController extends Controller
{
    public function index(){
      $userid = Session::get('user-id');
      $getmd = MD::where("tbl_doctor_id","=", $userid)->get();
      return view("profil/index",['md' => $getmd]);
    }
   public function submitMoyens(Request $r){
   			$checkBox = $r->input("checkbox"); 
        $userid = Session::get('user-id');
        $getmd=MD::where("tbl_doctor_id","=", $userid)->delete();

			for ($i=0; $i<sizeof($checkBox); $i++)
        	{
            $md = new MD;
            $md->tbl_moyen_id = $checkBox[$i];
            $md->tbl_doctor_id =  $userid;
            $md->save();	
			}
      $getmd = MD::where("tbl_doctor_id","=", $userid)->get();
      return view("profil/index",['md' => $getmd]);

    
			// echo $data;
   }
    public function formations(){
    	$getOI = OI::where("tbl_type_id","=",1)->get();
    	return view("profil/formations",['oi' => $getOI]);
    }
    public function submitFormation(Request $r){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		$formations = $r->input("formations");
	    	$oi = new OI;
	    	$oi->info = $formations;
	    	$oi->tbl_doctor_id = $userid;
	    	$oi->tbl_type_id = 1;
	    	$oi->save();
	    	$getOI = OI::where("tbl_type_id","=",1)->get();
    		return view("profil/formations",['oi' => $getOI]);
    	}
    	else{
    		return redirect("/login");
    	}  		

    }
    public function submitAutre(Request $r){
    	$userid = Session::get('user-id');
    	if (!empty($userid)) {
    		$formations = $r->input("formations");
	    	$oi = new OI;
	    	$oi->info = $formations;
	    	$oi->tbl_doctor_id = $userid;
	    	$oi->tbl_type_id = 2;
	    	$oi->save();
	    	$getOI = OI::where("tbl_type_id","=",2)->get();
    		return view("profil/autre-information",['oi' => $getOI]);
    	}
    	else{
    		return redirect("/login");
    	}  		

    }
    public function deleteoi(){
    	$oi = $_GET["oi"];
    	OI::destroy($oi);
    }
    public function editoi(){
    	$text = $_GET["text"];
    	$oi = $_GET["oi"];
    	$findoi = OI::findOrFail($oi);
    	$findoi->info = $text;
    	$findoi->update();

    }
    public function autresInformations(){
    	$getOI = OI::where("tbl_type_id","=",2)->get();
    	return view("profil/autre-information",['oi' => $getOI]);
    }

}

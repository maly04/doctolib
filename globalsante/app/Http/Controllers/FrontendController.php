<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DoctoLib as doctoLib;
use App\Hospital as hospital;
use App\Specialties as Specialty;
use DB;
use Session;


class FrontendController extends Controller
{
   public function index()
	{
		$specialty = Specialty::all();
		$getDoc = DB::table('tbl_doctor')                     
                    ->groupBy('email')
                    ->get();
		$getHos = hospital::all();
		
		return view("home/index",['spe'=>$specialty,'docto'=> $getDoc,'hospi'=>$getHos]);
	}

	public function autocomplete(){
		$getDoc = doctoLib::all();
		$getHos = hospital::all();
		

	}
	public function search(Request $request)
	{
		//For validate
		//$vspe = $this->validate($request, [
		$vspe = Validator::make($request->all(), [	 
	        'form-control-spe' => 'required'
    	]);
		$vville = Validator::make($request->all(), [	
			'ville' => 'required'
		]);
		if ($vspe->fails()){
		    return redirect()->back()->withErrors($vspe->errors());
		 //    echo "vspe";
			// exit();
		}

		else if ($vville->fails()){
		    return redirect()->back()->withErrors($vville->errors());

			//  echo "vville";
			// exit();
		}
		else{
			//Start get variable
			$sep_id = $request->input('form-control-spe');
			$v = $request->input('ville');
			Session::put('getville', $v);
			$ville = str_replace(' ', '', strtolower(str_replace(',', '-', $v)));
			$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
	 		$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");
	 		$ville = str_replace($search, $replace, $ville);
			$sepecialist_id = Specialty::where('id','=',$sep_id)->get()->first();
			$sname = strtolower(str_replace(' ', '-', $sepecialist_id->name));
			$sname = str_replace($search, $replace, $sname);
			$getArrCity = $request->get("arr");
			Session::put('arr_city', $getArrCity);

			// echo "<pre>";
			// var_dump($getArrCity);
			// echo "</pre>";

			// die();
			if (empty($getArrCity)) {
				  return redirect()->back()->with('message', 'Il n\'y a pas de résultat pour votre recherche');
			}
			else{
				return redirect()->action('DoctoLibController@searchreult',[$sname,$ville,$sep_id]);
			}
			// echo "<pre>";
			// var_dump($getArrCity);
			// echo "</pre>";
			// die();
			// $cities = "";
			// foreach ($getArrCity as $key) {
			// 	$cities .= $key."*";
			// }

			// $sepecialist_id = Specialty::all();	
			// $vile = str_replace('-', ',', $ville);
			// $vile = ucfirst(str_replace('e', 'é', str_replace('-', ',', $vile)));
			// if(Session::has('getville'))
			// {
			// 	$getville = Session::get('getville');
			// }
			// else
			// {
			// 	$getville="";
			// }
			// $list_docto = DB::table('tbl_hospital')
			// ->select("tbl_doctor.id as did","tbl_doctor.first_name as first_name","tbl_doctor.last_name as last_name","tbl_specialties.name as name","tbl_specialties.name as name","tbl_hospital.address_hospital as address_hospital","tbl_hospital.name_hospital as name_hospital")
			// ->join('tbl_doctor', 'tbl_hospital.tbl_doctor_id','=', 'tbl_doctor.id')
	  //       ->join('tbl_spe_doc', 'tbl_doctor.id', '=', 'tbl_spe_doc.tbl_doctor_id')
	  //       ->join('tbl_specialties', 'tbl_specialties.id', '=', 'tbl_spe_doc.tbl_specialties_id')        
	  //       ->where('tbl_specialties.id', $sep_id)
	  //       ->where('tbl_hospital.address_hospital','LIKE','%'.$ville.'%')
	  //       ->groupBy("tbl_doctor.first_name")
	  //       ->get(); 
	          
	  //       $count_total = count($list_docto);  
			// $getSpe = Specialty::where('id','=',$sep_id)->get()->first();

			// return view("doctoLib/index",["specialty" =>$sepecialist_id,"spec_id"=>$sid,"ville"=>$getville,"docto"=>$list_docto,"total_result"=>$count_total,"speName"=>$getSpe,'speid'=>$spe_id,'ville_link'=>$ville]);



			// echo $sname.'|'.$ville.'|'.$sep_id."|".rtrim($cities,'||');
			
		   
		}  // return redirect()->action('DoctoLibController@searchreult',[$sname,$ville,$sep_id]);


	}
	public function create(Request $r)
	{

	}
	public function store(Request $request)
	{
		$vspe = $this->validate($request, [
	        'hospitalName' => 'required'
    	]);

		 if ($vspe->fails())
		 	//var_dump($vspe->errors());
		    return redirect()->back()->withErrors($vspe->errors());

		//return ("views/home/index");

	}
	public function searchnearby(){
		header('Content-type: application/json');
		$location=$_GET['location'];
		// echo "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$_GET['location']."&sensor=true&key=".$_GET['key']."&radius=".$_GET['radius']."&types=hospital";
   		echo file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$_GET['location']."&sensor=true&key=".$_GET['key']."&radius=".$_GET['radius']."&types=hospital,clinic&keyword=hospital,clinic");

   		// echo file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=paris&sensor=true&key=".$_GET['key']."&radius=".$_GET['radius']."&types=hospital,clinic");

   		 // .
      // "location=-" . $_GET['location'] .
      // "&radius=" . $_GET['radius'] .
      // "&sensor=" . $_GET['sensor'] .
      // "&key=" .$_GET['key']);
	}
	

}

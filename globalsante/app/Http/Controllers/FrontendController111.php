<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DoctoLib as doctoLib;
use App\Hospital as hospital;
use App\Specialties as Specialty;



class HomeController extends Controller
{
    //
	public function index()
	{
	 	//
		$specialty = Specialty::all();
		$getDoc = doctoLib::all();
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
		if ($vspe->fails())
		    return redirect()->back()->withErrors($vspe->errors());

		if ($vville->fails())
			return redirect()->back()->withErrors($vville->errors());
		
			//Start get variable
			$sep_id = $request->input('form-control-spe');
			$v = $request->input('ville');
			$ville = str_replace(' ', '', strtolower(str_replace(',', '-', $v)));
			//$sid = strtolower(str_replace(' ', '-', $sep_id));
			$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");

	 		$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");
	 		//$sid = str_replace($search, $replace, $sid);
	 		$ville = str_replace($search, $replace, $ville);
			$sepecialist_id = Specialty::where('id','=',$sep_id)->get()->first();
			$sname = strtolower(str_replace(' ', '-', $sepecialist_id->name));
			$sname = str_replace($search, $replace, $sname);
			// var_dump($sepecialist_id);
			// foreach ($sepecialist_id as $key => $value) {
			// 	# code...
			// 	echo $key;
			// }
			//echo $sepecialist_id->name;

			//echo "test";

			//return view("doctoLib/index",["specialty" =>$sepecialist_id,"spec_id"=>$speciality,"ville"=>$ville]);
		     //return redirect('doctoLib/index',["specialty" =>$sepecialist_id,"spec_id"=>$speciality,"ville"=>$ville]);
		     return redirect()->action('DoctoLibController@searchreult',[$sname,$ville,$sep_id]);
		    // return view("doctoLib/index",[$sid][$ville]);


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

	
}

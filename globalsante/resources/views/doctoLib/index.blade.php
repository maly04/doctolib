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
use Response;
use Mail;
 ?>
@extends("layout")

@section("content")
	<section class="row customrow">
		<div class="col-md-4 col-sm-12 col-xs-12 nopadding">
			<form method="post" action="{!! action('FrontendController@search') !!}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col-md-12 col-sm-12 col-xs-12 divspe nopadding">	
					<h1 class="trovez">Trouver un {{$speName->name}} à {{$ville}}</h1>
					<div class="form-group form-group-responsive">			 
					<select class="select-combo form-control form-control-spe" name="form-control-spe" id="form-control-spe">
					 	<option value="" disabled selected></option>
						@foreach($specialty as $spes)
						<option {{ $spes->id == $speid ? 'selected="selected"': '' }} value="{{$spes->id}}">{{$spes->name}}</option>
						@endforeach
					</select>	
					</div>				  
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">				
					<div class="form-group form-group-responsive">
						<input type="text" class="form-control custom-form-control-adress" name="ville" value="{{$ville}}" id="name_vile">
						<input id="address-detail" type="hidden" name="address-detail"/>
						 <div class="contain-hidden"> 
                <?php 
                  if(Session::has('arr_city')){
                    $arr_city = Session::get('arr_city');
                    $i=0;
                    foreach ($arr_city as $key_arr) {
                      echo '<input type="hidden" name="arr['.$i.']" value="'.$key_arr.'" />';
                      $i++;
                    }
                  }
                ?>                           
             </div>
             <input type="hidden" name="latlng" id="latlng">
             <input type="hidden" name="allcity" id="allcity">
            
					</div>
					<div class="form-group form-group-responsive">
						<button type="submit" class="btn btn-warning custombtn searchbtn">
	                        <!-- <span class="glyphicon glyphicon-search"></span> -->
	                       Trouver un praticien
	                    </button>
					</div>
					<span class="searchByNom"><a href="<?php echo URL::to('/'); ?>">Rechercher par nom</a></span>
				</div>
			</form>
		</div>
		<div class="col-md-8 col-sm-12 col-xs-12 nopadding padding-destop">
			<div id="map"></div>
		</div>
	</section>
	<section class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
		<h1 class="result-dentis">Réserver en ligne un RDV avec un {{$speName->name}} dans les environs de {{$ville}}</h1>
		    <?php $num=1; ?>
		    @foreach($docto as $doctoInfo)
		    	<?php 
		    		$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
 					$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");
 					$dname = strtolower(str_replace(' ', '-', $doctoInfo->first_name));
 					$dname = str_replace($search, $replace, $dname);
 				?>

		 		<div class="col-md-12 col-sm-12 col-xs-12 each-record nopadding" id="tr<?php echo $num; ?>">
					<div  class="profile-pic col-md-4 col-sm-12 col-xs-12 nopadding">
						<!-- <div class="profile-pic col-md-4 col-sm-12 col-xs-12 nopadding"> -->
		        		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
		        			<span class="dr-name"><button class="btn btn-info btn-circle"><?php echo $num;?></button>
		        			<a  class="doctoinfo{{$doctoInfo->did}}" data-user-id="{{$doctoInfo->did}}" href="{!! action('DoctoLibController@doctoInfo',['sp'=>$spec_id,'vil'=>$ville_link,'doctoName'=>$dname,'did'=>$doctoInfo->did]) !!}">{{$doctoInfo->first_name}} {{$doctoInfo->last_name}}</a></span><br>
		        			
		        		</div>
		        		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">&nbsp;</div>
		        		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
		        			<div class="col-md-4 col-sm-6 col-xs-12 nopadding">
		        				<a href="{!! action('DoctoLibController@doctoInfo',['sp'=>$spec_id,'vil'=>$ville_link,'doctoName'=>$dname,'did'=>$doctoInfo->did]) !!}">
		        					<img src="{{asset('img/hospi.jpg')}}" class="img-responsive img-thumbnail">
		        				</a>
		        			</div>
		        			<div class="col-md-4 col-sm-6 col-xs-12">
		        				<span class="dr-spe">{{$doctoInfo->name}}</span><br>
		        				<span class="dr-hospital">{{$doctoInfo->name_hospital}}</span><br>
		        				<span class="h-address">{{$doctoInfo->address_hospital}}</span><br>
		        					<a href="{!! action('DoctoLibController@doctoInfo',['sp'=>$spec_id,'vil'=>$ville_link,'doctoName'=>$dname,'did'=>$doctoInfo->did]) !!}"><button type="submit" class="btn btn-primary custombtn">Prendre rendez-vous</button></a>		        				
		        			</div>
		        		</div>
					</div>
					<div  class="col-md-8 col-sm-12 col-xs-12 nopadding">
						<div class="table-slide col-md-12 col-sm-12 col-xs-12 custom-table">
						<?php echo  DoctoLibController::generateDoctoAvailability($doctoInfo->did); ?> 			

		        		</div> <!-- end table slide -->
					</div>
				</div>	
		       <?php $num++; ?>   
		       @endforeach
		</div>
	</section>
<!-- Modal -->
<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   Attention, à lire avant de prendre un RDV
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">    
                <p>Lors du RDV pensez à prendre votre carte vitale. Pour les CMU : Carte vitale + Attestation sécurité sociale</p>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-cancel"
                        data-dismiss="modal">
                            Retourner aux horaires
                </button>
                <button type="button" class="btn btn-info continue-reservation">
                   Continuer ma réservation
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@parent
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyAG-DuEfm3XJF0_Zg8Oi7kO2pwirjgg7bg&signed_in=true">
 </script>  -->
<script type="text/javascript">

var geocoder;
var map;
var markers = [];


function initialize() {
	//for loading auto complete
	var options = {
	   types: ['geocode'],
	   componentRestrictions: {country: 'fr'}
	};	
	var input = document.getElementById('name_vile');
	autocomplete = new google.maps.places.Autocomplete(input, options);
	/* Event listener on change of autocomplete input */
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
    	var address = document.getElementById('address-detail').value = document.getElementById('name_vile').value;
    	var latlng = (autocomplete.getPlace().geometry.location).toString().replace('(','').replace(')','').replace(' ','');
        document.getElementById('latlng').value = latlng;
        $(".searchbtn").prop('disabled', true);
        // console.log(latlng);
            var arr_city = [];
               $.ajax({
                  url: '{!! action("FrontendController@searchnearby") !!}',                             
                  // dataType: "json",
                  data: "location="+latlng+"&radius=25000&sensor=false&key=AIzaSyAG-DuEfm3XJF0_Zg8Oi7kO2pwirjgg7bg",
                  type: "GET",
                  success: function( data ) {
                    // console.log(data);
                    $(".contain-hidden").html("");
                    for(var i in data.results){
                      arr_city.push(data.results[i].vicinity);
                      // alert(1);
                      $(".contain-hidden").append('<input type="hidden" name="arr['+i+']" value="'+data.results[i].vicinity+'" />');
                      // console.log(data.results[i].vicinity);
                    }
                    $(".searchbtn").prop('disabled', false);
                     
                  },
                  error: function (request, status, error) {
                    //handle errors
                  }
                });
               console.log(arr_city);
  	});
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBo2-LQDiBzMf-bTzLo1qc5WuOdFMzfX2U&callback=initialize&libraries=places"></script>
<script type="text/javascript">
// New google map multiple pin
var locations = [
 @foreach($docto as $doctoInfo)
   ['{{$doctoInfo->name_hospital}}','{{$doctoInfo->address_hospital}}'],
  @endforeach
];

  var delay = 100;
  var infowindow = new google.maps.InfoWindow();
  var latlng = new google.maps.LatLng(46.552664, 2.422229);
  var mapOptions = {
    zoom: 10,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("map"), mapOptions);
  var bounds = new google.maps.LatLngBounds();
var nextAddress = 0;
var i = 1;
  function geocodeAddress(address, next) {
    // alert(next);
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var lat=p.lat();
          var lng=p.lng();
          createMarker(address,lat,lng,nextAddress);
        }
        else {
           if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            nextAddress--;
            delay++;
          } else {
          }   
        }
        next();
        i++;
      }
    );
  }
 function createMarker(add,lat,lng,nextAddress) {
 
   var contentString = add;
   var pinNumber = nextAddress;
   var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat,lng),
     map: map,
     icon: "{{asset('img/pin.png')}}",
           });
  

  google.maps.event.addListener(marker, 'click',  function () {
     infowindow.setContent(contentString); 
     infowindow.open(map,marker);               
       marker.setIcon("{{asset('img/pin-blue.png')}}");
       document.getElementById('tr'+pinNumber).scrollIntoView();
      
  });


   bounds.extend(marker.position);

 }  
  
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext)', delay);
      nextAddress++;
    } else {
      map.fitBounds(bounds);
    }
    console.log(locations);
  }
  theNext();
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".dr-work-time-hide").hide();
		$(".voir-plus").on("click",function(){
			// $(this).parent().nextAll(".dr-work-time-hide").show();
			// $(this).parent().remove();
      $(this).parent().prevAll(".dr-work-time-hide").show();
      $(".eachday").attr("style","height:700px;");
      $(this).parent().remove();
		});	
	});
</script>



@stop
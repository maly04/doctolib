@extends("layout")

@section("content")
<section class="row customrow">
	<div class="col-md-6 col-sm-12 col-xs-12 nopadding padding-right">
		@foreach($doctor_info as $docto)
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding ">			
			<div class="profil col-md-4 col-sm-4 col-xs-4 nopadding addpadding">
				<img src="{{asset('img/hospi.jpg')}}" class="img-responsive img-thumbnail">
			</div>
			<div class="col-md-5 col-sm-5 col-xs-5 nopadding addpadding">
				<h1 class="detail-dname">{{$docto->last_name}} {{$docto->first_name}} </h1>			
					
					<?php
					$temp="";		
					foreach ($speciality as $speciality) {
						$temp.= $speciality->name.", ";
					}
					$trimmed=rtrim($temp,', ');
					?>
					<span class="specialist">	
					<?=$trimmed?>	
					</span>
					

				
			</div>			
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 blog-info nopadding">
			<p class="doctoinfo">
				Information of doctor {{$docto->info}}	
			</p>
		</div>
		@endforeach
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12 nopadding">
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<a href="#" class="btn btn-info col-md-12 col-sm-12 col-xs-12 custombtn">Prendre rendez-vous en ligne</a>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding resum-info">
				<div class="info-address col-md-12 col-sm-12 col-xs-12">
					<h1>{{$firstHospital->name_hospital}} </h1>
					<p>{{$firstHospital->address_hospital}}</p>
				</div>
				<a class="link-view-map col-md-12 col-sm-12 col-xs-12">Voir la carte et les informations d'accès</a>
				<div class="col-md-12 col-sm-12 col-xs-12 box-info">
					<div class="col-md-2 col-sm-2 col-xs-2 nopadding seticon">
						
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 nopadding other-info ">
						<h1>Tarif de la consultation</h1>
						<p> Conventionné secteur 1</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="row rowpre">
	<div class="col-md-12 col-sm-12 col-xs-12 addpadding ">
		<h1 class="prenez"> Prenez un rendez-vous directement en ligne</h1>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">		
		<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		<div class="col-md-1 col-sm-2 col-xs-2 nopadding">
			
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<p> Choisissez une date et une heure de rendez-vous sur le calendrier</p>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-1 col-sm-12 col-xs-12">&nbsp;</div>
		<div class="col-md-12 col-sm-12 col-xs-12 slide-responsive detailslider">
			<div class="table-slide col-md-12 col-sm-12 col-xs-12 custom-table">
						{!! $timeAvaliability!!}
		    </div> <!-- end table slide -->

			
		</div>
	</div>
</section>
<section class="row list-info">
	<div class="col-md-6 col-sm-12 col-xs-12 nopadding">
		<h1><span class="glyphicon glyphicon-map-marker"></span> Informations d'accès</h1>
		<ul>
			 @foreach($hospital as $hos)
				<li>{{$hos->address_hospital}}</li>
		 	 @endforeach
	 	</ul>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12 nopadding">
		<div id="detail-map">
			
		</div>
	</div>
</section>
<section class="row moyen-paiment">
	<div class="col-md-6 col-sm-12 col-xs-12 nopadding">
		<h1><span class="glyphicon glyphicon-th-large"></span> Moyens de paiement</h1>
		<ul>
		
			@foreach($moyen as $moyens)
				<li>{{$moyens->name}}</li>
			@endforeach
			
		</ul>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12 nopadding">
		<h1><span class="glyphicon glyphicon-info-sign"></span> Autres informations</h1>
		<ul>
			@foreach($autre as $autres)
				<li>{{$autres->info}}</li>
			@endforeach
		</ul>
	</div>
</section>
<section class="row formation">
	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
		<h1><span class="glyphicon glyphicon-hdd"></span> Formations</h1>
		<ul>
			@foreach($formation as $formations)
				<li>{{$formations->info}}</li>
			@endforeach
		</ul>
	</div>
</section>

@endsection

@section('js')
@parent
<!--  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false?key=AIzaSyAG-DuEfm3XJF0_Zg8Oi7kO2pwirjgg7bg&signed_in=true">
 </script>  -->
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyAG-DuEfm3XJF0_Zg8Oi7kO2pwirjgg7bg&signed_in=true">
 </script> 
 <script type="text/javascript">
  var delay = 100;
  var infowindow = new google.maps.InfoWindow();
  var latlng = new google.maps.LatLng(46.552664, 2.422229);
  var mapOptions = {
    zoom: 5,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("detail-map"), mapOptions);
  var bounds = new google.maps.LatLngBounds();

  function geocodeAddress(address, next) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var lat=p.lat();
          var lng=p.lng();
          createMarker(address,lat,lng);
        }
        else {
           if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            nextAddress--;
            delay++;
          } else {
                        }   
        }
        next();
      }
    );
  }
 function createMarker(add,lat,lng) {
   var contentString = add;
   var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat,lng),
     map: map,
     icon: "{{asset('img/pin.png')}}",
           });

  google.maps.event.addListener(marker, 'click', function() {
     infowindow.setContent(contentString); 
     infowindow.open(map,marker);
   });

   bounds.extend(marker.position);

 }
  // var locations = [
  //          'New Delhi, India',
  //          'Mumbai, India',
  //          'Bangaluru, Karnataka, India',
  //          'Hyderabad, Ahemdabad, India',
  //          'Gurgaon, Haryana, India',
  //          'Cannaught Place, New Delhi, India',
  //          'Bandra, Mumbai, India',
  //          'Nainital, Uttranchal, India',
  //          'Guwahati, India',
  //          'West Bengal, India',
  //          'Jammu, India',
  //          'Kanyakumari, India',
  //          'Kerala, India',
  //          'Himachal Pradesh, India',
  //          'Shillong, India',
  //          'Chandigarh, India',
  //          'Dwarka, New Delhi, India',
  //          'Pune, India',
  //          'Indore, India',
  //          'Orissa, India',
  //          'Shimla, India',
  //          'Gujarat, India'
  // ];
  var locations = [
	 @foreach($hospital as $hos)
	   ['{{$hos->name_hospital}}','{{$hos->address_hospital}}'],
	  @endforeach
	];
  var nextAddress = 0;
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext)', delay);
      nextAddress++;
    } else {
      map.fitBounds(bounds);
    }
  }
  theNext();

</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".dr-work-time-hide").hide();
		$(".voir-plus").on("click",function(){
			$(this).parent().prevAll(".dr-work-time-hide").show();
			$(".eachday").attr("style","height:700px;");
			$(this).parent().remove();
		});
	});
</script>
<!-- <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG-DuEfm3XJF0_Zg8Oi7kO2pwirjgg7bg &signed_in=true&callback=theNext"></script> -->

@stop
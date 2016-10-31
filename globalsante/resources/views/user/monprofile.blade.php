@extends("layout")

@section("content")
	<div class="container  patientaccount">
		<div class="patient-menu">
			<ul>
				<li class="{{ Request::is('account/appointments') ? 'active' : '' }}">
					<a href="<?php echo URL::to('/account/appointments'); ?>">Mes rendez-vous</a>
					<div class="arrow"></div>
				</li>
				<li  class="{{ Request::is('account/profile') ? 'active' : '' }}">
					<a href="<?php echo URL::to('/account/profile'); ?>">Mon profil</a>
					<div class="arrow"></div>
				</li>
			</ul>
			<hr>
		</div>
		<div class="row custom-row">
			<div class="">
				<div class="col-md-7 col-xs-12 col-sm-12 mobile-form">
	        		<form id="form_mon_profile">
	        			<input type="hidden" name="_token" value="{{ csrf_token() }}">
	        			<h3 class="keyprofile"><span class="glyphicon glyphicon-lock"></span> Ces données sont confidentielles et destinées au docteur.</h3>
		        		<div class="col-md-3 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<select class="form-control" name="title" required>
		        				<option value="M." {{$title2}}>M.</option>
		        				<option value="Mme" {{$title1}}>Mme</option>
		        			</select>
		        		</div>
		        		<div class="col-md-4 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" class="form-control" name="nom_de_famile" value="{{$patient->first_name}}" id="nom_de_famile" required>
		        			<span class="invalidtext"></span>
		        		</div>
		        		<div class="col-md-5 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" class="form-control" name="prenom" value="{{$patient->last_name}}" id="prenom" required>
		        			 <span class="invalidtext"></span>
		        		</div>

		        		<div class="col-md-12 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" name="email" value="{{$patient->email}}" class="form-control" required id="email">
		        			 <span class="invalideemail">adresse email invalide</span>
		        		</div><br>
		        		<div class="col-md-12 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
							<a class="pull-right pull-right-mobile" data-toggle="modal" data-target="#forgetpwd" style="cursor:pointer;">Modifier mon mot de passe</a>
						</div>
						<div class="col-md-12 col-xs-12 col-sm-12 form-group hrstyle mobile-form">
							<hr>
						</div>
						<div class="col-md-3 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
							Date de naissance
						</div>
						<div class="col-md-3 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
					        <input type='text' class="form-control"  name="day"  placeholder="JJ" required id="dayValue" onkeypress="return isNumberDay(event,this)" maxlength="2" onfocus="this.value=''"  pattern="\d*" value="{{$getDOB[0]}}"/>
						</div>

						<div class="col-md-3 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
							<input type='text' class="form-control"  name="month"  placeholder="MM" required id="monthValue" onkeypress="return isNumberMonth(event,this)"  maxlength="2" onfocus="this.value=''" pattern="\d*" value="{{$getDOB[1]}}" />	
						</div>
						<div class="col-md-3 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
							<input type='text' class="form-control"  name="year"  placeholder="AAAA" required id="yearValue" onkeypress="return isNumberYear(event,this)"  maxlength="4" onfocus="this.value=''" pattern="\d*" value="{{$getDOB[2]}}" />
						</div>
						<div class="col-md-12 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" name="adresse" class="form-control" value="{{$patient->user_address}}" placeholder="Adresse">
						</div>
						<div class="col-md-4 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" name="cp" value="{{$patient->cpcode}}" class="form-control cp" maxlength="5" placeholder="Code postal">
						</div>
						<div class="col-md-8 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" name="ville"  class="form-control" id="ville_auto" value="{{$nomville}}" placeholder="Ville">
		        			<input type="hidden" name="hidenvilleid" id="hidenvilleid" value="{{$patient->id_city}}" >
						</div>
						<div class="col-md-12 col-xs-12 col-sm-12 form-group hrstyle form-group-mobile mobile-form">
							<hr>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<input type="text" name="mobilephone" value="{{$patient->mobile_phone}}" class="form-control" required id="phonenumber" maxlength="10" placeholder="Téléphone portable">
		        			<span class="error_phone">Numéro de téléphone invalide</span>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-12 "></div>
						<div class="col-md-12 col-xs-12 col-sm-12 form-group form-group-mobile mobile-form">
		        			<button type="submit" class="btn-info custombtn form-control update_profile">Enregistrer</button>
						</div>
	        		</form>
	        	</div>
	        	<div class="col-md-5 col-xs-12 col-sm-12">
	        		<h3 class="service-gloable">Global Santé, c'est un service pour : </h3>
	        		<p><span class="glyphicon glyphicon-ok"></span>  Trouver un docteur près de chez soi.</p>
	        		<p><span class="glyphicon glyphicon-ok"></span>  Prendre un rendez-vous en ligne.</p>

	        		<p><span class="glyphicon glyphicon-ok"></span>  Suivre ses consultations.</p>

	        	</div>
			</div>
			
		</div>
	</div>

	  <!-- Modal forget pwd -->
  <div class="modal fade" id="forgetpwd" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
	        <div class="modal-header header-pwd">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-pwd">Modifier mon mot de passe</h4>
	        </div>        
	        <div class="modal-body">  
	        	<form method="post" action="{!! action('UserController@patientPassword') !!}">
            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		        	<div class="col-md-12">&nbsp;</div>
		        	<div class="col-md-4 form-group col-xs-12 col-sm-12">
		        		 <span class="text-control text-control-mobile ">Nouveau mot de passe</span>
		        	</div>
		        	<div class="col-md-5 form-group col-xs-12 col-sm-12 form-group-mobile">
		        		<input type="password" name="newpwd" placeholder="Nouveau mot de passe" class="form-control" required>
		        		
		        	</div>
		        	<div class="col-md-3 form-group "></div> 
		        	<div class="col-md-12"></div> 
		        	<div class="modal-footer ">
			          <button type="button" class="btn btn-default desktop-only" data-dismiss="modal" >Annuler</button>
			          <button type="submit" class="btn btn-primary custombtn col-xs-12 col-sm-12">Modifier mon mot de passe</button>
			        </div>  
			    </form>     
	        </div> 
      </div>
      
    </div>
  </div>
@endsection

@section('js')
@parent

<script type="text/javascript">
	$(document).ready(function(){
		validateCP("cp");
		 $(".invalideemail").hide();
		//update mon profile
		$("#form_mon_profile").on("submit",function(e){
			e.preventDefault();
			 $(".invalideemail").hide();
			var fd = new FormData(document.getElementById("form_mon_profile"));
  		 	$.ajax({
		  		url      : "{!! action('UserController@updatePatientProfile') !!}",
                type     : "POST",
                data     : fd,
                processData: false,  // tell jQuery not to process the data
				contentType: false,// tell jQuery not to set contentType
                success  : function(response) {	
                	// alert(response);  
                	if (response == 0) {
                		$(".invalideemail").show();
                	}
                	else{
                		 $(".invalideemail").hide();
                	}	
                }
            });	
		});
		$(".error_phone").hide();
		$("#phonenumber").on("change",function(e){
	        $(".error_phone").hide();
	        var phone = $(this).val();
	        var phonePattern = /^0[6-7]\d{8}$/g;
	         if (!phonePattern.test(phone)){
	            $(".error_phone").show();
	            $(".error_phone").css("color","red");
	            return false;
	         }
	    });
		inputTextOnly("prenom");
		inputTextOnly("nom_de_famile");

		//ville autocomplete
	    $("#ville_auto").autocomplete({
			 source: function( request, response ) {
	            $.ajax({
	                url: "{{URL('villeauto')}}",
	                dataType: "json",
	                data: {
	                    q: request.term
	                },
	                success: function(data) {
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
					                        id: obj.id 
					                    };
			                		}));
							     }
			                    
	                }
	            });
	        },
	        minLength: 3,
	        select: function(event, ui) { 
		        $("#hidenvilleid").val(ui.item.id) 
		    },
	        cache: false

		});
	customTextStyle("nom_de_famile","uppercase");
	customTextStyle("prenom","capitalize");
	
});
</script>
@stop
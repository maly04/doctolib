@extends("layout")

@section("content")

<section class="row">	
	<div class="col-md-4 col-sm-12 col-xs-12"></div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="loginpanel">
			<ul class="nav nav-tabs">
			    <li class="active">
			    	<a href="#patient" class="activepatient">
			    		<span class="glyphicon glyphicon-user"></span> Patient</a>
			    </li>
			    <li><a href="#professionel" class="activepro"><span class="glyphicon glyphicon-circle-arrow-right"  aria-hidden="true"></span> Professionel</a></li>			    
			</ul>

				<div class="tab-content">
				    <div id="patient" class="tab-pane fade in active">
				        <div class="card card-container">
				           <form class="form-horizontal register"  id="form-patient">
							 <input type="hidden" name="_token" value="{{ csrf_token() }}">
							 	<div class="col-md-12 alert alert-success hide-worning-patient">
							    	Votre demande a bien été enregistrée. Vous allez recevoir un email, vous devrez cliquer sur le lien de confirmation pour valider votre compte.
							    </div>
							     <h3 class="login-title">S'inscrire</h3>
							    <div class="col-md-6 col-xs-12 col-sm-12 nopaddingleft mobilepadingleft">
							    	<div class="control-group"> 
								        <input type="text" id="nomPatient" name="nom" placeholder="Nom" class="form-control" required>	
								    </div>
							    </div>
							   
							    <div class="col-md-6 col-xs-12 col-sm-12 nopaddingright mobilepadingright">
							   		
							    	<div class="control-group custom-height-responsive"> 
								        <input type="text" id="prenomPatient" name="prenom" placeholder="Prénom" class="form-control" required> 
								    </div>
							    </div>
							   
							    <div class="clear custom-height">&nbsp;</div>
							    <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							     	<input type="text" id="telpro" name="tel" placeholder="Téléphone" class="form-control" required maxlength="10"> 
							     	<span class="error_phone_tel">Numéro de téléphone invalide</span>
							    </div>
							    
							 
							 	<div class="clear custom-height">&nbsp;</div>
							    <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							    	<input type="email"  name="email" placeholder="Email" class="form-control" required id="emailPatient"> 
							    	<span class="existsEmailPatient">L'adresse mail existe déjà.</span>
							    </div>
							    <div class="clear custom-height">&nbsp;</div>
							 	<div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							 		<input type="password" id="password" name="pwd" placeholder="Mot de passe" class="form-control" required>
							 	</div>
							 	<div class="clear custom-height">&nbsp;</div>
							    <div class="control-group">
							      <!-- Button -->
							      <div class="form-group ">
							        <button class="btn btn-success custombtn" type="submit">S'enregistrer</button>
							      </div>
							    </div>
							  <!-- </fieldset> -->
							</form>
				        </div><!-- /card-container -->
				        
				    </div>
				    <div id="professionel" class="tab-pane fade">
				        <div class="card card-container">
					       <form class="form-horizontal register" id="form-professionel" >
							 <input type="hidden" name="_token" value="{{ csrf_token() }}">
							 	<div class="col-md-12 alert alert-success hide-worning">
							    	Votre demande a bien été enregistrée. Vous allez être contacté par notre équipe. N'hésitez pas à nous contacter via le formulaire de contact si vous avez des questions.
							    </div>
							     <h3 class="login-title">S'inscrire</h3>
							    <div class="col-md-6 col-xs-12 col-sm-12 nopaddingleft mobilepadingleft">
							    	<div class="control-group"> 
								        <input type="text" id="nom" name="nom" placeholder="Nom" class="form-control" required>	
								    </div>
								   
							    </div>
							    
							    <div class="col-md-6 col-xs-12 col-sm-12 nopaddingright mobilepadingright">
							    	
							    	<div class="control-group custom-height-responsive"> 
								        <input type="text" id="prenom" name="prenom" placeholder="Prénom" class="form-control" required> 
								    </div>
							    </div>
							    <div class="clear custom-height">&nbsp;</div>
							    <div class="col-md-12 col-xs-12 col-sm-12 nopadding cp">
							     	<input type="text" id="cp" name="cp" placeholder="Code postal" class="form-control" required maxlength="5"> 
							    </div>
							    <div class="clear custom-height">&nbsp;</div>
							    <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							     	<input type="text" id="tel" name="tel" placeholder="Téléphone" class="form-control" required maxlength="10"> 
							     	<span class="error_phone">Numéro de téléphone invalide</span>
							    </div>
							    
							 	<div class="clear custom-height">&nbsp;</div>
							 	<div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							 		<select name="speciality" class="form-control" required>
							 			<option value="">Votre spécialité</option>
							 			@foreach($specialties as $spe)
							 			 <option value="{{$spe->id}}">{{$spe->name}} </option>
							 			@endforeach
							 		</select>
							 	</div>
							 	<div class="clear custom-height">&nbsp;</div>
							    <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							    	<input type="email" id="email" name="email" placeholder="Email" class="form-control" required> 
							    	<span class="existsEmail">L'adresse mail existe déjà.</span>
							    </div>
							    <div class="clear custom-height">&nbsp;</div>
							 	<div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							 		<input type="password" id="password" name="pwd" placeholder="Mot de passe" class="form-control" required>
							 	</div>
							 	<div class="clear custom-height">&nbsp;</div>
							 	<div class="col-md-12 col-xs-12 col-sm-12 nopadding">
							 		<textarea class="form-control" placeholder="Laissez un commentaire si besoin." name="comment"></textarea>
							 	</div>
							    <div class="clear custom-height">&nbsp;</div>
							    <div class="control-group">
							      <!-- Button -->
							      <div class="form-group ">
							        <button class="btn btn-success custombtn" type="submit">S'enregistrer</button>
							      </div>
							    </div>
							  <!-- </fieldset> -->
							</form>
				        </div><!-- /card-container -->
				    </div>
				   
				  </div>
				  </div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12"></div>

</section>

@endsection

@section('js')
@parent

<script type="text/javascript">
	$(document).ready(function(){
		validateCP("cp");

		$(".error_phone").hide();
		$(".error_phone_tel").hide();
		//phone validation
		phonenumbervalidation("telpro","error_phone_tel");
		phonenumbervalidation("tel","error_phone");
		//text capital letter for Nom&prenom patient
		customTextStyle("nomPatient","uppercase");
		customTextStyle("prenomPatient","capitalize");
		//text capital letter for Nom et prenom professional
		customTextStyle("nom","uppercase");
		customTextStyle("prenom","capitalize");		
		//tab
		loadTab();
		$(".existsEmail").hide();
		$(".existsEmailPatient").hide();
		$(".hide-worning-patient").hide();
		///register patient
		$("#form-patient").on("submit",function(event){
			event.preventDefault();
			var fd = new FormData(document.getElementById("form-patient"));
  		 	$.ajax({
		  		url      : "{!! action('UserController@signupPatient') !!}",
                type     : "POST",
                data     : fd,
                processData: false,  // tell jQuery not to process the data
				contentType: false,// tell jQuery not to set contentType
                success  : function(response) { 
                	//alert(response);               	
            		if (response == "0") {
            		 	$("#emailPatient").addClass("haserror");
            		}
            		else if(response == "2"){
            			$(".existsEmailPatient").show();
            		}
            		else{
						$(".hide-worning-patient").show();
            			//window.location.replace("{{ url('account') }}");
            		}
            			   		
                }
            });	
		});
		////register professionel
		$(".hide-worning").hide();
		$("#form-professionel").on("submit",function(event){
			event.preventDefault();
			var fd = new FormData(document.getElementById("form-professionel"));
  		 	$.ajax({
		  		url      : "{!! action('UserController@signup') !!}",
                type     : "POST",
                data     : fd,
                processData: false,  // tell jQuery not to process the data
				contentType: false,// tell jQuery not to set contentType
                success  : function(response) { 
                	// alert(response);               	
            		if (response == "0") {
            		 	$("#email").addClass("haserror");
            		}
            		else if(response == "2"){
            			$(".existsEmail").show();
            		}
            		else{
						$(".hide-worning").show();

            			//window.location.replace("{{ url('account') }}");
            		}
            			   		
                }
            });	
		});

	});
</script>


@stop
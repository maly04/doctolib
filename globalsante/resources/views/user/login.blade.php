@extends("layout")

@section("content")

<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
	<div class="col-md-4 col-sm-12 col-xs-12"></div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="loginpanel">
			<ul class="nav nav-tabs">
			    <li class="active">
			    	<a href="#patient" class="activepatient">
			    		<span class="glyphicon glyphicon-user"></span> Patient</a>
			    </li>
			    <li><a href="#professionel" class="activepro professionel"><span class="glyphicon glyphicon-circle-arrow-right"  aria-hidden="true"></span> Professionel</a></li>			    
			</ul>

			<div class="tab-content">
				    <div id="patient" class="tab-pane fade in active">
				        <div class="card card-container">
				             <form class="form-signin" id="form-patient">
				             	<input type="hidden" name="_token" value="{{ csrf_token() }}">
								  <div class=" col-md-12 alert alert-warning wronguser">
								  		Nom d'utilisateur ou mot de passe incorrect.
								  </div>
								  <div class=" col-md-12 alert alert-success succesuser">
								  	Connecter avec succès
								  </div>
								  <h3 class="login-title">Identifiez-vous pour accéder à votre espace</h3>
				                <span id="reauth-email" class="reauth-email"></span>
					        	  <input type="email" name="email" placeholder="Entrez votre email"  class="form-control" id="inputEmail" />
			                
			                      <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Mot de passe"/>
			                       <a href="{{ url('/patient/password/reset') }}" style="float:left;">Mot de passe perdu</a>
		          	 <br>

			                     <div id="remember" class="checkbox">
				                    <label>
				                        <input type="checkbox" name="remember"> Se souvenir de moi
				                    </label>
				                </div>
				                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="patientLogin">Se connecter</button>
				            </form><!-- /form -->
				            <a href="<?php echo URL::to('/signup#patient'); ?>" >
				               Vous n'avez pas de compte ? Rejoignez-nous !
				            </a>
				        </div><!-- /card-container -->
				       
				    </div>
				    <div id="professionel" class="tab-pane fade">
				        <div class="card card-container">
					       
						    <div class="col-md-12 alert alert-warning hide-worning">
						    	Désolé, votre adresse email ou votre mot de passe est incorrect.
						    </div>
						    <div class="col-md-12 alert alert-danger expireduser">
						    	Votre license professionnelle n'est pas activée, veuillez contacter l'administrateur.
						    </div>
				            <h3 class="login-title">Identifiez-vous pour accéder à votre espace</h3>
				             <form   id="formLogin" class="form-signin" data-toggle="validator">
				             	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				                <span id="reauth-email" class="reauth-email"></span>				               
						        	  <input type="email" name="email" placeholder="Entrez votre email"  class="form-control email" id="inputEmail" />
				                      <input type="password" class="form-control pass" name="password" id="inputPassword" placeholder="Mot de passe"/>
				                      <a href="{{ url('/password/reset') }}" style="float:left;">Mot de passe perdu</a>
		          	 <br>
				              
				                <div id="remember" class="checkbox">
				                    <label>
				                        <input type="checkbox" name="remember"> Se souvenir de moi
				                    </label>
				                </div>
				                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="go">Se connecter</button>
				            </form><!-- /form -->
				            <a href="<?php echo URL::to('/signup#professionel'); ?>" >
				               Vous n'avez pas de compte ? Rejoignez-nous !
				            </a>
				        </div><!-- /card-container -->
				      
						 

						
				    </div>
				   
				  </div>
				  </div>
			</div>
	<div class="col-md-4 col-sm-12 col-xs-12"></div>
</div>


@endsection

@section('js')
@parent
<?php
if (isset($_GET["tab"])) {
	if ($_GET["tab"] == "professionel") {
?>
	<script type="text/javascript">
		 $(document).ready(function () {
		 	$(".nav-tabs a.activepro").tab('show');
		 });
	</script>
<?php		
	}
}
?>
<script type="text/javascript">
	$(document).ready(function () {
		 var hash = window.location.hash;
			  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

			  $('.nav-tabs a').click(function (e) {
				    $(this).tab('show');
				    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
				    window.location.hash = this.hash;
				    $('html,body').scrollTop(scrollmem);
			   
			  });
			  //when click on layout menu
			  $(".atopmenu").on("click",function(e){
			  	 $(".professionel").tab('show');
			  	  var scrollmem = $('body').scrollTop() || $('html').scrollTop();
				    window.location.hash = this.hash;
				    $('html,body').scrollTop(scrollmem);
			  });
			  $(".hide-worning").hide();
			  $(".expireduser").hide();
			  $("#formLogin").on("submit",function(event){
			
			  		event.preventDefault(); 
			  		$(".hide-worning").hide();
			 		$(".expireduser").hide();
			  		var fd = new FormData(document.getElementById("formLogin"));
			  		 	$.ajax({
					  		url      : "{!! action('UserController@submitLogin') !!}",
			                type     : "POST",
			                data     : fd,
			                processData: false,  // tell jQuery not to process the data
							contentType: false,// tell jQuery not to set contentType
			                success  : function(response) {
			                	// alert(response);
			                	if (response == "firstlogin"){
			                		window.location.replace("{{ url('parameters/agenda') }}");
			                
			                	}
			                	if (response == "errorsMsg") {
			                		$(".hide-worning").show();
			                	}
			                	if (response == "errors") {
			                		$(".email").addClass("haserror");
			                		$(".pass").addClass("haserror");

			                	}
			                	if (response == "success") {
			                		window.location.replace("{{ url('agenda') }}");
			                	}
			                	if (response == "expireduser") {
			  						$(".expireduser").show();

			                	}
			            		 
			            			   		
			                }
			            });	
			  });

			  //patient login
			  $(".wronguser").hide();
			  $(".succesuser").hide();
			  $("#form-patient").on("submit",function(event){
			  		event.preventDefault();
			  		$(".wronguser").hide();
			  		$(".succesuser").hide();
			  		var fd = new FormData(document.getElementById("form-patient"));
		  		 	$.ajax({
				  		url      : "{!! action('UserController@submitLoginPatient') !!}",
		                type     : "POST",
		                data     : fd,
		                processData: false,  // tell jQuery not to process the data
						contentType: false,// tell jQuery not to set contentType
		                success  : function(response) {
		                	if (response == "0") {
		                		$(".wronguser").show();
		                	}	
		                	if (response == "success") {
		                		//$(".succesuser").show();
		                		window.location.replace("{{ url('/') }}");
		                	}  
		                	if (response == "errors") {
		                		$("#inputEmail").addClass("haserror");
		                		$("#inputPassword").addClass("haserror");

		                	}          			   		
		                }
		            });	 
			  });

		// $(".nav-tabs a").click(function(){
	 //        $(this).tab('show');
	 //        window.location.hash = ui.tab.hash;
	 //    });


		// $('#formLogin').validate({
		// 	rules: {
		// 		email: {
		// 			required: true,
		// 			email: true
		// 		},
		// 		password: {
		// 			minlength: 2,
		// 			required: true
		// 		}
		// 	},
		// 	highlight: function (element) {
		// 		$(element).closest('.control-group').removeClass('success').addClass('error');
		// 	},
		// 	success: function (element) {
		// 		element.text('').addClass('valid')
		// 			.closest('.control-group').removeClass('error').addClass('success');

		// 	}
		// });

	//});



});

</script>

@stop
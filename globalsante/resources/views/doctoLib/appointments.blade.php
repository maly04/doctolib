@extends("layout")
@section("content")
<section class="row ">
	<div class="container">
		<div class="stepwizard">
		    <div class="stepwizard-row setup-panel">
		        <div class="stepwizard-step">
		            <button href="#step-1"  class="btn btn-primary btn-circle btnstep11"></button>
		            <p>Identification</p>
		        </div>
		        <div class="stepwizard-step">
		            <button href="#step-2" class="btn btn-default btn-circle btnstep2" disabled="disabled"></button>
		            <p>Vérification</p>
		        </div>
		        <div class="stepwizard-step">
		            <button href="#step-3"  class="btn btn-default btn-circle btnstep3" disabled="disabled"></button>
		            <p>Infos patient</p>
		        </div>
		         <div class="stepwizard-step">
		            <button href="#step-4"  class="btn btn-default btn-circle btnstep4" disabled="disabled"></button>
		            <p>C'est terminé</p>
		        </div>
		    </div>
		</div>
		<form role="form">
			<!-- <div class="col-md-12 col-xs-12 col-sm-12">
			 	
			</div> -->
		    <div class="row setup-content" id="step-1">
		            <div class="col-md-12 col-xs-12 col-sm-12">
		            	<h3 class="appointement-title"> Finalisez votre rendez-vous en quelques clics</h3>
		            	<div class="col-md-7 col-xs-12 col-sm-12">
		            		<div class="form-block">
			            			<div class="form-group ptitle">
				            			Avez-vous déjà utilisé Global Santé ? <a href="{{URL::to('/login#patient')}}">Connectez-vous</a>
				            		</div>
				            		<div class="block-or">
										<i>OU</i>
										<hr>
								    </div>
				            		<h3 class="title_fieldset">Nouveau sur Global Santé ?</h3>
				            		<p class="ptitle">Saisissez vos informations pour continuer.</p>
				            		<div class="alert alert-danger error_email">
				            			Un compte Global Santé a déjà été créé le <span class="dateCreate"></span> avec cet email. Vous ne pouvez pas créer un nouveau compte avec le même email. Si vous ne vous souvenez plus de votre mot de passe, <a href="{{ url('/patient/password/reset') }}">cliquez-ici</a>.
				            		</div>
					                <div class="form-group">
					                    <input  maxlength="10" type="text" required="required" class="form-control" placeholder="Téléphone portable" id="phonenumber" />
					                    <span class="error_phone">Numéro de téléphone invalide</span>
					                </div>
					                <div class="form-group">
					                    <input  type="text" required="required" class="form-control" placeholder="Adresse email" id="email" />
					                    <span class="invalideemail">adresse email invalide</span>
					                </div>
					                <div class="form-group">
					                    <input  type="password" required="required" class="form-control" placeholder="Choisissez un mot de passe" id="password" />
					                </div>
					                <button class="btn btn-primary nextBtn form-control center-block custombtn btnstep1" type="button" data-step = "step1" >Continuer</button><br>

					        </div> <!-- end form-block -->
			            </div>
		            	<div class="col-md-5 col-xs-12 col-sm-12">
		            		<div class="col-md-12 col-xs-12 col-sm-12">
		            			<div class="alert alert-warning">
		            	 			<span>Votre rendez-vous n'est pas encore confirmé</p></span>
		            	 		</div>
		            		</div>
		            		<div class="col-md-12 col-xs-12 col-sm-12">
		            			<div class="panel panel-default">
								    <div class="panel-heading">{{$str_date}}</div>
								    <div class="panel-body">
								    	<p>
								    		{{$docto->first_name}} {{$docto->last_name}}<br>
								    		{{$docto->info}}
								    	</p>
								    </div>
								</div>
		            		</div>
	            		</div>	            		
		            	 		
		            </div>
		    </div>
		    <div class="row setup-content" id="step-2">
		    	<div class="col-md-12 col-xs-12 col-sm-12">
		    			<h3 class="appointement-title"> Finalisez votre rendez-vous en quelques clics</h3>
		            	<div class="col-md-7 col-xs-12 col-sm-12">
		            		<div class="form-block resetphnestep2">
		            			<h3>Saisissez ici le code communiqué par SMS sur votre téléphone portable <b class="phone_number">
		            			@if(sizeof($session) > 0)
		            					{{$session->mobile_phone}}		            			
		            			@endif
		            				</b> </h3>
		            			<div class="">
		            				@if(sizeof($session) > 0)
		            					<input type="hidden" id="pid" name="pid" value="{{$session->id}}">
		            				@else
		            					<input type="hidden" id="pid" name="pid" >
		            				@endif
		            				<input type="hidden" id="did" name="did" value="{{$docto->id}}" >
				                    <input  maxlength="3" type="text" required="required" class="form-control" placeholder="Code de vérification - Exemple : 123" id="confirmcode" /><br>
				                    <div class="alert alert-danger error_code">
				                    	Le code de confirmation saisi n'est pas correct.
				                    </div>
					            </div>
					           	 <button class="form-control btn btn-primary nextBtn center-block custombtn btnstep1" type="button" data-step = "step2" >Continuer</button>
					           	 <br>
					            <p class="txt-small">
					            	Le temps de réception du code temporaire par SMS est dépendant du réseau de votre opérateur. Au-delà de 2 minutes, nous vous invitons à vérifier votre numéro de téléphone :
					            </p>
					            <p class="txt-small">&nbsp;&nbsp;- Votre numéro est correct : <a  class="resetPhoneNumber">Recevoir un nouveau code sur ce numéro</a>.</p>
					            <p class="txt-small">&nbsp;&nbsp;- Votre numéro est incorrect : <a class="resetPhoneNumber"  >Changer de numéro de téléphone</a>.</p>
					         	
					         	<p class="txt-small">Si le problème persiste, vous pouvez nous appeler au 01 83 355 358.</p>
		            		</div>
		            	</div>

		            	<div class="col-md-5 col-xs-12 col-sm-12">
		            		<div class="col-md-12 col-xs-12 col-sm-12">
		            			<div class="alert alert-warning">
		            	 			<span>Votre rendez-vous n'est pas encore confirmé</p></span>
		            	 		</div>
		            		</div>
		            		<div class="col-md-12 col-xs-12 col-sm-12">
		            			<div class="panel panel-default">
								    <div class="panel-heading">{{$str_date}}</div>
								    <div class="panel-body">
								    	<p>
								    		{{$docto->first_name}} {{$docto->last_name}}<br>
								    		{{$docto->info}}
								    	</p>
								    </div>
								</div>
		            		</div>
	            		</div>	
		        </div>		         
		    </div>
		    <div class="row setup-content" id="step-3">
		       <div class="col-md-12 col-xs-12 col-sm-12">
		       		<h3 class="appointement-title">Finalisez votre rendez-vous en quelques clics</h3>
	            	<div class="col-md-7 col-xs-12 col-sm-12">
	            		<div class="form-block">
	            			<h3>Vos informations</h3>
	            			<div class="col-md-3 col-sm-12 col-xs-12 nopadding form-group">

	            			 	<select id="sex" class="select  form-control" required >
									<option value="">Civilité</option>
								    <option value="Mme">Mme</option>
								    <option value="M.">M.</option>
								</select>
								<input type="hidden" id="did" name="did" value="{{$docto->id}}" >
								<input type="hidden" id ="datestart" value="{{$dataStart}}">
	            			</div>
	            			
	            			<div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group">
	            					@if(sizeof($session) > 0)
		            					<input type="hidden" id="pid" name="pid" value="{{$session->id}}">
		            					<input type="text" required="required" class="form-control padding-top" placeholder="Prénom" id="prenom" value="{{$session->first_name}}" />
				                    <span class="invalidtext"></span>
		            				@else
		            					<input type="hidden" id="pid" name="pid">       
		            					<input type="text" required="required" class="form-control padding-top" placeholder="Prénom" id="prenom"  />
				                    <span class="invalidtext"></span>   					
		            				@endif
				                    
				                   
					        </div>
					        <div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group">
						        @if(sizeof($session) > 0)
						        	<input type="text" required="required" class="form-control padding-top" placeholder="Nom d'usage (ou nom de famille)" id="nom_de_famile" value="{{$session->last_name}}" />	
				                     <span class="invalidtext"></span>		
						        @else
						        	<input type="text" required="required" class="form-control padding-top" placeholder="Nom d'usage (ou nom de famille)" id="nom_de_famile" />	
				                     <span class="invalidtext"></span>		
						        @endif	            					
				                    	                   
					        </div>
					        <div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group">
					        	@if(sizeof($session) > 0)
					        		<input type="text" class="form-control padding-top" placeholder="Nom de naissance (ou nom de jeune fille) optionnel" id="nomjeun" value="{{$session->maiden_name}}" /> 
				                     <span class="invalidtext"></span>  
					        	@else
						        	<input type="text" class="form-control padding-top" placeholder="Nom de naissance (ou nom de jeune fille) optionnel" id="nomjeun"  /> 
					                     <span class="invalidtext"></span>  	
					        	@endif            					
				                                    
					        </div>
					        <div class="col-md-12 col-sm-12 col-xs-12 nopadding ">
								<div class="col-md-3 nopaddingleft form-group">
					                    <input type='text' class="form-control padding-top"  name="day"  placeholder="JJ" required id="dayValue" onkeypress="return isNumberDay(event,this)" maxlength="2" onfocus="this.value=''"  pattern="\d*"/>					
								</div>
								<div class="col-md-3 nopaddingleft form-group">
					                    <input type='text' class="form-control padding-top"  name="month"  placeholder="MM" required id="monthValue" onkeypress="return isNumberMonth(event,this)"  maxlength="2" onfocus="this.value=''" pattern="\d*" />				
									
								</div>
								<div class="col-md-6 nopaddingright form-group">
					                    <input type='text' class="form-control padding-top"  name="year"  placeholder="AAAA" required id="yearValue" onkeypress="return isNumberYear(event,this)"  maxlength="4" onfocus="this.value=''" pattern="\d*"/>						
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group">
								 <input type="text" required="required" class="form-control padding-top" placeholder="Adresse" id="address"  />
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12 nopaddingleft form-group">
								<input type="text" required="required" class="form-control padding-top cp" placeholder="Code postal" id="cp" maxlength="5" />
							</div>
							<div class="col-md-8 col-sm-12 col-xs-12 nopaddingright form-group">
								<input type="text" required="required" class="form-control padding-top padding-buttom" placeholder="Ville" id="ville" />
								 <input type="hidden" name="hidenvilleid" id="hidenvilleid">
							</div>
				           	<button class="form-control btn padding-top btn-primary nextBtn center-block custombtn button_step3" type="button" data-step = "step3" >Prendre rendez-vous</button>
				           	 <br>
	            		</div>
	            	</div>
	            	<div class="col-md-5 col-xs-12 col-sm-12">
		            		<div class="col-md-12 col-xs-12 col-sm-12">
		            			<div class="alert alert-warning">
		            	 			<span>Votre rendez-vous n'est pas encore confirmé</p></span>
		            	 		</div>
		            		</div>
		            		<div class="col-md-12 col-xs-12 col-sm-12">
		            			<div class="panel panel-default">
								    <div class="panel-heading">{{$str_date}}</div>
								    <div class="panel-body">
								    	<p>
								    		{{$docto->first_name}} {{$docto->last_name}}<br>
								    		{{$docto->info}}
								    	</p>
								    </div>
								</div>
		            		</div>
	            		</div>	
		        </div>
		    </div>
		    <div class="row setup-content" id="step-4">
		        <div class="col-xs-12">
		            <div class="col-md-12">
		                <h3 class="confirm-title"> <span class="glyphicon glyphicon-ok"></span> Votre rendez-vous est confirmé</h3>
		                <p class="pconfirmed">Nous venons de vous envoyer un email de confirmation de rendez-vous.
Vous recevrez également un SMS 1 jour avant le rendez-vous.</p>
						<p class="pconfirmed">Vous pouvez consulter vos rendez-vous <a href="<?php echo URL::to('/account/appointments'); ?>">ici</a>.</p>
		               
		            </div>
		        </div>
		    </div>
		</form>
		</div>
</section>

@endsection

@section('js') 
@parents
<?php


if (sizeof($session) > 0) {
	// echo $session->session;;
	 $getsession = $session->session;
	
}
else{
	 $getsession = "step1";
}
 
if ($getsession == "step1") {
?>

<script  type="text/javascript">
	
	$(document).ready(function(e){
		
		$(".btnstep2").attr("disabled","disabled");
		$("#step-2").attr("style","display:none");
		$(".btnstep3").attr("disabled","disabled");
		$("#step-3").attr("style","display:none;");
	});
</script>

<?php
 }
if ($getsession == "step2") {
?>
<script  type="text/javascript">
	$(document).ready(function(e){
	
		$(".btnstep11").attr("disabled","disabled");
		$("#step-1").attr("style","display:none");
		$(".btnstep2").addClass('btn-primary');
		$("#step-2").attr("style","display:block;");
		
		$(".btnstep3").attr("disabled","disabled");
		$("#step-3").attr("style","display:none");
	});
</script>

<?php
 }
 if ($getsession == "step3") {
?>
<script  type="text/javascript">
	$(document).ready(function(e){
		
		$(".btnstep11").attr("disabled","disabled");
		$("#step-1").attr("style","display:none");
		
		$(".btnstep2").attr("disabled","disabled");
		$("#step-2").attr("style","display:none");

		$("#step-3").attr("style","display:block;");
		$(".btnstep3").addClass('btn-primary');
	});
</script>

<?php
 }
 if ($getsession == "step4") {
?>
<script  type="text/javascript">
	$(document).ready(function(e){
	
		$(".btnstep11").attr("disabled","disabled");
		$("#step-1").attr("style","display:none");
		
		$(".btnstep2").attr("disabled","disabled");
		$("#step-2").attr("style","display:none");
		$(".btnstep3").attr("disabled","disabled");
		$("#step-3").attr("style","display:none");

		$("#step-4").attr("style","display:block;");
		$(".btnstep4").addClass('btn-primary');
	});
</script>

<?php
 }

?>
<script type="text/javascript">
	$(document).ready(function () {	
		validateCP("cp");
		$(".error_phone").hide();
	    $(".error_email").hide();
	    $(".invalideemail").hide();
	    $(".error_code").hide();

	    var navListItems = $('div.setup-panel div button'),
	            allWells = $('.setup-content'),
	            allNextBtn = $('.nextBtn');

	    allWells.hide();

	    navListItems.click(function (e) {
	        e.preventDefault();
	        var $target = $($(this).attr('href')),
	                $item = $(this);

	        if (!$item.hasClass('disabled')) {
	            navListItems.removeClass('btn-primary').addClass('btn-default');
	            $item.addClass('btn-primary');
	            allWells.hide();
	            $target.show();
	            $target.find('input:eq(0)').focus();
	        }
	    });

	    allNextBtn.click(function(){
	    	$(".error_email").hide();
	   		$(".invalideemail").hide();
	   		$(".error_code").hide();  	   		
	        var curStep = $(this).closest(".setup-content"),
	            curStepBtn = curStep.attr("id"),
	            nextStepWizard = $('div.setup-panel div button[href="#' + curStepBtn + '"]').parent().next().children("button"),
	            curInputs = curStep.find("input[type='text'],input[type='url'],select"),
	            isValid = true;

	        $(".form-group").removeClass("has-error");
	        for(var i=0; i<curInputs.length; i++){
	            if (!curInputs[i].validity.valid){
	                isValid = false;
	                $(curInputs[i]).closest(".form-group").addClass("has-error");
	            }
	        }

	        if (isValid == true){

	            var step = $(this).data("step");
	            if (step == "step1") {            	
	                var phone = $("#phonenumber").val();
	                var email = $("#email").val();
	                var pass =  $("#password").val();
	                var str_data = "phone="+phone+"&email="+email+"&password="+pass;
	                $.ajax({            
	                   url: "{!! action('DoctoLibController@sendsms') !!}",
	                   type: "get",
	                   data: str_data,
	                   success:function(response){
	                        //alert(response);
	                      
	                        //invalide email format
	                        if(response == 0){
	                        	$(".invalideemail").show();	
	                        }
	                        //email already exists
	                        else if (response == 1) {                        	
	                        	//to display email create date
	                        	$.ajax({            
				                   url: "{!! action('DoctoLibController@checkPatientCreateDate') !!}",
				                   type: "get",
				                   data: "email="+email,
				                   success:function(res){
					                   	$(".dateCreate").text(res);
					                    $(".error_email").show();
				                   }
				                });
	                        }
	                        else {

	                        	nextStepWizard.removeAttr('disabled').trigger('click');
	                        	$(".phone_number").text(phone);
	                        	$("#pid").val(response);
	                        	$(".btnstep11").attr("disabled","disabled");
								$("#step-1").attr("style","display:none");
	                        }
	                   }
	                });
	            }
	            if (step == "step2") {
	            	
	            	var pid = $("#pid").val();
	            	var code = $("#confirmcode").val();
	            	var did = $("#did").val();
	            	var str_data = "pid="+pid+"&code="+code+"&did="+did;

	            	$.ajax({            
	                   url: "{!! action('DoctoLibController@validateConfirmCode') !!}",
	                   type: "get",
	                   data: str_data,
	                   success:function(response){
	                       if (response == 0) {
	                       		$(".error_code").show();
	                       }
	                       else{
	                       		nextStepWizard.removeAttr('disabled').trigger('click');
	                       		$(".btnstep2").attr("disabled","disabled");
								$("#step-2").attr("style","display:none");
	                       }
	                   }
	                });
	            }
	            if (step == "step3") {

	            	var pid  = $("#pid").val();
	            	var sex = $("#sex").val();
	            	var did = $("#did").val();
	            	var datestart = $("#datestart").val();
	            	var prenom = $("#prenom").val();
	            	var nom_de_famile = $("#nom_de_famile").val();
	            	var nom_jeun = $("#nomjeun").val();
	            	var dayValue = $("#dayValue").val();
	            	var monthValue = $("#monthValue").val();
	            	var yearValue = $("#yearValue").val();
	            	var address = $("#address").val();
	            	var cp = $("#cp").val();
	            	var ville = $("#hidenvilleid").val();
	            	var date_str = dayValue+'-'+monthValue+"-"+yearValue;
	            	var data = "did="+did+"&pid="+pid+"&sex="+sex+"&prenom="+prenom+"&nom_famile="+nom_de_famile+"&nomjeun="+nom_jeun+"&date_str="+date_str+"&address="+address+"&cp="+cp+"&ville="+ville+"&datestart="+datestart;
	            	$.ajax({            
	                   url: "{!! action('DoctoLibController@infoPatient') !!}",
	                   type: "get",
	                   data: data,
	                   success:function(response){
	                       if (response == 1) {
	                       		nextStepWizard.removeAttr('disabled').trigger('click');
	                       		$(".btnstep3").attr("disabled","disabled");
								$("#step-3").attr("style","display:none");
	                       }
	                   }
	                });


	            }
	        }
	            
	            
	    });

	    $('div.setup-panel div button.btn-primary').trigger('click');	    
	    phonenumbervalidation("phonenumber","error_phone");
	    //click on reset phone number
	    $(".resetPhoneNumber").on("click",function(){
	    	var pid = $("#pid").val();
	    	$.ajax({            
	           url: "{!! action('DoctoLibController@resetPhoneNumber') !!}",
	           type: "get",
	           data: "pid="+pid,
	           success:function(res){
	           	$(".resetphnestep2").html(res);
	           }
	        });

	    });
		inputTextOnly("prenom");
		inputTextOnly("nom_de_famile");
		inputTextOnly("nomjeun");
		customTextStyle("nom_de_famile","uppercase");
		customTextStyle("prenom","capitalize");
	   	//ville autocomplete
	    $("#ville").autocomplete({
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
	});





</script>

 

@stop
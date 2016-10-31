@extends("layout")

@section("content")

	<section class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">			
				<div class="col-md-4">
					<a class="btn btn-primary custombtn" data-toggle="modal" data-target="#addnewPatient" style="cursor:pointer;">Ajouter un Nouveau Patient</a>
				</div>
				<div class="col-md-4">
					{!! $partient->links() !!}
				</div>
				<div class="col-md-4">
					
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">			
				<div class="table-responsive">
					<table class="table table-hover"  data-toggle="table"  data-search="true">
						<thead>
						      <tr>
						        <th>ID</th>
						        <th>Nom</th>
						        <th>Âge</th>
						        <th>Téléphone</th>
						        <th>Consultations</th>
						        <th>Dernière consultation</th>
						        <th class="thaction">Action</th>
						      </tr>
					    </thead>
					    <tbody>					   
					  		{!! $trhtml !!}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
 <div class="modal fade" id="addnewPatient" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
	        <div class="modal-header header-pwd">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <div class="col-md-12 col-sm-12 col-xs-12">
	          	<h4 class="modal-pwd">Ajouter un patient</h4>
	          </div>
	        </div>        
	        <div class="modal-body">  
	        	<form  id="submitPatient">
            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		        		<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>		        		
		            	<div class="col-md-4 col-sm-4 col-xs-4 nopadding">
		            		<div class="col-md-6 "><span class="text-control-p"><input type="radio" name="title" class="radiotitle" value="Mme" required> Mme</span></div>
		            		<div class="col-md-6 "><span class="text-control-p"><input type="radio" name="title" class="radiotitle" value="M." required> M.</span></div>
		            	</div>
		            	<div class="col-md-4 col-sm-4 col-xs-4 nopadding">				            		
		                    <div class="form-group">
		            			<input type="text" class="form-control" name="nom_de_famile" placeholder="Nom de famile" required id="nom_de_famile">
		            		</div>
		            	</div>
		            	<div class="col-md-4 col-sm-4 col-xs-4">				            		
		                    <div class="form-group">
		            			<input type="text" class="form-control" name="prenom" placeholder="Prénom" required id="prenom">  
		            		</div>          		
		            	</div>
						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
						<div class="col-md-4 col-sm-4 col-xs-5">&nbsp;</div>
						<div class="col-md-4 col-sm-4 col-xs-3 nopaddingleft">
		            		<input type="text" class="form-control nom_jeun" name="nom_jeun" placeholder="Nom de jeune fille"> 
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4 nopadding">
							<div class="col-md-3 nopaddingleft">
				                    <input type='text' class="form-control"  name="day"  placeholder="JJ" required id="dayValue" onkeypress="return isNumberDay(event,this)" maxlength="2" onfocus="this.value=''"  pattern="\d*"/>					
							</div>
							<div class="col-md-3 nopaddingleft">
				                    <input type='text' class="form-control"  name="month"  placeholder="MM" required id="monthValue" onkeypress="return isNumberMonth(event,this)"  maxlength="2" onfocus="this.value=''" pattern="\d*" />				
								
							</div>
							<div class="col-md-6">
				                    <input type='text' class="form-control"  name="year"  placeholder="AAAA" required id="yearValue" onkeypress="return isNumberYear(event,this)"  maxlength="4" onfocus="this.value=''" pattern="\d*"/>						
							</div>

							<div class="col-md-12 nopadding">
							<input id="dateValue" name="birthday" type="hidden">
								<span class="dateerror"></span>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
						<div class="col-md-6 col-sm-6 col-xs-6">	
							<div class="control-group">
								<div class="form-group controls">
			            			<input type="email" class="form-control" name="email_patient" id ="email_patient" placeholder="Email du patient"   value=" ">
			            			<span class="existsEmailPatient">L'adresse mail existe déjà.</span>
									<div class="help-block"></div>
								</div>	
							</div>								
		                    								
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							 <div class="form-group">
							 	<input type="text" name="password" class="form-control" placeholder="Mot de passe"  data-minlength="3" value="">									 	
							 </div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
						<div class="col-md-6 col-sm-6 col-xs-6">									
		                    <div class="form-group">
		            			<input type="text" class="form-control" name="tel_portable" placeholder="Téléphone portable" required maxlength="10"> 
		            			<span class="error_phone_tel">Numéro de téléphone invalide</span>         		
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">				            		
				            <div class="form-group">
		            			<input type="text" class="form-control" name="tel_fix" placeholder="Téléphone fixe" maxlength="10"> 
		            			<span class="error_phone_tel_fix">Numéro de téléphone invalide</span>
							</div>
						</div>
						

						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
		            			<input type="text" class="form-control" name="adresse" placeholder="Adresse" required>					
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
						<div class="col-md-4 col-sm-4 col-xs-4">							
		            		<input type="text" class="form-control" name="quartier" placeholder="Quartier"  data-maxlength="20">		

						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
		                    <div class="form-group">                
		            			<input type="text" class="form-control" name="ville" placeholder="Ville" id="ville_auto" required>					
			                    <input type="hidden" name="hidenvilleid" id="hidenvilleid">
			                </div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
						<div class="col-md-4 col-sm-4 col-xs-4">				            		
		            		<div class="form-group"> 
		            			<input type="text" class="form-control cp" name="cp" placeholder="Code Postal" maxlength="5" id="cp" required>					
							</div>				
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<select class="form-control" name="insurent" >
		            		  
		            			@foreach($insurrence as $insur)
		            				<option value="{{$insur->id}}">{{$insur->name}}</option>
		            			@endforeach
		            		</select>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
			        	<div class="clear"> </div>
			        	<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				          <button type="submit" class="btn btn-primary btnajouter custombtn">Ajouter nouveau patient</button>
				        </div>  
			    </form>     
	        </div> 
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="editPatient" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
	        <div class="modal-header header-pwd">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          
	           <div class="col-md-12 col-sm-12 col-xs-12">
	          	<h4 class="modal-pwd">Modifier un patient</h4>
	          </div>
	        </div>        
	        <div class="modal-body">  
	        	<form method="post" action="{!! action('ConfigurationController@updatePatient') !!}">
            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
            		
            		<div id="insertPatient">
            			
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
		 $(".existsEmailPatient").hide();
		 $("#submitPatient").on("submit",function(event){
		 	event.preventDefault(); 
		 	$(".existsEmailPatient").hide();
		 	var fd = new FormData(document.getElementById("submitPatient"));
		 	$.ajax({
		  		url      : "{!! action('ConfigurationController@createPatient') !!}",
                type     : "POST",
                data     : fd,
                processData: false,  // tell jQuery not to process the data
				contentType: false,// tell jQuery not to set contentType
                success  : function(response) {                	
            		 if (response == "0") {
            		 	$(".existsEmailPatient").show();
            		 }
            		 if (response == "1") {
            		 	window.location.replace("{{ url('/configuration/patients') }}");
            		 }
            		 if (response == "2") {
            		 	window.location.replace("{{ url('login') }}");
            		 }

            			   		
                }
            });	
		 });

		$('.search').find("input[type=text]").each(function(ev)
		  {
		      if(!$(this).val()) { 
			     $(this).attr("placeholder", "Rechercher un patient");
			  }
  		});

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
					                        id: obj.id,
					                        cp:obj.cp 
					                    };
			                		}));
							     }
			                    
	                }
	            });
	        },
	        minLength: 3,
	        select: function(event, ui) { 
		        $("#hidenvilleid").val(ui.item.id);
		         $("#cp").val(ui.item.cp);
		    },
	        cache: false

		});

	 //check on madam display only nom de jeun 
		$(".nom_jeun").hide();
	    $('input:radio[name="title"]').change(function(){
	        if (this.checked && this.value == 'Mme') {
	           $(".nom_jeun").show();
	        }
	        else{
	        	 $(".nom_jeun").hide();
	        }
		    
	    });

	  //click on edit button

	  $(".editPatient").on("click",function(){
	  		var pid = $(this).data("pid");

	  		$.ajax({

	           url: "{!! action('ConfigurationController@editPatient') !!}",
			  
			   type: "get",

			   data: "pid="+pid,

			   success:function(response){
			   		$("#insertPatient").html(response);
			  		$('#editPatient').modal();
			    }

			});
	  });

	  $(".sendmail").on("click",function(){
	  	 var pid = $(this).data("pid");
	  	 $.ajax({

	           url: "{!! action('ConfigurationController@sendmail') !!}",
			  
			   type: "get",

			   data: "pid="+pid,

			   success:function(response){
			   		//alert(response);
			    }

			});
	  });
	  //delete patient
	  $(".supprimmer").on("click",function(){
	  		var pid = $(this).data("pid");
	  		deleteItem(pid);
	  });
	  function deleteItem(pid) {
	  	if (confirm("vous voulez supprimer ce patient?")) {
  			$.ajax({		 	
	           url: "{!! action('ConfigurationController@destroyPatient') !!}",
			   type: "get",
			   data: "pid="+pid,
			   success:function(response){
			   		$("#tr"+pid).fadeOut();
			   }
			});
	  	}
	  	return false;
	  }
	  
	customTextStyle("nom_de_famile","uppercase");
	customTextStyle("prenom","capitalize");
	$(".error_phone_tel").hide();
	$(".error_phone_tel_fix").hide();
	phonenumbervalidation("tel_portable","error_phone_tel");
	phonenumbervalidation("tel_fix","error_phone_tel_fix");
});

</script>

@stop
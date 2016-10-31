<form  id="formConsultant" role="form" data-toggle="validator">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	 <input type="hidden" value="" name="hiddendate" id="hiddendate">
     <input type="hidden" name="userid" value="{!! $userid !!}">
	 <input type="hidden" name="aid" id="aid">
	 <input type="hidden" name="pid" id="getpid">
	<div class="col-md-3 nopadding"><span class="text-control">Horaire</span></div>
    	<div class="col-md-5 padding">					            
          <div class="form-group">
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control" id="dhour" name="dhour"  required/>
               
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
	</div>
	<div class="col-md-2"></div>
	<div class="col-md-2 padding">
		 <div class="form-group">
    		<select class="form-control" name="duration" required id="mduration">
    			<option value="00:10">10mn</option>
    			<option value="00:15">15mn</option>
    			<option value="00:20">20mn</option>
    			<option value="00:30">30mn</option>
    			<option value="1:00">60mn</option>
    			<option value="1:30">90mn</option>
    			<option value="2:00">120mn</option>
    		</select>
    	</div>
	</div>
	
	<!-- <div class="col-md-12">&nbsp;</div>
	

	<div class="col-md-12">&nbsp;</div> -->
<!-- 	<div class="col-md-3"><span class="text-control">Patient</span></div>
	<div class="col-md-4 nopadding">
		<input type="radio" name="chkpatient" class="noveau" value="noveau" required> Nouveau Patient
	</div>
	<div class="col-md-1">&nbsp;</div>				            	
	<div class="col-md-4">
		<input type="radio" name="chkpatient" class="exist" value="exist" required> Patient Existant
	</div> -->
		<div class="col-md-3 nopadding">
				<span class="text-control">Patient</span>
		</div>
		<div class="col-md-4 padding select2patientexist">
			
			<select class="form-control autoexists" name="autoexist" id ="autoexist" >
			 <option value=""></option>
	           @foreach($patient as $p)
	            <option value="{{$p->id}}">{{$p->first_name}} {{$p->last_name}}</option>
	          @endforeach
			</select>
			<input type="hidden" name="hiddepid" id="hiddepid">
		</div>
		<div class="col-md-5">
			
		</div>
		<div class="col-md-12 nopadding">
			<div class="col-md-3 nopadding">&nbsp;</div>
			<div class="col-md-9 existPatientForm nopadding">
				
			</div>
		</div>
	<!-- <div class="col-md-12">&nbsp;</div> -->
	<div class="col-md-12 nopadding noveauPatient">
		<!-- <div class="col-md-3">&nbsp;</div>
    	<div class="col-md-3 nopadding">
    		<div class="col-md-6 nopadding"><span class="text-control"><input type="radio" name="title" class="title" value="Mme" required> Mme</span></div>
    		<div class="col-md-6 nopadding"><span class="text-control"><input type="radio" name="title" class="title" value="M." required> M.</span></div>
    	</div>
    	<div class="col-md-3 nopadding">				            		
             <div class="form-group">
    			<input type="text" class="form-control" name="nom_de_famile" placeholder="Nom de famile" required id="nom_de_famile">
    		</div>
    	</div>
    	<div class="col-md-3">				            		
            <div class="form-group">
    			<input type="text" class="form-control" name="prenom" placeholder="Prénom" required id="prenom">  
    		</div>          		
    	</div> -->
		<!-- <div class="col-md-12">&nbsp;</div>
		<div class="col-md-5">&nbsp;</div>
		<div class="col-md-3 nopaddingleft">
    		<input type="text" class="form-control nom_jeun" name="nom_jeun" placeholder="Nom de jeune fille" id="nom_jeun"> 
		</div>
		<div class="col-md-4 nopadding">
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
		</div> -->

		<!-- <div class="col-md-12">&nbsp;</div>
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-4">	
			<div class="control-group">
				<div class="form-group controls">
        			<input type="email" class="form-control" name="email_patient" id ="email_patient" placeholder="Email du patient" >
        			<span class="existsEmail">Le patient existe déjà, veuillez utilier le menu Patient Existant.</span>
					<div class="help-block"></div>
				</div>	
			</div>								
            								
		</div>
		<div class="col-md-5">
			 <div class="form-group">
			 
			 </div>
		</div> -->

		<!-- <div class="col-md-12">&nbsp;</div>
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-4">									
            <div class="form-group">
    			<input type="text" class="form-control" name="tel_portable" placeholder="Téléphone portable" required id="tel_portable" maxlength="10">   
    			<span class="error_phone_tel">Numéro de téléphone invalide</span>       		
			</div>
		</div>
		<div class="col-md-5">				            		
            <div class="form-group">
    			<input type="text" class="form-control" name="tel_fix" placeholder="Téléphone fixe" id="tel_fix"  maxlength="10">
    			<span class="error_phone_tel_fix">Numéro de téléphone invalide</span>
			</div>
		</div>
		

		<div class="col-md-12">&nbsp;</div>
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-9">
			<div class="form-group">
    			<input type="text" class="form-control" name="adresse" placeholder="Adresse" required id="adresse">					
			</div>
		</div> -->

		<!-- <div class="col-md-12">&nbsp;</div>
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-3">
			
    		<input type="text" class="form-control" name="quartier" placeholder="Quartier"  data-maxlength="20" id="quartier">					

		</div>
		<div class="col-md-6">
            <div class="form-group">                
    			<input type="text" class="form-control" name="ville" placeholder="Ville" id="ville_auto" required>
                <input type="hidden" name="hidenvilleid" id="hidenvilleid">
            </div>
		</div>

		<div class="col-md-12">&nbsp;</div>
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-3">				            		
    		<div class="form-group"> 
    			<input type="text" class="form-control cp" name="cp" placeholder="Code postal"  maxlength="5" id="cp">
			</div>	 			
		</div>
		<div class="col-md-6">
			<select class="form-control" name="insurent" id="insurent">
    		  
    			@foreach($insurrence as $insur)
    				<option value="{{$insur->id}}">{{$insur->name}}</option>
    			@endforeach
    		</select>
		</div> -->
	</div>
	<div class="col-md-3 nopadding"><span class="text-control">Lieu du rdv</span></div>
	<div class="col-md-9 padding">
	    @if(sizeof($hospital) == 1)
	   		@foreach($hospital as $hos)
	    		<input type="text" name="" value="{{$hos->hname}} - {{$hos->haddress}}" class="form-control">
	    		<input type="hidden" name="lieu_rdv" value="{{$hos->hid}}">
	    	@endforeach
	    @else
	    	<select class="form-control" name="lieu_rdv">
				@foreach($hospital as $hos)
					<option value="{{$hos->hid}}">{{$hos->hname}} - {{$hos->haddress}}</option>
				@endforeach
			
			</select>
	    @endif
		
		
	</div>
	<div class="col-md-12">&nbsp;</div>
	<div class="col-md-3 nopadding"><span class="text-control">Provenance</span></div>
	<div class="col-md-9 padding">									
        <div class="form-group">
			<input type="text" class="form-control" name="origin" placeholder="Ex : généraliste, dentiste, pharmacien, patient..." >	
		</div>
	</div>
	<!-- <div class="col-md-12">&nbsp;</div> -->
	<div class="col-md-3 nopadding"><span class="text-control">Tags</span></div>
	<div class="col-md-9 padding">									
        <div class="form-group">
			<input type="text" class="form-control" name="tags" placeholder="Tags" >
		</div>	
	</div>
	<!-- <div class="col-md-12">&nbsp;</div> -->
	<div class="col-md-3 nopadding"><span class="text-control">Note</span></div>
	<div class="col-md-9 padding">								
        <div class="form-group">
			<textarea name="note" class="form-control" ></textarea>
		</div>
	</div>
	<!-- <div class="col-md-12">&nbsp;</div>	 -->
	<div class="clear"></div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button class="btn btn-primary custombtn btnajouter" type="submit">Créer le rendez-vous</button>
    </div>
    <input type="hidden" id="hiden_d_start">	
</form>
@section('js')
@parent
<script type="text/javascript">
	$(document).ready(function(){
		validateCP("cp");
		customTextStyle("nom_de_famile","uppercase");
		customTextStyle("prenom","capitalize");
		$(".error_phone_tel").hide();
		$(".error_phone_tel_fix").hide();
		phonenumbervalidation("tel_portable","error_phone_tel");
		phonenumbervalidation("tel_fix","error_phone_tel_fix");

	});
	
	
	
</script>
@stop
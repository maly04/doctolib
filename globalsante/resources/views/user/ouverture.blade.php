<form method="post" action="{!! action('AgendaController@submitouverture') !!}" id="formAbsence" role="form" data-toggle="validator">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="userid" value="{!! $userid !!}">
		<div class="col-md-2">
			<span class="text-control">Horaire</span>
		</div>	
		<div class="col-md-3 nopadding">
			<div class="form-group">
            <div class='input-group date' id='ouverturehour'>
                <input type='text' class="form-control" id="ouverturedatehour" name="ouverturedatehour" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
		</div>
		<div class="col-md-3">
			<div class="input-group time-clock-start" >
		    <input type="text" class="form-control" value="00:00" name="ouverture_clock_start" id="ouverture_clock_start">
		    <span class="input-group-addon">
		        <span class="glyphicon glyphicon-time"></span>
		    </span>
		</div>
		</div>
		<div class="col-md-1 ">
			 <span class="text-control">à </span>
		</div>
		<div class="col-md-3">
			<div class="input-group time-clock-fin" >
		    <input type="text" class="form-control" value="00:00" name="ouverture_clock_fin" id="ouverture_clock_fin">
		    <span class="input-group-addon">
		        <span class="glyphicon glyphicon-time"></span>
		    </span>
		</div>
		</div>	
		<div class="clear"></div>
		<div class="col-md-2">
			<!-- Motifs -->
		</div>
		<div class="col-md-6">
			<!-- <div class="col-md-6 hideradio">
				<input type="radio" name="radiocheck" value="tout" required> Tous
			</div>
			<div class="col-md-6 hideradio">
				<input type="radio" name="radiocheck" value="limit" required> Limité
			</div> -->
		</div>	
		<div class="col-md-4">
			<!-- <a id="config-avance">Configuration avancée</a>
			<a id="config-standard">Configuration Standard</a> -->
		</div>

		<div class="clear"></div>
		<div class="col-md-2"><span class="text-control">Durée d’un créneau</span></div>

		<div class="col-md-3 nopadding">
			<!-- <div class="chk-group">
				@foreach($motif as $mo)
   				<div class="col-md-12">
   					<input type="checkbox" name="motif_chk[]" value="{{$mo->id_motif}}"> {{$mo->motif}}
   				</div>
				@endforeach
				
			</div> -->
			<!-- <div class="step">
				<div class="col-md-5 nopadding"><span class="text-control" style="padding-left:0px;">Durée d’un créneau</span></div> -->
				<!-- <div class="col-md-7 nopadding"> -->
					<select class="form-control" name="un_duration">
						<option value="00:15">15mn</option>
						<option value="00:30">30mn</option>
						<option value="00:45">45mn</option>
						<option value="1:00">60mn</option><!-- 
						<option value="1:15">20mn</option>
						<option value="25">25mn</option>
						<option value="30">30mn</option>
						<option value="35">35mn</option> -->
					</select>
				<!-- </div> -->
			<!-- </div> -->
		</div>
		<div class="col-md-5">&nbsp;</div>

		<div class="clear"></div>
		<div class="col-md-12">&nbsp;</div>
		<div class="col-md-2">
			<span class="text-control">Remplaçant</span>
		</div>
		<div class="col-md-10 nopadding">
			<input type="text" name="remplacant" class="form-control" placeholder="Entrez le nom de votre remplaçant">
		</div>

		<div class="clear"></div>
		<div class="col-md-12">&nbsp;</div>
		<div class="col-md-2">
			<span class="text-control">Description</span>
		</div>
		<div class="col-md-10 nopadding">
			<input type="text" name="description" class="form-control" placeholder="Entrez une description (uniquement visible en interne)">
		</div>

		<div  class="clear"></div>
		<div class="col-md-12">&nbsp;</div>
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-10 nopadding">
			<div class="input-group ouvertColor">
		    <input type="text" value="" class="form-control" name="ouvertColor" />
		    <span class="input-group-addon"><i></i></span>
		</div>
		</div>
		<div class="col-md-12">&nbsp;</div>

	<div class="clear"></div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button class="btn btn-primary custombtn"><a id="eventUrl" target="_blank">Créer la plage d'ouverture</a></button>
    </div>
</form>
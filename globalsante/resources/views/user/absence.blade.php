<form method="post" action="{!! action('AgendaController@submitAbsence') !!}" id="formAbsence" role="form" data-toggle="validator">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="userid" value="{!! $userid !!}">
    <!-- Repeter -->        
    <div class="col-md-3"><span style="margin-left:8px;">Absence récurrente</span></div>
    <div class="col-md-2">
        <input type="radio"  name="chkon" value="1" required> Oui
    </div>
    <div class="col-md-2">
        <input type="radio"  name="chkon" value="0" required> Non
    </div>
    <div class="col-md-5">&nbsp;</div>
     <div class="col-md-12">&nbsp;</div>
	<div class="col-md-12 nopadding chkoui">
    	<div class="col-md-3"><span class="text-control">Horaire</span></div>	
    	<div class="col-md-2 nopadding"><span class="text-control">Début :</span></div>
    	<div class="col-md-4">
    		<div class="form-group">
                <div class='input-group date' id='absencehour'>
                    <input type='text' class="form-control" name="absence_start" id="absencehourinput" required/>
                    
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
    	</div>
    	<div class="col-md-3">
    		<div class="input-group absence-clock">
			    <input type="text" class="form-control" value="00:00" name="absence-clock" id="setabsencetime">
			    <span class="input-group-addon">
			        <span class="glyphicon glyphicon-time"></span>
			    </span>
			</div>
    	</div>


    	<div class="clear"></div>

    	<div class="col-md-3">&nbsp;</div>	
    	<div class="col-md-2 nopadding"><span class="text-control">Fin :</span></div>
    	<div class="col-md-4">
    		<div class="form-group">
                <div class='input-group date' id='finabsencehour'>
                    <input type='text' class="form-control" name="absence_end" id="finhour"  required/>
                    <span class="input-group-addon">
                        <span class="glyphicon  glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
    	</div>
    	<div class="col-md-3">
    		<div class="input-group absence-clock-fin" >
			    <input type="text" class="form-control" value="23:59" name="absence-clock-fin" id="setabsencetime_fin">
			    <span class="input-group-addon">
			        <span class="glyphicon glyphicon-time"></span>
			    </span>
			</div>

    	</div>

    	<!-- Checkbox -->
    	<div class="clear"></div>
    	<div class="col-md-3">&nbsp;</div>
    	<div class="col-md-1">
    		<input type="checkbox"  name="journee" id="chkjour"> 
    	</div>
    	<div class="col-md-3">Journée entière</div>
    	<div class="col-md-5">&nbsp;</div>
    </div>

	<div class="col-md-12 nopadding chknon">
			<div class="col-md-3">
       			<span class="text-control">Horaire</span>
       		</div>	
       		<div class="col-md-3 responsive">
       			<div class="form-group">
	                <div class='input-group date ' id='absencetime'>
	                    <input type='text' class="form-control " id="absencetimeinput" name="absencetimeinput"/>
	                    <span class="input-group-addon ">
	                        <span class="glyphicon glyphicon-calendar "></span>
	                    </span>
	                </div>
	            </div>
       		</div>
       		<div class="col-md-2 responsive nopaddingright">
       			<div class="input-group time-clock-start" >
				    <input type="text" class="form-control" value="00:00" name="time_clock_start" id="time_start">
				    <span class="input-group-addon">
				        <span class="glyphicon glyphicon-time"></span>
				    </span>
				</div>
       		</div>
            
       		<div class="col-md-1 ">
       			<span class="text-control">à</span> 
       		</div>
       		<div class="col-md-3 responsive">
       			<div class="input-group time-clock-fin" >
				    <input type="text" class="form-control" value="23:59" name="time_clock_fin" id="time_fin">
				    <span class="input-group-addon">
				        <span class="glyphicon glyphicon-time"></span>
				    </span>
				</div>
       		</div>	
	</div>
    <div class="clear"></div>
    <div class="col-md-12">&nbsp;</div>
	
	<div class="col-md-12 nopadding repeter-show">
    	<div class="col-md-3">&nbsp;</div>
    	<div class="col-md-2">Répéter le :</div>
    	<div class="col-md-6 paddingleft ">
    		<input type="checkbox" name="chk[]" value="1000000"> lun 
    	
    		<input type="checkbox" name="chk[]" value="0100000"> mar 
    	
    		<input type="checkbox" name="chk[]" value="0010000"> mer 
    	
    		<input type="checkbox" name="chk[]" value="0001000"> jeu 
    	
    		<input type="checkbox" name="chk[]" value="0000100"> ven 
    	
    		<input type="checkbox" name="chk[]" value="0000010"> sam 
    	
    		<input type="checkbox" name="chk[]" value="0000001"> dim 
    	</div>
    	<div class="col-md-12">&nbsp;</div>
    	<div class="col-md-3">&nbsp;</div>
    	<div class="col-md-9 responsive">
    		<select class="form-control" name="semaines">
    			<option value="0">Toutes les  semaines</option>
    			<option value="2">Toutes les 2 semaines</option>
    			<option value="3">Toutes les 3 semaines</option>
    			<option value="4">Toutes les 4 semaines</option>
    			<option value="5">Toutes les 5 semaines</option>
    			<option value="6">Toutes les 6 semaines</option>
    			<option value="7">Toutes les 7 semaines</option>
    			<option value="8">Toutes les 8 semaines</option>
    			<option value="9">Toutes les 9 semaines</option>
    			<option value="10">Toutes les 10 semaines</option>
    			<option value="11">Toutes les 11 semaines</option>
    			<option value="12">Toutes les 12 semaines</option>

    		</select>
    	</div>
    	<div class="col-md-12">&nbsp;</div>
    	<div class="col-md-3">&nbsp;</div>
    	<div class="col-md-2">Fin :</div>
    	<div class="col-md-2">
    		<input type="radio" name="jamain" value="jamais"> jamais
    	</div>
    	<div class="col-md-1">
    		<input type="radio" name="jamain" value="le"> Le
    	</div>
    	<div class="col-md-4 responsive">
    		<div class="form-group">
                <div class='input-group date' id='le'>
                    <input type='text' class="form-control" name="le" id="leinput" />
                   
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
    	</div>

    </div>
	<!-- Objet -->
	<div class="clear"></div>
	<div class="col-md-12">&nbsp;</div>
	<div class="col-md-3"><span class="text-control">Objet</span></div>
	<div class="col-md-9 responsive">
		<input type="text"  name="obj" class="form-control" placeholder="Entrez l'objet de l'absence">
	</div>

	<!-- Notes -->
	<div class="clear"></div>
	<div class="col-md-12">&nbsp;</div>
	<div class="col-md-3"><span class="text-control">Notes</span></div>
	<div class="col-md-9 responsive">
		<textarea class="form-control" name="note"></textarea>
	</div>
	<!-- Color -->
	<div class="clear"></div>
	<div class="col-md-12">&nbsp;</div>
	<div class="col-md-3">&nbsp;</div>
	<div class="col-md-9 responsive">
		<div class="input-group color input-group colorpicker-component">
		    <input type="text" value="" class="form-control" name="color" value="#cccccc" />
		    <span class="input-group-addon"><i></i></span>
		</div>
	</div>
	<div class="col-md-12">&nbsp;</div>

	<div class="clear"></div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button class="btn btn-danger cutom-btn" type="submit"><a id="eventUrl" target="_blank">Créer l'absence</a></button>
    </div>
</form>

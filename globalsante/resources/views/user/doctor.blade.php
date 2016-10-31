@extends("layout")

@section("content")
<section class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
		<div class="col-md-2 col-sm-12 col-xs-12 nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<input type= "button" value="Show Calendar" class="calendarButton btn btn-info" onclick="showCalendar('datepicker')"/>
			
				<div id="datepicker"></div>
			
				
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">&nbsp;</div>
			<!-- <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<button type="button" class="btn btn-success btnmotifConsultant" data-toggle="collapse" data-target="#motif_consultant">
			      <span class="glyphicon glyphicon-collapse-down"></span> Motifs de consultation
			    </button>
			  <div id="motif_consultant" class="collapse">
			  		@foreach($motif as $motifConsultant)
			   		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			   				<div class="col-md-1 col-sm-1 col-xs-1" >
			   					<div style="background:{{$motifConsultant->color}}; width:20px !important;height:15px;">
			   						
			   					</div>
			   				</div>
			   				<div class="col-md-10 col-sm-10 col-xs-10 click-text" id="click-text{{$motifConsultant->id_motif}}">{{$motifConsultant->motif}}</div>			   				
			   		</div>			   		

			   		@endforeach
			  </div>
			</div> -->
				
		</div>
		<div class="col-md-1 col-sm-12 col-xs-12">&nbsp;</div>
		<div class="col-md-9 col-sm-12 col-xs-12 nopadding">
			<div id='calendar'></div>
		</div>
		<div class="clear"></div>
		
	</div>
	<!-- <div id="eventDisplay">This is the event display...</div> -->
	

	<div id="fullCalModal" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header custom-modal">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>  <span class="sr-only">close</span>

	                </button>
	                
	 				 <ul class="nav nav-tabs" id="tabContent">
					        <li class="active">
					        	<a href="#consultation" data-toggle="tab">
					        		<span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>&nbsp;Consultation
					        	</a>
					       </li>
					        <li>
					        	<a href="#absence" data-toggle="tab">
					        		<span class="glyphicon glyphicon-ban-circle " aria-hidden="true"></span>&nbsp;Absence
					        	</a>
					        </li>
					       <!--  <li>
					        	<a href="#ouverture" data-toggle="tab">
					        		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;Ouverture
					        	</a>
					        </li> -->
					</ul>
	            </div>
	           
	            <div id="modalBody" class="modal-body tab-content">
	            		<div class="tab-pane active" id="consultation">
	            			@include('user.consultation')	            			
				      	</div> <!-- end of consultant -->
				        
				        <div class="tab-pane" id="absence">
				        	@include('user.absence')
				        </div> <!-- end  of absence -->


				       <div class="tab-pane" id="ouverture">
				        	@include('user.ouverture')
				       </div> <!-- end of ouverture -->
	            </div> <!-- end modal body -->
	           
	        </div>
	    </div>
	</div>


	<!-- Edit -->
	<div id="fullCalModaledit" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header custom-modal-edit">
	                <button type="button" class="close" data-dismiss="modal">
	                	<span aria-hidden="true">×</span>  <span class="sr-only">close</span>
	                </button>	                
	 				<h1 class="updateTile"></h1>
	            </div>
	           
	            <div id="modalBody" class="modal-body">
	            		<div>
	            			<form method="post" action="{!! action('AgendaController@updateConsultant') !!}" id="editformConsultant" role="form" data-toggle="validator">
	            				<input type="hidden" name="_token" value="{{ csrf_token() }}">
					        	<input type="hidden" value="" name="hiddendate" id="hiddendate">
					        	<input type="hidden" name="aid" id="aid">
					        	<!-- <input type="hidden" value="" name="hiddendate" id="hiddendate">
	                   			<input type="hidden" name="userid" value="{!! $userid !!}"> -->
	                   			<!-- Insert form here -->
	                   			<div class="" id="insertEditForm">
	                   				
	                   			</div>




								<!-- <div class="col-md-12">&nbsp;</div>	
								<div class="clear"></div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					                <button class="btn btn-primary cutom-btn" type="submit"><a id="eventUrl" target="_blank">mettre le rendez-vous</a></button>
					            </div>-->	
					        </form> 

				      	</div> <!-- end of consultant -->
	            </div> <!-- end modal body -->
	           
	        </div>
	    </div>
	</div>


	<!-- Edit absence -->
	<div id="modaleditAbsence" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header custom-modal-edit">
	                <button type="button" class="close" data-dismiss="modal">
	                	<span aria-hidden="true">×</span>  <span class="sr-only">close</span>
	                </button>	                
	 				<h1 class="updateTileAbsence">Absence</h1>
	            </div>
	           
	            <div id="modalBody" class="modal-body">
	            		<div>
	            			<form method="post" action="{!! action('AgendaController@updateAbsence') !!}" id="formAbsence" role="form" data-toggle="validator">
	            				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	            				<input type="hidden" name="userid" value="{!! $userid !!}">
					        	<input type="hidden" value="" name="hiddendate" id="hiddendate">
	                   			<div class="" id="insertEditFormAbsence">
	                   				


	                   			</div>
					        </form>	            			

				      	</div> <!-- end of consultant -->
	            </div> <!-- end modal body -->
	           
	        </div>
	    </div>
	</div>

	<!-- Edit Ouverture -->
	<div id="modaleditOuverture" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header custom-modal-edit">
	                <button type="button" class="close" data-dismiss="modal">
	                	<span aria-hidden="true">×</span>  <span class="sr-only">close</span>
	                </button>	                
	 				<h1 class="updateTileOuverture">Ouverture</h1>
	            </div>
	           
	            <div id="modalBody" class="modal-body">
	            		<div>
	            			<form method="post" action="{!! action('AgendaController@updateagendaOuverture') !!}" id="formOuverture" role="form" data-toggle="validator">
	            				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	            				<input type="hidden" name="userid" value="{!! $userid !!}">
					        	<input type="hidden" value="" name="hiddendate" id="hiddendate">
	                   			<div class="" id="insertEditFormOuverture">
	                   				


	                   			</div>
					        </form>	            			

				      	</div> <!-- end of consultant -->
	            </div> <!-- end modal body -->
	           
	        </div>
	    </div>
	</div>
</section>


 <?php 
 	$id = Session::get('user-id');
 	//echo $id."sdfasdf";
 ?>

@endsection


@section('js')
@parent
<script src="https://apis.google.com/js/client.js"> </script>
<script type="text/javascript">
//showCalendar
		function showCalendar(id) {
      var e = document.getElementById(id);

       if(e.style.display == 'block')

          e.style.display = 'none';

       else
       {
       	 
          e.style.display = 'block';
       }
		 
	}
	// for insert data into google calendar
		var clientId = '{{$doctorInfo->google_client_id}}',
	     	scopes = 'https://www.googleapis.com/auth/calendar',
	     	calendarId = '{{$doctorInfo->google_calendar_id}}';
	   	var apikey = '{{$doctorInfo->google_calendar_apikey}}';
	   // var nom,gdate_start,gdateEnd,eventid,location,description;
	   	function refresh() {
	        location.reload();
	    }
		function synEventToGcalendar(nom,gdate_start,gdateEnd,status,eventid,location,description){
		    var connectionSuccess = false;
			if (clientId != "" && calendarId != "" && apikey !="" ) {
				//gapi.client.setApiKey(apikey);
				//window.setTimeout(checkAuth,1);

	    		gapi.auth.authorize(
		            {
		               'client_id': clientId,
		               'scope': scopes,
		               'immediate': true
		            }, function(authResult){
		            	//console.log(authResult);
		            	connectionSuccess = true;
		            	 	if (authResult && !authResult.error) {	            	 	 
				            	//loadCalendarApi();
					          	gapi.client.load('calendar', 'v3', function(){
					            	 requestList = gapi.client.calendar.events.list({
							            'calendarId': calendarId
							         });
							         requestList
							            .then(function (resp) {						            	
							               if (resp.result.error) {
							               		alert("got error");
							               		//alert(data.error.message);
							                 // reportError('Google Calendar API: ' + data.error.message, data.error.errors);

							               } 
							               else{
							               		var resource = {
												  "summary": nom,
												  "location": location,
												  "description": description,
												  "start": {
												    "dateTime": gdate_start+'+07:00'
												  },
												  "end": {
												    "dateTime": gdateEnd+'+07:00'
												    }
												};

							               		if (status == "insert") {
													var request = gapi.client.calendar.events.insert({
													  'calendarId': 'primary',
													  'resource': resource
													});
													request.execute(function(resp) {
														//console.log(resp.id);
														var googleid = resp.id;
														var aid = $("#aid").val();
														$.ajax({		 	
												           url: "{!! action('AgendaController@saveEventsId') !!}",
														   type: "get",
														   data: "aid="+aid+"&googleid="+googleid,
														   success:function(response){
														   		//alert(response);
														   		if (response == 1) {
														   			refresh();
														   			//$(".close").click();
														   			//window.location.reload( true); 
														   		};
														   	  
														   }
														});
														//return googleid;
														//window.location = "{{url('/account')}}";
													  //  appendPre('Event created: ' + resp.htmlLink);
													});
												
							               		}
							               		if(status == "delete"){
							               			if (eventid != "") {
							               				var request = gapi.client.calendar.events.delete({
														  'calendarId': 'primary',
														  'eventId':eventid
														  //'resource': resource
														});
														request.execute(function(resp) {
															var id = $("#aid").val();
															var pid = $("#getpid").val();
															var did = "{{$userid}}";
															var date_start = $("#date_start").val();
															$.ajax({		 	
													           url: "{!! action('AgendaController@destroy') !!}",
															   type: "get",
															   data: "id="+id+"&pid="+pid+"&did="+did+"&date="+date_start,
															   success:function(response){
															    	refresh();
															   	// window.location.reload();
															   }
															});

														});
							               			}else{
							               					var id = $("#aid").val();
															var pid = $("#getpid").val();
															var did = "{{$userid}}";
															var date_start = $("#date_start").val()
															$.ajax({		 	
													           url: "{!! action('AgendaController@destroy') !!}",
															   type: "get",
															   data: "id="+id+"&pid="+pid+"&did="+did+"&date="+date_start,
															   success:function(response){
															    	refresh();
															   	//window.location.reload();
															   }
															});
							               			}
							               			
							               		}
							               		if (status == "update") {
							               			if (eventid != "") {
							               				var request = gapi.client.calendar.events.update({
														  'calendarId': 'primary', 
														  'eventId': eventid,
														  'resource': resource
														});
														request.execute(function(resp) {
															refresh();
														});
							               			}
							               			
							               		}
							               	}					               			

					    		         
							            }, function (reason) {
							            	alert("please input correct infor.");
							               console.log('Error: ' + reason.result.error.message);
							            });
								});
							}
							else{
								if (status == "delete") {

									var id = $("#aid").val();
									// alert(id);
									var pid = $("#getpid").val();

									var did = "{{$userid}}";
									var date_start = $("#date_start").val()
									$.ajax({		 	
							           url: "{!! action('AgendaController@destroy') !!}",
									   type: "get",
									   data: "id="+id+"&pid="+pid+"&did="+did+"&date="+date_start,
									   success:function(response){
									   		refresh();
									   }
									});
								}
								if (status == "update") {
									var fd = new FormData(document.getElementById("editformConsultant"));
									$.ajax({
								  		url      : "{!! action('AgendaController@updateConsultant') !!}",
						                type     : "POST",          
						               
						                data     : fd,
						                processData: false,  // tell jQuery not to process the data
										contentType: false,// tell jQuery not to set contentType
						                success  : function(response) {
						            		refresh();
						            				            		
						                }
							        });
								};
								//confirmGoogleAccount();
							}
					});
			}
			else{
				confirmGoogleAccount();
			}
			//if its wrong client id
			setTimeout(
			    function() {
			     	if (connectionSuccess == false) {
			     		confirmGoogleAccount();
						//alert("you can not access to your google account.please check your infor again");
					}
			    }, 3000);

						
			         // } else {
			         //    //handleAuthClick();
			           
			         //    //alert("you need to signin to your gmail account first");
			         // }
	            //});
		}//end synEventToGcalendar
	$(document).ready(function(){
		$(".existsEmail").hide();
		
		$("#formConsultant").on("submit",function(event){				
			event.preventDefault();	
			var connectionSuccess = false;
			if (clientId != "" && calendarId != "" && apikey !="" ) {					
					gapi.auth.authorize(
		            {
		               'client_id': clientId,
		               'scope': scopes,
		               'immediate': true
		            }, function(authResult){
		            	connectionSuccess = true;
		            	console.log(authResult);
		            	//alert(gapi.auth.authorize.client_id);
		            	if (authResult && !authResult.error) {	 
		            		console.log(authResult.access_token);
							var fd = new FormData(document.getElementById("formConsultant"));
						  	$.ajax({
						  		url      : "{!! action('AgendaController@submitConsultant') !!}",
				                type     : "POST",              
				               
				                data     : fd,
				                processData: false,  // tell jQuery not to process the data
								contentType: false,// tell jQuery not to set contentType
				                success  : function(response) {
				                	// alert(response);
				                	if (response == "0") {
				                		$(".existsEmail").show();
				                	}
				                	else{
				                		var getarr = response.split('|');
					            		$("#aid").val(getarr[3]);
					            		var dstart = getarr[0].split('+');
					            		var dend = getarr[1].split('+');
					            		synEventToGcalendar(getarr[2],dstart[0],dend[0],"insert",' ',getarr[4],getarr[5]);	
					                }
				            		
				            			   		
				                }
				            });
				         }
				       
				         else{
				         	// console.log(gapi.auth.authorize);
				         	// alert("fail");
				         	//console.log(authResult);
				        	confirmGoogleAccount();
				         }
				    });
					setTimeout(
					    function() {
					     	if (connectionSuccess == false) {
					     		confirmGoogleAccount();
							}
					    }, 3000); 
				
			}else{
				confirmGoogleAccount();
			} 


		});
		$("#editformConsultant").on("submit",function(event){
			event.preventDefault();
			var connectionSuccess = false;
			 if (clientId != "" && calendarId != "" && apikey !="" ) {
			 	gapi.auth.authorize(
	            {
	               'client_id': clientId,
	               'scope': scopes,
	               'immediate': true
	            }, function(authResult){
	            	connectionSuccess = true;
	            	console.log(authResult);
	            	if (authResult && !authResult.error) {	 
	            		//alert(1);
						 var fd = new FormData(document.getElementById("editformConsultant"));
						 $.ajax({
						  		url      : "{!! action('AgendaController@updateConsultant') !!}",
				                type     : "POST",           
				               
				                data     : fd,
				                processData: false,  // tell jQuery not to process the data
								contentType: false,// tell jQuery not to set contentType
				                success  : function(response) {
				                	//alert(2);
				            		var getarr = response.split('|');
				            		//$("#aid").val(getarr[3]);
				            		var dstart = getarr[0].split('+');
				            		var dend = getarr[1].split('+');
				            		synEventToGcalendar(getarr[2],dstart[0],dend[0],"update",getarr[3],getarr[4],getarr[5]);
				            				            		
				                }
				           });
					}
					else{

			         	var fd = new FormData(document.getElementById("editformConsultant"));
						 $.ajax({
						  		url      : "{!! action('AgendaController@updateConsultant') !!}",
				                type     : "POST", 
				                data     : fd,
				                processData: false,  // tell jQuery not to process the data
								contentType: false,// tell jQuery not to set contentType
				                success  : function(response) {
				                	location.reload();
				            		
				            				            		
				                }
				           });
			         }
				    setTimeout(
				    function() {
				     	if (connectionSuccess == false) {
				     		//confirmGoogleAccount();
							alert("you can not access to your google account.please check your infor again");
						}
				    }, 3000); 
				     });
			}else{
				var fd = new FormData(document.getElementById("editformConsultant"));
				 $.ajax({
				  		url      : "{!! action('AgendaController@updateConsultant') !!}",
		                type     : "POST", 
		                data     : fd,
		                processData: false,  // tell jQuery not to process the data
						contentType: false,// tell jQuery not to set contentType
		                success  : function(response) {
		                	location.reload();	            		
		            				            		
		                }
		           });	
			}
			 			 
					// var fd = new FormData(document.getElementById("editformConsultant"));
					// $.ajax({
				 //  		url      : "{!! action('AgendaController@updateConsultant') !!}",
		   //              type     : "POST",          
		               
		   //              data     : fd,
		   //              processData: false,  // tell jQuery not to process the data
					// 	contentType: false,// tell jQuery not to set contentType
		   //              success  : function(response) {
		   //          		var getarr = response.split('|');
		   //          		//$("#aid").val(getarr[3]);
		   //          		var dstart = getarr[0].split('+');
		   //          		var dend = getarr[1].split('+');
		   //          		synEventToGcalendar(getarr[2],dstart[0],dend[0],"update",getarr[3]);
		            				            		
		   //              }
			  //       });
		});

		// Action delete agenda 
		var id,pid,date_start ="",did = "{{$userid}}" ;
		$(document).on('click','a.delete_agenda',function(e){
			id = $(this).data("id");
			pid = $(this).data("p");
			date_start = $(this).data("date");

			$("#aid").val(id);
			$("#getpid").val(pid);
			// alert(did);
			deleteItem(id,pid,did,date_start);		
		});
		$(document).on('click','.delete_absence',function(e){
			id = $(this).data("id");
			//alert(id);
			pid = $(this).data("p");
			deleteItem(id,pid,did,date_start);		
		});
		$(document).on('click','.delete_ouverture',function(e){
			id = $(this).data("id");
			//alert(id);
			pid = $(this).data("p");
			deleteItem(id,pid,did,date_start);		
		});

		function deleteItem(id,pid,did,date_start) {
		    if (confirm("vous voulez supprimer ce rendez-vous?")) {
		        if (pid == "0") {
		         	//case absence
		         	$.ajax({		 	
			           url: "{!! action('AgendaController@destroyAbsence') !!}",
					   type: "get",
					   data: "id="+id,
					   success:function(response){
					   		//alert(response);
					   	  location.reload(); 
					   }
					});

		        }
		        else if (pid == "ouverture") {
		         		$.ajax({		 	
				           url: "{!! action('AgendaController@destroyOuverture') !!}",
						   type: "get",
						   data: "id="+id,
						   success:function(response){
						   		//alert(response);
						   	  location.reload(); 
						   }
						});
		        }
		        else{	         	
				    //     		$.ajax({		 	
						  //          url: "{!! action('AgendaController@deleteGcalendar') !!}",
								//    type: "get",
								//    data: "id="+id,
								//    success:function(response){
								//    		var getarr = response.split('|');
					   //          		var dstart = getarr[0].split('+');
					   //          		var dend = getarr[1].split('+');					   			
						  //           		synEventToGcalendar(getarr[2],dstart[0],dend[0],"delete",getarr[3]);   
								   		
								//    }
								// }); 
					var connectionSuccess = false; 
					//alert(id);
					if (clientId != "" && calendarId != "" && apikey !="" ) {
			         	gapi.auth.authorize(
			            {
			               'client_id': clientId,
			               'scope': scopes,
			               'immediate': true
			            }, function(authResult){
			            	connectionSuccess = true;
			            	if (authResult && !authResult.error) {
			            		var pid = $("#getpid").val();
			            		
			            		$.ajax({		 	
						           url: "{!! action('AgendaController@deleteGcalendar') !!}",
								   type: "get",
								    data: "id="+id,
								   success:function(response){
								   		var getarr = response.split('|');
					            		var dstart = getarr[0].split('+');
					            		var dend = getarr[1].split('+');					   			
						            	synEventToGcalendar(getarr[2],dstart[0],dend[0],"delete",getarr[3],'test','test');   
								   		
								   }
								});
			            	}
			            	else{
								var pid = $("#getpid").val();
								//alert(123);
								$.ajax({		 	
						           url: "{!! action('AgendaController@destroy') !!}",
								   type: "get",
								   data: "id="+id+"&pid="+pid+"&did="+did+"&date="+date_start,
								   success:function(response){
								   	 location.reload(); 
								   	// alert(response);
								   }
								});
					         }
				    	});
		         	}
		         	else{
		         		var pid = $("#getpid").val();
		         		//alert(did);
						$.ajax({		 	
				           url: "{!! action('AgendaController@destroy') !!}",
						   type: "get",
						   data: "id="+id+"&pid="+pid+"&did="+did+"&date="+date_start,
						   success:function(response){
						   	 	location.reload(); 
						   }
						});
		         	}	
		         //if its wrong client id
				setTimeout(
				    function() {
				     	if (connectionSuccess == false) {
				     		//confirmGoogleAccount();
							alert("you can not access to your google account.please check your infor again");
						}
				    }, 3000); 

			    }//end if

			}
			    return false;
		}
		function confirmGoogleAccount(){
			var msg = "Si vous souhaitez synchroniser votre calendrier avec votre compte Google Calendar, vous devez d\'abord vous connecter sur votre compte Google avant de continuer.Voulez-vous valider votre rdv sans synchroniser ?";
			if (confirm(msg)) {
					var fd = new FormData(document.getElementById("formConsultant"));
				  	$.ajax({
				  		url      : "{!! action('AgendaController@submitConsultant') !!}",
		                type     : "POST",               
		               
		                data     : fd,
		                processData: false,  // tell jQuery not to process the data
						contentType: false,// tell jQuery not to set contentType
		                success  : function(response) {
		                	if (response == "0") {
		                		$(".existsEmail").show();
		                	}
		                	else{
		                		refresh();
		                	}
		                	
		            		// var getarr = response.split('|');
		            		// $("#aid").val(getarr[3]);
		            		// var dstart = getarr[0].split('+');
		            		// var dend = getarr[1].split('+');
		            		// synEventToGcalendar(getarr[2],dstart[0],dend[0],"insert",' ');
		            			   		
		                }
		            });
			}
			return false;
			
		}

	});
</script>
<script type="text/javascript">
 $.fn.modal.Constructor.prototype.enforceFocus = function () {};
 </script>
 <script src="{{asset('js/doctor.js')}}"></script> 
<script type="text/javascript">	
	$(document).ready(function() {
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		//console.log(repeatBysemaines(2));
		var repeatingEvents = [

		    	@foreach($evenCon as $eventscon)
					@if ($eventscon->id_meeting_type == 2)
						{
							id: '{{$eventscon->aid}}', 
							title: '{{$eventscon->first_name}} {{$eventscon->last_name}}',
							start: '{{$eventscon->date_start}}',
							end:'{{$eventscon->date_end}}',							
							color:'{{$eventscon->color}}'						
							//url:'{!! action("AgendaController@agendaList") !!}'
						},
					@endif

				@endforeach
				@if ($event != null)
					@foreach($event as $events)					
						@if ($events->id_meeting_type == 3)
							@if ($events->days == "")
								{
									id: '{{$events->id}}',
									title: 'Absence',
									start: '{{$events->date_start}}',
									end:'{{$events->date_end}}',
									color:'{{$events->color}}'
								},
								
							@endif
							

						@endif

						@if ($events->id_meeting_type == 4)
							{
								id: '{{$events->id}}',
								title: 'Ouverture',
								start: '{{$events->date_start}}',
								end:'{{$events->date_end}}',
								color:'{{$events->color}}'
							},
						@endif
					@endforeach
				@endif


		];
		//emulate server
		var getEvents = function( start, end ){
		    return repeatingEvents;
		}

		$('#calendar').fullCalendar({

				header: {
					left: 'prev,next today', // prev,next today
					center: 'title',
					right: 'semaineouvree, month,agendaWeek,agendaDay' // month,agendaWeek,agendaDay
				},			
		

				defaultView: 'agendaWeek', // agendaDay -> For main page.
				selectable: true,
				disableResizing: true,
				selectHelper: true,
				lang: 'fr',
				dayNamesShort: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
				allDaySlot: false,
				 columnFormat: {
	                // month: 'dddd',    // Monday, Wednesday, etc
	                week: 'dd DD', // Monday 9/7
	                day: 'dd DD'  // Monday 9/7
	            },
	             views: {
	             	semaineouvree: {
			            type: 'agendaWeek',
			            weekends: false,
			            hiddenDays: [ 6, 7],
			            buttonText: 'Semaine ouvrée'
			  
			            
			        }
			      
	             },

	             viewRender: function (view, element) {
	             	 //setTimeline(view);

	             	var getDates = function(startDate, endDate) {
						  var dates = [],
						      currentDate = startDate,
						      addDays = function(days) {
						        var date = new Date(this.valueOf());
						        date.setDate(date.getDate() + days);
						        return date;
						      };
						     // alert(currentDate);
						     // alert(endDate);

						  while (currentDate <= endDate) {
						    dates.push(currentDate);
						    currentDate = addDays.call(currentDate, 1);
						    currentDate = moment(currentDate).format('YYYY-MM-DD');
						    //alert(currentDate);

						  }
						  return dates;
					};
					var start = moment(view.start).format('YYYY-MM-DD');
					var end = moment(view.end).format('YYYY-MM-DD');

	             	if (view.type == "agendaWeek") {
	             		
						var html = "";
						html += '<tr><th class="fc-axis fc-widget-header" style="width: 17px;"></th>';
						var dd = getDates(start, end); 
						var arr_day = [],arr_month = [],arr_year = [];
						
						@foreach($pcount as $count)
							arr_day.push({{$count->d}});
							arr_month.push({{$count->m}});
							arr_year.push({{$count->y}});
						@endforeach
						

						var i = 1;  

						dd.forEach(function(date) {
							var arr_split = date.split("-");
							var is_arryear = isInArray(parseInt(arr_split[0]),arr_year);
							var is_arrmonth = isInArray(parseInt(arr_split[1].replace(/^0+/, '')),arr_month);
							var is_arrday = isInArray(parseInt(arr_split[2].replace(/^0+/, '')),arr_day);
							if (i <=7) {
								if (is_arryear == true) {
									if (is_arrmonth == true) {
										if (is_arrday == true) {	
											@foreach($pcount as $count)				
												if (parseInt(arr_split[2].replace(/^0+/, '')) == {{$count->d}}) {
													if ({{$count->pid}} == 1) {
														html += '<th class="fc-day-header fc-widget-header"> <p class="desktop">{{$count->pid}} patient</p><p class="mobile">{{$count->pid}}<br>p</p></th>';

													}
													else{
														html += '<th class="fc-day-header fc-widget-header"> <p class="desktop">{{$count->pid}} patients</p><p class="mobile">{{$count->pid}}<br>p</p></th>';											
													}
												};
											@endforeach
										}else{
											html += '<th class="fc-day-header fc-widget-header"><p class="desktop">0 patient</p><p class="mobile">0<br>p</p></th>';

										}
									}
									else{
											html += '<th class="fc-day-header fc-widget-header"><p class="desktop">0 patient</p><p class="mobile">0<br>p</p></th>';

									}
								}else{
									html += '<th class="fc-day-header fc-widget-header"><p class="desktop">0 patient</p><p class="mobile">0<br>p</p></th>';

								} 
							}
							i++;	 	

						});

						html += '</tr>'; 
						  $(html).insertBefore(".fc-row tr");

	             	}
	             	else if(view.type == "agendaDay"){
	             		var html = "";
						html += '<tr><th class="fc-axis fc-widget-header" style="width: 17px;"></th>';
						var dd = getDates(start, end); 
						var arr_day = [];
						var arr_month = [];
						var arr_year = [];

						@foreach($pcount as $count)
							arr_day.push({{$count->d}});
							arr_month.push({{$count->m}});
							arr_year.push({{$count->y}});
						@endforeach
						

						var i = 1;  

						dd.forEach(function(date) {
							var arr_split = date.split("-");
							var is_arryear = isInArray(parseInt(arr_split[0]),arr_year);
							var is_arrmonth = isInArray(parseInt(arr_split[1].replace(/^0+/, '')),arr_month);
							var is_arrday = isInArray(parseInt(arr_split[2].replace(/^0+/, '')),arr_day);
							if (i ==1) {
								if (is_arryear == true) {
									if (is_arrmonth == true) {
										if (is_arrday == true) {	
											@foreach($pcount as $count)				
												if (parseInt(arr_split[2].replace(/^0+/, '')) == {{$count->d}}) {
													if ({{$count->pid}} == 1) {
															html += '<th class="fc-day-header fc-widget-header"> {{$count->pid}} patient</th>';

													}
													else{
														html += '<th class="fc-day-header fc-widget-header"> {{$count->pid}} patients</th>';												
													}
												};
											@endforeach
										}else{
										html += '<th class="fc-day-header fc-widget-header">0 patient</th>';


										}
									}
									else{
											html += '<th class="fc-day-header fc-widget-header">0 patient</th>';


									}
								}else{
									html += html += '<th class="fc-day-header fc-widget-header">0 patient</th>';


								} 
							}
							i++;	 	

						});
						  //$('<tr><th class="fc-axis fc-widget-header" style="width: 17px;"></th><th class="fc-day-header fc-widget-header">1</th></tr>').insertBefore(".fc-row tr");
						html += '</tr>'; 
						 $(html).insertBefore(".fc-row tr");
	             	}
	             	else if(view.type == "month"){            		

	             		var arr_mon = [],arr_tue = [],arr_wed = [],arr_thu = [],arr_fri = [],arr_sar = [],arr_sun = [];	             		
	             		var mon = 0,tue = 0,wed = 0,thu = 0,fri = 0,sar = 0,sunday =0,i=1;           		
	             		var arr_day = [],arr_month = [],arr_year = [];
	             		
	             		var currentMonth = GetCurrentDisplayedMonth();
	   					var arr_my = currentMonth.split(",");
	   					var month = parseInt(arr_my[0])+1;
	   					var year = arr_my[1];

	   					//alert(month);
	             		@foreach($pcount as $count)
	             			arr_day.push({{$count->d}});
							arr_month.push({{$count->m}});
							arr_year.push({{$count->y}});
	             		@endforeach


	             		@foreach($pcount as $count)	
	             			if (year == {{$count->y}}) {

	             				if (month == {{$count->m}}) {
	             					//alert(month);
	             					if ({{$count->weekinday}}  == 1) {
			             				arr_mon.push({{$count->pid}});
			             			}
			             			if({{$count->weekinday}}  == 2){
			             				arr_tue.push({{$count->pid}});
			             			}
			             			if({{$count->weekinday}}  == 3){
			             				arr_wed.push({{$count->pid}});
			             			}
			             			if({{$count->weekinday}}  == 4){
			             				arr_thu.push({{$count->pid}});
			             			}
			             			if({{$count->weekinday}}  == 5){
			             				arr_fri.push({{$count->pid}});
			             			} 
			             			if({{$count->weekinday}}  == 6){
			             				arr_sar.push({{$count->pid}});
			             			}
			             			if({{$count->weekinday}}  == 7){
			             				arr_sun.push({{$count->pid}});
			             			}
	             				}
	             			}			
							
						@endforeach
						var str_mon = "",str_tue = "",str_wed = "",str_thu = "",str_fri = "",str_sar = "",str_sun = "";
						
						mon = sumarray(mon,arr_mon);
						str_mon = getPartient(str_mon,mon);

						tue = sumarray(tue,arr_tue);
						str_tue = getPartient(str_tue,tue);

						wed = sumarray(wed,arr_wed);
						str_wed = getPartient(str_wed,wed);

						thu = sumarray(thu,arr_thu);
						str_thu = getPartient(str_thu,thu);

						fri = sumarray(fri,arr_fri);
						str_fri = getPartient(str_fri,fri);

						sar = sumarray(sar,arr_sar);
						str_sar = getPartient(str_sar,sar);

						sunday = sumarray(sunday,arr_sun);
						str_sun = getPartient(str_sun,sunday);	

						  $('<tr><th class="fc-day-header fc-widget-header">'+str_mon+'</th><th class="fc-day-header fc-widget-header">'+str_tue+'</th><th class="fc-day-header fc-widget-header">'+str_wed+'</th><th class="fc-day-header fc-widget-header">'+str_thu+'</th><th class="fc-day-header fc-widget-header">'+str_fri+'</th><th class="fc-day-header fc-widget-header">'+str_sar+'</th><th class="fc-day-header fc-widget-header">'+str_sun+'</th></tr>').insertBefore(".fc-head-container .fc-row table tr");

	             	}
	             	else if(view.type == "semaineouvree"){
		             		var html = "";
							html += '<tr><th class="fc-axis fc-widget-header" style="width: 17px;"></th>';
							var dd = getDates(start, end); 
							var arr_day = [];
							var arr_month = [];
							var arr_year = [];
							@foreach($pcount as $count)
								arr_day.push({{$count->d}});
								arr_month.push({{$count->m}});
								arr_year.push({{$count->y}});
							@endforeach
							

							var i = 1;  

							dd.forEach(function(date) {
								var arr_split = date.split("-");
								var is_arryear = isInArray(parseInt(arr_split[0]),arr_year);
								var is_arrmonth = isInArray(parseInt(arr_split[1].replace(/^0+/, '')),arr_month);
								var is_arrday = isInArray(parseInt(arr_split[2].replace(/^0+/, '')),arr_day);
								if (i <=5) {
									if (is_arryear == true) {
										if (is_arrmonth == true) {
											if (is_arrday == true) {	
												@foreach($pcount as $count)				
													if (parseInt(arr_split[2].replace(/^0+/, '')) == {{$count->d}}) {
														if ({{$count->pid}} == 1) {
															html += '<th class="fc-day-header fc-widget-header"> <p class="desktop">{{$count->pid}} patient</p><p class="mobile">{{$count->pid}}<br>p</p></th>';
														}
														else{
															html += '<th class="fc-day-header fc-widget-header"> <p class="desktop">{{$count->pid}} patients</p><p class="mobile">{{$count->pid}}<br>p</p></th>';												
														}
													};
												@endforeach
											}else{
												html += '<th class="fc-day-header fc-widget-header"><p class="desktop">0 patient</p><p class="mobile">0<br>p</p></th>';
											}
										}
										else{
												html += '<th class="fc-day-header fc-widget-header"><p class="desktop">0 patient</p><p class="mobile">0<br>p</p></th>';

										}
									}else{
										html += '<th class="fc-day-header fc-widget-header"><p class="desktop">0 patient</p><p class="mobile">0<br>p</p></th>';


									} 
								}
								i++;	 	

							});
							html += '</tr>'; 
						  $(html).insertBefore(".fc-row tr");
						  //$('<tr><th class="fc-axis fc-widget-header" style="width: 17px;"></th><th class="fc-day-header fc-widget-header">1</th><th class="fc-day-header fc-widget-header">2</th><th class="fc-day-header fc-widget-header">3</th><th class="fc-day-header fc-widget-header">4</th><th class="fc-day-header fc-widget-header">5</th></tr>').insertBefore(".fc-row tr");

	             	}
	             },
	            dayRender: function(date, element, view) {
	            	
	            },

				select: function(start, end, allDay) {
					
					fullcalendaDate(start,end);
					
			  
				},
				editable: false,

				
				googleCalendarApiKey: 'AIzaSyAhYCgzyemDcPURU_Z8ZwjnCzCyPrQNO9I',
				
			   //  eventSources: [
			   //  	 	{ 
				  //   	  // googleCalendarApiKey: 'AIzaSyAhYCgzyemDcPURU_Z8ZwjnCzCyPrQNO9I',
						//    googleCalendarId: 'seamaly168@gmail.com',
						//    className: 'gcal-event'
						// }
			   //  	//'https://calendar.google.com/calendar/ical/seamaly168%40gmail.com/public/basic'
			   //  ],
				events:[
						@foreach($evenCon as $eventscon)
							@if ($eventscon->id_meeting_type == 2)
								{
									id: '{{$eventscon->aid}}', 
									title: '{{$eventscon->first_name}} {{$eventscon->last_name}}',
									start: '{{$eventscon->date_start}}',
									end:'{{$eventscon->date_end}}',							
									color:'{{$eventscon->color}}',
									googleCalendarId: 'seamaly168@gmail.com',
						  			className: 'gcal-event' 						
									//url:'{!! action("AgendaController@agendaList") !!}'
								},
							@endif

						@endforeach
						@if ($event != null)
							@foreach($event as $events)					
								@if ($events->id_meeting_type == 3)
									@if ($events->days == "")
										{
											id: '{{$events->id}}',
											title: 'Absence',
											start: '{{$events->date_start}}',
											end:'{{$events->date_end}}',
											color:'{{$events->color}}',
											googleCalendarId: 'seamaly168@gmail.com',
							 			    className: 'gcal-event'
										},
										
									@endif
									

								@endif

								@if ($events->id_meeting_type == 4)
									// {
									// 	id: '{{$events->id}}',
									// 	title: 'Ouverture',
									// 	start: '{{$events->date_start}}',
									// 	end:'{{$events->date_end}}',
									// 	color:'{{$events->color}}',
									// 	googleCalendarId: 'seamaly168@gmail.com',
							  //  			className: 'gcal-event' 
									// },
								@endif
							@endforeach
						@endif
			    ],
				eventClick: function(event) {
			        //if (event.url) {
			           //$('#fullCalModaledit').modal();
			            //return false;
			        if (event.title == "Absence") {
	  					//alert(123);
			        	$.ajax({
				           url: "{!! action('AgendaController@editagendaAbsence') !!}",
						   type: "get",
						   data: "aid="+event.id,
						   success:function(response){
						   		// var split_arr = response.split("|");	
						   		// $(".updateTile").html(split_arr[1]);
						   		$("#insertEditFormAbsence").html(response);

						   		//var getTitle = $(".hiddenModaltitle").val();
						   		//$(".updateTile").text(getTitle);
						  		//
						  		//alert(response);
						  		$('#modaleditAbsence').modal();
						    }

						});

			        }
			        else if (event.title == "Ouverture") {
			        		$.ajax({
						           url: "{!! action('AgendaController@editagendaOuverture') !!}",
								   type: "get",
								   data: "aid="+event.id,
								   success:function(response){
								   		$("#insertEditFormOuverture").html(response);
								  		$('#modaleditOuverture').modal();
								    }

							});
			        }
			        else{

			        	var newsend = moment(event.end).format('YYYY-MM-DD HH:mm');
			        	
			        	$.ajax({
				           url: "{!! action('AgendaController@editagenda') !!}",
						   type: "get",
						   data: "aid="+event.id,
						   success:function(response){
						   		// var split_arr = response.split("|");	
						   		// $(".updateTile").html(split_arr[1]);

						   		
						   		$("#insertEditForm").html(response);
						   		var getTitle = $(".hiddenModaltitle").val();
						   		$(".updateTile").text(getTitle);
						   		$("#dfin").val(newsend);
						  		//
						  		//alert(response);
						  		$('#fullCalModaledit').modal();

						    }

						});
			        }
			           



			        //}
			    },
			   
				// Fix title special character here
				eventRender: function(event, element, view){
				  element.find('div.fc-title').html(event.title);
				 // console.log(event.start.format());
				  	if (!!event.ranges) {
				  		//console.log("true");
				  		 return (event.ranges.filter(function(range){
				            return (event.start.isBefore(range.end) &&
				                    event.end.isAfter(range.start));
				        }).length)>0;
				  	};
			       
	                 
				},
				eventDrop: function(event, delta, revertFunc) {
					alert("event drop");
			            moveEvents(event.start,event.end,event.id,event.title);
				        

	    		}
	    // 		eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
					// //alert("event resize");
					// //alert(minuteDelta);
					// console.log(event);
    	// 			//moveEvents(event.start,event.end,event.id,event.title);
			     
				        
			  //   }

		
		 });
			
			// recurrence = moment("01/01/2016").recur().every(2).weeks();
			// console.log(recurrence.matches( "01/02/2016" ));

		//Add repeat even every day for absence
		$('#calendar').fullCalendar( 'addEventSource',        
	        function(start, end,timezone, callback) {	        	
	            var events = [];

	       		var one_day = (24 * 60 * 60 * 1000);
				for (loop = start.toDate().getTime();
		            loop <= end.toDate().getTime();
		            loop = loop + one_day) {
		            var column_date = new Date(loop);
		        		@if ($event != null) 
			               @foreach($event as $events)
			               	var getday = returnDays('{{$events->days}}');				    
								@if ($events->id_meeting_type == 3)
									var getstartHour = '{{$events->date_start}}'.split(" ");									
					               	var startHour = getstartHour[1].split(":");
					               	var getendtime = '{{$events->date_end}}'.split(" ");
					               	var finHours = getendtime[1].split(":");
					               	var newstart = moment(start).format('HH:mm');
					               //==========
					                var getNumberMonth = column_date.getMonth()+1;
				               		var getNumberDay = column_date.getDay();
				               		var getDMY = getstartHour[0].split("-");
				               		var getDAY = column_date.getDate();
				               		
				               		//absence must start from date start
				               		@if ($events->days != "")
										//unlimit semain with specific stat date
						               	@if ($events->semaines == 0 && $events->fin_repete == "jamais")				               						               		
						               		for(var i = 0;i<= getday.length;i++){
						               			if (column_date.getDay() == getday[i]) {							               				
					               					if (getNumberMonth == getDMY[1] && getDAY >= getDMY[2]) {
					               						//var rInterval = moment( "{{$events->date_start}}" ).recur().every(2).weeks();
															//if (rInterval.matches( column_date ) == true) {
																//alert("true"+rInterval);
																//console.log(rInterval);
																events.push({
											               			id: '{{$events->id}}',
												                    title: 'Absence',
												                    start: new Date(column_date.setHours(startHour[0], startHour[1])),
												                    //start: dateString2Date('19-05-2016 12:00:00'),										                   
												                    end: new Date(column_date.setHours(finHours[0], finHours[1])),
												                    color:'{{$events->color}}',
												                    allDay: false
									                			});
															//};
							               					
									                	
								                	}
								                	if (getNumberMonth > getDMY[1]) {
								                			events.push({
										               			id: '{{$events->id}}',
											                    title: 'Absence',
											                    start: new Date(column_date.setHours(startHour[0], startHour[1])),
											                    //start: dateString2Date('19-05-2016 12:00:00'),										                   
											                    end: new Date(column_date.setHours(finHours[0], finHours[1])),
											                    color:'{{$events->color}}',
											                    allDay: false
									                		});

								                	}
							                	}
						               		}
						               
						                @endif
					                @endif
						            
					               
				           		@endif

						   @endforeach 	
						@endif	           
		        } // for loop
		        @if ($event != null)
				        @foreach($event as $events)			        	
				        	var eventstart = moment('{{$events->date_start}}').format('YYYY-MM-DDTHH:mm:ssZ'); 
							var eventend = moment('{{$events->date_end}}').format('YYYY-MM-DDTHH:mm:ssZ'); 			        			       				      					
							@if ($events->id_meeting_type == 3)
								@if ($events->days != "")
									//alert(45);
				               		var date_start = '{{$events->date_start}}'; 
				               		var date_end = '{{$events->date_end}}';
				               		var splitDateStart = date_start.split(" ");
				               		var splitDateEnd = date_end.split(" ");
									//unlimit semain with frequency
					               	@if ($events->semaines != 0 && $events->fin_repete == 'jamais')	
						               		recurrence = moment().recur({
											    start: splitDateStart[0],
											    end: "01/01/2017"
											}).every({{$events->semaines}}).weeks();
											allDates = recurrence.all("L");
											//console.log( allDates);					
											for( var j = 0;j< allDates.length;j++ ){
												var estart = "";
												var eend = "";
												var calStart = moment(start).format('MM/DD/YYYY');
												estart = moment(allDates[j]+' '+splitDateStart[1]).format('YYYY-MM-DDTHH:mm:ssZ'); 
												eend = moment(allDates[j]+' '+splitDateEnd[1]).format('YYYY-MM-DDTHH:mm:ssZ');
												if (calStart == allDates[j]) {
													events.push({
									           			id: '{{$events->id}}',
									                    title: 'Absence',
									                    start: estart,
									                    end: eend,
									                    color:'{{$events->color}}',
									                    dow: returnDays('{{$events->days}}'),                   
									                    allDay: false
									        		});
												}
												

											}
										@elseif ($events->semaines != 0 && $events->fin_repete != 'jamais')
											//alert(splitDateStart[0]);

											var newend = "{{$events->fin_repete}}".replace(/-/g, '/');
											//alert(newend);
											recurrence = moment().recur({
											    start: splitDateStart[0],
											    end: newend
											}).every({{$events->semaines}}).weeks();
											allDates = recurrence.all("L");
											for( var j = 0;j< allDates.length;j++ ){
												var estart = "";
												var eend = "";
												var calStart = moment(start).format('MM/DD/YYYY');
												//alert(calStart);
												estart = moment(allDates[j]+' '+splitDateStart[1]).format('YYYY-MM-DDTHH:mm:ssZ'); 
												eend = moment(allDates[j]+' '+splitDateEnd[1]).format('YYYY-MM-DDTHH:mm:ssZ');
												if (calStart == allDates[j]) {
													events.push({
									           			id: '{{$events->id}}',
									                    title: 'Absence',
									                    start: estart,
									                    end: eend,
									                    color:'{{$events->color}}',
									                    dow: returnDays('{{$events->days}}'),                   
									                    allDay: false
									        		});
												}
											}

								        //repeat without frequency
										@elseif ($events->semaines == 0 && $events->fin_repete != 'jamais')
											events.push({
							           			id: '{{$events->id}}' ,
							                    title: 'Absence',
							                    start: eventstart,
							                    end: eventend,
							                    color:'{{$events->color}}',
							                    dow: returnDays('{{$events->days}}'),
							                    ranges: [{ //repeating events are only displayed if they are within one of the following ranges.
											        start: moment('{{$events->date_start}}').startOf('week'), //next two weeks
											        end: moment('{{$events->fin_repete}}').endOf('week'),
											     }],
							                    allDay: false
							        		});

							        		@endif
										@endif

							    @endif
								     
				        @endforeach
				@endif
						
				//console.log(events);           
		        callback( events );
	        }
	    	);
	
		var d1,d2,eid,etitle;
		function moveEvents(d1,d2,eid,etitle){
		    var newstart = moment(d1).format('YYYY-MM-DD HH:mm');
		    var newend = moment(d2).format('YYYY-MM-DD HH:mm'); 
		    if (etitle != "Absence" && etitle != "ouverture") {
		        if (confirm("Etes-vous sûr de ce changement?") == true) {
		            //alert(newstart);         
		            $("#dhour").val(newstart);

		            //alert(clientId);

		            if (clientId != "" && calendarId != "" && apikey !="" ) {
		                gapi.auth.authorize(
		                {
		                   'client_id': clientId,
		                   'scope': scopes,
		                   'immediate': true
		                }, function(authResult){
		                    connectionSuccess = true;
		                    console.log(authResult);
		                        if (authResult && !authResult.error) {   
		                            $.ajax({                            
		                                   url: "{!! action('AgendaController@dragAgendaById') !!}",
		                                   type: "get",
		                                   data: "aid="+eid+"&date="+newstart+"&dend="+newend,
		                                   success:function(response){
		                                        var getarr = response.split('|');
		                                        //$("#aid").val(getarr[3]);
		                                        var dstart = getarr[0].split('+');
		                                        var dend = getarr[1].split('+');
		                                        synEventToGcalendar(getarr[2],dstart[0],dend[0],"update",getarr[3]);
		                                        
		                                    }

		                                });
		                        }
		                        else{

		                            $.ajax({                            
		                               url: "{!! action('AgendaController@dragAgendaById') !!}",
		                               type: "get",
		                               data: "aid="+eid+"&date="+newstart+"&dend="+newend,
		                               success:function(response){
		                                    //location.reload();
		                                }

		                            });
		                         }
		                        setTimeout(
		                        function() {
		                            if (connectionSuccess == false) {
		                                //confirmGoogleAccount();
		                                alert("you can not access to your google account.please check your infor again");
		                            }
		                        }, 3000); 
		                         });
		                }else{
		                    $.ajax({                            
		                       url: "{!! action('AgendaController@dragAgendaById') !!}",
		                       type: "get",
		                       data: "aid="+eid+"&date="+newstart+"&dend="+newend,
		                       success:function(response){
		                            //location.reload();
		                            
		                        }

		                    });
		                }


		            
		            }
		            else{
		                //alert("false");
		                revertFunc();
		            }
		    };  
		} 
		

	});

	$(document).ready(function() {			
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
		                       label: 'Aucun résultat', 
		                       value: response.term
		                       }
		                    ];
		                   response(result);
		                }
		                else{
		                    
		                    response($.map(data, function(obj) {
		                        //alert(2);
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


		//Patient autocomplete
		// $("#autoexist").autocomplete({
		
		//     source: function( request, response ){

		//         $.ajax({

		//             url: "{{URL('autopatient')}}",
		//             dataType: "json",
		//             data: {
		//                 q: request.term
		//             },
		           
		//             success: function(data) {
		//                 if(!data.length){
		//                     var result = [
		//                        {
		//                        label: 'Aucun résultat.', 
		//                        value: response.term
		//                        }
		//                      ];
		//                     response(result);
		//                  }
		//                 else{

		//                     response($.map(data, function(obj) {
		                        
		//                         return {
		//                             label: obj.value,
		//                             value: obj.value,
		//                             id: obj.id 
		//                         };

		//                     }));
		//                 }
		                        
		//             }
		//         });
		       
		//     },
		//     minLength: 1,
		//     select: function(event, ui) { 
		//         $("#hiddepid").val(ui.item.id);
		//         var pid = ui.item.id;
		//        // alert(pid);
		//         $.ajax({            
		//            url: "{!! action('ConfigurationController@editPatient') !!}",
		//            type: "get",
		//            data: "pid="+pid,
		//            success:function(response){
		//            	//alert(response);
		//                 $(".existPatientForm").html(response);  
		//                 $(".remove-modal-footer").remove();  
		//                 $(".noveauPatient").find("input") .removeAttr("required");        
		//            }
		//         });
		        
		//     },
		//     cache: false

		// });

		 $("#autoexist").select2({
	            placeholder: "Patient...",
	            allowClear: true,
	            language: {
	            	noResults: function(term) {
	            		return "Aucun résultat.";
	            	}
	            }

	      });

		 $("#autoexist").on("change",function(){
		 	var pid = $(this).val();
		 	$("#hiddepid").val(pid);
		        $.ajax({            
		           url: "{!! action('ConfigurationController@editPatient') !!}",
		           type: "get",
		           data: "pid="+pid,
		           success:function(response){
		           	//alert(response);
		                $(".existPatientForm").html(response);  
		                $(".remove-modal-footer").remove();  
		                $(".noveauPatient").find("input") .removeAttr("required");        
		           }
		        });
		 });
	});
	

</script>



@stop
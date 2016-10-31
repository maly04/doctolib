@extends("layout")

@section("content")
<!-- <div id="wrapper"> -->
 <!-- Sidebar -->
      <!--   <div id="sidebar-wrapper" class="wrapper-setmargin"> -->
           <!--  <ul class="sidebar-nav" style="margin-left:-250px;">
                <li>
                    <a href="<?php echo URL::to('/configuration/mon-compte'); ?>"><span class="glyphicon glyphicon-user"></span> Mon compte</a>
                </li>
                <li>
                    <a href="#"><span class="glyphicon glyphicon-euro"></span> Facturation</a>
                </li>
                <li>
                    <a href="#"><span class="glyphicon glyphicon-phone"></span> Synchronisation mobile</a>
                </li>
                <li>
                    <a href="#"><span class="glyphicon glyphicon-phone"></span> Connexions</a>
                </li>
            </ul> -->
        <!-- </div> -->
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <!-- <div id="page-content-wrapper"> -->
            <div class="container">
                <div class="row ">
                	<div class="col-md-12  col-sm-12 col-xs-12"> 
                		<div class="col-md-2  col-sm-12 col-xs-12">
                		</div>
	                	<div class="col-md-8  col-sm-12 col-xs-12">
	                			@if($imgerror)
							  <div class=" col-md-12 alert alert-warning col-sm-12 col-xs-12">
							  	{{$imgerror}}
							  </div>

							@endif
		                	<div class="col-md-12 nopadding col-sm-12 col-xs-12">                		
		                		<div class="col-md-3 col-sm-12 col-xs-12"> 
		                		</div>
		                		<div class="col-md-5 col-sm-12 col-xs-12">
		                			<div class="col-md-12">
										<img src="{{URL('/')}}/img/uploads/{{ isset($doctor->photo) ? $doctor->photo : 'default_logo.jpg' }}" id="default_photo" width="250" height="200">
		                				
		                			</div>
		                			<div class="clear">&nbsp;</div>

		                			<form method="post" action="{!! action('ConfigurationController@uploadFile') !!}" role="form" data-toggle="validator" enctype="multipart/form-data">
			                			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			                			<div class="col-md-12 col-sm-12 col-xs-12" >
			    							<input id="input-4" name="photo" type="file" class="file-loading" value="{{ isset($doctor->photo) ? $doctor->photo : 'default_logo.jpg' }}" accept="image/x-png, image/gif, image/jpeg,image/jpg">   
			                				
			                			</div>
		                			</form>
		                		</div>
		                		<div class="col-md-4">                			
		                		</div>
		                	</div>

		                	<div class="clear">&nbsp;</div>

		                    <div class="col-md-12 nopadding col-sm-12 col-xs-12">
	                		<form method="post" action="{!! action('ConfigurationController@updateprofil') !!}" role="form" data-toggle="validator">
	                      	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                       <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Nom</span>
		                       </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                        	<div class="form-group">
		                        		<input type="text" class="form-control" name="first_name" value="{{$doctor->first_name}}">
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>

		                        <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Prénom</span>
		                        </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                        	<div class="form-group">
		                        		<input type="text" class="form-control" name="last_name" value="{{$doctor->last_name}}">
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>

		                        <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Email</span>
		                        </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                       		<div class="control-group">
			                        	<div class="form-group controls">
			                        		<input type="email" class="form-control" name="email" value="{{$doctor->email}}" required>
			                        		<div class="help-block"></div>
			                        	</div>
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>

		                        <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Calendar ApiKey</span>
		                        </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                       		<div class="control-group">
			                        	<div class="form-group controls">
			                        		<input type="text" class="form-control" name="apikey" value="{{$doctor->google_calendar_apikey}}">
			                        		
			                        	</div>
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>

		                         <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Calendar ID</span>
		                        </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                       		<div class="control-group">
			                        	<div class="form-group controls">
			                        		<input type="text" class="form-control" name="calendarid" value="{{$doctor->google_calendar_id}}">
			                        		
			                        	</div>
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>

		                        <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Client ID</span>
		                        </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                       		<div class="control-group">
			                        	<div class="form-group controls">
			                        		<input type="text" class="form-control" name="clientid" value="{{$doctor->google_client_id}}">
			                        		
			                        	</div>
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-3 col-xs-3">
		                       		<span class="text-control">Téléphone portable</span>
		                        </div>
		                        <div class="col-md-9 col-sm-9 col-xs-9">
		                        	
			                        	<div class="form-group">
			                        		<input type="text" class="form-control" name="tel" value="{{$doctor->phone}}">
			                        		
			                        	</div>
			                    </div>
								<div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-12 col-xs-12">
		                       		<span class="text-control">Mot de passe</span>
		                        </div>
		                        <div class="col-md-9 col-sm-12 col-xs-12">
		                        	<div class="form-group">
		                        		<a data-toggle="modal" data-target="#forgetpwd" style="cursor:pointer;">Modifier mon mot de passe</a>
		                        	</div>
		                        </div>
								<div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-2 col-xs-2">
		                       		<span class="text-control">Sexe</span>
		                        </div>
		                        <div class="col-md-9 col-sm-10 col-xs-10">
		                        @if($doctor->sex == "h")
		                        	<div class="col-md-6 col-sm-6 col-xs-6">
		                        		Homme&nbsp;&nbsp;<input type="radio" name="homme" checked="" value="homme">
		                        	</div>
		                        	<div class="col-md-6 col-sm-6 col-xs-6">
		                        		Femme&nbsp;&nbsp;<input type="radio" name="homme"  value="femme">
		                        	</div>
		                        @else
		                        	<div class="col-md-6 col-sm-6 col-xs-6">
		                        		Homme&nbsp;&nbsp;<input type="radio" name="homme" value="homme">
		                        	</div>
		                        	<div class="col-md-6 col-sm-6 col-xs-6">
		                        		Femme&nbsp;&nbsp;<input type="radio" name="homme" checked="" value="femme">
		                        	</div>
		                        @endif
		                        	
		                        </div>
		                        <div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-3 col-xs-3">
		                       		<span class="text-control">Date de naissance</span>
		                        </div>
		                        <div class="col-md-9 col-sm-9 col-xs-9">
		                        	<div class="form-group">
		                        		<input type="text" name="dateofbirth" class="form-control" value="{{$doctor->birthdate}}" placeholder="JJ-MM-AAAA" id="dateofbirth">
		                        		<span class="dateerror"></span>
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-3 col-xs-3">
		                       		<span class="text-control">Fonction / Titre</span>
		                        </div>
		                        <div class="col-md-9 col-sm-9 col-xs-9">
		                        	<div class="form-group">
		                        		<input type="text" name="fonction" class="form-control" value="{{$doctor->title}}">
		                        	</div>
		                        </div>
		                        <div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-3 col-xs-3">
		                       		<span class="text-control">Smartphone</span>
		                        </div>
		                        <div class="col-md-9 col-sm-9 col-xs-9">
		                        	@if($arr_smart[0] == "1")
			                        	<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="1000" checked=""> iPhone
			                        	</div>
	                        		@else
		                        		<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="1000"> iPhone
			                        	</div>
	                        		@endif
	                        		@if($arr_smart[1] == "1")
			                        	<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="0100" checked=""> Android
			                        	</div>
		                        	@else
		                        		<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="0100"> Android
			                        	</div>
		                        	@endif
		                        	@if($arr_smart[2] == "1")
			                        	<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="0010" checked=""> Windows
			                        	</div>
		                        	@else
			                        	<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="0010"> Windows
			                        	</div>
		                        	@endif
		                        	@if($arr_smart[3] == "1")
			                        	<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="0001" checked=""> Blackberry
			                        	</div>
		                        	@else
		                        		<div class="col-md-3 col-sm-12 col-xs-12">
			                        		<input type="checkbox" name="chkphone[]" value="0001"> Blackberry
			                        	</div>
		                        	@endif

		                        </div>

		                        <div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-3 col-xs-3">
		                       		<span class="text-control">Tablette</span>
		                        </div>
		                        <div class="col-md-9 col-sm-9 col-xs-9">	                        
		                        	<div class="col-md-3 col-sm-12 col-xs-12">
		                        		@if($arr_tablete[0] == "1")
		                        			<input type="checkbox" name="tablette[]" value="100" checked=""> iPad
		                        		@else
		                        			<input type="checkbox" name="tablette[]" value="100"> iPad
		                        		@endif
		                        	</div>
		                        	<div class="col-md-4 col-sm-12 col-xs-12">
		                        		@if($arr_tablete[1] == "1")
		                        			<input type="checkbox" name="tablette[]" value="010" checked=""> Galaxy Note
		                        		@else
		                        			<input type="checkbox" name="tablette[]" value="010"> Galaxy Note

		                        		@endif
		                        	</div>
		                        	<div class="col-md-3 col-sm-12 col-xs-12">
		                        		@if($arr_tablete[2] == "1")
		                        			<input type="checkbox" name="tablette[]" value="001" checked=""> Surface
		                        		@else
		                        			<input type="checkbox" name="tablette[]" value="001"> Surface	                        			

		                        		@endif
		                        	</div>
		                        	<div class="col-md-2"></div>
		                        </div>
		                        <div class="clear">&nbsp;</div>
		                        <div class="col-md-3 col-sm-12 col-xs-12">
		                        	<button type="submit" class="btn btn-primary valider-btn custombtn">Valider</button>
		                        </div>
		                        <div class="col-md-9">
		                        	
		                        </div>
		                    </form>
	                		</div>
                		<div class="col-md-2 col-sm-12 col-xs-12">
                		</div>
	                	
	                </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- /#page-content-wrapper -->

    <!-- </div>
 -->
     <!-- Modal forget pwd -->
  <div class="modal fade" id="forgetpwd" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
	        <div class="modal-header header-pwd">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-pwd">Modifier mot de passe</h4>
	        </div>        
	        <div class="modal-body">  
	        	<form method="post" action="{!! action('ConfigurationController@lostpassword') !!}">
            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		        	<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		        	<div class="col-md-4 col-sm-12 col-xs-12">
		        		 <span class="text-control">Nouveau mot de passe</span>
		        	</div>
		        	<div class="col-md-5 col-sm-12 col-xs-12">
		        		<input type="password" name="newpwd" placeholder="Nouveau mot de passe" class="form-control">
		        		<input type="hidden" name="doctorid" value="{{$doctor->id}}">
		        	</div>
		        	<div class="col-md-3"></div> 
		        	<div class="col-md-12 col-sm-12 col-xs-12"></div> 
		        	<div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          <button type="submit" class="btn btn-primary custombtn">Valider</button>
			        </div>  
			    </form>     
	        </div> 
      </div>
      
    </div>
  </div>

@endsection

@section('js')
@parent
 <script>
    // $("#menu-toggle").click(function(e) {
    //     e.preventDefault();
    //     $("#wrapper").toggleClass("toggled");
    // });
</script>
 <script type="text/javascript">
    $(document).ready(function(){
        $("#input-4").fileinput({
        	showCaption: false,
        	language: 'fr'
        	//uploadUrl : "{!! action('ConfigurationController@uploadFile') !!}"
        });

        $("#dateofbirth").on("change",function(){
	  	var date_value = $(this).val();
	  	var pattern =/^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
   		var testDate = pattern.test(date_value);
   		if (testDate == true) {
   			$(".valider-btn").prop('disabled', false);
   			$(".dateerror").text("");
   		}
   		else{
   			$(".dateerror").text("invalide date format.").css("color","red");
   			$(".valider-btn").prop('disabled', true);
   		}
	  });


    });

 </script>
@stop
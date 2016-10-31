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
			<div class="col-md-12 col-xs-12 col-sm-12 nopadding mobile-form">
				<div class="col-md-12 col-xs-12 col-sm-12 notification-cancel mobile-form">
					<div class="alert alert-success col-xs-12 col-sm-12">
		        		Le rendez-vous a été annulé avec succès !
		        	</div>
				</div>
				<div class="col-md-12 col-xs-12 col-sm-12 mobile-form">
					<div class="alert alert-info">
		        		<span class="glyphicon glyphicon-calendar"></span> Mes rendez-vous à venir
		        	</div>
				</div>
				{!! $rdv_info !!}
				<div class="col-md-12 col-xs-12 col-sm-12 margintop mobile-form">
					<div class="alert alert-warning">
		        		<span class="glyphicon glyphicon-calendar"></span> Mes rendez-vous passés
		        	</div>
				</div>

				{!! $rdv_pass !!}
			</div>
		</div>
	</div>
@endsection

@section('js')
@parent
<script type="text/javascript">
	$(document).ready(function(){
		$(".notification-cancel").hide();
		$(".cancel").on("click",function(){
			var aid = $(this).data("aid");
			var dataDate = $(this).data("date");
			var did = $(this).data("did");
		//	alert(dataDate);
			$(".notification-cancel").hide();
			cancelMetting(aid,dataDate,did);

		});
		function cancelMetting(id,dataDate,did) {
		    if (confirm("Êtes-vous sûr(e) de vouloir annuler ce rendez-vous ?")) {
		    	// alert(id);
		         	//case absence
		         	$.ajax({		 	
			           url: "{!! action('UserController@cancelMetting') !!}",
					   type: "get",
					   data: "aid="+id+"&date="+dataDate+"&did="+did,
					   success:function(response){
					   		if (response == 1) {
					   			$(".notification-cancel").show();
					   			$(".removemetting"+id).fadeOut();
					   		} 
					   }
					});

		    }
		    return false;
		}
	});
</script>
@stop
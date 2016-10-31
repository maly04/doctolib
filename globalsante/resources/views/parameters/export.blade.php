 @extends("layout")

@section("content")
<div id="wrapper">
	<!-- Sidebar -->      
        @extends('parameters.sidebar')
    <!-- /#sidebar-wrapper -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
        	<div class="col-md-12 col-xs-12 col-sm-12">
        		<div class="alert alert-warning">
        			Pour exporter votre base patients et votre agenda, veuillez contacter le <a data-toggle="modal" data-target="#modalExport" style="cursor:pointer;">service praticien</a>.
        		</div>
        	</div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalExport" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
	        <div class="modal-header header-pwd">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-pwd">Contacter le service praticien de Global Santé</h4>
	        </div>        
	        <div class="modal-body"> 
	        	<p>Une question sur l'utilisation de Global Santé ?</p> 
	        	<p><a href="#">Accéder au guide d'utilisation </a>( <a href="#"> gérer vos horaires d'ouvertures, votre agenda sur smartphone, ...</a>)</p>
	        	<form method="post" action="#">
	        		<div class="col-md-12 col-xs-12 col-sm-12">
	        			<p>Envoyez-nous un message.</p>
	        		</div>
	        		<div class="col-md-12 col-xs-12 col-sm-12">
	        			<textarea class="form-control" rows="5" placeholder="En quelques mots ..." name="message"></textarea>
	        		</div>
	        		<div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
	        		<div class="col-md-12 col-xs-12 col-sm-12">
	        			<span class="text-muted">Nous vous répondrons par email (songebleu@gmail.com) ou téléphone (06 61 20 08 65).</span>
	        		</div>
	        		<div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
	        		<div class="col-md-12 col-xs-12 col-sm-12">
	        			<p>
	        				Vous pouvez aussi nous appeler au 01 83 355 356 (appel gratuit depuis un poste fixe)
ou nous envoyer un email à pro@doctolib.fr.
	        			</p>
	        			<p>Nous travaillons pour vous simpliﬁer le quotidien et espérons que vous aimez notre service.</p>
	        		</div>
	        		<div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          <button type="submit" class="btn btn-primary">ENVOYER</button>
			        </div> 
	        	</form>
   
	        </div> 
      </div>
      
    </div>
  </div>
@endsection

@section('js')
@parent
@stop
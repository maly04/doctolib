@extends("layout")

@section("content")
<div id="wrapper">
  <!-- Sidebar -->
    @extends('parameters.sidebar')
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
            	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
            	  <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Déclenchement</th>
                                <th>Motifs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                   Documents à ne pas oublier
                                </td>
                                <td>
                                    Confirmation de RDV                                        
                                </td>
                                <td>
                                    Blessure sportive, Lombalgie (Douleur aux reins), Douleur à la cheville, Douleur au dos, Douleur à l'épaule, Douleur à la main / poignet, Sciatique, Kinésithérapie respiratoire et Drainage lymphatique
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>   
                  </div>
            	</div>
                <div class="col-md-4 col-sm-12 col-xs-12 nopadding">
                    <button type="submit" class="btn btn-warning">Créer une nouvelle règle</button>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12 nopadding">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>

   

@endsection

@section('js')
@parent

@stop
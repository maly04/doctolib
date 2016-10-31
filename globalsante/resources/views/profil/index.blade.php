@extends("layout")

@section("content")
<div id="wrapper">
      <!-- Sidebar -->   
     @extends('profil.sidebar')
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
           <form method="post" action="{!! action('ProfilGlobalSanteController@submitMoyens') !!}" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row ">         
                  <p><b>Moyens de paiement</b></p>
                	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                    
                         <div class=" col-md-2 nopadding">
                                <span class=""><input type="checkbox" name="checkbox[]" value="1"
                                <?php 
                                foreach ($md as $mds) {
                                   if ($mds->tbl_moyen_id == 1) echo "checked='checked'"; 
                                }                               
                                ?>
                                > Espèces</span>
                            </div>
                    <div class=" col-md-2 nopadding">
                        
                        <span class=""><input type="checkbox" name="checkbox[]" value="2"
                            <?php 
                                foreach ($md as $mds) {
                                   if ($mds->tbl_moyen_id == 2) echo "checked='checked'"; 
                                }                               
                                ?>
                        > Chèques</span>
                    </div>
                    <div class="  col-md-2 nopadding">                    
                        <span class=""><input type="checkbox" name="checkbox[]" value="3"
                                <?php 
                                    foreach ($md as $mds) 
                                    {
                                        if ($mds->tbl_moyen_id == 3) echo "checked='checked'"; 
                                    }                             
                                ?>
                        > Carte bancaire</span>
                    </div>       
                        </div>
                        </div>
                    <div class="row ">
                     <p class="carte_style"><b>Carte Vitale</b></p>
                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                            <div class="col-md-2 nopadding">
                                <span class=""><input type="checkbox" name="checkbox[]"  value="4"
                                    <?php 
                                    foreach ($md as $mds) 
                                    {
                                        if ($mds->tbl_moyen_id == 4) echo "checked='checked'"; 
                                    }                             
                                    ?>
                                > Carte Vitale</span>
                            </div>
                        </div>
                    <div class="col-md-2 nopadding btn_ckb_save">
                        <button type="submit" class="btn btn-info" name="Moyens">Enregistrer</button>
                    </div>
                    </div>
      
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
@parent
@stop

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
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        @if($msg)
                          <div class=" col-md-12 alert alert-success">
                            {{$msg}}
                          </div>
                        @endif
                        <form action="{!! action('ParametersController@submitimport') !!}" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <span class="text-control">Type de données</span>
                          </div>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                            <select class="form-control" required name="type">
                              <option>Données de patients</option>
                              <option>Historique de RDV</option>
                            </select>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <span class="text-control">Fichier</span>
                          </div>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                            <input type="file" name="import" class="form-control" required>
                          </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>                          
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <span class="text-control">Commentaires</span>
                          </div>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                              <textarea name="comment" placeholder="Ex: nom et version de progiciel" class="form-control"></textarea>
                          </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                           <div class="col-md-4 col-sm-12 col-xs-12"><button type="submit" class="btn btn-warning">Importer le fichier</button> </div>
                           <div class="col-md-8 col-sm-12 col-xs-12">&nbsp;</div>
                        </form>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                          <h2>Liste des fichiers envoyés</h2>
                          <div class="responsive-table">
                              <table class="table">
                                  <thead>
                                    <tr>
                                      <td>Date et statut</td>
                                      <td>Nom du fichier</td>
                                      <td>Type d'import</td>                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($imports as $import)
                                      <tr>
                                          <td>{{$import->date}}</td>
                                          <td>{{$import->file_name}}</td>
                                          <td>{{$import->type}}</td>
                                      </tr>
                                      <tr class="oadd">
                                          <td>{{$import->status}}</td>
                                          <td colspan="2">
                                            @if($import->status == "Importé")
                                            <span class="alert alert-success">{{$import->count}} patients importés.</span>                                            
                                            @endif
                                          </td>
                                      </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                          </div>
                          
                      </div>
                  </div>
                </div>
            </div>

    </div>

   

@endsection

@section('js')
@parent
@stop
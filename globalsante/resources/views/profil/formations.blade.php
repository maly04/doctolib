@extends("layout")

@section("content")
<div id="wrapper">
      <!-- Sidebar -->   
     @extends('profil.sidebar')
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-hover able-reflow oitable">
                            <thead>
                                <tr>
                                   <th>ID</th>
                                   <th>Formations</th>
                                   <th>Action</th> 
                                </tr>                            
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($oi as $info)

                                <tr id="tr{{$info->id}}">
                                   <td><?php echo $i; ?></td>
                                   <td><input type="text" name="oi" value="{{$info->info}}" class="oi oitextbox" data-oi="{{$info->id}}"></td> 
                                   <td><a  class="supprimmer setCustor" style="color:red;" data-oi="{{$info->id}}"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"></div>
            	<div class="col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{!! action('ProfilGlobalSanteController@submitFormation') !!}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <label>Formation</label>
                        </div> 
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <input type="text" name="formations" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <button class="btn btn-primary custombtn">Enregistrer</button>
                        </div>
                        <div class="col-md-5 col-sm-12 col-xs-12"></div>
                    </form>
                </div>
                 
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@parent
<script type="text/javascript">
    $(document).ready(function(){
        //delete patient
      $(".supprimmer").on("click",function(){
            var oi = $(this).data("oi");
            // alert(oi);
            deleteItem(oi);
      });
      function deleteItem(oi) {
        if (confirm("vous voulez supprimer?")) {
            $.ajax({            
               url: "{!! action('ProfilGlobalSanteController@deleteoi') !!}",
               type: "get",
               data: "oi="+oi,
               success:function(response){
                    $("#tr"+oi).fadeOut();
               }
            });
        }
        return false;
      }
      //update
      $(".oitextbox").on("change",function(){
          var id = $(this).data("oi");
          var text = $(this).val();
          $.ajax({            
               url: "{!! action('ProfilGlobalSanteController@editoi') !!}",
               type: "get",
               data: "oi="+id+"&text="+text,
               success:function(response){
                    // $("#tr"+oi).fadeOut();
               }
            });
      });
      
    });
</script>
@stop

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
              <input type="hidden" value="{{$doctorid}}" id="doctorid">
            	    <div class="col-md-2 col-sm-12 col-xs-12 nopadding">
                      <span class="text-control">Durée d’un créneau</span>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12 nopadding">
                        <select class="form-control" name="un_duration" id="duration">
                           <option value="10" <?php if ($duration == "10") {echo 'selected="selected"';}else{echo "";} ?>>10mn</option>
                          <option value="15" <?php if ($duration == "15") {echo 'selected="selected"';}else{echo "";} ?>>15mn</option>
                          <option value="30" <?php if ($duration == "30") {echo 'selected="selected"';}else{echo "";} ?>>30mn</option>
                          <option value="45" <?php if ($duration == "45") {echo 'selected="selected"';}else{echo "";} ?>>45mn</option>
                          <option value="60" <?php if ($duration == "60") {echo 'selected="selected"';}else{echo "";} ?>>60mn</option>
                        </select>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12 nopadding"></div>
            	</div>
              <div class="col-md-12 col-sm-12 col-xs-12 nopadding margintop">
                  <a class="btn custombtn btn-primary" href="<?php echo URL::to('/agenda'); ?>">Accéder à votre agenda</a>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12 nopadding">&nbsp;</div>
              <div class="col-md-12 col-sm-12 col-xs-12 nopadding"><label>Horaires de travail</label></div>
              <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="table-responsive">
                    <table class="table table-bordered agenda-table table-hover">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Lundi</th>
                          <th>Mardi</th>
                          <th>Mercredi</th>
                          <th>Jeudi</th>
                          <th>Vendredi</th>
                          <th>Samedi</th>
                          <th>Dimanche</th>
                        </tr>
                      </thead>
                      <tbody>                    
                        {!! $openingTime !!}
                      </tbody>
                      
                    </table>
                </div>              
              </div>
            </div>
           
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>

  

@endsection

@section('js')
@parent
<script type="text/javascript">
  $(document).ready(function(){
    // check on check box
      $(".agenda-chk").on("change",function(){
           var day = $(this).data("day");    
           var aid = $(this).data("aid");   
          if (this.checked) {
            $(".agenda-table tr td input."+day).show();
            var chk = 1;
             var data = "chk="+chk+"&aid="+aid;
              $.ajax({      
                 url: "{!! action('ParametersController@updatecheckDay') !!}",
                 type: "get",
                 data: data,
                 success:function(response){ 
                 }
              });
          }
          else{
            $(".agenda-table tr td input."+day).hide();
             var chk = 0;
             var data = "chk="+chk+"&aid="+aid;
              $.ajax({      
                 url: "{!! action('ParametersController@updatecheckDay') !!}",
                 type: "get",
                 data: data,
                 success:function(response){ 
                 }
              });
            }
      });

    $(".agenda-table").find(".agenda-chk").each(function(){
         var day = $(this).data("day");         
        if ($(this).prop('checked')==true){          
           $(".agenda-table tr td input."+day).show();      
        }
        else{
           $(".agenda-table tr td input."+day).hide();  
        }
    });

    // action on change time
    $(".inputtime").on("change",function(){
        var time = $(this).val();
        var checkTime = checkValidTime(time);
        var attr_start = $(this).attr('data-start');
        var aid = $(this).data("aid");
        var dateType ="";
        var dayType = "";
        //has attribute data-start or not
        if (typeof attr_start !== typeof undefined && attr_start !== false) {
              //in case has datastart
              dateType = "start";
              dayType = $(this).data("start"); 
        }
        else{
          // in case has data-end
           dateType = "end";
           dayType = $(this).data("end");
        }
        var data = "dateType="+dateType+"&dayType="+dayType+"&time="+time+"&aid="+aid;
        if (checkTime == true) {
           // calling ajax
            $.ajax({      
               url: "{!! action('ParametersController@updateOpeningTime') !!}",
               type: "get",
               data: data,
               success:function(response){ 
               }
            });

        }
        else{
          alert("please input correct time.");
        }

    });
   $(".agenda-table tr").hover(function(){
      $(".inputtime").css("background","#f5f5f5");
   });
    $("#duration").on("change",function(e){
        var did = $("#doctorid").val();
        var duration = $(this).val();
        $.ajax({      
             url: "{!! action('ParametersController@updateduration') !!}",
             type: "get",
             data: "did="+did+"&duration="+duration,
             success:function(response){ 
             }
          });
     });
  });
</script>
@stop
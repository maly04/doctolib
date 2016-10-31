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
            	  <ul id = "myTab" class = "nav nav-tabs">
                      <?php $i = 1;?>
                      @foreach($hospital as $hos)
                        <?php if ($i == 1) {?>
                         
                            <li class = "active">
                              <a href = "#address{{$hos->hid}}" data-toggle = "tab">
                               {{$hos->hname}}
                              </a><span data = "{{$hos->hid}}" class="confirmDelete"><i class="fa fa-times" aria-hidden="true"></i>
</span>
                            </li> 
                        <?php }else{?>
                              
                                <li>
                                  <a href = "#address{{$hos->hid}}" data-toggle = "tab" class="tab{{$hos->hid}}">
                                   {{$hos->hname}}
                                  </a><span data = "{{$hos->hid}}" class="confirmDelete"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </li> 
                            

                        <?php }?>
                         <?php $i++;?>
                      
                       @endforeach 
                       <li>
                         <a href="#" class="add"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un lieu de consultation</a>
                       </li>                        
                                                 
                </ul>
                <div id = "myTabContent" class = "tab-content">
                    <?php 
                       $i = 1;
                      
                    ?>
                    @foreach($hospital as $hos)
                        <?php 
                           $chaccess1 = "";
                           $chaccess2 = "";
                           $chaccess3 = "";
                           if (!empty($hos->accessibility)) {
                             $chaccess = str_split($hos->accessibility);
                              if ($chaccess[0] == 1) {
                                 $chaccess1 = "checked";
                              }
                              if ($chaccess[1] == 1) {
                                 $chaccess2 = "checked";
                              }
                              if ($chaccess[2] == 1) {
                                 $chaccess3 = "checked";
                              }
                           }
                          
                        ?>
                        <?php if ($i == 1) {?>
                           <div class = "tab-pane fade in active" id = "address{{$hos->hid}}">
                              <form method="post" action="{!! action('ParametersController@submitextrafield') !!}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                  <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label>Adresse</label>
                                    <div class="form-group form-group-responsive">
                                        <input type="text" class="form-control" value="{{$hos->hname}}" name="hopital" placeholder="Nom de l'établissement (optionnel, apparaît sur le profil web et dans les emails de rappel)" required=required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adresse" value="{{$hos->haddress}}" id="adresse{{$hos->hid}}" placeholder="adresse de l\'hospital" required=required>
                                         <input id="address-container" type="hidden" name="address-conainer"/>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
                                        <input type="hidden" name="hid" value="{{$hos->hid}}">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                          <span><b>Informations pratiques publiques</b></span>
                                        </div>
                                        <div class="col-md-3 col-xs-12 col-sm-12 nopadding"><span class="text-control">Numéro du cabinet</span></div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="text" name="phone" class="form-control" value="{{$hos->ncabinet}}"></div>
                                        <div class="col-md-1 col-xs-12 col-sm-12"><span class="text-control">Fax</span></div>
                                        <div class="col-md-2 col-xs-12 col-sm-12"> <input type="text" name="fax" class="form-control" value="{{$hos->fax}}"></div>
                                        <div class="col-md-3 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12">Accessibilité</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="100" <?php echo $chaccess1;?>> Ascenseur</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="010" <?php echo $chaccess2;?>> Accès handicapé</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="001" <?php echo $chaccess3;?>> Étage</div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                          <span><b>Informations pratiques confidentielles</b></span>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Interphone</div>
                                            <div class="col-md-12 col-xs-12 col-sm-9 nopadding">
                                              <input type="text" name="nom" placeholder="Nom" class="form-control" value="{{$hos->interphone}}">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Digicode</div>
                                            <div class="col-md-12 col-xs-12 col-sm-9 nopadding">
                                              <input type="text" name="code" placeholder="Code" class="form-control" value="{{$hos->digicode1}}">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Digicode 2</div>
                                            <div class="col-md-12 col-xs-12 col-sm-9 nopadding">
                                              <input type="text" name="code2" placeholder="Code" class="form-control" value="{{$hos->digicode2}}">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-3 col-xs-12 col-sm-12 nopadding"><button class="btn btn-primary custombtn">Valider</button></div>
                                            <div class="col-md-9 col-xs-12 col-sm-12">&nbsp;</div>

                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                              <span><b>Informations pratiques confidentielles</b></span>
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                              <textarea class="form-control" placeholder="Numéro du bâtiment, escalier..." name="number_depart">{{$hos->number_depart}}</textarea>
                                            </div>
                                        </div>
                                  </div>
                                  
                                  <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                 </form>
                           </div>
                      <?php }else{?>

                              <div class = "tab-pane fade in" id = "address{{$hos->hid}}">
                                <form method="post" action="{!! action('ParametersController@submitextrafield') !!}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                    <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                    <label>Adresse</label>
                                    <div class="form-group form-group-responsive">
                                        <input type="text" class="form-control" value="{{$hos->hname}}" name="hopital" placeholder="Nom de l'établissement (optionnel, apparaît sur le profil web et dans les emails de rappel)" required=required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adresse" value="{{$hos->haddress}}" id="adresse{{$hos->hid}}" placeholder="adresse de l\'hospital" required=required>
                                        <input id="address-container" type="hidden" name="address-conainer"/>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
                                     
                                        <input type="hidden" name="hid" value="{{$hos->hid}}">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                          <span><b>Informations pratiques publiques</b></span>
                                        </div>
                                        <div class="col-md-3 col-xs-12 col-sm-12">Numéro du cabinet</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="text" name="phone" class="form-control" value="{{$hos->ncabinet}}"></div>
                                        <div class="col-md-1 col-xs-12 col-sm-12"><span class="text-control">Fax :</span></div>
                                        <div class="col-md-2 col-xs-12 col-sm-12"> <input type="text" name="fax" class="form-control" value="{{$hos->fax}}"></div>
                                        <div class="col-md-3 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12">Accessibilité</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="100" <?php echo $chaccess1;?>> Ascenseur</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="010" <?php echo $chaccess2;?>> Accès handicapé</div>
                                        <div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="001" <?php echo $chaccess3;?>> Étage</div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                          <span><b>Informations pratiques confidentielles</b></span>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Interphone</div>
                                            <div class="col-md-12 col-xs-12 col-sm-9 nopadding">
                                              <input type="text" name="nom" placeholder="Nom" class="form-control" value="{{$hos->interphone}}">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Digicode</div>
                                            <div class="col-md-12 col-xs-12 col-sm-9 nopadding">
                                              <input type="text" name="code" placeholder="Code" class="form-control" value="{{$hos->digicode1}}">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Digicode 2</div>
                                            <div class="col-md-12 col-xs-12 col-sm-9 nopadding">
                                              <input type="text" name="code2" placeholder="Code" class="form-control" value="{{$hos->digicode2}}">
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-3 col-xs-12 col-sm-12 nopadding"><button class="btn btn-primary custombtn" type="submit">Valider</button></div>
                                            <div class="col-md-9 col-xs-12 col-sm-12">&nbsp;</div>

                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                              <span><b>Informations pratiques confidentielles</b></span>
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                              <textarea class="form-control" placeholder="Numéro du bâtiment, escalier..." name="number_depart">{{$hos->number_depart}}</textarea>
                                            </div>
                                        </div>
                                     
                                  </div>
                                  <div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                                 </form>
                            </div>
                      <?php }?>
                      @section('js')
                      @parent
                      <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script> -->
                    
                      <script type="text/javascript">
                        /* Adresses autocomplete script */
                        var options_lieu{{$hos->hid}} = {
                           types: ['geocode'],
                           componentRestrictions: {country: 'fr'}
                        };
                        
                        var input_lieu{{$hos->hid}} = document.getElementById('adresse{{$hos->hid}}');
                        autocomplete_lieu{{$hos->hid}} = new google.maps.places.Autocomplete(input_lieu{{$hos->hid}}, options_lieu{{$hos->hid}});

                        /* Event listener on change of autocomplete input */
                        google.maps.event.addListener(autocomplete_lieu{{$hos->hid}}, 'place_changed', function() {
                            var address = document.getElementById('address-container').value = document.getElementById('adresse{{$hos->hid}}').value;
                          });

                        </script>
                    @stop
                     <?php $i++;?>
                   @endforeach                      
                                            
                </div> <!-- ending tab --> 
            	</div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>

  

@endsection

@section('js')
@parent
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places&key=AIzaSyC84KsXF2L7FdRrMEyOKXkmFd8SpX3wCro"></script>
 <script type="text/javascript">
    

    $(document).ready(function(){       


        $("#input-4").fileinput({
        	showCaption: false,
        	language: 'fr'
        	//uploadUrl : "{!! action('ConfigurationController@uploadFile') !!}"
        });

        $('#tabs').tab();

        $(".nav-tabs").on("click", "a", function (e) {
            e.preventDefault();
            if (!$(this).hasClass('add')) {
                $(this).tab('show');
            }
        })
        .on("click", "span.newtab", function (e) {
            var hid = $(this).data("hid");
            var anchor = $(this).siblings('a');
            $(anchor.attr('href')).remove();
            $(this).parent().remove();
            $(".nav-tabs li").children('a').first().click();     
        });

        $(".confirmDelete").bootstrap_confirm_delete(
        {
            callback: function( event )
            {
              // console.log(event);
              var getid = event.data.originalObject.context.attributes[0];
              var id = getid.nodeValue;
              var anchor = $(".confirmDelete").siblings('a.tab'+id);      
              // alert(id);         
                $.ajax({                            
                   url: "{!! action('ParametersController@supprimerHospital') !!}",
                   type: "get",
                   data: "hid="+id,
                   success:function(response){                   
                        $(anchor.attr('href')).remove();
                        $(".confirmDelete").parent().find(".tab"+id).remove();
                        $(".nav-tabs li").children('a').first().click();
                    }

                });

            }
        }
    );
       
        $(".hide-worning").hide();
        // $("#formaddhospital").on("submit",function(event){          
        //     event.preventDefault();
        //     alert(12);
        //    $(".hide-worning").hide();
        //     if ($(".hospital").val() != "" && $(".adresse").val() != "") {
        //         var fd = new FormData(document.getElementById("formaddhospital"));
        //         $.ajax({
        //             url      : "{!! action('ParametersController@submitHospital') !!}",
        //             type     : "POST",
        //             data     : fd,
        //             processData: false,  // tell jQuery not to process the data
        //             contentType: false,// tell jQuery not to set contentType
        //             success  : function(response) { 
        //               if (response == 1) {                 
        //                 window.location.replace("{{ url('lieu_consultation') }}");
        //               }
        //               if (response == 2) {
        //                 window.location.replace("{{ url('login') }}");
        //               }
        //               if (response == 0) {
        //                 $(".hide-worning").show();
        //               }
        //             }
        //         }); 
        //     }
            
            
        // });

    

        $('.add').click(function (e) {
          e.preventDefault();
          var id = $(".nav-tabs").children().length; //think about it ;)
          var tabId = 'address' + id;





          $(this).closest('li').before('<li><a href="#address' + id + '">Ajouter un lieu de consultation</a> <span class="newtab"> <i class="fa fa-times" aria-hidden="true"></i> </span></li>');
          $('.tab-content').append('<div class="tab-pane fade in" id="' + tabId + '"> <form id="formaddhospital" class="form-horizontal" method="post"><input type="hidden" name="_token" value="{{ csrf_token() }}"><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-12 alert alert-warning hide-worning">Les données non sauvegardées</div><div class="col-md-12 col-xs-12 col-sm-12"><label>Adresse</label><div class="col-md-12 col-xs-12 col-sm-12"><div class="form-group"> <input type="text" class="form-control hopital"  name="hopital" placeholder="Nom de l\'établissement (optionnel, apparaît sur le profil web et dans les emails de rappel)" required="required"></span></div></div><div class="col-md-12 col-xs-12 col-sm-12"><div class="form-group"><input type="text" placeholder="adresse de l\'hospital"  name="adresse"  class="form-control adresse" id="adresse_lieu"><input id="address-container" type="hidden" name="address-conainer"/></div></div></div><div class="col-md-12 col-xs-12 col-sm-12 nopadding"><div class="col-md-12 col-xs-12 col-sm-12"> <span><b>Informations pratiques publiques</b></span></div><div class="col-md-3 col-xs-12 col-sm-12">Numéro du cabinet</div><div class="col-md-3 col-xs-12 col-sm-12"><input type="text" name="phone" class="form-control"></div><div class="col-md-1 col-xs-12 col-sm-12"><span class="text-control">Fax :</span></div><div class="col-md-2 col-xs-12 col-sm-12"> <input type="text" name="fax" class="form-control"></div><div class="col-md-3 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-3 col-xs-12 col-sm-12">Accessibilité</div><div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="100" > Ascenseur</div><div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="010" > Accès handicapé</div><div class="col-md-3 col-xs-12 col-sm-12"><input type="checkbox" name="access[]" value="001" > Étage</div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-12 col-xs-12 col-sm-12"><span><b>Informations pratiques confidentielles</b></span></div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-6 col-xs-12 col-sm-12"><div class="col-md-12 col-xs-12 col-sm-3 nopadding">Interphone</div><div class="col-md-12 col-xs-12 col-sm-9 nopadding"><input type="text" name="nom" placeholder="Nom" class="form-control"> </div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-12 col-xs-12 col-sm-3 nopadding">Digicode</div><div class="col-md-12 col-xs-12 col-sm-9 nopadding"><input type="text" name="code" placeholder="Code" class="form-control"></div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div> <div class="col-md-12 col-xs-12 col-sm-3 nopadding">Digicode 2</div> <div class="col-md-12 col-xs-12 col-sm-9 nopadding"> <input type="text" name="code2" placeholder="Code" class="form-control"></div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-3 col-xs-12 col-sm-12 nopadding"><button class="btn btn-primary custombtn" type="submit">Valider</button></div><div class="col-md-9 col-xs-12 col-sm-12">&nbsp;</div></div><div class="col-md-6 col-xs-12 col-sm-12"><div class="col-md-12 col-xs-12 col-sm-12"> <span><b>Informations pratiques confidentielles</b></span></div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div><div class="col-md-12 col-xs-12 col-sm-12"> <textarea class="form-control" placeholder="Numéro du bâtiment, escalier..." name="number_depart"></textarea> </div></div></div><div class="col-md-12 col-xs-12 col-sm-12">&nbsp;</div></form></div>');
           var options_lieu = {
               types: ["geocode"],
               componentRestrictions: {country: "fr"}
            };  

            var input_lieu = document.getElementById("adresse_lieu");
            
            autocomplete_lieu = new google.maps.places.Autocomplete(input_lieu, options_lieu);
           // console.log(autocomplete_lieu); 
            /* Event listener on change of autocomplete input */
            google.maps.event.addListener(autocomplete_lieu, "place_changed", function() {
                //alert(1);
                var address = document.getElementById("address-container").value = document.getElementById("adresse_lieu").value;
            });
         $(".hide-worning").hide();
         $('.nav-tabs li:nth-child(' + id + ') a').click();
        });

        
    });

   /* Adresses autocomplete script */


 </script>




 

@stop
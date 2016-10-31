@extends("layout")

@section("content") 

      <div class="row customrow"> 
            <h1>Prenez rendez-vous en ligne chez un médecin ou un dentiste</h1>
            <h4>C’est immédiat, simple et gratuit</h4>           
           
                <div class="col-md-3 col-xs-12 col-sm-12 nopadding custom-select"> 
                    <div class="form-group form-group-mobile">
                      <input type="text"  class="form-control custom-form-control"  id="name" name = "doctor" placeholder="Médecin...">
                     
                    </div> 
                                     
                </div>
                <div class="col-md-9 col-xs-12 col-sm-12 nopadding">
                  <form method="post" action="{!! action('FrontendController@search') !!}" novalidate="novalidate" id="searchform">
                    <div class="col-md-5 col-xs-12 col-sm-12 nopadding">
                        <span class="badge-custom btn-circle-ou">Ou</span>
                      
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                        @if($errors->has('form-control-spe'))
                            <div class="form-group haserror form-group-mobile">
                          @else
                            <div class="form-group form-group-mobile">
                          @endif                   
                          <select class="form-control custom-form-control form-control-spe" id="form-control-spe" name="form-control-spe">
                               <option value=""></option>
                               @foreach($spe as $spec)
                                <option value="{{$spec->id}}">{{$spec->name}}</option>
                              @endforeach
                          </select>
                          </div>
                      </div>
                    <div class="col-md-5 col-xs-12 col-sm-12 nopadding">                   
                         @if($errors->has('ville'))
                            <div class="form-group haserror form-group-mobile">
                          @else
                            <div class="form-group form-group-mobile">
                          @endif 
                           <input type="text" name="ville" class="form-control custom-form-control" id="ville" placeholder="Où ? (adresse, ville...)">
                           <input id="address-container" type="hidden" name="address-container"/>
                               
                         <div class="contain-hidden"> 
                           
                         </div>
                         <input type="hidden" name="latlng" id="latlng">
                         <input type="hidden" name="allcity" id="allcity">

                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-12 nopadding form-group-mobile">
                        <button type="submit" class="btn btn-info custom-btn custombtn searchbtn">
                            <span class="glyphicon glyphicon-search"></span>
                            Rechercher
                        </button>
                    </div>
                </form>
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12 nopadding "></div>
              <div class="col-md-12 col-xs-12 col-sm-12 nopaddingleft">
               @if(session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message') }}
                </div>
                @endif
              </div>
      </div>
      
   @endsection

@section('js')
@parent

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places&key=AIzaSyC84KsXF2L7FdRrMEyOKXkmFd8SpX3wCro"></script>
<script type="text/javascript">
        /* Adresses autocomplete script */
        var options = {
           types: ['geocode','establishment'],
           componentRestrictions: {country: 'fr'}
        };
        
        var input = document.getElementById('ville');

        //console.log(input);

        autocomplete = new google.maps.places.Autocomplete(input, options);

        /* Event listener on change of autocomplete input */
                    google.maps.event.addListener(autocomplete, 'place_changed', function() {
                        var address = document.getElementById('address-container').value = document.getElementById('ville').value;
                        var latlng = (autocomplete.getPlace().geometry.location).toString().replace('(','').replace(')','').replace(' ','');
                        document.getElementById('latlng').value = latlng;
                        $(".searchbtn").prop('disabled', true);
                        console.log(latlng);
                        var arr_city = [];
                           $.ajax({
                              url: '{!! action("FrontendController@searchnearby") !!}',                             
                              // dataType: "json",
                              data: "location="+latlng+"&radius=25000&sensor=false&key=AIzaSyAG-DuEfm3XJF0_Zg8Oi7kO2pwirjgg7bg",
                              type: "GET",
                              success: function( data ) {
                                // console.log(data);
                                for(var i in data.results){
                                  arr_city.push(data.results[i].vicinity);
                                  $(".contain-hidden").append('<input type="hidden" name="arr['+i+']" value="'+data.results[i].vicinity+'" />');
                                }
                                $(".searchbtn").prop('disabled', false);
                                 console.log(arr_city);
                              },
                              error: function (request, status, error) {
                                //handle errors
                              }
                            });
                           
                        document.getElementById('address-container').value = address; 

                         geocoder = new google.maps.Geocoder();

                         geocoder.geocode( { 'address': address}, function(results, status) {
                         
                            if (status == google.maps.GeocoderStatus.OK) {
                               
                                for(key in results[0].address_components){
                                    id = results[0].address_components[key].types.indexOf('locality');
                                    if( id >= 0){
                                        var area = results[0].address_components[key].long_name;
                                        // console.log(area);
                                       
                                    }
                                } 

                            } else {
                                alert('unable to successfully reach this adress : ' + status);
                            }
                        });
                    
                    });

</script>
<script type="text/javascript">
   $(document).ready(function(){
      // $("#searchform").on("submit",function(e){
      //     e.preventDefault(); 
      //     var fd = new FormData(document.getElementById("searchform"));
      //       $.ajax({
      //         url      : "{!! action('FrontendController@search') !!}",
      //         type     : "POST", 
      //         data     : fd,
      //         processData: false,  // tell jQuery not to process the data
      //         contentType: false,// tell jQuery not to set contentType
      //         success  : function(response) {   
      //           if (response == "vspe") {
      //             $(".vspe").addClass("haserror");
      //             $(".vville").removeClass("haserror");
      //           }
      //           else if(response == "vville"){
      //             $(".vspe").removeClass("haserror");
      //             $(".vville").addClass("haserror");
      //           }
      //           else{
      //             // var explod = response.split("|");
      //             // var sid = explod[0];
      //             // var ville = explod[1];
      //             // var spid = explod[2];
      //             // var cities = explod[3];
      //             //   $.ajax({                            
      //             //          url: "{!! action('DoctoLibController@searchreult',["+sid+","+ville+","+spid+"]) !!}",
      //             //          type: "get",
      //             //          data: "cities="+cities,
      //             //          success:function(response){
      //             //               //location.reload();
                                
      //             //           }

      //             //   });
                 
      //           }    
      //         }//end success
      //       });
      // });
      //doctor autocomplete
       $("#name").autocomplete({
          source: function( request, response ) {
                $.ajax({
                    url: "{{URL('recherche/doctor')}}",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                      if(!data.length){
                      var result = [
                       {
                       label: 'Aucun résultat.', 
                       value: response.term
                       }
                     ];
                       response(result);
                     }
                     else{
                      response($.map(data, function(obj) {                            
                                return {
                                  label: obj.value,
                                  value: obj.value,
                                  url: obj.url,
                                  id: obj.id 
                                };
                            }));
                     }
                            
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) { 
              console.log(ui);
              window.open("<?php echo URL::to('/details'); ?>/"+ui.item.id+"/"+ui.item.url);
             // $("#hidenvilleid").val(ui.item.id) 
          },
            cache: false

        });   

   });
   
</script> 
@stop
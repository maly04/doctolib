<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- <meta name="google-signin-client_id" content="AIzaSyAhYCgzyemDcPURU_Z8ZwjnCzCyPrQNO9I"> -->
    <title>Global Santé</title>
    @section('css')
    <!-- Referencing Bootstrap CSS that is hosted locally -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/select2.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/mobile.css')}}">  
    <link rel="stylesheet" href="{{asset('css/combo.select.css')}}">       
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.autocomplete.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{asset('css/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/slick-theme.css')}}"/>

    <!-- CSS FOR AGENDA -->
    <link href="{{asset('css/fullcalendar.css')}}" rel='stylesheet' />
    <link href="{{asset('css/fullcalendar.print.css')}}" rel='stylesheet' media='print' />

    <!-- Boostrap calendar -->
    <link href="{{asset('css/bootstrap-datetimepicker.css')}}" rel='stylesheet' />

    <link href="{{asset('css/jquery-clockpicker.min.css')}}" rel='stylesheet' />
    <link href="{{asset('css/bootstrap-clockpicker.min.css')}}" rel='stylesheet' />

    <!-- Color picker -->
    <link href="{{asset('css/bootstrap-colorpicker.min.css')}}" rel='stylesheet' />

    <!-- Date picker -->
    <link href="{{asset('css/jquery-ui.css')}}" rel='stylesheet' />

     <!-- File upload -->
    <link href="{{asset('css/fileinput.min.css')}}" rel='stylesheet' />
    
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">

   <link href="{{asset('css/bootstrap-confirm-delete.css')}}" rel='stylesheet' />
@show
  </head>

  <body>
  <nav class="navbar navbar-default navbar-custom">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo URL::to('/'); ?>">Global Santé</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">         
          <ul class="nav navbar-nav navbar-right custom-navbar-ul">
            <li>
              
              <a href="#" class="menu-lignhight"> Besoin d'aide ?</a>
              
            </li>
            <li>               
                <?php 
                 $userid = Session::get('user-id'); 
                 //echo  "<script>alert(".$userid.");</script>";
                  if (Session::has('user-id')){
                       $userid = Session::get('user-id');

                       $email = Session::get('user-email');
                       if (Session::has('type')) {
                ?>
                   <span>
                    <a href="#"  class="btn dropdown-toggle menu-lignhight" data-toggle="dropdown"><?php echo $email; ?>
                         <span class="caret"></span>
                    </a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to('/account/appointments'); ?>">&nbsp;&nbsp;Mes rendez-vous</a></li>
                          
                            <li class="divider"></li>
                            <li><a href="<?php echo URL::to('/account/profile'); ?>">  &nbsp;&nbsp;Mon profil</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo URL::to('/logout'); ?>">&nbsp;&nbsp;Déconnexion </a></li>
                          </ul>
                </span> 

                <?php
                       }
                       else{
                         
               ?>
                <span>
                    <a href="#"  class="btn dropdown-toggle menu-lignhight" data-toggle="dropdown"><?php echo $email; ?>
                         <span class="caret"></span>
                    </a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to('/parameters/lieu_consultation'); ?>"><span class="glyphicon glyphicon-cog pull-left"></span>&nbsp;&nbsp;Paramètres</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo URL::to('/configuration/patients'); ?>"><span class="glyphicon glyphicon-user pull-left"></span>&nbsp;&nbsp;Patients </a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo URL::to('/profil-global-sante/moyens-de-paiement'); ?>" ><span class="glyphicon glyphicon-globe"></span> Profil Global Santé </a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo URL::to('/configuration/mon-compte'); ?>">  <span class="glyphicon glyphicon-user pull-left"></span>&nbsp;&nbsp;Mon compte</a></li>
                           
                           
                            <li class="divider"></li>
                            <li><a href="#">  <span class="glyphicon glyphicon-duplicate pull-left"></span>&nbsp;&nbsp;Abonnement</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo URL::to('/logout'); ?>"><span class="glyphicon glyphicon-log-out pull-left"></span>&nbsp;&nbsp;Déconnexion </a></li>
                          </ul>
                </span>               
                
               <?php
                  }
                }
                  else{
                    echo "<p class='topmenu'> <a href='".URL::to('/login')."'>MON COMPTE";
                ?>
                </a></p>
               <p class="text-rdv"> <a href="<?php echo URL::to('/login'); ?>">Gérer mes RDV</a></p>
                 
                <?php
                    }
                 
                ?>
                
             
            </li>
            <?php
               if (!Session::has('type')) {
            ?>
            <li>
              
                 <p class="topmenu"><a href="<?php echo URL::to('/login#professionel'); ?>" class="atopmenu"> Professionnel de santé?</a></p>
                 <p class="text-rdv"><a href="<?php echo URL::to('/login#professionel'); ?>" class="atopmenu">Découvrez nos services</a></p>  


            </li>
            <?php }?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
</nav>
    @if (Request::is('/'))
      <div class="container">
    @else
     <div class="container custom-container">
    @endif
        @yield('content')
    </div>
    @section('js')
 <!-- <script src="http://code.jquery.com/jquery-1.9.0.js"></script> -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
    <!-- <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script> -->
   <script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>
   <script src="{{asset('js/bootstrap.min.js')}}"></script>

   <script type="text/javascript" src="{{asset('js/jquery.autocomplete.js')}}"></script>
   <script src="{{asset('js/select2.min.js')}}"></script>
   <script src="{{asset('js/jquery.validate.min.js')}}"></script>
   <script src="{{asset('js/jquery.combo.select.js')}}"></script>
  


   <!-- Agenda -->
  <script src="{{asset('js/moment.min.js')}}"></script>
  <script src="{{asset('js/moment-recur.js')}}"></script>
  <script src="{{asset('js/fullcalendar.min.js')}}"></script>
  <script src="{{asset('js/gcal.js')}}"></script>
  <script src="{{asset('js/lang-all.js')}}"></script>
  <script src="{{asset('js/functions.js')}}"></script>



  <!-- Boostrap calendar -->
  <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>

  <script src="{{asset('js/jquery-clockpicker.min.js')}}"></script>
  <script src="{{asset('js/bootstrap-clockpicker.min.js')}}"></script>
  <!-- Color picker -->
  <script src="{{asset('js/bootstrap-colorpicker.min.js')}}"></script>

  <!-- Date picker -->
  <script src="{{asset('js/jquery-ui.min.js')}}"></script>
  <script src="{{asset('js/jquery.ui.datepicker-fr.js')}}"></script>
  
  <!-- Brow file -->
  
  <script src="{{asset('js/fileinput.min.js')}}"></script> 
  <script src="{{asset('js/fileinput_locale_fr.js')}}"></script> 


  <!-- <script type="text/javascript" src="{{asset('js/juery.validate.js')}}"></script> -->
  <script type="text/javascript" src="{{asset('js/jqBootstrapValidation.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/bootstrap-confirm-delete.js')}}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script>



@show


<!-- For table slider -->
<script type="text/javascript">

  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
    
      $(document).ready(function(){
               // $(".table-slide").slick();
         $('.table-slide').slick({
          
          dots: false,
          infinite: false,
          speed: 300,
          slidesToShow: 7,
          slidesToScroll: 7,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: false,
                 adaptiveHeight: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            }

            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
      });
    </script>
   <script type="text/javascript">
        $(document).ready(function(){
            
              $("#form-control-spe").select2({
                     placeholder: "Spécialité recherchée...",
                      allowClear: true,
                    language: {
                      noResults: function(term) {
                        return "Aucun résultat.";
                      }
                    }
              });
      

          
        });
    </script>
   
   
   


  </body>
   
</html>
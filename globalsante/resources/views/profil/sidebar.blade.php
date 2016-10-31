<!-- <div id="sidebar-wrapper"> -->
<span class="toggle-button">
            <div class="menu-bar menu-bar-top"></div>
            <div class="menu-bar menu-bar-middle"></div>
            <div class="menu-bar menu-bar-bottom"></div>
        </span>
        <div class="menu-wrap">
            <div class="menu-sidebar">
               
                 <ul class="sidebar-nav manu" >

        <li class="{{ Request::is('profil-global-sante/moyens-de-paiement') ? 'menuActive' : '' }}">
            <a href="<?php echo URL::to('/profil-global-sante/moyens-de-paiement'); ?>">
            <span class="glyphicon glyphicon-user"></span> Moyens de paiement</a>
        </li>
        <li>
            @if (Request::is('parameters/agenda'))
                <a href="<?php echo URL::to('/profil-global-sante/formations'); ?>" class="menuActive">
            @else
                <a href="<?php echo URL::to('/profil-global-sante/formations'); ?>">
            @endif
            <span class="glyphicon glyphicon-calendar"></span> Formations</a>
        </li>
       
        <li class="{{ Request::is('profil-global-sante/autres-informations') ? 'menuActive' : '' }}">
            
            <a href="<?php echo URL::to('/profil-global-sante/autres-informations'); ?>">
          
            <span class="glyphicon glyphicon-phone"></span> Autres informations</a>
        </li>
    </ul>         
    </div>
</div>
@section('js')
@parent        
<script type="text/javascript">
$(document).ready(function() {

    var $toggleButton = $('.toggle-button'),
        $menuWrap = $('.menu-wrap'),
        $sidebarArrow = $('.sidebar-menu-arrow');

    // Hamburger button

    $toggleButton.on('click', function() {
        $(this).toggleClass('button-open');
        $menuWrap.toggleClass('menu-show');
    });

    // Sidebar navigation arrows

    $sidebarArrow.click(function() {
        $(this).next().slideToggle(300);
    });

});

</script>
@stop
<!-- </div> -->
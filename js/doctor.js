
$(function () {

    //case new patience
    $(".existPatient").hide();
    $(".noveauPatient").hide();
    var usertype = "";
    //check new patient or exist patient
    $('input:radio[name="chkpatient"]').change(function(){
        if (this.checked && this.value == 'noveau') {
            $(".existPatient").hide();
            $(".noveauPatient").show();
            //$(".noveauPatient").find("input").Attr("required");
            usertype = 'noveau';
        }
        else{
            $(".existPatient").show();
            $(".noveauPatient").hide();
            //$(".noveauPatient").find("input").removeAttr("required");
            $(".noveauPatient").find("div").removeClass("control-group");
            usertype = 'exist';
            
        }
    });

    //check on madam display only nom de jeun 
    var title = "";
    $(".nom_jeun").hide();
    $('input:radio[name="title"]').change(function(){
        if (this.checked && this.value == 'Mme') {
           $(".nom_jeun").show();
           title = "Mme";
        }
        else{
             $(".nom_jeun").hide();
             title = "M.";
        }
        
    });
    //for motif will change next
    $("#motif_consultant").on("hide.bs.collapse", function(){
        $(".btnmotifConsultant").html('<span class="glyphicon glyphicon-collapse-down"></span> Motifs de consultation');
    });
    $("#motif_consultant").on("show.bs.collapse", function(){
        $(".btnmotifConsultant").html('<span class="glyphicon glyphicon-collapse-up"></span> Motifs de consultation');
    });

    $(".click-text").on("click",function(){
        if($(this).hasClass("textline")){
            $(this).removeClass("textline");
        }
        else{
            $(this).addClass("textline");
        }       
    });

    $('#datetimepicker2').datetimepicker({
        locale: 'fr',
        // format: 'dd DD MMM hh:mm'
         format: 'YYYY-MM-DD HH:mm'
    });
    $("#absencehour").datetimepicker({
        locale: 'fr',
        // format: 'dd MM YYYY'
        format: 'YYYY-MM-DD'

    });
    $("#finabsencehour").datetimepicker({
        locale: 'fr',
        // format: 'dd MM YYYY'
        format: 'YYYY-MM-DD'
    });
    $("#ouverturehour").datetimepicker({
        locale: 'fr',
        format: 'YYYY-MM-DD'
    });
    $("#birthdate").datetimepicker({
        locale: 'fr',
        format: 'DD MM YYYY'
    });

    $("#le").datetimepicker({
        locale: 'fr',
        format: 'YYYY-MM-DD'
    });
    $("#absencetime").datetimepicker({
        locale: 'fr',
         format: 'YYYY-MM-DD'

    });
	// Time picker
    // $('.consulclock').clockpicker({
    // 	 donetext: 'Done'
    // });

    $(".absence-clock").clockpicker({
    	 donetext: 'Validez'
    });
    $(".absence-clock-fin").clockpicker({
    	 donetext: 'Validez'
    });
    $(".time-clock-start").clockpicker({
    	 donetext: 'Validez'
    });
    $(".time-clock-fin").clockpicker({
    	 donetext: 'Validez'
    });
    // Color
     $('.color').colorpicker();
     //Ouverture color
     $(".ouvertColor").colorpicker();



     $("#city").select2({
           placeholder: "Ville",
           allowClear: true
          //allowClear: true
    });



    // Check if checkbox is change
    $(".absence-clock-fin").show();
    $(".absence-clock").show();
    $("#chkjour").change(function() {
        if(this.checked) {
            //Do stuff
            $(".absence-clock-fin").hide();
            $(".absence-clock").hide();
        }
        else{
            $(".absence-clock-fin").show();
            $(".absence-clock").show();
        
        }
    });

    //Ouverture

    $(".step").hide();
    $("#config-standard").hide();
    //Click on configuration avance
    $("#config-avance").on("click",function(){
        $(this).hide();
        $(".step").show();
        $(".chk-group").hide();
        $(".hideradio").hide();
        $("#config-standard").show();
        $('.hideradio input:radio[name="radiocheck"]').removeAttr('required');
    });
    $("#config-standard").on("click",function(){
        $(this).hide();
        $("#config-avance").show();
        $(".step").hide();
        $(".chk-group").show();
        $(".hideradio").show();
    });


    //check on radio tout or limit
    $('input:radio[name="radiocheck"]').change(function(){
        if (this.checked && this.value == 'tout') {
            $(".chk-group").hide();
        }
        else{
            $(".chk-group").show();
        }
        
    });
    $(".repeter-show").hide();
    $(".chkoui").show();
    $(".chknon").hide();
    $('input:radio[name="chkon"]').change(function(){
        if (this.checked && this.value == '1') {
            $(".repeter-show").show();
            $(".chkoui").hide();
            $(".chknon").show();
        }
        else{
            $(".repeter-show").hide();
            $(".chkoui").show();
            $(".chknon").hide();
        }
    });


});


function repeatBysemaines(week){
    var semaines = 7;
    if (week == 2) {
        semaines = (14-7);
    }
    if(week == 3){
        semaines = (21-7);
    }
    if(week == 4){
        semaines = (28-7);
    }
    if(week == 5){
        semaines = (35-7);
    }
    if(week == 6){
        semaines = (42-7);
    }
    if(week == 7){
        semaines = (49-7);
    }
    if(week == 8){
        semaines = (56-7);
    }
    if(week == 9){
        semaines = (63-7);
    }
    if(week == 10){
        semaines = (70-7);
    }
    if(week == 11){
        semaines = (77-7);
    }
    if(week == 12){
        semaines = (84-7);
    }
    return semaines;
}
function returnDays(days){
    var arr_day = days; 
    var day = [];   
    if (arr_day[0] == 1) {
        day.push(1);
    }
    if(arr_day[1] == 1){
        day.push(2);
    }
    if(arr_day[2] == 1){
        day.push(3);
    }
    if(arr_day[3] == 1){
        day.push(4);
    }
    if(arr_day[4] == 1){
        day.push(5);
    }
    if(arr_day[5] == 1){
        day.push(6);            
    }
    if(arr_day[6] == 1){
        day.push(0);            
    }
    return day;
    
}

function isInArray(value, array) {
  return array.indexOf(value) > -1;
}
function sumarray(total,array){
    for (var i = 0; i < array.length; i++) {
        total += array[i] << 0;
    }
    return total;
}
function GetCurrentDisplayedMonth() { 
    var date = new Date($('#calendar').fullCalendar('getDate'));
    var month_int = date.getMonth();
    var year_int = date.getFullYear();
    return month_int+","+year_int; 
}
var str_day = "";

var dayofweek =0;
function getPartient(str_day,dayofweek){
    if (dayofweek > 0) {
        if (dayofweek == 1) {
           str_day = dayofweek+'<p class="desktop"> patient</p><p class="mobile">p</p>'; 
          
        }

        else{
            str_day = dayofweek +'<p class="desktop"> patients</p><p class="mobile">p</p>';
        }
        
    }
    else{
        str_day ='<p class="desktop">0<br>patient</p><p class="mobile">0<br>p</p>';;
    }
    return str_day;
}

var start,end;
function fullcalendaDate(start,end){
    var newstart = moment(start).format('YYYY-MM-DD HH:mm');
    var endDate = moment(end).format('YYYY-MM-DD HH:mm');
    var dateformart = moment(start).format('YYYY-MM-DD HH:mm');
    var absenceDate = moment(start).format('YYYY-MM-DD');
    var normal = moment(start).format('DD MMM YYYY');
    var getTime = newstart.split(" ");
    var getEndtime = endDate.split(" ");

    $("#setabsencetime").val(getTime[1]);
    $("#setabsencetime_fin").val(getEndtime[1]);
    $("#time_start").val(getTime[1]);
    $("#time_fin").val(getEndtime[1]);

    $("#ouverture_clock_start").val(getTime[1]);
    $("#ouverture_clock_fin").val(getEndtime[1]);

    //alert(dateformart);
    $("#hiddendate").val(dateformart);  

    $('#fullCalModal').modal();
    $("#dhour").val(newstart);

    //For absence date
    $("#absencehourinput").val(absenceDate);
    $("#finhour").val(absenceDate);


    $("#absencetimeinput").val(absenceDate);
    $("#ouverturedatehour").val(absenceDate);
}

//$.datepicker.setDefaults($.datepicker.regional['en']);
$('#datepicker').datepicker({
    inline: true,
    onSelect: function(dateText, inst) {
        var d = new Date(dateText);
        //var d = moment(dateText).format('YYYY-MM-DD');
        //alert(d);
        $('#calendar').fullCalendar('gotoDate', d);
    }
});
// all function in agenda
function dateString2Date(dateString) {
  var dt  = dateString.split(/\-|\s/);
  return new Date(dt.slice(0,3).reverse().join('-') + ' ' + dt[3]);
}
function addDays(date, days) {
    var result = new Date(date);
    result.setDate(date.getDate() + days);
    return result;
}
function parseDate(input) {
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}

    

//function phone number validation	
function phonenumbervalidation(ele,span){
	//phone number validation		
	$("#"+ele).on("change",function(e){
        $("."+span).hide();
        var phone = $(this).val();
        var phonePattern = /^0[6-7]\d{8}$/g;
         if (!phonePattern.test(phone)){
            $("."+span).show();
            $("."+span).css("color","#b94a48");
            return false;
         }
    });
   
	
}
//Custom text style
function customTextStyle(ele,type){
	$("#"+ele).bind('keyup', function (e) {
		if (e.which >= 97 && e.which <= 122) {
	        var newKey = e.which - 32;
	        // I have tried setting those
	        e.keyCode = newKey;
	        e.charCode = newKey;
	    }

	    if (type == "uppercase") {
	    	$("#"+ele).val(($("#"+ele).val()).toUpperCase());
	    }
	    else{
	    	var str = $("#"+ele).val();
		    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
			    return letter.toUpperCase();
			});
			$("#"+ele).val(str);
	    }
	});
 
}

//validation day month year
function isNumberDay(evt,val) {
	var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};
	var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;
	if( key >= 48 && key <= 57 ){
		var valueKey = numArray[key];
		var ex = /^(0?[0-9]|[0-9][0-9]){1}$/;
		if (val.value){
			var value = val.value + "" + valueKey;
	    	
	    }else{
	    	var value = valueKey;
	    }
		if (value<32)
		{
			var returned =  ex.test(value);
			var valTxt = "" + value;
			if (numArray[key] > 3 || value > 9 || valTxt.length == 2) 
			{;
				$('#monthValue').focus();
				$('#dayValue').val($('#dayValue').val()+""+numArray[key]);

				if (value <10 && $('#dayValue').val().length <2)
					$('#dayValue').val("0"+value);
				else $('#dayValue').val(value);
					returned = false;
			}
			return returned;
		}
		else {
			$('#monthValue').focus();
			$('#monthValue').val(numArray[key]);
			return false;
		}
	}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
		return true;
	
	}else{
		return false;
	}
    
}

function isNumberMonth(evt,val) {
	var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};
	var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;			
	if( key >= 48 && key <= 57 ){
		var valueKey = numArray[key];
		var ex = /^(0?[0-9]|[0-9][0-9]){1}$/;
		var ex2 = /^([0-9]){2}$/;
		if (val.value == 1 ){
			var value = val.value+ "" + valueKey;
	    	
	    }else{
	    	var value = "" +valueKey;
	    }
		if (value<13)
		{			
			var returned =  ex.test(value);
			var valTxt = "" + value.toString();
			
			console.log (ex2.test(value) + " " +$('#monthValue').val() + " " + valTxt.length + " "+value.length );
		
			if ( value > 1 || ex2.test(value)) {
				
				$('#yearValue').focus();
				if (value <10)
				$('#monthValue').val("0"+value);
				else $('#monthValue').val(value);
				returned = false;
			}
			setTimeout(function(){
				if ($('#monthValue').val().length==2)
				$('#yearValue').focus();
			}, 100);
			return returned;
		} else {
			$('#yearValue').focus();
			$('#yearValue').val(numArray[key]);
			return false;
		}
	}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
		return true;
	
	}else{
		return false;
	}
    
}

function isNumberYear(evt,val) {
	var numArray = {48:0, 49:1, 50:2, 51:3, 52:4, 53:5, 54:6, 55:7, 56:8, 57:9};
	var key = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : 0;
	if( key >= 48 && key <= 57 ){
		var valueKey = numArray[key];
		var ex = /^([0-9][0-9][0-9][0-9]){1}$/;
		if (val.value){				
			var value = val.value+ "" + valueKey;
	    	
	    }else{
	    	var value = valueKey;
	    }
	}else if(key == 8 || key == 37 || key == 39 || key == 46 || key == 9 || key == 13){
		return true;
	
	}else{
		return false;
	}
    
}
//function user change
function loadform(){
	$("#userType").on("change",function(){
		var userType = $("#userType option:selected").text();	
		if (userType == "Doctor") {
			$.get('{!! url("/users/loadform") !!}/' + val,function(response){
					$("#insertForm").html(response);
				});
		};
	});

	$("#chk").change(function() {
		    if(this.checked) {
		        //Do stuff
		       // alert(1);
		        $.get('{!! url("/loadform") !!}',function(response){
		        	//alert(response);
					$("#insertForm").html(response);
				});
		    }
		    else{
		    	$("#insertForm").html("");
		    }
		});

}

//function load tab
function loadTab(){
	var hash = window.location.hash;
	hash && $('ul.nav a[href="' + hash + '"]').tab('show');

	$('.nav-tabs a').click(function (e) {
	    $(this).tab('show');
	    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
	    window.location.hash = this.hash;
	    $('html,body').scrollTop(scrollmem);
	   
	});
}
function inputTextOnly(ele){
	$("#"+ele).keyup(function(e) {
	   var regex = /^[a-zA-Z]+$/;
	   if (regex.test(this.value) !== true){
	   		$(this).next("span").text("Merci de saisir du texte seulement");
	   }
	   else{
	   		$(this).next("span").text("");
	   } 
	});

}
// validate cp

function validateCP(ele){
	//numberic_only_function
	$("."+ele).keypress(function (e) {
	    //if the letter is not digit then display error and don't type anything
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	    //display error message
	        return false;
	    }
	});
}

function formatState (state) {
	if (!state.id) { return state.text; }
	var $state = $(
	  '<span class="image-doctor"><img src="{{asset("img/hospi.jpg")}}" class="img-responsive img-circle custom-img" /> ' + state.text + '</span>'
	);
	return $state;
};
function checkValidTime(inputField) {
    var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField);

    return isValid;
}

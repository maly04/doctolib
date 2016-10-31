// $(document).ready(function () {
//     $(".error_email").hide();
//     var navListItems = $('div.setup-panel div a'),
//             allWells = $('.setup-content'),
//             allNextBtn = $('.nextBtn');

//     allWells.hide();

//     navListItems.click(function (e) {
//         e.preventDefault();
//         var $target = $($(this).attr('href')),
//                 $item = $(this);

//         if (!$item.hasClass('disabled')) {
//             navListItems.removeClass('btn-primary').addClass('btn-default');
//             $item.addClass('btn-primary');
//             allWells.hide();
//             $target.show();
//             $target.find('input:eq(0)').focus();
//         }
//     });

//     allNextBtn.click(function(){
//         var curStep = $(this).closest(".setup-content"),
//             curStepBtn = curStep.attr("id"),
//             nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
//             curInputs = curStep.find("input[type='text'],input[type='url']"),
//             isValid = true;

//         $(".form-group").removeClass("has-error");
//         for(var i=0; i<curInputs.length; i++){
//             if (!curInputs[i].validity.valid){
//                 isValid = false;
//                 $(curInputs[i]).closest(".form-group").addClass("has-error");
//             }
//         }

//         if (isValid == true){
//             var step = $(this).data("step");
//             if (step == "step1") {
//                 var phone = $("#phonenumber").val();
//                 var email = $("#email").val();
//                 var pass =  $("#password").val();
//                 var str_data = "phone="+phone+"&email="+email+"&password="+pass;
//                 $.ajax({            
//                    url: "{!! action('DoctoLibController@sendsms') !!}",
//                    type: "get",
//                    data: str_data,
//                    success:function(response){
//                         alert(response);
//                        //nextStepWizard.removeAttr('disabled').trigger('click');
//                    }
//                 });
//             }
//         }
            
            
//     });

//     $('div.setup-panel div a.btn-primary').trigger('click');

    
// });

$(document).ready(function(){
        $(".error_phone").hide();
        $("#phonenumber").on("change",function(e){
            $(".error_phone").hide();
            var phone = $(this).val();
            var phonePattern = /^0[6-7]\d{8}$/g;
             if (!phonePattern.test(phone)){
                $(".error_phone").show();
                $(".error_phone").css("color","red");
                return false;
             }
        });
});
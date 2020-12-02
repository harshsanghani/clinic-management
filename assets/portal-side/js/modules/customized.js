$(document).ready(function(){        
    $('.customized_form').validate({
        errorElement: 'span',
        errorClass: 'help-inline',

        rules: {
            date: {
                required    : true
            },
            patient: {
                required    : true
            },
            "certificate[physician_name]" :{
                required    : true
            }
        },
        messages: {
            date: {
                required    : "Please Select a Date" 
            },
            patient : {
                required    : "Please select a Patient"
            },
            "certificate[physician_name]" :{
                required    : "Please enter physician name"
            }
        },
        errorPlacement: function(error, element) {  
            if (element.attr("name") == "patient" ) {
                error.insertAfter(element.parent(".form-group"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    
});


$(document).ready(function(){        
    $('.sickness_form').validate({
        errorElement: 'span',
        errorClass: 'help-inline',

        rules: {
            date: {
                required: true
            },
            patient: {
                required: true
            }
        },
        messages: {
            date: {
                required : "Please Select a Date" 
            },
            patient : {
                required : "Please select a Patient"
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


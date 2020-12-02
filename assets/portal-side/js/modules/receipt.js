$(document).ready(function(){
    
    $('.receipt_form').validate({
        errorElement: 'span',
        errorClass: 'help-inline',

        rules: {
            date: {
                required: true
            },
            patient: {
                required: true
            },
            "certificate[receipt_no]": {
                required: true
            }
        },
        messages: {
            date: {
                required : "Please Select a Date" 
            },
            patient : {
                required : "Please select a Patient"
            },
            "certificate[receipt_no]" : {
                required : "Receipt number is required"
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
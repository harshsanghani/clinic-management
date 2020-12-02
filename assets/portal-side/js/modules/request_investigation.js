$(document).ready(function(){
    
    $('.request_investigation').validate({
        errorElement: 'span',
        errorClass: 'help-inline',
        rules: {
            date: {
                required: true
            },
            patient: {
                required: true
            },
            'certificate[lab_name]' : {
                required: true
            },
            'certificate[investigation_type]' : {
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
            'certificate[lab_name]' : {
                required : "Please enter Laboratory/ Physician name"
            },
            'certificate[investigation_type]' : {
                required: 'Please select investigation type'
            }
        },
        errorPlacement: function(error, element) {  
            if (element.attr("name") == "patient" || element.attr("name") == "certificate[investigation_type]") {
                error.insertAfter(element.parent(".form-group"));
            } else {
                error.insertAfter(element);
            }
        }
    });
});
$(document).ready(function(){
    $('.patient-report').validate({
        errorElement: 'span',
        errorClass: 'help-inline',

        rules: {
            date: {
                required    : true
            },
            patient: {
                required    : true
            },
            "certificate[dignosis]" :{
                required    : true
            },
             "certificate[problem]" :{
                required    : true
            },
             "certificate[medicine]" :{
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
            "certificate[dignosis]" :{
                required    : "Please enter dignosis"
            },
             "certificate[problem]" :{
                required    : "Please enter problem"
            },
             "certificate[medicine]" :{
                required    : "Please enter medicine"
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
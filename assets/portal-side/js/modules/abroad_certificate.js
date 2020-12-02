$(document).ready(function(){
    $('.abroad_form').validate({
        errorElement: 'span',
        errorClass: 'help-inline',

        rules: {
            date: {
                required    : true
            },
            patient: {
                required    : true
            },
            "certificate[carry_person_title]" :{
                required    : true
            },
             "certificate[carry_person_name]" :{
                required    : true
            },
             "certificate[carry_person_relation]" :{
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
            "certificate[carry_person_title]" :{
                required    : "Please enter title"
            },
             "certificate[carry_person_name]" :{
                required    : "Please enter name"
            },
             "certificate[carry_person_relation]" :{
                required    : "Please enter relation"
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

$(function() {
    $("#profile_form").validate({
        errorElement    : 'span',
        errorClass      : 'help-inline',
        rules: {
            username: {
                required    : true
            },
            email : {
                required    : true,
                email       : true
            },
            cpassword : {
                equalTo     : "#password"
            }
        },
        messages: {
            username: {
                required    : "Please enter username"
            },
            email : {
                required    : "Please enter email address",
                email       : "Please enter valid email address"
            },
            cpassword : {
                equalTo     : "Password & Confirm password must be same"
            }
        }
    });

    $("#login_form").validate({
        errorElement    : 'span',
        errorClass      : 'help-inline',

        rules: {
            username: {
                required    : true
            },
            password: {
                required    : true,
                minlength   : 5
            }
        },
        messages: {
            password: {
                required    : "Please provide a password",
                minlength   : "Your password must be at least 5 characters long"
            },
            username: "Please enter a Username"
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") == "text" ) {
                error.insertAfter(element.parent(".form-group"));
            } else if  (element.attr("type") == "password" ) {
                error.insertAfter(element.parent(".form-group"));
            }
        }
    });
    
    $("#forget_form").validate({
        errorElement    : 'span',
        errorClass      : 'help-inline',

        rules: {
            email: {
                required    : true,
                email       : true,
                remote      : {
                        url: base_url+'user/check_email',
                        type: "post",
                        data: {
                            email: function() {
                                return $( "#email" ).val();
                            }
                        }
                }
            }
        },
        messages: {
            email:  {
                required    : "Please enter a Email",
                email       : "Please Enter valid email",
                remote      : "Please Enter Correct email"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") == "text" ) {
                error.insertAfter(element.parent(".form-group"));
            } else if  (element.attr("type") == "password" ) {
                error.insertAfter(element.parent(".form-group"));
            }
        }
    }); 
    
    $("#reset_password").validate({
        errorElement: 'span',
        errorClass: 'help-inline',

        rules: {
            password : {
                required: true
            },
            cpassword : {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            password  :  {
                required : "Please enter a Password"
            },
            cpassword :  {
                required : "Please enter a Confirm Password",
                equalTo  : "Password and Confirm Password Must be same"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") == "text" ) {
                error.insertAfter(element.parent(".form-group"));
            } else if  (element.attr("type") == "password" ) {
                error.insertAfter(element.parent(".form-group"));
            }
        }
    });

});



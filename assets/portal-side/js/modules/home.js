$(document).ready(function(){ 
    
    $(document).on('submit','#add_appointment',function(e){
        e.preventDefault();
        var $this  = $(this);
        var action = $this.attr('action');
        if ($this.valid()) {
            $('#new-appointment').modal('hide');
            $.ajax({
                url: action,
                type:"post",
                data: $this.serialize(),
                success: function(data){
                    var response =  $.parseJSON(data);
                    if(response.status == true) {
                        $('.calendar').fullCalendar('refetchEvents');
                        showMessage('success',response.message);
                    } else {
                        showMessage('danger',response.message);
                    }
                }
            });
        }  
    });

    $(document).on('click','.appointment_model',function(){       
        var appointment_id  = ""
        var today           = "new";

        if (typeof $(this).attr('data-id') !== 'undefined') {
            $('#edit-event').modal('hide');
            appointment_id = $(this).attr('data-id');
            today = "";
        }

        load_appointment(today,appointment_id);
    });

    $(document).on('click','.delete-appointment',function(){       
        var appointment_id  = ""

        if (confirm('Are you sure, You want to delete?')) {
            if (typeof $(this).attr('data-id') !== 'undefined') {
                appointment_id = $(this).attr('data-id');

                if (appointment_id != '') {
                    $.ajax({
                        url     : base_url+'home/delete_appointment',
                        type    : "post",
                        data    : {appointment_id : appointment_id},
                        success : function(data){
                            $('#edit-event').modal('hide');
                            var response =  $.parseJSON(data);   
                            if(response.status == true) {
                                $('.calendar').fullCalendar('refetchEvents');
                                showMessage('success',response.message);
                            } else {
                                showMessage('danger',response.message);
                            }
                        }
                    });
                }
            }
        }
    });
});

function load_appointment(date,appointment_id) { 

    var url_path = base_url+'home/index'
    if (typeof appointment_id != "undefined") {     
        url_path = base_url+'home/index/'+appointment_id;
    }
    var defaultdate = '';
    if ( date == 'new') {
         defaultdate = moment().format("DD-MM-YYYY");
    } else if(date != '') {
         defaultdate = moment(date).format("DD-MM-YYYY");
    }

    $.ajax({
        url     : url_path,
        type    : "post",
        success : function(data){
            var response =  $.parseJSON(data);   
            if(response.status == true) {
                $('#new-appointment').html(response.html);
                $('#new-appointment').modal('show');                    
                init_validation();
                init_patient_list();                
                init_timepicker();
                init_datepicker();
                
                init_date_mask();
                
                if (defaultdate != "") {
                    $('input[name="appointment_date"]').val(defaultdate);
                }

            } else {
                showMessage('danger',response.message);
            } 
        }
    });
}

function init_validation() {
    $('#add_appointment').validate({
        errorElement: 'span',
        errorClass: 'help-inline',
        rules: {
            patient_id: {
                required: true
            },
            appointment_date: {
                required: true
            },
            appointment_time : {
                required: true
            }
        },
        messages: {
            patient_id: {
                required : "Please Select a Patient" 
            },
            appointment_date : {
                required : "Please select Appointment Date"
            },
            appointment_time : {
                required : "please enter Appointment time"  
            }
        },
        errorPlacement: function(error, element) {  
            if (element.attr("name") == "patient_id" ) {
                error.insertAfter(element.parent(".form-group").find('.form-group__bar'));
            } else {
                error.insertAfter(element);
            }
        }
    });    
}


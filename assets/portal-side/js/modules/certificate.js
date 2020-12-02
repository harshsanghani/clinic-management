$(document).ready(function(){
    init_patient_list(); 
    init_datepicker();
    init_days_mask();

    $(document).on('click','.preview_button',function(e){
        e.preventDefault();
        var p_form = $(this).parents('form');
        if ( p_form.valid()){
            p_form.append("<input type='hidden' name='preview' value='1'>");
            p_form.submit();
        }
        
    });

    $(document).on('click','.delete-confirm',function(e){
        e.preventDefault();
        var $this   = $(this);
        var url     = $this.attr('href');
        if (confirm("Are you sure to remove record?")){
            $.ajax({
                url     : url,
                type    :"post",
                success: function(data){                                
                    var response =  $.parseJSON(data);
                    if(response.status == true) {
                        showMessage('success', response.message);
                        $this.parents('tr').fadeOut("normal", function() {
                            $(this).remove();
                        });
                    } else {
                        showMessage('danger', response.message);
                    }                
                }
            });
        } else {
            return false;
        }
    });

    $(document).on('click','.send_email',function(e){
        e.preventDefault();
        var email = $(this).attr('data-email');
        $('.patient_email').html(email);
        $('#email-model').modal('show'); 
        $('.send-email').attr('href',$(this).attr('href'));
    });
    $(document).on('click','.send-email',function(e){
        e.preventDefault();      
        var url = $(this).attr('href');
        $.ajax({
            url     : url,
            type    :"post",
            success: function(data){                                
                var response =  $.parseJSON(data);
                if(response.status == true) {
                    showMessage('success', response.message);
                    $('#email-model').modal('hide');
                } else {
                    showMessage('danger', response.message);
                }                
            }
        });
     });
});
function get_report(report_type) { 
    if($('#prescription_report').length > 0 && report_type != '') {
        $('#prescription_report').DataTable({
            "destroy"    : true,
            "processing" : true,
            "serverSide" : true,
            'pageLength' : 10,
            "ajax": {
                "url"   : base_url+'certificate/index/' + report_type,
                "type"  : "POST"
            },
            "columns": [
                { "data"    : "name" },
                { "data"    : "date"},
                { "data"    : "action" }
            ]
        });
    }
}


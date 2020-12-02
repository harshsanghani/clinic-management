
$(document).ready(function(){
    init_patient_list();
   
   if($(".from-date").length > 0) {
        $(".from-date").flatpickr({
            enableTime  : !1,
            dateFormat  : 'Y-m-d',
            autoclose   : true,
            nextArrow   : '<i class="zmdi zmdi-long-arrow-right" />',
            prevArrow   : '<i class="zmdi zmdi-long-arrow-left" />',
            onChange: function(selectedDates, dateStr, instance) {
               get_todate(dateStr); 
            }
        });
    }
    
    $(document).on('submit','.invoice_filter',function(e){ 
        e.preventDefault();
        init_validate();
        get_invoice_report()
    });
    $('.reset').on('click',function(){   
        $('.from-date').val('');
        $('.to-date').val('');
        $('.patient_list').val('').change();
        get_invoice_report()
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
})

function get_invoice_report() {
      if($('#invoice-report').length > 0) {
        var from_date   = $('.from-date').val();
        var to_date     = $('.to-date').val();
        var patient_id  = $('.patient_list').val();
        $('#invoice-report').DataTable({
            "dom"           : "Blfrtip",
            "buttons"       : [{
                                "extend"        : "csvHtml5",
                                "title"         : "Export Data",
                                "exportOptions" : {
                                                    "columns" : ['0','1','2','3']
                                                }
                            },{
                                "extend"        : "excelHtml5",
                                "title"         : "Export Data",
                                "exportOptions" : {
                                                    "columns" : ['0','1','2','3']
                                                }
                            }],
            "initComplete"  : function(a, b) {
                $(this).closest(".dataTables_wrapper").prepend('<div class="dataTables_buttons hidden-sm-down actions"><div class="dropdown actions__item"><i data-toggle="dropdown" class="zmdi zmdi-download" /><ul class="dropdown-menu dropdown-menu-right"><a href="" class="dropdown-item" data-table-action="excel">Excel (.xlsx)</a><a href="" class="dropdown-item" data-table-action="csv">CSV (.csv)</a></ul></div></div>')
            },
            "destroy"       : true,
            "processing"    : true,
            "serverSide"    : true,
            'pageLength'    : 10,
            "ajax": {
                "url"   : base_url+'invoice/index',
                "type"  : "POST",
                "data" : {
                    "patient_id"    : patient_id,
                    "from"          : from_date,
                    "to"            : to_date
                }
            },
            "columns": [
                { "data"    : "file_number" },
                { "data"    : "name" },
                { "data"    : "consulting_amount" },
                { "data"    : "medicine_amount" },
                { "data"    : "received_amount" },
                { "data"    : "amount" },
                { "data"    : "appointment_date" },
                { "data"    : "action"}
            ]
        });
        
         $("body").on("click", "[data-table-action]", function(a) {
            a.preventDefault();
            var b = $(this).data("table-action");
            if ("excel" === b && $(this).closest(".dataTables_wrapper").find(".buttons-excel").trigger("click"), "csv" === b && $(this).closest(".dataTables_wrapper").find(".buttons-csv").trigger("click"), "print" === b && $(this).closest(".dataTables_wrapper").find(".buttons-print").trigger("click"), "fullscreen" === b) {
                var c = $(this).closest(".card");
                c.hasClass("card--fullscreen") ? (c.removeClass("card--fullscreen"), $("body").removeClass("data-table-toggled")) : (c.addClass("card--fullscreen"), $("body").addClass("data-table-toggled"))
            }
        });
    }
}
function get_todate(from_date) {
    if($(".to-date").length > 0) {
        $(".to-date").flatpickr({
            enableTime  : !1,
            dateFormat  : 'Y-m-d',
            autoclose   : true,
            minDate     : from_date,
            nextArrow   : '<i class="zmdi zmdi-long-arrow-right" />',
            prevArrow   : '<i class="zmdi zmdi-long-arrow-left" />'
        });
    }
    init_validate();
}
function init_validate() {
   $('.invoice_filter').validate({
        errorElement: 'span',
        errorClass  : 'help-inline',
        rules: {
            to_date: {
                required_to_date: true
            }
        },
        messages: {
            to_date : {
                required_to_date : "please Select to date"
            }
        }
    }); 
    $.validator.addMethod("required_to_date", function(value, element) {
        var returnValue = true;
        if ($('.from-date').val() != '' && $('.to-date').val() == '') {
            returnValue = false;
        } 
        return returnValue;
    });
    
}




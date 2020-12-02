$(window).on("load", function() {
    setTimeout(function() {
        $(".page-loader").fadeOut();
    }, 500)
}),
$(document).ready(function() {
    
    init_phone_mask();
    init_date_mask();
    initScrollbar();

    $("body").on("click", "[data-ma-action]", function(b) {
        b.preventDefault();
        var c = $(this)
          , d = c.data("ma-action")
          , e = "";
        switch (d) {
            case "aside-open":
                e = c.data("ma-target"),
                c.addClass("toggled"),
                $(e).addClass("toggled"),
                $(".content, .header").append('<div class="ma-backdrop" data-ma-action="aside-close" data-ma-target=' + e + " />");
                break;
            case "aside-close":
                e = c.data("ma-target"),
                $('[data-ma-action="aside-open"], ' + e).removeClass("toggled"),
                $(".content, .header").find(".ma-backdrop").remove();
                break;
            case "fullscreen":
                a(document.documentElement);
                break;
        }
    });
    
    $(document).on('keyup','.search__inner .search__text2', function(e){
        var search = $(this).val();
        if (search.length >= 3 || $.isNumeric(search)) {
            $.ajax({
                url: base_url+'patient/search_patient',
                type:"post",
                data:{search_string:search},
                success: function(data){                                
                    var response =  $.parseJSON(data);
                    if(response.status == true) {
                        $('.patient_search_result').html(response.html);
                        $('.patient_search_result').css('display','block');
                    } else {
                        $('.patient_search_result').css('display','none');
                    }                
                }
            });
        } else {
            $('.patient_search_result').css('display','none');
        } 
    });

    $("body").on("change", ".theme-switch input:radio", function() {
        var a = $(this).val();
        $("body").attr("data-ma-theme", a)
    }),
    $("body").on("focus", ".search__text", function() {
        $(this).closest(".search").addClass("search--focus")
    }),
    $("body").on("blur", ".search__text", function() {
        $(this).val(""),
        $(this).closest(".search").removeClass("search--focus")
    }),
    $("body").on("click", ".navigation__sub > a", function(a) {
        a.preventDefault(),
        $(this).parent().toggleClass("navigation__sub--toggled"),
        $(this).next("ul").slideToggle(250)
    })
});

function init_editor() {
    if ($(".wysiwyg-editor").length > 0) {
        $(".wysiwyg-editor").trumbowyg({
            autogrow: !0,
            btns: [['foreColor'], ['backColor'], ["viewHTML"], ["formatting"], ["link"], ["insertImage"], "btnGrp-justify", "btnGrp-lists", ["horizontalRule"], ["removeformat"], ["fullscreen"]]
        });
    }
}
function init_amount_mask() {
    if ($(".amount-mask").length > 0) {
        $(".amount-mask").inputmask('numeric',{
            groupSeparator : "",
            digits         : 2,
            autoGroup      : true,
            rightAlign     : false
        });
    }
}

function init_days_mask() {
    if ($(".day-mask").length > 0) {
        $(".day-mask").inputmask('numeric',{
            autoGroup      : true,
            rightAlign     : false
        });
    }
}
function init_date_mask() {
    if ($(".date-mask").length > 0) {
//        var im = new Inputmask("99-99-9999");
//        im.mask($(".date-mask"));
        $(".date-mask").inputmask("99-99-9999");
    }
}

function init_phone_mask() {
    if ($(".phone-mask").length > 0) {
//        var pm = new Inputmask("9999999999");
//        pm.mask($(".phone-mask"));
        
        $(".phone-mask").inputmask("9999999999");
    }
}
function init_patient_list() {
    if ($(".patient_list").length > 0) {      
        $('.patient_list').select2({
            width: '100%'
        });
    }
}
function init_datepicker() {
    if($(".date-picker").length > 0) {
        $('.date-picker').datepicker({
            format: "dd-mm-yyyy",
            startDate:new Date(),
            autoclose: true
        });
        
        
//        $(".date-picker").flatpickr({
//            enableTime  : !1,
//            dateFormat  : 'Y-m-d',
//            autoclose   : true,
//            //minDate     : new Date(),
//            nextArrow   : '<i class="zmdi zmdi-long-arrow-right" />',
//            prevArrow   : '<i class="zmdi zmdi-long-arrow-left" />'
//        });
    }
}

function init_timepicker() {
    if($(".time-picker").length > 0) {
        $(".time-picker").flatpickr({
            enableTime      : true,
            noCalendar      : true,
            dateFormat      : "h:i:S K",
            autoclose       : true,
            time_24hr       : false,
            minuteIncrement :30
        });
    }
}

function initDropZone() {
    if ($(".dropzone_container").length > 0) {
        var patient_id = $(".dropzone_container").data('rel');
        if (patient_id != '') {
            $(".dropzone_container").html('<div class="dropzone dz-clickable" id="dropzone-upload"></div>');
            $("#dropzone-upload").dropzone({
                paramName       : "report",
                uploadMultiple  : false,
                headers         : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //maxFiles        : 1,
                maxFilesize     : 10,
                url             : portal_url+"/patient/report_upload/"+patient_id,
                success: function(response) {
                    response    = $.parseJSON(response.xhr.response);

                    if (response.status == true) {
                        //showMessage('success', "Success");
                        get_report(patient_id);
                    } else {
                        if (typeof response.message != 'undefined') {
                            showMessage('danger', response.message);
                        } else {
                            showMessage('danger', 'Something went wrong.');
                        }
                    }
                    initDropZone();
                }
            });
        } 
    } 
}

function showMessage(type, message) {
    $.notify({
        message: message
    }, {
        type        : type,
        timer       : 4000,
        placement   : {
            from: "top",
            align: "center"
        }
    });
}

function initScrollbar() {
    $(".scrollbar-inner")[0] && $(".scrollbar-inner").scrollbar().scrollLock();
}
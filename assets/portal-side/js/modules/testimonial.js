$(document).ready(function(){
    setTimeout(function(){
        get_testimonial();
    },500);

    $(document).on('click', '.openModal', function(e) {
        e.preventDefault();
        
        var data = {};
        if (typeof $(this).data('id') != 'undefined') {
            var data = {'testimonial_id' : $(this).data('id')};
        }
        
        var path_url = base_url+'testimonial/setup';
        
        $.ajax({
            url     : path_url,
            type    :"post",
            data    : data,
            success: function(data){                                
                var response =  $.parseJSON(data);
                if (response.status == true) {
                    $('#testimonial-modal .modal-content').html(response.html);
                    $('#testimonial-modal').modal('show');
                } else {
                    showMessage('danger', response.message);
                }                
            }
        });
    });

    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you wants to delete?')) {
            var data = {};
            if (typeof $(this).data('id') != 'undefined') {
                var data = {'testimonial_id' : $(this).data('id')};
            }

            var path_url = base_url+'testimonial/delete';

            $.ajax({
                url     : path_url,
                type    :"post",
                data    : data,
                success: function(data){                                
                    var response =  $.parseJSON(data);
                    if (response.status == true) {
                        showMessage('success', response.message);
                        get_testimonial();
                    } else {
                        showMessage('danger', response.message);
                    }                
                }
            });
        }
    });
    
    $(document).on('submit', '#testimonial-form', function(e){
        e.preventDefault();
        
        var formData = new FormData($('#testimonial-form')[0]);
        
        $.ajax({
            url     : base_url+'testimonial/commit',
            data    : formData,
            type    :"POST",
            processData: false,
            contentType: false,
            success: function(data){                                
                var response =  $.parseJSON(data);
                if (response.status == true) {
                    $('#testimonial-modal').modal('hide');
                    $('#testimonial-modal .modal-content').html('');
                    get_testimonial();
                    showMessage('success', response.message);
                } else {
                    $('.ajaxerror').show();
                    $('.ajaxerror').html(response.message);
                }                
            }
        });
    });
})

function get_testimonial() {
    if ($('#testimonial-table').length > 0) {
        $('#testimonial-table').DataTable({
            "destroy"       : true,
            "processing"    : true,
            "serverSide"    : false,
            "aaSorting": [],
            "ajax": {
                "url"   : base_url+'testimonial/index',
                "type"  : "POST"
            },
            "columns": [
                { "data"    : "name"},
                { "data"    : "city"},
                { "data"    : "action"}
            ],
            'pageLength'    : 10
        });
    }
}
$(document).ready(function(){
    refreshAll();

    formValidate();

    $(document).on('click', '.openToolModal',function(e){
        e.preventDefault();
        openModal($(this));
    });

    $(document).on('click', '.deleteToolData',function(e){
        e.preventDefault();

        if (confirm("Are you sure you wants to delete?")) {
            var type = $(this).data('rel');
            var id = $(this).data('id');

            if (type != '' && id != '') {
                $.ajax({
                    url: base_url+'tool/deleteTool',
                    data: {'id' : id, 'type' : type},
                    type:"post",
                    success: function(data){
                        var response =  $.parseJSON(data);
                        if (response.status == true) {
                            refreshToolData(type);
                            showMessage('success', "Deleted successfully");
                        } else {
                            showMessage('danger',response.message);
                        }
                    }
                });
            }
        }
    });

    $(document).on('submit', '#modal-tool form', function(e) {
        e.preventDefault();

        var form_action = $(this).attr('action');

        if ($(this).valid()) {
            $.ajax({
                url: base_url+'tool/commitTool',
                data: $(this).serialize(),
                type:"post",
                success: function(data){
                    var response =  $.parseJSON(data);
                    if (response.status == true) {
                        $('#modal-tool .modal-content').html('');
                        $('#modal-tool').modal('hide');
                        refreshToolData(form_action);
                        showMessage('success', "Data save successfully");
                    } else {
                        showMessage('danger',response.message);
                    }
                }
            });
        }
    });
});

function openModal(selector) {
    var type = selector.data('rel');

    if (type != "") {

        var form_data = {'type' : type};
        var data_id = selector.data('id');
        if (data_id != 'undefined') {
            form_data = {'type' : type, 'id' : data_id};
        }

        $.ajax({
            url: base_url+'tool/openModal',
            data: form_data,
            type:"post",
            success: function(data){
                var response =  $.parseJSON(data);
                if (response.status == true) {
                    $('#modal-tool .modal-content').html(response.html);
                    $('#modal-tool').modal('show');
                    formValidate();
                } else {
                    showMessage('danger',response.message);
                }
            }
        });
    }
}

function refreshAll() {
    $('.tool_container .tool_box').each(function(){
        refreshToolData($(this).attr('data-type'));
    })
}

function refreshToolData(type) {
    if (type != '') {
        var selector = '.'+type+'_box .listview';
        $.ajax({
            url: base_url+'tool/toolData',
            data : {tool_type : type},
            type:"post",
            success: function(data){
                var response =  $.parseJSON(data);
                if (response.status == true) {
                    $(selector).html(response.html);
                } else {
                    showMessage('danger',response.message);
                }
            }
        });
    }
}

function formValidate() {
    $("#modal-tool form").validate({
        errorElement    : 'span',
        errorClass      : 'help-inline',
        rules: {
            name: {
                required : true
            }
        },
        messages: {
            name: {
                required    : "Please enter name"
            }
        }
    });
}
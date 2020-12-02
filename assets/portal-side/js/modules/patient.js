function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();            
        reader.onload = function (e) {
            $('#img').append('<img id="blah" src="'+e.target.result+'" width="100px" height="100px"/>');
        }            
        reader.readAsDataURL(input.files[0]);
    }
}
function get_report(patient_id) {
    alert(patient_id);
    $.ajax({
        url         : portal_url+'patient/report/'+patient_id,
        type        :"post",
            success: function(data){
            var response =  $.parseJSON(data);
            if(response.status == true) {
                $('.photos').html(response.html);
             } else {
                 showMessage('danger',response.message);
             }            
        }
    });
}
$(document).ready(function(){
    initDropZone();
});
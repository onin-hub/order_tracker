$("#btn-import-driver").click(function() {

var file_data = $('#input-import-driver').prop('files')[0];   
var form_data = new FormData();      

form_data.append('file', file_data);

// console.log(form_data);          

$.ajax({
    url: 'classes.php', // point to server-side PHP script 
    dataType: 'text',  // what to expect back from the PHP script, if anything
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,                         
    type: 'post',
    success: function(response) {

        var response = JSON.parse(response);

        if (response['type'] == 'success') {
            Swal.fire({
                icon: 'success',
                text: response['msg'],
            }).then(function(){
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                text: response['msg'],
            })
        }

        // console.log(response);
    }
 });
});
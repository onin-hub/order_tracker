$("#but_upload").click(function () {

    var fd = new FormData();
    var files = $('#file')[0].files[0];
    fd.append('file', files);

    $.ajax({
        url: 'z_upload.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 0) {
                $("#img").attr("src", response);
                // $(".preview img").show(); // Display image element
                $('.orderDeliveredBtn').prop('disabled', false);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'No file Chosen',
                    type: 'error'
                })
            }
        }
    });
});
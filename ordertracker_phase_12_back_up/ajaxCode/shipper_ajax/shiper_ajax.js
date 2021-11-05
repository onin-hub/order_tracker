$(document).ready(function () {

    // star rating
    $("#review").rating({
        "value": 2,
        "click": function (e) {
            // console.log(e);
            $("#appearRate").html('');
            $("#appearRate").append(e.stars);
        }
    });
    // end star rating


    showAllDataAndClearInput();



});

function showAllDataAndClearInput() {
    showAllDispatchedOrderPerShipper();
    showAllDeliveryOrderDataPerShipper();
    showAllDeliveredOrderPerShipper();
    showAllCancelledOrderPerShipper();
}


// function clearAllInput() {

// }


function showAllDispatchedOrderPerShipper() {
    var shipperId = $('#shipperID').val();

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {
            'action': "showDispatchOrderDetailsForShipper",
            'shipperId': shipperId
        },

        success: function (response) {
            // console.log(response);

            $("#showShipperDispatchOrderForChecking").html(response);
            $('#dispatchOrderTableViewPerShipper').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                // dom: 'Bfrtip',
                // buttons: [
                //     'csv', 'excel'
                // ]
            });
            // $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('cust-btn-dt'); //use to export to CSV and Excel
        }
    });

}

//stop camera strea
function stopVideoStream() {
    if (videoStream) {
      videoStream.getTracks().forEach((track) => {
        track.stop();
      });
    }
  }

function showAllDeliveredOrderPerShipper() {
    var shipperId = $('#shipperID').val();

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {
            'action': "showDeliveredOrderDetailsForShipper",
            'shipperId': shipperId
        },

        success: function (response) {
            // console.log(response);

            $("#showDeliveredOrder").html(response);
            $('#deliveredOrderTableViewPerShipper').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                // dom: 'Bfrtip',
                // buttons: [
                //     'csv', 'excel'
                // ]
            });
            // $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('cust-btn-dt'); //use to export to CSV and Excel
        }
    });

}

function showAllCancelledOrderPerShipper() {
    var shipperId = $('#shipperID').val();

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {
            'action': "showCancelledOrderDetailsForShipper",
            'shipperId': shipperId
        },

        success: function (response) {
            // console.log(response);

            $("#showCancelledOrder").html(response);
            $('#cancelledOrderTableViewPerShipper').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                // dom: 'Bfrtip',
                // buttons: [
                //     'csv', 'excel'
                // ]
            });
            // $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('cust-btn-dt'); //use to export to CSV and Excel
        }
    });

}

function showAllDeliveryOrderDataPerShipper() {

    var userShipperID = $(".userId").val();

    // console.log(userShipperID);

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: { action: "showDeliveryOrderDetailsPerShipper", 'userShipperID': userShipperID },

        success: function (response) {
            // console.log(response);
            $("#showDeliveryOrderForShipper").html(response);

            $('#deliveryOrderTableViewPerShipper').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                // dom: 'Bfrtip',
                // buttons: [
                //     'csv', 'excel'
                // ]
            });
            // $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('cust-btn-dt'); //use to export to CSV and Excel

            // console.log(response);
        }
    });
}

$(document).on('click', '.customer_Order_Info_Btn', function (e) {
    e.preventDefault();

    var orderNumber = $(this).attr('orderNumber');//get input value
    var shipperid = $(this).attr('shipperid');

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action': "getCustomerOrderByID", //set an action to trigger , what if condition to be use.
            'orderNumber': orderNumber
        },
        type: 'POST',
        success: function (response) {

            $("#showCustomerOrderDetails").html(response);
            $('.dupHubnumber').val(orderNumber);
            $('.shipperidDup').val(shipperid);

        }
    });
});

$(document).on('click', '.customer_Info_Btn', function (e) {
    e.preventDefault();

    var id = $(this).attr('id');//get input value

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action': "getCustomerId", //set an action to trigger , what if condition to be use.
            'id': id
        },
        type: 'POST',
        success: function (response) {

            $("#showCustomerDetails").html(response);
            // console.log(data);
        }
    });
});

$(document).on('click', '.forDeliveryBtn', function (e) {
    e.preventDefault();

    var hubNumber = $('.dupHubnumber').val();
    var rgetOrderId = $('.rgetOrderId').val();
    var shipperid = $('.shipperidDup').val();

    Swal.fire({
        title: 'Are you sure?',
        text: "This Item is ready to deliver!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Im Sure!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "phpAction/shipper_action/shipper_action.php",
                type: "POST",
                data: {
                    'action': "updaOStatusForDelivery",
                    'hubNumber': hubNumber,
                    'rgetOrderId' : rgetOrderId,
                    'shipperid' : shipperid
                },
                success: function (response) {

                    var data = JSON.parse(response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Order ready to deliver',
                        type: 'success'
                    })
                    $('#Customer_Order_details_modal').modal('hide');
                    $('.badgeCountDispatched').empty();
                    $('.badgeCountForDelivery').empty();
                    $('.badgeCountDispatched').append(data.dispatchCount);
                    $('.badgeCountForDelivery').append(data.deliveryCount);

                    showAllDataAndClearInput();

                }
            });
        }
    });
});

$(document).on('click', '.deliveredCancelledBtn', function (e) {
    e.preventDefault();

    var id = $(this).attr('orderid');
    var orderNumber = $(this).attr('orderNumber');
    var cFullname = $(this).attr('cusfulname');//get input value

    
    $('.dupOrderID').val(id);
    $('.dupOrderNumber').val(orderNumber);
    $('.dupCusName').val(cFullname);

});

// check the other code
$(document).on('click', '.saveOrderVoid', function (e) {
    e.preventDefault();

    var orderNumber = $('.dupOrderNumber').val();
    var voidRemark = $('.voidRemark').val();
    var userId = $('.userId').val();

    // console.log(orderNumber);
    // console.log(voidRemark);

    if (voidRemark == '') {
        Swal.fire({
            icon: 'error',
            title: 'Remark is empty!',
            type: 'error'
        })
    } else {

        Swal.fire({
            text: "Are you sure to void this order?" + ' ' + orderNumber,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "phpAction/shipper_action/shipper_action.php",
                    type: "POST",
                    data: {
                        'action': "updateOStatusForVoidedAndRemark",
                        'orderNumber': orderNumber,
                        'voidRemark': voidRemark,
                        'userId' : userId
                    },
                    success: function (response) {

                        var data = JSON.parse(response);

                        Swal.fire({
                            icon: 'success',
                            title: 'Order ' + orderNumber + ' cancelled!',
                            type: 'success'
                        })
                        $('#DeliveredOrCancelledModal').modal('hide')

                        $('.badgeCountDispatched').empty();
                        $('.badgeCountForDelivery').empty();
                        $('.badgeCountDispatched').append(data.dispatchCount);
                        $('.badgeCountForDelivery').append(data.deliveryCount);

                        showAllDataAndClearInput();

                    }
                });
            }
        });
    }


});

$(document).on('click', '.customer_rateImg_info', function (e) {
    e.preventDefault();

    var id = $(this).attr('id');

    // console.log(id);
    $.ajax({
        url: 'phpAction/shipper_action/shipper_action.php',
        type: 'post',
        data: {
            'action': "getRateAndImg",
            'id': id
        },
        type: 'POST',
        success: function (response) {

            // var data = JSON.parse(response);
            // $("#img").attr("src", response);
            $(".showRateAndImage").html(response);
            // console.log(data);

        }
    });
});

$(document).on('click', '.clearUploadImgFrame', function (e) {
    e.preventDefault();

    $('#screenshots img').remove('img');
    // $('.orderDeliveredBtn').prop('disabled', true);
    // $('#but_upload').prop('disabled', true);
});

$(document).on('click', '.orderDeliveredBtn', function (e) {
    e.preventDefault();

    // var imgFileNameCheck = $('.preview img').attr('src');

    //insert image and rating value of customer
    var orderNumber = $('.dupOrderNumber').val();
    var cusRate = $('#appearRate').html();
    var orderID = $('.dupOrderID').val();
    var cusFullname = $('.dupCusName').val();
    var userId = $('.userId').val();
    //base64 decoded url
    var pathCode = $('#screenshots img').attr('src') ?? '';
    //base64 decoded url end

    // console.log(pathCode);

    if (pathCode == ''){
        Swal.fire({
            icon: 'error',
            title: 'Take a photo first!',
            type: 'error'
        })
    }else{

        Swal.fire({
            // title: 'Are you sure?',
            text: "Order delivered?" + ' ' + orderNumber,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "phpAction/shipper_action/shipper_action.php",
                    type: "POST",
                    data: {
                        'action': "updateOStatusForDelivered",
                        'orderNumber': orderNumber,
                        'cusRate': cusRate,
                        'orderID': orderID,
                        'cusFullname': cusFullname,
                        'userId' : userId,
                        'pathCode' : pathCode
                    },
                    success: function (response) {
                        // console.log(response);
                        var data = JSON.parse(response);
    
                        Swal.fire({
                            icon: 'success',
                            title: 'Order successfully delivered',
                            type: 'success'
                        })
                        $('#DeliveredOrCancelledModal').modal('hide')
                        $('#ratingAndUpload').modal('hide')
    
                        $('.badgeCountDispatched').empty();
                        $('.badgeCountForDelivery').empty();
                        $('.badgeCountDispatched').append(data.dispatchCount);
                        $('.badgeCountForDelivery').append(data.deliveryCount);
    
                        showAllDataAndClearInput();
                        stopVideoStream();

    
                    }
                });
            }
        });

    }

});

$(document).on('click', '.close', function (e) {
    e.preventDefault();
    stopVideoStream();

});

$(document).on('click','#changePassModal',function(e) {
    e.preventDefault();

    $('[name="newPassword"]').val('');
    $('[name="confirmPassword"]').val('');
    $('[name="currentPassword"]').val('');

    var id = $("input[name='changePassID']").val();
    

    $.ajax({
        url:'phpAction/shipper_action/shipper_action.php',
        data:{
            'action' : "changePass",
            'id' : id
        },
        'type' : 'POST',
        success: function(response){
            var data = JSON.parse(response);

            // console.log(data);

            $("input[name='userName']").val(data[0].user_username);
        }     
    });
    
});

$(document).on('click','[name="saveChangePass"]',function(e) {
    e.preventDefault();

    var uID = $('[name="changePassID"]').val();
    var newpass = $('[name="newPassword"]').val();
    var connewpass = $('[name="confirmPassword"]').val();
    var currentPassword = $('[name="currentPassword"]').val();

    if(newpass == ''){
        Swal.fire({
            icon: 'error',
            title: 'insert new password!',
            type: 'error'
        })
    }else if(connewpass == ''){
        Swal.fire({
            icon: 'error',
            title: 'insert confirm password!',
            type: 'error'
        })
    }else if(currentPassword == ''){
        Swal.fire({
            icon: 'error',
            title: 'insert current password!',
            type: 'error'
        })
    }
    else if(newpass != connewpass){
        Swal.fire({
            icon: 'error',
            title: 'New password and confirm password not match!',
            type: 'error'
        })
    }else{

        $.ajax({
            url:'phpAction/shipper_action/shipper_action.php',
            data:{
                'action' : 'updateUpassword',
                'uID' : uID,
                'connewpass' : connewpass,
                'currentPassword' : currentPassword
            },
            'type' : 'POST',
            success: function(response){
                var response = JSON.parse(response);

               

                if (response['condition'] == 'error') {

                        Swal.fire({
                        icon: 'error',
                        title: 'invalid current password!',
                        type: 'error'
                    })
                }else if(response['condition'] == 'success'){

                    Swal.fire({
                        title: 'Password update Successfully',
                        type: 'success'
                    })
                    $("#changePasswordModal").modal('hide');

                }
            }     
        });
    }
});

















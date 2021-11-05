$(document).ready(function() {
    
    showAllDataAndClearInput();
});


function showAllDataAndClearInput(){
    showAllDispatchedOrderPerShipper();
    showAllDeliveryOrderDataPerShipper();
    showAllDeliveredOrderPerShipper();
    showAllCancelledOrderPerShipper();
}


function clearAllInput(){
  
}



function showAllDispatchedOrderPerShipper(){
    var shipperId = $('#shipperID').val();

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {'action': "showDispatchOrderDetailsForShipper", 
               'shipperId' : shipperId},

        success:function(response){
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

$(document).on('click','.customer_Order_Info_Btn',function(e) {
    e.preventDefault();

      var orderNumber = $(this).attr('orderNumber');//get input value

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "getCustomerOrderByID", //set an action to trigger , what if condition to be use.
            'orderNumber' : orderNumber
        },
        type: 'POST',
        success: function(response){
            
            $("#showCustomerOrderDetails").html(response);
            $('.dupHubnumber').val(orderNumber);
            
        }
     });
});

$(document).on('click','.customer_Info_Btn',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "getCustomerId", //set an action to trigger , what if condition to be use.
            'id' : id
        },
        type: 'POST',
        success: function(response){
               
                $("#showCustomerDetails").html(response);
                // console.log(data);
        }
     });
});

$(document).on('click','.forDeliveryBtn',function(e) {
    e.preventDefault();
      
    var hubNumber = $('.dupHubnumber').val();

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
            data: {'action' : "updaOStatusForDelivery",
                    'hubNumber' : hubNumber
            },
            success:function(response){
                // console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Order ready to deliver',
                    type: 'success'
                })
                $('#Customer_Order_details_modal').modal('hide')
                showAllDataAndClearInput();

            }
          });
        }
    });

});


function showAllDeliveryOrderDataPerShipper(){

    var userShipperID = $(".userId").val();

    // console.log(userShipperID);

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {action: "showDeliveryOrderDetailsPerShipper", 'userShipperID' : userShipperID},

        success:function(response){
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



$(document).on('click','.deliveredCancelledBtn',function(e) {
    e.preventDefault();

      var orderNumber = $(this).attr('orderNumber');//get input value
      $('.dupOrderNumber').val(orderNumber);
});



$(document).on('click','.orderDeliveredBtn',function(e) {
    e.preventDefault();
    
    var orderNumber = $('.dupOrderNumber').val();

    Swal.fire({
        // title: 'Are you sure?',
        text: "Order delivered?" + ' '+ orderNumber,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: "phpAction/shipper_action/shipper_action.php",
            type: "POST",
            data: {'action' : "updateOStatusForDelivered",
                    'orderNumber' : orderNumber
            },
            success:function(response){
                // console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Order successfully delivered',
                    type: 'success'
                })
                $('#DeliveredOrCancelledModal').modal('hide')
                showAllDataAndClearInput();

            }
          });
        }
    });

});

$(document).on('click','.saveOrderVoid',function(e) {
    e.preventDefault();
    
    var orderNumber = $('.dupOrderNumber').val();
    var voidRemark = $('.voidRemark').val();

    // console.log(orderNumber);
    // console.log(voidRemark);

    if (voidRemark == ''){
        Swal.fire({
            icon: 'error',
            title: 'Remark is empty!',
            type: 'error'
        })
    }else {

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
            data: {'action' : "updateOStatusForVoidedAndRemark",
                    'orderNumber' : orderNumber,
                    'voidRemark' : voidRemark
            },
            success:function(response){

                Swal.fire({
                    icon: 'success',
                    title: 'Order ' + orderNumber + ' cancelled!',
                    type: 'success'
                })
                $('#DeliveredOrCancelledModal').modal('hide')
                showAllDataAndClearInput();

            }
          });
        }
    });
}


});

function showAllDeliveredOrderPerShipper(){
    var shipperId = $('#shipperID').val();

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {'action': "showDeliveredOrderDetailsForShipper", 
               'shipperId' : shipperId},

        success:function(response){
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

function showAllCancelledOrderPerShipper(){
    var shipperId = $('#shipperID').val();

    $.ajax({
        url: "phpAction/shipper_action/shipper_action.php",
        type: "POST",
        data: {'action': "showCancelledOrderDetailsForShipper", 
               'shipperId' : shipperId},

        success:function(response){
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

// <!--===============================================
// Star Rating Code
// ===================================================-->
$(document).on('click','.customerSatisfactionBtn',function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    var fullName = $(this).attr('fullName');

    $('.dupOrderID').val(id);
    $('.dupCustoName').val(fullName);
   
});


$(document).on('click','#fiveStar',function(e) {
    e.preventDefault();
    var rateting = $(this).attr('value');
    $('.getRating').val(rateting);

    var dupOrderID = $('.dupOrderID').val();
    var dupCustoName = $('.dupCustoName').val();
    var getRating = $('.getRating').val();

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "insertCustomerSatisfactionData", //set an action to trigger , what if condition to be use.
            'dupOrderID' : dupOrderID,
            'dupCustoName' : dupCustoName,
            'getRating' : getRating
        },
        type: 'POST',
        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'thank you for rating us!',
                type: 'success'
            })
            $('#customerSatisfactionModal').modal('hide');
        }
     });

});

$(document).on('click','#fourStar',function(e) {
    e.preventDefault();
    var rateting = $(this).attr('value');
    $('.getRating').val(rateting);

    var dupOrderID = $('.dupOrderID').val();
    var dupCustoName = $('.dupCustoName').val();
    var getRating = $('.getRating').val();

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "insertCustomerSatisfactionData", //set an action to trigger , what if condition to be use.
            'dupOrderID' : dupOrderID,
            'dupCustoName' : dupCustoName,
            'getRating' : getRating
        },
        type: 'POST',
        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'thank you for rating us!',
                type: 'success'
            })
            $('#customerSatisfactionModal').modal('hide');
        }
     });

});

$(document).on('click','#threeStar',function(e) {
    e.preventDefault();
    var rateting = $(this).attr('value');
    $('.getRating').val(rateting);

    var dupOrderID = $('.dupOrderID').val();
    var dupCustoName = $('.dupCustoName').val();
    var getRating = $('.getRating').val();

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "insertCustomerSatisfactionData", //set an action to trigger , what if condition to be use.
            'dupOrderID' : dupOrderID,
            'dupCustoName' : dupCustoName,
            'getRating' : getRating
        },
        type: 'POST',
        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'thank you for rating us!',
                type: 'success'
            })
            $('#customerSatisfactionModal').modal('hide');
        }
     });

});

$(document).on('click','#twoStar',function(e) {
    e.preventDefault();
    var rateting = $(this).attr('value');
    $('.getRating').val(rateting);

    var dupOrderID = $('.dupOrderID').val();
    var dupCustoName = $('.dupCustoName').val();
    var getRating = $('.getRating').val();

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "insertCustomerSatisfactionData", //set an action to trigger , what if condition to be use.
            'dupOrderID' : dupOrderID,
            'dupCustoName' : dupCustoName,
            'getRating' : getRating
        },
        type: 'POST',
        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'thank you for rating us!',
                type: 'success'
            })
            $('#customerSatisfactionModal').modal('hide');
        }
     });

});

$(document).on('click','#oneStar',function(e) {
    e.preventDefault();
    var rateting = $(this).attr('value');
    $('.getRating').val(rateting);

    var dupOrderID = $('.dupOrderID').val();
    var dupCustoName = $('.dupCustoName').val();
    var getRating = $('.getRating').val();

    $.ajax({
        url:"phpAction/shipper_action/shipper_action.php",// point to server-side PHP script 
        data: {
            'action' : "insertCustomerSatisfactionData", //set an action to trigger , what if condition to be use.
            'dupOrderID' : dupOrderID,
            'dupCustoName' : dupCustoName,
            'getRating' : getRating
        },
        type: 'POST',
        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'thank you for rating us!',
                type: 'success'
            })
            $('#customerSatisfactionModal').modal('hide');
        }
     });

});

// <!--===============================================
// END Star Rating Code
// ===================================================-->

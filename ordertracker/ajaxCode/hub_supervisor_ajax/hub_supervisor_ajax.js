$(document).ready(function() {

    showAllDataAndClearInput();

    $('input[name="dates"]').daterangepicker();
    
    $(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'right'
      }, function(start, end, label) {
        // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#startDate').val(start.format('MM/DD/YYYY'));
        $('#endDate').val(end.format('MM/DD/YYYY'));
      });
    });
});


 /*=====================================
          Function
 ======================================*/ 
function showAllDataAndClearInput(){
    showAllShipperDataByHub();
    clearAllInput();
    showAllPendingOrderDataPerHub();
    showZipcodeForthisHub();
    showAllDispatchedOrderDataPerHub();
    showAllDeliveryOrderDataPerHub();
    showAllDeliveredOrderPerHub();
    showAllCancelledOrderPerHub();
    // showGraphData();
    showAllNAProdByHub();
    showAReturnOrder();
    
}

function clearAllInput(){
    $('#sFname').val('');//get input value
    $('#sLname').val('');
    $('#sUserName').val('');
    $('#sUPass').val('');
    $('#sUContact').val('');
}

$(document).on('click','#addShipBtn',function(e) {
    clearAllInput();

});

 /*=====================================
   SHOW ALL SHIPPER PER HUB
 ======================================*/ 
 function showAllShipperDataByHub(){

    var hubnumber = $('#suHubnumber').val();
    var urole = $('#suRole').val();

    $.ajax({
        url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
        type: "POST",
        data: {'action' : "viewShipperDataPerHub",
                'hubnumber' : hubnumber,
                'urole' : urole
         },
        success:function(response){
            // console.log(response);
            $("#showShipperAccountPerHub").html(response);
            $('#shipperTableView').DataTable({
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

function showAllPendingOrderDataPerHub(){
    var hubNumber = $('#ugetUserHubNUmber').val();

    $.ajax({
        url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
        type: "POST",
        data: {'action': "showPendingOrderDetailsPerHub", 'hubNumber' : hubNumber},
        success:function(response){
            // console.log(response);
            $("#showCurrentHubPedingOrder").html(response);
            $('#pendingOrderTableViewPerHub').DataTable({
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

function showAllDispatchedOrderDataPerHub(){
    var hubNumber = $('#dugetUserHubNUmber').val();

    $.ajax({
        url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
        type: "POST",
        data: {action: "showDispatchOrderDetailsPerHub", 'hubNumber' : hubNumber},
        success:function(response){
            // console.log(response);
            $("#showCurrentHubDispatchedOrder").html(response);
            $('#dispatchOrderTableViewPerHub').DataTable({
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

function showAllDeliveryOrderDataPerHub(){

    var hubNumber = $(".hubNumber").val();

    // console.log(userShipperID);

    $.ajax({
        url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
        type: "POST",
        data: {action: "showDeliveryOrderDetailsPerHub", 'hubNumber' : hubNumber},

        success:function(response){
            // console.log(response);
            $("#hshowForDeliveryOrder").html(response);

            $('#deliveryOrderTableViewPerHub').DataTable({
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

function showAllDeliveredOrderPerHub(){
    var hubNumber = $('.hubNumber').val();

    $.ajax({
        url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
        type: "POST",
        data: {'action': "hshowDeliveredOrder", 
               'hubNumber' : hubNumber},

        success:function(response){
            // console.log(response);

            $("#hshowDeliveredOrder").html(response);
            $('#hshowDeliveredOrderTableView').DataTable({
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


function showAllCancelledOrderPerHub(){
    var hubNumber = $('.hubNumber').val();

    $.ajax({
        url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
        type: "POST",
        data: {'action': "showCancelledOrderDetailsForPerHub", 
               'hubNumber' : hubNumber},
        success:function(response){
            // console.log(response);

            $("#showCancelledOrder").html(response);
            $('#cancelledOrderTableViewPerHub').DataTable({
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


function showPrepOrder(id,orderNumber){
    $.ajax({
        url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
        data: {
            'action' : "getCustomerOrderByID", //set an action to trigger , what if condition to be use.
            'id' : id,
            'orderNumber' : orderNumber
        },
        type: 'POST',
        success: function(response){
            $('#showCustomerOrderDetails').html(response);

        }
     });
}

function showAllNAProdByHub(){

    var ugetUserHubNUmber = $('#ugetUserHubNUmber').val();

    $.ajax({
        url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
        data: {
            'action' : "getAndShowNAProd", //set an action to trigger , what if condition to be use.
            'ugetUserHubNUmber' : ugetUserHubNUmber
        },
        type: 'POST',
        success: function(response){
            $('#showNAItems').html(response);
            $('#NaProdTable').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                    // dom: 'Bfrtip',
                    // buttons: [
                    //     'csv', 'excel'
                    // ]
            });
        }
     });
}

function showAReturnOrder(){

    var ugetUserHubNUmber = $('#ugetUserHubNUmber').val();

    $.ajax({
        url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
        data: {
            'action' : "getReturnOrderDetails", //set an action to trigger , what if condition to be use.
            'ugetUserHubNUmber' : ugetUserHubNUmber
        },
        type: 'POST',
        success: function(response){
            $('#showReturnHistory').html(response);
            $('#returnOrderTableView').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                    // dom: 'Bfrtip',
                    // buttons: [
                    //     'csv', 'excel'
                    // ]
            });
        }
     });
}

$(document).on('click','.getNAProdById',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

    $.ajax({
        url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
        data: {
            'action' : "getTheNAProd", //set an action to trigger , what if condition to be use.
            'id' : id
        },
        type: 'POST',
        success: function(response){

                $("#showNAProdName").html(response);
               
        }
     });
});



$(document).on('click','#generateBtnByYear',function(e) {
    e.preventDefault();

    var yearFilter = $('#datepicker').val();
    var hubArea = $('#ugetUserHubNUmberForGraph').val();
    
    // console.log(yearFilter);
    if (yearFilter == ''){
        Swal.fire({
            icon: 'error',
            title: 'insert Year',
            type: 'error'
        })
    }else{
        $.ajax({
            url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
            data: {
                'action' : "filterGraphByYear", //set an action to trigger , what if condition to be use.
                'yearFilter' : yearFilter,
                'hubArea' : hubArea
            },                         
            type: 'POST',
            success: function(response){
                var data = JSON.parse(response);
                //   console.log(data);
                var data = JSON.parse(response);
            // console.log(data);
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',
                // The data for our dataset
                data: {
                    datasets: [
                        {
                        label: 'delivered',
                        backgroundColor: 'rgb(0,128,0)',
                        borderColor: 'rgb(0,128,0)',
                        data: [data[0][1], data[0][2],data[0][3],data[0][4],data[0][5],data[0][6],data[0][7],data[0][8],data[0][9],data[0][10],data[0][11],data[0][12]]
                    }, {
                        label: 'voided',
                        backgroundColor: 'rgb(255,0,0)',
                        borderColor: 'rgb(255,0,0)',
                        data: [data[1][1], data[1][2],data[1][3],data[1][4],data[1][5],data[1][6],data[1][7],data[1][8],data[1][9],data[1][10],data[1][11],data[1][12]],
            
                        // Changes this dataset to become a line
                        type: 'bar'
                    }],
                    labels: ['Jan' + ' ' +yearFilter, 'Feb' + ' ' +yearFilter, 'Mar' + ' ' +yearFilter, 'April' + ' ' +yearFilter,'May' + ' ' +yearFilter,'June' + ' ' +yearFilter,'July' + ' ' +yearFilter,'Aug' + ' ' +yearFilter,'Sep' + ' ' +yearFilter,'Oct' + ' ' +yearFilter,'Nov' + ' ' +yearFilter,'Dec' + ' ' +yearFilter]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            }
         });
    }
});

/*=====================================
        END GRAPH CODE
 ======================================*/ 



 /*=====================================
          INSERT SHIPPER ACCOUNT DATA AJAX
 ======================================*/ 
 $(document).on('click','#addShipperAccount',function(e) {
    e.preventDefault();

    var fname = $('#sFname').val();//get input value
    var lname = $('#sLname').val();
    var uname = $('#sUserName').val();
    var upass = $('#sUPass').val();
    var ucontact = $('#sUContact').val();
    var urole = $('#suRole').val();
    var suhubnumber = $('#suHubnumber').val();
    
    
    var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;


    if ($('#sFname').val() == '' && $('#sLname').val() == '' && $('#sUserName').val() == '' && $('#sUPass').val() == '' && $('#sUContact').val() == ''){
        Swal.fire({
            icon: 'error',
            title: 'all field is empty',
            type: 'error'
        })
    } else if ($('#sFname').val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'first name is empty',
            type: 'error'
        })
    } else if ($('#sLname').val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'last name is empty',
            type: 'error'
        })
    } else if ($('#sUserName').val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'user name is empty',
            type: 'error'
        })
    } else if ($('#sUPass').val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'password is empty',
            type: 'error'
        })
    } else if ($('#sUContact').val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Contact number is empty',
            type: 'error'
        })
    }  else if (!numericReg.test(ucontact)) {
        Swal.fire({
            icon: 'error',
            title: 'input numeric value only in Contact',
            type: 'error'
        })
        $('#sUContact').val('');
    } else {

        $.ajax({
            url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
            data: {
                'action' : "insertShipperAccount", //set an action to trigger , what if condition to be use.
                'fname' : fname,
                'lname' : lname,
                'uname' : uname,
                'upass' : upass,
                'ucontact' : ucontact,
                'urole' : urole,
                'suhubnumber' : suhubnumber
            },            
            type: 'POST',
            success: function(response){
                response = JSON.parse(response);

                if (response['condition'] == 'userExist') {

                    Swal.fire({
                    icon: 'error',
                    title: 'User already Exist!',
                    type: 'error'
                })
                }

                else if (response['condition'] == 'success') {
                    Swal.fire({
                    icon: 'success',
                    title: 'User add Successfully',
                    type: 'success'
                })
                $("#addShipperModal").modal('hide');
                showAllDataAndClearInput();

                }

            }
        });
    
    }
});

     /*=====================================
            Delete Shipper
 ======================================*/ 
    $("body").on("click", ".shipperDelBtn", function(e){
        e.preventDefault();
       
        var id = $(this).attr('id');
    
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
                type: "POST",
                data: {'action' : "deleteShipperDetails",
                        'id' : id
                },
                success:function(response){
                    // console.log(response);
                    Swal.fire(
                        'Deleted!',
                        'Hub Deleted Successfully!',
                        'success'
                    )
                    showAllDataAndClearInput();
                }
              });
            }
        });
    });


     /*=====================================
            edit shipper details and fetch to modal
 ======================================*/ 
    $(document).on('click','.shipperEditBtn',function(e) {
        e.preventDefault();
    
          var id = $(this).attr('id');//get input value
    
        $.ajax({
            url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
            data: {
                'action' : "getShipperDetailsById", //set an action to trigger , what if condition to be use.
                'id' : id
            },
            type: 'POST',
            success: function(response){
                    data = JSON.parse(response);

                    $('#addShipperId').val(data.id);//get input value
                    $('#esFname').val(data.first_name);//get input value
                    $('#esLname').val(data.last_name);
                    $('#esUserName').val(data.user_username);
                    $('#esUPass').val(data.user_password);
                    $('#esUContact').val(data.user_contact_number);   

                    
            }
         });
    });

        /*=====================================
            udpate shipper details
 ======================================*/ 
    $(document).on('click','#EditaddShipperAccount',function(e) {
        e.preventDefault();
    
          var id = $('#addShipperId').val();//get input value
          var fname = $('#esFname').val();//get input value
          var lname = $('#esLname').val();
          var uname = $('#esUserName').val();
          var upass = $('#esUPass').val();
          var ucontact = $('#esUContact').val();   

          var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;

          if ($('#esFname').val() == '' && $('#esLname').val() == '' && $('#esUserName').val() == '' && $('#esUPass').val() == '' && $('#esUContact').val() == ''){
            Swal.fire({
                icon: 'error',
                title: 'all field is empty',
                type: 'error'
            })
        }else if ($('#esFname').val() == '') {
            Swal.fire({
                icon: 'error',
                title: 'first name is empty',
                type: 'error'
            })
        } else if ($('#esLname').val() == '') {
            Swal.fire({
                icon: 'error',
                title: 'last name is empty',
                type: 'error'
            })
        }else if ($('#esUserName').val() == '') {
            Swal.fire({
                icon: 'error',
                title: 'user name is empty',
                type: 'error'
            })
        }else if ($('#esUPass').val() == '') {
            Swal.fire({
                icon: 'error',
                title: 'password is empty',
                type: 'error'
            })
        }else if ($('#esUContact').val() == '') {
            Swal.fire({
                icon: 'error',
                title: 'Contact number is empty',
                type: 'error'
            })
        }  else if (!numericReg.test(ucontact)) {
            Swal.fire({
                icon: 'error',
                title: 'input numeric value only in Contact',
                type: 'error'
            })
            $('#esUContact').val('');
        }else {

            $.ajax({
                url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
                data: {
                    'action' : "updateShipperDetails", //set an action to trigger , what if condition to be use.
                    'id' : id,
                    'fname' : fname,
                    'lname' : lname,
                    'uname' : uname,
                    'upass' : upass,
                    'ucontact' : ucontact
                },            
                type: 'POST',
                success: function(response){
                        Swal.fire({
                            icon: 'success',
                            title: 'Shipper Details Update Successfully',
                            type: 'success'
                        })
                        $("#EditaddShipperModal").modal('hide');
                    showAllDataAndClearInput();
                }
             });

        }
    });


    $(document).on('click','.customer_Order_Info_Btn',function(e) {
        e.preventDefault();
          var orderNumber = $(this).attr('orderNumber');//get input value
    
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "getCustomerOrderByID", //set an action to trigger , what if condition to be use.
                'orderNumber' : orderNumber
            },
            type: 'POST',
            success: function(response){
                $("#showCustomerOrderDetails").html(response);

                    if($('.fOrderStatus').val() == 'for checking' || 
                    $('.fOrderStatus').val() == 'transit' || 
                    $('.fOrderStatus').val() == 'paid' || 
                    $('.fOrderStatus').val() == 'voided'){
                    
                    $('.disArmTheRemoveAction-and-pointer').removeClass('dontShowNotAvailableItem');
                    $('.disArmTheRemoveAction-and-pointer').removeClass('pointer');
                    
                }else{
                    $('.disArmTheRemoveAction-and-pointer').addClass('dontShowNotAvailableItem');
                    $('.disArmTheRemoveAction-and-pointer').addClass('pointer');
                }

            }
         });
    });


    $(document).on('click','.adminShipperBtn',function(e) {
        e.preventDefault();
        $('#Customer_Order_details_modal').modal('hide');

        var shipperHubNumber = $('.getHubNumber').val();
        var OrderNumber = $('.rgetOrderNumber').val();
        var OrderId = $('.rgetOrderId').val();

        var userID = $('#ugetUserID').val();
        var naProductName = $('.naProductName').val();
    
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "getHubShipper", //set an action to trigger , what if condition to be use.
                'shipper' : shipperHubNumber,
                'userID' : userID,
                'naProductName' : naProductName,
                'OrderNumber' : OrderNumber
            },
            type: 'POST',
            success: function(response){
                
                $("#showAllShipperDetails").html(response);

                $('#copyHubNumber').val(shipperHubNumber);
                $('#rcopyOrderNumber').val(OrderNumber);
                $('#rcopyOrderId').val(OrderId);
                $('#naProducts').val(naProductName);
                
            }
         });
    
       
    });


    $(document).on('click','.updateOrderByshipper',function(e) {
        e.preventDefault();
        
        var shipperName = $('#getShipperName').val();
        var copyOrderNumber = $('#rcopyOrderNumber').val();
        var copyOrderId = $('#rcopyOrderId').val();
        var ugetUserHubNUmber = $('#ugetUserHubNUmber').val();
        var naProducts = $('#naProducts').val();
        var ugetUserID = $('#ugetUserID').val();
        
        if (shipperName == 'Choose Shipper'){
            Swal.fire({
                icon: 'error',
                title: 'Insert shipper name',
                type: 'error'
            })
        }else {
            
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "updateTheOrderByShipper", //set an action to trigger , what if condition to be use.
                'shipperName' : shipperName,
                'copyOrderNumber' : copyOrderNumber,
                'copyOrderId' : copyOrderId,
                'ugetUserHubNUmber' : ugetUserHubNUmber,
                'naProducts' : naProducts,
                'ugetUserID' : ugetUserID
                
            },
            type: 'POST',
            success: function(response){

                var data = JSON.parse(response);

                // console.log(data);

                $('.pendingDataCount').empty();
                $('.checkingDataCount').empty();
                $('.deliveryDataCount').empty();

                $('.pendingDataCount').append(data.pendingCount);
                $('.checkingDataCount').append(data.checkingCount);
                $('.deliveryDataCount').append(data.deliveryCount);

                Swal.fire({
                    icon: 'success',
                    title: 'Order Successfully Dispatch!',
                    type: 'success'
                })
                $('#assign_modal').modal('hide');
                showAllDataAndClearInput();
            }
         });
        }
        // console.log(shipperName);
        // console.log(copyHubNumber);
    });

    
    $(document).on('click','.customer_Info_Btn',function(e) {
        e.preventDefault();
    
          var id = $(this).attr('id');//get input value
    
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
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

    function showZipcodeForthisHub(){

        var hubSelectorForZipCode = $('#ugetUserHubNUmber').val();
        
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "showZipcodePerHub", //set an action to trigger , what if condition to be use.
                'hubSelectorForZipCode' : hubSelectorForZipCode 
            },
            type: 'POST',
            success: function(response){
                    $("#showZip").html(response);
            }
         });
    }


    $(document).on('click','.cancel_order_Btn',function(e) {
        e.preventDefault();
        $('#dupInsertOrderNumber').html('');
        var orderNum = $(this).attr('orderNumber');//get input value
        $('#dupInsertOrderNumber').append(orderNum);
        $('.orderNumberInput').val(orderNum);
        $('.orderCancelRemark').val('');
    
    });


    $(document).on('click','.saveCancelOrderBtn',function(e) {
        e.preventDefault();

        var orderNum = $('.orderNumberInput').val();//get input value
        var remarks = $('.orderCancelRemark').val();//get input valued
        var ugetUserHubNUmber = $('#ugetUserHubNUmber').val();

        // console.log(orderNum);
        // console.log(remarks);

        $.ajax({
            url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
            data: {
                'action' : "cancelAndupdateOrderNumber", //set an action to trigger , what if condition to be use.
                'orderNum' : orderNum,
                'remarks' : remarks,
                'ugetUserHubNUmber' : ugetUserHubNUmber
            },            
            type: 'POST',
            success: function(response){
                var response = JSON.parse(response);
    
                if (response['condition'] == 'error') {
                    Swal.fire({
                    title: 'Remarks is empty!',
                    type: 'error'
                })
                }else if (response['condition'] == 'success') {

                    $('.pendingDataCount').empty();
                    $('.checkingDataCount').empty();
                    $('.deliveryDataCount').empty();

                    $('.pendingDataCount').append(response.pendingCount);
                    $('.checkingDataCount').append(response.checkingCount);
                    $('.deliveryDataCount').append(response.deliveryCount);

                    Swal.fire({
                        icon: 'success',
                        title: 'Order number' + ' ' + orderNum + ' ' + 'cancelled!',
                        type: 'success'
                    })
                    
                    $('#cancelOrdermodal').modal('hide');
                    showAllDataAndClearInput();
                }
            }
         });
     
    });

//select lng nung pwede na ideliver.
    $(document).on('click','.dontShowNotAvailableItem',function(e) {
        e.preventDefault();
        
        var id = $(this).attr('id');
        var prodName = $(this).attr('prodName');//get input value
        var orderNumber = $(this).attr('orderNumber');
        
        // alert (id + ' ' + prodName + ' ' + orderNumber);

        Swal.fire({
            title: prodName,
            text: "not available?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
                type: "POST",
                data: {'action' : "getCustomerOrderByID",
                        'id' : id,
                        'orderNumber ' : orderNumber
                },
                success:function(response){
                    // console.log(response);
                    Swal.fire(
                        prodName + ' ' + 'Deleted Successfully!',
                        'success'
                    )
                    showAllDataAndClearInput();
                    clearAllInput();
                    showPrepOrder(id,orderNumber);
                }
              });
            }
        });
    });

    $(document).on('click','#generateBtn',function(e) {
        e.preventDefault();
     
        var hubnumber = $('#ugetUserHubNUmber').val();
        var orderStatus = $('.fOrderStatus').val();
        var dateStartAndEnd = $('#dateStartAndEnd').val();
        var zipCode = $('.showZipByHub').val();

        // console.log(hubnumber) + '<br/>';
        // console.log(orderStatus) + '<br/>';
        // console.log(dateStartAndEnd) + '<br/>';
        // console.log(zipCode) + '<br/>';

        $.ajax({
            url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
            data: {
                'action' : "filterAction", //set an action to trigger , what if condition to be use.
                'hubnumber' : hubnumber,
                'orderStatus': orderStatus,
                'dateStartAndEnd' : dateStartAndEnd,
                'zipCode' : zipCode
            },                       
            type: 'POST',
            success: function(response){
                   
                $("#showCurrentHubPedingOrder").html(response);
                $('#OrderTableViewPerHub').DataTable({
                    order: [0, 'desc'] //use this to make the the appear the current record in the top
                        // dom: 'Bfrtip',
                        // buttons: [
                        //     'csv', 'excel'
                        // ]
                });

                if (orderStatus == 'for checking' || orderStatus == 'transit' || orderStatus == 'paid' || orderStatus == 'voided'){
                    $('.adminShipperBtn').css("display","none");
                }
                if (orderStatus == 'pending'){
                    $('.adminShipperBtn').css("display","");
                }

                // console.log(response);
            }
         });
    });

    $(document).on('click', '.customer_rateImg_info', function (e) {
        e.preventDefault();
    
        var id = $(this).attr('id');
    
        // console.log(id);
        $.ajax({
            url: 'phpAction/shipper_action/shipper_action.php',
            type: 'post',
            data: {'action' : "getRateAndImg",
                    'id' : id
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

    $(document).on('click', '.orderProgressDetails', function (e) {
        e.preventDefault();
    
        var ordernumber = $(this).attr('ordernumber');
        var ahubareanum = $(this).attr('ahubareanum');
        var shipperid = $(this).attr('shipperid');

        // console.log(shipperid);

        $.ajax({
            url: 'phpAction/hub_supervisor_action/hub_supervisor_action.php',
            type: 'post',
            data: {'action' : "getOrderDetails",
                    'ordernumber' : ordernumber,
                    'ahubareanum' : ahubareanum,
                    'shipperid' : shipperid
            },
            type: 'POST',
            success: function (response) {
                    $(".showProgress").html(response);
            }
        });

    });

    $(document).on('click', '.orderProgressDetailsVoided', function (e) {
        e.preventDefault();
    
        var ordernumber = $(this).attr('ordernumber');
        var ahubareanum = $(this).attr('ahubareanum');
        var shipperid = $(this).attr('shipperid');

        // console.log(shipperid);

        $.ajax({
            url: 'phpAction/hub_supervisor_action/hub_supervisor_action.php',
            type: 'post',
            data: {'action' : "getOrderDetailsForVoided",
                    'ordernumber' : ordernumber,
                    'ahubareanum' : ahubareanum,
                    'shipperid' : shipperid
            },
            type: 'POST',
            success: function (response) {
                    $(".showProgressVoided").html(response);
            }
        });

    });

    $(document).on('click','#changePassModal',function(e) {
        e.preventDefault();


        $('[name="newPassword"]').val('');
        $('[name="confirmPassword"]').val('');
        $('[name="currentPassword"]').val('');

        var id = $("input[name='changePassID']").val();
        
    
        $.ajax({
            url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',
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
                url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',
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

    $(document).on('click','.return_tohub_Btn',function(e) {
        e.preventDefault();

        $('#dupInsertOrderNumberToReturnOrder').html('');
        $('.shippingAddress').html('');
        $('.billingAddress').html('');

        var orderNum = $(this).attr('orderNumber');
        var addressOne = $(this).attr('addressOne');
        var addressTwo = $(this).attr('addressTwo');//get input value

        $('#dupInsertOrderNumberToReturnOrder').append(orderNum);
        $('.shippingAddress').append(addressOne);
        $('.billingAddress').append(addressTwo);

        $('.orderNumberInputToReturnOrder').val(orderNum);
        $('.orderCancelRemarkToReturnOrder').val('');
    
    });

    $(document).on('click','.returnOrderBtn',function(e) {
        e.preventDefault();

        var orderNumber = $('.orderNumberInputToReturnOrder').val();
        var remarks = $('.orderCancelRemarkToReturnOrder').val();

        if (remarks == ""){
            Swal.fire({
                title: 'Remarks is empty!',
                type: 'success'
            })
        }else{

            $.ajax({
                url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',
                data:{
                    'action' : "saveReturnOrder",
                    'orderNumber' : orderNumber,
                    'remarks' : remarks
                },
                'type' : 'POST',
                success: function(response){
                    Swal.fire({
                        title: 'Order successfully returned!',
                        type: 'success'
                    })
                    showAllPendingOrderDataPerHub();
                    $('#returnOrdermodal').modal('hide');
                }     
            });

        }
    });




    
 








$(document).ready(function() {
    
    showAllDataAndClearInput();
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
        alert('all field is empty');
    } else if ($('#sFname').val() == '') {

        alert('first name is empty');
    } else if ($('#sLname').val() == '') {

        alert('last name is empty');
    } else if ($('#sUserName').val() == '') {

        alert('user name is empty');
    } else if ($('#sUPass').val() == '') {

        alert('password is empty');
    } else if ($('#sUContact').val() == '') {

        alert('Contact number is empty');
    }  else if (!numericReg.test(ucontact)) {

        alert('input numeric value only in Contact');
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
    });
    

    function showAllPendingOrderDataPerHub(){
        var hubNumber = $('#ugetUserHubNUmber').val();

        $.ajax({
            url: "phpAction/hub_supervisor_action/hub_supervisor_action.php",
            type: "POST",
            data: {action: "showPendingOrderDetailsPerHub", 'hubNumber' : hubNumber},
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
            }
         });
    });



    $(document).on('click','.adminShipperBtn',function(e) {
        e.preventDefault();
        $('#Customer_Order_details_modal').modal('hide')
        var shipperHubNumber = $('.getHubNumber').val();
        var OrderNumber = $('.rgetOrderNumber').val();
    
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "getHubShipper", //set an action to trigger , what if condition to be use.
                'shipper' : shipperHubNumber
            },
            type: 'POST',
            success: function(response){
                
                $("#showAllShipperDetails").html(response);
                $('#copyHubNumber').val(shipperHubNumber);
                $('#rcopyOrderNumber').val(OrderNumber);
            }
         });
    
       
    });


    $(document).on('click','.updateOrderByshipper',function(e) {
        e.preventDefault();
        
        var shipperName = $('#getShipperName').val();
        var copyOrderNumber = $('#rcopyOrderNumber').val();
        
    
        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "updateTheOrderByShipper", //set an action to trigger , what if condition to be use.
                'shipperName' : shipperName,
                'copyOrderNumber' : copyOrderNumber
            },
            type: 'POST',
            success: function(response){
                Swal.fire({
                    icon: 'success',
                    title: 'Order Successfully Dispatch!',
                    type: 'success'
                })
                $('#assign_modal').modal('hide');
                showAllDataAndClearInput();
            }
         });
    
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

    $(document).on('change','.showZipByHub',function(e) {
        var zipCodeFilter = $('.showZipByHub').val();
        var hubnumber = $('#ugetUserHubNUmber').val();
        
        // console.log(zipCodeFilter);

        $.ajax({
            url:"phpAction/hub_supervisor_action/hub_supervisor_action.php",// point to server-side PHP script 
            data: {
                'action' : "showZipcodePerHubFiltered", //set an action to trigger , what if condition to be use.
                'zipCodeFilter' : zipCodeFilter ,
                'hubnumber' : hubnumber
            },
            type: 'POST',
            success: function(response){
                   
                    $("#showCurrentHubPedingOrder").html(response);
                    $('#pendingOrderTableViewPerHub').DataTable({
                        order: [0, 'desc'] //use this to make the the appear the current record in the top
                            // dom: 'Bfrtip',
                            // buttons: [
                            //     'csv', 'excel'
                            // ]
                    });
                    // console.log(response);
            }
         });
    });


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







$(document).ready(function() {
    showAllData();
    // $('#addAcctTableView').DataTable();
    // $('#hubTableView').DataTable();

});

//disable submit when you press enter keyboard
$("#addHubModal").on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
});

//disable submit when you press enter keyboard
$("#editHubModal").on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
});


/*=====================================
        FUNCTION AREA
 ======================================*/ 
function showAllData(){
    show_All_Hub_In_DropDown();
    show_All_Account_In_Table();
    showAllHubData();
    edit_show_All_Hub_In_DropDown();
    show_All_Hub_In_Import();
    showAllOrderData();
    showAllDispatchedOrderData();
    showAllForDeliveryOrderDataHub();
    showAllForDeliveredOrderDataHub();
    showAllCancelledOrderPerShipper();
}



function clearAllInput(){
    $('#hubNumber').val('');
    $('#fName').val('');//get input value
    $('#lName').val('');
    $('#uName').val('');
    $('#uPass').val('');
    $('#uContact').val('');
    $('#uRole').val('Choose...');
    $('#userHubNumber').val('Choose...');
    clearZipInput();
}

function clearZipInput(){

    $('.inputZipcode').tagsinput('removeAll');

}

$(document).on('click','.close',function(e) {

    $('.inputZipcode').tagsinput('removeAll');
});

$(document).on('click','.addHubBtnTop',function(e) {

    clearAllInput();
    showAllData();

});



/*============================================================
                        HUB NUMBER CODE
===============================================================*/
function showAllHubData(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "viewHubData"},
        success:function(response){
            // console.log(response);
            $("#showHubData").html(response);
            $('#hubTableView').DataTable({
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
/*============================================================
                        Show all order
===============================================================*/
function showAllOrderData(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "showOrderDetails"},
        success:function(response){
            // console.log(response);
            $("#showManageOrderHere").html(response);
            $('#orderTableView').DataTable({
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
                EVENT AREA
 ======================================*/ 
 /*=====================================
          ADD HUB MODAL INSERT AJAX
 ======================================*/ 
$(document).on('click','#add_HubNumber',function(e) {
    e.preventDefault();

    var hubNumber = $('#hubNumber').val();//get input value
    var hubZipcode = $(".inputZipcode").val();

    
    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "addHubNumber", //set an action to trigger , what if condition to be use.
            'hubNumber' : hubNumber,
            'hubZipcode' : hubZipcode
        },            
        type: 'POST',
        success: function(response){
            response = JSON.parse(response);

            if (response['condition'] == 'error') {

                Swal.fire({
                icon: 'error',
                title: 'Hub already exist!',
                type: 'error'
            })
            // $("#addHubModal").modal('hide');
            showAllData();
            // clearAllInput();

            }

            else if (response['condition'] == 'empty') {
                Swal.fire({
                icon: 'error',
                title: 'Insert Hub',
                type: 'error'
            })
            // $("#addHubModal").modal('hide');
            showAllData();
            // clearAllInput();
                  
            }
            else if (response['condition'] == 'emptyZipCode') {
                Swal.fire({
                icon: 'error',
                title: 'Enter Zip code',
                type: 'error'
            })
            // $("#addHubModal").modal('hide');
            showAllData();
            // clearAllInput();
                  
            }
            else if (response['condition'] == 'success') {
                Swal.fire({
                icon: 'success',
                title: 'Hub add successfully',
                type: 'success'
            })
            $("#addHubModal").modal('hide');
            showAllData();
            clearAllInput();
                  
            }

        }
     });
});


 /*=====================================
          DELETE HUB AJAX
 ======================================*/ 
$("body").on("click", ".delHubBtn", function(e){
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
            url: "phpAction/admin_action/admin_action.php",
            type: "POST",
            data: {'action' : "deleteHub",
                    'id' : id
            },
            success:function(response){
                // console.log(response);
                Swal.fire(
                    'Deleted!',
                    'Hub Deleted Successfully!',
                    'success'
                )
                showAllData();
                clearAllInput();
            }
          });
        }
    });
});

 /*===============================================
          Fetch data HUB into #editHubModal AJAX
 ==================================================*/ 
$(document).on('click','.updateHubBtn',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "getHubDetailsById", //set an action to trigger , what if condition to be use.
            'id' : id
        },
        type: 'POST',
        success: function(response){
                data = JSON.parse(response);
                $("#id_HubNumber").val(data.id);
                $("#edit_Hub_Number").val(data.hub_area);

                $('.editInputZipcode').tagsinput('removeAll');
                $(".editInputZipcode").tagsinput('add', data.zip_code);
        }
     });
});




/*===============================================
         udpate hub details by id AJAX
 ==================================================*/ 
$(document).on('click','#insert_Edit_Hub_Number',function(e) {
    e.preventDefault();

    var hubId = $('#id_HubNumber').val();//get input value
    var hubNumber = $('#edit_Hub_Number').val();
    
    var editInputZipcode =  $(".editInputZipcode").val();
   
    // console.log(hubNumber);
    // console.log(hubId);

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "updateHubDetail", //set an action to trigger , what if condition to be use.
            'hubId' : hubId,
            'hubNumber' : hubNumber,
            'editInputZipcode' : editInputZipcode
        },            
        type: 'POST',
        success: function(response){
            console.log(response);
                Swal.fire({
                    title: 'Hub Update Successfully',
                    type: 'success'
                })
                $("#editHubModal").modal('hide');
                showAllData();
                // clearAllInput();
        }
     });
});


/*============================================================
                      END HUB NUMBER CODE
===============================================================*/




/*============================================================
                        ADD ACCOUNT CODE
===============================================================*/
/*========================================================
         GET DATA AND FETCH INTO  showAccountArea DROP DOWN
 ==========================================================*/ 
 function show_All_Hub_In_DropDown(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "viewHubDataInDropDown"},
        success:function(response){

            $("#showAccountArea").html(response);
            
        }
    });
}

function edit_show_All_Hub_In_DropDown(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "editViewHubDataInDropDown"},
        success:function(response){

            $("#editShowAccountArea").html(response);
            
        }
    });
}

/*========================================================
         GET DATA AND FETCH INTO  import DROP DOWN tatak
 ==========================================================*/
 function show_All_Hub_In_Import(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "importDropdown"},
        success:function(response){

            $("#showHubdetailsForImport").html(response);
            
        }
    });
}


/*========================================================
         GET DATA AND FETCH INTO  showAccountData
 ==========================================================*/ 
function show_All_Account_In_Table(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "viewAccountData"},
        success:function(response){

            $("#showAccountData").html(response);
            $('#addAcctTableView').DataTable({order: [0, 'desc']});
        }
    });
}

/*========================================================
         clear data
 ==========================================================*/ 

$(document).on('click','#dAddAccountInput',function(e) {
    clearAllInput();
});
 /*=====================================
          INSERT ACCOUNT DATA AJAX
 ======================================*/ 
 $(document).on('click','#insertAccount',function(e) {
    e.preventDefault();

    var fname = $('#fName').val();//get input value
    var lname = $('#lName').val();
    var uname = $('#uName').val();
    var upass = $('#uPass').val();
    var ucontact = $('#uContact').val();
    var urole = $('#uRole').val();
    var uhubnumber = $('#userHubNumber').val();

    var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;


    if ($('#fName').val() == '' && $('#lName').val() == '' && $('#uName').val() == '' && $('#uPass').val() == '' && $('#uContact').val() == '' && $('#uRole').val() == 'Choose...' && $('#userHubNumber').val() == 'Choose...')
    {
        // alert('all field is empty');
        Swal.fire({
            icon: 'error',
            title: 'All field is empty',
            type: 'error'
        })
    } else if ($('#fName').val() == '') {

        // alert('first name is empty');
        Swal.fire({
            icon: 'error',
            title: 'First name is empty',
            type: 'error'
        })
    } else if ($('#lName').val() == '') {

        // alert('last name is empty');
        Swal.fire({
            icon: 'error',
            title: 'Last name is empty',
            type: 'error'
        })
        
    } else if ($('#uName').val() == '') {

        // alert('user name is empty');
        Swal.fire({
            icon: 'error',
            title: 'User name is empty',
            type: 'error'
        })
    } else if ($('#uPass').val() == '') {

        // alert('password is empty');
        Swal.fire({
            icon: 'error',
            title: 'Password is empty',
            type: 'error'
        })
    } else if ($('#uContact').val() == '') {

        // alert('Contact number is empty');
        Swal.fire({
            icon: 'error',
            title: 'Contact number is empty',
            type: 'error'
        })
    } else if ($('#uRole').val() == 'Choose...') {
        
        // alert('User Role is empty');
        Swal.fire({
            icon: 'error',
            title: 'User Role is empty',
            type: 'error'
        })
    } else if ($('#userHubNumber').val() == 'Choose...') {

        // alert('User Hub Number is empty');
        Swal.fire({
            icon: 'error',
            title: 'User Hub Number is empty',
            type: 'error'
        })
    } else if (!numericReg.test(ucontact)) {

        // alert('input numeric value only in Contact');
        Swal.fire({
            icon: 'error',
            title: 'Input numeric value only in Contact',
            type: 'error'
        })
        $('#uContact').val('');
    } else if ($('#inputZipcode').val() == '') {

        Swal.fire({
            icon: 'error',
            title: 'Insert hub covered zipcode',
            type: 'error'
        })
    }
    else {

        $.ajax({
            url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
            data: {
                'action' : "insertAccount", //set an action to trigger , what if condition to be use.
                'fname' : fname,
                'lname' : lname,
                'uname' : uname,
                'upass' : upass,
                'ucontact' : ucontact,
                'urole' : urole,
                'uhubnumber' : uhubnumber
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
                $("#addAccountModal").modal('hide');
                showAllData();
                clearAllInput();
                }

            }
        });
    }
    
});



 /*==========================================================
          Fetch data Account into #editAddAccountModal AJAX
 ============================================================*/ 

 $(document).on('click','.editAccountBtn',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "getAccountDetailsById", //set an action to trigger , what if condition to be use.
            'id' : id
        },
        type: 'POST',
        success: function(response){
                data = JSON.parse(response);
                
                $('#editAccountId').val(data.id);
                $('#efName').val(data.first_name);
                $('#elName').val(data.last_name);
                $('#euName').val(data.user_username);
                $('#euPass').val(data.user_password);
                $('#euContact').val(data.user_contact_number);
                $('#euRole').val(data.user_role);
                $('#euserHubNumber').val(data.hub_area);
        }
     });
});


$(document).on('click','#editInsertAccount',function(e) {
    e.preventDefault();

    var id = $('#editAccountId').val();//get input value
    var fname =  $('#efName').val();
    var lname = $('#elName').val();
    var uname =  $('#euName').val();
    var upass = $('#euPass').val();
    var ucontact = $('#euContact').val();
    var urole = $('#euRole').val();
    var uhubnumber = $('#euserHubNumber').val();

    
    // console.log(id);
    // console.log(fname);
    // console.log(lname);
    // console.log(uname);
    // console.log(upass);
    // console.log(ucontact);
    // console.log(urole);
    // console.log(uhubnumber);


    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "editUpdateAccountDetail", //set an action to trigger , what if condition to be use.
            'id' : id,
            'fname' : fname,
            'lname' : lname,
            'uname' : uname,
            'upass' : upass,
            'ucontact' : ucontact,
            'urole' : urole,
            'uhubnumber' : uhubnumber
        },            
        type: 'POST',
        success: function(response){
                Swal.fire({
                    icon: 'success',
                    title: 'Account Update Successfully',
                    type: 'success'
                })
                $("#editAddAccountModal").modal('hide');
                showAllData();
                clearAllInput();

                // console.log(response);

        }
     });
    
});


 /*=====================================
          Delete Account AJAX
 ======================================*/ 
 $("body").on("click", ".delAccountBtn", function(e){
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
            url: "phpAction/admin_action/admin_action.php",
            type: "POST",
            data: {'action' : "deleteAccount",
                    'id' : id
            },
            success:function(response){
                // console.log(response);
                Swal.fire(
                    'Deleted!',
                    'Account Deleted Successfully!',
                    'success'
                )
                showAllData();
                clearAllInput();
            }
          });
        }
    });
});



 /*=====================================
          IMPORTING Excel CODE
 ======================================*/ 
 $("#btn-import-driver").click(function() {

    var file_data = $('#input-import-driver').prop('files')[0];   
    var form_data = new FormData();
    var importHubNumber = $('#importHubNumber').val();
    var action = "insertExcel";

    form_data.append('file', file_data);
    form_data.append('action', action);
    form_data.append('importHubNumber', importHubNumber);
    
    // console.log(form_data);   
    
    $.ajax({
        url: 'phpAction/admin_action/admin_action.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,              
        type: 'POST',

        success: function(response) {
            
            var response = JSON.parse(response);

            
            if (response['type'] == 'success') {
                Swal.fire({
                    icon: 'success',
                    text: response['msg'],
                }).then(function(){
                    window.location.reload();
                });
            } else if (response['type'] == 'insertHubNumber'){
                
                     Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                })
            }
            else if (response['type'] == 'error'){
                Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                })
            }
        
        }
    
     });
});


$(document).on('click','.customer_Info_Btn',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
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

$(document).on('click','.customer_Order_Info_Btn',function(e) {
    e.preventDefault();

      var orderNumber = $(this).attr('orderNumber');//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
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


// point to server-side PHP script Current coding

$(document).on('click','.adminShipperBtn',function(e) {
    e.preventDefault();
    $('#Customer_Order_details_modal').modal('hide')
    var shipperHubNumber = $('.getHubNumber').val();
    var OrderNumber = $('.rgetOrderNumber').val();

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
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
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
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
            showAllData();
        }
     });

    // console.log(shipperName);
    // console.log(copyHubNumber);

   
});



function showAllDispatchedOrderData(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "showDispatchOrderDetails"},
        success:function(response){
            // console.log(response);
            $("#showDispatchOrderHere").html(response);
            $('#DispatchOrderTableView').DataTable({
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

$(document).on('click','.getHubZipcodeDetails',function(e) {
    e.preventDefault();

    var id = $(this).attr('id');

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "getHubZipcode", //set an action to trigger , what if condition to be use.
            'id' : id
        },                         
        type: 'POST',
        success: function(response){
               
            $("#showHubZipcode").html(response);
          
        }
     });

});


function showAllForDeliveryOrderDataHub(){

    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "showAllOrderDetails"},
        success:function(response){
            // console.log(response);
            $("#showAllForDeliveryOrder").html(response);
            $('#forDeliverOrderTableView').DataTable({
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

function showAllForDeliveredOrderDataHub(){
    
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {action: "showAllDeliveredOrder"},
        success:function(response){
            // console.log(response);
            $("#showAllDeliveredOrder").html(response);
            $('#deliveredOrderTableView').DataTable({
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

    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {'action': "showAllCancelledOrder"},

        success:function(response){
            // console.log(response);

            $("#showAllCancelledOrder").html(response);
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
// showAllHubData();
// clearAllInput();
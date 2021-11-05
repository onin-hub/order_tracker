$(document).ready(function() {
    showAllData();
    
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

    // for hub droplist
    showAllHubForFilter();
    showAllHubForFilterByDispatchedOrder();
    showAllHubForFilterByDeliveryOrder();
    showAllHubForDelivered();
    showAllHubForCancelledOrder();

    //for grahp
    // showGraphData();
    showAImporthistory();
    showAllNAProdByHub();
    showAllUncoOrders();
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

function showAllUncoOrders(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {'action': "showUnconsoOrders"},
        success:function(response){
            // console.log(response);
            $("#showUnconsolidateOrder").html(response);
            $('#unconsoOrderTableView').DataTable({
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

$(document).on('click','.close',function(e) {

    $('.inputZipcode').tagsinput('removeAll');
});

$(document).on('click','.addHubBtnTop',function(e) {

    clearAllInput();
    showAllData();

});

$(document).on('click','#adminGenerateBtnGraph',function(e) {
    e.preventDefault();

    var inputYear = $('.inputYear').val();
    var filterByHub = $('.hubOnChangeAction').val();

    // console.log(filterByHub);

    if (inputYear == '' && filterByHub == 'empty'){
        Swal.fire({
            icon: 'error',
            title: 'Insert year or year and hub for filter',
            type: 'error'
        })
    }else if(inputYear == ''){
        Swal.fire({
            icon: 'error',
            title: 'Insert year',
            type: 'error'
        })
    }else{
        $.ajax({
            url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
            data: {
                'action' : "getPaidAndVoidedByYearAndHubAdmin", //set an action to trigger , what if condition to be use.
                'inputYear' : inputYear,
                'filterByHub' : filterByHub
            },               
            type: 'POST',
            success: function(response){
                   var data = JSON.parse(response);
                //    console.log(data);
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
                        // data: [50,60,75,60]
                        data: [data[0][1], data[0][2],data[0][3],data[0][4],data[0][5],data[0][6],data[0][7],data[0][8],data[0][9],data[0][10],data[0][11],data[0][12]]
                    }, {
                        label: 'voided',
                        backgroundColor: 'rgb(255,0,0)',
                        borderColor: 'rgb(255,0,0)',
                        // data: [50,60,75,60],
                        data: [data[1][1], data[1][2],data[1][3],data[1][4],data[1][5],data[1][6],data[1][7],data[1][8],data[1][9],data[1][10],data[1][11],data[1][12]],
            
                        // Changes this dataset to become a line
                        type: 'bar'
                    }],
                    labels: ['Jan' + ' ' +inputYear, 'Feb' + ' ' +inputYear, 'Mar' + ' ' +inputYear, 'April' + ' ' +inputYear,'May' + ' ' +inputYear,'June' + ' ' +inputYear,'July' + ' ' +inputYear,'Aug' + ' ' +inputYear,'Sep' + ' ' +inputYear,'Oct' + ' ' +inputYear,'Nov' + ' ' +inputYear,'Dec' + ' ' +inputYear]
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
        data: {'action': "showOrderDetails"},
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
        

            }

            else if (response['condition'] == 'empty') {
                Swal.fire({
                icon: 'error',
                title: 'Insert Hub',
                type: 'error'
            })
         
            showAllData();
       
                  
            }
            else if (response['condition'] == 'emptyZipCode') {
                Swal.fire({
                icon: 'error',
                title: 'Enter Zip code',
                type: 'error'
            })
    
            showAllData();
           
                  
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
        data: {"action": "importDropdown"},
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
    $('#showAccountArea').show();
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
    } else if (!numericReg.test(ucontact)) {

        // alert('input numeric value only in Contact');
        Swal.fire({
            icon: 'error',
            title: 'Input numeric value only in Contact',
            type: 'error'
        })
        $('#uContact').val('');

    } else if ($('#uRole').val() == 'Consolidator'){

        if($('#userHubNumber').val() == 'Choose...' || $('#userHubNumber').val() == ''){
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
        }else{
            Swal.fire({
                icon: 'error',
                title: "Consolidator account don't need hub number",
                type: 'error'
            })
            $('#userHubNumber').val('Choose...');
        }
    }
     else if ($('#uRole').val() == 'Choose...') {
        
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
    }else if ($('#inputZipcode').val() == '') {

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

                if ($('#euRole').val() == "Consolidator"){
                    $('#editShowAccountArea').hide();
                }else if($('#euRole').val() == "Hub Supervisor" || $('#euRole').val() == "Shipper"){
                    $('#editShowAccountArea').show();
                }
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
        url:'phpAction/admin_action/admin_action.php',
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

    var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;

    if ($('#efName').val() == '' && $('#elName').val() == '' && $('#euName').val() == '' && $('#euPass').val() == '' && $('#euContact').val() == '' && $('#euRole').val() == 'Choose...' && $('#euserHubNumber').val() == 'Choose...')
    {
        // alert('all field is empty');
        Swal.fire({
            icon: 'error',
            title: 'All field is empty',
            type: 'error'
        })
    }else if ($('#efName').val() == '') {

        // alert('first name is empty');
        Swal.fire({
            icon: 'error',
            title: 'First name is empty',
            type: 'error'
        })
    }else if ($('#elName').val() == '') {

        // alert('last name is empty');
        Swal.fire({
            icon: 'error',
            title: 'Last name is empty',
            type: 'error'
        })
        
    } else if ($('#euName').val() == '') {

        // alert('user name is empty');
        Swal.fire({
            icon: 'error',
            title: 'User name is empty',
            type: 'error'
        })
    }else if ($('#euPass').val() == '') {

        // alert('password is empty');
        Swal.fire({
            icon: 'error',
            title: 'Password is empty',
            type: 'error'
        })
    }else if ($('#euContact').val() == '') {

        // alert('Contact number is empty');
        Swal.fire({
            icon: 'error',
            title: 'Contact number is empty',
            type: 'error'
        })
    } else if (!numericReg.test(ucontact)) {

        // alert('input numeric value only in Contact');
        Swal.fire({
            icon: 'error',
            title: 'Input numeric value only in Contact',
            type: 'error'
        })
        $('#euContact').val('');

    }else if ($('#euserHubNumber').val() == 'Choose...') {

        // alert('User Hub Number is empty');
        Swal.fire({
            icon: 'error',
            title: 'User Hub Number is empty',
            type: 'error'
        })
    }else {

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
    }
    
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
    var action = "insertExcel";
    // var importHubNumber = $('#importHubNumber').val();
    var fname = $('#userFname').val();
    var lname = $('#userLname').val();
    var uID = $('#userID').val();

    form_data.append('file', file_data);
    form_data.append('action', action);
    // form_data.append('importHubNumber', importHubNumber);
    form_data.append('fname', fname);
    form_data.append('lname', lname);
    form_data.append('uID', uID);

    // console.log(file_name);

    $.ajax({
        url: 'phpAction/admin_action/admin_action.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,          
        type: 'POST',

        beforeSend: function( xhr ) {
            $('#btn-import-driver').fadeOut();
            $('.spinner-border').fadeIn();
        },

        success: function(response) {
            
            var response = JSON.parse(response);

            // console.log(response);
            
            if (response['type'] == 'success') {
                Swal.fire({
                    icon: 'success',
                    text: response['msg'],
                }).then(function(){
                    window.location.reload();
                    $('#btn-import-driver').fadeIn();
                    $('.spinner-border').fadeOut();
                });
            } else if (response['type'] == 'insertHubNumber'){
                
                     Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                })
                $('#btn-import-driver').fadeIn();
                $('.spinner-border').fadeOut();
            }
            else if (response['type'] == 'error'){
                Swal.fire({
                    icon: 'error',
                    text: response['msg'],
                }).then(function(){
                window.location.reload();
                $('#btn-import-driver').fadeIn();
                $('.spinner-border').fadeOut();
            });
            }
        }
     });
});

function showAImporthistory(){
    $.ajax({
        url: "phpAction/admin_action/admin_action.php",
        type: "POST",
        data: {'action': "importHistoryAction"},
        success:function(response){
            // console.log(response);
            $("#orderImportHistory").html(response);
            $('#orderImportHistoryTable').DataTable({
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

$(document).on('click','.getImportExtraData',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

     

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "getImportExtraData", //set an action to trigger , what if condition to be use.
            'id' : id
        },
        type: 'POST',
        success: function(response){
               
                $("#importDataAppear").html(response);
        }
     });
});

$(document).on('click','.customer_Info_Btn',function(e) {
    e.preventDefault();

        $('#importHubNumber').val("Choose...");

      var id = $(this).attr('id');//get input value
      var orderNumber = $(this).attr('ordernumber');//get input value

      $('.getOrderForHubUpdateAssign').val(orderNumber);


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

//ajax for drop hub list and filter for pending order per hub
function showAllHubForFilter(){    
    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "showAllHubsForDropDown", //set an action to trigger , what if condition to be use.
        },
        type: 'POST',
        success: function(response){
               
                $("#showAllHubsForDropDown").html(response);
               

        }
     });
}


//ajax for drop hub list and filter for dispatched order per hub
function showAllHubForFilterByDispatchedOrder(){    
    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "showAllHubsForDropDownForDispatched", //set an action to trigger , what if condition to be use.
        },
        type: 'POST',
        success: function(response){
                $("#showAllHubsForDropDownForDispatched").html(response);
        }
     });
}

$(document).on('change','.hubOnChangeActionForDispathed',function(e) {
    
    var hubnumber = $('.hubOnChangeActionForDispathed').val();
    
    // console.log(zipCodeFilter);

    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "shoDispatchedByHub", //set an action to trigger , what if condition to be use.
            'hubnumber' : hubnumber
        },
        type: 'POST',
        success: function(response){
               
                $("#showDispatchOrderHere").html(response);
                $('#DispatchedOrderTableViewPerHub').DataTable({
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

//ajax for drop hub list and filter for delivery order per hub
function showAllHubForFilterByDeliveryOrder(){    
    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "showAllHubsForDropDownForDelivery", //set an action to trigger , what if condition to be use.
        },
        type: 'POST',
        success: function(response){
                $("#showAllHubsForDropDownForDelivery").html(response);
        }
     });
}

$(document).on('change','.hubOnChangeActionForDelivery',function(e) {
    
    var hubnumber = $('.hubOnChangeActionForDelivery').val();
    
    // console.log(zipCodeFilter);

    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "shoDeliveryByHub", //set an action to trigger , what if condition to be use.
            'hubnumber' : hubnumber
        },
        type: 'POST',
        success: function(response){
               
                $("#showAllForDeliveryOrder").html(response);
                $('#DeliveryOrderTableViewPerHub').DataTable({
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

//ajax for drop hub list and filter for delivered order per hub
function showAllHubForDelivered(){    
    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "showAllHubsForDeliveredOrder", //set an action to trigger , what if condition to be use.
        },
        type: 'POST',
        success: function(response){
               
                $("#showAllHubsForDeliveredOrder").html(response);
        }
     });
}

$(document).on('change','.hubOnChangeActionForDelivered',function(e) {
    
    var hubnumber = $('.hubOnChangeActionForDelivered').val();
    
    // console.log(zipCodeFilter);

    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "shoDeliveredByHub", //set an action to trigger , what if condition to be use.
            'hubnumber' : hubnumber
        },
        type: 'POST',
        success: function(response){
               
                $("#showAllDeliveredOrder").html(response);
                $('#DeliveredOrderTableViewPerHub').DataTable({
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

//ajax for drop hub list and filter for cancelled order per hub
function showAllHubForCancelledOrder(){    
    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "showAllHubsForCancelledOrder", //set an action to trigger , what if condition to be use.
        },
        type: 'POST',
        success: function(response){
               
                $("#showAllHubsForCancelledOrder").html(response);
        }
     });
}


// one page filter ajax
$(document).on('click','#generateBtn',function(e) {
    e.preventDefault();

    var hubnumber = $('.hubOnChangeAction').val();
    var orderStatus = $('.fOrderStatus').val();
    var dateStartAndEnd = $('#dateStartAndEnd').val();


    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "filterAction", //set an action to trigger , what if condition to be use.
            'hubnumber' : hubnumber,
            'orderStatus': orderStatus,
            'dateStartAndEnd' : dateStartAndEnd
        },                       
        type: 'POST',
        success: function(response){
               
            $("#showManageOrderHere").html(response);
            $('#OrderTableViewPerHub').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                    // dom: 'Bfrtip',
                    // buttons: [
                    //     'csv', 'excel'
                    // ]
            });

        }
     });

});


$(document).on('click', '.orderProgressDetailsVoided', function (e) {
    e.preventDefault();

    var ordernumber = $(this).attr('ordernumber');

    $.ajax({
        url: 'phpAction/admin_action/admin_action.php',
        type: 'post',
        data: {'action' : "getOrderDetailsForVoided",
                'ordernumber' : ordernumber
        },
        type: 'POST',
        success: function (response) {
                $(".showProgressVoided").html(response);
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


function showAllNAProdByHub(){

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "getAndShowNAProd" //set an action to trigger , what if condition to be use.
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

$(document).on('click','.getNAProdById',function(e) {
    e.preventDefault();

      var id = $(this).attr('id');//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
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

$(document).on('click','[name="saveChangePass"]',function(e) {
    e.preventDefault();

    //get the value using name attribute
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
            url:'phpAction/admin_action/admin_action.php',
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

$(document).on('change', '#uRole', function () {

    if ($('#uRole').val() == "Consolidator"){
        $('#showAccountArea').hide();
    }else if ($('#uRole').val() == "Hub Supervisor"){
        $('#showAccountArea').show();
    }else if ($('#uRole').val() == "Shipper"){
        $('#showAccountArea').show();
    }
});

$(document).on('change', '#euRole', function () {

    if ($('#euRole').val() == "Consolidator"){
        $('#editShowAccountArea').hide();
    }else if($('#euRole').val() == "Hub Supervisor" || $('#euRole').val() == "Shipper"){
        $('#editShowAccountArea').show();
        $('#euserHubNumber').val('Choose...');
    }
});

//download excel file
$(document).on('click','.getNAProdById',function(e) {
    e.preventDefault();  //stop the browser from following
    var filename = $(this).attr('filename');
    window.location.href = (filename);
});

$(document).on('click','#assignOrderToHubBtn',function(e) {
    e.preventDefault();

     var hubArea = $("#importHubNumber").val();
     var orderNumber = $('.getOrderForHubUpdateAssign').val();

  
    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "assignUncoOrderToHub", //set an action to trigger , what if condition to be use.
            'hubArea' : hubArea,
            'orderNumber' : orderNumber
        },
        type: 'POST',
        success: function(response){

            $("#showUnconsolidateOrder").html(response);
            $('#unconsoOrderTableView').DataTable({
                order: [0, 'desc'] //use this to make the the appear the current record in the top
                    // dom: 'Bfrtip',
                    // buttons: [
                    //     'csv', 'excel'
                    // ]
            });

            Swal.fire({

                title: 'Order successfull consolidated!',
                type: 'Success'
            })
            $('#Customer_details_modal').modal('hide');
            
        }
     });
});

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


    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "cancelAndupdateOrderNumber", //set an action to trigger , what if condition to be use.
            'orderNum' : orderNum,
            'remarks' : remarks
        },            
        type: 'POST',
        success: function(response){
            var response = JSON.parse(response);

            if (response['condition'] == 'error') {
                Swal.fire({
                icon: 'error',
                title: 'Remark is empty!',
                type: 'error'
            })
            }else if (response['condition'] == 'success') {

                Swal.fire({
                    icon: 'success',
                    title: 'Order number' + ' ' + orderNum + ' ' + 'cancelled!',
                    type: 'success'
                })
                
                $('#cancelOrdermodal').modal('hide');
                showAllData();
            }
        }
     });
 
});



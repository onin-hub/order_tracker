$(document).ready(function() {
    showAllData();

    // $('#addAcctTableView').DataTable();
    // $('#hubTableView').DataTable();

});

/*=====================================
        FUNCTION AREA
 ======================================*/ 
function showAllData(){
    show_All_Hub_In_DropDown();
    show_All_Account_In_Table();
    showAllHubData();
    edit_show_All_Hub_In_DropDown();
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
}

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

/*=====================================
                EVENT AREA
 ======================================*/ 
 /*=====================================
          ADD HUB MODAL INSERT AJAX
 ======================================*/ 
$(document).on('click','#add_HubNumber',function(e) {
    e.preventDefault();

    var hubNumber = $('#hubNumber').val();//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "addHubNumber", //set an action to trigger , what if condition to be use.
            'hubNumber' : hubNumber
        },            
        type: 'POST',
        success: function(response){
            response = JSON.parse(response);

            if (response['condition'] == 'error') {

                Swal.fire({
                icon: 'error',
                title: 'Hub already Exist!',
                type: 'error'
            })
            $("#addHubModal").modal('hide');
            showAllData();
            clearAllInput();
   
            }

            else if (response['condition'] == 'empty') {
                Swal.fire({
                icon: 'error',
                title: 'You Insert Nothing',
                type: 'error'
            })
            $("#addHubModal").modal('hide');
            showAllData();
            clearAllInput();
                  
            }
            
            else if (response['condition'] == 'success') {
                Swal.fire({
                icon: 'success',
                title: 'Hub add Successfully',
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

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "updateHubDetail", //set an action to trigger , what if condition to be use.
            'hubId' : hubId,
            'hubNumber' : hubNumber
        },            
        type: 'POST',
        success: function(response){
                Swal.fire({
                    title: 'Hub Update Successfully',
                    type: 'success'
                })
                $("#editHubModal").modal('hide');
                showAllData();
                clearAllInput();
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
        alert('all field is empty');
    } else if ($('#fName').val() == '') {

        alert('first name is empty');
    } else if ($('#lName').val() == '') {

        alert('last name is empty');
    } else if ($('#uName').val() == '') {

        alert('user name is empty');
    } else if ($('#uPass').val() == '') {

        alert('password is empty');
    } else if ($('#uContact').val() == '') {

        alert('Contact number is empty');
    } else if ($('#uRole').val() == 'Choose...') {
        
        alert('User Role is empty');
    } else if ($('#userHubNumber').val() == 'Choose...') {

        alert('User Hub Number is empty');
    } else if (!numericReg.test(ucontact)) {

        alert('input numeric value only in Contact');
        $('#uContact').val('');
    } else {

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




// showAllHubData();
// clearAllInput();
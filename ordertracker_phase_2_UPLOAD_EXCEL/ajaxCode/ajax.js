$(document).ready(function(){

/******************************************************************************
 * area to declare the function you create, and load when the browser is ready
 ******************************************************************************/

showAllUserData();
showAllHubData();
showHubDropDown();
showHubDropDown2ForEdit();
});

/*******************
 * Start Code Here
 *******************/

/*********************************************************
 * AJAX function for get all the user data in the database
 *********************************************************/
function showAllUserData(){
    $.ajax({
        url: "phpAction/action.php",
        type: "POST",
        data: {action: "view"},
        success:function(response){
            // console.log(response);
            $("#showUser").html(response);
            $('#accountTable').DataTable({
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

function showAllHubData(){
    $.ajax({
        url: "phpAction/action.php",
        type: "POST",
        data: {action: "viewHub"},
        success:function(response){
            // console.log(response);
            $("#showHub").html(response);
            $('#hubTable').DataTable({
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

function showHubDropDown(){
    $.ajax({
        url: "phpAction/action.php",
        type: "POST",
        data: {action: "viewHubDropDown"},
        success:function(response){
            // console.log(response);
            $("#dropHub").html(response);
        }
    });
}

function showHubDropDown2ForEdit(){
    $.ajax({
        url: "phpAction/action.php",
        type: "POST",
        data: {action: "viewHubDropDown2"},
        success:function(response){
            // console.log(response);
            $("#dropHub2").html(response);
        }
    });
}

/*********************************************************
 * insert ajax request
 *********************************************************/

    $("#insert").click(function(e){
        if($("#user-form-data")[0].checkValidity()){ //checkValidity is a method. 
            e.preventDefault();
            $.ajax({
                url: "phpAction/action.php",
                type: "POST",
                data: $("#user-form-data").serialize()+"&action=insert", // serialize method is get all the input data inside the form
                success:function(response){
                Swal.fire({
                    title: 'User added Successfully',
                    type: 'success'
                })

                $("#addModal").modal('hide');
                $("#user-form-data")[0].reset();
                showAllUserData();
                }
            });
        }
    });


    /*********************************************************
 * insert hub ajax request
 *********************************************************/
$("#insertHub").click(function(e){
    if($("#hub-form-data")[0].checkValidity()){ //checkValidity is a method. 
        e.preventDefault();
        $.ajax({
            url: "phpAction/action.php",
            type: "POST",
            data: $("#hub-form-data").serialize()+"&action=insertHub", // serialize method is get all the input data inside the form
            success:function(response){
            Swal.fire({
                title: 'Hub added Successfully',
                type: 'success'
            })

            $("#hubModal").modal('hide');
            $("#hub-form-data")[0].reset();
            showAllHubData();
            window.location.reload();
            }
        });
    }
});

    /*********************************************************
 * edit ,method in add account
 *********************************************************/
$("body").on("click",".editBtn", function(e){
    // console.log("working");
    e.preventDefault();
    var edit_id = $(this).attr('id');
    $.ajax({
        url: "phpAction/action.php",
        type: "POST",
        data: {'edit_id':edit_id},
        success:function(response){
            // console.log(response);
            data = JSON.parse(response);
            // console.log(data);
            $("#id").val(data.id);
            $("#firstName").val(data.first_name);
            $("#lastName").val(data.last_name);
            $("#uName").val(data.user_username);
            $("#upass").val(data.user_password);
            $("#uContact").val(data.user_contact_number);
            $("#userRole").val(data.user_role);
            $("#userHub2").val(data.hub_area);
        }
    });
});

    /*********************************************************
 * Delete add account details
 *********************************************************/
$("body").on("click", ".delBtn", function(e){
    e.preventDefault();
    var tr = $(this).closest('tr');
    var del_id = $(this).attr('id');

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
            url: "phpAction/action.php",
            type: "POST",
            data: {'del_id':del_id},
            success:function(response){
                // console.log(response);
                tr.css('background-color','#ff6666');
                Swal.fire(
                    'Deleted!',
                    'User Deleted successfully!',
                    'success'
                )
                showAllUserData();
                window.location.reload();
            }
          });
        }
    });
});

    /*********************************************************
 * edit ,method in hub
 *********************************************************/
$("body").on("click",".editHub", function(e){
    // console.log("working");
    e.preventDefault();
    var edit_hub = $(this).attr('id');
    $.ajax({
        url: "phpAction/action.php",
        type: "POST",
        data: {'edit_hub':edit_hub},
        success:function(response){
            // console.log(response);
            data = JSON.parse(response);
            // console.log(data);
            $("#idHub").val(data.id);
            $("#hubNum").val(data.hub_area);
        }
    });
});
    /*********************************************************
 * update add account details
 *********************************************************/
$("#editAccount").click(function(e){
    if($("#edit-user-form-data")[0].checkValidity()){ //checkValidity is a method. 
        e.preventDefault();
        $.ajax({
            url: "phpAction/action.php",
            type: "POST",
            data: $("#edit-user-form-data").serialize()+"&action=updateAddAccount", // serialize method is get all the input data inside the form
            success:function(response){
            Swal.fire({
                title: 'Account updated Successfully',
                type: 'success'
            })

            $("#editAddModal").modal('hide');
            $("#edit-user-form-data")[0].reset();
            showAllUserData();
            // console.log(response);
            }
        });
    }
});

    /*********************************************************
 * Delete Hub details
 *********************************************************/
$("body").on("click", ".delHub", function(e){
    e.preventDefault();
    var tr = $(this).closest('tr');
    var del_hub = $(this).attr('id');

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
            url: "phpAction/action.php",
            type: "POST",
            data: {'del_hub':del_hub},
            success:function(response){
                // console.log(response);
                tr.css('background-color','#ff6666');
                Swal.fire(
                    'Deleted!',
                    'User Deleted successfully!',
                    'success'
                )
                showAllHubData();
                window.location.reload();
            }
          });
        }
    });
});
    /*********************************************************
 * update Hub details
 *********************************************************/
$("#updatesHub").click(function(e){
    e.preventDefault();

    var hubId = $('#idHub').val();
    var hubNum = $('#hubNum').val();
    var action = $('#updatesHub').attr('name')

    $.ajax({
        url:'phpAction/action.php',
        data:{
            'hubId' : hubId,
            'hubNum' : hubNum,
            'action' : action
        },
        'type' : 'POST',
        success: function(response){
            Swal.fire({
                title: 'Hub update Successfully',
                type: 'success'
            })
            $("#editHubModal").modal('hide');
            showAllHubData();
            window.location.reload();
        }     
    });
});

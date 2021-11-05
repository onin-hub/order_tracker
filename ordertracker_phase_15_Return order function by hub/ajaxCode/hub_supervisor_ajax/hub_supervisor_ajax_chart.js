$(document).ready(function() {

    showAllDataAndClearInput();

    $("#datepicker").datepicker( {
        format: " yyyy", // Notice the Extra space at the beginning
        viewMode: "years", 
        minViewMode: "years"
    });
    
});


 /*=====================================
          Function
 ======================================*/ 
function showAllDataAndClearInput(){

    showGraphData();
    
}


/*=====================================
         GRAPH CODE
 ======================================*/
function showGraphData(){
    var ugetUserHubNUmberForGraph = $('#ugetUserHubNUmberForGraph').val();
    var Currentyear = $('.cYear').val();

    $.ajax({
        url:'phpAction/hub_supervisor_action/hub_supervisor_action.php',// point to server-side PHP script 
        data: {
            'action' : "getOstatusOfPaidAndCountIt", //set an action to trigger , what if condition to be use.
            'ugetUserHubNUmberForGraph' : ugetUserHubNUmberForGraph
        },
        type: 'POST',
        success: function(response){

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
                    labels: ['Jan' + ' ' +Currentyear, 'Feb' + ' ' +Currentyear, 'Mar' + ' ' +Currentyear, 'April' + ' ' +Currentyear,'May' + ' ' +Currentyear,'June' + ' ' +Currentyear,'July' + ' ' +Currentyear,'Aug' + ' ' +Currentyear,'Sep' + ' ' +Currentyear,'Oct' + ' ' +Currentyear,'Nov' + ' ' +Currentyear,'Dec' + ' ' +Currentyear]
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
                // var data = JSON.parse(response);
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
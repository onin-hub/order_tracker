$(document).ready(function() {
    showAllData();
 // end date picker code
 
 //year picker
 $("#datepicker").datepicker( {
    format: " yyyy", // Notice the Extra space at the beginning
    viewMode: "years", 
    minViewMode: "years"
});

});


/*=====================================
        FUNCTION AREA
 ======================================*/ 
function showAllData(){

    showGraphData();
    showAllHubForFilter();
}


function showGraphData(){
    var Currentyear = $('.cYear').val();

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "getAllPaidAndVoidedOrderForCurrentYear", //set an action to trigger , what if condition to be use.
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

function showAllHubForFilter(){    
    $.ajax({
        url:"phpAction/admin_action/admin_action.php",// point to server-side PHP script 
        data: {
            'action' : "showAllHubsForDropDownForChart", //set an action to trigger , what if condition to be use.
        },
        type: 'POST',
        success: function(response){
               
                $("#showAllHubsForDropDown").html(response);
        }
     });
}



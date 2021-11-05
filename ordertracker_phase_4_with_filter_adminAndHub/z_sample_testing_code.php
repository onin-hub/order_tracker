<?php

require 'classes/admin_classes/AdminClasses.php';
$paidOrders = new AdminClasses;

$currentYear = date("Y");
$results = $paidOrders->selectAllPaidOrdersForGraph($currentYear);

var_dump($currentYear);

$resultEncoded = json_encode($results);

?>

<!-- ======================================================================
FIRST GRAPH 
========================================================================-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    

    <!-- chart CDN link -->
    <!-- <link rel="stylesheet" type="text/css" href="https://path/to/chartjs/dist/Chart.min.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/yearpicker.css"> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>


   <style>
       input[type="text"] {
        border: solid 1px;
        border-color: rgb(181, 181, 181);
        border-radius: .25rem;
        text-align: center;
        height: 33px;
        font-size: 15px;
}
   </style>

</head>

<body>
    <div class="container mt-5">
        <div class="row mb-3">
        <!-- year picker here -->
            <div class="col-lg-6">
                <form action="">
                    <input type="text" id="datepicker" placeholder="Insert Year" />
                    <button type="submit" class="btn btn-success btn-sm" id="generateBtn">Generate</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<!-- year picker JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<!-- chart cdn -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdnjs.com/libraries/Chart.js"></script>
<script src="https://www.jsdelivr.com/package/npm/chart.js?path=dist"></script>

<script>
    $(document).ready(function() {
    var resultEncoded = <?php echo $resultEncoded; ?>

    console.log(resultEncoded);

    var year = '2020';
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        datasets: [
            {
            label: 'voided',
            backgroundColor: 'rgb(255,0,0)',
            borderColor: 'rgb(255,0,0)',
            data: [1, 2, 3, 4]
        }, {
            label: 'delivered',
            backgroundColor: 'rgb(0,128,0)',
            borderColor: 'rgb(0,128,0)',
            data: [50, 45, 45, 50],

            // Changes this dataset to become a line
            type: 'bar'
        }],
        labels: ['Jan' + ' ' +year, 'Feb' + ' ' +year, 'Mar' + ' ' +year, 'April' + ' ' +year,'May' + ' ' +year,'June' + ' ' +year,'July' + ' ' +year,'Aug' + ' ' +year,'Sep' + ' ' +year,'Oct' + ' ' +year,'Nov' + ' ' +year,'Dec' + ' ' +year]
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
});
</script>

<script>
$(document).ready(function() {
    $("#datepicker").datepicker( {
        format: " yyyy", // Notice the Extra space at the beginning
        viewMode: "years", 
        minViewMode: "years"
    });
});
</script>
</body>
</html>       
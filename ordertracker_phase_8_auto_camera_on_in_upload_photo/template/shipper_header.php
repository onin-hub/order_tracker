<?php
require 'core/shipper_init/shipper_init.php';

require 'classes/shipper_classes/ShipperClasses.php';

$db = new ShipperClasses;

$filterKey = 'for checking';
$forDelivery = 'for delivery';

$shipperId = $_SESSION['logInShipperInfo'][0];
$userShipperID = $_SESSION['logInShipperInfo'][0];

$dispatchedOrder = $db->readAllDispatchedOrderDataPerShipper($shipperId,$filterKey);
$dispatcheCount = [];

$forDeliverydOrder = $db->readAllDeliveryOrderDataPerShipper($userShipperID,$forDelivery);
$deliveryCount = [];


foreach ($dispatchedOrder as $row){

    if (in_array($row['order_number'],$dispatcheCount,TRUE)){
        continue;
    }else{
        $dispatcheCount[] = $row['order_number'];
    }
}

foreach ($forDeliverydOrder as $row){

  if (in_array($row['order_number'],$deliveryCount,TRUE)){
      continue;
  }else{
    $deliveryCount[] = $row['order_number'];
  }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Order Tracker</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon"> -->
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

 <!-- Google Fonts -->
 <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->

<!-- Vendor CSS Files -->
<!-- CAMERA LINK-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">

<!--MY bootstrap cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!--datatable cdn -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
<!-- ===========================
          Template file 
  =============================-->
<link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="assets/vendor/aos/aos.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">
<!-- My Css -->
<link href="assets/css/myCss.css" rel="stylesheet">


  <!-- =======================================================
  * Template Name: Day - v2.0.0
  * Template URL: https://bootstrapmade.com/day-multipurpose-html-template-for-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->



</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="shipper_dashboard.php"><img src="assets/img/onnewtem.png" ></a></h1>
      
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="drop-down"><a href="#">Orders</a>
            <ul>
              <li><a href="shipper_dispatched_order.php">Dispatched Order &nbsp; <span class="badge badge-danger p-1 badgeCountDispatched"><?php echo count($dispatcheCount) ?></span></a></li>
              <li><a href="shipper_for_delivery_order.php">For Delivery Order &nbsp; <span class="badge badge-danger p-1 badgeCountForDelivery"><?php echo count($deliveryCount) ?></span></a></li>
              <li><a href="shipper_delivered_order.php">Delivered Order (paid)</a></li>
              <li><a href="shipper_cancelled_order.php">Cancelled Order (voided)</a></li>
            </ul>
          </li>

          <li class="drop-down"><a href="#"> welcome <?php echo $_SESSION['logInShipperInfo'][1]; ?></a>
            <ul>
              <li><a href="#">Change Password</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
          
          <!-- <form action="" method = "POST">
          <button class="" type="submit" name="logout">logout</button>
          </form> -->
          <!-- multi dropdown menu -->
<!--      
          <li class="drop-down"><a href="">Drop Down</a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="drop-down"><a href="#">Deep Drop Down</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
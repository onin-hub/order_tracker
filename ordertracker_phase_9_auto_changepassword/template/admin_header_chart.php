<?php
require 'core/admin_init/admin_init.php';
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

<!--MY bootstrap cdn -->
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
 <!--file for input value tags in one input field-->
<link rel="stylesheet" href="inputTagsDist/dist/bootstrap-tagsinput.css">

  <!-- =======================================================
  * Template Name: Day - v2.0.0
  * Template URL: https://bootstrapmade.com/day-multipurpose-html-template-for-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  
   <!-- datepicker cdn -->
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

   <!-- YEAR PICKER CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
   
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="admin_dashboard.php"><img src="assets/img/onnewtem.png" ></a></h1>
      
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>

          <li><a href="admin_dashboard.php">Dashboard</a></li>
          <li class="drop-down"><a href="#">Materlist</a>
            <ul>
              <li><a href="admin_acct_mngt.php">User Account</a></li>
              <li><a href="admin_acct_mngt_hub.php">Hub List</a></li>
              <li><a href="admin_not_available_prod.php">Out of stock history</a></li>
            </ul>
          </li>
          <li><a href="admin_import_order.php">Import</a></li>
          <li ><a href="admin_manage_pending_order.php">Orders</a></li>
          
          <!-- multi dropdown menu -->

          <li class="drop-down"><a href="#"> welcome <?php echo $_SESSION['logInAdminInfo'][1]; ?></a>
            <ul>
              <li><a href="#" data-toggle="modal" data-target="#changePasswordModal" id = "changePassModal" >Change Password</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
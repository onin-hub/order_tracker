
<?php

include "core/init.php"

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracker</title>


    <!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- datatables pagination -->
    <!-- sorting , searching etc. cdn -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">

   



</head>
<body>

    <!-- **************************
        TOP NAV
    *******************************-->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">TRACKER</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link " href="#" id = "dashBoardNav">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#" id = "accountNav">Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#" id = "hubNav">Hub</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#" id = "shipperNav">Shipper</a>
            </li>
            </ul>
        </div>
    </nav>
  
        
   
<?
require 'core/login_init/login_init.php';

if(isset($_SESSION['logInAdminInfo'])){
    header('Location: admin_dashboard.php');
}elseif(isset($_SESSION['logInHubSuperVisorInfo'])){
    header('Location: hubSup_dashboard.php');
}elseif(isset($_SESSION['logInShipperInfo'])){
    header('Location: shipper_dispatched_order.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracker</title>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="assets/css/myCss.css" rel="stylesheet">

</head>
<body>
<div class="mainWrapper">   
    <div class="container loginWrapper"> 
        <div class="card card-login text-center bg-dark" >
            <div  class="card-header mx-auto  bg-dark">
                <span> <img src="assets/img/onnewtem.png" class="w-75" alt="Logo"> </span><br/>
                            <span class="logo_title mt-5"> Login Dashboard </span>

            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="" id = "user_name" class="form-control" placeholder="Username">
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="" id = "user_password" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="" id = "logMein" value="Login" class="btn btn-outline-danger float-right login_btn">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<script src="ajaxCode/login_ajax/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>
</html>
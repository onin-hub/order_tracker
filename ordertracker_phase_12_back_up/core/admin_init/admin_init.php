<?php
session_start();

if(!isset($_SESSION['logInAdminInfo'])) {
    header('Location: index.php');
}
// if(isset($_POST['logout'])) {
//     session_destroy();
//     header('Location: index.php');
// }

//load all the classes folder file at once rather than use require_once to each file
spl_autoload_register(function($class){
    require_once 'classes/admin_classes/' . $class . '.php';

});

?>
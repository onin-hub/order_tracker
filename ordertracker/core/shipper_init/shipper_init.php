<?php
session_start();

if(!isset($_SESSION['logInShipperInfo'])) {
    header('Location: index.php');
}
//load all the classes folder file at once rather than use require_once to each file
spl_autoload_register(function($class){
    require_once 'classes/shipper_classes/Shipper_classes.php' . $class . '.php';
    
});



?>
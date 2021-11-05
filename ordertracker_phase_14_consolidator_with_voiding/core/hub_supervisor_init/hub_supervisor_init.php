<?php
session_start();

if(!isset($_SESSION['logInHubSuperVisorInfo'])) {
    header('Location: index.php');
}
//load all the classes folder file at once rather than use require_once to each file
spl_autoload_register(function($class){
    require_once 'classes/hub_supervisor_classes/HubSupervisorClasses.php' . $class . '.php';

});
?>
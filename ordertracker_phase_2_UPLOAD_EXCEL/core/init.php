<?php

session_start();



//load all the classes folder file at once rather than use require_once to each file
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

?>
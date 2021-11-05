<?php

require "../classes/admin_classes/AdminClasses.php";
$db = new AdminClasses;

$orderDetails = $db->getCustomerOderDetailCheckedWhoVoid("FOO3098");

$shipperDetails = $db->selectShipperByID("18");

var_dump($orderDetails);

$str = "Hello";
$str2 = "World";

$sample = "";

?>


<?php

require "../classes/hub_supervisor_classes/HubSupervisorClasses.php";
require "../classes/admin_classes/AdminClasses.php";

$db = new HubSupervisorClasses;
$dbadmin = new AdminClasses;

$reportResult = $dbadmin->reportResult("2020/07/23","2020/07/23");

// var_dump($reportResult);
// See the password_hash() example to see where this came from.
$hash = 'a037be9c6f78ee4cc80fd872049367bc';
var_dump($hash);


?>


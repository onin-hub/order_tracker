<?php

require "../classes/hub_supervisor_classes/HubSupervisorClasses.php";
require "../classes/admin_classes/AdminClasses.php";

$db = new HubSupervisorClasses;
$dbadmin = new AdminClasses;

$reportResult = $dbadmin->reportResult("2020/07/23","2020/07/23");

var_dump($reportResult);

?>


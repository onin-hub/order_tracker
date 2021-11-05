<?php

require "../classes/hub_supervisor_classes/HubSupervisorClasses.php";
require "../classes/admin_classes/AdminClasses.php";

$db = new HubSupervisorClasses;
$dbadmin = new AdminClasses;

$getReturnOrder = $db->getReturnOrder("FO119 - SAN GABRIEL");

var_dump($getReturnOrder);

?>


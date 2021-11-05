<?php

require 'classes/admin_classes/AdminClasses.php';
$db = new AdminClasses;

$compute = ['5','5'];

$total = array_sum($compute);

var_dump($total);
?>


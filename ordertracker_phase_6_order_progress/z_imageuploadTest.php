<?php

require 'classes/shipper_classes/ShipperClasses.php';

$db = new ShipperClasses;

$filterKey = 'for checking';
$shipperId = '52';

$dispatchedOrder = $db->readAllDispatchedOrderDataPerShipper($shipperId,$filterKey);
$dispatcheCount = [];

foreach ($dispatchedOrder as $row){

    if (in_array($row['order_number'],$dispatcheCount,TRUE)){
        continue;
    }else{
        $dispatcheCount[] = $row['order_number'];
    }
}

// var_dump($dispatchedFinalCount);
echo count($dispatcheCount);

?>


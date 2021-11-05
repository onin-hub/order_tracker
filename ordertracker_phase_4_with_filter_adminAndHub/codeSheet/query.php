<?php
//select the year. (basta format nya is Y-m-d)
SELECT `order_number`,`o_status`,`shipper_for_delivered_date_time` 
FROM `order_details`
WHERE `o_status` = 'paid' AND YEAR(`shipper_for_delivered_date_time`) = 2020;
?>
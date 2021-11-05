<?php
//select the year. (basta format nya is Y-m-d)
SELECT `order_number`,`o_status`,`shipper_for_delivered_date_time` 
FROM `order_details`
WHERE `o_status` = 'paid' AND YEAR(`shipper_for_delivered_date_time`) = 2020;



//update query
UPDATE table_name
SET column1 = value1, column2 = value2, ...
WHERE FOO2237;

UPDATE order_details
SET `shipper_for_delivered_date_time`= '2020/06/09 08:54:45'
WHERE `order_number` = FOO2237;


DROP PROCEDURE `sample`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sample`(IN `_paid` LONGTEXT, IN `_ship_date` LONGTEXT, IN `_hub_area` LONGTEXT) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER select 
Month, 
COUNT(*) as 'Order Month'
from sample
WHERE 
o_status = _paid
and ship_date like CONCAT('%', _ship_date , '%')
and hub_area = _hub_area
GROUP by Month




?>
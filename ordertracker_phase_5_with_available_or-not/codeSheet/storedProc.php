 
 
 <!-- sql
 
 BEGIN
SET SESSION sql_mode = '';

SELECT MONTH(shipper_for_delivered_date_time),order_number,o_status FROM order_details GROUP BY order_number;

END -->

 <?php
 
 public function ShowSingleData($from, $to)
    {
        try {

            $dao = new Dao();
            $conn = $dao->openConnection();

            $sql = "CALL `orders`(:order_status,:order_year)";

            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":order_status", $from);
            $stmt->bindparam(":order_year", $to);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dao->closeConnection();
        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }
?>


BEGIN
SET SESSION sql_mode = '';

SELECT
Month, 
COUNT(*) as 'Order Month'
from `orderview`
WHERE `o_status` = _paid
AND ship_date like CONCAT('%', _ship_date , '%')
AND `hub_area` = _hub_area
GROUP by Month

END


select distinct `ot_database`.`order_details`.`order_number` AS `order_number`,`ot_database`.`order_details`.`o_status` AS `o_status`,month(`ot_database`.`order_details`.`shipper_for_delivered_date_time`) AS `Month`,`ot_database`.`order_details`.`hub_area` AS `hub_area`,`ot_database`.`order_details`.`shipper_for_delivered_date_time` AS `ship_date` from `ot_database`.`order_details`
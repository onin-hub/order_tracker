<?php 

class ShipperClasses{

    private $dsn = "mysql:host=localhost;dbname=ot_database";
    private $user = "root";
    private $pass = "";
    public $conn;
    
    
    public function __construct(){
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);
            // echo "database is connected";
        }
    
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function readAllDispatchedOrderDataPerShipper($shipperId,$filterKey){

        $data = array(); //declare the variable to store the data
    
        $sql = "SELECT * FROM `order_details` WHERE `shipper_user_id`=:shipperId AND `o_status`=:filterKey ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['shipperId' => $shipperId, 'filterKey' => $filterKey]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($results as $row){
            $data[] = $row;
        }
    
        return $data;
    
    }


    public function getCustomerOderDetailsById($orderNumber){

        $data = array(); //declare the variable to store the data
    
        $sql = "SELECT * FROM `order_details` WHERE `order_number` = :order_number";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_number' => $orderNumber]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($results as $row){
            $data[] = $row;
        }
    
        return $data;
    }

    
public function getCustomerId($id){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function updateOrderByshipper($updateKey,$dateAndTimeFordelivery,$hubNumber) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey, `shipper_for_delivery_date_time` = :shipper_for_delivery_date_time WHERE `order_number` = :hubNumber";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'shipper_for_delivery_date_time' => $dateAndTimeFordelivery,
                    'hubNumber' => $hubNumber
                    ]);
}

public function readAllDeliveryOrderDataPerShipper($userShipperID,$forDelivery){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `shipper_user_id` = :shipper_user_id AND `o_status` = :forDelivery ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['shipper_user_id' => $userShipperID, 'forDelivery' => $forDelivery]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}


public function updateOrderOStatusToDelivered($updateKey,$dateAndTimeDelivered,$hubNumber) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey, `shipper_for_delivered_date_time` = :shipper_for_delivered_date_time WHERE `order_number` = :hubNumber";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'shipper_for_delivered_date_time' => $dateAndTimeDelivered,
                    'hubNumber' => $hubNumber]);
}

public function updateOrderOStatusToVoided($updateKey,$orderNumber,$shipper_for_voided_date_time,$voidRemark) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey, `shipper_for_voided_date_time` = :shipper_for_voided_date_time, `remarks` = :voidRemark 
    WHERE `order_number` = :hubNumber";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'shipper_for_voided_date_time' => $shipper_for_voided_date_time,
                    'voidRemark' => $voidRemark,
                    'hubNumber' => $orderNumber]);
}

public function readAllDeliveredOrderDataPerShipper($shipperId,$filterKey){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `shipper_user_id`=:shipperId AND `o_status`=:filterKey ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['shipperId' => $shipperId, 'filterKey' => $filterKey]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function readAllCancelledOrderDataPerShipper($shipperId,$filterKey){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `shipper_user_id`=:shipperId AND `o_status`=:filterKey ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['shipperId' => $shipperId, 'filterKey' => $filterKey]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function insertCustomerSatisfactionData($dupCustoName,$getRating,$dupOrderID){
    $sql = "INSERT INTO customer_satisfaction_data (c_fullname,c_rating,customer_rate_id) VALUES (:cfullname,:crating,:customerrateid)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['cfullname' => $dupCustoName,
                    'crating' => $getRating,
                    'customerrateid' => $dupOrderID]);

    return true;
}



}

?>

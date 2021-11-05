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

public function updateOrderByshipper($updateKey,$dateAndTimeFordelivery,$hubNumber,$updateId) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey, `shipper_for_delivery_date_time` = :shipper_for_delivery_date_time WHERE `order_number` = :hubNumber AND `id` = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'shipper_for_delivery_date_time' => $dateAndTimeFordelivery,
                    'hubNumber' => $hubNumber,
                    'id' => $updateId
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


public function updateOrderOStatusToDelivered($updateKey,$dateAndTimeDelivered,$hubNumber,$idToupdate) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey, `shipper_for_delivered_date_time` = :shipper_for_delivered_date_time WHERE `order_number` = :hubNumber AND `id` = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'shipper_for_delivered_date_time' => $dateAndTimeDelivered,
                    'hubNumber' => $hubNumber,
                    'id' => $idToupdate
                    ]);
}

public function updateOrderOStatusToVoided($updateKey,$orderNumber,$shipper_for_voided_date_time,$voidRemark,$finalIdtoUpdate) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey, `shipper_for_voided_date_time` = :shipper_for_voided_date_time, `remarks` = :voidRemark 
    WHERE `order_number` = :hubNumber AND `id` = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'shipper_for_voided_date_time' => $shipper_for_voided_date_time,
                    'voidRemark' => $voidRemark,
                    'hubNumber' => $orderNumber,
                    'id' => $finalIdtoUpdate
                    ]);
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

public function customerSatisfaction($orderID,$cusFullname,$cusRate,$imgFileName){
    $sql = "INSERT INTO `customer_satisfaction_data` (`customer_rate_id`,`c_fullname`,`c_rating`,`cus_img`) VALUES (:id,:c_fullname,:c_rating,:cus_img)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $orderID,
                    'c_fullname' => $cusFullname,
                    'c_rating' => $cusRate,
                    'cus_img' => $imgFileName
                    ]);
    return true;
}

public function selectRateAndImg($id){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `customer_satisfaction_data` WHERE `customer_rate_id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}


public function getOrderbyHubNumber($orderNumber){

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

}

?>

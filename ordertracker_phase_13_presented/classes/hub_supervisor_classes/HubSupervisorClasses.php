<?php

class HubSupervisorClasses{

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

/*==============================================
                Hub Supervior function
==================================================*/

public function shipper_fName_And_Lname_Exist($fname, $lname){

    $sql = "SELECT * FROM `users_table` WHERE `first_name` = :fname AND `last_name` = :lname";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname,
                    'lname' => $lname]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return  $results;
}

public function insertShippertAccount($fname, $lname, $uname, $upass, $ucontact, $urole, $uhubnumber){
    $sql = "INSERT INTO `users_table` (`first_name`, `last_name`, `user_username`, `user_password`, `user_contact_number`, `user_role`, `hub_area`) 
    VALUES (:fname, :lname, :uname, :upass, :ucontact, :urole, :uhubnumber)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname,
                    'lname' => $lname,
                    'uname' => $uname,
                    'upass' => $upass,
                    'ucontact' => $ucontact,
                    'urole' => $urole,
                    'uhubnumber' => $uhubnumber]);

    return true;
}

public function readAllShipperAccountData($hubnumber,$urole){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `users_table` WHERE hub_area = :hubnumber AND user_role = :urole";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hubnumber' => $hubnumber,
                    'urole' => $urole]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function deleteShipper($id){
    $sql = "DELETE FROM `users_table` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    return true;
}

public function getShipperAccountId($id){
    $sql = "SELECT * FROM users_table WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    
    return $result;
}

public function updateShipper_Details($id,$fname,$lname,$uname,$userPassword,$userContact) {
    $sql = "UPDATE users_table SET 
    first_name = :fname, last_name = :lname, user_username = :uname, 
    user_password = :userPassword, user_contact_number = :userContact
    WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname, 
                    'lname' => $lname, 
                    'uname' => $uname, 
                    'userPassword' => $userPassword,
                    'userContact' => $userContact,
                    'id' => $id]);
}

public function readAllPendingOrderDataPerHub($hubNumber,$pending){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hubNumber AND `o_status` = :pending";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
                'hubNumber' => $hubNumber,
                'pending' => $pending
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByHubNumAndDateOrder($hubnumber,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByHubNumStatusAndDateOrder($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByHubNumStatusZipcodeAndDateOrder($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus AND `c_zipcode` = :zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus,
        'zipcode'=>$zipCode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubAndDateForvoided($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `filterbyostatusanddateforvoided` WHERE `date_voided_by_hub_or_shipper` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubZipAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `orderdetailsviews` WHERE `hub_order_dispatched_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus AND `c_zipcode` = :zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus,
        'zipcode'=>$zipCode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusDateZipAndHubForDelivery($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `filterbyostatusanddatefordelivery` WHERE `shipper_for_delivery_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus AND `c_zipcode` = :zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus,
        'zipcode'=>$zipCode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubZipAndDateForPaid($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `filterbyostatusanddateforpaid` WHERE `shipper_for_delivered_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus AND `c_zipcode` = :zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus,
        'zipcode'=>$zipCode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubZipAndDateForvoided($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `filterbyostatusanddateforvoided` WHERE `date_voided_by_hub_or_shipper` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus AND `c_zipcode` = :zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus,
        'zipcode'=>$zipCode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusDateAndHubForDelivery($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `filterbyostatusanddatefordelivery` WHERE `shipper_for_delivery_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `orderdetailsviews` WHERE `hub_order_dispatched_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubAndDateForPaid($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `filterbyostatusanddateforpaid` WHERE `shipper_for_delivered_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByHubNumZipcodeAndDateOrder($hubnumber,$c_zipcode,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `c_zipcode` = :c_zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'c_zipcode'=>$c_zipcode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByHubNumZipcodeOstatusAndDateOrder($hubnumber,$orderStatus,$c_zipcode,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `hub_area` = :hubnumber AND `o_status` = :orderStatus AND `c_zipcode` = :c_zipcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'hubnumber'=>$hubnumber,
        'orderStatus'=>$orderStatus,
        'c_zipcode'=>$c_zipcode
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function readAllPendingOrderDataPerHubFiltered($hubNumber,$fRequest){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hubNumber AND `o_status` = :fRequest ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hubNumber' => $hubNumber, 'fRequest' => $fRequest]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function functionForZipFiltering($hubnumber,$zipCodeFilter){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hubnumber AND `c_zipcode` = :zipCodeFilter";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hubnumber' => $hubnumber,
                    'zipCodeFilter' => $zipCodeFilter]);
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

public function updateOstatusToNA($id) {
    $updateKey = "NA";

    $sql = "UPDATE `order_details` SET
    `o_status` = :updateKey WHERE `id` = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['updateKey' => $updateKey,
                    'id' => $id]);
}

public function getShipperByHub($shipperHubNum,$shipper){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `users_table` WHERE `hub_area` = :hub_area AND `user_role` = :shipper";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub_area' => $shipperHubNum,
                    'shipper' => $shipper]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function getShipperID($shipperFname,$shipperLname){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `users_table` WHERE `first_name` = :shipperName AND `last_name` = :shipperLname";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['shipperName' => $shipperFname,
                    'shipperLname' => $shipperLname]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function insertShipperIdIntoOrder($shipperID,$copyOrderNumber) {
    $sql = "UPDATE `order_details` SET
    `shipper_user_id` = :shipper_user_id WHERE `order_number` = :order_number";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['shipper_user_id' => $shipperID,
                    'order_number' => $copyOrderNumber]);
}

public function updateOstats($disOstatus,$dateAndTimeDispatched,$copyOrderNumber,$copyOrderId) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :o_status, `hub_order_dispatched_date_time` = :hub_order_dispatched_date_time WHERE `order_number` = :order_number AND `id` =:id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['o_status' => $disOstatus,
                    'hub_order_dispatched_date_time' => $dateAndTimeDispatched,
                    'order_number' => $copyOrderNumber,
                    'id' => $copyOrderId
                    ]);
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

public function getZipByHubNumber($hubNumber){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `hub_area_number` WHERE `hub_area` = :hubNumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hubNumber' => $hubNumber]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function readAllDeliveryOrderDataPerHub($hubNumber,$forDelivery){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hub_area AND `o_status` = :forDelivery ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub_area' => $hubNumber, 'forDelivery' => $forDelivery]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function readAllDeliveredOrderDataPerHub($hubNumber,$forDelivery){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hub_area AND `o_status` = :forDelivery ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub_area' => $hubNumber, 'forDelivery' => $forDelivery]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}


public function readAllCancelledOrderDataPerHub($hubNumber,$forDelivery){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hub_area AND `o_status` = :forDelivery ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub_area' => $hubNumber, 'forDelivery' => $forDelivery]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function updateOstatusAndRemarks($orderNum,$remarks,$voided,$pedingOrderTimeVoided,$dateForoCancelledAtColumn) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :o_status,`remarks` = :remarks, `hub_pending_date_time_voided` = :pedingOrderTimeVoided, `o_cancelled_at` = :o_cancelled_at, 
    `date_time_voided_by_hub_and_shipper` = :date_time_voided_by_hub_and_shipper		
    WHERE `order_number` = :order_number";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['o_status' => $voided,
                    'remarks' => $remarks,
                    'pedingOrderTimeVoided' => $pedingOrderTimeVoided,
                    'o_cancelled_at' => $dateForoCancelledAtColumn,
                    'date_time_voided_by_hub_and_shipper' => $dateForoCancelledAtColumn,
                    'order_number' => $orderNum]);
}

/////paid data graph query
public function selectAllPaidOrdersForGraph($ugetUserHubNUmberForGraph,$currentYear){
    $filterKey = 'paid';
    $data = array(); //declare the variable to store the data
    
    $sql = "SELECT `order_number`,`o_status`,`shipper_for_delivered_date_time` 
            FROM `order_details` WHERE `o_status` = :paid AND `hub_area` = :ugetUserHubNUmberForGraph AND YEAR(`shipper_for_delivered_date_time`) = :YearFilter";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'paid'=>$filterKey,
        'ugetUserHubNUmberForGraph'=> $ugetUserHubNUmberForGraph,
        'YearFilter'=>$currentYear
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function ShowPaidData($hubNumber, $o_year){
    $paidKey = 'paid';

        $sql = "CALL `viewpaid`(:_paid,:_ship_date,:_hub_area)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindparam(":_paid", $paidKey);
        $stmt->bindparam(":_ship_date", $o_year);
        $stmt->bindparam(":_hub_area", $hubNumber);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
}

public function ShowVoidedData($hubNumber, $o_year){
    $voidKey = 'voided';

        $sql = "CALL `orderVoided`(:_voided,:_ship_date_voided,:_hub_area)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindparam(":_voided", $voidKey);
        $stmt->bindparam(":_ship_date_voided", $o_year);
        $stmt->bindparam(":_hub_area", $hubNumber);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
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

public function selectHubNumAndVariantName($ordernumber,$ahubareanum,$whereKey){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_number` = :order_number AND `hub_area` = :hub_area AND `variant_name` = :variant_name";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['order_number' => $ordernumber,
                    'hub_area' => $ahubareanum,
                    'variant_name' => $whereKey
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function selectShipperByID($shipperid){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `users_table` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $shipperid]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function readAllHubByStatus($hubNumber,$statusTrack){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT DISTINCT order_number FROM `order_details` WHERE `hub_area` = :hubNumber AND `o_status` = :statusTrack";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
                'hubNumber' => $hubNumber,
                'statusTrack' => $statusTrack
                ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function selectUserByID($userid){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT `id`,`first_name`,`last_name`,`hub_area` FROM `users_table` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $userid]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function inserIntoNaProductHistory($uID,$uFulname,$uHubArea,$OrderNumber,$naProductName){
    $sql = "INSERT INTO `not_available_item_history` (`user_id`,`user_fname_lname`,`hub_area`,`order_number`,`product_name`) 
    VALUES (:userID,:fullname,:hub,:orderNum,:naProdName)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['userID' => $uID,
                    'fullname' => $uFulname,
                    'hub' => $uHubArea,
                    'orderNum' => $OrderNumber,
                    'naProdName' => $naProductName
    ]);

    return true;

}

public function getNAItem($ugetUserHubNUmber){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `not_available_item_history` WHERE `hub_area` = :hub";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub' => $ugetUserHubNUmber]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function getNAItembYid($id){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `not_available_item_history` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function getAccountChangePass($id){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `users_table` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function updateuPassword($uID,$connewpass) {
    $sql = "UPDATE `users_table` SET 
    user_password = :user_password WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['user_password' => $connewpass, 
                    'id' => $uID]);
}

public function getAccountIdAndPass($uID,$currentPassword){
    $sql = "SELECT * FROM users_table WHERE id = :id AND user_password = :user_password";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $uID,
                    'user_password' => $currentPassword
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    return $result;

}


}

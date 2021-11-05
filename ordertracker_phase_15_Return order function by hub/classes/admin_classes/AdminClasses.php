<?php

class AdminClasses {

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
                insert into order details
==================================================*/
public function insertExcelOrder($order_date,
                                $order_number,
                                $c_fullname,
                                $c_pnumber_one,
                                $c_pnumber_two,
                                $c_pnumber_primary,
                                $c_email,
                                $order_note,
                                $c_address_one,
                                $c_address_two,
                                $c_billing_add_one,
                                $c_billing_add_two,
                                $c_zipcode,
                                $c_city,
                                $o_total_price,
                                $o_status,
                                $o_cancelled_at,
                                $o_payment_gateway,
                                $o_special_discount,
                                $o_card_id_number,
                                $o_card_discount,
                                $o_card_discount_number,
                                $property_note,
                                $variant_price,
                                $variant_name,
                                $product_name,
                                $total_quantity_sold,
                                $hub_area){
    $sql = "INSERT INTO order_details (`order_date`,
                                        `order_number`,
                                        `c_fullname`,
                                        `c_pnumber_one`,
                                        `c_pnumber_two`,
                                        `c_pnumber_primary`,
                                        `c_email`,`order_note`,
                                        `c_address_one`,
                                        `c_address_two`,
                                        `c_billing_add_one`,
                                        `c_billing_add_two`,
                                        `c_zipcode`,
                                        `c_city`,
                                        `o_total_price`,
                                        `o_status`,
                                        `o_cancelled_at`,
                                        `o_payment_gateway`,
                                        `o_special_discount`,
                                        `o_card_id_number`,
                                        `o_card_discount`,
                                        `o_card_discount_number`,
                                        `property_note`,
                                        `variant_price`,
                                        `variant_name`,
                                        `product_name`,
                                        `total_quantity_sold`,
                                        `hub_area`) VALUES
                                    (:order_date,
                                    :order_number,
                                    :c_fullname,
                                    :c_pnumber_one,
                                    :c_pnumber_two,
                                    :c_pnumber_primary,
                                    :c_email,
                                    :order_note,
                                    :c_address_one,
                                    :c_address_two,
                                    :c_billing_add_one,
                                    :c_billing_add_two,
                                    :c_zipcode,
                                    :c_city,
                                    :o_total_price,
                                    :o_status,
                                    :o_cancelled_at,
                                    :o_payment_gateway,
                                    :o_special_discount,
                                    :o_card_id_number,
                                    :o_card_discount,
                                    :o_card_discount_number,
                                    :property_note,
                                    :variant_price,
                                    :variant_name,
                                    :product_name,
                                    :total_quantity_sold,
                                    :hub_area)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['order_date' => $order_date,
                    'order_number' => $order_number,
                    'c_fullname' => $c_fullname,
                    'c_pnumber_one' => $c_pnumber_one,
                    'c_pnumber_two' => $c_pnumber_two,
                    'c_pnumber_primary' => $c_pnumber_primary,
                    'c_email' => $c_email,
                    'order_note' => $order_note,
                    'c_address_one' => $c_address_one,
                    'c_address_two' => $c_address_two,
                    'c_billing_add_one' => $c_billing_add_one,
                    'c_billing_add_two' => $c_billing_add_two,
                    'c_zipcode' => $c_zipcode,
                    'c_city' => $c_city,
                    'o_total_price' => $o_total_price,
                    'o_status' => $o_status,
                    'o_cancelled_at' => $o_cancelled_at,
                    'o_payment_gateway' => $o_payment_gateway,
                    'o_special_discount' => $o_special_discount,
                    'o_card_id_number' => $o_card_id_number,
                    'o_card_discount' => $o_card_discount,
                    'o_card_discount_number' => $o_card_discount_number,
                    'property_note' => $property_note,
                    'variant_price' => $variant_price,
                    'variant_name' => $variant_name,
                    'product_name' => $product_name,
                    'total_quantity_sold' => $total_quantity_sold,
                    'hub_area' => $hub_area]);


    return true;

}

/*==============================================================
                check the excel file if order number is exist
=================================================================*/
public function orderNumberIfExist($order_number){
    $sql = "SELECT * FROM `order_details` WHERE `order_number` = :order_number";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_number' => $order_number,]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}


public function orderDoubleCheck($var_order_number,
                                 $var_property_note,
                                 $var_variant_name,
                                 $var_product_name,
                                 $var_total_quantity_sold){
    $sql = "SELECT * FROM `order_details` WHERE `order_number` = :order_number AND 
                                                `property_note` = :property_note AND
                                                `variant_name` = :variant_name AND
                                                `product_name` = :product_name AND
                                                `total_quantity_sold` = :total_quantity_sold";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_number' => $var_order_number,
                        'property_note' => $var_property_note,
                        'variant_name' => $var_variant_name,
                        'product_name' => $var_product_name,
                        'total_quantity_sold' => $var_total_quantity_sold]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
/*==============================================
                HUB function method
==================================================*/
    public function insertHubNumber($hubNumber,$hubZipcode){
        $sql = "INSERT INTO `hub_area_number` (`hub_area`,`zip_code`) VALUES (:hubNumber,:zip_code)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hubNumber' => $hubNumber,
                        'zip_code' => $hubZipcode]);
    
        return true;
    }


    public function readAllHubData(){

        $data = array(); //declare the variable to store the data

        $sql = "SELECT * FROM `hub_area_number`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row){
            $data[] = $row;
        }

        return $data;
    }

    public function rHubZipcode($id){

        $data = array();

        $sql = "SELECT * FROM hub_area_number WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        foreach ($results as $row){
            $data[] = $row;
        }

        return $data;
    
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

    public function updateHub($id,$hubNumber) {
        $sql = "UPDATE `hub_area_number` SET 
        hub_area = :hub_area WHERE id = :id";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hub_area' => $hubNumber, 
                        'id' => $id]);
    }

    public function deleteHubNumber($id){
        $sql = "DELETE FROM `hub_area_number` WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
    
        return true;
    }

    public function getHubId($id){
        $sql = "SELECT * FROM hub_area_number WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

        return $result;

    }

    public function updateHubDetails($id,$hubNumber,$editInputZipcode) {
        $sql = "UPDATE `hub_area_number` SET 
        `hub_area` = :hub_area,`zip_code` = :zipcode WHERE `id` = :id";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hub_area' => $hubNumber,
                        'zipcode'=>$editInputZipcode,
                        'id' => $id]);
    }


    public function ifExisting($hubNumber){

        $sql = "SELECT * FROM `hub_area_number` WHERE `hub_area` = :hub_area";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hub_area' => $hubNumber]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return  $results;
    }

    /*==============================================
                END HUB function method
==================================================*/



    /*==============================================
                ADD ACCOUNT function method
==================================================*/

public function insertAccount($fname, $lname, $uname, $upass, $ucontact, $urole, $uhubnumber){
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

public function user_fName_And_Lname_Exist($fname, $lname){

    $sql = "SELECT * FROM `users_table` WHERE `first_name` = :fname AND `last_name` = :lname";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname,
                    'lname' => $lname]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return  $results;
}

public function readAllAccountData(){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `users_table`";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}
// MARK CURRENT
public function selectAllOrderNumber($order_number){

        $sql = "SELECT * FROM `order_details` WHERE `order_number` = :order_number";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_number' => $order_number]);
                        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return  $results;
}

public function readAllOrderData($fRequest){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `o_status` = :fordelivery";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fordelivery' => $fRequest]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function readAllOrderDataStatusByHub(){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details`";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}


public function readAllOrderDataForSafe(){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details`";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
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

public function getAccountId($id){
    $sql = "SELECT * FROM users_table WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    return $result;

}

public function getCustomerDetails($id){
    $sql = "SELECT * FROM `order_details` WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    return $result;

}

public function eupdateAccount_Details($id,$fname,$lname,$uname,$userPassword,$userContact,$userRole,$hubArea) {
    $sql = "UPDATE users_table SET 
    first_name = :fname, last_name = :lname, user_username = :uname, 
    user_password = :userPassword, user_contact_number = :userContact, 
    user_role = :userRole, hub_area = :hubArea 
    WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname, 
                    'lname' => $lname, 
                    'uname' => $uname, 
                    'userPassword' => $userPassword,
                    'userContact' => $userContact,
                    'userRole' => $userRole,
                    'hubArea' => $hubArea,
                    'id' => $id]);
}

public function deleteAccount($id){
    $sql = "DELETE FROM `users_table` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    return true;
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

public function updateOstats($disOstatus,$copyOrderNumber) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :o_status WHERE `order_number` = :order_number";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['o_status' => $disOstatus,
                    'order_number' => $copyOrderNumber]);
}

public function readAllCancelledOrderDataPerHub($filterKey){

    $data = array(); //declare the variable to store the data
    
    $sql = "SELECT * FROM `order_details` WHERE `o_status`=:filterKey";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['filterKey' => $filterKey]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function getAllHubArea(){
    $sql = "SELECT * FROM hub_area_number";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    return $result;

}

public function functionForHubFilteringByPending($hubnumber){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hubnumber' => $hubnumber]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function selectAllorderByDate($currentDateStart,$currentDateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :currentDateStart AND :currentDateEnd";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$currentDateStart,
        'currentDateEnd'=>$currentDateEnd
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByHubNumberAndDate($hubnumber,$dateStart,$dateEnd){

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

public function filterByOstatusAndDatePending($orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `o_status` = :orderStatus";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'orderStatus'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }
    return $data;

}

public function filterByOstatusAndDate($orderStatus,$dateStart,$dateEnd){

    $data = array();

    $sql = "SELECT * FROM `orderdetailsviews` WHERE `hub_order_dispatched_date` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array();

    $sql = "SELECT * FROM `orderdetailsviews` WHERE `hub_order_dispatched_date` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status AND `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus,
        'hubnumber'=>$hubnumber
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusDateAndHubForDelivery($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array();

    $sql = "SELECT * FROM `filterbyostatusanddatefordelivery` WHERE `shipper_for_delivery_date` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status AND `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus,
        'hubnumber'=>$hubnumber
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubAndDateForPaid($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array();

    $sql = "SELECT * FROM `filterbyostatusanddateforpaid` WHERE `shipper_for_delivered_date` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status AND `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus,
        'hubnumber'=>$hubnumber
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusHubAndDateForvoided($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array();

    $sql = "SELECT * FROM `filterbyostatusanddateforvoided` WHERE `date_voided_by_hub_or_shipper` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status AND `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus,
        'hubnumber'=>$hubnumber
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
    
}

public function filterByOstatusAndDateForPaid($orderStatus,$dateStart,$dateEnd){

    $data = array();
    
    $sql = "SELECT * FROM `filterbyostatusanddateforpaid` WHERE `shipper_for_delivered_date` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusAndDateForvoided($orderStatus,$dateStart,$dateEnd){

    $data = array();
    
    $sql = "SELECT * FROM `filterbyostatusanddateforvoided` WHERE `date_voided_by_hub_or_shipper` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

public function filterByOstatusAndDateForDelivery($orderStatus,$dateStart,$dateEnd){

    $data = array();
    
    $sql = "SELECT * FROM `filterbyostatusanddatefordelivery` WHERE `shipper_for_delivery_date` BETWEEN :currentDateStart AND :currentDateEnd AND `o_status` = :o_status";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'currentDateStart'=>$dateStart,
        'currentDateEnd'=>$dateEnd,
        'o_status'=>$orderStatus
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function filterByHubnumberOstatusAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_date` BETWEEN :dateStart AND :dateEnd AND `o_status` = :orderStatus AND `hub_area` = :hubnumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'dateStart'=>$dateStart,
        'dateEnd'=>$dateEnd,
        'orderStatus'=>$orderStatus,
        'hubnumber' => $hubnumber
        ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;

}

////chart Methods
public function ShowPaidData($o_year){
    $paidKey = 'paid';

        $sql = "CALL `adminOViewsPaid`(:_paid,:_ship_date)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindparam(":_paid", $paidKey);
        $stmt->bindparam(":_ship_date", $o_year);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
}

public function ShowVoidedData($o_year){
    $voidKey = 'voided';

        $sql = "CALL `adminOViewsVoided`(:_voided,:_ship_date_voided)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindparam(":_voided", $voidKey);
        $stmt->bindparam(":_ship_date_voided", $o_year);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
}

public function ShowPaidDataHubAndYear($hubNumber, $o_year){
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

public function ShowVoidedDataHubAndYear($hubNumber, $o_year){
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

public function orderImportHistoryData($fileName,$hubNumber,$order_number,$c_fullname,$fnameAndLname,$uID){
    $sql = "INSERT INTO `order_import_history` (`file_name`,`hub_area`,`order_number`,`c_name`,`user_fname_lname`,`user_id`) 
    VALUES (:csvName,:hub_area,:order_number,:c_name,:user_fname_lname,:userID)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['csvName'=>$fileName,
                    'hub_area'=>$hubNumber,
                    'order_number'=>$order_number,
                    'c_name'=>$c_fullname,
                    'user_fname_lname'=>$fnameAndLname,
                    'userID'=>$uID
    ]);

    return true;
}

public function importHistoryData($id){
    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_import_history` WHERE `id` = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function importHistoryDataView(){
    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_import_history`";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function getNAItem(){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `not_available_item_history`";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
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

public function zipcodeChecking($c_zipcode){

        $sql = "CALL `zipcodeSearch`(:searchThisZip)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindparam(":searchThisZip", $c_zipcode);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
}

public function readAllUncosoOrders(){

    $undefinedKey = "undefined";
    $uncoveredKey = "not covered";

    $data = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `hub_area` = :undefinedOrder OR `hub_area` = :notcoverOrder";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['undefinedOrder' => $undefinedKey,
                    'notcoverOrder' => $uncoveredKey
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $data[] = $row;
    }

    return $data;
}

public function getOrderByOrderNumbers($orderNumber){

    $datas = array(); //declare the variable to store the data

    $sql = "SELECT * FROM `order_details` WHERE `order_number` = :orderNumber";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['orderNumber' => $orderNumber]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row){
        $datas[] = $row;
    }

    return $datas;
}


public function updateHubBecauseItsNoHub($hubArea,$orderNumber){
    
    $sql = "UPDATE `order_details` SET 
    `hub_area` = :hub_area WHERE `order_number` = :order_number";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub_area' => $hubArea,
                    'order_number' => $orderNumber
    ]);

}

public function updateHubAreaZipCode($finalZipcodeToSave,$hubArea){
    
    $sql = "UPDATE `hub_area_number` SET 
    `zip_code` = :zip_code WHERE `hub_area` = :hub_area";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['zip_code' => $finalZipcodeToSave,
                    'hub_area' => $hubArea
    ]);

}

public function gettedHubArea($hubArea){

    $sql = "SELECT * FROM `hub_area_number` WHERE `hub_area` = :hub_area";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['hub_area' => $hubArea]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return  $result;
}


public function updateOstatusAndRemarks($orderNum,$remarks,$voided,$pedingOrderTimeVoided,$dateForoCancelledAtColumn) {
    $sql = "UPDATE `order_details` SET
    `o_status` = :o_status,`remarks` = :remarks, `consolidator_date_time_voided_order` = :pedingOrderTimeVoided, `o_cancelled_at` = :o_cancelled_at, 
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

public function getCustomerOderDetailCheckedWhoVoid($orderNumber){

    $data = array(); //declare the variable to store the data

    $sql = "SELECT DISTINCT `order_date`,
                            `order_number`,
                            `hub_area`,
                            `shipper_user_id`,
                            `remarks`,
                            `hub_order_dispatched_date_time`,
                            `hub_pending_date_time_voided`,
                            `shipper_for_delivery_date_time`,
                            `shipper_for_voided_date_time`,
                            `consolidator_date_time_voided_order`
    FROM `order_details` WHERE `order_number` = :order_number";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['order_number' => $orderNumber]);
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

public function getReturnOrder(){

    $sql = "SELECT * FROM `return_history_order` ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return  $results;
}



}

?>
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

}


?>
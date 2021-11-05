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
                HUB function method
==================================================*/
    public function insertHubNumber($hubNumber){
        $sql = "INSERT INTO `hub_area_number` (`hub_area`) VALUES (:hubNumber)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hubNumber' => $hubNumber,]);
    
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

     public function updateHubDetails($id,$hub_area) {
        $sql = "UPDATE hub_area_number SET hub_area = :hubArea WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hubArea' => $hub_area, 
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

public function getAccountId($id){
    $sql = "SELECT * FROM users_table WHERE id = :id";
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

}

?>
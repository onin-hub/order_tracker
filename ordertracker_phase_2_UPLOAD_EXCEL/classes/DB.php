<?php


class DB{

    //code to connect into the database
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

    /***********************
     * Start code here
     ***********************/

     /***********************
     * insert Method
     ***********************/
    public function insertData($fname,$lname,$uname,$userPassword,$userContact,$userRole,$hubArea){
        $sql = "INSERT INTO users_table (first_name, last_name, user_username, user_password, user_contact_number, user_role, hub_area) VALUES 
        (:fname, :lname, :uname, :userPassword, :userContact, :userRole, :hubArea)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fname' => $fname,
                        'lname' => $lname,
                        'uname' => $uname,
                        'userPassword' => $userPassword,
                        'userContact' => $userContact,
                        'userRole' => $userRole,
                        'hubArea' => $hubArea ]);

        return true;

    }

     /***********************
     * insert hub Method
     ***********************/
    public function insertHubData($hubNumber){
        $sql = "INSERT INTO hub_area_number (hub_area) VALUES 
        (:hubNum)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hubNum' => $hubNumber,]);

        return true;

    }

     /*******************************************************
     * retrieve or select all the data from the database
     * RENDER DATA for users_table
     *******************************************************/
    public function readAllData(){

        $data = array(); //declare the variable to store the data

        $sql = "SELECT * FROM users_table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row){
            $data[] = $row;
        }

        return $data;
    }

    /*******************************************************
     * GET user Id method
     *******************************************************/
    public function getUserId($id){
        $sql = "SELECT * FROM users_table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

        return $result;

    }

/*******************************************************
     * GET hub Id method
     *******************************************************/
    public function getHubId($id){
        $sql = "SELECT * FROM hub_area_number WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

        return $result;

    }

    /*******************************************************
     * update Method add account
     *******************************************************/
    public function update($id,$fname,$lname,$uname,$userPassword,$userContact,$userRole,$hubArea) {
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
      /*******************************************************
     * update Method Hub
     *******************************************************/
    public function updateHubDetails($id,$hub_area) {
        $sql = "UPDATE hub_area_number SET hub_area = :hubArea WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['hubArea' => $hub_area, 
                        'id' => $id]);
    }

    /*******************************************************
     * Delete Method in users_table
     *******************************************************/
    public function delete($id){
        $sql = "DELETE FROM users_table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    
    /*******************************************************
     * Delete Method in users_table
     *******************************************************/
    public function deleteHub($id){
        $sql = "DELETE FROM hub_area_number WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

   /*******************************************************
     * users_table row count method
     *******************************************************/
    public function totalRowCount(){
        $sql = "SELECT * FROM users_table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $t_rows = $stmt->rowCount(); // rowCount method is a build in method of php , that count the row data in the database

        return $t_rows; // to use the row count in if statement
    }

/*******************************************************
     * retrieve or select all the data from the database
     * RENDER DATA for hub_area_number table
     *******************************************************/
    public function readAllHubData(){
        
        $data = array(); //declare the variable to store the data

        $sql = "SELECT * FROM hub_area_number";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row){
            $data[] = $row;
        }

        return $data;
    }

    /*******************************************************
     *Code Here
     *******************************************************/





}






/***********************************************************************************************
 *                   HOW TO USE THE METHOD OR FUNCTION INSIDE THE CLASS
 ***********************************************************************************************/
// $ob = new DB();              create a new object to use the function inside the class
// echo $ob->totalRowCount();   sample of code t use the function or method inside the class








?>
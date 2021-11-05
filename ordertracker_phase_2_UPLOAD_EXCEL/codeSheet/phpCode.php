<?php
/***********************************************************************************************
 *                   HOW TO USE THE METHOD OR FUNCTION INSIDE THE CLASS
 ***********************************************************************************************/
//  $ob = new DB();              create a new object to use the function inside the class
// echo $ob->totalRowCount();   sample of code t use the function or method inside the class

/***********************************************************************************************
 *                                      Auto loader classes
 ***********************************************************************************************/
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});







/***********************************************************************************************
 *                                      SOME CODE SHEET
 ***********************************************************************************************/
class SampleCode{

 /***********************************************************************************************
 *                    Code to Connect into the database
 ***********************************************************************************************/
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


/***********************************************************************************************
                INSERT
 ***********************************************************************************************/
public function insert($fname,$lname,$uname,$userPassword,$userContact,$userRole,$hubArea){
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


/***********************************************************************************************
                UPDATE
 ***********************************************************************************************/
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

/***********************************************************************************************
                Delete
 ***********************************************************************************************/
public function delete($id){
    $sql = "DELETE FROM users_table WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    return true;
}
/***********************************************************************************************
                GET
 ***********************************************************************************************/
public function getHubId($id){
    $sql = "SELECT * FROM hub_area_number WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    return $result;

}

/***********************************************************************************************
 *                 NOTE HERE
 ***********************************************************************************************/




}






?>
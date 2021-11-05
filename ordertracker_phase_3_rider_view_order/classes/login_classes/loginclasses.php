<?php

class loginclasses{

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


    public function checkUnameAndPassword($user_name, $user_password){

        $sql = "SELECT * FROM users_table WHERE user_username = :user_username AND user_password = :user_password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_username' => $user_name,
                        'user_password' => $user_password]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch is a fetch of a single data
        
        return $result;
    }




}
?>
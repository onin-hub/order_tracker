
<?php


class DB{
    private $dsn = "mysql:host=localhost;dbname=csv_import_testing";
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

    public function insertSample($name,$udepartment,$salary){
        $sql = "INSERT INTO `testing_import` (`user_name`, `u_department`, `salary`) VALUES 
        (:uname, :udepartment, :salary)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uname' => $name,
                        'udepartment' => $udepartment,
                        'salary' => $salary]);
    
        return true;
    
    }
}

?>
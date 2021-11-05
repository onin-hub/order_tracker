<?php

//=============================================================================
// HOW TO USE THE METHOD OR FUNCTION INSIDE THE CLASS
//=============================================================================

//  $ob = new DB();              create a new object to use the function inside the class
// echo $ob->totalRowCount();   sample of code t use the function or method inside the class

//=============================================================================
// Auto loader classes
//=============================================================================
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

//=============================================================================
// SOME CODE
//=============================================================================

class SampleCode{

//=============================================================================
// Code to Connect into the database
//=============================================================================
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

//=============================================================================
// INSERT
//=============================================================================
public function insert($fname){
    $sql = "INSERT INTO users_table (first_name) VALUES (:fname)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname]);

    return true;

}

//=============================================================================
// UPDATE
//=============================================================================
public function update($fname) {
    $sql = "UPDATE users_table SET 
    first_name = :fname WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['fname' => $fname]);

}

//=============================================================================
// Delete
//=============================================================================
public function delete($id){
    $sql = "DELETE FROM users_table WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    return true;
}

//=============================================================================
// GET
//=============================================================================
public function getHubId($id){
    $sql = "SELECT * FROM hub_area_number WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch is a fetch of a single data

    return $result;
}

}

//=============================================================================
// GET THE data by id , and use to Json_encode (kapag array na nung binabato mo sa ajax)
//=============================================================================
if(isset($_POST['action']) && $_POST['action'] == "getHubDetailsById" ){

    $hubId = $_POST['id'];
    $row = $db->getHubId($hubId);

    echo json_encode($row); //json_encode
}

//=============================================================================
// Else if with json_encode data kase (array na nung inecho pabalik sa ajax)
//=============================================================================
 if(isset($_POST['action']) && $_POST['action'] == "addHubNumber" ){
    $hubNumber = strtoupper($_POST['hubNumber']);

    $data = $db->ifExisting($hubNumber);

    if(!empty($data)){
            $response['condition'] = 'error';
            $response = json_encode($response);
            echo $response;
    }elseif ($hubNumber == ''){
            $response['condition'] = 'empty';
            $response = json_encode($response);
            echo $response;
    }
    else{
            $db->insertHubNumber($hubNumber);
            $response['condition'] = 'success';
            $response = json_encode($response);
            echo $response;
    }
}

//=============================================================================
//  in_array (sample code)  inbuild function of php
//=============================================================================
/**
 * in_array function
 * kapag nasa array daw nung data do some condition or action
 */

 $foNumberArray = [];

 foreach ($rOrderData as $row){

    $order_number = $row['order_number'];

    if (in_array($order_number, $foNumberArray, TRUE)){
        continue;
    }else{
        $foNumberArray[] = $order_number;
        $output .= '<tr  class = "text-center text-secondary">
        <td>'.$row['id'].'</td>
        <td>'.$row['order_date'].'</td>
        <td>'.$row['order_number'].'</td>
        <td>'.$row['c_fullname'].'</td>
        <td>'.$row['c_pnumber_primary'].'</td>
        <td>
            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#" id = "'.$row['id'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
        </td>
      </tr>';
        
    }
    }

//=============================================================================
//  LOOPING
//=============================================================================

    
//=============================================================================
//  foreach loop
//=============================================================================
     foreach ($array as $row){
    $id = $row['id'];
    $order_date = $row['order_date'];
    $order_number = $row['order_number'];
    $c_fullname = $row['c_fullname'];
    $c_pnumber_primary = $row['c_pnumber_primary'];
  
}

//=============================================================================
//  while loop
//=============================================================================
$i = 0;
while ($i < count($array)){

    $i++;
}

//=============================================================================
//  for loop with foreach
//=============================================================================
$entry = [];
for ($i = 1; $i <= 12; $i++) { 

    $entry[] = 0;

    foreach ($dataGraphPaid  as $k => $v) {
        
        if ($i == $dataGraphPaid [$k]['Month']) {
            $entry[$i] = (int)$dataGraphPaid [$k]['Order Month'];
        }
    }

    unset($entry[0]);//unset (para tanggalin nung value sa array.)
}

//=============================================================================
//  Current Date and time
//=============================================================================
date_default_timezone_set('Asia/Manila');

// Then call the date functions
echo date('Y-m-d H:i:s') . "<br/>";
// Or
echo date('Y/m/d H:i:s');

//=============================================================================
//  How can I convert string to date type in PHP?
//=============================================================================
$time = strtotime('10/16/2003');
$newformat = date('Y-m-d',$time);
echo $newformat;
// 2003-10-16

date("m/d/Y H:i:s",strtotime($row['shipper_for_delivery_date_time']));

//=============================================================================
// Coalescing Operator (if walang laman nung POST na binato or na isset papalitan nya ng ibang laman)
//=============================================================================
/**
 * para hindi mag undefined nung variable
 */

$names = isset($_POST['name']) ? $_POST['name'] : 'nobody';


?>

<!--=============================================================================
format when you foreach inside the html in table  
=============================================================================-->
            <table id="hubTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Hub Number</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>
              <?php foreach ($rHubData as $hubRow) : ?>
                  <tr  class = "text-center text-secondary">
                    <td><?php echo $hubRow['id'] ?></td>
                    <td><?php echo $hubRow['hub_area'] ?></td>
                    <td>
                    
                        <a href="#" title="Edit Details" class="text-primary editBtn" data-toggle="modal" data-target="#editAddModal" > <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                        
                        <a href="#" title="Delete Details" class="text-danger delBtn" id = "'.$row['id'].'" > <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                    </td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
           </table>

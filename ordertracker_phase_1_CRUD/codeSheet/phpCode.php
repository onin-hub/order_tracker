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

}

/***********************************************************************************************
               GET THE data by id , and use to Json_encode
 ***********************************************************************************************/
if(isset($_POST['action']) && $_POST['action'] == "getHubDetailsById" ){

    $hubId = $_POST['id'];
    $row = $db->getHubId($hubId);
    echo json_encode($row); //json_encode
}

// sample code how to use json_encode(); inside the ajax
$.ajax({
    url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
    data: {
        'action' : "getHubDetailsById", //set an action to trigger , what if condition to be use.
        'id' : id
    },
    type: 'POST',
    success: function(response){
            data = JSON.parse(response);
            $("#id_HubNumber").val(data.id);
            $("#edit_Hub_Number").val(data.hub_area);
    }
 });

/***********************************************************************************************
               Else if with json_encode data
 ***********************************************************************************************/
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


?>

<!-- 
/***********************************************************************************************
 *                 format when you foreach inside the html in table
 ***********************************************************************************************/ -->
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


<!-- 
/***********************************************************************************************
 *              to make value forcing it to upper case
 ***********************************************************************************************/ -->
 style="text-transform: uppercase;
 <!-- 
/***********************************************************************************************
 *              to make value forcing it to upper case
 ***********************************************************************************************/ -->
 
<?php

include_once "../classes/DB.php";
$db = new DB();

/**************************************************
 * Viewing Code
***************************************************/
if (isset($_POST['action']) && $_POST['action'] == "view") {
    $output = '';
    $data = $db->readAllData();

   
            $output .= '
            <button type="button" class="btn btn-primary btn-sm my-3" data-toggle="modal" data-target="#addModal">Add Account</button>      
            <div class="container text-center">
            <h4>Account List</h4>
            </div>
            <table id="accountTable" class="display responsive nowrap table table-striped table-bordered " style="width:100%">
                            <thead>
                            <tr class = "text-center">
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact #</th>
                                <th>Role</th>
                                <th>Hub Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>';

                    foreach ($data as $row){
                        $output .= ' <tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.$row['first_name'].'</td>
                        <td>'.$row['last_name'].'</td>
                        <td>'.$row['user_contact_number'].'</td>
                        <td>'.$row['user_role'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>
                           
                            <a href="#" title="Edit Details" class="text-primary editBtn" data-toggle="modal" data-target="#editAddModal" id = "'.$row['id'].'"> <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                            
                            <a href="#" title="Delete Details" class="text-danger delBtn" id = "'.$row['id'].'" > <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                        </td>
                    </tr>';
                    }
                        $output .= '</tbody></table>';

                        echo $output;
                         // <a href="#" title="View Details" class="text-success" > <i class = "fas fa-info-circle fa-sm" ></i>  </a> &nbsp;&nbsp;

 
}

if (isset($_POST['action']) && $_POST['action'] == "viewHubDropDown") {
    $output = '';
    $data = $db->readAllHubData();

   
                        $output .= '<select class="custom-select" name = "uHub" id = "userHub">
                        <option selected>Choose...</option>';

                    foreach ($data as $row){

                        $output .= '
                        <option value="'.$row['hub_area'].'">'.$row['hub_area'].'</option>';
                    }
                    $output .= '</select> 
                    <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Hub Number</label>
                     </div>';

                        echo $output;

    
}

if (isset($_POST['action']) && $_POST['action'] == "viewHubDropDown2") {
    $output = '';
    $data = $db->readAllHubData();

   
                        $output .= '<select class="custom-select" name = "uHub" id = "userHub2">
                        <option selected>Choose...</option>';

                    foreach ($data as $row){

                        $output .= '
                        <option value="'.$row['hub_area'].'">'.$row['hub_area'].'</option>';
                    }
                    $output .= '</select> 
                    <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Hub Number</label>
                     </div>';

                        echo $output;

    
}

if (isset($_POST['action']) && $_POST['action'] == "viewHub") {
    $output = '';
    $data = $db->readAllHubData();

            $output .= '
            <button type="button" class="btn btn-primary btn-sm my-3" data-toggle="modal" data-target="#hubModal">Add Hub Area</button>
            <div class="container text-center">
                <h4>Hub List</h4>
            </div>
            <table id="hubTable" class="display responsive nowrap table table-striped table-bordered " style="width:100%">
                <thead>
                    <tr class = "text-center">
                        <th>Id</th>
                        <th>Hub Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

                    foreach ($data as $row){
                        $output .= ' <tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>
                            
                            <a href="#" title="Edit Details" class="text-primary editHub" data-toggle="modal" data-target="#editHubModal" id = "'.$row['id'].'"> <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                           
                            <a href="#" title="Delete Details" class="text-danger delHub" id = "'.$row['id'].'"> <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                        </td>
                    </tr>';
                    }
                        $output .= '</tbody></table>';

                        echo $output;
                        //<a href="#" title="View Details" class="text-success" > <i class = "fas fa-info-circle fa-sm" ></i>  </a> &nbsp;&nbsp;

    
}




/**************************************************
 * Action for insert delete update
***************************************************/

/******************************
 * if condition for add account
 ******************************/
if(isset($_POST['action']) && $_POST['action'] == "insert" ){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $userPassword = $_POST['pw'];
    $userContact = $_POST['contact'];
    $userRole = $_POST['uRole'];
    $HubArea = $_POST['uHub'];

    $db->insertData($fname, $lname, $uname, $userPassword, $userContact, $userRole, $HubArea );

}

/******************************
 * if condition for hub adding
 ******************************/
if(isset($_POST['action']) && $_POST['action'] == "insertHub" ){
    $hubNumber = $_POST['hubNumber'];
    $db->insertHubData($hubNumber);

}

/******************************
 * edit button add account
 ******************************/
if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $row = $db->getUserId($id);
    echo json_encode($row); //json_encode
}

/******************************
 * edit hub button 
 ******************************/
if(isset($_POST['edit_hub'])){
    $id = $_POST['edit_hub'];

    $row = $db->getHubId($id);
    echo json_encode($row); //json_encode

}

/******************************
 * edit button add account update
 ******************************/
if(isset($_POST['action']) && $_POST['action'] == "updateAddAccount" ){
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $userPassword = $_POST['pw'];
    $userContact = $_POST['contact'];
    $userRole = $_POST['uRole'];
    $HubArea = $_POST['uHub'];


    echo $_POST;
    // $db->update($id,$fname, $lname, $uname, $userPassword, $userContact, $userRole, $HubArea );
}

/******************************
 * edit button hub
 ******************************/
if(isset($_POST['action'])){

    $id = (isset($_POST['hubId'])) ? $_POST['hubId'] : ''; // use when undefine
    $hubArea =  (isset($_POST['hubNum'])) ? $_POST['hubNum'] : '';

    $db->updateHubDetails($id, $hubArea);
}

/******************************
 * delete button add account
 ******************************/
if (isset($_POST['del_id'])){
    $id = $_POST['del_id'];
    $db->delete($id);
   
}
/******************************
 * delete button of Hub
 ******************************/
if (isset($_POST['del_hub'])){

    $id = $_POST['del_hub'];
    $db->deleteHub($id);
}


?>
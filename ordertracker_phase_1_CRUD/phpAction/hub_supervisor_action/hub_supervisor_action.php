<?php

require '../../classes/hub_supervisor_classes/HubSupervisorClasses.php';

$db = NEW HubSupervisorClasses;


/*============================================================
        fetching data of SHIPPER ACCOUNT
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "viewShipperDataPerHub") {
    $output = '';
    $hubnumber = $_POST['hubnumber'];
    $urole = $_POST['urole'];

    $rHubData = $db->readAllShipperAccountData($hubnumber, $urole);

            $output .= '
            <button type="submit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addShipperModal" id = "addShipBtn">ADD SHIPPER</button>

            <table id="shipperTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Contact #</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($rHubData as $row){
                        $output .= ' <tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.$row['first_name'].'</td>
                        <td>'.$row['last_name'].'</td>
                        <td>'.$row['user_contact_number'].'</td>
                        <td>
                        
                            <a href="#" title="Edit Details" class="text-primary shipperEditBtn" data-toggle="modal" data-target="#EditaddShipperModal" id = "'.$row['id'].'"> <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                            
                            <a href="#" title="Delete Details" class="text-danger shipperDelBtn" id = "'.$row['id'].'" > <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                        </td>
                      </tr>';
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
}




if(isset($_POST['action']) && $_POST['action'] == "insertShipperAccount" ){
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $upass = $_POST['upass'];
    $ucontact = $_POST['ucontact'];
    $urole = $_POST['urole'];
    $suhubnumber = $_POST['suhubnumber'];
   

    $data = $db->shipper_fName_And_Lname_Exist($fname, $lname);

    if(!empty($data)){

        $response['condition'] = 'userExist';
        $response = json_encode($response);
        echo $response;
    }
    else{
        $db->insertShippertAccount($fname, $lname, $uname, $upass, $ucontact, $urole, $suhubnumber);

        $response['condition'] = 'success';
        $response = json_encode($response);
        echo $response;
    }

}


if(isset($_POST['action']) && $_POST['action'] == "deleteShipperDetails" ){

        $id = $_POST['id'];
        $db->deleteShipper($id);
    
}

if(isset($_POST['action']) && $_POST['action'] == "getShipperDetailsById" ){

    $shipperId = $_POST['id'];
    $row = $db->getShipperAccountId($shipperId);
    echo json_encode($row); //json_encode
}

if(isset($_POST['action']) && $_POST['action'] == "updateShipperDetails" ){

    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $upass = $_POST['upass'];
    $ucontact = $_POST['ucontact'];
   

    $db->updateShipper_Details($id, $fname, $lname, $uname, $upass, $ucontact);
}


?>
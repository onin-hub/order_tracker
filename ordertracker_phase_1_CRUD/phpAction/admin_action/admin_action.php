<?php

require '../../classes/admin_classes/AdminClasses.php';

$db = NEW AdminClasses;


/*============================================================
                        HUB NUMBER CODE
===============================================================*/


if (isset($_POST['action']) && $_POST['action'] == "viewHubData") {
    $output = '';
    $rHubData = $db->readAllHubData();

   
            $output .= '
            <button type="submit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addHubModal">ADD HUB</button>

            <table id="hubTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Hub Number</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($rHubData as $row){
                        $output .= ' <tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>
                        
                            <a href="#" title="Edit Details" class="text-primary updateHubBtn" data-toggle="modal" data-target="#editHubModal" id = "'.$row['id'].'"> <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                            
                            <a href="#" title="Delete Details" class="text-danger delHubBtn" id = "'.$row['id'].'"> <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                        </td>
                      </tr>';
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
}

/*======================
insert Hub Number
========================*/
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
/*======================
delete Hub Number
========================*/
if(isset($_POST['action']) && $_POST['action'] == "deleteHub" ){

    $hubId = $_POST['id'];
    $db->deleteHubNumber($hubId);

}

/*====================================
    get Hub Number and fetch the data
========================================*/
if(isset($_POST['action']) && $_POST['action'] == "getHubDetailsById" ){

    $hubId = $_POST['id'];
    $row = $db->getHubId($hubId);
    echo json_encode($row); //json_encode
}

if(isset($_POST['action']) && $_POST['action'] == "updateHubDetail" ){

    $hubId = $_POST['hubId'];
    $hubNumber = $_POST['hubNumber'];

    $db->updateHubDetails($hubId,$hubNumber);
}


/*============================================================
                        END HUB NUMBER CODE
===============================================================*/




/*============================================================
                        ADD ACCOUNT CODE
===============================================================*/

/*============================================================
        this is for fetching data for hub menu drop down
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "viewHubDataInDropDown") {
    $output = '';
    $rHubData = $db->readAllHubData();

            $output .= '<select class="custom-select" name = "uHub" id = "userHubNumber">
                    <option selected>Choose...</option>';

                    foreach ($rHubData as $row){

                        $output .= '
                        <option value="'.$row['hub_area'].'">'.$row['hub_area'].'</option>';
                    }
        $output .= ' </select> 
        <div class="input-group-append">
        <label class="input-group-text">Hub Number</label>
        </div>';

            echo $output;

}


/*======================================================================
        this is for fetching data for hub menu drop down for edit modal
=========================================================================*/
if (isset($_POST['action']) && $_POST['action'] == "editViewHubDataInDropDown") {
    $output = '';
    $rHubData = $db->readAllHubData();

            $output .= '<select class="custom-select" name = "uHub" id = "euserHubNumber">
                    <option selected>Choose...</option>';

                    foreach ($rHubData as $row){

                        $output .= '
                        <option value="'.$row['hub_area'].'">'.$row['hub_area'].'</option>';
                    }
        $output .= ' </select> 
        <div class="input-group-append">
        <label class="input-group-text">Hub Number</label>
        </div>';

            echo $output;

}

/*============================================================
        fetching data of account
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "viewAccountData") {
    $output = '';
    $rHubData = $db->readAllAccountData();

            $output .= '
            <button type="submit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addAccountModal" id = "dAddAccountInput">ADD ACCOUNT</button>

            <table id="addAcctTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
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

                    foreach ($rHubData as $row){
                        $output .= ' <tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.$row['first_name'].'</td>
                        <td>'.$row['last_name'].'</td>
                        <td>'.$row['user_contact_number'].'</td>
                        <td>'.$row['user_role'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>
                        
                            <a href="#" title="Edit Details" class="text-primary editAccountBtn" data-toggle="modal" data-target="#editAddAccountModal" id = "'.$row['id'].'"> <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                            
                            <a href="#" title="Delete Details" class="text-danger delAccountBtn" id = "'.$row['id'].'" > <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                        </td>
                      </tr>';
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
}
/*============================================================
                        Insert account 
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "insertAccount") {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = trim($_POST['uname']);
    $upass = trim($_POST['upass']);
    $ucontact = $_POST['ucontact'];
    $urole = $_POST['urole'];
    $uhubnumber = $_POST['uhubnumber'];

    $data = $db->user_fName_And_Lname_Exist($fname, $lname);

    if(!empty($data)){

        $response['condition'] = 'userExist';
        $response = json_encode($response);
        echo $response;
    }
    else{
        $db->insertAccount($fname, $lname, $uname, $upass, $ucontact, $urole, $uhubnumber);

        $response['condition'] = 'success';
        $response = json_encode($response);
        echo $response;
    }

}


/*====================================
    get account Number and fetch the data
========================================*/
if(isset($_POST['action']) && $_POST['action'] == "getAccountDetailsById" ){

    $accountId = $_POST['id'];
    $row = $db->getAccountId($accountId);
    echo json_encode($row); //json_encode
}


/*====================================
   update account details
========================================*/
if(isset($_POST['action']) && $_POST['action'] == "editUpdateAccountDetail" ){

    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $upass = $_POST['upass'];
    $ucontact = $_POST['ucontact'];
    $urole = $_POST['urole'];
    $hubarea = $_POST['uhubnumber'];

    $db->eupdateAccount_Details($id, $fname, $lname, $uname, $upass, $ucontact, $urole, $hubarea);
}



/*======================
delete Account
========================*/
if(isset($_POST['action']) && $_POST['action'] == "deleteAccount" ){

    $id = $_POST['id'];
    $db->deleteAccount($id);

}
/*============================================================
                       END ADD ACCOUNT CODE
===============================================================*/

?>
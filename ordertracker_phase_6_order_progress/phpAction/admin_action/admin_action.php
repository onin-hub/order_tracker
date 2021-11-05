<?php

require '../../classes/admin_classes/AdminClasses.php';

$db = new AdminClasses;

/*============================================================
                       EXCEL IMPORTING CODE csv type file
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "insertExcel") {
    
    $response = [];

    $foOrderNumber = [];
    $hubAreaArray = [];
    $cName = [];


    $hubNumber = $_POST['importHubNumber'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $fnameAndLname = $fname . ' ' . $lname;
    $uID = $_POST['uID'];


    if ($hubNumber == 'Choose...'){
        $response['type'] = "insertHubNumber";
        $response['msg'] = "Please insert hub number first";
        $response = json_encode($response);
        echo $response;

    }
    else {
    
            if (!empty($_FILES)) {
                $allowedFileType = ['application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

                if (in_array($_FILES["file"]["type"], $allowedFileType)) {
            
                    $file = $_FILES["file"];
                    $file = $_FILES['file']['tmp_name'];
                    $fileName = $_FILES["file"]['name'];
                    
                    $handle = fopen($file, "r");
                    $ctr = 1;
            
                    while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            
                        if ($ctr == 1) { 
                            $ctr++;
                            continue; 
                        }

                        $order_date = strip_tags(trim(date("Y/m/d", strtotime($filesop[0]))));
                        // echo $order_date;
                      
                        $order_number = strip_tags(trim($filesop[1]));
                        $c_fullname = strip_tags(trim($filesop[2]));
                        $c_pnumber_one = strip_tags(trim($filesop[3]));
                        $c_pnumber_two = strip_tags(trim($filesop[4]));
                        $c_pnumber_primary = strip_tags(trim($filesop[5]));
                        $c_email = strip_tags(trim($filesop[6]));
                        $order_note = strip_tags(trim($filesop[7]));
                        $c_address_one = strip_tags(trim($filesop[8]));
                        $c_address_two = strip_tags(trim($filesop[9]));
                        $c_billing_add_one = strip_tags(trim($filesop[10]));
                        $c_billing_add_two = strip_tags(trim($filesop[11]));
                        $c_zipcode = strip_tags(trim($filesop[12]));
                        $c_city = strip_tags(trim($filesop[13]));
                        $o_total_price = strip_tags(trim($filesop[14]));
                        $o_status = strip_tags(trim($filesop[15]));
                        $o_cancelled_at = strip_tags(trim($filesop[16]));
                        $o_payment_gateway = strip_tags(trim($filesop[17]));
                        $o_special_discount = strip_tags(trim($filesop[18]));
                        $o_card_id_number = strip_tags(trim($filesop[19]));
                        $o_card_discount = strip_tags(trim($filesop[20]));
                        $o_card_discount_number = strip_tags(trim($filesop[21]));
                        $property_note = strip_tags(trim($filesop[22]));
                        $variant_price = strip_tags(trim($filesop[23]));
                        $variant_name = strip_tags(trim($filesop[24]));
                        $product_name = strip_tags(trim($filesop[25]));
                        $total_quantity_sold = strip_tags(trim($filesop[26]));

                        // trapping condition start
                        $no_double_order_checking = $db->orderDoubleCheck($order_number,
                                                                          $property_note,
                                                                          $variant_name,
                                                                          $product_name,
                                                                          $total_quantity_sold);

                            if ($order_date == "1970/01/01" || $order_date == "") {
                                continue;
                            }elseif(!empty($no_double_order_checking)){
                                continue;
                            }
                            else {
                                // insert query here
                                        $resultExcel = $db->insertExcelOrder($order_date,
                                                                            $order_number,
                                                                            $c_fullname,
                                                                            $c_pnumber_one,
                                                                            $c_pnumber_two,
                                                                            $c_pnumber_primary,
                                                                            $c_email,
                                                                            $order_note,
                                                                            $c_address_one,
                                                                            $c_address_two,
                                                                            $c_billing_add_one,
                                                                            $c_billing_add_two,
                                                                            $c_zipcode,
                                                                            $c_city,
                                                                            $o_total_price,
                                                                            $o_status,
                                                                            $o_cancelled_at,
                                                                            $o_payment_gateway,
                                                                            $o_special_discount,
                                                                            $o_card_id_number,
                                                                            $o_card_discount,
                                                                            $o_card_discount_number,
                                                                            $property_note,
                                                                            $variant_price,
                                                                            $variant_name,
                                                                            $product_name,
                                                                            $total_quantity_sold,
                                                                            $hubNumber);
        
                                            // code here for order import history
                                            if(in_array($hubNumber, $hubAreaArray, TRUE)){
                                                if(in_array($order_number, $foOrderNumber, TRUE)){
                                                    continue;
                                                }else{
                                                    $foOrderNumber[] = $order_number;
                                                    $cName[] = $c_fullname;
                                                }
                                            }else{
                                                // $db->orderImportHistoryData($fileName,$hubNumber,$order_number,$c_fullname);
                                                $hubAreaArray[] = $hubNumber;
                                                $foOrderNumber[] = $order_number;
                                                $cName[] = $c_fullname;
                                            }

                                        if (!empty($resultExcel)) {

                                            $response['type'] = "success";
                                            $response['msg'] = "CSV Data successfully imported!";

                                        } else {
                                            $response['type'] = "error";
                                            $response['msg'] = "Problem in importing Excel Data";
                                        }
                            }
                    }
            
                } else { 
                    $response['type'] = "error";
                    $response['msg'] = "Invalid file type. Upload a CSV file.";
                }
            
            } else {
                $response['type'] = "error";
                $response['msg'] = "Please upload a CSV file.";
                }

                //code here for order import history
                if(count($foOrderNumber) == 0){

                $response['type'] = "error";
                $response['msg'] = "no data uploaded";

                }elseif(count($foOrderNumber) == 1){
                    $orderNumbers = implode($foOrderNumber);
                    $cNames = implode($cName);
                    $db->orderImportHistoryData($fileName,$hubNumber,$orderNumbers,$cNames,$fnameAndLname,$uID);
                }else{

                    $orderNumbers = implode(" , ",$foOrderNumber);
                    $cNames = implode(" , ",$cName);
                    $db->orderImportHistoryData($fileName,$hubNumber,$orderNumbers,$cNames,$fnameAndLname,$uID);

                }

                $response = json_encode($response);
                echo $response;

                // echo json_encode($foOrderNumber);
               
        }
}
/*============================================================
                        HUB NUMBER CODE
===============================================================*/


if (isset($_POST['action']) && $_POST['action'] == "viewHubData") {
    $output = '';
    $rHubData = $db->readAllHubData();

            $output .= '
            <button type="submit" class="btn btn-success btn-sm addHubBtnTop" data-toggle="modal" data-target="#addHubModal">ADD HUB</button>

            <table id="hubTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Hub Number</th>
                      <th>Zip code</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($rHubData as $row){
                        $Zipcode = $row['zip_code'];
                        $shortZipcode = "$Zipcode";

                        $output .= ' <tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td><a href="#" title="Zipcode" class="text-info getHubZipcodeDetails" data-toggle="modal" data-target="#showHubZipcodeModal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a></td>
                        <td>
                        
                            <a href="#" title="Edit Details" class="text-primary updateHubBtn" data-toggle="modal" data-target="#editHubModal" id = "'.$row['id'].'"> <i class = "fas fa-edit fa-sm" ></i>  </a> &nbsp;&nbsp;
                            
                            <a href="#" title="Delete Details" class="text-danger delHubBtn" id = "'.$row['id'].'"> <i class = "fas fa-trash-alt fa-sm" ></i>  </a>
                        </td>
                      </tr>';
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
                        substr('Hello', 1, 3);
}

/*======================
insert Hub Number
========================*/
if(isset($_POST['action']) && $_POST['action'] == "addHubNumber" ){
    $hubNumber = strtoupper($_POST['hubNumber']);
    $hubZipcode = $_POST['hubZipcode'];

    $data = $db->ifExisting($hubNumber);

    if(!empty($data)){

            $response['condition'] = 'error';
            $response = json_encode($response);
            echo $response;

    }
    elseif ($hubNumber == ''){
            $response['condition'] = 'empty';
            $response = json_encode($response);
            echo $response;
            
    }
    elseif ($hubZipcode == ''){
        $response['condition'] = 'emptyZipCode';
        $response = json_encode($response);
        echo $response;
        
    }
    else{
            $db->insertHubNumber($hubNumber,$hubZipcode);

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
    $editInputZipcode = $_POST['editInputZipcode'];

    $db->updateHubDetails($hubId,$hubNumber,$editInputZipcode);
   
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
/*============================================================
        this is for fetching data for import menu drop down
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "importDropdown") {
    $output = '';
    $rHubData = $db->readAllHubData();

            $output .= '<div class="input-group mb-3"><select class="custom-select" name = "uHub" id = "importHubNumber">
                    <option selected>Choose...</option>';

                    foreach ($rHubData as $row){

                        $output .= '
                        <option value="'.$row['hub_area'].'">'.$row['hub_area'].'</option>';
                    }
        $output .= ' </select> 
        <div class="input-group-append">
        <label class="input-group-text">Hub Number</label>
        </div> </div>';

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

if (isset($_POST['action']) && $_POST['action'] == "getHubZipcode") {

    $id = $_POST['id'];
    $output = '';

    $rHubZipcode = $db->rHubZipcode($id);

    $zipToString = '';
    $zipExploded = '';

            foreach ($rHubZipcode as $zip){
                $zipToString = $zip['zip_code'];
                // $zipExploded = explode(",", $zipToString);

            }

            $output .= '<div class="list-group"> <ul class="list-group list-group-flush">';
            
            // foreach ($zipExploded as $strZip){
                
                $output .= '<li class="list-group-item">'.$zipToString.'</li>';
            // }

            $output .= '</ul></div>'; 
            
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
        data from order excel 
===============================================================*/
if (isset($_POST['action']) && $_POST['action'] == "showOrderDetails") {

    $output = '';
  
    $order_date = '';
    $order_number = '';
  
    $foNumberArray = []; // admin show all pending order (all hub)

    $rOrderData = $db->readAllOrderDataForSafe();

            $output .= '
            <table id="orderTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Status</th>
                      <th>Hub area</th>
                      <th>Zip code</th>
                      <th>Customer name</th>
                      <th>Phone number (primary)</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($rOrderData as $row){

                        $order_number = $row['order_number'];
                        
                        if (in_array($order_number, $foNumberArray, TRUE)){
                            continue;
                        }
                        else{
                            $foNumberArray[] = $order_number;
                            $output .= '<tr  class = "text-center text-secondary">
                            <td>'.$row['id'].'</td>
                            <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                            <td>'.$row['order_number'].'</td>
                            <td>'.$row['o_status'].'</td>
                            <td>'.$row['hub_area'].'</td>
                            <td>'.$row['c_zipcode'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
}


if (isset($_POST['action']) && $_POST['action'] == "showDispatchOrderDetails") {

    $output = '';
    $id = '';
    $order_date = '';
    $order_number = '';
    $c_fullname = '';
    $c_pnumber_primary = '';
    $foNumberArray = [];
    $forChecking = 'for checking';

    $rOrderData = $db->readAllOrderData($forChecking);

            $output .= '
            <table id="DispatchOrderTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Customer Name</th>
                      <th>Phone number (primary)</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($rOrderData as $row){

                        $order_number = $row['order_number'];
                        $o_status = $row['o_status'];
 

                        if (in_array($order_number, $foNumberArray, TRUE)){
                            continue;
                        }elseif ($o_status == 'pending'){
                            continue;
                        }
                        else{
                            $foNumberArray[] = $order_number;
                            $output .= '<tr  class = "text-center text-secondary">
                            <td>'.$row['id'].'</td>
                            <td>'.$row['order_date'].'</td>
                            <td>'.$row['order_number'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                            </td>
                          </tr>';
                            
                        }
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

if (isset($_POST['action']) && $_POST['action'] == "getCustomerId") {
    $id = $_POST['id'];
    $output = '';
    $rHubData = $db->getCustomerId($id);

                    foreach ($rHubData as $row){
                        $output .= ' 
                        <ul>
                            <li>Name: '.$row['c_fullname'].'</li>
                            <li>Primay #: '.$row['c_pnumber_primary'].'</li>
                            <li>Contact #2: '.$row['c_pnumber_one'].'</li>
                            <li>Contact #3: '.$row['c_pnumber_two'].'</li>
                            <li>Address 1: '.$row['c_address_one'].'</li>
                            <li>Address 2: '.$row['c_address_two'].'</li>
                            <li>Billing address 1: '.$row['c_billing_add_one'].'</li>
                            <li>Billing address 2: '.$row['c_billing_add_two'].'</li>
                            <li>Land-mark / General Order note: '.$row['order_note'].'</li>
                            <li>Special Discount: '.$row['o_special_discount'].'</li>
                            <li>Card/ID number: '.$row['o_card_id_number'].'</li>
                            <li>Gift Cert/ Qpoints: '.$row['o_card_discount'].'</li>
                            <li>GC/Qpoints #: '.$row['o_card_discount_number'].'</li>
                            <li>Mode of Payment: '.$row['o_payment_gateway'].'</li>

                        </ul>';
                    }

                        echo $output;
}


if (isset($_POST['action']) && $_POST['action'] == "getCustomerOrderByID") {


    $orderNumber = $_POST['orderNumber'];
    $output = '';

    $newTotal = [];
    $oNumToUpdate = [];


    $orderListByNumber = $db->getCustomerOderDetailsById($orderNumber);

                    foreach ($orderListByNumber as $row){
                        
                        $prodName = $row['product_name'];
                        $status = $row['o_status'];

                        if ($prodName == '[Shipping]'){
                            $oNumToUpdate[] = $row['id'];
                            continue;
                        }elseif($status == 'NA'){
                            continue;
                        }else{
                        $output .= ' <b>Product name: Chunky Pork Sisig</b>
                        <ul>
                            
                            <li>Variant: '.$row['variant_name'].'</li>
                            <li>Total quantity sold: '.$row['total_quantity_sold'].'</li>
                            <li>Note: '.$row['property_note'].'</li>
                            <hr>

                        </ul>';

                            if ($row['total_quantity_sold'] > 1){

                                $newTotal[] = $row['variant_price'] * $row['total_quantity_sold'];
                                $oNumToUpdate[] = $row['id'];
                            }else{

                                $newTotal[] = $row['variant_price'];
                                $oNumToUpdate[] = $row['id'];
                            }
                         }

                    }

                    $oNumToUpdateImploded = implode(",",$oNumToUpdate);

                    $output .= '<p>Land-mark / General Order note: '.$row['order_note'].'</p><br>';

                    $output .= '<input type="hidden" class="form-control getHubNumber" aria-describedby="emailHelp" placeholder="Enter email" value="'.$row['hub_area'].'">';
                    $output .= '<input type="hidden" class="form-control rgetOrderNumber" aria-describedby="emailHelp" placeholder="Enter email" value="'.$row['order_number'].'">';
                    $output .= '<input type="hidden" class="form-control rgetOrderId" aria-describedby="emailHelp" placeholder="Enter email" value="'.$oNumToUpdateImploded.'">';

                    $final = array_sum($newTotal);
                    $finalSum = $final + '49'; //49 is the delivery

                    $output .= '<p>Total: '.$finalSum.' </p><br>';
                   


                        // $response = json_encode($orderListByNumber);
                        echo  $output;
}

if (isset($_POST['action']) && $_POST['action'] == "getHubShipper") {
    $shipperHubNum = $_POST['shipper'];
    $shipper = "Shipper";
  

    $output = '';
    $shipperByHub = $db->getShipperByHub($shipperHubNum,$shipper);

            $output .= '<select class="custom-select" name = "" id = "getShipperName">
            <option selected>Choose Shipper</option>';

            foreach ($shipperByHub as $row){

                $output .= '<option value=" '.$row['first_name'].' '.$row['last_name'].' ">'.$row['first_name'].' '.$row['last_name'].' </option>';
            }
        $output .= '</select>';

        echo $output;
    
}

    if (isset($_POST['action']) && $_POST['action'] == "updateTheOrderByShipper"){

        $disOstatus = "for checking";
        $shipperID = "";
        $shipperName = trim($_POST['shipperName']);
        $copyOrderNumber = $_POST['copyOrderNumber'];

        $shipperPieces = explode(" ",$shipperName);
        $shipperFname = $shipperPieces[0];
        $shipperLname = $shipperPieces[1];


         $shipperDetails = $db->getShipperID($shipperFname,$shipperLname);

        foreach ($shipperDetails as $details){
            $shipperID = $details['id'];
        }
       
        $db->insertShipperIdIntoOrder($shipperID,$copyOrderNumber);
        $db->updateOstats($disOstatus,$copyOrderNumber);

    }


    if (isset($_POST['action']) && $_POST['action'] == "showAllOrderDetails") {

        $output = '';
        $order_number = '';
        $foNumberArray = [];
        $forDelivery = 'for delivery'; // admin show all pending order (all hub)
    
        $rOrderData = $db->readAllOrderData($forDelivery);
    
                $output .= '
                <table id="forDeliverOrderTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zip code</th>
                          <th>Customer name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($rOrderData as $row){
    
                            $order_number = $row['order_number'];
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
    }
    
    if (isset($_POST['action']) && $_POST['action'] == "showAllDeliveredOrder") {

        $output = '';
        $order_number = '';
        $foNumberArray = [];
        $forDelivery = 'paid'; // admin show all pending order (all hub)
    
        $rOrderData = $db->readAllOrderData($forDelivery);
    
                $output .= '
                <table id="deliveredOrderTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zip code</th>
                          <th>Customer name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($rOrderData as $row){
    
                            $order_number = $row['order_number'];
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
    }
  
    if (isset($_POST['action']) && $_POST['action'] == "showAllCancelledOrder") {
     
        $filterKey = 'voided';
        
        $output = '';
        $order_number = '';
        $foNumberArray = [];
    
        // echo $shipperId;
        // echo $filterKey;
        
        $rOrderData = $db->readAllCancelledOrderDataPerHub($filterKey);
    
                $output .= '
                <table id="cancelledOrderTableViewPerShipper" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Remarks</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($rOrderData as $row){
    
                            $order_number = $row['order_number'];
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['remarks'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
            
    }

// dropDown for hub List Code
    if (isset($_POST['action']) && $_POST['action'] == "showAllHubsForDropDown") {
        $output = '';
        $allHubsList = [];
        $hResultList = $db->getAllHubArea();
    
        foreach($hResultList as $hub){
            $allHubsList[] = $hub['hub_area'];
        }
        // $output .= '<input type="text" name="daterange" value=""/>';
        $output .= '<select class="browser-default custom-select zipcode-size hubOnChangeAction">';
    
        $output .= '<option selected value="empty">Filter by hub</option>';
        // $output .= '<option value="all">All</option>';
        
        foreach ($allHubsList as $hubPc){
        $output .= '<option value="'.$hubPc.'">'.$hubPc.'</option>';
        }
    
        $output .= '</select>';
        
    
        echo $output;
     
    
    }

    if (isset($_POST['action']) && $_POST['action'] == "showAllHubsForDropDownForChart") {
        $output = '';
        $allHubsList = [];
        $hResultList = $db->getAllHubArea();
    
        foreach($hResultList as $hub){
            $allHubsList[] = $hub['hub_area'];
        }
        // $output .= '<input type="text" name="daterange" value=""/>';
        $output .= '<select class="browser-default custom-select zipcode-size hubOnChangeActionChart">';
    
        $output .= '<option selected value="empty">Filter by hub</option>';
        // $output .= '<option value="all">All</option>';
        
        foreach ($allHubsList as $hubPc){
        $output .= '<option value="'.$hubPc.'">'.$hubPc.'</option>';
        }
    
        $output .= '</select>';
        
    
        echo $output;
     
    
    }

    if (isset($_POST['action']) && $_POST['action'] == "showAllHubsForDropDownForDispatched") {
        $output = '';
        $allHubsList = [];
        $hResultList = $db->getAllHubArea();
    
        foreach($hResultList as $hub){
            $allHubsList[] = $hub['hub_area'];
        }

        $output .= '<select class="browser-default custom-select zipcode-size hubOnChangeActionForDispathed">';
    
        $output .= '<option selected>Filter by hub area</option>';
        $output .= '<option value="All">All</option>';
        
        foreach ($allHubsList as $hubPc){
        $output .= '<option value="'.$hubPc.'">'.$hubPc.'</option>';
        }
    
        $output .= '</select>';
        
    
        echo $output;
     
    
    }

    if (isset($_POST['action']) && $_POST['action'] == "showAllHubsForDropDownForDelivery") {
        $output = '';
        $allHubsList = [];
        $hResultList = $db->getAllHubArea();
    
        foreach($hResultList as $hub){
            $allHubsList[] = $hub['hub_area'];
        }

        $output .= '<select class="browser-default custom-select zipcode-size hubOnChangeActionForDelivery">';
    
        $output .= '<option selected>Filter by hub area</option>';
        $output .= '<option value="All">All</option>';
        
        foreach ($allHubsList as $hubPc){
        $output .= '<option value="'.$hubPc.'">'.$hubPc.'</option>';
        }
    
        $output .= '</select>';
        
    
        echo $output;
     
    
    }

    if (isset($_POST['action']) && $_POST['action'] == "showAllHubsForDeliveredOrder") {
        $output = '';
        $allHubsList = [];
        $hResultList = $db->getAllHubArea();
    
        foreach($hResultList as $hub){
            $allHubsList[] = $hub['hub_area'];
        }

        $output .= '<select class="browser-default custom-select zipcode-size hubOnChangeActionForDelivered">';
    
        $output .= '<option selected>Filter by hub area</option>';
        $output .= '<option value="All">All</option>';
        
        foreach ($allHubsList as $hubPc){
        $output .= '<option value="'.$hubPc.'">'.$hubPc.'</option>';
        }
    
        $output .= '</select>';
        
    
        echo $output;
     
    
    }

    if (isset($_POST['action']) && $_POST['action'] == "showAllHubsForCancelledOrder") {
        $output = '';
        $allHubsList = [];
        $hResultList = $db->getAllHubArea();
    
        foreach($hResultList as $hub){
            $allHubsList[] = $hub['hub_area'];
        }

        $output .= '<select class="browser-default custom-select zipcode-size hubOnChangeActionForCancelled">';
    
        $output .= '<option selected>Filter by hub area</option>';
        $output .= '<option value="All">All</option>';
        
        foreach ($allHubsList as $hubPc){
        $output .= '<option value="'.$hubPc.'">'.$hubPc.'</option>';
        }
    
        $output .= '</select>';
        
    
        echo $output;
     
    
    }

    if (isset($_POST['action']) && $_POST['action'] == "shoPendingByHub") {

        $order_number = '';
        $foNumberArray = array();
        $output = '';
    
            $output .= '
                <table id="pendingOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Status</th>
                          <th>Hub area</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($allStatusOfOrder as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['o_status'].'</td>
                                <td>'.$row['hub_area'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
        
            
    }

    if (isset($_POST['action']) && $_POST['action'] == "shoDispatchedByHub") {

        $hubnumber = $_POST['hubnumber'];
        $pending = 'for checking';

        $order_number = '';
        $foNumberArray = array();
        $output = '';
       
        // function wag baguhin may tatamaan
        $hubFiltering = $db->functionForHubFilteringByPending($hubnumber,$pending);
    
        $allPendingOrder = $db->readAllOrderData($pending);
    
        if ($hubnumber == 'All' || $hubnumber == 'Filter by hub area'){
    
            $output .= '
                <table id="DispatchedOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($allPendingOrder as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
        }else {
    
                $output .= '
                <table id="DispatchedOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($hubFiltering as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
            }
            
    }

    if (isset($_POST['action']) && $_POST['action'] == "shoDeliveryByHub") {

        $hubnumber = $_POST['hubnumber'];
        $pending = 'for delivery';

        $order_number = '';
        $foNumberArray = array();
        $output = '';
       
        // function wag baguhin may tatamaan
        $hubFiltering = $db->functionForHubFilteringByPending($hubnumber,$pending);
    
        $allPendingOrder = $db->readAllOrderData($pending);
    
        if ($hubnumber == 'All' || $hubnumber == 'Filter by hub area'){
    
            $output .= '
                <table id="DeliveryOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($allPendingOrder as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
        }else {
    
                $output .= '
                <table id="DeliveryOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($hubFiltering as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
            }
            
    }

    if (isset($_POST['action']) && $_POST['action'] == "shoDeliveredByHub") {

        $hubnumber = $_POST['hubnumber'];
        $pending = 'paid';

        $order_number = '';
        $foNumberArray = array();
        $output = '';
       
        // function wag baguhin may tatamaan
        $hubFiltering = $db->functionForHubFilteringByPending($hubnumber,$pending);
    
        $allPendingOrder = $db->readAllOrderData($pending);
    
        if ($hubnumber == 'All' || $hubnumber == 'Filter by hub area'){
    
            $output .= '
                <table id="DeliveredOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($allPendingOrder as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
        }else {
    
                $output .= '
                <table id="DeliveredOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($hubFiltering as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
            }
            
    }
    if (isset($_POST['action']) && $_POST['action'] == "shoCancelledByHub") {

        $hubnumber = $_POST['hubnumber'];
        $pending = 'voided';

        $order_number = '';
        $foNumberArray = array();
        $output = '';
       
        // function wag baguhin may tatamaan
        $hubFiltering = $db->functionForHubFilteringByPending($hubnumber,$pending);
    
        $allPendingOrder = $db->readAllOrderData($pending);
    
        if ($hubnumber == 'All' || $hubnumber == 'Filter by hub area'){
    
            $output .= '
                <table id="cancelledOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Remarks</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($allPendingOrder as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['remarks'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
        }else {
    
                $output .= '
                <table id="cancelledOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Remarks</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($hubFiltering as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }else{
                                $foNumberArray[] = $order_number;
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['remarks'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;
            }
            
    }

    if (isset($_POST['action']) && $_POST['action'] == "filterAction") {

        $hubnumber = $_POST['hubnumber'];
        $orderStatus = $_POST['orderStatus'];
        $dateStartAndEnd = $_POST['dateStartAndEnd'];

        $explodedDates = explode(" - ",$dateStartAndEnd);

        $dateStartRevise = $explodedDates[0];
        $dateEndRevise = $explodedDates[1];

        $dateStart = date("Y/m/d", strtotime($dateStartRevise));
        $dateEnd = date("Y/m/d", strtotime($dateEndRevise));

        $order_number = '';
        $foNumberArray = array();
        $output = '';


        if ($hubnumber == 'empty' && $orderStatus == 'empty'){

                $filterByDateOrder = $db->selectAllorderByDate($dateStart,$dateEnd);

                    $output .= '
                <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Status</th>
                          <th>Hub area</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($filterByDateOrder as $row){
    
                            $order_number = $row['order_number'];
     
    
                            if (in_array($order_number, $foNumberArray, TRUE)){
                                continue;
                            }
                            else{
                                $foNumberArray[] = $order_number;
                                
                                $output .= '<tr  class = "text-center text-secondary">
                                <td>'.$row['id'].'</td>
                                <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                                <td>'.$row['order_number'].'</td>
                                <td>'.$row['o_status'].'</td>
                                <td>'.$row['hub_area'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
    
                            echo $output;

        }elseif ($hubnumber != 'empty' && $orderStatus == 'empty'){

                $filterByHubNumberAndDate = $db->filterByHubNumberAndDate($hubnumber,$dateStart,$dateEnd);

                $output .= '
            <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
        
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Status</th>
                      <th>Hub area</th>
                      <th>Customer Name</th>
                      <th>Phone number (primary)</th>
                      <th>Action</th>
                  </tr>

              </thead>

              <tbody>';

                    foreach ($filterByHubNumberAndDate as $row){

                        $order_number = $row['order_number'];
 

                        if (in_array($order_number, $foNumberArray, TRUE)){
                            continue;
                        }
                        else{
                            $foNumberArray[] = $order_number;
                            
                            $output .= '<tr  class = "text-center text-secondary">
                            <td>'.$row['id'].'</td>
                            <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                            <td>'.$row['order_number'].'</td>
                            <td>'.$row['o_status'].'</td>
                            <td>'.$row['hub_area'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
        }elseif ($hubnumber == 'empty' && $orderStatus != 'empty'){

            if($orderStatus == 'for checking'){

            // echo $dateStart;
            // echo $dateEnd;

            $filterByOstatusAndDate = $db->filterByOstatusAndDate($orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Dispatched date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusAndDate as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['hub_order_dispatched_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                            
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
                    
        }elseif($orderStatus == 'for delivery'){

            // echo $dateStart;
            // echo $dateEnd;
                
            $filterByOstatusAndDateForDelivery = $db->filterByOstatusAndDateForDelivery($orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Delivery date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusAndDateForDelivery as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivery_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
        }elseif($orderStatus == 'paid'){

            // echo $dateStart;
            // echo $dateEnd;
                
            $filterByOstatusAndDateForPaid = $db->filterByOstatusAndDateForPaid($orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Date paid</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusAndDateForPaid as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivered_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;

        }elseif($orderStatus == 'voided'){

            // echo $dateStart;
            // echo $dateEnd;
                
            $filterByOstatusAndDateForvoided = $db->filterByOstatusAndDateForvoided($orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Remarks</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusAndDateForvoided as $row){

                    $order_number = $row['order_number'];

                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['remarks'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Order Status" class="text-info orderProgressDetailsVoided" data-toggle="modal" data-target="#orderProgressVoided" orderNumber = "'.$row['order_number'].'" ahubAreaNum = "'.$row['hub_area'].'" shipperID = "'.$row['shipper_user_id'].'"> <i class="fas fa-tasks"></i>  </a>
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
        }else{
            $filterByOstatusAndDate = $db->filterByOstatusAndDatePending($orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusAndDate as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
        }
        
    }elseif ($hubnumber != 'empty' && $orderStatus != 'empty'){

        if($orderStatus == 'for checking'){

            // echo $dateStart;
            // echo $dateEnd;

            $filterByOstatusHubAndDate = $db->filterByOstatusHubAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Dispatched date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusHubAndDate as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['hub_order_dispatched_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
                    
        }elseif($orderStatus == 'for delivery'){

            // echo $dateStart;
            // echo $dateEnd;

            $filterByOstatusDateAndHubForDelivery = $db->filterByOstatusDateAndHubForDelivery($hubnumber,$orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Delivery date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusDateAndHubForDelivery as $row){

                    $order_number = $row['order_number'];

                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;

                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivery_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
        }elseif($orderStatus == 'paid'){

            // echo $dateStart;
            // echo $dateEnd;
                
            $filterByOstatusHubAndDateForPaid = $db->filterByOstatusHubAndDateForPaid($hubnumber,$orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Date paid</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusHubAndDateForPaid as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivered_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Order Status" class="text-info orderProgressDetails" data-toggle="modal" data-target="#orderProgress" orderNumber = "'.$row['order_number'].'" ahubAreaNum = "'.$row['hub_area'].'" shipperID = "'.$row['shipper_user_id'].'"> <i class="fas fa-tasks"></i>  </a>
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;

        }
        elseif($orderStatus == 'voided'){

            // echo $dateStart;
            // echo $dateEnd;
                
            $filterByOstatusHubAndDateForvoided = $db->filterByOstatusHubAndDateForvoided($hubnumber,$orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Remarks</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusHubAndDateForvoided as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['remarks'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Order Status" class="text-info orderProgressDetailsVoided" data-toggle="modal" data-target="#orderProgressVoided" orderNumber = "'.$row['order_number'].'" ahubAreaNum = "'.$row['hub_area'].'" shipperID = "'.$row['shipper_user_id'].'"> <i class="fas fa-tasks"></i>  </a>
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
        }
        else{

            $filterByHubnumberOstatusAndDate = $db->filterByHubnumberOstatusAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Hub area</th>
                  <th>Customer Name</th>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByHubnumberOstatusAndDate as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['order_number'])).'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$row['hub_area'].'</td>
                        <td>'.$row['c_fullname'].'</td>
                        <td>'.$row['c_pnumber_primary'].'</td>
                        
                        <td>
                            <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;
        }
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == "getAllPaidAndVoidedOrderForCurrentYear"){
        $yearFilter = date('Y');

        $dataGraphPaid = $db->ShowPaidData($yearFilter);
        $dataGraphVoided = $db->ShowVoidedData($yearFilter);

        $paidANdVoided = [];

        $entryPaid = [];
        $entryVoided = [];


        for ($i = 1; $i <= 12; $i++) { 

            $entryPaid[] = 0;

            foreach ($dataGraphPaid  as $k => $v) {
                
                if ($i == $dataGraphPaid [$k]['Month']) {
                    $entryPaid[$i] = (int)$dataGraphPaid [$k]['Order Month'];
                }
            }

            unset($entryPaid[0]);
        }

        for ($i = 1; $i <= 12; $i++) { 

            $entryVoided[] = 0;

            foreach ($dataGraphVoided  as $k => $v) {
                
                if ($i == $dataGraphVoided [$k]['Month']) {
                    $entryVoided[$i] = (int)$dataGraphVoided [$k]['Order Month'];
                }
            }

            unset($entryVoided[0]);
        }

        $paidANdVoided[] = $entryPaid;
        $paidANdVoided[] = $entryVoided;

        echo json_encode($paidANdVoided);
    }

    if (isset($_POST['action']) && $_POST['action'] == "getPaidAndVoidedByYearAndHubAdmin"){

        $inputYear = $_POST['inputYear'];
        $filterByHub = $_POST['filterByHub'];

        if ($filterByHub = 'empty'){
            
            $dataGraphPaid = $db->ShowPaidData($inputYear);
            $dataGraphVoided = $db->ShowVoidedData($inputYear);

            $paidANdVoided = [];

            $entryPaid = [];
            $entryVoided = [];


            for ($i = 1; $i <= 12; $i++) { 

                $entryPaid[] = 0;

                foreach ($dataGraphPaid  as $k => $v) {
                    
                    if ($i == $dataGraphPaid [$k]['Month']) {
                        $entryPaid[$i] = (int)$dataGraphPaid [$k]['Order Month'];
                    }
                }

                unset($entryPaid[0]);
            }

            for ($i = 1; $i <= 12; $i++) { 

                $entryVoided[] = 0;

                foreach ($dataGraphVoided  as $k => $v) {
                    
                    if ($i == $dataGraphVoided [$k]['Month']) {
                        $entryVoided[$i] = (int)$dataGraphVoided [$k]['Order Month'];
                    }
                }

                unset($entryVoided[0]);
            }

            $paidANdVoided[] = $entryPaid;
            $paidANdVoided[] = $entryVoided;

            echo json_encode($paidANdVoided);
            
        }else{
            $dataGraphPaid = $db->ShowPaidDataHubAndYear($filterByHub,$inputYear);
            $dataGraphVoided = $db->ShowVoidedDataHubAndYear($filterByHub,$inputYear);

            $paidANdVoided = [];

            $entryPaid = [];
            $entryVoided = [];


            for ($i = 1; $i <= 12; $i++) { 

                $entryPaid[] = 0;

                foreach ($dataGraphPaid  as $k => $v) {
                    
                    if ($i == $dataGraphPaid [$k]['Month']) {
                        $entryPaid[$i] = (int)$dataGraphPaid [$k]['Order Month'];
                    }
                }

                unset($entryPaid[0]);
            }

            for ($i = 1; $i <= 12; $i++) { 

                $entryVoided[] = 0;

                foreach ($dataGraphVoided  as $k => $v) {
                    
                    if ($i == $dataGraphVoided [$k]['Month']) {
                        $entryVoided[$i] = (int)$dataGraphVoided [$k]['Order Month'];
                    }
                }

                unset($entryVoided[0]);
            }

            $paidANdVoided[] = $entryPaid;
            $paidANdVoided[] = $entryVoided;

            echo json_encode($paidANdVoided);
        }

    }


    if (isset($_POST['action']) && $_POST['action'] == "importHistoryAction") {


        $output = '';

        $importHistoryData = $db->importHistoryDataView();
    
            $output .= '
                <table id="orderImportHistoryTable" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                  
                  <thead>
                      <tr class = "text-center">
                          <th>id</th>
                          <th>File</th>
                          <th>Hub area</th>
                          <th>User name</th>
                          <th>Import date</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
            foreach($importHistoryData as $row){

                    $output .= '<tr  class = "text-center text-secondary">
                    <td>'.$row['id'].'</td>
                    <td>'.$row['file_name'].'</td>
                    <td>'.$row['hub_area'].'</td>
                    <td>'.$row['user_fname_lname'].'</td>
                    <td>'.date("m/d/Y H:i:s",strtotime($row['date_import'])).'</td>
                    
                    <td>
                        <a href="#" title="Order Imported" class="text-info getImportExtraData" data-toggle="modal" data-target="#importHistoryModal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i> </a> 
                    </td>
                    </tr>';
            }
                $output .= '</tbody> </table>';

                echo $output;
        
    }

    if (isset($_POST['action']) && $_POST['action'] == "getImportExtraData") {

        $id = $_POST['id'];

        $output = '';

        $importHistoryData = $db->importHistoryData($id);
        
        $orderNumber = '';

        foreach ($importHistoryData as $row){
            $orderNumber = $row['order_number'];
        }

        $orderNumberExploded = explode(" , ",$orderNumber);
        $orderCout = count($orderNumberExploded);
            

            $output .= '<div class="modal-body px-4 orderHistoryDiv">';
            $output .= '
                <table id="orderImportHistoryTable" class="display responsive table-striped" width = "100%">

                  <thead>
                      <tr class = "text-center">
                          <th>Order number</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
            foreach($orderNumberExploded as $row){

                    $output .= '<tr  class = "text-center text-secondary">
                    <td>'.$row.'</td>
                    </tr>';
            }
                $output .= ' </tbody> </table>';
                $output .= '</div>
                            <div class="modal-footer">
                            <span>Count:</span> <span>'.$orderCout.'</span>
                            </div>';

                echo $output;
        
    }
    
    
?>
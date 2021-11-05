<?php
require '../../classes/hub_supervisor_classes/HubSupervisorClasses.php';


$db = new HubSupervisorClasses;

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


if (isset($_POST['action']) && $_POST['action'] == "showPendingOrderDetailsPerHub") {

    $output = '';
    $id = '';
    $order_date = '';
    $order_number = '';
    $c_pnumber_primary = '';
    $foNumberArray = [];

    $pending = 'pending';

    $hubNumber = $_POST['hubNumber'];
 

    $rOrderData = $db->readAllPendingOrderDataPerHub($hubNumber,$pending);

            $output .= '
            <table id="pendingOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Status</th>
                      <th>Zipcode</th>
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
                            <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                            <td>'.$row['order_number'].'</td>
                            <td>'.$row['o_status'].'</td>
                            <td>'.$row['c_zipcode'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a>&nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-danger cancel_order_Btn" data-toggle="modal" data-target="#cancelOrdermodal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-window-close fa-md" ></i>  </a>&nbsp;&nbsp;
                               
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
        
}

if (isset($_POST['action']) && $_POST['action'] == "getCustomerOrderByID") {

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $orderNumber = $_POST['orderNumber'];
    $output = '';

    $newTotal = [];

    $oNumToUpdate = [];
    $naProductName = [];

    if(!empty($id)){
        $db->updateOstatusToNA($id);
    }

    $orderListByNumber = $db->getCustomerOderDetailsById($orderNumber);

                    foreach ($orderListByNumber as $row){
                        
                        $prodName = $row['product_name'];
                        $status = $row['o_status'];

                        if ($prodName == '[Shipping]'){
                            $oNumToUpdate[] = $row['id'];
                            continue;
                        }elseif($status == 'NA'){
                            $naProductName[] = $row['product_name'];
                            continue;
                        }
                        else{ // select lng nung pwede na ideliver.
                        $output .= ' <b>Product name: '.$row['product_name'].'</b>
                        <ul class = "dontShowNotAvailableItem pointer disArmTheRemoveAction-and-pointer" id ="'.$row['id'].'"  prodName ="'.$row['product_name'].'" orderNumber="'.$row['order_number'].'">
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
                    $naProductNameImploded = implode(",",$naProductName);
                    
                    $output .= '<p>Land-mark / General Order note: '.$row['order_note'].'</p><br>';

                    $output .= '<input type="hidden" class="form-control getHubNumber" aria-describedby="emailHelp" placeholder="Enter email" value="'.$row['hub_area'].'">';
                    $output .= '<input type="hidden" class="form-control rgetOrderNumber" aria-describedby="emailHelp" placeholder="Enter email" value="'.$row['order_number'].'">';
                    $output .= '<input type="hidden" class="form-control rgetOrderId" aria-describedby="emailHelp" placeholder="Enter email" value="'.$oNumToUpdateImploded.'">';
                    $output .= '<input type="hidden" class="form-control naProductName" aria-describedby="emailHelp" placeholder="Enter email" value="'.$naProductNameImploded.'">';

                    $final = array_sum($newTotal);
                    $finalSum = $final + '49'; //49 is the delivery

                    $output .= '<p>Total: '.$finalSum.' </p><br>';

                        // echo json_encode($newTotal);
    
                    echo  $output;
}

if (isset($_POST['action']) && $_POST['action'] == "getHubShipper") {
    $shipperHubNum = $_POST['shipper'];
    $shipper = "Shipper";
    // $userID = $_POST['userID'];

  
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
    date_default_timezone_set('Asia/Manila');
    $dateAndTimeDispatched = date('Y/m/d H:i:s');

    $disOstatus = "for checking";
    $shipperID = "";
    $shipperName = trim($_POST['shipperName']);
    $copyOrderNumber = $_POST['copyOrderNumber'];
    $copyOrderId = $_POST['copyOrderId'];
    $ugetUserHubNUmber = $_POST['ugetUserHubNUmber'];

    $naProducts = isset($_POST['naProducts']) ? $_POST['naProducts'] : '';
    $userID = $_POST['ugetUserID'];

    $shipperPieces = explode(" ",$shipperName);
    $shipperFname = $shipperPieces[0];
    $shipperLname = $shipperPieces[1];


     $shipperDetails = $db->getShipperID($shipperFname,$shipperLname);
     $userDetails = $db->selectUserByID($userID);

    foreach ($shipperDetails as $details){
        $shipperID = $details['id'];
    }

    $db->insertShipperIdIntoOrder($shipperID,$copyOrderNumber);

    $copyOrderIdExploded = explode(",",$copyOrderId);

    foreach ($copyOrderIdExploded as $rowID){
        $updateId = $rowID;
        $db->updateOstats($disOstatus,$dateAndTimeDispatched,$copyOrderNumber,$updateId);
    }

    ////order count code

    $pendingKey = 'pending';
    $checkingKey = 'for checking';
    $deliveryKey = 'for delivery';
    $oCounts = [];

    $pendingData = $db->readAllHubByStatus($ugetUserHubNUmber,$pendingKey);
    $checkingData = $db->readAllHubByStatus($ugetUserHubNUmber,$checkingKey);
    $deliveryData = $db->readAllHubByStatus($ugetUserHubNUmber,$deliveryKey);

    $oCounts['pendingCount'] = count($pendingData);
    $oCounts['checkingCount'] = count($checkingData);
    $oCounts['deliveryCount'] = count($deliveryData);

    ////order count code END

    ////NA history code

    $uFulname = $userDetails[0]['first_name']. ' ' .$userDetails[0]['last_name'];

    if (!empty($naProducts)){
        $db->inserIntoNaProductHistory($userDetails[0]['id'],$uFulname,$userDetails[0]['hub_area'],$copyOrderNumber,$naProducts);
    }

    ////NA history code END

    echo json_encode($oCounts);
}

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

if (isset($_POST['action']) && $_POST['action'] == "showDispatchOrderDetailsPerHub") {

    $output = '';
    $id = '';
    $order_date = '';
    $order_number = '';
    $c_fullname = '';
    $c_pnumber_primary = '';
    $foNumberArray = [];
    $forChecking = 'for checking';

    $hubNumber = $_POST['hubNumber'];


    $rOrderData = $db->readAllPendingOrderDataPerHub($hubNumber,$forChecking);

            $output .= '
            <table id="dispatchOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
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
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-danger cancel_order_Btn" data-toggle="modal" data-target="#cancelOrdermodal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-window-close fa-md" ></i>  </a>
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
        
}

if (isset($_POST['action']) && $_POST['action'] == "showZipcodePerHub") {
    $hubSelectorForZipCode = $_POST['hubSelectorForZipCode'];

    $output = '';
    $wholeZip = '';
    $qResult = $db->getZipByHubNumber($hubSelectorForZipCode);

    foreach($qResult as $result){
        $wholeZip = $result['zip_code'];
    }

    $zipPieces = explode(",", $wholeZip);

    $output .= '<select class="browser-default custom-select zipcode-size showZipByHub">';

    $output .= '<option selected value="empty">Filter by zip code</option>';
    // $output .= '<option value="All">All</option>';

    foreach ($zipPieces as $zipPc){
    $output .= '<option value="'.$zipPc.'">'.$zipPc.'</option>';
    }

    $output .= '</select>';
    

    echo $output;
 

}

if (isset($_POST['action']) && $_POST['action'] == "showDeliveryOrderDetailsPerHub") {
    $hubNumber = $_POST['hubNumber'];
    $forDelivery = 'for delivery';

    $output = '';
    $order_number = '';
    $foNumberArray = [];


    $rOrderData = $db->readAllDeliveryOrderDataPerHub($hubNumber,$forDelivery);

            $output .= '
            <table id="deliveryOrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Total</th>
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
                            <td>'.$row['o_total_price'].'</td>
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

if (isset($_POST['action']) && $_POST['action'] == "hshowDeliveredOrder") {
    $hubNumber = $_POST['hubNumber'];
    $filterKey = 'paid';

    $output = '';
    $order_number = '';
    $foNumberArray = [];

    // echo $shipperId;
    // echo $filterKey;

    $rOrderData = $db->readAllDeliveredOrderDataPerHub( $hubNumber,$filterKey);

            $output .= '
            <table id="hshowDeliveredOrderTableView" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
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

                        if (in_array($order_number, $foNumberArray, TRUE)){
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

if (isset($_POST['action']) && $_POST['action'] == "showCancelledOrderDetailsForPerHub") {
    $hubNumber = $_POST['hubNumber'];
    $filterKey = 'voided';

    $output = '';
    $order_number = '';
    $foNumberArray = [];

    // echo $shipperId;
    // echo $filterKey;

    $rOrderData = $db->readAllCancelledOrderDataPerHub($hubNumber,$filterKey);

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

if(isset($_POST['action']) && $_POST['action'] == "cancelAndupdateOrderNumber" ){
    date_default_timezone_set('Asia/Manila');

    $orderNum = $_POST['orderNum'];
    $remarks = $_POST['remarks'];
    $voided = 'voided';
    $pedingOrderTimeVoided = date('Y/m/d H:i:s');
    $dateForoCancelledAtColumn = date('Y/m/d');

    $ugetUserHubNUmber = $_POST['ugetUserHubNUmber'];


    if($remarks == ''){

            $response['condition'] = 'error';
            $response = json_encode($response);
            echo $response;
    }
    else{
            $db->updateOstatusAndRemarks($orderNum,$remarks,$voided,$pedingOrderTimeVoided,$dateForoCancelledAtColumn);
            
            $response = [];
            $response['condition'] = 'success';
             ////order count code
             $pendingKey = 'pending';
             $checkingKey = 'for checking';
             $deliveryKey = 'for delivery';
 
             $pendingData = $db->readAllHubByStatus($ugetUserHubNUmber,$pendingKey);
             $checkingData = $db->readAllHubByStatus($ugetUserHubNUmber,$checkingKey);
             $deliveryData = $db->readAllHubByStatus($ugetUserHubNUmber,$deliveryKey);
 
             $response['pendingCount'] = count($pendingData);
             $response['checkingCount'] = count($checkingData);
             $response['deliveryCount'] = count($deliveryData);
 
             $response = json_encode($response);
             echo $response;
             ////order count code END
    }


    
}

if(isset($_POST['action']) && $_POST['action'] == "filterAction" ){

    $hubnumber = $_POST['hubnumber'];
    $orderStatus = $_POST['orderStatus'];
    $dateStartAndEnd = $_POST['dateStartAndEnd'];
    $zipCode = $_POST['zipCode'];

    $explodedDates = explode(" - ",$dateStartAndEnd);
    $dateStartRevise = $explodedDates[0];
    $dateEndRevise = $explodedDates[1];

    $dateStart = date("Y/m/d", strtotime($dateStartRevise));
    $dateEnd = date("Y/m/d", strtotime($dateEndRevise));

    $order_number = '';
    $foNumberArray = array();
    $output = '';

    if ($orderStatus == 'empty' && $zipCode == 'empty'){

        $filterByHubNumAndDateOrder = $db->filterByHubNumAndDateOrder($hubnumber,$dateStart,$dateEnd);

            $output .= '
            <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Status</th>
                      <th>Zipcode</th>
                      <th>Customer Name</th>
                      <th>Phone number (primary)</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($filterByHubNumAndDateOrder as $row){

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
                            <td>'.$row['c_zipcode'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a>&nbsp;&nbsp;
                                
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;

    }elseif($orderStatus != 'empty' && $zipCode == 'empty'){

        if ($orderStatus == 'pending'){

        $filterByHubNumStatusAndDateOrder = $db->filterByHubNumStatusAndDateOrder($hubnumber,$orderStatus,$dateStart,$dateEnd);
        
            $output .= '
            <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Status</th>
                      <th>Zipcode</th>
                      <th>Customer Name</th>
                      <th>Phone number (primary)</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($filterByHubNumStatusAndDateOrder as $row){

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
                            <td>'.$row['c_zipcode'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a>&nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-danger cancel_order_Btn" data-toggle="modal" data-target="#cancelOrdermodal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-window-close fa-md" ></i>  </a>
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
        }elseif($orderStatus == 'for checking'){

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
                  <th>Shipper</th>
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

                        $shipperFullName = $db->getShipperAccountId($row['shipper_user_id']);

                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['hub_order_dispatched_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$shipperFullName['first_name'] .' '. $shipperFullName['last_name'] .'</td>
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
                  <th>Shipper</th>
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

                        $shipperFullName = $db->getShipperAccountId($row['shipper_user_id']);

                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivery_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$shipperFullName['first_name'] .' '. $shipperFullName['last_name'] .'</td>
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
                            <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i> </a> &nbsp;&nbsp;
                            <a href="#" title="Customer rate and image" class="text-warning customer_rateImg_info" data-toggle="modal" data-target="#customerRateAndImage" id = "'.$row['id'].'"> <i class="fas fa-star"></i> </a>
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

    }
    elseif($orderStatus == 'empty' && $zipCode != 'empty'){
        $filterByHubNumZipcodeAndDateOrder = $db->filterByHubNumZipcodeAndDateOrder($hubnumber,$zipCode,$dateStart,$dateEnd);
        
            $output .= '
            <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Date</th>
                      <th>Order number</th>
                      <th>Status</th>
                      <th>Zipcode</th>
                      <th>Customer Name</th>
                      <th>Phone number (primary)</th>
                      <th>Action</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($filterByHubNumZipcodeAndDateOrder as $row){

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
                            <td>'.$row['c_zipcode'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a>&nbsp;&nbsp;
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;

    }elseif($orderStatus != 'empty' && $zipCode != 'empty'){

        if ($orderStatus == 'pending'){

            $filterByHubNumStatusZipcodeAndDateOrder = $db->filterByHubNumStatusZipcodeAndDateOrder($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode);
        
                $output .= '
                <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
                
                  <thead>
                      <tr class = "text-center">
                          <th>Id</th>
                          <th>Date</th>
                          <th>Order number</th>
                          <th>Status</th>
                          <th>Zipcode</th>
                          <th>Customer Name</th>
                          <th>Phone number (primary)</th>
                          <th>Action</th>
                      </tr>
                  </thead>
    
                  <tbody>';
    
                        foreach ($filterByHubNumStatusZipcodeAndDateOrder as $row){
    
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
                                <td>'.$row['c_zipcode'].'</td>
                                <td>'.$row['c_fullname'].'</td>
                                <td>'.$row['c_pnumber_primary'].'</td>
                                
                                <td>
                                    <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a>&nbsp;&nbsp;
                                    <a href="#" title="Customer Details" class="text-danger cancel_order_Btn" data-toggle="modal" data-target="#cancelOrdermodal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-window-close fa-md" ></i>  </a>
                                </td>
                              </tr>';
                                
                            }
                        }
                            $output .= '</tbody> </table>';
                        
                            echo $output;
        }elseif($orderStatus == 'for checking'){



            $filterByOstatusHubZipAndDate = $db->filterByOstatusHubZipAndDate($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Dispatched date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Shipper</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusHubZipAndDate as $row){

                    $order_number = $row['order_number'];


                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;

                        $shipperFullName = $db->getShipperAccountId($row['shipper_user_id']);
                        
                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['hub_order_dispatched_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$shipperFullName['first_name'] .' '. $shipperFullName['last_name'] .'</td>
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


            $filterByOstatusDateZipAndHubForDelivery = $db->filterByOstatusDateZipAndHubForDelivery($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode);

            $output .= '
        <table id="OrderTableViewPerHub" class="display responsive nowrap table table-striped table-bordered" width = "100%">
          
          <thead>
              <tr class = "text-center">
                  <th>Id</th>
                  <th>Date</th>
                  <th>Delivery date</th>
                  <th>Order number</th>
                  <th>Status</th>
                  <th>Shipper</th>
                  <th>Hub area</th>
                  <th>Customer Name</>
                  <th>Phone number (primary)</th>
                  <th>Action</th>
              </tr>

          </thead>

          <tbody>';

                foreach ($filterByOstatusDateZipAndHubForDelivery as $row){

                    $order_number = $row['order_number'];

                    if (in_array($order_number, $foNumberArray, TRUE)){
                        continue;
                    }
                    else{
                        $foNumberArray[] = $order_number;

                        $shipperFullName = $db->getShipperAccountId($row['shipper_user_id']);

                        $output .= '<tr  class = "text-center text-secondary">
                        <td>'.$row['id'].'</td>
                        <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                        <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivery_date_time'])).'</td>
                        <td>'.$row['order_number'].'</td>
                        <td>'.$row['o_status'].'</td>
                        <td>'.$shipperFullName['first_name'] .' '. $shipperFullName['last_name'] .'</td>
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
                
            $filterByOstatusHubZipAndDateForPaid = $db->filterByOstatusHubZipAndDateForPaid($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode);

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

                foreach ($filterByOstatusHubZipAndDateForPaid as $row){

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
                            <a href="#" title="Customer rate and image" class="text-warning customer_rateImg_info" data-toggle="modal" data-target="#customerRateAndImage" id = "'.$row['id'].'"> <i class="fas fa-star"></i>  </a>
                            <a href="#" title="Order Status" class="text-info orderProgressDetails" data-toggle="modal" data-target="#orderProgress" orderNumber = "'.$row['order_number'].'" ahubAreaNum = "'.$row['hub_area'].'" shipperID = "'.$row['shipper_user_id'].'"> <i class="fas fa-tasks"></i>  </a>
                        </td>
                      </tr>';
                        
                    }
                }
                    $output .= '</tbody> </table>';

                    echo $output;

        }elseif($orderStatus == 'voided'){
            // echo $dateStart;
            // echo $dateEnd;
                
            $filterByOstatusHubZipAndDateForvoided = $db->filterByOstatusHubZipAndDateForvoided($hubnumber,$orderStatus,$dateStart,$dateEnd,$zipCode);

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

                foreach ($filterByOstatusHubZipAndDateForvoided as $row){

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
    }
}

if(isset($_POST['action']) && $_POST['action'] == "getOstatusOfPaidAndCountIt" ){
        $hubNumber = $_POST['ugetUserHubNUmberForGraph'];
        $o_year = date('Y');

        $dataGraphPaid = $db->ShowPaidData($hubNumber, $o_year);
        $dataGraphVoided = $db->ShowVoidedData($hubNumber, $o_year);

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

if(isset($_POST['action']) && $_POST['action'] == "filterGraphByYear" ){

    $yearFilter = $_POST['yearFilter'];
    $hubNumber = $_POST['hubArea'];

    $dataGraphPaid = $db->ShowPaidData($hubNumber, $yearFilter);
    $dataGraphVoided = $db->ShowVoidedData($hubNumber, $yearFilter);

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



if (isset($_POST['action']) && $_POST['action'] == "getRateAndImg") {

    $output = '';
    $id = $_POST['id'];

   $results = $db->selectRateAndImg($id);


        $output .='<!-- Modal Header -->
        <div class="modal-header">
            <h6 class="modal-title">Customer rate and image</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>';

        $output .='<!-- Modal body -->
        <div class="modal-body px-4">

            <img src="'.$results[0]['cus_img'].'" id="img" width="100%" height="260px">

        </div>';

        $output .='<!-- Modal foote here , put it -->
        <div class="modal-footer" id ="imgDetails">
                <ul>
                <li>Customer name: '.$results[0]['c_fullname'].' </li> 
                <li>Customer rate: '.$results[0]['c_rating'].' </li> 
                <li>Date time: '.$results[0]['date_create'].' </li> 
                </ul>
        </div>';

//    echo json_encode($imagePath);

    echo $output;
    

}


if (isset($_POST['action']) && $_POST['action'] == "getOrderDetails") {

    $ordernumber = $_POST['ordernumber'];
    $ahubareanum = $_POST['ahubareanum'];
    $whereKey = '[Shipping]';

    $shipperid = $_POST['shipperid'];

    $output = '';

    $hubNumAndVariantName = $db->selectHubNumAndVariantName($ordernumber,$ahubareanum,$whereKey);
    $selectShipperByID = $db->selectShipperByID($shipperid);
    
    $shipperFname = $selectShipperByID[0]['first_name'];
    $shipperLname = $selectShipperByID[0]['last_name'];
    $shipperFullName = $shipperFname . " " . $shipperLname;

    $output .= '
                <ul>
                    <li>Order Date: '.date("m/d/Y",strtotime($hubNumAndVariantName[0]['order_date'])).' </li> 
                    <li>Order number: '.$hubNumAndVariantName[0]['order_number'].' </li> 
                    <li>Hub area: '.$hubNumAndVariantName[0]['hub_area'].' </li> 
                    <li>Shipper name: '.$shipperFullName.' </li>
                    <li>Date time (dispatched): '.date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['hub_order_dispatched_date_time'])).' </li>
                    <li>Date time (delivery): '.date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['shipper_for_delivery_date_time'])).' </li>
                    <li>Date time (delivered): '.date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['shipper_for_delivered_date_time'])).' </li>
                </ul>
                ';
    echo $output;

}

if (isset($_POST['action']) && $_POST['action'] == "getOrderDetailsForVoided") {

    $ordernumber = $_POST['ordernumber'];
    $ahubareanum = $_POST['ahubareanum'];
    $whereKey = '[Shipping]';

    $shipperid = isset($_POST['shipperid']) ? $_POST['shipperid'] : '';

    $selectShipperByID = $db->selectShipperByID($shipperid);

    $shipperFname = isset($selectShipperByID[0]['first_name']) ? $selectShipperByID[0]['first_name'] : '';
    $shipperLname = isset($selectShipperByID[0]['last_name']) ? $selectShipperByID[0]['last_name'] : '';

    $shipperFullName = $shipperFname . " " . $shipperLname;

    $hubNumAndVariantName = $db->selectHubNumAndVariantName($ordernumber,$ahubareanum,$whereKey);

    $output = '';
    $remarkShipper = 'none';
    $remarkHub = 'none';
    
    if ($hubNumAndVariantName[0]['hub_pending_date_time_voided'] == ''){

        $dispatched = date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['hub_order_dispatched_date_time']));
        $delivery = date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['shipper_for_delivery_date_time']));
        $delivered = 'none';
        $hubVoid = 'none';
        $remarkShipper  = $hubNumAndVariantName[0]['remarks'];
        $shipperVoid = date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['shipper_for_voided_date_time']));
        
    }else{
        $shipperFullName = 'none';
        $dispatched = 'none';
        $delivery = 'none';
        $delivered = 'none';
        $hubVoid = date("m/d/Y H:i:s",strtotime($hubNumAndVariantName[0]['hub_pending_date_time_voided']));
        $remarkHub = $hubNumAndVariantName[0]['remarks'];
        $shipperVoid = 'none';
    }

    $output .= '
                <ul>
                    <li>Order Date: '.date("m/d/Y",strtotime($hubNumAndVariantName[0]['order_date'])).' </li> 
                    <li>Order number: '.$hubNumAndVariantName[0]['order_number'].' </li> 
                    <li>Hub area: '.$hubNumAndVariantName[0]['hub_area'].' </li> 
                    <li>Shipper name: '.$shipperFullName.' </li> 
                    <li>Date time (dispatched): '.$dispatched.' </li>
                    <li>Date time (delivery): '.$delivery.' </li>
                    <li>Date time (delivered): '.$delivered.' </li>
                    <br>
                    <p>Voided by:</p>
                    <li>Hub supervisor: '.$hubVoid.' </li>
                    <p>Remark: '.$remarkHub.'</p>
                    <li>Shipper: '.$shipperVoid.' </li>
                    <p>Remark: '.$remarkShipper.'</p>
                </ul>
                ';
    echo $output;
    
}

if (isset($_POST['action']) && $_POST['action'] == "getAndShowNAProd") {

    $ugetUserHubNUmber = $_POST['ugetUserHubNUmber'];

    $NAItems = $db->getNAItem($ugetUserHubNUmber);

    $output = '';

    $output .= '
            <table id="NaProdTable" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>User name</th>
                      <th>Hub</th>
                      <th>Order number</th>
                      <th>Product name</th>
                      <th>NA date</th>
                  </tr>
              </thead>

              <tbody>';

                    foreach ($NAItems as $row){

                            $output .= '<tr  class = "text-center text-secondary">
                            <td>'.$row['id'].'</td>
                            <td>'.$row['user_fname_lname'].'</td>
                            <td>'.$row['hub_area'].'</td>
                            <td>'.$row['order_number'].'</td>
                            <td> <a href="#" title="Customer Details" class="text-info getNAProdById" data-toggle="modal" data-target="#NAProdModal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a></td>
                            <td>'.date("m/d/Y H:i:s",strtotime($row['date_not_available'])).'</td>
                           
                          </tr>';
                            
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
    
}

if (isset($_POST['action']) && $_POST['action'] == "getTheNAProd") {
    
    $id = $_POST['id'];

    $output = '';

    $NAProdItem = $db->getNAItembYid($id);
    $NAProdName = $NAProdItem[0]['product_name'];

    $NAProdNameExploded = explode(",",$NAProdName);
    $i = 1;

        $output .= '<div class="modal-body px-4 orderHistoryDiv">';
        $output .= '
            <table id="orderImportHistoryTable" class="display responsive table-striped" width = "100%">

              <thead>
                  <tr class = "text-center">
                      <th>Product name</th>
                  </tr>
              </thead>

              <tbody>';

        foreach($NAProdNameExploded as $row){

                $output .= '<tr  class = "text-center text-secondary">
                <td>'.$i.'.'.' '.$row.'</td>
                </tr>';
                $i++;
        }
            $output .= ' </tbody> </table>';
            $output .= '</div>
                        <div class="modal-footer " id="fontsizeInUl">
                            <ul>
                                <li>Hub: '.$NAProdItem[0]['hub_area'].'</li>
                                <li>Order number: '.$NAProdItem[0]['order_number'].'</li>
                                <li>NA date: '.date("m/d/Y H:i:s",strtotime($NAProdItem[0]['date_not_available'])).'</li>
                            </ul>
                        </div>';
            echo $output; 
}
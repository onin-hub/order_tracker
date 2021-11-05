<?php

require '../../classes/shipper_classes/ShipperClasses.php';

$db = new ShipperClasses;

if (isset($_POST['action']) && $_POST['action'] == "showDispatchOrderDetailsForShipper") {
    $shipperId = $_POST['shipperId'];
    $filterKey = 'for checking';

    $output = '';
    $order_number = '';
    $foNumberArray = [];

    // echo $shipperId;
    // echo $filterKey;

    $rOrderData = $db->readAllDispatchedOrderDataPerShipper($shipperId,$filterKey);

            $output .= '
            <table id="dispatchOrderTableViewPerShipper" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Order date</th>
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
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'" shipperid = "'.$row['shipper_user_id'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> 
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

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
                        }
                        else{
                        $output .= ' <b>Product name: '.$row['product_name'].'</b>
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


if (isset($_POST['action']) && $_POST['action'] == "updaOStatusForDelivery") {
    date_default_timezone_set('Asia/Manila');
    $dateAndTimeFordelivery = date('Y/m/d H:i:s');

    $hubNumber = $_POST['hubNumber'];
    $updateKey = 'transit';
    $updateThisId = $_POST['rgetOrderId'];
    $shipperidFOrDispatched = $_POST['shipperid'];// shipper ID
    $shipperidFOrDelivery = $_POST['shipperid'];
    
    $filterKey = 'for checking';
    $forDelivery = 'transit';

    $dispatchAndDeliveryCount = [];

    $updateThisIdexploded = explode(",",$updateThisId);

    foreach($updateThisIdexploded as $rowId){
    
    $updateId = $rowId;

    $db->updateOrderByshipper($updateKey,$dateAndTimeFordelivery,$hubNumber,$updateId);

    }

    $dispatchedOrder = $db->readAllDispatchedOrderDataPerShipper($shipperidFOrDispatched,$filterKey);
    $dispatcheCount = [];

    $forDeliverydOrder = $db->readAllDeliveryOrderDataPerShipper($shipperidFOrDelivery,$forDelivery);
    $deliveryCount = [];


    foreach ($dispatchedOrder as $row){

        if (in_array($row['order_number'],$dispatcheCount,TRUE)){
            continue;
        }else{
            $dispatcheCount[] = $row['order_number'];
        }
    }

        foreach ($forDeliverydOrder as $row){

        if (in_array($row['order_number'],$deliveryCount,TRUE)){
            continue;
        }else{
            $deliveryCount[] = $row['order_number'];
        }
    }

    $dispatchAndDeliveryCount['dispatchCount'] = count($dispatcheCount);
    $dispatchAndDeliveryCount['deliveryCount'] = count($deliveryCount);

    echo json_encode($dispatchAndDeliveryCount);

}


if (isset($_POST['action']) && $_POST['action'] == "showDeliveryOrderDetailsPerShipper") {
    $userShipperID = $_POST['userShipperID'];
    $forDelivery = 'transit';

    $output = '';
    $order_number = '';
    $foNumberArray = [];


    $rOrderData = $db->readAllDeliveryOrderDataPerShipper($userShipperID,$forDelivery);

            $output .= '
            <table id="deliveryOrderTableViewPerShipper" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Order date</th>
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
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Delivered/Cancelled" class="text-secondary deliveredCancelledBtn" data-toggle="modal" data-target="#DeliveredOrCancelledModal"  orderNumber = "'.$row['order_number'].'" orderID = "'.$row['id'].'" cusFulname = "'.$row['c_fullname'].'"> <i class = "fas fa-marker fa-md" ></i></a>
                                
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';


                        echo $output;
        
}


if (isset($_POST['action']) && $_POST['action'] == "updateOStatusForDelivered") {

    /*location of folder to save a image*/
    define('UPLOAD_DIR', '../../assets/img/');

    
    date_default_timezone_set('Asia/Manila');
    $dateAndTimeDelivered = date('Y/m/d H:i:s');
    
    //save the base64 url img to folder
    
    $img = $_POST['pathCode'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img); //decode the base64 url 
    $file = UPLOAD_DIR . uniqid() . '.png';

    $success = file_put_contents($file, $data);
     //save the base64 url img to folder end
    
    $orderNumber = $_POST['orderNumber'];
    $updateKey = 'paid';

     //insert image and rating value of customer variable
     $filePath = str_replace("../../","",$file);
     $orderID = $_POST['orderID'];
     $cusFullname = $_POST['cusFullname'];
     $cusRate = $_POST['cusRate'];
     $imgFileName = $filePath;
     

     $shipperidFOrDispatched = $_POST['userId'];// shipper ID
     $shipperidFOrDelivery = $_POST['userId'];
    
     $filterKey = 'for checking';
     $forDelivery = 'transit';

    $dispatchAndDeliveryCount = [];



     $updateThisId = [];
    
    $specificOrders = $db->getOrderbyHubNumber($orderNumber);

    foreach($specificOrders as $rowId){
        if ($rowId['o_status'] == 'NA'){
            continue;
        }else{
            $updateThisId[] = $rowId['id'];
        }
    }

    foreach ($updateThisId as $idToupdate){

    $finalIdtoUpdate = $idToupdate;

    $db->updateOrderOStatusToDelivered($updateKey,$dateAndTimeDelivered,$orderNumber,$idToupdate);

    }
    
    $db->customerSatisfaction($orderID,$cusFullname,$cusRate,$imgFileName);

    /////////
    $dispatchedOrder = $db->readAllDispatchedOrderDataPerShipper($shipperidFOrDispatched,$filterKey);
    $dispatcheCount = [];

    $forDeliverydOrder = $db->readAllDeliveryOrderDataPerShipper($shipperidFOrDelivery,$forDelivery);
    $deliveryCount = [];


    foreach ($dispatchedOrder as $row){

        if (in_array($row['order_number'],$dispatcheCount,TRUE)){
            continue;
        }else{
            $dispatcheCount[] = $row['order_number'];
        }
    }

        foreach ($forDeliverydOrder as $row){

        if (in_array($row['order_number'],$deliveryCount,TRUE)){
            continue;
        }else{
            $deliveryCount[] = $row['order_number'];
        }
    }

    $dispatchAndDeliveryCount['dispatchCount'] = count($dispatcheCount);
    $dispatchAndDeliveryCount['deliveryCount'] = count($deliveryCount);


    echo json_encode($dispatchAndDeliveryCount);

}


if (isset($_POST['action']) && $_POST['action'] == "updateOStatusForVoidedAndRemark") {
    date_default_timezone_set('Asia/Manila');

    $voidRemark = $_POST['voidRemark'];
    $orderNumber = $_POST['orderNumber'];
    $updateKey = 'voided';
    $shipper_for_voided_date_time = date('Y/m/d H:i:s');
    $shipper_for_voided_date = date('Y/m/d H:i:s');

    $shipperidFOrDispatched = $_POST['userId'];// shipper ID
    $shipperidFOrDelivery = $_POST['userId'];
    
    $filterKey = 'for checking';
    $forDelivery = 'transit';

    $dispatchAndDeliveryCount = [];
    
    
    $updateThisId = [];
    
    $specificOrders = $db->getOrderbyHubNumber($orderNumber);

    foreach($specificOrders as $rowId){
        if ($rowId['o_status'] == 'NA'){
            continue;
        }else{
            $updateThisId[] = $rowId['id'];
        }
    }

    foreach ($updateThisId as $idToupdate){

    $finalIdtoUpdate = $idToupdate;

    $db->updateOrderOStatusToVoided($updateKey,$orderNumber,$shipper_for_voided_date_time,$voidRemark,$finalIdtoUpdate,$shipper_for_voided_date);

    }

    $dispatchedOrder = $db->readAllDispatchedOrderDataPerShipper($shipperidFOrDispatched,$filterKey);
    $dispatcheCount = [];

    $forDeliverydOrder = $db->readAllDeliveryOrderDataPerShipper($shipperidFOrDelivery,$forDelivery);
    $deliveryCount = [];


    foreach ($dispatchedOrder as $row){

        if (in_array($row['order_number'],$dispatcheCount,TRUE)){
            continue;
        }else{
            $dispatcheCount[] = $row['order_number'];
        }
    }

        foreach ($forDeliverydOrder as $row){

        if (in_array($row['order_number'],$deliveryCount,TRUE)){
            continue;
        }else{
            $deliveryCount[] = $row['order_number'];
        }
    }

    $dispatchAndDeliveryCount['dispatchCount'] = count($dispatcheCount);
    $dispatchAndDeliveryCount['deliveryCount'] = count($deliveryCount);

    echo json_encode($dispatchAndDeliveryCount);

}


if (isset($_POST['action']) && $_POST['action'] == "showDeliveredOrderDetailsForShipper") {
    $shipperId = $_POST['shipperId'];
    $filterKey = 'paid';

    $output = '';
    $order_number = '';
    $foNumberArray = [];

    // echo $shipperId;
    // echo $filterKey;

    $rOrderData = $db->readAllDeliveredOrderDataPerShipper($shipperId,$filterKey);

            $output .= '
            <table id="deliveredOrderTableViewPerShipper" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Order date</th>
                      <th>Date deliver</th>
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
                            <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                            <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_delivered_date_time'])).'</td>
                            <td>'.$row['order_number'].'</td>
                            <td>'.$row['c_fullname'].'</td>
                            <td>'.$row['c_pnumber_primary'].'</td>
                            
                            <td>
                                <a href="#" title="Customer Order Details" class="text-primary customer_Order_Info_Btn" data-toggle="modal" data-target="#Customer_Order_details_modal" orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-shopping-cart fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Customer rate and image" class="text-warning customer_rateImg_info" data-toggle="modal" data-target="#customerRateAndImage" id = "'.$row['id'].'"> <i class="fas fa-star"></i>  </a>
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
        
}

if (isset($_POST['action']) && $_POST['action'] == "showCancelledOrderDetailsForShipper") {
    $shipperId = $_POST['shipperId'];
    $filterKey = 'voided';

    $output = '';
    $order_number = '';
    $foNumberArray = [];

    // echo $shipperId;
    // echo $filterKey;

    $rOrderData = $db->readAllCancelledOrderDataPerShipper($shipperId,$filterKey);

            $output .= '
            <table id="cancelledOrderTableViewPerShipper" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
              <thead>
                  <tr class = "text-center">
                      <th>Id</th>
                      <th>Order date</th>
                      <th>Date voided</th>
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
                            <td>'.date("m/d/Y",strtotime($row['order_date'])).'</td>
                            <td>'.date("m/d/Y H:i:s",strtotime($row['shipper_for_voided_date_time'])).'</td>
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


//star rating code
if (isset($_POST['action']) && $_POST['action'] == "insertCustomerSatisfactionData") {

    $dupCustoName = $_POST['dupCustoName'];
    $getRating = $_POST['getRating'];
    $dupOrderID = $_POST['dupOrderID'];

   $db->insertCustomerSatisfactionData($dupCustoName,$getRating,$dupOrderID);
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

if (isset($_POST['action']) && $_POST['action'] == "changePass") {
    
    $id = $_POST['id'];

   $datas = $db->getAccountChangePass($id);

    echo json_encode($datas);
}

if (isset($_POST['action']) && $_POST['action'] == "updateUpassword") {

    $uID = $_POST['uID'];
    $connewpass = $_POST['connewpass'];
    $currentPassword = $_POST['currentPassword'];

    $ifUserExist = $db->getAccountIdAndPass($uID,$currentPassword);

    if(empty($ifUserExist)){

        $response['condition'] = 'error';
        $response = json_encode($response);
        echo $response;

    }else{

        $db->updateuPassword($uID,$connewpass);

        $response['condition'] = 'success';
        $response = json_encode($response);
        echo $response;
    }
    
}

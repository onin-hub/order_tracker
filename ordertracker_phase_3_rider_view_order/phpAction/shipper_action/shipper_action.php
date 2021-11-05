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


if (isset($_POST['action']) && $_POST['action'] == "getCustomerOrderByID") {
    $orderNumber = $_POST['orderNumber'];
    $output = '';
    $orderListByNumber = $db->getCustomerOderDetailsById($orderNumber);

                    foreach ($orderListByNumber as $row){
                        
                        $prodName = $row['product_name'];

                        if ($prodName == '[Shipping]'){
                            continue;
                        }else{
                        $output .= ' 
                        <ul>
                            <li>Product name: '.$row['product_name'].'</li>
                            <li>Variant: '.$row['variant_name'].'</li>
                            <li>Total quantity sold: '.$row['total_quantity_sold'].'</li>
                            <li>Note: '.$row['property_note'].'</li>
                            <hr>

                        </ul>';
                         }
                    }
                    $output .= '<input type="hidden" class="form-control getHubNumber" aria-describedby="emailHelp" placeholder="Enter email" value="'.$row['hub_area'].'">';
                    $output .= '<input type="hidden" class="form-control rgetOrderNumber" aria-describedby="emailHelp" placeholder="Enter email" value="'.$row['order_number'].'">';
                    $output .= '<p>Land-mark / General Order note: '.$row['order_note'].'</p><br>';
                    $output .= '<p>Total: '.$row['o_total_price'].'</p><br>';
                   


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
    $hubNumber = $_POST['hubNumber'];
    $updateKey = 'for delivery';

    $db->updateOrderByshipper($updateKey,$hubNumber);

}


if (isset($_POST['action']) && $_POST['action'] == "showDeliveryOrderDetailsPerShipper") {
    $userShipperID = $_POST['userShipperID'];
    $forDelivery = 'for delivery';

    $output = '';
    $order_number = '';
    $foNumberArray = [];


    $rOrderData = $db->readAllDeliveryOrderDataPerShipper($userShipperID,$forDelivery);

            $output .= '
            <table id="deliveryOrderTableViewPerShipper" class="display responsive nowrap table table-striped table-bordered" width = "100%">
              
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
                                <a href="#" title="Customer Details" class="text-info customer_Info_Btn" data-toggle="modal" data-target="#Customer_details_modal" id = "'.$row['id'].'"> <i class = "fas fa-info-circle fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Delivered/Cancelled" class="text-secondary deliveredCancelledBtn" data-toggle="modal" data-target="#DeliveredOrCancelledModal"  orderNumber = "'.$row['order_number'].'"> <i class = "fas fa-marker fa-md" ></i>  </a> &nbsp;&nbsp;
                                <a href="#" title="Delivery Rating" class="text-warning customerSatisfactionBtn" data-toggle="modal" data-target="#customerSatisfactionModal" id = "'.$row['id'].'" fullName = "'.$row['c_fullname'].'" > <i class = "fas fa-star fa-md" ></i>  </a>
                                
                            </td>
                          </tr>';
                            
                        }
                    }
                        $output .= '</tbody> </table>';

                        echo $output;
        
}


if (isset($_POST['action']) && $_POST['action'] == "updateOStatusForDelivered") {
    $orderNumber = $_POST['orderNumber'];
    $updateKey = 'paid';

    $db->updateOrderOStatusToDelivered($updateKey,$orderNumber);

}


if (isset($_POST['action']) && $_POST['action'] == "updateOStatusForVoidedAndRemark") {
   
    $orderNumber = $_POST['orderNumber'];
    $voidRemark = $_POST['voidRemark'];
    $updateKey = 'voided';

    $db->updateOrderOStatusToVoided($updateKey,$orderNumber);
    $db->saveOrderRemark($voidRemark,$orderNumber);

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



if (isset($_POST['action']) && $_POST['action'] == "insertCustomerSatisfactionData") {

    $dupCustoName = $_POST['dupCustoName'];
    $getRating = $_POST['getRating'];
    $dupOrderID = $_POST['dupOrderID'];

   $db->insertCustomerSatisfactionData($dupCustoName,$getRating,$dupOrderID);
}
?>

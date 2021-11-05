<?php
include 'template/hubsup_header.php';

require 'classes/hub_supervisor_classes/HubSupervisorClasses.php';

$db = new HubSupervisorClasses;

$pendingKey = 'pending';
$checkingKey = 'for checking';
$deliveryKey = 'transit';

$chubNumber = $_SESSION['logInHubSuperVisorInfo'][7];

$pendingData = $db->readAllHubByStatus($chubNumber, $pendingKey);
$checkingData = $db->readAllHubByStatus($chubNumber, $checkingKey);
$deliveryData = $db->readAllHubByStatus($chubNumber, $deliveryKey);


?>

<div class="container" style="margin-top:80px">
    <div class="midWrapper">
        <div class="row">
            <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
                <h6>ORDERS <?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?></h6>
            </div>
        </div>

        <!-- count button start -->
        <button type="button" class="btn btn-danger">
            Pending <span class="badge badge-light ml-2 pendingDataCount"><?php echo count($pendingData) ?></span>
            <!-- <span class="sr-only">unread messages</span> -->
        </button>

        <button type="button" class="btn btn-warning">
            Dispatched <span class="badge badge-light ml-2 checkingDataCount"><?php echo count($checkingData) ?></span>
            <!-- <span class="sr-only">unread messages</span> -->
        </button>

        <button type="button" class="btn btn-success">
            Transit <span class="badge badge-light ml-2 deliveryDataCount"><?php echo count($deliveryData) ?></span>
            <!-- <span class="sr-only">unread messages</span> -->
        </button>

        <!-- count button end -->

        <div class="row my-3">
            <div class="col-lg-2 my-1">
                <select class="browser-default custom-select zipcode-size fOrderStatus">
                    <option selected value="empty">Filter by status</option>
                    <option value="pending">Pending</option>
                    <option value="for checking">Dispatched</option>
                    <option value="transit">Transit</option>
                    <option value="paid">Paid</option>
                    <option value="voided">Voided</option>
                </select>
            </div>

            <div class="col-lg-2 my-1">
                <div id="showZip">
                    <!--===============================================
                                    filter by select option
                        ===================================================-->
                </div>
            </div>

            <div class="col-lg-4 my-1" id="datePicker">
                <input type="text" name="daterange" value="" id="dateStartAndEnd" class="middle-center" /> <!-- datepicker -->
                <button type="submit" class="btn btn-success btn-sm" id="generateBtn">Generate</button>
            </div>

        </div>
    </div>
    <div class="midWrapper">
        <div class="row mb-3">
            <div class="col-lg-12">
                <div id="showCurrentHubPedingOrder">
                    <!--===============================================
                                show Shipper current pending order
                    ===================================================-->
                </div>
                <input id="ugetUserHubNUmber" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
                <input id="ugetUserID" type="hidden" name="" class="form-control" placeholder="UID" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][0]; ?>">
            </div>
        </div>
    </div>
    <input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][0] ?>">
</div>


<!--*****************************************************
    Customer rate and Image modal "Delivered Order"
********************************************************* -->
<div class="modal fade" id="customerRateAndImage">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="showRateAndImage rateImg">
                <!--*******************************
                    show rate and img here 
                *********************************** -->
            </div>
        </div>
    </div>
</div>

<!--*****************************************************
     show order Progres HERE for paid
********************************************************* -->
<div class="modal fade" id="orderProgress">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Order Record</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <div class="showProgress">
                    <!--*******************************
                    show order Progres HERE
                *********************************** -->
                </div>
            </div>
        </div>
    </div>
</div>

<!--*****************************************************
     show order Progres HERE for voided
********************************************************* -->
<div class="modal fade" id="orderProgressVoided">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Voided Record</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <div class="showProgressVoided">
                    <!--*******************************
                    show order Progres HERE for voided
                *********************************** -->
                </div>
            </div>
        </div>
    </div>
</div>

<!--*******************************
    cancel order Modal
*********************************** -->
<div class="modal fade" id="cancelOrdermodal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Cancel Order</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <p>Are you sure to cancel this order number: <span id="dupInsertOrderNumber"></span></p>
                <input type="hidden" name="" class="form-control my-2 orderNumberInput" placeholder="ordernumber" value="">
                <input type="text" name="" class="form-control my-2 orderCancelRemark" placeholder="Remarks" value="">
                <button type="submit" class="btn btn-success btn-sm saveCancelOrderBtn">Save cancel order</button>
            </div>
        </div>
    </div>
</div>

<!--*******************************
    return order Modal
*********************************** -->
<div class="modal fade" id="returnOrdermodal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Return Order</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <p>Are you sure to return this order number: <span id="dupInsertOrderNumberToReturnOrder"></span></p>
                <p>Shipping Address: <span class ="shippingAddress"></span></p>
                <p>Billing Address: <span class="billingAddress"></span></p>

                <input type="hidden" name="" class="form-control my-2 orderNumberInputToReturnOrder" placeholder="ordernumber" value="">

                <input type="text" name="" class="form-control my-2 orderCancelRemarkToReturnOrder" placeholder="Remarks" value="">
                <button type="submit" class="btn btn-success btn-sm returnOrderBtn">Save return order</button>
            </div>
        </div>
    </div>
</div>


<!--*******************************
    Customer Details Modal
*********************************** -->
<div class="modal fade" id="Customer_details_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Customer Details</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <div id="showCustomerDetails">
                    <!--===============================================
                                  where Customer Details Appear
                        ===================================================-->
                </div>
            </div>
        </div>
    </div>
</div>

<!--*******************************
    Customer order Details Modal
*********************************** -->
<div class="modal fade" id="Customer_Order_details_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Customer Order Details</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">

                <div id="showCustomerOrderDetails">
                    <!--===============================================
                                  where Customer Details Appear
                        ===================================================-->
                </div>

                <button type="submit" class="btn btn-success btn-sm adminShipperBtn" data-toggle="modal" data-target="#assign_modal">Dispatch</button>
            </div>

        </div>
    </div>
</div>

<!--*******************************
    Dispatched Modal
*********************************** -->
<div class="modal fade" id="assign_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Assign order to shipper</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">

                <div id="showAllShipperDetails">
                    <!--===============================================
                                  where Customer Details Appear
                        ===================================================-->
                </div>
                <input type="hidden" class="form-control" id="copyHubNumber" aria-describedby="" placeholder="HubNumber">
                <input type="hidden" class="form-control" id="rcopyOrderNumber" aria-describedby="" placeholder="OrderNumber">
                <input type="hidden" class="form-control" id="rcopyOrderId" aria-describedby="" placeholder="OrderID">
                <input type="hidden" class="form-control" id="naProducts" aria-describedby="" placeholder="NaProd">

                <button type="submit" class="btn btn-success btn-sm mt-2 updateOrderByshipper">Save</button>
            </div>

        </div>
    </div>
</div>

<!-- =============================
     change password modal
  ==================================-->
<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Change Password</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <!-- phpAction/admin_action/admin_action.php -->
                <form action="" method="POST">

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="text" name="userName" class="form-control" placeholder="User Name" required>
                            <span>User Name</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="password" name="currentPassword" class="form-control" placeholder="Current password" required>
                            <span>Current password</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="password" name="newPassword" class="form-control" placeholder="New Password" required>
                            <span>New Password</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                            <span>Confirm Password</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="saveChangePass" value="Save" class="btn btn-success btn-sm">
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<?php include 'template/hubsup_footer.php' ?>
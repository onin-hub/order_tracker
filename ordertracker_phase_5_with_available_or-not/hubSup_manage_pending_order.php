<?php
include 'template/hubsup_header.php'

?>

    <div class="container" style="margin-top:80px">

        <div class="row">
            <h3>Orders <?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?></h3>
        </div>

        <div class="row my-3">
            <div class="col-lg-2 my-1">
                <select class="browser-default custom-select zipcode-size fOrderStatus">
                    <option selected value="empty">Filter by status</option>
                    <option value="pending">Pending</option>
                    <option value="for checking">Dispatched</option>
                    <option value="for delivery">For delivery</option>
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
                <input type="text" name="daterange" value="" id="dateStartAndEnd" /> <!-- datepicker -->
                <button type="submit" class="btn btn-success btn-sm" id="generateBtn">Generate</button>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-lg-12">

                <div id="showCurrentHubPedingOrder">
                    <!--===============================================
                                show Shipper current pending order
                    ===================================================-->
                </div>
                <input id="ugetUserHubNUmber" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
            </div>
        </div>

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
                <button type="submit" class="btn btn-success btn-sm saveCancelOrderBtn">Save</button>
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

                <button type="submit" class="btn btn-success btn-sm mt-2 updateOrderByshipper">Save</button>
            </div>

        </div>
    </div>
</div>


<?php include 'template/hubsup_footer.php' ?>
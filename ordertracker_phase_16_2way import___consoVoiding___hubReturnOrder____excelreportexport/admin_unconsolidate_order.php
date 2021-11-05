<?php include 'template/admin_header.php' ?>

<!-- ======= About Section ======= -->

<div class="container" style="margin-top:80px">
    <div class="midWrapper">
        <h6>UNCONSOLIDATE ORDERS</h6>
        <div class="row">
            <div class="col-lg-12">
                <div id="showUnconsolidateOrder">
                    <!--===============================================
                            where unconcolidate orders 
                  ===================================================-->
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInAdminInfo'][0] ?>">


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

            <div class="col-lg-12">
                <div id="showHubdetailsForImport">
                    <!--===============================================
                            where Hub details show dropdown 
                    ===================================================-->
                </div>
            </div>

            <div class="col-lg-12">
                <button id="assignOrderToHubBtn" class="btn btn-success mb-2" type="button">Save</button>
            </div>
            
            <input type="hidden" class="form-control getOrderForHubUpdateAssign" aria-describedby="emailHelp" placeholder="ordernumber" value="">
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

                <!-- <button type="submit" class="btn btn-success btn-sm adminShipperBtn" data-toggle="modal" data-target="#assign_modal">Dispatch</button> -->
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

<?php include 'template/admin_footer.php' ?>
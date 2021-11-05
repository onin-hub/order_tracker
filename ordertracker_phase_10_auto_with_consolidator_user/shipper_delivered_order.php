<?php include 'template/shipper_header.php' ?>


<div class="container" style="margin-top:80px">
    <div class="row mb-3">
        <h3>Delivered Order</h3>
        <div class="col-lg-12">
            <div id="showDeliveredOrder">
                <!--===============================================
                           show Shipper Dispatch VIew Here
                  ===================================================-->
            </div>
            <input id="shipperID" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInShipperInfo'][0]; ?>">
        </div>
    </div>
</div>
<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInShipperInfo'][0]?>"> 

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
                <!-- <input type="text" name="" class="form-control dupHubnumber" placeholder="First Name" value = ""> -->
                <!-- <button type="submit" class="btn btn-success btn-sm forDeliveryBtn" data-toggle="modal" data-target="#forDelivery_modal">For Delivery</button> -->
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
                            <input type="text" name="userName"  class="form-control" placeholder="User Name" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="currentPassword"  class="form-control" placeholder="Current password" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="newPassword"  class="form-control" placeholder="New Password" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="confirmPassword"  class="form-control" placeholder="Confirm Password" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="saveChangePass"  value="Save" class = "btn btn-success btn-sm">
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>



<?php include 'template/shipper_footer.php' ?>
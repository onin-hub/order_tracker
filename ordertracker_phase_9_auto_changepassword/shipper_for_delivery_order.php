<?php include 'template/shipper_header.php' ?>


<div class="container" style="margin-top:80px">
    <div class="row mb-3">
        <h3>For Delivery Order</h3>
        <div class="col-lg-12">
            <div id="showDeliveryOrderForShipper">
                <!--===============================================
                            show delivery order for shipper
                  ===================================================-->
            </div>
            <input type="hidden" name="" class="form-control userId" placeholder="shipper id" value="<?php echo $_SESSION['logInShipperInfo'][0]; ?> ">
        </div>
    </div>
</div>
<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInShipperInfo'][0]?>"> 

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
                <input type="hidden" name="" class="form-control dupHubnumber" placeholder="First Name" value="">
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



<!--*******************************
    delivered/cancelled Modal
*********************************** -->
<div class="modal fade" id="DeliveredOrCancelledModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Order Marking</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                        <button type="submit" class="btn btn-primary btn-success form-control clearUploadImgFrame" data-toggle="modal" data-target="#ratingAndUpload">Deliver</button>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                        <button type="submit" class="btn btn-primary btn-danger form-control orderVoidedBtn" data-toggle="modal" data-target="#voidedModal">Cancel</button>
                    </div>

                </div>
                <input type="hidden" name="" class="form-control dupOrderID" placeholder="ID" value="">
                <input type="hidden" name="" class="form-control dupOrderNumber" placeholder="ordernumber" value="">
                <input type="hidden" name="" class="form-control dupCusName" placeholder="cName" value=""> <!-- get the orderNumber -->
            </div>
        </div>
    </div>
</div>

<!--****************************************************
        modal for upload image and star rating
******************************************************** -->
<div class="modal fade" id="ratingAndUpload">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Upload image and customer rate</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <div class="container">
                    <!-- camera area code -->
                    <video autoplay id="video"></video>
                    <button class="button is-hidden" id="btnPlay">
                        <span class="icon is-small">
                            <i class="fas fa-play"></i>
                        </span>
                    </button>
                    <button class="button" id="btnPause">
                        <span class="icon is-small">
                            <i class="fas fa-pause"></i>
                        </span>
                    </button>
                    <button class="button is-success" id="btnScreenshot">
                        <span class="icon is-small">
                            <i class="fas fa-camera"></i>
                        </span>
                    </button>
                    <button class="button" id="btnChangeCamera">
                        <span class="icon">
                            <i class="fas fa-sync-alt"></i>
                        </span>
                        <span>Switch camera</span>
                    </button>
                    <!-- camera area code end -->
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div class='preview'>
                                <!-- <img src="" id="img" width="100" height="100"> -->
                                <div class="column">
                                    <div id="screenshots"></div>
                                </div>
                            </div>
                            <!-- <div>
                                <input type="file" id="file" name="" class="" value=""/>
                                <input type="button" class="button" value="Upload" id="but_upload">
                            </div> -->
                            <!-- star rating -->
                            <div style="font-size: 2em;" id="imgDiv">
                                <h5>Customer Satisfaction</h5>
                                <div id="review"></div>
                            </div>
                            <div>
                                <label for="starsInput" readonly id="starsInputs">Customer rate: <span id="appearRate"></span></label>
                            </div>
                            <!-- end star rating -->
                            <button type="submit" class="btn btn-success mt-3 orderDeliveredBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--*******************************
    Voiding Modal
*********************************** -->
<div class="modal fade" id="voidedModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Voiding</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <input type="text" name="" class="form-control mb-3 voidRemark" placeholder="Remarks" value="">
                <button type="submit" class="btn btn-primary btn-danger form-control saveOrderVoid" data-toggle="modal" data-target="#voidedModal">Void</button>

                <input type="hidden" name="" class="form-control dupOrderNumber" placeholder="ordernumber" value=""> <!-- get the orderNumber -->
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
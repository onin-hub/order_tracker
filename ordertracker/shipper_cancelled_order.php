<?php include 'template/shipper_header.php' ?>


<div class="container" style="margin-top:80px">
    <div class="midWrapper">
        <div class="row mb-3">
            <div class="col-lg-12">
                <h6>CANCELLED ORDER</h6>
            </div>

            <div class="col-lg-12">
                <div id="showCancelledOrder">
                    <!--===============================================
                           show Shipper Dispatch VIew Here
                  ===================================================-->
                </div>
                <input id="shipperID" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInShipperInfo'][0]; ?>">
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInShipperInfo'][0] ?>">


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

<!--****************************************************
        modal for upload image and star rating "para lng hindi mag loko sa console nung code"
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


<?php include 'template/shipper_footer.php' ?>
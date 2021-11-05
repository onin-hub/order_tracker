<?php include 'template/admin_header.php' ?>

<!-- ======= About Section ======= -->

<div class="container" style="margin-top:80px">

    <div class="row">
        <h3>Orders</h3>
    </div>

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
            <div id="showAllHubsForDropDown">
                <!--===============================================
                                filter by hub Area
                    ===================================================-->
            </div>
        </div>

        <div class="col-lg-4 my-1" id="datePicker">
            <input type="text" name="daterange" value="" id="dateStartAndEnd"  class = "middle-center"/> <!-- datepicker -->
            <button type="submit" class="btn btn-success btn-sm" id="generateBtn">Generate</button>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="showManageOrderHere">
                <!--===============================================
                            where Hub details show dropdown 
                  ===================================================-->
            </div>
        </div>
    </div>

</div>
<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInAdminInfo'][0]?>">


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

                <!-- <button type="submit" class="btn btn-success btn-sm adminShipperBtn" data-toggle="modal" data-target="#assign_modal">Dispatch</button> -->
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
                <input type="hidden" class="form-control" id="copyHubNumber" aria-describedby="emailHelp" placeholder="HubNumber">
                <input type="hidden" class="form-control" id="rcopyOrderNumber" aria-describedby="emailHelp" placeholder="OrderNumber">
                <button type="submit" class="btn btn-success btn-sm mt-2 updateOrderByshipper">Save</button>
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
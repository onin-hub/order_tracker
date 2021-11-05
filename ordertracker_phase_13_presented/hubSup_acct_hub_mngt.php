<?php include 'template/hubsup_header.php' ?>

<div class="container" style="margin-top:80px">
    <div class="row mb-3">
        <div class="col-lg-12 ">
            <div id="showShipperAccountPerHub">
                <!-- ===========================================
                    Area where the hub_area : data shipper by hub
                =================================================-->
            </div>
        </div>
    </div>

</div>
<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][0] ?>">

<!-- =============================
      ADD SHIPPER MODAL INSERT
  ==================================-->
<div class="modal fade" id="addShipperModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">ADD SHIPPER</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <form action="" method="POST" id="">
                    <input type="hidden" name="" id="addShipperId" class="form-control" placeholder="Id">

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="text" name="" id="sFname" class="form-control" placeholder="First Name" required>
                            <span>First Name</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="text" name="" id="sLname" class="form-control" placeholder="Last Name" required>
                            <span>Last Name</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="text" name="" id="sUserName" class="form-control" placeholder="User Name" required>
                            <span>User Name</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="password" name="" id="sUPass" class="form-control" placeholder="Password" required>
                            <span>Password</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-group has-float-label">
                            <input type="text" name="" id="sUContact" class="form-control" placeholder="Contact #" pattern="[1-9]{1}[0-9]{9}" maxlength="11" required>
                            <span>Contact #</span>
                        </label>
                    </div>

                    <input type="hidden" name="" id="suRole" class="form-control" placeholder="Id" value="Shipper">
                    <input type="hidden" name="" id="suHubnumber" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
                    <div class="form-group">
                        <input type="submit" name="" id="addShipperAccount" value="Save" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- =============================
      EDIT SHIPPER MODAL INSERT
  ==================================-->
<div class="modal fade" id="EditaddShipperModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">EDIT SHIPPER</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">




                <input type="hidden" name="" id="EditaddShipperId" class="form-control" placeholder="Id">

                <div class="form-group">
                    <label class="form-group has-float-label">
                        <input type="text" name="" id="esFname" class="form-control" placeholder="First Name" required>
                        <span>First Name</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-group has-float-label">
                        <input type="text" name="" id="esLname" class="form-control" placeholder="Last Name" required>
                        <span>Last Name</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-group has-float-label">
                        <input type="text" name="" id="esUserName" class="form-control" placeholder="User Name" required>
                        <span>User Name</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-group has-float-label">
                        <input type="password" name="" id="esUPass" class="form-control" placeholder="Password" required>
                        <span>Password</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-group has-float-label">
                        <input type="text" name="" id="esUContact" class="form-control" placeholder="Contact #" pattern="[1-9]{1}[0-9]{9}" maxlength="11" required>
                        <span>Contact #</span>
                    </label>
                </div>

                <input type="hidden" name="" id="esuRole" class="form-control" placeholder="Id" value="Shipper">
                <input type="hidden" name="" id="esuHubnumber" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
                <div class="form-group">
                    <input type="submit" name="" id="EditaddShipperAccount" value="Save" class="btn btn-primary">
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

<?php include 'template/hubsup_footer.php' ?>
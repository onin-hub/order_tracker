<?php
include 'template/admin_header.php';

?>

<div class="container" style="margin-top:80px">
    <div class="midWrapper">
        <h6>NA ITEMS</h6>
        <div id="showNAItems">
            <!--===============================================
                                show Shipper current pending order
                    ===================================================-->
        </div>
        <input id="ugetUserHubNUmber" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInAdminInfo'][7]; ?>">
        <input id="ugetUserID" type="hidden" name="" class="form-control" placeholder="UID" value="<?php echo $_SESSION['logInAdminInfo'][0]; ?>">
        <input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInAdminInfo'][0] ?>">
    </div>
</div>

<!--===============================================
        MOdal for NA prod
===================================================-->
<div class="modal fade" id="NAProdModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">NA product/s</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div id="showNAProdName">
                <!--===============================================
                        where NA prod appear
                ===================================================-->
            </div>
        </div>
    </div>
</div>


<!--===============================================
        MOdal for import History data
===================================================-->
<div class="modal fade" id="NAProdModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">NA product/s</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div id="showNAProdName">
                <!--===============================================
                        where the import history extra data appear
                ===================================================-->
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
<?php
include 'template/admin_header_chart.php';
$currentYear = date('Y');
?>

<div class="container" style="margin-top:80px">
  <div class="midWrapper col-lg-12">
    <h6>DASHBOARD</h6>

    <div class="row col-lg-12 mb-3">
      <!-- year picker here -->
      <div class="col-lg-3 mb-2">
        <input type="text" id="datepicker" placeholder="Insert Year" autocomplete="off" class="inputYear middle-center" />
      </div>

      <div class="col-lg-3 mb-2 hubFilterAdminDashBoard">
        <div id="showAllHubsForDropDown">
          <!--===============================================
                                  filter by hub Area
          ===================================================-->
        </div>
      </div>

      <div class="col-lg-2 mb-2 btnAdminDashBoard">
        <button type="submit" class="btn btn-success btn-sm " id="adminGenerateBtnGraph">Generate</button>
      </div>

    </div>

    <div class="row mb-2">
      <div class="col-lg-6">
        <canvas id="myChart" width="400" height="200"></canvas>
      </div>
    </div>

    <input id="ugetUserHubNUmberForGraph" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInAdminInfo'][7]; ?>">
    <input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInAdminInfo'][0] ?>">
    <input type="hidden" id="" class="cYear" placeholder="Current Year" value="<?php echo $currentYear ?>" />

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


<?php include 'template/admin_footer_chart.php' ?>
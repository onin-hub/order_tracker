<?php
include 'template/hubsup_header_chart.php';
$currentYear = date('Y');
?>

<div class="container" style="margin-top:60px">
  <div class="row">
    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
      <h6>DASHBOARD</h6>
    </div>
  </div>
</div>
<input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][0]?>"> 

<div class="container">
  <div class="row mb-3">
    <!-- year picker here -->
    <div class="col-lg-6">
      <form action="" autocomplete="off">
        <input type="text" id="datepicker" placeholder="Insert Year" class = "middle-center"/>
        <button type="submit" class="btn btn-success btn-sm ml-2" id="generateBtnByYear">Generate</button>
        <canvas id="myChart" width="400" height="200"></canvas>
      </form>
    </div>
  </div>
  <input id="ugetUserHubNUmberForGraph" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
  <input type="hidden" id="" class="cYear" placeholder="Current Year" value="<?php echo $currentYear ?>" />
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
<?php include 'template/hubsup_footer_chart.php' ?>
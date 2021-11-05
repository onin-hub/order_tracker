

<?php include 'template/admin_header.php'?>


  <main id="main">
   
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
            <h3>IMPORT ORDER</h3>
            <div class="col-lg-12 mt-5">
              <div id = "showHubdetailsForImport">
                  <!--===============================================
                            where Hub details show dropdown 
                  ===================================================-->
              </div>
            </div>
              <form class="">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="input-import-driver" class="form-control-file" id="input-import-driver" accept=".csv">
                    </div>

                    <div class="input-group-append">
                        <button id="btn-import-driver" class="btn btn-success" type="button">Import</button>
                        <div class="d-flex justify-content-center loaderBlack">
                          <div class="spinner-border" role="status" style="display:none">
                            <span class="sr-only">Loading...</span>
                          </div>
                        </div>
                    </div>

                </div>
              </form>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->
  </main><!-- End #main -->

  <input type="hidden" name="" class="" id="userFname" value="<?php echo $_SESSION['logInAdminInfo'][1]?>">
  <input type="hidden" name="" class="" id="userLname" value="<?php echo $_SESSION['logInAdminInfo'][2]?>">
  <input type="hidden" name="" class="" id="userID" value="<?php echo $_SESSION['logInAdminInfo'][0]?>">
  <input type="hidden" name="changePassID" id="" class="form-control" placeholder="Id" value="<?php echo $_SESSION['logInAdminInfo'][0]?>">

  <div class="container mb-5">
    <div class="row">
      <div class="col-lg-12">
        <div id = "">
          <div id="orderImportHistory">
              <!--===============================================
                              where import history appear
                    ===================================================-->
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--===============================================
                            MOdal for import History data
                  ===================================================-->
  <div class="modal fade" id="importHistoryModal">
      <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content">
          
              <!-- Modal Header -->
              <div class="modal-header">
              <h6 class="modal-title">Import Order</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div id="importDataAppear">
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


<?php include 'template/admin_footer.php'?>
  
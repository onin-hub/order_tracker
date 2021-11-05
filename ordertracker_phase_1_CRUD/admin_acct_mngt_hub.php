
<?php
require 'core/admin_init/admin_init.php';
?>

<?php include 'template/admin_header.php'?>

<div class="container" style = "margin-top:80px">
    <hr class = "my-4">

    <div class="row mb-3">
        <div class="col-lg-6 ">
            <div class = "" id = "showHubData">
                <!-- ************************************************
                    where the hub_area_number table data appear
                *****************************************************-->
            </div>
       </div>
    </div>
</div>

<br>
  <!-- ======================================================================
                                    ADD ACCOUNT CODE
  ========================================================================-->
  <!-- =============================
      ADD ACCOUNT MODAL INSERT
  ==================================-->
  <div class="modal fade" id="addAccountModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">ADD ACCOUNT</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">

                    <form action="phpAction/admin_action/admin_action.php" method="POST">
                        
                        <div class="form-group">
                            <input type="text" name="" id = "fName" class="form-control" placeholder="First Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" id = "lName" class="form-control" placeholder="Last Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" id = "uName" class="form-control" placeholder="User Name" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="" id = "uPass" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" id = "uContact" class="form-control" placeholder="Contact #" required>
                        </div>

                        <div class="input-group mb-3">
                            <select class="custom-select" name = "" id = "uRole">
                                <option selected>Choose...</option>
                                <option value="Admin">Admin</option>
                                <option value="Hub Supervisor">Hub Supervisor</option>
                                <option value="Shipper">Shipper</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text">User Role</label>
                            </div>
                        </div>

                        <div class="input-group mb-3" id = "showAccountArea">
                             <!-- ============================================
                                    Where the hub_area_number Fetch again
                            =================================================-->
                        </div>

                        <div class="form-group">
                            <input type="submit" name="" id="insertAccount" value="Save" class = "btn btn-primary">
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>


  <!-- =============================
      EDIT ADD ACCOUNT MODAL INSERT
  ==================================-->
    <div class="modal fade" id="editAddAccountModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">EDIT ACCOUNT</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                <!-- phpAction/admin_action/admin_action.php -->
                    <form action="" method="POST">

                        <input type="text" name="" id="editAccountId" class="form-control" placeholder="Id"> 
                        <div class="form-group">
                            <input type="text" name="" id = "efName" class="form-control" placeholder="First Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" id = "elName" class="form-control" placeholder="Last Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" id = "euName" class="form-control" placeholder="User Name" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="" id = "euPass" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" id = "euContact" class="form-control" placeholder="Contact #" required>
                        </div>

                        <div class="input-group mb-3">
                            <select class="custom-select" name = "" id = "euRole">
                                <option selected>Choose...</option>
                                <option value="Admin">Admin</option>
                                <option value="Hub Supervisor">Hub Supervisor</option>
                                <option value="Shipper">Shipper</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text">User Role</label>
                            </div>
                        </div>

                        <div class="input-group mb-3" id = "editShowAccountArea">
                             <!-- ============================================
                                    Where the hub_area_number Fetch again
                            =================================================-->
                        </div>

                        <div class="form-group">
                            <input type="submit" name="" id="editInsertAccount" value="Save" class = "btn btn-primary">
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
  <!-- ======================================================================
                                    END ADD ACCOUNT CODE
  ========================================================================-->


<!-- ======================================================================
                                    HUB MODAL CODE
  ========================================================================-->
     <!-- =============================
      ADD HUB MODAL INSERT
  ==================================-->
  <div class="modal fade" id="addHubModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">ADD HUB</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">

                    <form action="phpAction/admin_action/admin_action.php" method="POST">
                        
                        <div class="form-group">
                            <input type="text" name="" id="hubNumber" class="form-control" placeholder="Hub Number" autocomplete="off" required = "true" style="text-transform: uppercase;">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="" id="add_HubNumber" value="Save" class = "btn btn-primary" >
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- =============================
      EDIT HUB MODAL
  ==================================-->
  <div class="modal fade" id="editHubModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">EDIT HUB</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">

                    <form action="phpAction/admin_action/admin_action.php" method="POST" autocomplete="off">
                        
                        <input type="hidden" name="" id="id_HubNumber" class="form-control" placeholder="Id">   
                        <div class="form-group">
                            <input type="text" name="" id="edit_Hub_Number" class="form-control" placeholder="Hub Number" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="" id="insert_Edit_Hub_Number" value="Save" class = "btn btn-primary">
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
<!-- ======================================================================
                                    END HUB MODAL CODE
  ========================================================================-->

<?php include 'template/admin_footer.php'?>
  
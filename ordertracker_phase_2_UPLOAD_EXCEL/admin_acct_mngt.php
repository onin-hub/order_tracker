


<?php include 'template/header.php'?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class = "" id = "showUser">  
                    <!-- ***************************
                        where the users_tables tables render  
                    *******************************-->
                </div>
            </div>
        </div>
        <hr class = "my-4">
        <div class="row">
            <div class="col-lg-6">
                <div class = "" id = "showHub">  
                    <!-- ***************************
                        where the hub_area_number tables render  
                    *******************************-->
                </div>
            </div>
        </div>
        <br>
        <br>

    </div>

        <!--******************** 
            Add account Modal 
        ************************-->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Add Account</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <form action="" method="POST" id="user-form-data">
                        <div class="form-group">
                            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="uname" class="form-control" placeholder="User Name" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="pw" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="contact" class="form-control" placeholder="Contact #" required>
                        </div>

                        <div class="input-group mb-3">
                            <select class="custom-select" id="inputGroupSelect02" name = "uRole">
                                <option selected>Choose...</option>
                                <option value="Admin">Admin</option>
                                <option value="Hub Supervisor">Hub Supervisor</option>
                                <option value="Shipper">Shipper</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text" for="inputGroupSelect02">Role</label>
                            </div>
                        </div>

                        <div class="input-group mb-3" id = "dropHub">
                            <!-- *********************************
                                hub_data render here dropdown
                            ***********************************-->
                        </div>

                        <div class="form-group">
                            <input type="submit" name="insert" id="insert" value="Save" class = "btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--*************************
            edit Add account Modal 
        ************************-->
        <div class="modal fade" id="editAddModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Edit Account</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <form action="" method="POST" id="edit-user-form-data">
                        <input type="hidden" name = "id" id = "id">
                        <div class="form-group">
                            <input type="text" name="fname" class="form-control" id ="firstName" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="lname" class="form-control" id ="lastName" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="uname" class="form-control" id ="uName" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="pw" class="form-control" id ="upass" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="contact" class="form-control" id ="uContact" required>
                        </div>

                        <div class="input-group mb-3">
                            <select class="custom-select"  name = "uRole" id = "userRole">
                                <option selected >Choose...</option>
                                <option value="Admin">Admin</option>
                                <option value="Hub Supervisor">Hub Supervisor</option>
                                <option value="Shipper">Shipper</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text" for="inputGroupSelect02">Role</label>
                            </div>
                        </div>

                        <div class="input-group mb-3" id = "dropHub2">
                            <!-- *********************************
                                hub_data render here dropdown
                            ***********************************-->
                        </div>

                        <div class="form-group">
                            <input type="submit" name="editAccount" id="editAccount" value="Save" class = "btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



     <!--******************** 
            Add hub Modal 
        ************************-->
    <div class="modal fade" id="hubModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Add Hub Area</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <form action="" method="POST" id="hub-form-data">
                        <div class="form-group">
                            <input type="text" name="hubNumber" class="form-control" placeholder="Hub Number" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="insertHub" id="insertHub" value="Save" class = "btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!--******************** 
            edit hub Modal 
        ************************-->
        <div class="modal fade" id="editHubModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Add Hub Area</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <input type="hidden" name ="idHubName" id ="idHub">
                    <form action="" method="POST" id="edit-hub-form">
                        <div class="form-group">
                            <input type="text" name="hubNumber" class="form-control " id="hubNum" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="updatesHub" id="updatesHub" value="Save" class = "btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    


 <?php include 'template/footer.php'?>



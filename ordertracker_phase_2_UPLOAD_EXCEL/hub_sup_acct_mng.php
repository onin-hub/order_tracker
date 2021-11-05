


<?php include 'template/header.php'?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                
                    <button type="button" class="btn btn-primary btn-sm my-3" data-toggle="modal" data-target="#addShipperModal" >Add Shipper Account</button>      
                
            </div>
        </div>
    </div>





    <!-- **************************************
        MODAL AREA
     ******************************************-->


     <!-- **************************************
        ADD SHIPPER ACCOUNT MODAL
     ******************************************-->
     <div class="modal fade" id="addShipperModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Add Shipper Account</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">

                    <form action="" method="POST" id="">
                        <div class="form-group">
                            <input type="text" name="" class="form-control" placeholder="First Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" class="form-control" placeholder="Last Name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" class="form-control" placeholder="User Name" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="" class="form-control" placeholder="Contact #" required>
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

                        <div class="input-group mb-3">
                            <select class="custom-select" id="" name = "">
                                <option selected>Default Hub Number dpt</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text" for="inputGroupSelect02">Hub Number</label>
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <input type="submit" name="insert" id="insert" value="Save" class = "btn btn-primary">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

 <?php include 'template/footer.php'?>



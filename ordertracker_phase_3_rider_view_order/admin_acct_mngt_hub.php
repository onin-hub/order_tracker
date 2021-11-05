


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
                             <input type="text" value="" data-role="tagsinput" placeholder="Insert covered zipcode" class = "inputZipcode"/>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="" id="add_HubNumber" value="Save" class = "btn btn-success btn-sm" >
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
                             <input type="text" class = "editInputZipcode" value="" data-role="tagsinput" placeholder="Insert covered zipcode" />
                        </div>

                       
                        <div class="form-group">
                            <input type="submit" name="" id="insert_Edit_Hub_Number" value="Save" class = "btn btn-success btn-sm">
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>


<!-- =============================
      show hub zipcode MODAL
  ==================================-->
  <div class="modal fade" id="showHubZipcodeModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title">Hub Zipcode List</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <div id = "showHubZipcode">
                        <!-- =============================
                            hub zipcode Appear
                        ==================================-->
                    </div>
                </div>

            </div>
        </div>
    </div>
<!-- ======================================================================
                                    END HUB MODAL CODE
  ========================================================================-->

<?php include 'template/admin_footer.php'?>
  
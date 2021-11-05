


<?php include 'template/hubsup_header.php'?>


      <div class="container" style = "margin-top:80px">
        <div class="row mb-3">
            <h3>Dispatched Order <?php echo $_SESSION['logInHubSuperVisorInfo'][7];?></h3>
            <div class="col-lg-12">
              <div id = "showCurrentHubDispatchedOrder">
                  <!--===============================================
                            show Shipper current pending order
                  ===================================================-->
             
              </div>
              <input id = "dugetUserHubNUmber" type="hidden" name="" class="form-control" placeholder="First Name" value = "<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
            </div>
        </div>
      </div>


<!--*******************************
    Customer Details Modal
*********************************** -->
<div class="modal fade" id="Customer_details_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title" >Customer Details</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                        <div id = "showCustomerDetails">
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

                       <div id = "showCustomerOrderDetails">
                        <!--===============================================
                                  where Customer Details Appear
                        ===================================================-->
                       </div>
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

                       <div id = "showAllShipperDetails">
                        <!--===============================================
                                  where Customer Details Appear
                        ===================================================-->
                       </div>
                       <input type="hidden" class="form-control" id="copyHubNumber"  placeholder="HubNumber">
                       <input type="hidden" class="form-control" id="rcopyOrderNumber" placeholder="OrderNumber">
                       <button type="submit" class="btn btn-success btn-sm mt-2 updateOrderByshipper">Save</button>
                </div>

            </div>
        </div>
    </div>

      
<?php include 'template/hubsup_footer.php'?>
  
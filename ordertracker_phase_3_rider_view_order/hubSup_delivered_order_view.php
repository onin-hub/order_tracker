


<?php include 'template/hubsup_header.php'?>

      <div class="container" style = "margin-top:80px">
        <div class="row">
            <h3>Delivered Order <?php echo $_SESSION['logInHubSuperVisorInfo'][7];?></h3>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
            <div id = "hshowDeliveredOrder">
                <!--===============================================
                            show Shipper current pending order
                ===================================================-->
            </div>
            <input type="hidden" name="" class="form-control hubNumber" placeholder="First Name" value = "<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
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
                       
                       <!-- <button type="hidden" class="btn btn-success btn-sm adminShipperBtn" data-toggle="modal" data-target="#assign_modal">Dispatch</button> -->
                </div>

            </div>
        </div>
    </div>

      
<?php include 'template/hubsup_footer.php'?>
  
<?php include 'template/shipper_header.php'?>


      <div class="container" style = "margin-top:80px">
        <div class="row mb-3">
            <h3>Delivered Order</h3>
            <div class="col-lg-12">
              <div id = "showDeliveredOrder">
                  <!--===============================================
                           show Shipper Dispatch VIew Here
                  ===================================================-->
              </div>
              <input id = "shipperID" type="hidden" name="" class="form-control" placeholder="First Name" value = "<?php echo $_SESSION['logInShipperInfo'][0]; ?>">
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
                       <!-- <input type="text" name="" class="form-control dupHubnumber" placeholder="First Name" value = ""> -->
                       <!-- <button type="submit" class="btn btn-success btn-sm forDeliveryBtn" data-toggle="modal" data-target="#forDelivery_modal">For Delivery</button> -->
                </div>

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

 


<?php include 'template/shipper_footer.php'?>
  
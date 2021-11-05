

<?php include 'template/admin_header.php'?>
    <!-- ======= About Section ======= -->

      <div class="container" style = "margin-top:80px">
        <div class="row">
            <h3>Dispatched Order</h3>
        </div>

            <div class="row">
            <div class="my-2 ml-2">
                <div id = "showAllHubsForDropDownForDispatched">
                    <!--===============================================
                                filter by hub Area
                    ===================================================-->
                    
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
              <div id = "showDispatchOrderHere">
                  <!--===============================================
                            dispatch order here
                  ===================================================-->
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
<?php include 'template/admin_footer.php'?>
  
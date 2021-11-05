
<?php include 'template/admin_header.php'?>

    <!-- ======= About Section ======= -->

      <div class="container" style = "margin-top:80px">

        <div class="row">
            <h3>Orders</h3>
        </div>

        <div class="row my-3">
        <div class="col-lg-2 my-1">
                    <select class="browser-default custom-select zipcode-size fOrderStatus">
                        <option selected value="empty">Filter by status</option>
                        <option value="pending">Pending</option>
                        <option value="for checking">Dispatched</option>
                        <option value="for delivery">For delivery</option>
                        <option value="paid">Paid</option>
                        <option value="voided">Voided</option>
                    </select>
            </div>

            <div class="col-lg-2 my-1">
                <div id = "showAllHubsForDropDown">
                    <!--===============================================
                                filter by hub Area
                    ===================================================-->
                </div>
            </div>

            <div class="col-lg-4 my-1" id="datePicker">
                 <input type="text" name="daterange" value="" id="dateStartAndEnd"/> <!-- datepicker -->
                 <button type="submit" class="btn btn-success btn-sm" id="generateBtn">Generate</button>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
              <div id = "showManageOrderHere">
                  <!--===============================================
                            where Hub details show dropdown 
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
                       
                       <!-- <button type="submit" class="btn btn-success btn-sm adminShipperBtn" data-toggle="modal" data-target="#assign_modal">Dispatch</button> -->
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
                       <input type="hidden" class="form-control" id="copyHubNumber" aria-describedby="emailHelp" placeholder="HubNumber">
                       <input type="hidden" class="form-control" id="rcopyOrderNumber" aria-describedby="emailHelp" placeholder="OrderNumber">
                       <button type="submit" class="btn btn-success btn-sm mt-2 updateOrderByshipper">Save</button>
                </div>

            </div>
        </div>
    </div>
    
<?php include 'template/admin_footer.php'?>
  
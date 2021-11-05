<?php include 'template/shipper_header.php'?>


      <div class="container" style = "margin-top:80px">
        <div class="row mb-3">
            <h3>For Delivery Order</h3>
            <div class="col-lg-12">
              <div id = "showDeliveryOrderForShipper">
                  <!--===============================================
                            show delivery order for shipper
                  ===================================================-->
              </div>
              <input type="hidden" name="" class="form-control userId" placeholder="shipper id" value = "<?php echo $_SESSION['logInShipperInfo'][0]; ?> ">
            </div>
        </div>
      </div>


      
<!--*******************************
    customer satisfaction Modal
*********************************** -->
<div class="modal fade" id="customerSatisfactionModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title" >Customer Satisfaction</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <h6 class="text-center">Star Rating</h6>

                    <div class="row my-3 text-center ">
                        <div class="col-lg-12 my-3 pointer" id = "fiveStar" value = "5">
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar" ></span>
                        </div>

                        <div class="col-lg-12 my-3 pointer" id = "fourStar" value = "4">
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star" ></span>
                        </div>


                        <div class="col-lg-12 my-3 pointer" id = "threeStar" value = "3">
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star "></span>
                            <span class="fa fa-star " ></span>
                        </div>

                        <div class="col-lg-12 my-3 pointer" id = "twoStar" value = "2">
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star "></span>
                            <span class="fa fa-star "></span>
                            <span class="fa fa-star " ></span>
                        </div>

                        <div class="col-lg-12 my-3 pointer" id = "oneStar" value = "1">
                            <span class="fa fa-star checkedStar"></span>
                            <span class="fa fa-star "></span>
                            <span class="fa fa-star "></span>
                            <span class="fa fa-star "></span>
                            <span class="fa fa-star " ></span>
                        </div>
                    </div>
                    <input type="hidden" name="" class="form-control dupOrderID" placeholder="orderId" value = "">
                    <input type="hidden" name="" class="form-control dupCustoName" placeholder="cusFullName" value = "">
                    <input type="hidden" name="" class="form-control getRating" placeholder="ratings" value = "">
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
                       <input type="hidden" name="" class="form-control dupHubnumber" placeholder="First Name" value = "">
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



  <!--*******************************
    delivered/cancelled Modal
*********************************** -->
<div class="modal fade" id="DeliveredOrCancelledModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title" >Order Marking</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                        <button type="submit" class="btn btn-primary btn-success form-control orderDeliveredBtn" data-toggle="modal" data-target="#">Delivered</button>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                        <button type="submit" class="btn btn-primary btn-danger form-control orderVoidedBtn" data-toggle="modal" data-target="#voidedModal">Cancelled</button>
                    </div>

                  </div>
                  <input type="hidden" name="" class="form-control dupOrderNumber" placeholder="ordernumber" value = ""> <!-- get the orderNumber -->
                </div>
            </div>
        </div>
    </div>

<!--*******************************
    Voiding Modal
*********************************** -->
<div class="modal fade" id="voidedModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h6 class="modal-title" >Voiding</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                  <input type="text" name="" class="form-control mb-3 voidRemark" placeholder="Remarks" value = "">
                  <button type="submit" class="btn btn-primary btn-danger form-control saveOrderVoid" data-toggle="modal" data-target="#voidedModal">Void</button>

                  <input type="hidden" name="" class="form-control dupOrderNumber" placeholder="ordernumber" value = ""> <!-- get the orderNumber -->
                </div>
            </div>
        </div>
    </div>





<?php include 'template/shipper_footer.php'?>
  
<?php
include 'template/admin_header.php';

?>

<div class="container" style="margin-top:80px">

    <div class="row">
        <div class="col-lg-12">
            <h4>NA items</h4>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <div id="showNAItems">
                <!--===============================================
                                show Shipper current pending order
                    ===================================================-->
            </div>
            <input id="ugetUserHubNUmber" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInAdminInfo'][7]; ?>">
            <input id="ugetUserID" type="hidden" name="" class="form-control" placeholder="UID" value="<?php echo $_SESSION['logInAdminInfo'][0]; ?>">
        </div>
    </div>

</div>


<!--===============================================
        MOdal for import History data
===================================================-->
<div class="modal fade" id="NAProdModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">NA product/s</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div id="showNAProdName">
                <!--===============================================
                        where the import history extra data appear
                ===================================================-->
            </div>
        </div>
    </div>
</div>


<?php include 'template/admin_footer.php' ?>
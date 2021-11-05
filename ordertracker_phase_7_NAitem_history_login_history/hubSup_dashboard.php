<?php
include 'template/hubsup_header_chart.php';
$currentYear = date('Y');
?>

<div class="container" style="margin-top:60px">
  <div class="row">
    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
      <h6>DASHBOARD</h6>
    </div>
  </div>
</div>

<div class="container">
  <div class="row mb-3">
    <!-- year picker here -->
    <div class="col-lg-6">
      <form action="" autocomplete="off">
        <input type="text" id="datepicker" placeholder="Insert Year" />
        <button type="submit" class="btn btn-success btn-sm ml-2" id="generateBtnByYear">Generate</button>
        <canvas id="myChart" width="400" height="200"></canvas>
      </form>
    </div>
  </div>
  <input id="ugetUserHubNUmberForGraph" type="hidden" name="" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['logInHubSuperVisorInfo'][7]; ?>">
  <input type="hidden" id="" class="cYear" placeholder="Current Year" value="<?php echo $currentYear ?>" />
</div>



<?php include 'template/hubsup_footer_chart.php' ?>
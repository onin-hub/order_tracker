

<?php include 'template/admin_header.php'?>


  <main id="main">
   
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">

            <h3>IMPORT ORDER</h3>

            <div class="col-lg-12 mt-5">
              <div id = "showHubdetailsForImport">
                  <!--===============================================
                            where Hub details show dropdown 
                  ===================================================-->
              </div>
            </div>

              <form class="">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="input-import-driver" class="form-control-file" id="input-import-driver" accept=".csv">
                    </div>

                    <div class="input-group-append">
                        <button id="btn-import-driver" class="btn btn-success" type="button">Import</button>
                    </div>
                </div>
              </form>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->
  
    

  </main><!-- End #main -->


<?php include 'template/admin_footer.php'?>
  
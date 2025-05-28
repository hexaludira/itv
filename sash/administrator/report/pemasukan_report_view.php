<?php

$jasperServerUrl = "http://itinventory.mbgfiber.com:8391/jasperserver";

// Pastikan variabel diambil dari input form dengan metode yang sesuai
$report_date_from = isset($_POST['report_date_from']) ? $_POST['report_date_from'] : '';
$report_date_to = isset($_POST['report_date_to']) ? $_POST['report_date_to'] : '';
// var_dump($_SESSION);
$printby = isset($_SESSION['ses_nama']) ? $_SESSION['ses_nama'] : '';

$reportPath = "/flow.html?_flowId=viewReportFlow&standAlone=true&_flowId=viewReportFlow&ParentFolderUri=%2Freports&reportUnit=%2Freports%2FPemasukanperdokpabean&j_username=free&j_password=free&datef=$report_date_from&datet=$report_date_to&printby=$printby";
$reportUrl = $jasperServerUrl . $reportPath ;
?>

<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report - Pemasukan per Dokumen Pabean</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a class='h10'>Active menu / <b>REPORT / Pemasukan per Dokumen Pabean</b></a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

   <!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Report Parameter</h3>
              </div>
              <!-- /.card-header -->
              
             <div class="card-body">
                
                <form method="POST" action="">															 
                    <div class="row">
                        <div class="col-md-1 d-flex align-items-center">
                            <div class="form-group">
                                Date from:
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="date" id="report_date_from" name="report_date_from" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-1 d-flex align-items-center">
                            <div class="form-group">
                                Date to:
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="date" id="report_date_to" name="report_date_to" class="form-control">
                            </div>
                        </div>

                    <div class="col-md-2">
                        	
                        <button type="submit" class="btn btn-primary mt-auto align-self-start">Show Report</button>
                    </div>	  
                  </div> <!-- row -->
                </form>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script>window.open('$reportUrl', '_blank');</script>";
}
?>
<!-- DataTables  & Plugins -->
<!-- <script src="plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- Plugins -->
<!-- <script>
    echo "<script>console.log('Session Data: " . json_encode($_SESSION) . "');</script>";
</script> -->
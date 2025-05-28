<?php
if (isset($_GET['kode'])) {
    $sql_cek = "SELECT * FROM itv_masterdata_company WHERE id_company='" . $_GET['kode'] . "'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
  }
?>
<!-- /template header -->
<?php include 'itv/itv_template_header.php' ?>
<!-- /template header -->  
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Master Data>Company</b></a></li>
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
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Data Company</h3>

            </div>
                <div class="card-body">
                <!-- <form method="POST" action="administrator/user/tambah.php"> -->
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="col">
                    <input type="hidden" class="form-control" placeholder="Id Company" name="id_company" value=<?php echo $data_cek['id_company']; ?>>
                  </div>
                  <div class="col">
                    <label>Company</label>
                    <textarea class="form-control" rows="1" placeholder="Company" id="company" name="company"><?php echo $data_cek['company']; ?></textarea>
                  </div>
                  </br>
                  <div class="col">
                    <label>NPWP</label>
                    <textarea class="form-control" rows="1" placeholder="NPWP" id="npwp" name="npwp"><?php echo $data_cek['npwp']; ?></textarea>
                  </div>
                  </br>
                  <div class="col">
                    <label>NIB</label>
                    <textarea class="form-control" rows="1" placeholder="NIB" id="nib" name="nib"><?php echo $data_cek['nib']; ?></textarea>
                  </div>
                  </br>
                         
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=company_view"><i class="fas fa-backward"></i> Back</a>
                <button type="submit" class="btn btn-primary" name="simpan">Update</button>
              </div>
            </form>
                </div>
          </div>
            <!-- /.card-body -->
        </div>
          <!-- /.card -->
      </div>
</div>
      
    </section>
    <!-- /.content -->
        <?php
        if (isset ($_POST['simpan'])){
            
            $id = $_POST['id_company'];
            $company = $_POST['company'];
            $npwp = $_POST['npwp'];
            $nib = $_POST['nib'];
            
            $query_ubah = mysqli_query($koneksi, "UPDATE itv_masterdata_company SET company='$company', npwp='$npwp', nib='$nib' WHERE id_company='$id'");
            if ($query_ubah) {
              echo "<script>location='index.php?page=company_view'</script>";
              }else{
              echo "<script>location='index.php?page=company_edit'</script>";
          }
          }
            ?>

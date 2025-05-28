<?php
    $sql_cek = "SELECT * FROM user WHERE id_user='" . $data_id . "'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>PROFILE/Manage My Account</b></a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Change My Password</h3>

            </div>
                <div class="card-body">
                <!-- <form method="POST" action="administrator/user/tambah.php"> -->
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="col">
                    <input type="hidden" class="form-control" placeholder="Id User" name="id_user" value=<?php echo $data_cek['id_user']; ?>>
                  </div>
                  <div class="col">
                    <label>New Password</label>
                    <input type="password" class="form-control" placeholder="New Password" name="new_password" REQUIRED>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="index.php"><i class="fas fa-backward"></i> Back</a>
                <button type="submit" class="btn btn-primary" name="simpan" onclick="return confirm('Do you really want change your password?')">Update</button>
              </div>
            </form>
                </div>
          </div>
            <!-- /.card-body -->
        </div>
          <!-- /.card -->
      </div>
      
    </section>
    <!-- /.content -->
        <?php
        if (isset ($_POST['simpan'])){
            
            $id = $_POST['id_user'];
            $passMD5 = MD5($_POST['new_password']);
            
            $query_ubah = mysqli_query($koneksi, "UPDATE user SET password='$passMD5' WHERE id_user='$id'");
            if ($query_ubah) {
              echo "<script>location='index.php?page=signout'</script>";
              }else{
              echo "<script>location='index.php?page=me_manage'</script>";
          }
          }
            ?>

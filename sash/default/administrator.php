<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Welcome to IT Inventory Gen 2.0<a> -<?= $data_nama; ?>-</a></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>Dashboard</b></a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
    <div class="container-fluid">
<!-- row info master data -->
      <div class="row">
<!-- card 1 -->
<div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_masterdata_bp where isdelete = 1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Business Partner</p>
              </div>
            </div>
          </div>
<!-- /.card 1 -->
<!-- card 2 -->
<div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_masterdata_item where isdelete = 1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Item General</p>
              </div>
            </div>
          </div>
<!-- /.card 2 -->
<!-- card 3 -->
<div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_lnsw_masterdata_unitcode");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Unit</p>
              </div>
            </div>
          </div>
<!-- /.card 3 -->
      </div>
<!-- /.row info master data -->

<!-- row info trx planned -->
      <div class="row">
<!-- card 4 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_exim_po where total_link=0 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total EXIM PO Not Linked</p>
              </div>
            </div>
          </div>
<!-- /.card 4 -->
<!-- card 5 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_exim_so where total_link=0 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total EXIM SO Not Linked</p>
              </div>
            </div>
          </div>
<!-- /.card 5 -->
<!-- card 6 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_po_header where status=10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Purchase Not Planned</p>
              </div>
            </div>
          </div>
<!-- /.card 6 -->
<!-- card 7 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_so_header where status=10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Sales Not Planned</p>
              </div>
            </div>
          </div>
<!-- /.card 7 -->
      </div>

      <div class="row">
<!-- card 8 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_prod_header where status=10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Production Not Planned</p>
              </div>
            </div>
          </div>
<!-- /.card 8 -->
<!-- card 9 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_wh_header where status=10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Warehouse Not Received or Delivered</p>
              </div>
            </div>
          </div>
<!-- /.card 9 -->
      </div>
<!-- /.row info trx planned -->

<!-- row info trx not planned -->
<div class="row">
<!-- card 4 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_exim_po where total_link > 0 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total EXIM PO Linked</p>
              </div>
            </div>
          </div>
<!-- /.card 4 -->
<!-- card 5 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_exim_so where total_link > 0 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total EXIM SO Linked</p>
              </div>
            </div>
          </div>
<!-- /.card 5 -->
<!-- card 6 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_po_header where status<>10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Purchase</p>
              </div>
            </div>
          </div>
<!-- /.card 6 -->
<!-- card 7 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_so_header where status<>10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Sales</p>
              </div>
            </div>
          </div>
<!-- /.card 7 -->
      </div>

      <div class="row">
<!-- card 8 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_prod_header where status<>10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Production</p>
              </div>
            </div>
          </div>
<!-- /.card 8 -->
<!-- card 9 -->
<div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                    <?php
                        $sql = $koneksi->query("select count(*) as a from itv_wh_header where status<>10 and isdelete=1");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                <h3><?php echo $data['a']; ?></h3>
                    <?php
                        }
                    ?>   
                <p>Total Warehouse</p>
              </div>
            </div>
          </div>
<!-- /.card 9 -->
      </div>
<!-- /.row info trx not planned -->
    </div>
    </section>



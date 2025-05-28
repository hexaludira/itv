<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>INVENTORY/Inventory per Item</b></a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Item General</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Factory</th>
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Item Category</th>
                    <th>Unit</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT *                                           
                                                FROM itv_masterdata_item as A 
                                                JOIN itv_lnsw_masterdata_unitcode as B 
                                                ON A.id_unit_code=B.id_unit_code
                                                JOIN itv_masterdata_factory as C
                                                ON A.id_factory=C.id_factory
                                                JOIN itv_lnsw_masterdata_itemcategorycode as D
                                                ON A.id_item_category_code=D.id_item_category_code
                                                WHERE A.isdelete = '1' 
                                                order by A.id_item asc");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $no++; ?></td>
                    <td><?php echo $data['factory']; ?></td>
                    <td><?php echo $data['item_code']; ?></td>
                    <td><?php echo $data['item_desc']; ?></td>
                    <td><?php echo $data['item_category_code']; ?></td>
                    <td><?php echo $data['unit']; ?></td>
                    <td>                 
                        <a class="btn btn-default btn-sm" href="?page=inventory_per_item_detail_view&kode=<?php echo $data['id_item']; ?>"><i class="fas fa-search"></i>
                          Check Mutation
                        </a>                  
                    </td>
                  </tr>  
                  <?php
                        }
                    ?>               
                  </tbody>
                </table>
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
<!-- /.Main content -->







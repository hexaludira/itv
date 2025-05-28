<?php

include "inc/koneksi.php";
include "inc/koneksi_wms.php";
if (isset($_GET['kode'])) {
  $sql_cek = "SELECT 
              A.SalesOrderNo as SalesOrderNo,
              A.CreatedByUserName as CreatedByUserName,
              A.CreatedDateTime as CreatedDateTime,
              A.Werks as Werks,
              A.CustomerNo as CustomerNo,
              B.Name as Name
              FROM SalesOrder as A INNER JOIN Customer as B ON A.CustomerNo=B.CustomerNo WHERE A.SalesOrderNo='" . $_GET['kode'] . "' AND B.IsDelete='0'";
  $query_cek = sqlsrv_query($koneksi_wms,$sql_cek);
  $data_cek = sqlsrv_fetch_array($query_cek, SQLSRV_FETCH_ASSOC);

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
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Submit To LNSW>Issued To Sales>Sales Order Detail</b></a></li>
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
              <h3 class="card-title">Sales Order Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Sales Order No</label>
                      <input type="text" class="form-control" placeholder="Sales Order No" name="SalesOrderNo" value=<?php echo $data_cek['SalesOrderNo']; ?> disabled>
                    </div> 
                    <div class="col-md-1">
                        <label>Factory</label>
                        <input type="text" class="form-control" placeholder="Factory" name="Factory" value=<?php echo $data_cek['Werks']; ?> disabled>
                    </div>         
                  </div> 
                  </br>
                  <div class="row"> 
                    <div class="col-md-2">
                      <label>Created By</label>
                      <textarea class="form-control" rows="1" placeholder="Created By" id="CreatedByUserName" name="CreatedByUserName" disabled><?php echo $data_cek['CreatedByUserName']; ?></textarea>
                                                                                                                               
                    </div>  
                    <div class="col-md-2">
                    <label>Create Date</label>
                      <textarea class="form-control" rows="1" placeholder="CreatedDateTime" id="CreatedDateTime" name="CreatedDateTime" disabled><?php 
                                                                                                                 $newformatdatex = $data_cek['CreatedDateTime']->format('Y-m-d H:i:s');     
                                                                                                                      echo $newformatdatex; ?></textarea>

                    </div>  
                  </div>
                  </br>
                  <div class="row">  
                    <div class="col-md-1">
                        <label>Customer</label>
                        <input type="text" class="form-control" placeholder="Suuplier No" name="SupplierNo" value=<?php echo $data_cek['CustomerNo']; ?> disabled>                     
                      </div>
                      <div class="col-md-4">  
                        <label>Name</label>              
                        <textarea class="form-control" rows="1" placeholder="Supplier Name" id="Name" name="Name" disabled><?php echo $data_cek['Name']; ?></textarea>
                      </div>                     
                    </div>          
                  </div>                 
                  </br>
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card">                
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                            <thead>
                            <tr>
                              <th>Item No</th>
                              <th>Factory</th>
                              <th>Item Category-LNSW</th>
                              <th>Item</th>
                              <th>Item Name</th>
                              <th>Quantity</th>
                              <th>Unit</th>
                              <th>Unit-LNSW</th>
                              <th>Price</th>                           
                            </tr>
                            </thead>
                            <tbody>
                            <?php                     
                              $sql = "																								
                              select
                              SalesOrderItem.SalesOrderItemNo as SalesOrderItemNo,
                              SalesOrderItem.Werks as Werks,
                              SalesOrderItem.Matnr as Matnr,
                              Material.Name as Name,
                              SalesOrderItem.Quantity,
                              SalesOrderItem.Unit
                              from SalesOrderItem left join Material on SalesOrderItem.Matnr=Material.Matnr and SalesOrderItem.Werks=Material.Werks
                              where 
                              SalesOrderItem.SalesOrderNo='" . $_GET['kode'] . "' 
                              AND Material.IsDelete='0'
                              AND SalesOrderItem.IsDelete='0'
                              ORDER BY SalesOrderItemNo, Matnr ASC";
                                                
                              $stmt = sqlsrv_query($koneksi_wms,$sql);
                              while ($data= sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {                              
                              ?>
                            <tr>
                              <td><?php echo $data['SalesOrderItemNo']; ?></td>
                              <td><?php echo $data['Werks']; ?></td>
                              <td>
                                <?php 
                                   $sql2 = $koneksi->query("SELECT B.item_category_code as itemcat                                                                                                                     
                                                            FROM itv_masterdata_so_price as A
                                                            INNER JOIN itv_lnsw_masterdata_itemcategorycode as B ON A.id_item_category_code = B.id_item_category_code                                                
                                                            WHERE A.SalesOrderNo='" . $_GET['kode'] . "' AND A.SalesOrderItemNo='" . $data['SalesOrderItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'");
                                   while ($data2= $sql2->fetch_assoc()) { echo $data2['itemcat'];} 
                                ?>
                              </td>
                              <td><?php echo $data['Matnr']; ?></td>
                              <td><?php echo $data['Name']; ?></td>  
                              <td><?php echo $data['Quantity']; ?></td> 
                              <td><?php echo $data['Unit']; ?></td>
                              <td>
                                <?php 
                                   $sql2 = $koneksi->query("SELECT A.id_unit_code as unitcode, B.unit as unitlnsw                                                                                                                     
                                                            FROM itv_masterdata_so_price as A
                                                            INNER JOIN itv_lnsw_masterdata_unitcode as B ON A.id_unit_code = B.id_unit_code                                                   
                                                            WHERE A.SalesOrderNo='" . $_GET['kode'] . "' AND A.SalesOrderItemNo='" . $data['SalesOrderItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'");
                                   while ($data2= $sql2->fetch_assoc()) { echo $data2['unitcode']; echo '-'; echo $data2['unitlnsw'];} 
                                ?>
                              </td>
                              <td>
                                <?php 
                                   $sql2 = $koneksi->query("SELECT A.price as price, 
                                                            B.symbol as symbol
                                                            FROM itv_masterdata_so_price as A
                                                            INNER JOIN itv_masterdata_currency as B ON A.id_currency = B.id_currency                                                   
                                                            WHERE A.SalesOrderNo='" . $_GET['kode'] . "' AND A.SalesOrderItemNo='" . $data['SalesOrderItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'");
                                   while ($data2= $sql2->fetch_assoc()) { echo $data2['symbol']; echo ' '; echo number_format($data2['price'],2);} 
                                ?>
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
                  </div>
              </div>         
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=issued_sales_view"><i class="fas fa-backward"></i> Back</a>
              </div>
            </form>
                </div>
          </div>
        </div>
      </div>
   </div>
   </div>
    </section>
   <!-- /.Main content -->






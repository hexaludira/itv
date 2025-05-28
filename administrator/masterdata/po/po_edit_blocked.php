<?php

include "inc/koneksi.php";
include "inc/koneksi_wms.php";
if (isset($_GET['kode'])) {
  $sql_cek = "SELECT 
              Purchase.PurchaseNo as PurchaseNo,
              Purchase.CreatedByUserName as CreatedByUserName,
              Purchase.CreatedDateTime as CreatedDateTime,
              Purchase.AuditByUserName as AuditByUserName,
              Purchase.AuditDateTime as AuditDateTime,
              Purchase.Werks as Werks,
              Purchase.SupplierNo as SupplierNo,
              Supplier.Name as Name
              FROM Purchase INNER JOIN supplier ON Purchase.SupplierNo=Supplier.SupplierNo WHERE Purchase.PurchaseNo='" . $_GET['kode'] . "' AND Supplier.IsDelete='0'";
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
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Submit To LNSW>Receipt From Purchase>Purchase Order Detail</b></a></li>
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
              <h3 class="card-title">Purchase Order Detail</h3>

            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-2">
                      <label>Purchase No</label>
                      <input type="text" class="form-control" placeholder="Purchase No" name="PurchaseNo" value=<?php echo $data_cek['PurchaseNo']; ?> disabled>
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
                      <input type="text" class="form-control" placeholder="Created By" name="CreatedByUserName" value=<?php echo $data_cek['CreatedByUserName']; ?> disabled>
                      <label>Audited By</label>
                      <input type="text" class="form-control" placeholder="Audited By" name="AuditByUserName" value=<?php echo $data_cek['AuditByUserName']; ?> disabled>            
                    </div>  
                    <div class="col-md-2">
                    <label>Create Date</label>
                      <textarea class="form-control" rows="1" placeholder="CreatedDateTime" id="CreatedDateTime" name="CreatedDateTime" disabled><?php 
                                                                                                                                                  if ($data_cek['CreatedDateTime'] == NULL){
                                                                                                                                                    echo "";
                                                                                                                                                  }
                                                                                                                                                  else {
                                                                                                                                                    $newformatdatex = $data_cek['CreatedDateTime']->format('Y-m-d H:i:s');     
                                                                                                                                                    echo $newformatdatex; 
                                                                                                                                                  }
                                                                                                                                                  ?></textarea>                                                                                                                
                      <label>Audit Date</label>
                      <textarea class="form-control" rows="1" placeholder="Audit DateTime" id="AuditDateTime" name="AuditDateTime" disabled><?php 
                                                                                                                                                  if ($data_cek['AuditDateTime'] == NULL){
                                                                                                                                                    echo "";
                                                                                                                                                  }
                                                                                                                                                  else {
                                                                                                                                                    $newformatdatex = $data_cek['CreatedDateTime']->format('Y-m-d H:i:s');     
                                                                                                                                                    echo $newformatdatex; 
                                                                                                                                                  }
                                                                                                                                                  ?></textarea>
                    </div>  
                  </div>
                  </br>
                  <div class="row">  
                    <div class="col-md-1">
                        <label>Supplier</label>
                        <input type="text" class="form-control" placeholder="Suuplier No" name="SupplierNo" value=<?php echo $data_cek['SupplierNo']; ?> disabled>                     
                      </div>
                      <div class="col-md-4">  
                        <label>Name</label>              
                        <textarea class="form-control" rows="1" placeholder="Supplier Name" id="Name" name="Name" disabled><?php echo $data_cek['Name']; ?></textarea>
                      </div>
                    </div>          
                  </div>
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card">                       
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Line</th>
                              <th>Factory</th>
                              <th>Item</th>
                              <th>Item Name</th>
                              <th>Quantity</th>
                              <th>Unit</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php                     
                              $sql = "																								
                                      select
                                      PurchaseItem.PurchaseItemNo as PurchaseItemNo,
                                      PurchaseItem.Werks as Werks,
                                      PurchaseItem.Matnr as Matnr,
                                      Material.Name as Name,
                                      PurchaseItem.Quantity,
                                      PurchaseItem.Unit
                                      from PurchaseItem left join Material on PurchaseItem.Matnr=Material.Matnr and PurchaseItem.Werks=Material.Werks
                                      where PurchaseItem.PurchaseNo='" . $_GET['kode'] . "' AND Material.IsDelete='0'
                                                ";
                              $stmt = sqlsrv_query($koneksi_wms,$sql);
                              while ($data= sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                              ?>
                            <tr>
                              <td><?php echo $data['PurchaseItemNo']; ?></td>
                              <td><?php echo $data['Werks']; ?></td>
                              <td><?php echo $data['Matnr']; ?></td>
                              <td><?php echo $data['Name']; ?></td>  
                              <td><?php echo $data['Quantity']; ?></td>    
                              <td><?php echo $data['Unit']; ?></td>                         
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
                <a class="btn btn-secondary" href="?page=receipt_pur_view"><i class="fas fa-backward"></i> Back</a>
              </div>
            </form>
                </div>
          </div>
        </div>
      </div>
   </div>
      
    </section>
   <!-- /.Main content -->


    <!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>





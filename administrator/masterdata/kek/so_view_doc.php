<?php

include "inc/koneksi.php";
include "inc/koneksi_wms.php";
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
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Master Data>KEK's Document SO</b></a></li>
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
                <h3 class="card-title">KEK's Document SO Data</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Factory</th>
                                            <th>Sales Order No</th>
                                            <th>Remark</th>
                                            <th>Customer</th>
                                            <th>Customer Name</th>
                                            <th>Created Date</th>  
                                            <th>Create By</th>                                                                 
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php                     
                                                $sql = "																								
                                                SELECT 
                                                A.Werks as Werks,
                                                A.SalesOrderNo as SalesOrderNo,
                                                A.BSTKD as Remark,
                                                A.CustomerNo as CustomerNo,
                                                B.Name as Name,
                                                A.CreatedDateTime as CreatedDateTime,
                                                A.CreatedByUserName as CreatedByUserName,
                                                A.AuditDateTime as AuditDateTime,
                                                A.AuditByUserName as AuditByUserName
                                                FROM
                                                SalesOrder as A
                                                INNER JOIN Customer as B on A.CustomerNo=B.CustomerNo
                                                WHERE 
                                                A.CreatedDateTime < '2023-12-31 00:00:00'
                                                AND
                                                A.AuditState = '1'
                                                AND
                                                A.IsDelete = '0'
                                                ORDER BY Werks,SalesOrderNo,Remark,CustomerNo																																																
																								";
                                                $stmt = sqlsrv_query($koneksi_wms,$sql);
                                                while ($data= sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                        <tr>     
                                            <td><?php echo $data['Werks']; ?></td>                                             
                                            <td><?php echo $data['SalesOrderNo']; ?></td>  
                                            <td><?php echo $data['Remark']; ?></td>   
                                            <td><?php echo $data['CustomerNo']; ?></td> 
                                            <td><?php echo $data['Name']; ?></td>
                                            <td><?php 
                                                if ($data['CreatedDateTime'] == NULL)
                                                {
                                                  echo " ";
                                                }
                                                else
                                                {
                                                $newformatdate = $data['CreatedDateTime']->format('Y-m-d H:i:s');
                                                echo $newformatdate;
                                                } 
                                                ?>
                                            </td>          
                                            <td><?php echo utf8_encode($data['CreatedByUserName']); ?></td>                                             
                                            <td>                                              
                                                <a class="btn btn-default btn-sm" href="?page=so_add_document&kode=<?php echo $data['SalesOrderNo']; ?>">
                                                    <i class="fas fa-search"></i>
                                                    Detail
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







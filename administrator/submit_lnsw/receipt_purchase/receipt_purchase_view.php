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
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Submit To LNSW>Receipt From Purchase</b></a></li>
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
        <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">WMS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">TRANSFORMED</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-hobby-tab" data-toggle="pill" href="#custom-tabs-three-hobby" role="tab" aria-controls="custom-tabs-three-hobby" aria-selected="false">LNSW</a>
                  </li>
                </ul>
              </div>
              <!-- Card Body --> 
              <div class="card-body">  
                <!-- Tab -->             
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <!-- Tab WMS -->
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                  <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Receipt From Purchase Data</h3>
                        </div>
                          <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>Receipt Date</th>
                                  <th>Receipt No</th> 
                                  <th>Receipt Item No</th>                                            
                                  <th>Factory</th>
                                  <th>Purchase No WMS</th>
                                  <th>Purchase No Internal</th>                         
                                  <th>Item</th>
                                  <th>Item Name</th>
                                  <th>Quantity</th>
                                  <th>Unit</th>
                                  <th>Batch</th>
                                  <th>Warehouse</th>  
                                  <th>Storehouse</th>
                                  <th>Price</th>
                                  <th>KEK's Document</th> 
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php                     
                                  $sql = "																								
                                          SELECT
                                          B.CreatedDateTime as CreatedDateTime,
                                          A.Werks as Werks,
                                          A.PurchaseReceiveNo,
                                          B.PurchaseReceiveItemNo,
                                          B.PurchaseItemNo as PurchaseItemNo,
                                          A.PurchaseNo as PurchaseNo,
                                          D.Remark as Remark,
                                          B.Matnr as Matnr,
                                          C.Name as Name,
                                          B.Quantity as Quantity,
                                          B.Unit as Unit,
                                          B.Lot as Lot,
                                          B.Lgort as Lgort,
                                          B.LocationNo as LocationNo
                                          FROM
                                          PurchaseReceive as A
                                          INNER JOIN PurchaseReceiveItem as B on A.PurchaseReceiveNo=B.PurchaseReceiveNo
                                          INNER JOIN Material as C on B.Matnr=C.Matnr AND b.Werks=c.Werks
                                          INNER JOIN Purchase as D on A.PurchaseNo=D.PurchaseNo
                                          WHERE 
                                          A.CreatedDateTime > '2023-12-31 00:00:00'
                                          AND
                                          B.IsDelete = 0
                                          AND
                                          C.IsDelete = 0
                                          AND
                                          B.itv_flag_status IS NULL
                                          AND
                                          D.AuditByUserName <> ''
                                          AND
                                          D.IsDelete = '0'
                                          ORDER BY CreatedDateTime,Werks,PurchaseReceiveNo,PurchaseReceiveItemNo,PurchaseNo																																														
																					";
                                  $stmt = sqlsrv_query($koneksi_wms,$sql);
                                  while ($data= sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                  <tr> 
                                    <td>
                                      <?php 
                                        $newformatdate = $data['CreatedDateTime']->format('Y-m-d H:i:s');
                                        echo $newformatdate; 
                                      ?>
                                    </td>  
                                    <td><?php echo $data['PurchaseReceiveNo']; ?></td>  
                                    <td><?php echo $data['PurchaseReceiveItemNo']; ?></td>      
                                    <td><?php echo $data['Werks']; ?></td>                                        
                                    <td><a href="?page=po_edit_blocked&kode=<?php echo $data['PurchaseNo']; ?>"><u><?php echo $data['PurchaseNo']; ?></u></a></td>      
                                    <td><?php echo $data['Remark']; ?></td>                                                     
                                    <td><?php echo $data['Matnr']; ?></td>  
                                    <td><?php echo $data['Name']; ?></td>  
                                    <td><?php echo $data['Quantity']; ?></td>
                                    <td><?php echo $data['Unit']; ?></td>  
                                    <td><?php echo $data['Lot']; ?></td> 
                                    <td><?php echo $data['Lgort']; ?></td>  
                                    <td><?php echo $data['LocationNo']; ?></td>   
                                    <td style="text-align:center;">
                                      <?php 
                                        $sql2 = $koneksi->query("SELECT IFNULL( (SELECT DISTINCT A.price
                                                                 FROM itv_masterdata_po_price as A                                                                                                                          
                                                                 WHERE A.PurchaseNo='$data[PurchaseNo]' AND A.Werks='" . $data['Werks'] . "' AND A.PurchaseItemNo='$data[PurchaseItemNo]' AND A.isdelete='1'),'1')");                                                                                  
                                        while ($data2= $sql2->fetch_row()) {   
                                        $row_cnt = $data2[0];                                                                                                            
                                        if ($row_cnt == '1') 
                                        { ?>
                                          <button class="btn btn-danger btn-sm"><i class="fas fa-close"></i>                                                 
                                          </button>
                                            <?php
                                        }
                                        else 
                                        {   ?> 
                                          <button class="btn btn-success btn-sm"><i class="fas fa-check"></i>                                                     
                                          </button>
                                            <?php
                                        }
                                        } 
                                            ?>
                                    </td>
                                    <td>
                                      <?php 
                                        $sql2 = $koneksi->query("SELECT B.nomorDokumen as dokumen, 
                                                                 C.id_doc_code as id_doc_code,
                                                                 C.document as document
                                                                 FROM itv_masterdata_po_price as A
                                                                 INNER JOIN itv_masterdata_po_dokumen as B ON A.id_po_dokumen = B.id_po_dokumen     
                                                                 INNER JOIN itv_lnsw_masterdata_documentcode as C ON B.id_doc_code = C.id_doc_code                                             
                                                                 WHERE A.PurchaseNo='$data[PurchaseNo]' AND A.PurchaseItemNo='" . $data['PurchaseItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'");
                                        while ($data2= $sql2->fetch_assoc()) { echo $data2['dokumen']; echo ' ('; echo $data2['id_doc_code']; echo '-'; echo $data2['document']; echo ')';} 
                                      ?>
                                    </td>                  
                                    <td>
                                      <?php 
                                        $sql2 = $koneksi->query("SELECT IFNULL( (SELECT A.price
                                                                 FROM itv_masterdata_po_price as A
                                                                 INNER JOIN itv_masterdata_currency as B ON A.id_currency = B.id_currency                                                   
                                                                 WHERE A.PurchaseNo='$data[PurchaseNo]' AND A.PurchaseItemNo='" . $data['PurchaseItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'),'1')");                                   
                                        while ($data2= $sql2->fetch_row()) {   
                                        $row_cnt = $data2[0];                                                                                                            
                                        if ($row_cnt == '1') 
                                        { ?>
                                          <button class="btn btn-warning btn-sm btn_edit" name="<?php echo $data['PurchaseNo']; ?>" id="<?php echo $data['PurchaseReceiveItemNo']; ?>" disabled><i class="fa fa-atom fa-spin"></i>
                                            Transform
                                          </button>
                                            <?php
                                        }
                                        else 
                                        { 
                                            ?> 
                                          <button class="btn btn-warning btn-sm btn_edit" name="<?php echo $data['PurchaseNo']; ?>" id="<?php echo $data['PurchaseReceiveItemNo']; ?>"><i class="fa fa-atom fa-spin"></i>
                                            Transform
                                          </button>
                                            <?php
                                        }
                                        } 
                                            ?> 
                                        </td>
                                      </tr>  
                                        <?php
                                          }
                                        ?>               
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>  
                  </div>
                  <!-- /.Tab WMS -->
                  <!-- Tab Transformed -->
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                  <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Receipt From Purchase Transformed Data</h3>
                        </div>
                          <div class="card-body">                          
                          <table id="example1" class="table table-bordered table-striped" cellspacing="0">
                          <thead>
                            <tr>                           
                            <th>Purchase No</th> 
                            <th>Receipt Item No</th>                                            
                            <th>Receipt Item Date</th>
                            <th>Supplier</th>
                            <th>Item Category-LNSW</th>
                            <th>Item</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Unit-LNSW</th>
                            <th>Total Price</th>
                            <th>Doc Code-LNSW</th>
                            <th>Document No</th>
                            <th>Document Date</th>
                            <th>Action</th>                                          
                            </tr>
                          </thead>
                          <tbody>    
                          <?php                     
                            $sql = $koneksi->query("SELECT
                            A.Werks as Werks,                            
                            A.PurchaseNo as PurchaseNo,
                            A.PurchaseReceiveItemNo as PurchaseReceiveItemNo,
                            A.PurchaseReceiveItemNo_CreatedDateTime as PurchaseReceiveItemNo_CreatedDateTime,
                            A.Supplier_Name as Supplier_Name,
                            A.id_item_category_code as id_item_category_code,
                            B.item_category_code as item_category_code,
                            A.Matnr as Matnr,
                            A.Matnr_Name as Matnr_Name,
                            A.Quantity as Quantity,
                            A.id_unit_code as id_unit_code,
                            C.unit as unitlnsw,
                            A.tot_price as tot_price,
                            A.id_doc_code as id_doc_code,
                            A.nomorDokumen as nomorDokumen,
                            A.tanggalDokumen as tanggalDokumen
                            FROM
                            itv_transform_receipt as A
                            INNER JOIN
                            itv_lnsw_masterdata_itemcategorycode as B ON A.id_item_category_code=B.id_item_category_code
                            INNER JOIN
                            itv_lnsw_masterdata_unitcode as C ON A.id_unit_code=C.id_unit_code
                            WHERE 
                            A.IsDelete = 1
                            AND 
                            A.flag_receipt_type = '1'
                            AND
                            A.submit_status = '1'
                            ORDER BY A.Werks,A.PurchaseNo,A.PurchaseReceiveItemNo,A.PurchaseReceiveItemNo_CreatedDateTime");
                            while ($data= $sql->fetch_assoc()) {
                          ?>         
                            <tr>   
                            <td><?php echo $data['PurchaseNo']; ?></td>
                            <td><?php echo $data['PurchaseReceiveItemNo']; ?></td> 
                            <td><?php echo $data['PurchaseReceiveItemNo_CreatedDateTime']; ?></td> 
                            <td><?php echo $data['Supplier_Name']; ?></td>
                            <td><?php echo $data['id_item_category_code']; echo ' ('; echo $data['item_category_code']; echo ')';?></td>   
                            <td><?php echo $data['Matnr']; ?></td>    
                            <td><?php echo $data['Matnr_Name']; ?></td>    
                            <td><?php echo $data['Quantity']; ?></td>   
                            <td><?php echo $data['id_unit_code']; ?><?php echo ' ('; echo $data['unitlnsw']; echo ')';?></td>                                
                            <td><?php echo $data['tot_price']; ?></td>   
                            <td><?php echo $data['id_doc_code']; ?></td> 
                            <td><?php echo $data['nomorDokumen']; ?></td> 
                            <td><?php echo $data['tanggalDokumen']; ?></td> 
                            <td><button class="btn btn-primary btn-sm btn_submit" name="<?php echo $data['PurchaseNo']; ?>" id="<?php echo $data['PurchaseReceiveItemNo']; ?>" onclick="return confirm('Do you really want to submit ?')"><i class="fa fa-paper-plane"></i>
                                  Submit
                                </button>
                            </td> 
                            </tr> 
                            <?php
                              }
                            ?>
                          </tbody> 
                          </table>
                          </div>                                          
                        </div>
                      </div>                     
                    </div>
                    <!-- /.Tab Transformed -->
                    <!-- Tab LNSW -->
                  <div class="tab-pane fade" id="custom-tabs-three-hobby" role="tabpanel" aria-labelledby="custom-tabs-three-hobby-tab">
                  <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Receipt From Purchase LNSW Data</h3>
                        </div>
                          <div class="card-body">                          
                          <table id="example3" class="table table-bordered table-striped" cellspacing="0">
                          <thead>
                            <tr>
                            <th>Purchase No</th> 
                            <th>Receipt Item No</th>                                            
                            <th>Receipt Item Date</th>
                            <th>Supplier</th>
                            <th>Item Category-LNSW</th>
                            <th>Item</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Unit-LNSW</th>
                            <th>Total Price</th>
                            <th>Doc Code-LNSW</th>
                            <th>Document No</th>
                            <th>Document Date</th>                                                                     
                            </tr>
                          </thead>
                          <tbody>    
                          <?php                     
                            $sql = $koneksi->query("SELECT
                            A.PurchaseNo as PurchaseNo,
                            A.PurchaseReceiveItemNo as PurchaseReceiveItemNo,
                            A.PurchaseReceiveItemNo_CreatedDateTime as PurchaseReceiveItemNo_CreatedDateTime,
                            A.Supplier_Name as Supplier_Name,
                            A.id_item_category_code as id_item_category_code,
                            B.item_category_code as item_category_code,
                            A.Matnr as Matnr,
                            A.Matnr_Name as Matnr_Name,
                            A.Quantity as Quantity,
                            A.id_unit_code as id_unit_code,
                            C.unit as unitlnsw,
                            A.tot_price as tot_price,
                            A.id_doc_code as id_doc_code,
                            A.nomorDokumen as nomorDokumen,
                            A.tanggalDokumen as tanggalDokumen
                            FROM
                            itv_transform_receipt as A
                            INNER JOIN
                            itv_lnsw_masterdata_itemcategorycode as B ON A.id_item_category_code=B.id_item_category_code
                            INNER JOIN
                            itv_lnsw_masterdata_unitcode as C ON A.id_unit_code=C.id_unit_code
                            WHERE 
                            A.IsDelete = 1
                            AND 
                            A.flag_receipt_type = '1'
                            AND
                            A.submit_status = '2'
                            ORDER BY A.Werks,A.PurchaseNo,A.PurchaseReceiveItemNo,A.PurchaseReceiveItemNo_CreatedDateTime");
                            while ($data= $sql->fetch_assoc()) {
                          ?>         
                            <tr>  
                            <td><?php echo $data['PurchaseNo']; ?></td>
                            <td><?php echo $data['PurchaseReceiveItemNo']; ?></td> 
                            <td><?php echo $data['PurchaseReceiveItemNo_CreatedDateTime']; ?></td> 
                            <td><?php echo $data['Supplier_Name']; ?></td>
                            <td><?php echo $data['id_item_category_code']; echo ' ('; echo $data['item_category_code']; echo ')';?></td>   
                            <td><?php echo $data['Matnr']; ?></td>    
                            <td><?php echo $data['Matnr_Name']; ?></td>    
                            <td><?php echo $data['Quantity']; ?></td>   
                            <td><?php echo $data['id_unit_code']; ?><?php echo ' ('; echo $data['unitlnsw']; echo ')';?></td>                                
                            <td><?php echo $data['tot_price']; ?></td>   
                            <td><?php echo $data['id_doc_code']; ?></td> 
                            <td><?php echo $data['nomorDokumen']; ?></td> 
                            <td><?php echo $data['tanggalDokumen']; ?></td> 
                            </tr> 
                            <?php
                              }
                            ?>
                          </tbody> 
                          </table>
                          </div>                                          
                        </div>
                      </div>                     
                    </div>
                    <!-- /.Tab LNSW -->
                  </div>
                  <!-- /.Tab -->
                </div>
                <!-- /.Card Body -->
              </div>
            </div>
          </div>
        </div>
</section>
<!-- /.Main content -->

<!------------------- Modal Transform ---------------------------------->
  
<div class="modal fade" id="modal_transform">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Transform</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form id="add_system_form" method="post">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="form-group">                                                       
                            <input type="hidden" class="form-control" id="flag_receipt_type" name="flag_receipt_type" value="1">                         
                          </div>
                          <div class="form-group">                                                       
                            <input type="hidden" class="form-control" id="id_trx_type_code" name="id_trx_type_code" value="30">                         
                          </div>  
                          <div class="form-group">                           
                            <input type="hidden" class="form-control" id="npwp" name="npwp" value="031339922063000">                         
                          </div> 
                          <div class="form-group">                           
                            <input type="hidden" class="form-control" id="nib" name="nib" value="8120218022499">                         
                          </div>
                          <div class="form-group">                           
                            <input type="hidden" class="form-control" id="PurchaseNo" name="PurchaseNo">                         
                          </div> 
                          <div class="form-group"> 
                            <label><h5>Factory</h5></label>                           
                            <input type="text" class="form-control" id="Werks" name="Werks" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Receive Item No</h5></label>                             
                            <input type="text" class="form-control" id="PurchaseReceiveItemNo" name="PurchaseReceiveItemNo" disabled>                         
                          </div> 
                          <div class="form-group"> 
                            <label><h5>Receive Item Date Time</h5></label>                             
                            <input type="text" class="form-control" id="PurchaseReceiveItemNo_CreatedDateTime" name="PurchaseReceiveItemNo_CreatedDateTime" disabled>                         
                          </div>  
                          <div class="form-group">   
                            <label><h5>Supplier Name</h5></label>                        
                            <textarea class="form-control" rows="3" placeholder="Supplier_Name" id="Supplier_Name" name="Supplier_Name" disabled></textarea>                         
                          </div>      
                          <div class="form-group">
                            <label><h5>Item Category-LNSW</h5></label>
                            <input type="hidden" class="form-control" id="id_item_category_code" name="id_item_category_code" disabled>
                            <input type="text" class="form-control" id="item_category_code" name="item_category_code" disabled>
                          </div>
                          <div class="form-group">
                           <label><h5>Receive Item</h5></label>
                           <input type="text" class="form-control" id="Matnr" name="Matnr" disabled>
                           <textarea class="form-control" rows="3" placeholder="Matnr_Name" id="Matnr_Name" name="Matnr_Name" disabled></textarea>
                          </div> 
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="text" class="form-control" id="Quantity" name="Quantity" disabled>
                          </div> 
                          <div class="form-group">
                            <label><h5>Unit-LNSW</h5></label></br>
                            <input type="text" class="form-control" id="id_unit_code" name="id_unit_code" disabled>
                            <input type="text" class="form-control" id="unitlnsw" name="unitlnsw" disabled>
                          </div> 
                          <div class="form-group">
                            <label><h5>Total Price</h5></label></br>
                            <input type="text" class="form-control" id="tot_price" name="tot_price" disabled>
                          </div>
                          <div class="form-group">
                            <label><h5>Document Code</h5></label></br>
                            <input type="text" class="form-control" id="id_doc_code" name="id_doc_code" disabled>
                            <input type="hidden" class="form-control" id="id_po_dokumen" name="id_po_dokumen" disabled>
                          </div>
                          <div class="form-group">
                            <label><h5>Document No</h5></label></br>
                            <input type="text" class="form-control" id="nomorDokumen" name="nomorDokumen" disabled>
                          </div>
                          <div class="form-group">
                            <label><h5>Document Date</h5></label></br>
                            <input type="text" class="form-control" id="tanggalDokumen" name="tanggalDokumen" disabled>
                          </div>
                        </div>                                          
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_transform">Transform</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Transform<END> ---------------------------------->    
<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">

$(document).ready(function(){

  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
    $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

        /* ======================= Edit Transform ========================= */
        $('#example2').on('click','.btn_edit', function(e){
            e.preventDefault();
              var PurchaseReceiveItemNo = $(this).attr('id');
              var PurchaseNo = $(this).attr('name');              
              $.ajax({
                url : "itv/administrator/submit_lnsw/receipt_purchase/receipt_purchase_controller.php",
                type : 'POST',
                data : {PurchaseReceiveItemNo_Edit : PurchaseReceiveItemNo, 
                        PurchaseNo : PurchaseNo},
                dataType : 'json',
                success : function(response){
                  console.log(response[1]);
                  
                  $("#modal_transform").modal("show");
                  $('#PurchaseReceiveItemNo').val(response[0].PurchaseReceiveItemNo);
                  $('#PurchaseNo').val(response[0].PurchaseNo);
                  $('#Werks').val(response[0].Werks);
                  $('#PurchaseReceiveItemNo_CreatedDateTime').val(response[0].PurchaseReceiveItemNo_CreatedDateTime['date']);
                  $('#Supplier_Name').val(response[0].Supplier_Name);
                  $('#id_item_category_code').val(response[1].id_item_category_code);
                  $('#item_category_code').val(response[1].item_category_code);
                  $('#Matnr').val(response[0].Matnr);
                  $('#Matnr_Name').val(response[0].Matnr_Name);
                  $('#Quantity').val(response[0].Quantity);
                  $('#Unit').val(response[0].Unit);
                  $('#unitlnsw').val(response[1].unitlnsw);
                  $('#tot_price').val(response[1].tot_price);
                  $('#id_po_dokumen').val(response[1].id_po_dokumen);
                  $('#id_unit_code').val(response[1].id_unit_code);
                  $('#id_doc_code').val(response[1].id_doc_code);
                  $('#nomorDokumen').val(response[1].nomorDokumen);
                  $('#tanggalDokumen').val(response[1].tanggalDokumen);
                }
              });
              //Swal.fire(edit_id);
            });
            });
        /* ======================== <END> Edit Transform <END> ===================== */

        /* ======================= Save Transform ========================= */
        $('#btn_add_transform').on('click', function(e){
        e.preventDefault();
        var flag_receipt_type = $('#flag_receipt_type').val();
        var id_trx_type_code = $('#id_trx_type_code').val();
        var npwp = $('#npwp').val();
        var nib = $('#nib').val();
        var PurchaseReceiveItemNo = $('#PurchaseReceiveItemNo').val();
        var PurchaseNo = $('#PurchaseNo').val();
        var Werks = $('#Werks').val();
        var PurchaseReceiveItemNo_CreatedDateTime = $('#PurchaseReceiveItemNo_CreatedDateTime').val();
        var Supplier_Name = $('#Supplier_Name').val();
        var id_item_category_code = $('#id_item_category_code').val();
        var Matnr = $('#Matnr').val();
        var Matnr_Name = $('#Matnr_Name').val();
        var Quantity = $('#Quantity').val();
        var id_unit_code = $('#id_unit_code').val();
        var tot_price = $('#tot_price').val();
        var id_po_dokumen = $('#id_po_dokumen').val();
        var id_doc_code = $('#id_doc_code').val();
        var nomorDokumen = $('#nomorDokumen').val();
        var tanggalDokumen = $('#tanggalDokumen').val();
        //console.log(id_currency,price);

        $.ajax({
          url : "itv/administrator/submit_lnsw/receipt_purchase/receipt_purchase_controller.php",
          type : 'POST',
          data : {PurchaseReceiveItemNo_Save : PurchaseReceiveItemNo,
                  flag_receipt_type : flag_receipt_type,
                  id_trx_type_code : id_trx_type_code,
                  npwp : npwp,
                  nib : nib, 
                  PurchaseNo : PurchaseNo,
                  Werks : Werks,
                  PurchaseReceiveItemNo_CreatedDateTime : PurchaseReceiveItemNo_CreatedDateTime,
                  Supplier_Name : Supplier_Name,
                  id_item_category_code : id_item_category_code,
                  Matnr : Matnr,
                  Matnr_Name : Matnr_Name,
                  Quantity : Quantity,
                  id_unit_code : id_unit_code,
                  tot_price : tot_price,
                  id_po_dokumen : id_po_dokumen,
                  id_doc_code : id_doc_code,
                  nomorDokumen : nomorDokumen,
                  tanggalDokumen : tanggalDokumen
          },
          success : function(response){
            console.log(response);
            if(response == "1"){
              Swal.fire("Data added succesfully",'','success');
            } else {
              Swal.fire("Adding Data Failed",'','error')
            }
            
            $('#flag_receipt_type').val("");
            $('#id_trx_type_code').val("");
            $('#npwp').val("");
            $('#nib').val("");
            $('#PurchaseReceiveItemNo').val("");
            $('#PurchaseNo').val("");
            $('#Werks').val("");
            $('#PurchaseReceiveItemNo_CreatedDateTime').val("");
            $('#Supplier_Name').val("");
            $('#id_item_category_code').val("");
            $('#Matnr').val("");
            $('#Matnr_Name').val("");
            $('#Quantity').val("");
            $('#id_unit_code').val("");
            $('#tot_price').val("");
            $('#id_po_dokumen').val("");
            $('#id_doc_code').val("");
            $('#nomorDokumen').val("");
            $('#tanggalDokumen').val("");

            $('#modal_transform').modal("hide");
            setInterval('location.reload()',1500);
          }
        });
      });
      /* ==================== <END> Save Transform <END> ====================== */
    
      /* ========================  Submit Transformed Data To LNSW  ===================== */
      $('#example1').on('click','.btn_submit', function(e){
        e.preventDefault();
        var PurchaseReceiveItemNo = $(this).attr('id');
        var PurchaseNo = $(this).attr('name');

        $.ajax({
          url : "itv/administrator/submit_lnsw/receipt_purchase/receipt_purchase_controller.php",
          type : 'POST',
          data : {PurchaseReceiveItemNo_API : PurchaseReceiveItemNo,               
                  PurchaseNo : PurchaseNo                 
          },
          success : function(response){
            console.log(response)
            if(response == "1"){
              Swal.fire("Data submited succesfully",'','success');
            } else {
              Swal.fire("Submit data failed",'','error')
            }
            setInterval('location.reload()',1500);
          }
        });
      });
      /* ======================== <END> Submit Transformed Data To LNSW <END> ===================== */
      
    </script>
    <!------------------------------ <END> JavaScript <END> --------------------------------------->






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
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Master Data>Sales Order>Sales Order Detail</b></a></li>
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
                              <th>KEK's Document</th>
                              <th>Action</th>                             
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
                              <td>
                                <?php 
                                    $sql2 = $koneksi->query("SELECT B.nomorDokumen as dokumen, 
                                                              C.id_doc_code as id_doc_code,
                                                              C.document as document
                                                              FROM itv_masterdata_so_price as A
                                                              INNER JOIN itv_masterdata_so_dokumen as B ON A.id_so_dokumen = B.id_so_dokumen     
                                                              INNER JOIN itv_lnsw_masterdata_documentcode as C ON B.id_doc_code = C.id_doc_code                                             
                                                              WHERE A.SalesOrderNo='" . $_GET['kode'] . "' AND A.SalesOrderItemNo='" . $data['SalesOrderItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'");
                                    while ($data2= $sql2->fetch_assoc()) { echo $data2['dokumen']; echo ' ('; echo $data2['id_doc_code']; echo '-'; echo $data2['document']; echo ')';} 
                                  ?>
                              </td>                               
                              <td>
                                <?php 
                                    $sql2 = $koneksi->query("SELECT IFNULL( (SELECT A.price
                                                              FROM itv_masterdata_so_price as A
                                                              INNER JOIN itv_masterdata_currency as B ON A.id_currency = B.id_currency                                                   
                                                              WHERE A.SalesOrderNo='" . $_GET['kode'] . "' AND A.SalesOrderItemNo='" . $data['SalesOrderItemNo'] . "' AND A.Matnr='" . $data['Matnr'] . "' AND A.Werks='" . $data['Werks'] . "' AND A.isdelete='1'),'1')");                                   
                                    
                                    while ($data2= $sql2->fetch_row()) {   
                                      $row_cnt = $data2[0];                                                                                                            
                                      if ($row_cnt == '1') 
                                      { ?>
                                        <button class="btn btn-primary btn-sm btn_edit" name="<?php echo $_GET['kode'] ?>" id="<?php echo $data['SalesOrderItemNo']; ?>"><i class="fas fa-plus"></i>
                                          Add Price & Link Document
                                      </button>
                                      <?php
                                      }
                                      else { ?> 
                                        <button class="btn btn-primary btn-sm btn_edit" name="<?php echo $_GET['kode'] ?>" id="<?php echo $data['SalesOrderItemNo']; ?>" disabled><i class="fas fa-plus"></i>
                                          Add Price & Link Document
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
                        <!-- /.card-body -->
                        </div>
                      <!-- /.card -->
                    </div>
                  </div>
              </div>         
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=so_view"><i class="fas fa-backward"></i> Back</a>
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

<!------------------- Modal Add Price ---------------------------------->
  
<div class="modal fade" id="modal_add_price">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Price & Link Document</h4>
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
                        <!-- <div class="form-group">
                           <input type="hidden" class="form-control" id="system_id_edit">
                        </div> -->
                        <div class="form-group">
                          <div class="form-group">                           
                            <input type="hidden" class="form-control" id="Werks" name="Werks">                         
                          </div>  
                          <div class="form-group">                           
                            <input type="hidden" class="form-control" id="SalesOrderNo" name="SalesOrderNo">                         
                          </div>  
                          <div class="form-group">   
                            <label><h5>Item No</h5></label>                        
                            <input type="text" class="form-control" id="SalesOrderItemNo" name="SalesOrderItemNo" disabled>                         
                          </div>      
                          <div class="form-group">
                            <label><h5>Item Category-LNSW</h5></label><label> </label><label><h6><i>*Note: Must be same with PPKEK</i></h6></label></br>
                            <select class="form-control custom-select" id="id_item_category_code" name="id_item_category_code">
                            <?php 
                              $itemcatcodeisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_itemcategorycode"); 
                              while($row = mysqli_fetch_array($itemcatcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item_category_code]>$row[item_category_code]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <input type="text" class="form-control" id="Matnr" name="Matnr" disabled>                         
                          </div>
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="text" class="form-control" id="Quantity" name="Quantity" disabled>
                          </div> 
                          <div class="form-group">
                            <label><h5>Unit</h5></label>
                            <input type="text" class="form-control" id="Unit" name="Unit" disabled>
                          </div> 
                          <div class="form-group">
                            <label><h5>Unit-LNSW</h5></label><label> </label><label><h6><i>*Note: Must be same with PPKEK</i></h6></label></br>
                            <select class="form-control custom-select" id="id_unit_code" name="id_unit_code">
                            <?php 
                              $unitcodeisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_unitcode"); 
                              while($row = mysqli_fetch_array($unitcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_unit_code]>$row[id_unit_code] $row[unit]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                           <label><h5>KEK's Document</h5></label>
                              <select class="form-control custom-select" id="id_so_dokumen" name="id_so_dokumen">
                                <?php 
                                  $documentisi = mysqli_query($koneksi, "select * from itv_masterdata_so_dokumen as A where A.SalesOrderNo='" . $_GET['kode'] . "'"); 
                                  while($row = mysqli_fetch_array($documentisi)){?>
                                      <?php                                  
                                        echo "<option value=$row[id_so_dokumen]>$row[nomorDokumen] - $row[tanggalDokumen]</option>";
                                      ?>
                                <?php } ?>
                              </select>
                          </div> 
                          <div class="form-group">
                           <label><h5>Currency</h5></label>
                              <select class="form-control custom-select" id="id_currency" name="id_currency">
                                <?php 
                                  $currencyisi = mysqli_query($koneksi, "select * from itv_masterdata_currency"); 
                                  while($row = mysqli_fetch_array($currencyisi)){?>
                                      <?php                                  
                                        echo "<option value=$row[id_currency]>($row[symbol])  $row[currency]</option>";
                                      ?>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Price</h5></label>
                            <input type="number" placeholder="Insert price here" class="form-control" id="price" name="price">
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
            <button type="button" class="btn btn-success" id="btn_add_price">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add Price<END> ---------------------------------->




<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">

$(document).ready(function(){
  $("#id_item_category_code").select2({
    dropdownParent : $('#modal_add_price .modal-content'),
    theme : 'bootstrap4',
  });

  $('#id_unit_code').select2({
    dropdownParent : $('#modal_add_price .modal-content'),
    theme : 'bootstrap4',
  });


        /* ======================= Add Price ========================= */
        $('#example2').on('click','.btn_edit', function(e){
            e.preventDefault();
              var SalesOrderItemNo = $(this).attr('id');
              var SalesOrderNo = $(this).attr('name');
              //$("#modal_add_price").modal("show");
              $.ajax({
                url : "itv/administrator/masterdata/so/so_add_price_controller.php",
                type : 'POST',
                data : {SalesOrderItemNo_Edit : SalesOrderItemNo, SalesOrderNo : SalesOrderNo},
                dataType : 'json',
                success : function(response){
                  //console.log(response);
                  $("#modal_add_price").modal("show");
                  $('#SalesOrderItemNo').val(response.SalesOrderItemNo);
                  $('#SalesOrderNo').val(response.SalesOrderNo);
                  $('#Werks').val(response.Werks);
                  $('#Matnr').val(response.Matnr);
                  $('#Quantity').val(response.Quantity);
                  $('#Unit').val(response.Unit);
                }
              });
              //Swal.fire(edit_id);
            });
        /* ======================== <END> Add Price <END> ===================== */
      });
    
      /* ======================= Save Price ========================= */
      $('#btn_add_price').on('click', function(e){
        e.preventDefault();
        var Werks = $('#Werks').val();
        var SalesOrderNo = $('#SalesOrderNo').val();
        var SalesOrderItemNo = $('#SalesOrderItemNo').val();
        var id_item_category_code = $('#id_item_category_code').find(":selected").val();
        var Matnr = $('#Matnr').val();
        var Quantity = $('#Quantity').val();
        var Unit = $('#Unit').val();
        var id_unit_code = $('#id_unit_code').find(":selected").val();
        var id_so_dokumen = $('#id_so_dokumen').find(":selected").val();
        var id_currency = $('#id_currency').find(":selected").val();
        var price = $('#price').val();
        console.log(id_currency,price);
        //var table_system = $('#example2').DataTable();

        $.ajax({
          url : 'itv/administrator/masterdata/so/so_add_price_controller.php',
          type : 'POST',
          data : {Werks : Werks, 
                  SalesOrderNo : SalesOrderNo, 
                  SalesOrderItemNo_save : SalesOrderItemNo, 
                  id_item_category_code : id_item_category_code,
                  Matnr : Matnr, 
                  Quantity : Quantity, 
                  Unit : Unit, 
                  id_unit_code : id_unit_code,
                  id_currency : id_currency,
                  id_so_dokumen : id_so_dokumen, 
                  price : price},
          success : function(response){
            console.log(response);
            if(response == "1"){
              Swal.fire("Data added succesfully",'','success');
            } else {
              Swal.fire("Adding Data Failed",'','error')
            }
            
            $('#Werks').val("");
            $('#SalesOrderNo').val("");
            $('#SalesOrderItemNo').val("");
            $('#id_item_category_code').val("");
            $('#Matnr').val("");
            $('#Quantity').val("");
            $('#Unit').val("");
            $('#id_unit_code').val("");
            $('#id_currency').val("");
            $('#id_so_dokumen').val("");
            $('#price').val("");
            $('#modal_add_price').modal("hide");
            setInterval('location.reload()',1500);
           }
        });
      });
      /* ==================== <END> Save Price <END> ====================== */
    </script>





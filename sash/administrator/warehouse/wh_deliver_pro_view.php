<?php

include "inc/koneksi.php";
if (isset($_GET['kode'])) {
  $sql_cek = "SELECT 
            a.id_wh_header as id_wh_header,
            a.wh_order_no as wh_order_no,
            a.wh_order_internal_no as wh_order_internal_no,
            b.trx_type_code as trx_type_code,
            c.order_type as order_type,
            d.sales_order_no as sales_order_no,
            a.send_from as send_from,
            a.send_to as send_to,
            a.status as status
            FROM
            itv_wh_header as a
            LEFT JOIN itv_lnsw_masterdata_trxtypecode as b ON a.id_trx_type_code = b.id_trx_type_code
            LEFT JOIN itv_masterdata_order_type as c ON a.id_order_type = c.id_order_type
            LEFT JOIN itv_so_header as d ON a.id_order_header = d.id_so_header
            WHERE a.id_wh_header='" . $_GET['kode'] . "' AND a.isdelete='1'";

    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

}
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
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>WAREHOUSE/Warehouse Order/Warehouse Order Detail/Deliver</b></a></li>
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
              <h3 class="card-title">Data Warehouse Order & Warehouse Order Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Warehouse Order No</label>
                      <input type="text" class="form-control" placeholder="Warehouse Order No" name="wh_order_no" value=<?php echo $data_cek['wh_order_no']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Warehouse Order Internal No</label>
                        <input type="text" class="form-control" placeholder="Warehouse Order Internal No" name="wh_order_internal_no" value=<?php echo $data_cek['wh_order_internal_no']; ?> disabled>
                    </div>         
                  </div> 
                  </br>
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Transaction Type</label>
                      <input type="text" class="form-control" placeholder="Transaction Type" name="trx_type_code" value=<?php echo $data_cek['trx_type_code']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Order Type</label>
                        <textarea class="form-control" rows="1" placeholder="Order Type" id="order_type" name="order_type" disabled><?php echo $data_cek['order_type']; ?></textarea>
                    </div>         
                  </div> 
                  </br>
                  <div class="row">  
                    <div class="col-md-4">
                        <label>Ship From</label>    
                        <textarea class="form-control" rows="1" placeholder="Send From" id="send_from" name="send_from" disabled><?php echo $data_cek['send_from']; ?></textarea>          
                      </div>                                   
                    </div>          
                  </div>                 
                  <div class="row">  
                    <div class="col-md-4">
                        <label>Ship To</label>   
                        <textarea class="form-control" rows="1" placeholder="Send To" id="send_to" name="send_to" disabled><?php echo $data_cek['send_to']; ?></textarea>            
                      </div>                                         
                    </div>          
                  </div>                 
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card"> 
                        <div class="card-header">
                            <h3 class="card-title">Data Warehouse Order Detail</h3>
              </div>                     
                        <div class="card-body">                      
                          <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Line</th>
                              <th>Item Code</th>
                              <th>Item Description</th>
                              <th>Order Quantity</th>
                              <th>Batch</th>
                              <th>Delivered Quantity</th>
                              <th>Delivered Date</th>
                              <th>Unit</th>
                              <th>Status</th>
                              <th>Action</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php              
                              $no = 1;       
                              $sql = $koneksi->query("SELECT
                                                    a.id_wh_detail as id_wh_detail,
                                                    d.id_wh_detail_root as id_wh_detail_root,
                                                    a.id_wh_header as id_wh_header,
                                                    b.item_code as item_code,
                                                    b.item_desc as item_desc,
                                                    d.batch as batch,
                                                    a.order_quantity as order_quantity,
                                                    d.actual_quantity as actual_quantity,
                                                    d.datetime as receive_datetime,
                                                    c.unit as unit,
                                                    d.status as status
                                                    FROM itv_wh_detail as a 
                                                    LEFT JOIN itv_masterdata_item as b ON a.id_item = b.id_item
                                                    LEFT JOIN itv_lnsw_masterdata_unitcode as c ON b.id_unit_code = c.id_unit_code
                                                    LEFT JOIN itv_wh_detail_root as d ON a.id_wh_detail = d.id_wh_detail
                                                    WHERE a.id_wh_header='" . $data_cek['id_wh_header'] . "' AND d.isdelete = '1'
                                                    ORDER BY a.id_wh_detail, d.id_wh_detail_root ASC");
                              while ($data= $sql->fetch_assoc()) {                              
                              ?>
                            <tr>
                              <td><?php echo $data['id_wh_detail']; ?></td>
                              <td><?php echo 'L-'; ?><?php echo ($no++)*10; ?></td>                             
                              <td><?php echo $data['item_code']; ?></td>
                              <td><?php echo $data['item_desc']; ?></td> 
                              <td><?php echo $data['order_quantity']; ?></td> 
                              <td><?php echo $data['batch']; ?></td> 
                              <td><?php echo $data['actual_quantity']; ?></td>
                              <td><?php echo $data['receive_datetime']; ?></td>
                              <td><?php echo $data['unit']; ?></td>   
                              <td>
                                  <?php $status = $data['status']; ?>
                                  <?php if($status == "10"){?>
                                  <span class="badge bg-secondary">Created</span>
                                  <?php }elseif($status == "40"){ ?>  
                                  <span class="badge bg-success">Received</span> 
                                  <?php }elseif($status == "50"){ ?>  
                                  <span class="badge bg-success">Delivered</span> 
                                  <?php }else{ ?>
                                  <span class="badge bg-danger">Error</span>
                                  <?php } ?>
                              </td>   
                              <td>
                                <?php $status = $data['status'];?>
                                <?php if($status == "10"){?>
                                  <button class="btn btn-warning btn-sm btn_edit" id="<?php echo $data['id_wh_detail']; ?>" name="<?php echo $data['id_wh_detail_root']; ?>" disabled><i class="fas fa-dolly-flatbed"></i></button>
                                  <button class="btn btn-default btn-sm btn_add" id="<?php echo $data['id_wh_detail']; ?>"disabled><i class="fas fa-plus"></i></button>
                                  <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_wh_detail']; ?>" name="<?php echo $data['id_wh_detail_root']; ?>" disabled><i class="fas fa-trash-can"></i>Delete</button>
                                <?php }else{ ?> 
                                  <button class="btn btn-warning btn-sm btn_edit" id="<?php echo $data['id_wh_detail']; ?>" name="<?php echo $data['id_wh_detail_root']; ?>" disabled><i class="fas fa-dolly-flatbed"></i></button>
                                  <button class="btn btn-default btn-sm btn_add" id="<?php echo $data['id_wh_detail']; ?>" disabled><i class="fas fa-plus"></i></button>
                                <?php } ?>
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
              </div>         
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=wh_view"><i class="fas fa-backward"></i> Back</a>
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


<!------------------- Modal Edit/Deliver WO detail ---------------------------------->
<div class="modal fade" id="wh_detail_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delivery Order Item</h4>
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
                            <input type="hidden" class="form-control" id="id_wh_detail_edit" name="id_wh_detail_edit">  
                            <input type="hidden" class="form-control" id="id_wh_header_edit" name="id_wh_header_edit">  
                            <input type="hidden" class="form-control" id="id_order_detail_edit" name="id_order_detail_edit">
                            <input type="hidden" class="form-control" id="id_wh_detail_root_edit" name="id_wh_detail_root_edit">                                              
                          </div>       
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select" id="id_item_edit" name="id_item_edit" disabled>
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select * from itv_masterdata_item"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Order Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity_edit" name="quantity_edit" disabled>
                          </div> 
                          <div class="form-group">
                            <label><h5>Unit</h5></label>
                            <select class="form-control custom-select" id="id_unit_code_edit" name="id_unit_code_edit" disabled>
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_unitcode"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_unit_code]>$row[unit]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div> 
                          <div class="form-group">    
                            <label><h5>Batch No</h5></label>                       
                            <input type="text" class="form-control" id="batch_edit" name="batch_edit">                         
                          </div> 
                          <div class="form-group">    
                            <label><h5>Delivered Quantity</h5></label>                       
                            <input type="number" class="form-control" id="actual_quantity_edit" name="actual_quantity_edit">                         
                          </div> 
                          <div class="form-group">    
                            <label><h5>Delivered Date</h5></label>                       
                            <input type="date" class="form-control" id="receive_datetime_edit" name="receive_datetime_edit">                         
                          </div>                                    
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_po_detail_receive">Deliver</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit/Receive WO detail<END> ---------------------------------->

     <!----------------------- Modal Delete WO detail-------------------------------------->
  <div class="modal fade" id="wo_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Warehouse Order Detail</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to delete?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_delete">Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Delete WO detail<END>---------------------------->

<!----------------------- Modal Add WO detail-------------------------------------->
<div class="modal fade" id="add_confirmation_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add More Delivery</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to add another delivery?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_add">Add</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Add WO detail<END>---------------------------->


<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

        /* ======================= Menampilkan edit modal WO detail ======================= */
      $('#example2').on('click','.btn_edit', function(e){
        e.preventDefault();
        let id_wh_detail_edit = $(this).attr('id');
        let id_wh_detail_root_edit = $(this).attr('name');
        $.ajax({
          url : "sash/administrator/warehouse/wh_deliver_pro_controller.php",
          type : 'POST',
          data : {id_wh_detail_edit : id_wh_detail_edit,
                  id_wh_detail_root_edit : id_wh_detail_root_edit
          },
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#wh_detail_edit_modal").modal("show");
            $('#id_wh_detail_edit').val(response.id_wh_detail);          
            $('#id_wh_header_edit').val(response.id_wh_header);
            $('#id_order_detail_edit').val(response.id_order_detail);
            $('#id_wh_detail_root_edit').val(response.id_wh_detail_root);
            $('#quantity_edit').val(response.order_quantity);
            $('#id_unit_code_edit').val(response.id_unit_code).trigger('change');
            $('#id_item_edit').val(response.id_item).trigger('change');
            $('#actual_quantity_edit').val(response.actual_quantity);
            $('#receive_datetime_edit').val(response.datetime);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal WO detail <END> ==================== */

      /* ======================= Mengupdate WO detail ======================= */
        $('#btn_po_detail_receive').on('click', function(e){
				e.preventDefault();
				let id_wh_detail = $('#id_wh_detail_edit').val();
        let id_wh_header = $('#id_wh_header_edit').val();
        let id_order_detail = $('#id_order_detail_edit').val();
        let id_wh_detail_root = $('#id_wh_detail_root_edit').val();
				let actual_quantity = $('#actual_quantity_edit').val();
				let receive_datetime = $('#receive_datetime_edit').val();
        let batch = $('#batch_edit').val();

				$.ajax({
					url : "sash/administrator/warehouse/wh_deliver_pro_controller.php",
					type : 'POST',
					data : {id_wh_detail_update : id_wh_detail,
                  id_wh_header_update : id_wh_header, 
                  id_order_detail_update : id_order_detail, 
                  id_wh_detail_root_update : id_wh_detail_root, 
                  actual_quantity_update : actual_quantity,
                  receive_datetime_update : receive_datetime,
                  batch_update : batch
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data delivered succesfully",'','success');
            } else {
              Swal.fire("Delivered data failed",'','error');
            }

			      $('#id_wh_detail_edit').val();
            $('#id_wh_header_edit').val();
            $('#id_order_detail').val();
            $('#id_wh_detail_root').val();
            $('#actual_quantity_edit').val("");
            $('#receive_datetime_edit').val("");
            $('#batch_edit').val("");
            $('#wh_detail_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate WO detail <END> ======================= */

      /* =========================== Delete WO detail ========================= */
	    $('#example2').on('click','.btn_delete', function(e){
        e.preventDefault();
        let id_wh_detail = $(this).attr('id');
        let id_wh_detail_root = $(this).attr('name');
        $('#wo_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/warehouse/wh_deliver_pro_controller.php",
            type : 'POST',
            data : {id_wh_detail_delete : id_wh_detail,
                    id_wh_detail_root_delete : id_wh_detail_root
            },
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#wo_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete WO detail <END> ===================== */
      

      /* =========================== Add more wh detail ========================= */
	    $('#example2').on('click','.btn_add', function(e){
        e.preventDefault();
        let id_wh_detail = $(this).attr('id');
        $('#add_confirmation_modal').modal('show');
        $('#btn_confirm_add').on('click', function(){
          $.ajax({
            url : "sash/administrator/warehouse/wh_deliver_pro_controller.php",
            type : 'POST',
            data : {id_wh_detail_add : id_wh_detail
            },
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been added",'','success');
              } else {
                Swal.fire("Data failed to added",'','error');
              }
              $('#add_confirmation_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Add more wh detail <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->





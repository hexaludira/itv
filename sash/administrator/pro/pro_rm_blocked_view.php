<?php

include "inc/koneksi.php";
if (isset($_GET['kode'])) {
            $sql_cek = "SELECT 
            a.id_prod_header as id_prod_header,
            a.prod_order_no as prod_order_no,
            a.prod_order_internal_no as prod_order_internal_no,
            c.production_desc as production_desc,
            a.prod_date as prod_date,
            d.item_code as item_code,
            f.bom_no as bom_no,
            d.item_desc as item_desc,
            b.quantity as quantity,
            e.unit as unit,
            a.createdby as createdby,
            a.createddatetime as createddatetime,
            a.lastupdatedby as lastupdatedby,
            a.lastupdateddatetime as lastupdateddatetime,
            a.status as status,
            a.remark as remark
            FROM itv_prod_header as a
            LEFT JOIN itv_prod_detail_fg as b ON a.id_prod_header = b.id_prod_header
            LEFT JOIN itv_masterdata_production as c ON a.id_production = c.id_production
            LEFT JOIN itv_masterdata_item as d ON b.id_item = d.id_item
            LEFT JOIN itv_lnsw_masterdata_unitcode as e ON d.id_unit_code = e.id_unit_code
            LEFT JOIN itv_masterdata_bom_header as f ON b.id_bom_header=f.id_bom_header
            WHERE a.id_prod_header='" . $_GET['kode'] . "' AND a.isdelete='1'";

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
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>PRODUCTION/Production Order/Material Order Detail</b></a></li>
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
              <h3 class="card-title">Data Production Order & Material Order Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Production Order No</label>
                      <input type="text" class="form-control" placeholder="Production Order No" name="prod_order_no" value=<?php echo $data_cek['prod_order_no']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Production Order Internal No</label>
                        <input type="text" class="form-control" placeholder="Production Order Internal No" name="prod_order_internal_no" value=<?php echo $data_cek['prod_order_internal_no']; ?> disabled>
                    </div>  
                    <div class="col-md-2">
                      <label>Production Date</label>
                      <input type="date" class="form-control" placeholder="Production Date" name="prod_date" value=<?php echo $data_cek['prod_date']; ?> disabled>
                    </div>    
                    <div class="col-md-2">
                        <label>Production Type</label>
                        <input type="text" class="form-control" placeholder="Production Type" name="production_desc" value=<?php echo $data_cek['production_desc']; ?> disabled>
                    </div>    
                  </div>
                  </br> 
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Item</label>
                      <input type="text" class="form-control" placeholder="Item" name="item_code" value=<?php echo $data_cek['item_code']; ?> disabled>
                    </div>     
                    <div class="col-md-2">
                        <label>Description</label>
                        <input type="text" class="form-control" placeholder="Item desc" name="item_desc" value=<?php echo $data_cek['item_desc']; ?> disabled>
                    </div>         
                    <div class="col-md-2">
                      <label>Quantity</label>
                      <input type="number" class="form-control" placeholder="Quantity" name="quantity" value=<?php echo $data_cek['quantity']; ?> disabled>
                    </div>  
                    <div class="col-md-2">
                      <label>Unit</label>
                      <input type="text" class="form-control" placeholder="Unit" name="unit" value=<?php echo $data_cek['unit']; ?> disabled>
                    </div>                
                  </div>
                  </br>
                  <div class="row">     
                  <div class="col-md-2">
                      <label>Bill of Material No</label>
                      <input type="text" class="form-control" placeholder="Bill of Material No" name="bom_no" value=<?php echo $data_cek['bom_no']; ?> disabled>
                    </div>          
                    <div class="col-md-4">
                        <label>Remark</label>
                        <textarea class="form-control" rows="1" placeholder="Remark" id="remark" name="remark" disabled><?php echo $data_cek['remark']; ?></textarea>
                    </div>                        
                  </div>                      
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card"> 
                        <div class="card-header">
                            <h3 class="card-title">Data Material Order Detail</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_pro_rm_detail" disabled><i class="fas fa-plus-square"></i> Add</button>
                            </div>
              </div>                     
                        <div class="card-body">                      
                        <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Line</th>
                              <th>Material Code</th>
                              <th>Material Description</th>
                              <th>Order Quantity</th>
                              <th>Consumption Quantity</th>
                              <th>Unit</th>
                              <th>Batch</th>
                              <th>Status</th>
                              <th>Action</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php              
                              $no = 1;       
                              $sql = $koneksi->query("SELECT
                                                    a.id_prod_detail_rm as id_prod_detail_rm,
                                                    b.item_code as item_code,
                                                    b.item_desc as item_desc,
                                                    a.quantity as quantity, 
                                                    a.actual_quantity as actual_quantity,   
                                                    a.batch as batch,                                               
                                                    c.unit as unit,
                                                    a.status as status
                                                    FROM itv_prod_detail_rm as a
                                                    JOIN itv_masterdata_item as b ON a.id_item = b.id_item
                                                    JOIN itv_lnsw_masterdata_unitcode as c ON b.id_unit_code = c.id_unit_code                                                                  
                                                    WHERE a.id_prod_header='" . $_GET['kode'] . "' AND a.isdelete='1'
                                                    ORDER BY a.id_prod_detail_rm ASC");
                              while ($data= $sql->fetch_assoc()) {                              
                              ?>
                            <tr>
                              <td><?php echo $data['id_prod_detail_rm']; ?></td>
                              <td><?php echo 'L-'; ?><?php echo ($no++)*10; ?></td>
                              <td><?php echo $data['item_code']; ?></td>
                              <td><?php echo $data['item_desc']; ?></td> 
                              <td><?php echo $data['quantity']; ?></td>  
                              <td><?php echo $data['actual_quantity']; ?></td> 
                              <td><?php echo $data['unit']; ?></td>   
                              <td><?php echo $data['batch']; ?></td>   
                              <td>
                                  <?php $status = $data['status']; ?>
                                  <?php if($status == "10"){?>
                                  <span class="badge bg-secondary">Created</span>
                                  <?php }elseif($status == "50"){ ?>  
                                  <span class="badge bg-success">Delivered</span> 
                                  <?php }else{ ?>
                                  <span class="badge bg-danger">Error</span>
                                  <?php } ?>
                              </td>  
                              <td>
                                <?php $status = $data['status'];?>
                                <?php if($status == "10"){?>
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_prod_detail_rm']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_prod_detail_rm']; ?>" disabled><i class="fas fa-trash-can"></i>
                                    Delete
                                </button>
                                <?php }elseif($status == "50"){ ?> 
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_prod_detail_rm']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_prod_detail_rm']; ?>" disabled><i class="fas fa-trash-can"></i>
                                    Delete
                                </button>
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
                <a class="btn btn-secondary" href="?page=pro_view"><i class="fas fa-backward"></i> Back</a>
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

<!------------------- Modal Add material detail ---------------------------------->
  
<div class="modal fade" id="modal_add_pro_rm_detail">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Material Order Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_prod_header" name="id_prod_header" value=<?php echo $data_cek['id_prod_header']; ?>>                         
                          </div>       
                          <div class="form-group">
                            <label><h5>Material</h5></label>
                            <select class="form-control custom-select" id="id_item" name="id_item">
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select 
                                                                  a.id_item as id_item,
                                                                  a.item_code as item_code,
                                                                  a.item_desc as item_desc,
                                                                  b.unit as unit
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code where a.id_item_category_code <> '7' and a.isdelete = '1'"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Order Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
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
            <button type="button" class="btn btn-success" id="btn_add_pro_rm_detail">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add material detail<END> ---------------------------------->

<!------------------- Modal Edit material detail ---------------------------------->
<div class="modal fade" id="pro_rm_detail_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Material Order Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_prod_detail_rm_edit" name="id_prod_detail_rm_edit">                         
                          </div>       
                          <div class="form-group">
                            <label><h5>Material</h5></label>
                            <select class="form-control custom-select" id="id_item_edit" name="id_item_edit">
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select 
                                                                  a.id_item as id_item,
                                                                  a.item_code as item_code,
                                                                  a.item_desc as item_desc,
                                                                  b.unit as unit
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity_edit" name="quantity_edit">
                          </div>                               
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_pro_rm_detail_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
  </div>
    <!------------------- <END>Modal Edit material detail<END> ---------------------------------->

  <!----------------------- Modal Delete pro Detail-------------------------------------->
  <div class="modal fade" id="pro_rm_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Material Order Detail</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to delete the line?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_delete">Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Delete pro Detail<END>---------------------------->



<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add material detail ========================= */
          $(document).ready(function(){
            $('#btn_add_pro_rm_detail').on('click', function(){
            var id_prod_header = $('#id_prod_header').val();
            var id_item = $('#id_item').find(":selected").val();
            var quantity = $('#quantity').val();   

            $.ajax({
              url : "sash/administrator/pro/pro_rm_controller.php",
              type : "POST",
              data : {
                id_prod_header : id_prod_header, 
                id_item : id_item, 
                quantity : quantity          
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#id_prod_header').val("");
                $('#id_item').val("");
                $('#quantity').val("");
                $('#modal_add_pro_rm_detail').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add material detail <END> ===================== */

        /* ======================= Menampilkan edit modal material detail ======================= */
      $('#example2').on('click','.btn_edit', function(e){
        e.preventDefault();
        let id_prod_detail_rm_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/pro/pro_rm_controller.php",
          type : 'POST',
          data : {id_prod_detail_rm_edit : id_prod_detail_rm_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#pro_rm_detail_edit_modal").modal("show");
            $('#id_prod_detail_rm_edit').val(response.id_prod_detail_rm);
            $('#quantity_edit').val(response.quantity);
            $('#id_item_edit').val(response.id_item).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal material detail <END> ==================== */

      /* ======================= Mengupdate material detail ======================= */
        $('#btn_pro_rm_detail_update').on('click', function(e){
				e.preventDefault();
				let id_prod_detail_rm = $('#id_prod_detail_rm_edit').val();
				let quantity = $('#quantity_edit').val();
				let id_item = $('#id_item_edit').find(":selected").val(); 

				$.ajax({
					url : "sash/administrator/pro/pro_rm_controller.php",
					type : 'POST',
					data : {id_prod_detail_rm_update : id_prod_detail_rm, 
                            quantity_update : quantity,                     
                            id_item_update : id_item
						   },
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

			$('#id_prod_detail_rm_edit').val();
            $('#quantity_edit').val("");          
            $('#id_item_edit').val("");
            $('#pro_rm_detail_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate material detail <END> ======================= */

     /* =========================== Delete pro Detail ========================= */
	    $('#example2').on('click','.btn_delete', function(e){
        e.preventDefault();
        let id_prod_detail_rm = $(this).attr('id');
        $('#pro_rm_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/pro/pro_rm_controller.php",
            type : 'POST',
            data : {id_prod_detail_rm_delete : id_prod_detail_rm},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#pro_rm_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete pro Detail <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->





<?php

include "inc/koneksi.php";
if (isset($_GET['kode'])) {
            $sql_cek = "SELECT 
            a.id_scrap_header as id_scrap_header,
            a.scrap_no as scrap_no,
            a.scrap_internal_no as scrap_internal_no,
            a.scrap_date as scrap_date,
            a.remark as remark,
            a.createdby as createdby,
            a.createddatetime as createddatetime,
            a.lastupdatedby as lastupdatedby,
            a.lastupdateddatetime as lastupdateddatetime,
            a.status as status
            FROM itv_scrap_header as a
            WHERE a.id_scrap_header='" . $_GET['kode'] . "' AND a.isdelete='1'";

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
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>SCRAP/Scrap/Scrap Detail</b></a></li>
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
              <h3 class="card-title">Data Scrap & Scrap Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Scrap No</label>
                      <input type="text" class="form-control" placeholder="Scrap No" name="scrap_no" value=<?php echo $data_cek['scrap_no']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Scrap Internal No</label>
                        <input type="text" class="form-control" placeholder="Scrap Internal No" name="scrap_internal_no" value=<?php echo $data_cek['scrap_internal_no']; ?> disabled>
                    </div>         
                  </div>
                  </br>
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Scrap Date</label>
                      <input type="date" class="form-control" placeholder="Scrap Date" name="scrap_date" value=<?php echo $data_cek['scrap_date']; ?> disabled>
                    </div>                          
                  </div> 
                  </br>
                  <div class="row">             
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
                            <h3 class="card-title">Data Scrap Detail</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_scrap_detail"><i class="fas fa-plus-square"></i> Add</button>
                            </div>
              </div>                     
                        <div class="card-body">                      
                          <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Line</th>
                              <th>Item Code</th>
                              <th>Item Description</th>
                              <th>Batch</th>
                              <th>Quantity</th>
                              <th>Unit</th>              
                              <th>Status</th>
                              <th>Action</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php              
                              $no = 1;       
                              $sql = $koneksi->query("SELECT
                                                    a.id_scrap_detail as id_scrap_detail,
                                                    b.item_code as item_code,
                                                    b.item_desc as item_desc,
                                                    a.quantity as quantity,
                                                    a.batch as batch,
                                                    c.unit as unit,
                                                    a.status as status
                                                    FROM itv_scrap_detail as a
                                                    JOIN itv_masterdata_item as b ON a.id_item = b.id_item
                                                    JOIN itv_lnsw_masterdata_unitcode as c ON b.id_unit_code = c.id_unit_code
                                                    WHERE a.id_scrap_header='" . $_GET['kode'] . "' AND a.isdelete='1' ORDER BY a.id_scrap_detail ASC");
                              while ($data= $sql->fetch_assoc()) {                              
                              ?>
                            <tr>
                              <td><?php echo $data['id_scrap_detail']; ?></td>
                              <td><?php echo 'L-'; ?><?php echo ($no++)*10; ?></td>
                              <td><?php echo $data['item_code']; ?></td>
                              <td><?php echo $data['item_desc']; ?></td> 
                              <td><?php echo $data['batch']; ?></td> 
                              <td><?php echo $data['quantity']; ?></td> 
                              <td><?php echo $data['unit']; ?></td>    
                              <td>
                                  <?php $status = $data['status']; ?>
                                  <?php if($status == "10"){?>
                                  <span class="badge bg-secondary">Created</span>
                                  <?php }elseif($status == "70"){ ?>  
                                  <span class="badge bg-success">Completed</span> 
                                  <?php }else{ ?>
                                  <span class="badge bg-danger">Error</span>
                                  <?php } ?>
                              </td>  
                              <td>
                                <?php $status = $data['status'];?>
                                <?php if($status == "10"){?>
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_scrap_detail']; ?>"><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_scrap_detail']; ?>"><i class="fas fa-trash-can"></i>
                                    Delete
                                </button>
                                <?php }elseif($status == "70"){ ?> 
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_scrap_detail']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_scrap_detail']; ?>" disabled><i class="fas fa-trash-can"></i>
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
                <a class="btn btn-secondary" href="?page=scrap_view"><i class="fas fa-backward"></i> Back</a>
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

<!------------------- Modal Add detail ---------------------------------->
  
<div class="modal fade" id="modal_add_scrap_detail">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Scrap Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_scrap_header" name="id_scrap_header" value=<?php echo $data_cek['id_scrap_header']; ?>>                         
                          </div>       
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select" id="id_item" name="id_item">
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select 
                                                                  a.id_item as id_item,
                                                                  a.item_code as item_code,
                                                                  a.item_desc as item_desc,
                                                                  b.unit as unit
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code
                                                                  where a.id_item_category_code = '8'"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Batch</h5></label>
                            <input type="text" class="form-control" id="batch" name="batch">
                          </div> 
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
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
            <button type="button" class="btn btn-success" id="btn_add_scrap_detail">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  

<!------------------- <END>Modal Add detail<END> ---------------------------------->

<!------------------- Modal Edit detail ---------------------------------->
<div class="modal fade" id="scrap_detail_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Scrap Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_scrap_detail_edit" name="id_scrap_detail_edit">                         
                          </div>       
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select" id="id_item_edit" name="id_item_edit">
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select 
                                                                  a.id_item as id_item,
                                                                  a.item_code as item_code,
                                                                  a.item_desc as item_desc,
                                                                  b.unit as unit
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code
                                                                  where a.id_item_category_code = '8'"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Batch</h5></label>
                            <input type="text" class="form-control" id="batch_edit" name="batch_edit">
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
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_scrap_detail_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit detail<END> ---------------------------------->

  <!----------------------- Modal Delete Detail-------------------------------------->
  <div class="modal fade" id="scrap_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Scrap Detail</h4>
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
  <!----------------------- <END>Modal Delete Detail<END>---------------------------->



<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add detail ========================= */
          $(document).ready(function(){
            $('#btn_add_scrap_detail').on('click', function(){
            var id_scrap_header = $('#id_scrap_header').val();
            var id_item = $('#id_item').find(":selected").val();
            var quantity = $('#quantity').val();  
            var batch = $('#batch').val(); 
            
            $.ajax({
              url : "sash/administrator/scrap/scrap_detail_controller.php",
              type : "POST",
              data : {
                id_scrap_header : id_scrap_header, 
                id_item : id_item, 
                quantity : quantity ,
                batch : batch            
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#id_scrap_header').val("");
                $('#id_item').val("");
                $('#quantity').val("");
                $('#modal_add_scrap_detail').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add detail <END> ===================== */

        /* ======================= Menampilkan edit modal detail ======================= */
      $('#example2').on('click','.btn_edit', function(e){
        e.preventDefault();
        let id_scrap_detail_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/scrap/scrap_detail_controller.php",
          type : 'POST',
          data : {id_scrap_detail_edit : id_scrap_detail_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#scrap_detail_edit_modal").modal("show");
            $('#id_scrap_detail_edit').val(response.id_scrap_detail);
            $('#id_item_edit').val(response.id_item).trigger('change');
            $('#quantity_edit').val(response.quantity);
            $('#batch_edit').val(response.batch);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal detail <END> ==================== */

      /* ======================= Mengupdate detail ======================= */
        $('#btn_scrap_detail_update').on('click', function(e){
				e.preventDefault();
				let id_scrap_detail = $('#id_scrap_detail_edit').val();
				let quantity = $('#quantity_edit').val();
				let batch = $('#batch_edit').val();
				let id_item = $('#id_item_edit').find(":selected").val(); 
				$.ajax({
					url : "sash/administrator/scrap/scrap_detail_controller.php",
					type : 'POST',
					data : {id_scrap_detail_update : id_scrap_detail, 
                            quantity_update : quantity,
                            id_item_update : id_item,
                            batch_update : batch
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

			$('#id_scrap_detail_edit').val();
            $('#quantity_edit').val("");
            $('#id_item_edit').val("");
            $('#batch_edit').val("");
            $('#scrap_detail_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate detail <END> ======================= */

     /* =========================== Delete Detail ========================= */
	    $('#example2').on('click','.btn_delete', function(e){
        e.preventDefault();
        let id_scrap_detail = $(this).attr('id');
        $('#scrap_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/scrap/scrap_detail_controller.php",
            type : 'POST',
            data : {id_scrap_detail_delete : id_scrap_detail},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#scrap_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete Detail <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->





<?php

include "inc/koneksi.php";
if (isset($_GET['kode'])) {
  $sql_cek = "SELECT 
            a.id_bom_header as id_bom_header,
            a.bom_no as bom_no,
            a.id_item as id_item,
            c.item_code as item_code,
            c.item_desc as item_desc,
            a.quantity_finish_good as quantity_finish_good,
            a.remark as remark,
            a.status as status,
            d.unit as unit,
            a.createdby as createdby,
            a.createddatetime as createddatetime,
            a.lastupdatedby as lastupdatedby,
            a.lastupdateddatetime as lastupdateddatetime
            FROM itv_masterdata_bom_header as a
            LEFT JOIN itv_masterdata_bom_detail as b ON a.id_bom_header=b.id_bom_header 
            LEFT JOIN itv_masterdata_item as c ON a.id_item=c.id_item
            LEFT JOIN itv_lnsw_masterdata_unitcode as d ON c.id_unit_code=d.id_unit_code
            WHERE 
            a.id_bom_header='" . $_GET['kode'] . "' 
            AND 
            a.isdelete='1'
            AND 
            c.isdelete='1'";

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
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>MASTER DATA/Bill of Material/Bill of Material Detail</b></a></li>
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
              <h3 class="card-title">Data Bill of Material & Bill of Material Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Bill of Material No</label>
                      <input type="text" class="form-control" placeholder="Bill of Material Code" name="bom_no" value=<?php echo $data_cek['bom_no']; ?> disabled>
                    </div>         
                  </div>
                  </br>
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Item Code</label>
                      <input type="text" class="form-control" placeholder="Item Code" name="item_code" value=<?php echo $data_cek['item_code']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Item Description</label>
                        <input type="text" class="form-control" placeholder="Item Description" name="item_desc" value=<?php echo $data_cek['item_desc']; ?> disabled>
                    </div>                                                 
                    <div class="col-md-1">
                      <label>Quantity</label>
                      <input type="number" class="form-control" placeholder="Quantity Finished Good" name="quantity_finish_good" value=<?php echo $data_cek['quantity_finish_good']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                      <label>Unit</label>
                      <input type="text" class="form-control" placeholder="Unit" name="unit" value=<?php echo $data_cek['unit']; ?> disabled>
                    </div>                          
                  </div> 
                  </br>
                  <div class="row">  
                      <div class="col-md-4">  
                        <label>Remark</label>              
                        <textarea class="form-control" rows="1" placeholder="Remark" id="remark_bom_header" name="remark_bom_header" disabled><?php echo $data_cek['remark']; ?></textarea>
                      </div>                     
                    </div>          
                  </div>                 
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card"> 
                        <div class="card-header">
                            <h3 class="card-title">Data Bill of Material Detail</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_bom_detail" disabled><i class="fas fa-plus-square"></i> Add</button>
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
                              <th>Quantity</th>
                              <th>Unit</th>
                              <th>Action</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php              
                              $no = 1;       
                              $sql = $koneksi->query("SELECT
                                                    a.id_bom_detail as id_bom_detail,
                                                    b.item_code as item_code,
                                                    b.item_desc as item_desc,
                                                    c.unit as unit,
                                                    a.quantity_material as quantity_material,
                                                    a.remark as remark
                                                    FROM itv_masterdata_bom_detail as a
                                                    JOIN itv_masterdata_item as b ON a.id_item = b.id_item
                                                    JOIN itv_lnsw_masterdata_unitcode as c ON b.id_unit_code = c.id_unit_code                                                   
                                                    WHERE a.id_bom_header='" . $_GET['kode'] . "' AND a.isdelete='1' ORDER BY a.id_bom_detail ASC");
                              while ($data= $sql->fetch_assoc()) {                              
                              ?>
                            <tr>
                              <td><?php echo $data['id_bom_detail']; ?></td>
                              <td><?php echo 'L-'; ?><?php echo ($no++)*10; ?></td>
                              <td><?php echo $data['item_code']; ?></td>
                              <td><?php echo $data['item_desc']; ?></td> 
                              <td><?php echo $data['quantity_material']; ?></td> 
                              <td><?php echo $data['unit']; ?></td>                               
                              <td>                                
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_bom_detail']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_bom_detail']; ?>" disabled><i class="fas fa-trash-can"></i>
                                    Delete
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
              </div>         
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=bom_view"><i class="fas fa-backward"></i> Back</a>
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


<!------------------- Modal Add BOM detail ---------------------------------->
  
<div class="modal fade" id="modal_add_bom_detail">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Bill of Material Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_bom_header" name="id_bom_header" value=<?php echo $data_cek['id_bom_header']; ?>>                         
                          </div>       
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select id_item" id="id_item" name="id_item">
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select 
                                                                  a.id_item as id_item,
                                                                  a.item_code as item_code,
                                                                  a.item_desc as item_desc,
                                                                  b.unit as unit
                                                                  from itv_masterdata_item as a 
                                                                  JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code
                                                                  where a.id_item_category_code in (1,2,3,4,5,6,8)"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity_material" name="quantity_material">
                          </div>    
                          <div class="form-group"> 
                                <label><h5>Remark</h5></label>                             
                                <textarea class="form-control" rows="2" placeholder="" id="remark" name="remark" required></textarea>                       
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
            <button type="button" class="btn btn-success" id="btn_add_bom_detail">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add BOM detail<END> ---------------------------------->

<!------------------- Modal Edit BOM detail ---------------------------------->
<div class="modal fade" id="bom_detail_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Bill of Material Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_bom_detail_edit" name="id_bom_detail_edit">                         
                          </div>       
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select id_item_edit" id="id_item_edit" name="id_item_edit">
                            <?php 
                              $item_isi = mysqli_query($koneksi, "select 
                                                                  a.id_item as id_item,
                                                                  a.item_code as item_code,
                                                                  a.item_desc as item_desc,
                                                                  b.unit as unit
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code
                                                                  where a.id_item_category_code in (1,2,3,4,5,6,8)"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity_material_edit" name="quantity_material_edit">
                          </div>  
                          <div class="form-group"> 
                                <label><h5>Remark</h5></label>                             
                                <textarea class="form-control" rows="2" placeholder="" id="remark_edit" name="remark_edit" required></textarea>                       
                          </div>                                     
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_bom_detail_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit BOM detail<END> ---------------------------------->

  <!----------------------- Modal Delete BOM Detail-------------------------------------->
  <div class="modal fade" id="bom_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Bill of Material Detail</h4>
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
  <!----------------------- <END>Modal Delete BOM Detail<END>---------------------------->



<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add BOM detail ========================= */
          $(document).ready(function(){

            $('#id_item').select2();

            $('#btn_add_bom_detail').on('click', function(){
            var id_bom_header = $('#id_bom_header').val();
            var id_item = $('#id_item').find(":selected").val();
            var quantity_material = $('#quantity_material').val();  
            var remark = $('#remark').val();     

            $.ajax({
              url : "sash/administrator/bom/bom_detail_controller.php",
              type : "POST",
              data : {
                id_bom_header : id_bom_header, 
                id_item : id_item, 
                quantity_material : quantity_material,
                remark : remark           
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#id_bom_header').val("");
                $('#id_item').val("");
                $('#quantity_material').val("");
                $('#remark').val("");
                $('#modal_add_bom_detail').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add BOM detail <END> ===================== */

        /* ======================= Menampilkan edit modal BOM detail ======================= */
      $('#example2').on('click','.btn_edit', function(e){
        e.preventDefault();
        $('#id_item_edit').select2();
        let id_bom_detail_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/bom/bom_detail_controller.php",
          type : 'POST',
          data : {id_bom_detail_edit : id_bom_detail_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#bom_detail_edit_modal").modal("show");
            $('#id_bom_detail_edit').val(response.id_bom_detail);
            $('#quantity_material_edit').val(response.quantity_material);
            $('#remark_edit').val(response.remark);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal BOM detail <END> ==================== */

      /* ======================= Mengupdate BOM detail ======================= */
        $('#btn_bom_detail_update').on('click', function(e){
				e.preventDefault();
				let id_bom_detail = $('#id_bom_detail_edit').val();
        let id_item = $('#id_item_edit').find(":selected").val();
				let quantity_material = $('#quantity_material_edit').val();
				let remark = $('#remark_edit').val();				 

				$.ajax({
					url : "sash/administrator/bom/bom_detail_controller.php",
					type : 'POST',
					data : {id_bom_detail_update : id_bom_detail, 
                  id_item_update : id_item,
                  quantity_material_update : quantity_material,
                  remark_update : remark
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

			      $('#id_bom_detail_edit').val();
            $('#quantity_material_edit').val("");
            $('#remark_edit').val("");
            $('#bom_detail_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate BOM detail <END> ======================= */

     /* =========================== Delete BOM Detail ========================= */
	    $('#example2').on('click','.btn_delete', function(e){
        e.preventDefault();
        let id_bom_detail = $(this).attr('id');
        $('#bom_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/bom/bom_detail_controller.php",
            type : 'POST',
            data : {id_bom_detail_delete : id_bom_detail},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#bom_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete BOM Detail <END> ===================== */

     

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->





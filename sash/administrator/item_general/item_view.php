<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>MASTER DATA/Item General</b></a></li>
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
                <h3 class="card-title">Data Item General</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_item"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
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
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_item']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_item']; ?>"><i class="fas fa-trash-can"></i>
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
    <!-- /.content -->

<!------------------- Modal Add Item ---------------------------------->
  
<div class="modal fade" id="modal_add_item">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Item General</h4>
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
                            <label><h5>Factory</h5></label>
                            <select class="form-control custom-select" id="id_factory" name="id_factory">
                            <?php 
                              $factoryisi = mysqli_query($koneksi, "select * from itv_masterdata_factory"); 
                              while($row = mysqli_fetch_array($factoryisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_factory]>$row[factory]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>     
                          <div class="form-group">
                            <label><h5>Item Category</h5></label>
                            <select class="form-control custom-select" id="id_item_category_code" name="id_item_category_code">
                            <?php 
                              $catisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_itemcategorycode"); 
                              while($row = mysqli_fetch_array($catisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item_category_code]>$row[item_category_code]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>                       
                          <div class="form-group"> 
                            <label><h5>Item Code</h5></label>                           
                            <input type="text" class="form-control" placeholder="8xxxxxxxxxx" id="item_code" name="item_code" required>                          
                          </div>
                          <div class="form-group"> 
                            <label><h5>Item Description</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="Description of item" id="item_desc" name="item_desc" required></textarea>                       
                          </div>   
                          <div class="form-group">
                            <label><h5>Unit</h5></label>
                            <select class="form-control custom-select" id="id_unit_code" name="id_unit_code">
                            <?php 
                              $unitisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_unitcode order by unit asc"); 
                              while($row = mysqli_fetch_array($unitisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_unit_code]>$row[unit]</option>";
                                  ?>
                            <?php } ?>
                          </select>
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
            <button type="button" class="btn btn-success" id="btn_add_item">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add Item<END> ---------------------------------->   

<!------------------- Modal Edit Item ---------------------------------->
<div class="modal fade" id="item_edit_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Item General</h4>
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
                            <input type="hidden" class="form-control" id="id_item_edit" name="id_item_edit">
                            <label><h5>Factory</h5></label>
                            <select class="form-control custom-select" id="id_factory_edit" name="id_factory_edit">
                            <?php 
                              $factoryisi = mysqli_query($koneksi, "select * from itv_masterdata_factory"); 
                              while($row = mysqli_fetch_array($factoryisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_factory]>$row[factory]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>     
                          <div class="form-group">
                            <label><h5>Item Category</h5></label>
                            <select class="form-control custom-select" id="id_item_category_code_edit" name="id_item_category_code_edit">
                            <?php 
                              $catisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_itemcategorycode"); 
                              while($row = mysqli_fetch_array($catisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item_category_code]>$row[item_category_code]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>                       
                          <div class="form-group"> 
                            <label><h5>Item Code</h5></label>                           
                            <input type="text" class="form-control" placeholder="8xxxxxxxxxx" id="item_code_edit" name="item_code_edit" required>                          
                          </div>
                          <div class="form-group"> 
                            <label><h5>Item Description</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="Description of item" id="item_desc_edit" name="item_desc_edit" required></textarea>                       
                          </div>   
                          <div class="form-group">
                            <label><h5>Unit</h5></label>
                            <select class="form-control custom-select" id="id_unit_code_edit" name="id_unit_code_edit">
                            <?php 
                              $unitisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_unitcode order by unit asc"); 
                              while($row = mysqli_fetch_array($unitisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_unit_code]>$row[unit]</option>";
                                  ?>
                            <?php } ?>
                          </select>
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
                        <button type="button" class="btn btn-success" id="btn_item_update">Update</button>
                      </div>
                    
                    </form>
                </div>
              </div>
            </div>
          </div>
				</div>
			</div>
		</div>
	</div>
  <!------------------- <END>Modal Edit Item<END> ---------------------------------->

  <!----------------------- Modal Delete user-------------------------------------->
  <div class="modal fade" id="item_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Item General</h4>
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
  <!----------------------- <END>Modal Delete user<END>---------------------------->
  
<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add Item ========================= */
          $(document).ready(function(){
            $('#btn_add_item').on('click', function(){
            var id_item_category_code = $('#id_item_category_code').find(":selected").val();    
            var id_factory = $('#id_factory').find(":selected").val();    
            var item_code = $('#item_code').val();
            var item_desc = $('#item_desc').val();
            var id_unit_code = $('#id_unit_code').find(":selected").val(); 
               
            $.ajax({
              url : "sash/administrator/item_general/item_controller.php",
              type : "POST",
              data : {
                id_item_category_code : id_item_category_code, 
                id_factory : id_factory, 
                item_code : item_code,
                item_desc : item_desc,
                id_unit_code : id_unit_code              
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#id_item_category_code').val("");
                $('#id_factory').val("");
                $('#item_code').val("");
                $('#item_desc').val("");
                $('#id_unit_code').val("");
                $('#modal_add_item').modal("hide");
                setInterval('location.reload()',1500);
              }
            });
          });
        });
        /* ======================== <END> Add Item <END> ===================== */

        /* ======================= Menampilkan edit modal item ======================= */
      $('#example1').on('click','.btn_edit', function(){
        let id_item_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/item_general/item_controller.php",
          type : 'POST',
          data : {id_item_edit : id_item_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#item_edit_modal").modal("show");
            $('#id_item_edit').val(response.id_item);
            $('#item_code_edit').val(response.item_code);
            $('#item_desc_edit').val(response.item_desc);
            $('#id_item_category_code_edit').val(response.id_item_category_code).trigger('change');
            $('#id_factory_edit').val(response.id_factory).trigger('change');
            $('#id_unit_code_edit').val(response.id_unit_code).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal item <END> ==================== */

      /* ======================= Mengupdate Item ======================= */
        $('#btn_item_update').on('click', function(e){
				e.preventDefault();
				let id_item = $('#id_item_edit').val();
				let item_code = $('#item_code_edit').val();
				let item_desc = $('#item_desc_edit').val();
				let id_item_category_code = $('#id_item_category_code_edit').find(":selected").val();  
        let id_factory = $('#id_factory_edit').find(":selected").val();  
        let id_unit_code = $('#id_unit_code_edit').find(":selected").val();  

				$.ajax({
					url : "sash/administrator/item_general/item_controller.php",
					type : 'POST',
					data : {id_item_update : id_item, 
                  item_code_update : item_code,
									item_desc_update : item_desc,
									id_item_category_code_update : id_item_category_code,
                  id_factory_update : id_factory,
                  id_unit_code_update : id_unit_code
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_item_category_code').val("");
            $('#id_factory').val("");
            $('#item_code').val("");
            $('#item_desc').val("");
            $('#id_unit_code').val("");
            $('#item_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate Item <END> ======================= */

      /* =========================== Delete Item ========================= */
			 $('#example1').on('click','.btn_delete', function(){
        let id_item = $(this).attr('id');
        $('#item_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/item_general/item_controller.php",
            type : 'POST',
            data : {id_item_delete : id_item},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#item_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete Item <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->

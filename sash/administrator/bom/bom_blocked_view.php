<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>MASTER DATA/Bill of Material</b></a></li>
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
                <h3 class="card-title">Data Bill of Material</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_bom"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Bill of Material No</th>
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT 
                                                A.id_bom_header as id_bom_header,
                                                A.bom_no as bom_no,
                                                B.item_code as item_code,
                                                B.item_desc as item_desc,
                                                A.status as status,
                                                A.isdelete as isdelete
                                                FROM itv_masterdata_bom_header as A
                                                LEFT JOIN itv_masterdata_item as B ON A.id_item=B.id_item
                                                WHERE A.isdelete = '1' 
                                                order by id_bom_header asc");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $data['bom_no']; ?></td>
                    <td><?php echo $data['item_code']; ?></td>
                    <td><?php echo $data['item_desc']; ?></td> 
                    <td>
                        <?php $status = $data['status']; ?>
                        <?php if($status == "60"){?>
                        <span class="badge bg-success">Active</span>
                        <?php }elseif($status == "80"){ ?>  
                        <span class="badge bg-warning">Non-active</span> 
                        <?php }elseif($status == "10"){ ?>  
                        <span class="badge bg-primary">Created</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>  
                    <td>
                        <?php $status = $data['status'];?>
                        <?php if($status == "10"){?>
                        <a class="btn btn-default btn-sm" href="?page=bom_detail_blocked_view2&kode=<?php echo $data['id_bom_header']; ?>"><i class="fas fa-sitemap"></i>
                            Material
                        </a>
                        <button class="btn btn-success btn-sm btn_activate" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-check"></i>
                            Activate
                        </button>                       
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "60"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=bom_detail_blocked_view2&kode=<?php echo $data['id_bom_header']; ?>"><i class="fas fa-sitemap"></i>
                            Material
                        </a>
                        <button class="btn btn-secondary btn-sm btn_deactivate" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-ban"></i>
                            Deactivate
                        </button>                       
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "80"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=bom_detail_blocked_view2&kode=<?php echo $data['id_bom_header']; ?>"><i class="fas fa-sitemap"></i>
                            Material
                        </a>
                        <button class="btn btn-success btn-sm btn_activate" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-check"></i>
                            Activate
                        </button>                       
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_bom_header']; ?>" disabled><i class="fas fa-trash-can"></i>
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

    <!------------------- Modal Add BOM ---------------------------------->
  
<div class="modal fade" id="modal_add_bom">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Bill of Material</h4>
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
                                <label><h5>Bill of Material No</h5></label>                           
                                <input type="text" class="form-control" placeholder="Bill of Material Code Generate By System" id="bom_no" name="bom_no" disabled>                         
                            </div>                   
                            <div class="form-group">
                                <label><h5>Item</h5></label>
                                <select class="form-control custom-select id_item" id="id_item" name="id_item">
                                <?php 
                                $id_item_isi = mysqli_query($koneksi, "select a.id_item as id_item, a.item_code as item_code, a.item_desc, b.unit
                                                                        from itv_masterdata_item as a left join itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code
                                                                        where a.id_item_category_code in (6,7) and a.isdelete=1"); 
                                while($row = mysqli_fetch_array($id_item_isi)){?>
                                    <?php                                  
                                        echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                    ?>
                                <?php } ?>
                                </select>                    
                            </div>  
                            <div class="form-group"> 
                                <label><h5>Quantity</h5></label>                             
                                <input type="number" class="form-control" placeholder="" id="quantity_finish_good" name="quantity_finish_good" required>                       
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
            <button type="button" class="btn btn-success" id="btn_add_bom_h">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add BOM<END> ---------------------------------->   

<!------------------- Modal Edit BOM ---------------------------------->
<div class="modal fade" id="bom_header_edit_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Bill of Material</h4>
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
                                <label><h5>Bill of Material No</h5></label>   
                                <input type="hidden" class="form-control" id="id_bom_header_edit" name="id_bom_header_edit">                
                                <input type="text" class="form-control" placeholder="Bill of Material Code" id="bom_no_edit" name="bom_no_edit" disabled> 
                            </div>
                            <div class="form-group">
                                    <label><h5>Item</h5></label>
                                    <select class="form-control custom-select id_item" id="id_item_edit" name="id_item_edit">
                                    <?php 
                                    $id_item_isi = mysqli_query($koneksi, "select a.id_item as id_item, a.item_code as item_code, a.item_desc, b.unit
                                                                            from itv_masterdata_item as a left join itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code
                                                                            where a.id_item_category_code in (6,7) and a.isdelete=1"); 
                                    while($row = mysqli_fetch_array($id_item_isi)){?>
                                        <?php                                  
                                            echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                        ?>
                                    <?php } ?>
                                    </select>                    
                                </div>  
                                <div class="form-group"> 
                                    <label><h5>Quantity</h5></label>                             
                                    <input type="number" class="form-control" placeholder="" id="quantity_finish_good_edit" name="quantity_finish_good_edit" required>                       
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
        </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btn_bp_update">Update</button>
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
  <!------------------- <END>Modal Edit BOM<END> ---------------------------------->

  <!----------------------- Modal Activate BOM-------------------------------------->
  <div class="modal fade" id="bom_activate_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Activate Bill of Material</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to activate?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-success" id="btn_confirm_activate">Activate</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Activate BOM<END>---------------------------->

  <!----------------------- Modal Deactivate BOM-------------------------------------->
  <div class="modal fade" id="bom_deactivate_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Deactivate Bill of Material</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to deactivate?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btn_confirm_deactivate">Deactivate</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Deactivate BOM<END>---------------------------->

  <!----------------------- Modal Delete BOM-------------------------------------->
       <div class="modal fade" id="bom_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Bill of Material</h4>
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
  <!----------------------- <END>Modal Delete BOM<END>---------------------------->

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add BOM ========================= */
          $(document).ready(function(){
            $('#id_item').select2();
            $('#btn_add_bom_h').on('click', function(){
            var id_item = $('#id_item').find(":selected").val(); 
            var quantity_finish_good = $('#quantity_finish_good').val();   
            var remark = $('#remark').val();      

            $.ajax({
              url : "sash/administrator/bom/bom_controller.php",
              type : "POST",
              data : {
                id_item : id_item, 
                quantity_finish_good : quantity_finish_good, 
                remark : remark              
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#quantity_finish_good').val("");
                $('#remark').val("");
                $('#modal_add_bomo').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add BOM <END> ===================== */

        /* ======================= Menampilkan edit modal BOM ======================= */
      $('#example1').on('click','.btn_edit', function(){
        $('#id_item_edit').select2();
        let id_bom_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/bom/bom_controller.php",
          type : 'POST',
          data : {id_bom_header_edit : id_bom_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#bom_header_edit_modal").modal("show");
            $('#bom_no_edit').val(response.bom_no);
            $('#id_bom_header_edit').val(response.id_bom_header);
            $('#id_item_edit').val(response.id_item).trigger('change');
            $('#quantity_finish_good_edit').val(response.quantity_finish_good);
            $('#remark_edit').val(response.remark);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal BOM <END> ==================== */

      /* ======================= Mengupdate BOM ======================= */
            $('#btn_bp_update').on('click', function(e){
				e.preventDefault();
				let id_bom_header = $('#id_bom_header_edit').val();				
				let id_item = $('#id_item_edit').val();
                let quantity_finish_good = $('#quantity_finish_good_edit').val();
                let remark = $('#remark_edit').val(); 

				$.ajax({
					url : "sash/administrator/bom/bom_controller.php",
					type : 'POST',
					data : {id_bom_header_update : id_bom_header, 
                                    id_item_update : id_item,
									quantity_finish_good_update : quantity_finish_good,
									remark_update : remark
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

			$('#id_bom_header_edit').val();
            $('#quantity_finish_good_edit').val("");
            $('#remark_edit').val("");
            $('#bom_header_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate BOM <END> ======================= */

     /* =========================== Activate BOM ========================= */
     $('#example1').on('click','.btn_activate', function(){
        let id_bom_header = $(this).attr('id');
        $('#bom_activate_modal').modal('show');
        $('#btn_confirm_activate').on('click', function(){
          $.ajax({
            url : "sash/administrator/bom/bom_controller.php",
            type : 'POST',
            data : {id_bom_header_activate : id_bom_header},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been activated",'','success');
              } else {
                Swal.fire("Data failed to activated",'','error');
              }
              $('#bom_activate_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Activate BOM <END> ===================== */

     /* =========================== Deactivate BOM ========================= */
     $('#example1').on('click','.btn_deactivate', function(){
        let id_bom_header = $(this).attr('id');
        $('#bom_deactivate_modal').modal('show');
        $('#btn_confirm_deactivate').on('click', function(){
          $.ajax({
            url : "sash/administrator/bom/bom_controller.php",
            type : 'POST',
            data : {id_bom_header_deactivate : id_bom_header},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deactivated",'','success');
              } else {
                Swal.fire("Data failed to deactivated",'','error');
              }
              $('#bom_deactivate_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Deactivate BOM <END> ===================== */

     /* =========================== Delete BOM ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_bom_header = $(this).attr('id');
        $('#bom_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/bom/bom_controller.php",
            type : 'POST',
            data : {id_bom_header_delete : id_bom_header},
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
      /* ======================== <END> Delete BOM <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


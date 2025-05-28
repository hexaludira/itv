<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>STOCK OPNAME/Stock Opname</b></a></li>
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
                <h3 class="card-title">Data Stock Opname</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_stockop"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Stock Opname No</th>
                    <th>Stock Opname Internal No</th>
                    <th>Stock Opname Date</th>
                    <th>Created By</th>
                    <th>Created Date Time</th>
                    <th>Last Updated By</th>
                    <th>Last Updated Time</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql2 = $koneksi->query("SELECT 
                                                a.id_stockop_header as id_stockop_header,
                                                a.stockop_no as stockop_no,
                                                a.stockop_internal_no as stockop_internal_no,
                                                a.stockop_date as stockop_date,
                                                a.remark as remark,
                                                a.createdby as createdby,
                                                a.createddatetime as createddatetime,
                                                a.lastupdatedby as lastupdatedby,
                                                a.lastupdateddatetime as lastupdateddatetime,
                                                a.status as status
                                                FROM itv_stockop_header as a
                                                WHERE a.isdelete = '1' 
                                                ORDER BY a.id_stockop_header ASC");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['stockop_no']; ?></td>
                    <td><?php echo $data['stockop_internal_no']; ?></td>
                    <td><?php echo $data['stockop_date']; ?></td>
                    <td><?php echo $data['createdby']; ?></td>
                    <td><?php echo $data['createddatetime']; ?></td>
                    <td><?php echo $data['lastupdatedby']; ?></td>
                    <td><?php echo $data['lastupdateddatetime']; ?></td>
                    <td>
                        <?php $status = $data['status']; ?>
                        <?php if($status == "10"){?>
                        <span class="badge bg-secondary">Created</span>
                        <?php }elseif($status == "20"){ ?>  
                        <span class="badge bg-warning">Planned</span> 
                        <?php }elseif($status == "70"){ ?>  
                        <span class="badge bg-success">Completed</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>  
                    <td>
                        <?php $status = $data['status'];?>
                        <?php if($status == "10"){?>
                        <a class="btn btn-default btn-sm" href="?page=stockop_detail_view&kode=<?php echo $data['id_stockop_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_stockop_header']; ?>"><i class="fas fa-bullhorn"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_stockop_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_stockop_header']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "70"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=stockop_detail_view&kode=<?php echo $data['id_stockop_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_stockop_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_stockop_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_stockop_header']; ?>" disabled><i class="fas fa-trash-can"></i>
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

    <!------------------- modal add  ---------------------------------->
  
<div class="modal fade" id="modal_add_stockop">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Stock Opname</h4>
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
                            <label><h5>Stock Opname No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Stock Opname Code Generate By System" id="stockop_no" name="stockop_no" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Stock Opname Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Stock Opname Internal Code" id="stockop_internal_no" name="stockop_internal_no" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Stock Opname Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Stock Opname Date" id="stockop_date" name="stockop_date" required>                         
                          </div>                      
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information for this stock opname..." id="remark" name="remark" required></textarea>                          
                          </div>              
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_stockop">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>

<!------------------- <END>modal add<END> ---------------------------------->   

<!------------------- Modal Edit  ---------------------------------->
<div class="modal fade" id="stockop_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Stock Opname</h4>
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
                            <label><h5>Stock Opname No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_stockop_header_edit" name="id_stockop_header_edit">                        
                            <input type="text" class="form-control" placeholder="Stock Opname Code" id="stockop_no_edit" name="stockop_no_edit" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Stock Opname Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Stock Opname Internal Code" id="stockop_internal_no_edit" name="stockop_internal_no_edit" required>                         
                          </div>   
                          <div class="form-group"> 
                            <label><h5>Stock Opname Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Stock Opname Date" id="stockop_date_edit" name="stockop_date_edit" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information for this stock opname..." id="remark_edit" name="remark_edit" required></textarea>                          
                          </div>                        
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_stockop_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit<END> ---------------------------------->

  <!----------------------- Modal Delete-------------------------------------->
  <div class="modal fade" id="stockop_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Stock Opname</h4>
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
  <!----------------------- <END>Modal Delete<END>---------------------------->

  <!----------------------- Modal Complete -------------------------------------->
  <div class="modal fade" id="complete_stockop_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Complete Stock Opname</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to complete this stock opname?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_complete">Complete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Complete<END>---------------------------->

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add stockop ========================= */
          $(document).ready(function(){
            // e.preventDefault();
            $('#btn_add_stockop').on('click', function(){
            var stockop_no = $('#stockop_no').val();
            var stockop_internal_no = $('#stockop_internal_no').val();
            var stockop_date = $('#stockop_date').val();  
            var remark = $('#remark').val();

            $.ajax({
              url : "sash/administrator/stockop/stockop_controller.php",
              type : "POST",
              data : {
                stockop_no : stockop_no, 
                stockop_internal_no : stockop_internal_no, 
                stockop_date : stockop_date,
                remark : remark             
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#stockop_no').val("");
                $('#stockop_internal_no').val("");
                $('#stockop_date').val("");
                $('#remark').val("");
                $('#modal_add_stockop').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add stockop <END> ===================== */

        /* ======================= Menampilkan edit modal ======================= */
      $('#example1').on('click','.btn_edit', function(){
        //e.preventDefault();
        let id_stockop_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/stockop/stockop_controller.php",
          type : 'POST',
          data : {id_stockop_header_edit : id_stockop_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#stockop_edit_modal").modal("show");
            $('#id_stockop_header_edit').val(response.id_stockop_header);
            $('#stockop_no_edit').val(response.stockop_no);
            $('#stockop_internal_no_edit').val(response.stockop_internal_no);
            $('#stockop_date_edit').val(response.stockop_date);
            $('#remark_edit').val(response.remark);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal <END> ==================== */

      /* ======================= Mengupdate ======================= */
        $('#btn_stockop_update').on('click', function(e){
        e.preventDefault();
        let id_stockop_header = $('#id_stockop_header_edit').val();
        let stockop_no = $('#stockop_no_edit').val();
        let stockop_internal_no = $('#stockop_internal_no_edit').val();
        let remark = $('#remark_edit').val();
        let stockop_date = $('#stockop_date_edit').val();  

				$.ajax({
					url : "sash/administrator/stockop/stockop_controller.php",
					type : 'POST',
					data : {id_stockop_header_update : id_stockop_header, 
                  stockop_no_update : stockop_no,
							    stockop_internal_no_update : stockop_internal_no,
                  stockop_date_update : stockop_date,
							    remark_update : remark
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_stockop_header_edit').val("");
            $('#stockop_no_edit').val("");
            $('#stockop_internal_no_edit').val("");
            $('#remark_edit').val("");
            $('#stockop_date_edit').val("");
            $('#stockop_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate <END> ======================= */

     /* =========================== Delete ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_stockop_header_delete = $(this).attr('id');
        $('#stockop_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/stockop/stockop_controller.php",
            type : 'POST',
            data : {id_stockop_header_delete : id_stockop_header_delete},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#stockop_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete <END> ===================== */

      /* =========================== Complete stock opname ========================= */
	    $('#example1').on('click','.btn_complete', function(){
        let id_stockop_header_complete = $(this).attr('id');
        $('#complete_stockop_modal').modal('show');
        $('#btn_confirm_complete').on('click', function(){
          $.ajax({
            url : "sash/administrator/stockop/stockop_controller.php",
            type : 'POST',
            data : {id_stockop_header_complete : id_stockop_header_complete},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been completed",'','success');
              } else {
                Swal.fire("Data failed to completed",'','error');
              }
              $('#complete_stockop_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Complete stock opname <END> ===================== */
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


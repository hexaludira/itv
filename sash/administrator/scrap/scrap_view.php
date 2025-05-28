<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>SCRAP/Scrap</b></a></li>
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
                <h3 class="card-title">Data Scrap</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_scrap"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Scrap No</th>
                    <th>Scrap Internal No</th>
                    <th>Scrap Date</th>
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
                                                WHERE a.isdelete = '1' 
                                                ORDER BY a.id_scrap_header ASC");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['scrap_no']; ?></td>
                    <td><?php echo $data['scrap_internal_no']; ?></td>
                    <td><?php echo $data['scrap_date']; ?></td>
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
                        <a class="btn btn-default btn-sm" href="?page=scrap_detail_view&kode=<?php echo $data['id_scrap_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_scrap_header']; ?>"><i class="fas fa-bullhorn"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_scrap_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_scrap_header']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "70"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=scrap_detail_view&kode=<?php echo $data['id_scrap_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_scrap_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_scrap_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_scrap_header']; ?>" disabled><i class="fas fa-trash-can"></i>
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
  
<div class="modal fade" id="modal_add_scrap">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Scrap</h4>
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
                            <label><h5>Scrap No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Scrap Code Generate By System" id="scrap_no" name="scrap_no" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Scrap Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Scrap Internal Code" id="scrap_internal_no" name="scrap_internal_no" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Scrap Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Scrap Date" id="scrap_date" name="scrap_date" required>                         
                          </div>                      
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information for this scrap..." id="remark" name="remark" required></textarea>                          
                          </div>              
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_scrap">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>

<!------------------- <END>modal add<END> ---------------------------------->   

<!------------------- Modal edit ---------------------------------->
<div class="modal fade" id="scrap_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Scrap</h4>
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
                            <label><h5>Scrap No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_scrap_header_edit" name="id_scrap_header_edit">                        
                            <input type="text" class="form-control" placeholder="Scrap Code" id="scrap_no_edit" name="scrap_no_edit" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Scrap Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Scrap Internal Code" id="scrap_internal_no_edit" name="scrap_internal_no_edit" required>                         
                          </div>   
                          <div class="form-group"> 
                            <label><h5>Scrap Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Scrap Date" id="scrap_date_edit" name="scrap_date_edit" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information this scrap..." id="remark_edit" name="remark_edit" required></textarea>                          
                          </div>                        
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_scrap_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal edit<END> ---------------------------------->

  <!----------------------- Modal Delete-------------------------------------->
  <div class="modal fade" id="scrap_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Scrap</h4>
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

  <!----------------------- Modal Complete-------------------------------------->
  <div class="modal fade" id="complete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Complete Scrap</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to complete this scrap?</h4>
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

          /* ======================= Add ========================= */
          $(document).ready(function(){
            // e.preventDefault();
            $('#btn_add_scrap').on('click', function(){
            var scrap_no = $('#scrap_no').val();
            var scrap_internal_no = $('#scrap_internal_no').val();
            var scrap_date = $('#scrap_date').val();  
            var remark = $('#remark').val();

            $.ajax({
              url : "sash/administrator/scrap/scrap_controller.php",
              type : "POST",
              data : {
                scrap_no : scrap_no, 
                scrap_internal_no : scrap_internal_no, 
                scrap_date : scrap_date,
                remark : remark             
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#scrap_no').val("");
                $('#scrap_internal_no').val("");
                $('#scrap_date').val("");
                $('#remark').val("");
                $('#modal_add_scrap').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add <END> ===================== */

        /* ======================= Menampilkan edit modal ======================= */
      $('#example1').on('click','.btn_edit', function(){
        //e.preventDefault();
        let id_scrap_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/scrap/scrap_controller.php",
          type : 'POST',
          data : {id_scrap_header_edit : id_scrap_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#scrap_edit_modal").modal("show");
            $('#id_scrap_header_edit').val(response.id_scrap_header);
            $('#scrap_no_edit').val(response.scrap_no);
            $('#scrap_internal_no_edit').val(response.scrap_internal_no);
            $('#scrap_date_edit').val(response.scrap_date);
            $('#remark_edit').val(response.remark);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal <END> ==================== */

      /* ======================= Mengupdate ======================= */
        $('#btn_scrap_update').on('click', function(e){
        e.preventDefault();
        let id_scrap_header = $('#id_scrap_header_edit').val();
        let scrap_no = $('#scrap_no_edit').val();
        let scrap_internal_no = $('#scrap_internal_no_edit').val();
        let remark = $('#remark_edit').val();
        let scrap_date = $('#scrap_date_edit').val();  

				$.ajax({
					url : "sash/administrator/scrap/scrap_controller.php",
					type : 'POST',
					data : {id_scrap_header_update : id_scrap_header, 
                            scrap_no_update : scrap_no,
							scrap_internal_no_update : scrap_internal_no,
                            scrap_date_update : scrap_date,
							remark_update : remark
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_scrap_header_edit').val("");
            $('#scrap_no_edit').val("");
            $('#scrap_internal_no_edit').val("");
            $('#remark_edit').val("");
            $('#scrap_date_edit').val("");
            $('#scrap_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate <END> ======================= */

     /* =========================== Delete ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_scrap_header_delete = $(this).attr('id');
        $('#scrap_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/scrap/scrap_controller.php",
            type : 'POST',
            data : {id_scrap_header_delete : id_scrap_header_delete},
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
      /* ======================== <END> Delete <END> ===================== */

      /* =========================== Complete ========================= */
	    $('#example1').on('click','.btn_complete', function(){
        let id_scrap_header_complete = $(this).attr('id');
        $('#complete_modal').modal('show');
        $('#btn_confirm_complete').on('click', function(){
          $.ajax({
            url : "sash/administrator/scrap/scrap_controller.php",
            type : 'POST',
            data : {id_scrap_header_complete : id_scrap_header_complete},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been completed",'','success');
              } else {
                Swal.fire("Data failed to completed",'','error');
              }
              $('#complete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Complete <END> ===================== */
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


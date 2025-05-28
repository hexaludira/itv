<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>ADJUSTMENT/Adjustment Order</b></a></li>
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
                <h3 class="card-title">Data Adjustment Order</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_adj"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Adjustment Order No</th>
                    <th>Adjustment Order Internal No</th>
                    <th>Adjustment Date</th>
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
                                                a.id_adj_header as id_adj_header,
                                                a.adj_order_no as adj_order_no,
                                                a.adj_order_internal_no as adj_order_internal_no,
                                                a.adj_date as adj_date,
                                                a.remark as remark,
                                                a.createdby as createdby,
                                                a.createddatetime as createddatetime,
                                                a.lastupdatedby as lastupdatedby,
                                                a.lastupdateddatetime as lastupdateddatetime,
                                                a.status as status
                                                FROM itv_adj_header as a
                                                WHERE a.isdelete = '1' 
                                                ORDER BY a.id_adj_header ASC");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['adj_order_no']; ?></td>
                    <td><?php echo $data['adj_order_internal_no']; ?></td>
                    <td><?php echo $data['adj_date']; ?></td>
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
                        <a class="btn btn-default btn-sm" href="?page=adjustment_detail_view&kode=<?php echo $data['id_adj_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_adj_header']; ?>"><i class="fas fa-bullhorn"></i>
                            Adjust
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_adj_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_adj_header']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "70"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=adjustment_detail_view&kode=<?php echo $data['id_adj_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_adj_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Adjust
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_adj_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_adj_header']; ?>" disabled><i class="fas fa-trash-can"></i>
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

    <!------------------- modal add adj header ---------------------------------->
  
<div class="modal fade" id="modal_add_adj">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Adjustment Order</h4>
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
                            <label><h5>Adjustment Order No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Adjustment Order Code Generate By System" id="adj_order_no" name="adj_order_no" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Adjustment Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Adjustment Order Internal Code" id="adj_order_internal_no" name="adj_order_internal_no" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Adjustment Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Adjustment Date" id="adj_date" name="adj_date" required>                         
                          </div>                      
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information why need to make adjustment order..." id="remark" name="remark" required></textarea>                          
                          </div>              
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_adj">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>

<!------------------- <END>modal add po header<END> ---------------------------------->   

<!------------------- Modal Edit PO ---------------------------------->
<div class="modal fade" id="adj_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Adjustment Order</h4>
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
                            <label><h5>Adjustment Order No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_adj_header_edit" name="id_adj_header_edit">                        
                            <input type="text" class="form-control" placeholder="Adjustment Order Code" id="adj_order_no_edit" name="adj_order_no_edit" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Adjustment Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Adjustment Order Internal Code" id="adj_order_internal_no_edit" name="adj_order_internal_no_edit" required>                         
                          </div>   
                          <div class="form-group"> 
                            <label><h5>Adjustment Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Adjustment Date" id="adj_date_edit" name="adj_date_edit" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information why need to make adjustment order..." id="remark_edit" name="remark_edit" required></textarea>                          
                          </div>                        
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_adj_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit PO<END> ---------------------------------->

  <!----------------------- Modal Delete adj-------------------------------------->
  <div class="modal fade" id="adj_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Adjustment Order</h4>
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
  <!----------------------- <END>Modal Delete adj<END>---------------------------->

  <!----------------------- Modal Plan PO-------------------------------------->
  <div class="modal fade" id="adj_plan_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Adjust Adjustment Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to adjust this adjustment?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_plan">Adjust</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Plan PO<END>---------------------------->

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add adj ========================= */
          $(document).ready(function(){
            // e.preventDefault();
            $('#btn_add_adj').on('click', function(){
            var adj_order_no = $('#adj_order_no').val();
            var adj_order_internal_no = $('#adj_order_internal_no').val();
            var adj_date = $('#adj_date').val();  
            var remark = $('#remark').val();

            $.ajax({
              url : "sash/administrator/adjustment/adj_controller.php",
              type : "POST",
              data : {
                adj_order_no : adj_order_no, 
                adj_order_internal_no : adj_order_internal_no, 
                adj_date : adj_date,
                remark : remark             
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#adj_order_no').val("");
                $('#adj_order_internal_no').val("");
                $('#adj_date').val("");
                $('#remark').val("");
                $('#modal_add_adj').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add adj <END> ===================== */

        /* ======================= Menampilkan edit modal adj ======================= */
      $('#example1').on('click','.btn_edit', function(){
        //e.preventDefault();
        let id_adj_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/adjustment/adj_controller.php",
          type : 'POST',
          data : {id_adj_header_edit : id_adj_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#adj_edit_modal").modal("show");
            $('#id_adj_header_edit').val(response.id_adj_header);
            $('#adj_order_no_edit').val(response.adj_order_no);
            $('#adj_order_internal_no_edit').val(response.adj_order_internal_no);
            $('#adj_date_edit').val(response.adj_date);
            $('#remark_edit').val(response.remark);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal adj <END> ==================== */

      /* ======================= Mengupdate adj ======================= */
        $('#btn_adj_update').on('click', function(e){
        e.preventDefault();
        let id_adj_header = $('#id_adj_header_edit').val();
        let adj_order_no = $('#adj_order_no_edit').val();
        let adj_order_internal_no = $('#adj_order_internal_no_edit').val();
        let remark = $('#remark_edit').val();
        let adj_date = $('#adj_date_edit').val();  

				$.ajax({
					url : "sash/administrator/adjustment/adj_controller.php",
					type : 'POST',
					data : {id_adj_header_update : id_adj_header, 
                            adj_order_no_update : adj_order_no,
							adj_order_internal_no_update : adj_order_internal_no,
                            adj_date_update : adj_date,
							remark_update : remark
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_adj_header_edit').val("");
            $('#adj_order_no_edit').val("");
            $('#adj_order_internal_no_edit').val("");
            $('#remark_edit').val("");
            $('#adj_date_edit').val("");
            $('#adj_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate adj <END> ======================= */

     /* =========================== Delete adj ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_adj_header_delete = $(this).attr('id');
        $('#adj_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/adjustment/adj_controller.php",
            type : 'POST',
            data : {id_adj_header_delete : id_adj_header_delete},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#adj_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete adj <END> ===================== */

      /* =========================== Adjust adj ========================= */
	    $('#example1').on('click','.btn_plan', function(){
        let id_adj_header_plan = $(this).attr('id');
        $('#adj_plan_modal').modal('show');
        $('#btn_confirm_plan').on('click', function(){
          $.ajax({
            url : "sash/administrator/adjustment/adj_controller.php",
            type : 'POST',
            data : {id_adj_header_plan : id_adj_header_plan},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been adjust",'','success');
              } else {
                Swal.fire("Data failed to adjust",'','error');
              }
              $('#adj_plan_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Adjust adj <END> ===================== */
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


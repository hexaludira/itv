<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>SALES/Sales Order</b></a></li>
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
                <h3 class="card-title">Data Sales Order</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_so"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Sales Order No</th>
                    <th>Sales Order Internal No</th>
                    <th>Sales Type</th>
                    <th>Sales Date</th>
                    <th>Business Partner</th>
                    <th>Created By</th>
                    <th>Created Date Time</th>
                    <th>Last Updated By</th>
                    <th>Last Updated Time</th>
                    <th>Status</th>
                    <th>Status Link</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql2 = $koneksi->query("SELECT 
                                                a.id_so_header as id_so_header,
                                                a.sales_order_no as sales_order_no,
                                                a.sales_order_internal_no as sales_order_internal_no,
                                                c.sales_type as sales_type,
                                                a.sales_date as sales_date,
                                                a.createdby as createdby,
                                                a.createddatetime as createddatetime,
                                                a.lastupdatedby as lastupdatedby,
                                                a.lastupdateddatetime as lastupdateddatetime,
                                                a.status as status,
                                                a.total_link as total_link,
                                                b.bp_code as bp_code,
                                                b.bp_name as bp_name
                                                FROM itv_so_header as a
                                                LEFT JOIN itv_masterdata_bp as b ON a.id_bp = b.id_bp 
                                                LEFT JOIN itv_masterdata_salestype as c ON a.id_sales_type = c.id_sales_type
                                                WHERE a.isdelete = '1' 
                                                ORDER BY a.id_so_header ASC");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['sales_order_no']; ?></td>
                    <td><?php echo $data['sales_order_internal_no']; ?></td>
                    <td><?php echo $data['sales_type']; ?></td>
                    <td><?php echo $data['sales_date']; ?></td>
                    <td><?php echo $data['bp_code']; ?> <?php echo $data['bp_name']; ?></td>
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
                        <?php }elseif($status == "50"){ ?>  
                        <span class="badge bg-success">Delivered</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>  
                    <td>
                        <?php $total_link = $data['total_link']; ?>
                        <?php if($total_link == "0"){?>
                        <span class="badge bg-secondary">Unlinked</span>
                        <?php }elseif($total_link > "0"){ ?>  
                        <span class="badge bg-success">Linked to KEK Document SO</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td> 
                    <td>
                        <?php $status = $data['status']; $total_link = $data['total_link'];?>
                        <?php if($status == "10" && $total_link == "0"){?>
                        <a class="btn btn-default btn-sm" href="?page=so_detail_view&kode=<?php echo $data['id_so_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_so_header']; ?>"><i class="fas fa-bullhorn"></i>
                            Plan
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_header']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "10" && $total_link > "0"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=so_detail_blocked_view&kode=<?php echo $data['id_so_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_so_header']; ?>"><i class="fas fa-bullhorn"></i>
                            Plan
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "20" && $total_link == "0"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=so_detail_blocked_view&kode=<?php echo $data['id_so_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Plan
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "20" && $total_link > "0"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=so_detail_blocked_view&kode=<?php echo $data['id_so_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Plan
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "50" && $total_link == "0"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=so_detail_blocked_view&kode=<?php echo $data['id_so_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Plan
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "50" && $total_link > "0"){ ?>
                        <a class="btn btn-default btn-sm" href="?page=so_detail_blocked_view&kode=<?php echo $data['id_so_header']; ?>"><i class="fas fa-search"></i>
                            Detail
                        </a>
                        <button class="btn btn-default btn-sm btn_plan" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Plan
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_header']; ?>" disabled><i class="fas fa-trash-can"></i>
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

    <!------------------- modal add so header ---------------------------------->
  
<div class="modal fade" id="modal_add_so">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Sales Order</h4>
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
                            <label><h5>Sales Order No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Sales Order Code Generate By System" id="sales_order_no" name="sales_order_no" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Sales Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Sales Order Internal Code" id="sales_order_internal_no" name="sales_order_internal_no" required>                         
                          </div>
                          <div class="form-group">
                            <label><h5>Sales Type</h5></label>
                            <select class="form-control custom-select" id="id_sales_type" name="id_sales_type">
                            <?php 
                              $id_st_isi = mysqli_query($koneksi, "select * from itv_masterdata_salestype"); 
                              while($row = mysqli_fetch_array($id_st_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_sales_type]>$row[sales_type]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group"> 
                            <label><h5>Sales Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Sales Date" id="sales_date" name="sales_date" required>                         
                          </div>
                          <div class="form-group">
                            <label><h5>Business Partner</h5></label>
                            <select class="form-control custom-select" id="id_bp" name="id_bp">
                            <?php 
                              $id_bp_isi = mysqli_query($koneksi, "select * from itv_masterdata_bp where bp_type=10 and isdelete=1"); 
                              while($row = mysqli_fetch_array($id_bp_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_bp]>$row[bp_code] $row[bp_name]</option>";
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
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_so">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>

<!------------------- <END>modal add so header<END> ---------------------------------->   

<!------------------- Modal Edit SO ---------------------------------->
<div class="modal fade" id="so_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Sales Order</h4>
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
                            <label><h5>Sales Order No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_so_header_edit" name="id_so_header_edit">                        
                            <input type="text" class="form-control" placeholder="Sales Order Code" id="sales_order_no_edit" name="sales_order_no_edit" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Sales Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Sales Order Internal Code" id="sales_order_internal_no_edit" name="sales_order_internal_no_edit" required>                         
                          </div>   
                          <div class="form-group">
                            <label><h5>Sales Type</h5></label>
                            <select class="form-control custom-select" id="id_sales_type_edit" name="id_sales_type_edit">
                            <?php 
                              $id_st_isi = mysqli_query($koneksi, "select * from itv_masterdata_salestype"); 
                              while($row = mysqli_fetch_array($id_st_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_sales_type]>$row[sales_type]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>
                          <div class="form-group"> 
                            <label><h5>Sales Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Sales Date" id="sales_date_edit" name="sales_date_edit" required>                         
                          </div>
                          <div class="form-group">
                            <label><h5>Business Partner</h5></label>
                            <select class="form-control custom-select" id="id_bp_edit" name="id_bp_edit">
                            <?php 
                              $id_bp_isi = mysqli_query($koneksi, "select * from itv_masterdata_bp where bp_type=10 and isdelete=1"); 
                              while($row = mysqli_fetch_array($id_bp_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_bp]>$row[bp_code] $row[bp_name]</option>";
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
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_so_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit SO<END> ---------------------------------->

  <!----------------------- Modal Delete PO-------------------------------------->
  <div class="modal fade" id="so_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Sales Order</h4>
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
  <!----------------------- <END>Modal Delete PO<END>---------------------------->

  <!----------------------- Modal Plan PO-------------------------------------->
  <div class="modal fade" id="so_plan_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Plan Sales Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to plan this sales?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_plan">Plan</button>
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

          /* ======================= Add PO ========================= */
          $(document).ready(function(){
            // e.preventDefault();
            $('#id_bp').select2();
            $('#btn_add_so').on('click', function(){
            var sales_order_no = $('#sales_order_no').val();
            var sales_order_internal_no = $('#sales_order_internal_no').val();
            var id_sales_type = $('#id_sales_type').find(":selected").val();  
            var sales_date = $('#sales_date').val();  
            var id_bp = $('#id_bp').find(":selected").val();      

            $.ajax({
              url : "sash/administrator/so/so_controller.php",
              type : "POST",
              data : {
                sales_order_no : sales_order_no, 
                sales_order_internal_no : sales_order_internal_no, 
                id_sales_type : id_sales_type,
                sales_date : sales_date,
                id_bp : id_bp             
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#sales_order_no').val("");
                $('#sales_order_internal_no').val("");
                $('#id_sales_type').val("");
                $('#id_bp').val("");
                $('#sales_date').val("");
                $('#modal_add_so').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add PO <END> ===================== */

        /* ======================= Menampilkan edit modal SO ======================= */
      $('#example1').on('click','.btn_edit', function(){
        //e.preventDefault();
        let id_so_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/so/so_controller.php",
          type : 'POST',
          data : {id_so_header_edit : id_so_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#so_edit_modal").modal("show");
            $('#id_so_header_edit').val(response.id_so_header);
            $('#sales_order_no_edit').val(response.sales_order_no);
            $('#sales_order_internal_no_edit').val(response.sales_order_internal_no);
            $('#id_sales_type_edit').val(response.id_sales_type).trigger('change');
            $('#sales_date_edit').val(response.sales_date);
            $('#id_bp_edit').val(response.id_bp).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal SO <END> ==================== */

      /* ======================= Mengupdate SO ======================= */
        $('#btn_so_update').on('click', function(e){
				e.preventDefault();
				let id_so_header = $('#id_so_header_edit').val();
				let sales_order_no = $('#sales_order_no_edit').val();
				let sales_order_internal_no = $('#sales_order_internal_no_edit').val();
                let id_sales_type = $('#id_sales_type_edit').find(":selected").val();
                let sales_date = $('#sales_date_edit').val();  
				let id_bp = $('#id_bp_edit').find(":selected").val(); 

				$.ajax({
					url : "sash/administrator/so/so_controller.php",
					type : 'POST',
					data : {id_so_header_update : id_so_header, 
                            sales_order_no_update : sales_order_no,
							sales_order_internal_no_update : sales_order_internal_no,
                            id_sales_type_update : id_sales_type,
                            sales_date_update : sales_date,
							id_bp_update : id_bp
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_so_header_edit').val("");
            $('#sales_order_no_edit').val("");
            $('#sales_order_internal_no_edit').val("");
            $('#id_sales_type_edit').val("");
            $('#id_bp_edit').val("");
            $('#sales_date_edit').val("");
            $('#so_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate SO <END> ======================= */

     /* =========================== Delete SO ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_so_header_delete = $(this).attr('id');
        $('#so_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/so/so_controller.php",
            type : 'POST',
            data : {id_so_header_delete : id_so_header_delete},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#so_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete SO <END> ===================== */

      /* =========================== Plan SO ========================= */
	    $('#example1').on('click','.btn_plan', function(){
        let id_so_header_plan = $(this).attr('id');
        $('#so_plan_modal').modal('show');
        $('#btn_confirm_plan').on('click', function(){
          $.ajax({
            url : "sash/administrator/so/so_controller.php",
            type : 'POST',
            data : {id_so_header_plan : id_so_header_plan},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been planned",'','success');
              } else {
                Swal.fire("Data failed to planned",'','error');
              }
              $('#so_plan_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Plan SO <END> ===================== */
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


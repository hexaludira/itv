<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>WAREHOUSE/Warehouse Order</b></a></li>
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
                <h3 class="card-title">Data Warehouse Order</h3>
                  <div class="card-tools">
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Warehouse Order No</th>
                    <th>Warehouse Order Internal No</th>
                    <th>Transaction Type</th>
                    <th>Order Type</th>
                    <th>Order No</th>
                    <th>Send From</th>
                    <th>Send To</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php                      
                        $sql2 = $koneksi->query("SELECT 
                                                a.id_wh_header as id_wh_header,
                                                a.wh_order_no as wh_order_no,
                                                a.wh_order_internal_no as wh_order_internal_no,
                                                b.trx_type_code as trx_type_code,
                                                c.order_type as order_type,
                                                d.purchase_order_no as purchase_order_no,
                                                e.sales_order_no as sales_order_no,
                                                f.prod_order_no as prod_order_no,
                                                g.adj_order_no as adj_order_no,
                                                h.scrap_no as scrap_no,
                                                a.send_from as send_from,
                                                a.send_to as send_to,
                                                a.status as status,
                                                a.id_order_type as id_order_type
                                                FROM
                                                itv_wh_header as a
                                                LEFT JOIN itv_lnsw_masterdata_trxtypecode as b ON a.id_trx_type_code = b.id_trx_type_code
                                                LEFT JOIN itv_masterdata_order_type as c ON a.id_order_type = c.id_order_type
                                                LEFT JOIN itv_po_header as d ON a.id_order_header = d.id_po_header
                                                LEFT JOIN itv_so_header as e ON a.id_order_header = e.id_so_header
                                                LEFT JOIN itv_prod_header as f ON a.id_order_header = f.id_prod_header
                                                LEFT JOIN itv_adj_header as g ON a.id_order_header = g.id_adj_header
                                                LEFT JOIN itv_scrap_header as h ON a.id_order_header = h.id_scrap_header
                                                WHERE a.isdelete = '1'
                                                ");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $data['wh_order_no']; ?></td>
                    <td><?php echo $data['wh_order_internal_no']; ?></td>
                    <td><?php echo $data['trx_type_code']; ?></td>
                    <td><?php echo $data['order_type']; ?></td>
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo $data['purchase_order_no']; ?>
                        <?php }elseif($id_order_type == "130"){ ?>
                        <?php echo $data['sales_order_no']; ?>
                        <?php }elseif($id_order_type == "140"){ ?>
                        <?php echo $data['prod_order_no']; ?>
                        <?php }elseif($id_order_type == "120"){ ?>
                        <?php echo $data['prod_order_no']; ?>
                        <?php }elseif($id_order_type == "999"){ ?>
                        <?php echo $data['adj_order_no']; ?>
                        <?php }elseif($id_order_type == "888"){ ?>
                        <?php echo $data['scrap_no']; ?>
                        <?php } ?>
                    </td>
                    <td><?php echo $data['send_from']; ?></td>
                    <td><?php echo $data['send_to']; ?></td>
                    <td>
                        <?php $status = $data['status']; ?>
                        <?php if($status == "10"){?>
                        <span class="badge bg-secondary">Created</span>
                        <?php }elseif($status == "40"){ ?>  
                        <span class="badge bg-success">Received</span> 
                        <?php }elseif($status == "50"){ ?>  
                        <span class="badge bg-success">Delivered</span>
                        <?php }elseif($status == "70"){ ?>  
                        <span class="badge bg-success">Completed</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td> 
                    <td>
                        <?php $id_order_type = $data['id_order_type'];?>
                        <?php if($id_order_type == "110"){?>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_wh_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-info btn-sm" href="?page=wh_receive_view&kode=<?php echo $data['id_wh_header']; ?>"><i class="fas fa-hand-holding-medical"></i></a>
                        <a class="btn btn-warning btn-sm" href=""><i class="fas fa-dolly-flatbed"></i></a>
                        <?php }elseif($id_order_type == "130"){ ?>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_wh_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-info btn-sm" href=""><i class="fas fa-hand-holding-medical"></i></a>
                        <a class="btn btn-warning btn-sm" href="?page=wh_deliver_view&kode=<?php echo $data['id_wh_header']; ?>"><i class="fas fa-dolly-flatbed"></i></a>
                        <?php }elseif($id_order_type == "140"){ ?>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_wh_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-info btn-sm" href=""><i class="fas fa-hand-holding-medical"></i></a>
                        <a class="btn btn-warning btn-sm" href="?page=wh_deliver_pro_view&kode=<?php echo $data['id_wh_header']; ?>"><i class="fas fa-dolly-flatbed"></i></a>
                        <?php }elseif($id_order_type == "120"){ ?>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_wh_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-info btn-sm" href="?page=wh_receive_pro_view&kode=<?php echo $data['id_wh_header']; ?>"><i class="fas fa-hand-holding-medical"></i></a>
                        <a class="btn btn-warning btn-sm" href=""><i class="fas fa-dolly-flatbed"></i></a>
                        <?php }elseif($id_order_type == "999"){ ?>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_wh_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-info btn-sm" href="?page=wh_receive_pro_view&kode=<?php echo $data['id_wh_header']; ?>"><i class="fas fa-hand-holding-medical"></i></a>
                        <a class="btn btn-warning btn-sm" href=""><i class="fas fa-dolly-flatbed"></i></a>
                        <?php }elseif($id_order_type == "888"){ ?>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_wh_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-info btn-sm" href="?page=wh_receive_pro_view&kode=<?php echo $data['id_wh_header']; ?>"><i class="fas fa-hand-holding-medical"></i></a>
                        <a class="btn btn-warning btn-sm" href=""><i class="fas fa-dolly-flatbed"></i></a>
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

    <!------------------- Modal Edit WO ---------------------------------->
<div class="modal fade" id="wo_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Warehouse Order</h4>
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
                            <label><h5>Warehouse Order No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_wh_header_edit" name="id_wh_header_edit">                        
                            <input type="text" class="form-control" placeholder="Warehouse Order No" id="wh_order_no_edit" name="wh_order_no_edit" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Warehouse Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Warehouse Order Internal Code" id="wh_order_internal_no_edit" name="wh_order_internal_no_edit" required>                         
                          </div>                                        
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_wo_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit WO<END> ---------------------------------->


<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

        /* ======================= Menampilkan edit modal WO ======================= */
      $('#example1').on('click','.btn_edit', function(){
        //e.preventDefault();
        let id_wh_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/warehouse/wh_order_controller.php",
          type : 'POST',
          data : {id_wh_header_edit : id_wh_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#wo_edit_modal").modal("show");
            $('#id_wh_header_edit').val(response.id_wh_header);
            $('#wh_order_no_edit').val(response.wh_order_no);
            $('#wh_order_internal_no_edit').val(response.wh_order_internal_no);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal WO <END> ==================== */

      /* ======================= Mengupdate WO ======================= */
        $('#btn_wo_update').on('click', function(e){
				e.preventDefault();
				let id_wh_header = $('#id_wh_header_edit').val();
				let wh_order_internal_no = $('#wh_order_internal_no_edit').val();

				$.ajax({
					url : "sash/administrator/warehouse/wh_order_controller.php",
					type : 'POST',
					data : {id_wh_header_update : id_wh_header, 
                  wh_order_internal_no_update : wh_order_internal_no
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_wh_header_edit').val("");
            $('#wh_order_no_edit').val("");
            $('#wh_order_internal_no_edit').val("");
            $('#wo_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate WO <END> ======================= */
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->




 
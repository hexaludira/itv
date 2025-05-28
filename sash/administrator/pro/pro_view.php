<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>PRODUCTION/Production Order</b></a></li>
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
                <h3 class="card-title">Data Production Order</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_prod"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Production Order No</th>
                    <th>Production Order Internal No</th>
                    <th>Production Type</th>
                    <th>Production Date</th>
                    <th>Completed Date</th>
                    <th>Item</th> 
                    <th>Bill of Material No</th> 
                    <th>Planned Quantity</th>  
                    <th>Completed Quantity</th>    
                    <th>Unit</th>          
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
                                                a.id_prod_header as id_prod_header,
                                                a.prod_order_no as prod_order_no,
                                                a.prod_order_internal_no as prod_order_internal_no,
                                                c.production_desc as production_desc,
                                                a.prod_date as prod_date,
                                                b.datetime as datetime,
                                                d.item_code as item_code,
                                                f.bom_no as bom_no,
                                                d.item_desc as item_desc,
                                                b.quantity as quantity,
                                                b.actual_quantity as actual_quantity,
                                                e.unit as unit,
                                                a.createdby as createdby,
                                                a.createddatetime as createddatetime,
                                                a.lastupdatedby as lastupdatedby,
                                                a.lastupdateddatetime as lastupdateddatetime,
                                                a.status as status
                                                FROM itv_prod_header as a
                                                LEFT JOIN itv_prod_detail_fg as b ON a.id_prod_header = b.id_prod_header
                                                LEFT JOIN itv_masterdata_production as c ON a.id_production = c.id_production
                                                LEFT JOIN itv_masterdata_item as d ON b.id_item = d.id_item
                                                LEFT JOIN itv_lnsw_masterdata_unitcode as e ON d.id_unit_code = e.id_unit_code
                                                LEFT JOIN itv_masterdata_bom_header as f ON b.id_bom_header = f.id_bom_header
                                                WHERE a.isdelete = '1' AND b.isdelete = '1'
                                                ORDER BY a.id_prod_header ASC");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['prod_order_no']; ?></td>
                    <td><?php echo $data['prod_order_internal_no']; ?></td>
                    <td><?php echo $data['production_desc']; ?></td>
                    <td><?php echo $data['prod_date']; ?></td>
                    <td><?php echo $data['datetime']; ?></td>
                    <td><?php echo $data['item_code']; ?>-<?php echo $data['item_desc']; ?></td>
                    <td><?php echo $data['bom_no']; ?></td>
                    <td><?php echo $data['quantity']; ?></td>
                    <td><?php echo $data['actual_quantity']; ?></td>
                    <td><?php echo $data['unit']; ?></td>
                    <td><?php echo $data['createdby']; ?></td>
                    <td><?php echo $data['createddatetime']; ?></td>
                    <td><?php echo $data['lastupdatedby']; ?></td>
                    <td><?php echo $data['lastupdateddatetime']; ?></td>
                    <td>
                        <?php $status = $data['status']; ?>
                        <?php if($status == "10"){?>
                        <span class="badge bg-secondary">Created</span>
                        <?php }elseif($status == "30"){ ?>  
                        <span class="badge bg-info">Released</span> 
                        <?php }elseif($status == "60"){ ?>  
                        <span class="badge bg-warning">To be completed</span> 
                        <?php }elseif($status == "70"){ ?>  
                        <span class="badge bg-success">Completed</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>                 
                    <td>
                        <?php $status = $data['status'];?>
                        <?php if($status == "10"){?>
                        <a class="btn btn-default btn-sm" href="?page=pro_rm_view&kode=<?php echo $data['id_prod_header']; ?>"><i class="fas fa-shapes"></i>
                            Material Order
                        </a>
                        <button class="btn btn-default btn-sm btn_released" id="<?php echo $data['id_prod_header']; ?>"><i class="fas fa-bullhorn"></i>
                            Released
                        </button>
                        <button class="btn btn-default btn-sm btn_material_usage" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-list"></i>
                            Material Usage
                        </button>
                        <button class="btn btn-default btn-sm btn_tobe_complete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-ellipsis-h"></i>
                          To Be Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-box"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_prod_header']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_prod_header']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "30"){ ?>  
                        <a class="btn btn-default btn-sm" href="?page=pro_rm_blocked_view&kode=<?php echo $data['id_prod_header']; ?>"><i class="fas fa-shapes"></i>
                          Material Order
                        </a>
                        <button class="btn btn-default btn-sm btn_released" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Released
                        </button>
                        <a class="btn btn-default btn-sm" href="?page=pro_rm_usage_view&kode=<?php echo $data['id_prod_header']; ?>"><i class="fas fa-list"></i>
                            Materials Usage
                        </a>
                        <button class="btn btn-default btn-sm btn_tobe_complete" id="<?php echo $data['id_prod_header']; ?>"><i class="fas fa-ellipsis-h"></i>
                          To Be Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-box"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "60"){ ?>  
                        <a class="btn btn-default btn-sm" href="?page=pro_rm_blocked_view&kode=<?php echo $data['id_prod_header']; ?>"><i class="fas fa-shapes"></i>
                          Material Order
                        </a>
                        <button class="btn btn-default btn-sm btn_released" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Released
                        </button>
                        <button class="btn btn-default btn-sm btn_material_usage" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-list"></i>
                            Material Usage
                        </button>
                        <button class="btn btn-default btn-sm btn_tobe_complete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-ellipsis-h"></i>
                          To Be Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_prod_header']; ?>" ><i class="fas fa-box"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($status == "70"){ ?>  
                        <a class="btn btn-default btn-sm" href="?page=pro_rm_blocked_view&kode=<?php echo $data['id_prod_header']; ?>"><i class="fas fa-shapes"></i>
                          Material Order
                        </a>
                        <button class="btn btn-default btn-sm btn_released" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-bullhorn"></i>
                            Released
                        </button>
                        <button class="btn btn-default btn-sm btn_material_usage" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-list"></i>
                            Material Usage
                        </button>
                        <button class="btn btn-default btn-sm btn_tobe_complete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-ellipsis-h"></i>
                            To Be Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_complete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-box"></i>
                            Complete
                        </button>
                        <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_prod_header']; ?>" disabled><i class="fas fa-trash-can"></i>
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

    <!------------------- modal add pro header ---------------------------------->
  
<div class="modal fade" id="modal_add_prod">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Production Order</h4>
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
                            <label><h5>Production Order No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Production Order Code Generate By System" id="prod_order_no" name="prod_order_no" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Production Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Production Order Internal Code" id="prod_order_internal_no" name="prod_order_internal_no" required>                         
                          </div>
                          <div class="form-group">
                            <label><h5>Production Type</h5></label>
                            <select class="form-control custom-select" id="id_production" name="id_production">
                            <?php 
                              $id_pt_isi = mysqli_query($koneksi, "select * from itv_masterdata_production"); 
                              while($row = mysqli_fetch_array($id_pt_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_production]>$row[production_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group"> 
                            <label><h5>Production Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Production Date" id="prod_date" name="prod_date" required>                      
                          </div> 
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select id_item" id="id_item" name="id_item">
                            <?php 
                              $id_pt_isi = mysqli_query($koneksi, "select a.id_item as id_item, a.item_code as item_code, a.item_desc, b.unit from itv_masterdata_item as a left join itv_lnsw_masterdata_unitcode as b on a.id_unit_code = b.id_unit_code where a.id_item_category_code in ('6','7') and a.isdelete = '1'"); 
                              while($row = mysqli_fetch_array($id_pt_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] - $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group">
                            <label><h5>Bill of Material No </h5></label>
                            <a href="?page=bom_blocked_view" target="_blank"><u><?php echo 'More info...' ?></u></a>
                            <select class="form-control custom-select id_bom_header" id="id_bom_header" name="id_bom_header">
                            <?php 
                              $id_bom_isi = mysqli_query($koneksi, "select a.id_bom_header as id_bom_header, a.bom_no as bom_no, b.item_code as item_code, b.item_desc as item_desc from itv_masterdata_bom_header as a left join itv_masterdata_item as b on a.id_item=b.id_item where a.status ='60' and a.isdelete = '1' and b.isdelete='1'"); 
                              while($row = mysqli_fetch_array($id_bom_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_bom_header]>$row[bom_no] / $row[item_code] - $row[item_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group"> 
                            <label><h5>Quantity</h5></label>                           
                            <input type="number" class="form-control" placeholder="Quantity" id="quantity" name="quantity" required>                      
                          </div> 
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information for this production order..." id="remark" name="remark" required></textarea>                          
                          </div>                                        
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_prod">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>

<!------------------- <END>modal add pro header<END> ---------------------------------->   

<!------------------- Modal Edit pro ---------------------------------->
<div class="modal fade" id="prod_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Production Order</h4>
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
                            <label><h5>Production Order No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_prod_header_edit" name="id_prod_header_edit">                        
                            <input type="text" class="form-control" placeholder="Production Order Code" id="prod_order_no_edit" name="prod_order_no_edit" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Production Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Production Order Internal Code" id="prod_order_internal_no_edit" name="prod_order_internal_no_edit" required>                         
                          </div>   
                          <div class="form-group">
                            <label><h5>Production Type</h5></label>
                            <select class="form-control custom-select" id="id_production_edit" name="id_production_edit">
                            <?php 
                              $id_pt_isi = mysqli_query($koneksi, "select * from itv_masterdata_production"); 
                              while($row = mysqli_fetch_array($id_pt_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_production]>$row[production_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>
                          <div class="form-group"> 
                            <label><h5>Production Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Production Date" id="prod_date_edit" name="prod_date_edit" required>                         
                          </div>      
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select id_item_edit" id="id_item_edit" name="id_item_edit" disabled>
                            <?php 
                              $id_pt_isi = mysqli_query($koneksi, "select a.id_item as id_item, a.item_code as item_code, a.item_desc, b.unit from itv_masterdata_item as a left join itv_lnsw_masterdata_unitcode as b on a.id_unit_code = b.id_unit_code where a.id_item_category_code in ('6','7') and a.isdelete = '1'"); 
                              while($row = mysqli_fetch_array($id_pt_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] - $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group">
                            <label><h5>Bill of Material No </h5></label>
                            <a href="?page=bom_blocked_view" target="_blank"><u><?php echo 'More info...' ?></u></a>
                            <select class="form-control custom-select id_bom_header" id="id_bom_header_edit" name="id_bom_header_edit" disabled>
                            <?php 
                              $id_bom_isi = mysqli_query($koneksi, "select a.id_bom_header as id_bom_header, a.bom_no as bom_no, b.item_code as item_code, b.item_desc as item_desc from itv_masterdata_bom_header as a left join itv_masterdata_item as b on a.id_item=b.id_item where a.status ='60' and a.isdelete = '1' and b.isdelete='1'"); 
                              while($row = mysqli_fetch_array($id_bom_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_bom_header]>$row[bom_no] / $row[item_code] - $row[item_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>
                          <div class="form-group"> 
                            <label><h5>Quantity</h5></label>                           
                            <input type="number" class="form-control" placeholder="Quantity" id="quantity_edit" name="quantity_edit" required disabled>                      
                          </div> 
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information for this production order..." id="remark_edit" name="remark_edit" required></textarea>                          
                          </div>                                  
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_prod_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit pro<END> ---------------------------------->

  <!----------------------- Modal Delete pro-------------------------------------->
  <div class="modal fade" id="prod_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Production Order</h4>
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
  <!----------------------- <END>Modal Delete pro<END>---------------------------->

  <!----------------------- Modal released prod-------------------------------------->
  <div class="modal fade" id="prod_released_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Released Production Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to released this production order including material order?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_released">Release</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal released prod<END>---------------------------->

  <!----------------------- Modal to be complete prod-------------------------------------->
  <div class="modal fade" id="prod_tobe_complete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">To Be Complete Production Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to be complete this production order including material order & consumption?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_tobe_complete">To be Complete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal to be complete prod<END>---------------------------->


  <!------------------- Complete pro edit ---------------------------------->
<div class="modal fade" id="complete_prod_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Complete Production Order</h4>
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
                            <label><h5>Production Order No</h5></label>   
                            <input type="hidden" class="form-control" placeholder="" id="id_prod_header_complete" name="id_prod_header_complete">                        
                            <input type="text" class="form-control" placeholder="Production Order Code" id="prod_order_no_complete" name="prod_order_no_complete" disabled>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Production Order Internal No</h5></label>                           
                            <input type="text" class="form-control" placeholder="Production Order Internal Code" id="prod_order_internal_no_complete" name="prod_order_internal_no_complete" disabled>                         
                          </div>   
                          <div class="form-group">
                            <label><h5>Production Type</h5></label>
                            <select class="form-control custom-select" id="id_production_complete" name="id_production_complete" disabled>
                            <?php 
                              $id_pt_isi = mysqli_query($koneksi, "select * from itv_masterdata_production"); 
                              while($row = mysqli_fetch_array($id_pt_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_production]>$row[production_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>
                          <div class="form-group"> 
                            <label><h5>Production Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Production Date" id="prod_date_complete" name="prod_date_complete" disabled>                         
                          </div>      
                          <div class="form-group">
                            <label><h5>Item</h5></label>
                            <select class="form-control custom-select id_item_complete" id="id_item_complete" name="id_item_complete" disabled>
                            <?php 
                              $id_pt_isi = mysqli_query($koneksi, "select a.id_item as id_item, a.item_code as item_code, a.item_desc, b.unit from itv_masterdata_item as a left join itv_lnsw_masterdata_unitcode as b on a.id_unit_code = b.id_unit_code where a.id_item_category_code in ('6','7') and a.isdelete = '1'"); 
                              while($row = mysqli_fetch_array($id_pt_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] - $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group">
                            <label><h5>Bill of Material No </h5></label>
                            <a href="?page=bom_blocked_view" target="_blank"><u><?php echo 'More info...' ?></u></a>
                            <select class="form-control custom-select id_bom_header" id="id_bom_header_complete" name="id_bom_header_complete" disabled>
                            <?php 
                              $id_bom_isi = mysqli_query($koneksi, "select a.id_bom_header as id_bom_header, a.bom_no as bom_no, b.item_code as item_code, b.item_desc as item_desc from itv_masterdata_bom_header as a left join itv_masterdata_item as b on a.id_item=b.id_item where a.status ='60' and a.isdelete = '1' and b.isdelete='1'"); 
                              while($row = mysqli_fetch_array($id_bom_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_bom_header]>$row[bom_no] / $row[item_code] - $row[item_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>                    
                          </div>  
                          <div class="form-group"> 
                            <label><h5>Quantity</h5></label>                           
                            <input type="number" class="form-control" placeholder="Quantity" id="quantity_complete" name="quantity_complete" disabled>                      
                          </div> 
                          <div class="form-group"> 
                            <label><h5>Remarks</h5></label>                           
                            <textarea class="form-control" rows="2" placeholder="Another information for this production order..." id="remark_complete" name="remark_complete" required disabled></textarea>                          
                          </div>         
                          <div class="form-group"> 
                            <label><h5>Completed Production Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="Completed Production Date" id="datetime_complete" name="datetime_complete" required>                         
                          </div>  
                          <div class="form-group"> 
                            <label><h5>Completed Quantity</h5></label>                           
                            <input type="number" class="form-control" placeholder="Completed Quantity" id="actual_quantity_complete" name="actual_quantity_complete" required>                      
                          </div>                         
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_complete_prod_update">Complete</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Complete pro edit<END> ---------------------------------->

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });
          

          /* ======================= Add prod ========================= */
          $(document).ready(function(){
            // e.preventDefault();
            $('#id_item').select2();
            $('#id_bom_header').select2();
            $('#id_item_edit').select2();
            $('#id_item_complete').select2();
            $('#btn_add_prod').on('click', function(){
            var prod_order_no = $('#prod_order_no').val();
            var prod_order_internal_no = $('#prod_order_internal_no').val();
            var id_production = $('#id_production').find(":selected").val();  
            var prod_date = $('#prod_date').val();
            var remark = $('#remark').val();
            var id_item = $('#id_item').val();
            var id_bom_header = $('#id_bom_header').val();
            var quantity = $('#quantity').val();

            $.ajax({
              url : "sash/administrator/pro/pro_controller.php",
              type : "POST",
              data : {
                prod_order_no : prod_order_no, 
                prod_order_internal_no : prod_order_internal_no, 
                id_production : id_production,
                prod_date : prod_date,
                remark : remark,
                id_item : id_item,
                id_bom_header : id_bom_header,
                quantity : quantity         
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#prod_order_no').val("");
                $('#prod_order_internal_no').val("");
                $('#id_production').val("");
                $('#prod_date').val("");
                $('#remark').val("");
                $('#id_item').val("");
                
                $('#quantity').val("");
                $('#modal_add_prod').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add PO <END> ===================== */

        /* ======================= Menampilkan edit modal pro ======================= */
      $('#example1').on('click','.btn_edit', function(e){
        e.preventDefault();
        let id_prod_header_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/pro/pro_controller.php",
          type : 'POST',
          data : {id_prod_header_edit : id_prod_header_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#prod_edit_modal").modal("show");
            $('#id_prod_header_edit').val(response.id_prod_header);
            $('#prod_order_no_edit').val(response.prod_order_no);
            $('#prod_order_internal_no_edit').val(response.prod_order_internal_no);
            $('#id_production_edit').val(response.id_production).trigger('change');
            $('#prod_date_edit').val(response.prod_date);
            $('#remark_edit').val(response.remark);
            $('#id_item_edit').val(response.id_item).trigger('change');
            $('#id_bom_header_edit').val(response.id_bom_header).trigger('change');
            $('#quantity_edit').val(response.quantity);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal pro <END> ==================== */

      /* ======================= Mengupdate pro ======================= */
        $('#btn_prod_update').on('click', function(e){
				e.preventDefault();
				let id_prod_header = $('#id_prod_header_edit').val();
				let prod_order_no = $('#prod_order_no_edit').val();
				let prod_order_internal_no = $('#prod_order_internal_no_edit').val();
        let id_production = $('#id_production_edit').find(":selected").val();
        let prod_date = $('#prod_date_edit').val();  
				let remark = $('#remark_edit').val();
        let id_item = $('#id_item_edit').find(":selected").val();
        let quantity = $('#quantity_edit').val(); 

				$.ajax({
					url : "sash/administrator/pro/pro_controller.php",
					type : 'POST',
					data : {id_prod_header_update : id_prod_header, 
                  prod_order_no_update : prod_order_no,
									prod_order_internal_no_update : prod_order_internal_no,
                  id_production_update : id_production,
                  prod_date_update : prod_date,
									remark_update : remark,
                  id_item_update : id_item,
                  quantity_update : quantity
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

            $('#id_prod_header_edit').val("");
            $('#prod_order_no_edit').val("");
            $('#prod_order_internal_no_edit').val("");
            $('#id_production_edit').val("");
            $('#remark_edit').val("");
            $('#prod_date_edit').val("");
            $('#id_item_edit').val("");
            $('#quantity_edit').val("");
            $('#prod_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate pro <END> ======================= */

     /* =========================== Delete pro ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_prod_header = $(this).attr('id');
        $('#prod_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/pro/pro_controller.php",
            type : 'POST',
            data : {id_prod_header_delete : id_prod_header},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#prod_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete pro <END> ===================== */

      /* =========================== Release pro ========================= */
	    $('#example1').on('click','.btn_released', function(){
        let id_prod_header = $(this).attr('id');
        $('#prod_released_modal').modal('show');
        $('#btn_confirm_released').on('click', function(){
          $.ajax({
            url : "sash/administrator/pro/pro_controller.php",
            type : 'POST',
            data : {id_prod_header_released : id_prod_header},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been released",'','success');
              } else {
                Swal.fire("Data failed to released",'','error');
              }
              $('#prod_released_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Release pro <END> ===================== */

      /* =========================== To be complete pro ========================= */
      $('#example1').on('click','.btn_tobe_complete', function(){
        let id_prod_header = $(this).attr('id');
        $('#prod_tobe_complete_modal').modal('show');
        $('#btn_confirm_tobe_complete').on('click', function(){
          $.ajax({
            url : "sash/administrator/pro/pro_controller.php",
            type : 'POST',
            data : {id_prod_header_tobe_complete : id_prod_header},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been to be complete",'','success');
              } else {
                Swal.fire("Data failed to be complete",'','error');
              }
              $('#prod_tobe_complete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> To be complete pro <END> ===================== */

      /* =========================== Complete pro edit ========================= */
        $('#example1').on('click','.btn_complete', function(e){
        e.preventDefault();
        let id_prod_header_complete = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/pro/pro_controller.php",
          type : 'POST',
          data : {id_prod_header_complete : id_prod_header_complete},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#complete_prod_edit_modal").modal("show");
            $('#id_prod_header_complete').val(response.id_prod_header);
            $('#prod_order_no_complete').val(response.prod_order_no);
            $('#prod_order_internal_no_complete').val(response.prod_order_internal_no);
            $('#id_production_complete').val(response.id_production).trigger('change');
            $('#prod_date_complete').val(response.prod_date);
            $('#remark_complete').val(response.remark);
            $('#id_item_complete').val(response.id_item).trigger('change');
            $('#id_bom_header_complete').val(response.id_bom_header).trigger('change');
            $('#quantity_complete').val(response.quantity);
          }
        });
        //Swal.fire(edit_id);
      });
      /* ======================== <END> Complete pro edit <END> ===================== */

      /* ======================= Mengupdate pro complete ======================= */
      $('#btn_complete_prod_update').on('click', function(e){
				e.preventDefault();
				let id_prod_header = $('#id_prod_header_complete').val();
        let actual_quantity = $('#quantity_complete').val(); 
        let datetime = $('#datetime_complete').val(); 

				$.ajax({
					url : "sash/administrator/pro/pro_controller.php",
					type : 'POST',
					data : {id_prod_header_complete_update : id_prod_header, 
                  datetime_complete_update : datetime,
                  actual_quantity_update : actual_quantity
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data completed succesfully",'','success');
            } else {
              Swal.fire("Complete data failed",'','error');
            }

            $('#id_prod_header_complete').val("");
            $('#datetime_complete').val("");
            $('#quantity_complete').val("");
            $('#complete_prod_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate pro complete <END> ======================= */

      
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


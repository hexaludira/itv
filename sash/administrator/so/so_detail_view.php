<?php

include "inc/koneksi.php";
if (isset($_GET['kode'])) {
  $sql_cek = "SELECT 
            a.id_so_header as id_so_header,
            a.sales_order_no as sales_order_no,
            a.sales_order_internal_no as sales_order_internal_no,
            a.sales_date as sales_date,
            a.createdby as createdby,
            a.createddatetime as createddatetime,
            a.lastupdatedby as lastupdatedby,
            a.lastupdateddatetime as lastupdateddatetime,
            a.status as status,
            b.bp_code as bp_code,
            b.bp_name as bp_name
            FROM itv_so_header as a
            JOIN itv_masterdata_bp as b ON a.id_bp=b.id_bp 
            WHERE a.id_so_header='" . $_GET['kode'] . "' AND a.isdelete='1'";

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
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>SALES/Sales Order/Sales Order Detail</b></a></li>
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
              <h3 class="card-title">Data Sales Order & Sales Order Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Sales Order No</label>
                      <input type="text" class="form-control" placeholder="Sales Order No" name="sales_order_no" value=<?php echo $data_cek['sales_order_no']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Sales Order Internal No</label>
                        <input type="text" class="form-control" placeholder="Sales Order Internal No" name="sales_order_internal_no" value=<?php echo $data_cek['sales_order_internal_no']; ?> disabled>
                    </div>         
                  </div>
                  </br>
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Sales Date</label>
                      <input type="date" class="form-control" placeholder="Sales Date" name="sales_date" value=<?php echo $data_cek['sales_date']; ?> disabled>
                    </div>                          
                  </div> 
                  </br>
                  <div class="row">  
                    <div class="col-md-1">
                        <label>Business Partner</label>
                        <input type="text" class="form-control" placeholder="Business Partner" name="Business Partner" value=<?php echo $data_cek['bp_code']; ?> disabled>                     
                      </div>
                      <div class="col-md-4">  
                        <label>Business Partner Name</label>              
                        <textarea class="form-control" rows="1" placeholder="Supplier Name" id="Name" name="Name" disabled><?php echo $data_cek['bp_name']; ?></textarea>
                      </div>                     
                    </div>          
                  </div>                 
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card"> 
                        <div class="card-header">
                            <h3 class="card-title">Data Sales Order Detail</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_so_detail"><i class="fas fa-plus-square"></i> Add</button>
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
                              <th>Currency</th>
                              <th>Price</th>
                              <th>Status</th>
                              <th>Action</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php              
                              $no = 1;       
                              $sql = $koneksi->query("SELECT
                                                    a.id_so_detail as id_so_detail,
                                                    b.item_code as item_code,
                                                    b.item_desc as item_desc,
                                                    a.quantity as quantity,
                                                    c.unit as unit,
                                                    a.price as price,
                                                    d.currency_code as currency,
                                                    a.status as status
                                                    FROM itv_so_detail as a
                                                    JOIN itv_masterdata_item as b ON a.id_item = b.id_item
                                                    JOIN itv_lnsw_masterdata_unitcode as c ON b.id_unit_code = c.id_unit_code
                                                    JOIN itv_masterdata_currency as d ON a.id_currency = d.id_currency
                                                    WHERE a.id_so_header='" . $_GET['kode'] . "' AND a.isdelete='1' ORDER BY a.id_so_detail ASC");
                              while ($data= $sql->fetch_assoc()) {                              
                              ?>
                            <tr>
                              <td><?php echo $data['id_so_detail']; ?></td>
                              <td><?php echo 'L-'; ?><?php echo ($no++)*10; ?></td>
                              <td><?php echo $data['item_code']; ?></td>
                              <td><?php echo $data['item_desc']; ?></td> 
                              <td><?php echo $data['quantity']; ?></td> 
                              <td><?php echo $data['unit']; ?></td>   
                              <td><?php echo $data['currency']; ?></td> 
                              <td><?php echo $data['price']; ?></td>  
                              <td>
                                  <?php $status = $data['status']; ?>
                                  <?php if($status == "10"){?>
                                  <span class="badge bg-secondary">Created</span>
                                  <?php }elseif($status == "40"){ ?>  
                                  <span class="badge bg-success">Received</span> 
                                  <?php }else{ ?>
                                  <span class="badge bg-danger">Error</span>
                                  <?php } ?>
                              </td>  
                              <td>
                                <?php $status = $data['status'];?>
                                <?php if($status == "10"){?>
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_detail']; ?>"><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_detail']; ?>"><i class="fas fa-trash-can"></i>
                                    Delete
                                </button>
                                <?php }elseif($status == "50"){ ?> 
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_so_detail']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_so_detail']; ?>" disabled><i class="fas fa-trash-can"></i>
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
                <a class="btn btn-secondary" href="?page=so_view"><i class="fas fa-backward"></i> Back</a>
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

<!------------------- Modal Add SO detail ---------------------------------->
  
<div class="modal fade" id="modal_add_so_detail">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Sales Order Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_so_header" name="id_so_header" value=<?php echo $data_cek['id_so_header']; ?>>                         
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
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                          </div> 
                          <div class="form-group">
                           <label><h5>Currency</h5></label>
                              <select class="form-control custom-select" id="id_currency" name="id_currency">
                                <?php 
                                  $currencyisi = mysqli_query($koneksi, "select * from itv_masterdata_currency"); 
                                  while($row = mysqli_fetch_array($currencyisi)){?>
                                      <?php                                  
                                        echo "<option value=$row[id_currency]>($row[currency_code])  $row[currency]</option>";
                                      ?>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Price</h5></label>
                            <input type="number" class="form-control" id="price" name="price">
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
            <button type="button" class="btn btn-success" id="btn_add_so_detail">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add SO detail<END> ---------------------------------->

<!------------------- Modal Edit PO detail ---------------------------------->
<div class="modal fade" id="so_detail_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Sales Order Detail</h4>
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
                            <input type="hidden" class="form-control" id="id_so_detail_edit" name="id_so_detail_edit">                         
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
                                                                  from itv_masterdata_item as a JOIN itv_lnsw_masterdata_unitcode as b on a.id_unit_code=b.id_unit_code"); 
                              while($row = mysqli_fetch_array($item_isi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item]>$row[item_code] $row[item_desc] ($row[unit])</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>
                            <input type="number" class="form-control" id="quantity_edit" name="quantity_edit">
                          </div> 
                          <div class="form-group">
                           <label><h5>Currency</h5></label>
                              <select class="form-control custom-select" id="id_currency_edit" name="id_currency_edit">
                                <?php 
                                  $currencyisi = mysqli_query($koneksi, "select * from itv_masterdata_currency"); 
                                  while($row = mysqli_fetch_array($currencyisi)){?>
                                      <?php                                  
                                        echo "<option value=$row[id_currency]>($row[currency_code])  $row[currency]</option>";
                                      ?>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Price</h5></label>
                            <input type="number" class="form-control" id="price_edit" name="price_edit">
                          </div>                                      
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_so_detail_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit PO detail<END> ---------------------------------->

  <!----------------------- Modal Delete SO Detail-------------------------------------->
  <div class="modal fade" id="so_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Sales Order Detail</h4>
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
  <!----------------------- <END>Modal Delete SO Detail<END>---------------------------->



<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add SO detail ========================= */
          $(document).ready(function(){
            $('#id_item').select2();
            $('#id_currency').select2();
            $('#btn_add_so_detail').on('click', function(){
            var id_so_header = $('#id_so_header').val();
            var id_item = $('#id_item').find(":selected").val();
            var quantity = $('#quantity').val();  
            var id_currency = $('#id_currency').find(":selected").val(); 
            var price = $('#price').val();      

            $.ajax({
              url : "sash/administrator/so/so_detail_controller.php",
              type : "POST",
              data : {
                id_so_header : id_so_header, 
                id_item : id_item, 
                quantity : quantity,
                id_currency : id_currency,
                price : price             
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#id_so_header').val("");
                $('#id_item').val("");
                $('#quantity').val("");
                $('#id_currency').val("");
                $('#price').val("");
                $('#modal_add_so_detail').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add SO detail <END> ===================== */

        /* ======================= Menampilkan edit modal SO detail ======================= */
      $('#example2').on('click','.btn_edit', function(e){
        e.preventDefault();
        $('#id_item_edit').select2();
            $('#id_currency_edit').select2();
        let id_so_detail_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/so/so_detail_controller.php",
          type : 'POST',
          data : {id_so_detail_edit : id_so_detail_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#so_detail_edit_modal").modal("show");
            $('#id_so_detail_edit').val(response.id_so_detail);
            $('#quantity_edit').val(response.quantity);
            $('#price_edit').val(response.price);
            $('#id_item_edit').val(response.id_item).trigger('change');
            $('#id_currency_edit').val(response.id_currency).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal SO detail <END> ==================== */

      /* ======================= Mengupdate SO detail ======================= */
        $('#btn_so_detail_update').on('click', function(e){
				e.preventDefault();
				let id_so_detail = $('#id_so_detail_edit').val();
				let quantity = $('#quantity_edit').val();
				let price = $('#price_edit').val();
				let id_item = $('#id_item_edit').find(":selected").val(); 
                let id_currency = $('#id_currency_edit').find(":selected").val(); 

				$.ajax({
					url : "sash/administrator/so/so_detail_controller.php",
					type : 'POST',
					data : {id_so_detail_update : id_so_detail, 
                  quantity_update : quantity,
                  price_update : price,
                  id_item_update : id_item,
                  id_currency_update : id_currency
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

		    $('#id_so_detail_edit').val();
            $('#quantity_edit').val("");
            $('#price_edit').val("");
            $('#id_item_edit').val("");
            $('#id_currency_edit').val("");
            $('#so_detail_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate SO detail <END> ======================= */

     /* =========================== Delete PO Detail ========================= */
	    $('#example2').on('click','.btn_delete', function(e){
        e.preventDefault();
        let id_so_detail = $(this).attr('id');
        $('#so_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/so/so_detail_controller.php",
            type : 'POST',
            data : {id_so_detail_delete : id_so_detail},
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
      /* ======================== <END> Delete PO Detail <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->





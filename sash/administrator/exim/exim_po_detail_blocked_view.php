<?php

include "inc/koneksi.php";
if (isset($_GET['kode'])) {
  $sql_cek = "SELECT 
            a.id_po_header as id_po_header,
            a.purchase_order_no as purchase_order_no,
            a.purchase_order_internal_no as purchase_order_internal_no,
            a.purchase_date as purchase_date,
            a.createdby as createdby,
            a.createddatetime as createddatetime,
            a.lastupdatedby as lastupdatedby,
            a.lastupdateddatetime as lastupdateddatetime,
            a.status as status,
            b.bp_code as bp_code,
            b.bp_name as bp_name
            FROM itv_po_header as a
            JOIN itv_masterdata_bp as b ON a.id_bp=b.id_bp 
            WHERE a.id_po_header='" . $_GET['kode'] . "' AND a.isdelete='1'";

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
              <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>EXIM/Purchase Order/Purchase Order Detail</b></a></li>
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
              <h3 class="card-title">Data Purchase Order & Purchase Order Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Purchase Order No</label>
                      <input type="text" class="form-control" placeholder="Purchase Order No" name="purchase_order_no" value=<?php echo $data_cek['purchase_order_no']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Purchase Order Internal No</label>
                        <input type="text" class="form-control" placeholder="Purchase Order Internal No" name="purchase_order_internal_no" value=<?php echo $data_cek['purchase_order_internal_no']; ?> disabled>
                    </div>         
                  </div>
                  </br>
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Purchase Date</label>
                      <input type="date" class="form-control" placeholder="Purchase Date" name="purchase_date" value=<?php echo $data_cek['purchase_date']; ?> disabled>
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
                            <h3 class="card-title">Data Purchase Order Detail</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_po_detail" disabled><i class="fas fa-plus-square"></i> Add</button>
                            </div>
              </div>                     
                        <div class="card-body">                      
                          <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                            <thead>
                            <tr>
                              <th>Line</th>
                              <th>Item Code</th>
                              <th>Item Description</th>
                              <th>Quantity</th>
                              <th>Batch</th>
                              <th>Received Quantity</th>
                              <th>Received Date</th>
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
                                                    a.id_po_detail as id_po_detail,
                                                    b.item_code as item_code,
                                                    b.item_desc as item_desc,
                                                    a.quantity as quantity,
                                                    c.unit as unit,
                                                    a.price as price,
                                                    d.currency_code as currency,
                                                    g.actual_quantity as actual_quantity,
                                                    g.datetime as datetime,
                                                    g.batch as batch,
                                                    a.status as status
                                                    FROM itv_po_detail as a
                                                    LEFT JOIN itv_masterdata_item as b ON a.id_item = b.id_item
                                                    LEFT JOIN itv_lnsw_masterdata_unitcode as c ON b.id_unit_code = c.id_unit_code
                                                    LEFT JOIN itv_masterdata_currency as d ON a.id_currency = d.id_currency
                                                    LEFT JOIN itv_wh_header as e ON a.id_po_header = e.id_order_header 
                                                    LEFT JOIN itv_wh_detail as f ON e.id_wh_header = f.id_wh_header AND f.id_order_detail = a.id_po_detail
                                                    LEFT JOIN itv_wh_detail_root as g ON f.id_wh_detail = g.id_wh_detail
                                                    WHERE a.id_po_header='" . $_GET['kode'] . "' AND a.isdelete='1' AND e.id_trx_type_code = '30' AND e.id_order_type = '110' AND g.isdelete = '1'
                                                    ORDER BY a.id_po_detail ASC");
                              while ($data= $sql->fetch_assoc()) {                              
                              ?>
                            <tr>
                              <td><?php echo 'L-'; ?><?php echo ($no++)*10; ?></td>
                              <td><?php echo $data['item_code']; ?></td>
                              <td><?php echo $data['item_desc']; ?></td> 
                              <td><?php echo $data['quantity']; ?></td>
                              <td><?php echo $data['batch']; ?></td> 
                              <td><?php echo $data['actual_quantity']; ?></td>
                              <td><?php echo $data['datetime']; ?></td>
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
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_po_detail']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_po_detail']; ?>" disabled><i class="fas fa-trash-can"></i>
                                    Delete
                                </button>
                                <?php }elseif($status == "40"){ ?> 
                                <button class="btn btn-default btn-sm btn_edit" id="<?php echo $data['id_po_detail']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                                    Edit
                                </button>
                                <button class="btn btn-default btn-sm btn_delete" id="<?php echo $data['id_po_detail']; ?>" disabled><i class="fas fa-trash-can"></i>
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
                <a class="btn btn-secondary" href="?page=exim_po_view"><i class="fas fa-backward"></i> Back</a>
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
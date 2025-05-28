
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>INVENTORY/Inventory per Item Mutation</b></a></li>
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
                <h3 class="card-title">Data Item Mutation</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Item</th>
                    <th>Unit</th>
                    <th>Date</th>
                    <th>Receipt</th>
                    <th>Issued</th>
                    <th>Balance</th>
                    <th>Purchase Order No</th>
                    <th>Sales Order No</th>
                    <th>Production Order No</th>
                    <th>Adjustment Order No</th>
                    <th>Scrap No</th>
                    <th>Warehouse Order No</th>
                    <th>Batch</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php          
                        $saldo = 0;              
                        $sql2 = $koneksi->query("SELECT 
                                                g.item_code as item_code,
                                                g.item_desc as item_desc,
                                                b.trx_type_code as trx_type_code,
                                                c.order_type as order_type,
                                                a.id_order_type as id_order_type,
                                                d.purchase_order_no as purchase_order_no,
                                                e.sales_order_no as sales_order_no,
                                                l.prod_order_no as prod_order_no,
                                                m.adj_order_no as adj_order_no,
                                                n.scrap_no as scrap_no,
                                                k.datetime as datetime,
                                                k.actual_quantity as actual_quantity,
                                                j.unit as unit,
                                                a.wh_order_no as wh_order_no,
                                                k.batch as batch
                                                FROM
                                                itv_wh_header as a
                                                LEFT JOIN 
                                                itv_lnsw_masterdata_trxtypecode as b ON a.id_trx_type_code = b.id_trx_type_code
                                                LEFT JOIN
                                                itv_masterdata_order_type as c ON a.id_order_type = c.id_order_type
                                                LEFT JOIN
                                                itv_po_header as d ON a.id_order_header = d.id_po_header
                                                LEFT JOIN
                                                itv_so_header as e ON a.id_order_header = e.id_so_header
                                                LEFT JOIN
                                                itv_wh_detail as f ON a.id_wh_header = f.id_wh_header
                                                LEFT JOIN
                                                itv_masterdata_item as g ON f.id_item = g.id_item
                                                LEFT JOIN 
                                                itv_lnsw_masterdata_unitcode as j ON g.id_unit_code = j.id_unit_code
                                                LEFT JOIN 
                                                itv_wh_detail_root as k ON f.id_wh_detail = k.id_wh_detail
                                                LEFT JOIN 
                                                itv_prod_header as l ON a.id_order_header = l.id_prod_header
                                                LEFT JOIN
                                                itv_adj_header as m ON a.id_order_header = m.id_adj_header
                                                LEFT JOIN
                                                itv_scrap_header as n ON a.id_order_header = n.id_scrap_header
                                                WHERE a.isdelete = '1' AND f.id_item = '" . $_GET['kode'] . "'
                                                ORDER BY g.item_code, k.datetime, a.createddatetime ASC
                                                ");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $data['item_code']; ?> - <?php echo $data['item_desc']; ?></td>
                    <td><?php echo $data['unit']; ?></td>
                    <td><?php echo $data['datetime']; ?></td>  
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo $data['actual_quantity']; ?>
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo $data['actual_quantity']; ?> 
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo "-"; ?>  
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo "-"; ?>  
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo $data['actual_quantity']; ?>   
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo $data['actual_quantity']; ?>                  
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>   
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo $data['actual_quantity']; ?>   
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo $data['actual_quantity']; ?> 
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo "-"; ?>    
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo "-"; ?>                       
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>     
                    <td>
                    <?php 
                    $trx_type_code = $data['trx_type_code'];
                    if($trx_type_code == 'Adjustment'){
                      $receipt = $data['actual_quantity'];
                      $saldo = $saldo + $receipt;
                      echo $saldo;
                    }elseif($trx_type_code == 'Pemasukan'){
                      $receipt = $data['actual_quantity'];
                      $saldo = $saldo + $receipt;
                      echo $saldo;
                    }elseif($trx_type_code == 'Pengeluaran'){
                      $issue = $data['actual_quantity'];
                      $saldo = $saldo - $issue;
                      echo $saldo;
                    }
                    ?> 
                    </td>              
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo $data['purchase_order_no']; ?>
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo "-"; ?>       
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo "-"; ?>          
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td> 
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo $data['sales_order_no']; ?> 
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo "-"; ?>    
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo "-"; ?>            
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo "-"; ?>
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo $data['prod_order_no']; ?>  
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo $data['prod_order_no']; ?>  
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo "-"; ?>             
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo "-"; ?>
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo $data['adj_order_no']; ?>              
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo "-"; ?>
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php $id_order_type = $data['id_order_type']; ?>
                        <?php if($id_order_type == "110"){?>
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "120"){ ?>  
                        <?php echo "-"; ?> 
                        <?php }elseif($id_order_type == "130"){ ?>  
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "140"){ ?>  
                        <?php echo "-"; ?>
                        <?php }elseif($id_order_type == "999"){ ?>  
                        <?php echo "-"; ?>          
                        <?php }elseif($id_order_type == "888"){ ?>  
                        <?php echo $data['scrap_no']; ?> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>
                    <td><?php echo $data['wh_order_no']; ?></td>
                    <td><?php echo $data['batch']; ?></td>  
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
        <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=inventory_per_item_view"><i class="fas fa-backward"></i> Back</a>
              </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
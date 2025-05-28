<?php

include "inc/koneksi.php";
include "inc/koneksi_wms.php";
if (isset($_GET['kode'])) {
    $sql_cek = $koneksi->query("SELECT *
                                FROM itv_beg_balance
                                WHERE id_beg_balance='" . $_GET['kode'] . "' AND isdelete='1'");  

    $data_cek =  $sql_cek->fetch_assoc(); 

}
?>
<!-- /template header -->
<?php include 'itv/itv_template_header.php' ?>
<!-- /template header -->  

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">IT Inventory</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Submit To LNSW>Beginning Balance>Beginning Balance Detail</b></a></li>
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
              <h3 class="card-title">Beginning Balance Detail</h3>
            </div>
                <div class="card-body">
                <form method="POST">
                <div class="modal-body">
              
                <div class="form-group">
                  <div class="row">         
                    <div class="col-md-2">
                      <label>Activity No</label>
                      <input type="text" class="form-control" placeholder="no_kegiatan" name="no_kegiatan" value=<?php echo $data_cek['no_kegiatan']; ?> disabled>
                    </div> 
                    <div class="col-md-2">
                        <label>Date Activity</label>
                        <textarea class="form-control" rows="1" placeholder="datetime_beg_balance" id="datetime_beg_balance" name="datetime_beg_balance" disabled><?php 
                                                                                                                 echo $data_cek['datetime_beg_balance']; ?></textarea>   
                    </div>         
                  </div> 
                  </br>
                  <div class="row"> 
                    <div class="col-md-2">
                      <label>Created By</label>
                      <input type="text" class="form-control" placeholder="Created By" name="createdby" value=<?php echo $data_cek['createdby']; ?> disabled>        
                    </div>  
                    <div class="col-md-2">
                    <label>Create Date</label>
                      <textarea class="form-control" rows="1" placeholder="CreatedDateTime" id="createddatetime" name="createddatetime" disabled><?php 
                                                                                                                 echo $data_cek['createddatetime']; ?></textarea>                                                                                                                    
                    </div>  
                  </div>
                  </br>
                  <div class="row">  
                    <div class="col-md-4">  
                        <label>Company</label>              
                            <textarea class="form-control" rows="1" placeholder="PT Maju Bersama Gemilang" id="company" name="company" disabled><?php echo 'PT Maju Bersama Gemilang'; ?></textarea>
                        <label>NPWP</label>
                            <input type="text" class="form-control" placeholder="NPWP" value=<?php echo $data_cek['npwp']; ?> disabled>      
                        <label>NIB</label>
                            <input type="text" class="form-control" placeholder="NIB" value=<?php echo $data_cek['nib']; ?> disabled>                
                      </div>                     
                    </div>          
                  </div>                 
                  </br>
                  <div class="row">  
                    <div class="col-12">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_bb_item"><i class="fas fa-plus-square"></i> Add Beginning Balance Item</button>
                    </div>
                  </div>
                  </br>
                  <div class="row"> 
                  <div class="col-12">
                      <div class="card">                 
                        <!-- /.card-header -->
                        <div class="card-body">
                        <div class="table-responsive">
                          <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                            <th>No</th>
                            <th>Item Category-LNSW</th>
                            <th>Item</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Unit-LNSW</th>
                            <th>Item Price</th>
                            <th>Total Price</th>
                            <th>Declare Date</th>                                                                                   
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                $sql = $koneksi->query("SELECT 
                                                        A.id_item_category_code as id_item_category_code,
                                                        B.item_category_code as item_category_code,                                                       
                                                        A.Matnr as Matnr,
                                                        A.Matnr_Name as Matnr_Name,
                                                        A.Quantity as Quantity,
                                                        A.id_unit_code as id_unit_code,
                                                        C.unit as unit,
                                                        A.price_item as price_item,
                                                        A.tot_price as tot_price,
                                                        A.declare_date as declare_date
                                                        FROM itv_beg_balance_detail as A
                                                        INNER JOIN itv_lnsw_masterdata_itemcategorycode as B ON A.id_item_category_code=B.id_item_category_code
                                                        INNER JOIN itv_lnsw_masterdata_unitcode as C ON A.id_unit_code=C.id_unit_code
                                                        WHERE 
                                                        A.isdelete = '1'
                                                        AND
                                                        A.id_beg_balance = '" . $_GET['kode'] . "' 
                                                        ORDER BY A.id_beg_balance_item ASC");
                                while ($data= $sql->fetch_assoc()) {
                            ?>
                            <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['id_item_category_code']; echo ' ('; echo $data['item_category_code']; echo ')';  ?></td>
                            <td><?php echo $data['Matnr']; ?></td>
                            <td><?php echo $data['Matnr_Name']; ?></td>
                            <td><?php echo $data['Quantity']; ?></td>
                            <td><?php echo $data['id_unit_code']; echo ' ('; echo $data['unit']; echo ')';  ?></td>
                            <td><?php echo $data['price_item']; ?></td>
                            <td><?php echo $data['tot_price']; ?></td>
                            <td><?php echo $data['declare_date']; ?></td>
                            </tr>  
                            <?php
                                }
                            ?>              
                            </tbody>
                          </table>
                        </div>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary" href="?page=beg_balance_view"><i class="fas fa-backward"></i> Back</a>
              </div>
            </form>
                </div>
          </div>
        </div>
      </div>
   </div>
</section>
<!-- /.Main content -->

<!------------------- Modal Add Beginning Balance Item ---------------------------------->
  
<div class="modal fade" id="modal_add_bb_item">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Beginning Balance Item</h4>
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
                            <label><h5>Item Category-LNSW</h5></label></br>
                            <select class="form-control custom-select" id="id_item_category_code" name="id_item_category_code">
                            <?php 
                              $itemcatcodeisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_itemcategorycode"); 
                              while($row = mysqli_fetch_array($itemcatcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_item_category_code]>$row[item_category_code]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="form-group"> 
                            <label><h5>Item</h5></label>                             
                            <select class="form-control custom-select" id="Modal_Matnr" name="Modal_Matnr">
                            <?php 
                              $itemisi = sqlsrv_query($koneksi_wms,"SELECT *
                                                                    FROM Material
                                                                    WHERE
                                                                    IsDelete = '0'
                                                                    ORDER BY Werks, Matnr ASC"); 
                              while($row= sqlsrv_fetch_array($itemisi,SQLSRV_FETCH_ASSOC)){                              
                                ?>
                                  <?php                                  
                                    echo "<option value='" . utf8_encode($row[Werks]) . "-" . utf8_encode($row[Matnr]) . "꩜" . utf8_encode($row[Name]) . "'>$row[Werks]-$row[Matnr]-" . utf8_encode($row[Name]) . "</option>";
                                  ?>     
                                       <?php } ?>    
                                  <input type="hidden" class="form-control" id="Werks_Matnr" name="Werks_Matnr"> 
                                  <textarea class="form-control" rows="3" id="Matnr_Name" name="Matnr_Name" hidden></textarea>                                     
                          </select>                                                                                                                                                                                                                                              
                          </div>     
                          <div class="form-group">
                            <label><h5>Quantity</h5></label>                           
                            <input type="number" class="form-control" id="Quantity" name="Quantity">
                          </div> 
                          <div class="form-group">
                            <label><h5>Unit-LNSW</h5></label></br>
                            <select class="form-control custom-select" id="id_unit_code" name="id_unit_code">
                            <?php 
                              $unitcodeisi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_unitcode"); 
                              while($row = mysqli_fetch_array($unitcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_unit_code]>$row[id_unit_code] $row[unit]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>  
                          <div class="form-group">
                           <label><h5>Currency</h5></label>
                              <select class="form-control custom-select" id="id_currency" name="id_currency">
                                <?php 
                                  $currencyisi = mysqli_query($koneksi, "select * from itv_masterdata_currency"); 
                                  while($row = mysqli_fetch_array($currencyisi)){?>
                                      <?php                                  
                                        echo "<option value=$row[id_currency]>($row[symbol])  $row[currency]</option>";
                                      ?>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="form-group">
                            <label><h5>Item Price</h5></label>                           
                            <input type="number" class="form-control" id="price_item" name="price_item">
                          </div>  
                          <div class="form-group"> 
                            <label><h5>Declare Date</h5><label><h6><i>*Note: Same with Date Activity</i></h6></label>                             
                            <input type="text" class="form-control" id="declare_date" name="declare_date" value="<?php echo $data_cek['datetime_beg_balance']; ?>" disabled>                         
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
            <button type="button" class="btn btn-success" id="btn_save_bb_item" name="<?php echo $data_cek['id_beg_balance']; ?>">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add Beginning Balance Item<END> ---------------------------------->    

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
    $("#Modal_Matnr").on("change",function() {
    var val = this.value.split('꩜');
    $("#Werks_Matnr").val(val[0]);
    $("#Matnr_Name").val(val[1]);
    }).change();

    /* ======================= Add Begining Balance Item ========================= */
    $(document).ready(function(){
            $('#btn_save_bb_item').on('click', function(e){
              e.preventDefault();
            var id_beg_balance = $(this).attr('name');;
            var id_item_category_code = $('#id_item_category_code').find(":selected").val();
            var Matnr = $('#Werks_Matnr').val();
            var Matnr_Name = $('#Matnr_Name').val(); 
            var Quantity = $('#Quantity').val();
            var id_unit_code = $('#id_unit_code').find(":selected").val();  
            var id_currency = $('#id_currency').find(":selected").val();   
            var price_item = $('#price_item').val();    
            var declare_date = $('#declare_date').val();     

            $.ajax({
              url : "itv/administrator/submit_lnsw/beginning_balance/beg_balance_detail_controller.php",
              type : "POST",
              data : {
                id_beg_balance : id_beg_balance, 
                id_item_category_code : id_item_category_code, 
                Matnr : Matnr, 
                Matnr_Name : Matnr_Name ,
                Quantity : Quantity,
                id_unit_code : id_unit_code,
                id_currency : id_currency,
                price_item : price_item,
                declare_date : declare_date
              },
              success : function(response){
                console.log(response);
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#id_item_category_code').val("");
                $('#Matnr').val("");
                $('#Matnr_Name').val("");
                $('#Quantity').val("");
                $('#id_unit_code').val("");
                $('#id_currency').val("");
                $('#price_item').val("");
                $('#declare_date').val("");
                $('#modal_add_bb_item').modal("hide");
                setInterval('location.reload()',1500);
              }
            });
          });
        });
    /* ======================== <END> Add Begining Balance Item <END> ===================== */


</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->
<?php

include "inc/koneksi.php";
include "inc/koneksi_wms.php";

?>
<!-- /template header -->
<?php include 'itv/itv_template_header.php' ?>
<!-- /.template header -->

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">IT Inventory</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a class='h10'>IT Inventory Active menu - <b>Submit To LNSW>Beginning Balance</b></a></li>
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
        <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">BEGINNING BALANCE</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">LNSW</a>
                  </li>
                </ul>
              </div>
              <!-- Card Body --> 
              <div class="card-body">  
                <!-- Tab -->             
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <!-- Tab BB -->
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                  <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Beginning Balance Data</h3>
                          <div class="col-12">
                          <?php 
                                        $sql_tot_bb = $koneksi->query("SELECT *
                                                                 FROM itv_total_beg_balance");                                                                                  
                                        $data_tot_bb= $sql_tot_bb->fetch_assoc();    
                                        $tot_bb = $data_tot_bb['total'];                                                                                                                                                 
                                        if ($tot_bb == '1') 
                                        { ?>                                         
                                          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_bb" disabled><i class="fas fa-plus-square"></i> Add Beginning Balance</button>
                                            <?php
                                        }
                                        else 
                                        {   ?> 
                                          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_bb"><i class="fas fa-plus-square"></i> Add Beginning Balance</button>
                                            <?php
                                        }
                                        
                                            ?>    
                          </div>  
                        </div>
                          <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>Activity No</th>
                                  <th>Date Activity</th> 
                                  <th>Company</th>                                            
                                  <th>NPWP</th>
                                  <th>NIB</th> 
                                  <th>Total Item</th> 
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php                     
                                  $sql = $koneksi->query("SELECT
                                                          A.id_beg_balance as id,
                                                          A.no_kegiatan as no_kegiatan,
                                                          A.datetime_beg_balance as tgl_kegiatan,
                                                          A.npwp as npwp,
                                                          A.nib as nib 
                                                          FROM
                                                          itv_beg_balance as A
                                                          WHERE 
                                                          A.isdelete = 1
                                                          AND
                                                          A.submit_status = 1
                                                          ORDER BY A.no_kegiatan,A.datetime_beg_balance																																													
																					                ");                                 
                                  while ($data= $sql->fetch_assoc()) {
                                ?>
                                  <tr> 
                                    <td><?php echo $data['no_kegiatan']; ?></td>                                       
                                    <td><?php echo $data['tgl_kegiatan']; ?></td> 
                                    <td>PT Maju Bersama Gemilang</td>                                               
                                    <td><?php echo $data['npwp']; ?></td>                                                     
                                    <td><?php echo $data['nib']; ?></td>   
                                    <td>
                                        <?php 
                                            $sql2 = $koneksi->query("SELECT IFNULL( (SELECT COUNT(A.id_beg_balance)
                                                                    FROM itv_beg_balance_detail as A                                                                                                                          
                                                                    WHERE A.id_beg_balance='$data[id]'),'0')");                                                                                  
                                            while ($data2= $sql2->fetch_row()) {   
                                            $row_cnt = $data2[0];                                                                                                                                                       
                                            if ($row_cnt == '0') 
                                            { ?>                                         
                                              0
                                                <?php
                                            }
                                            else 
                                            {   
                                              echo $row_cnt;
                                                ?>                                                
                                                <?php
                                            }
                                            } 
                                                ?>
                                    </td>  
                                    <td>
                                        <a class="btn btn-default btn-sm" href="?page=beg_balance_detail_view&kode=<?php echo $data['id']; ?>">
                                                    <i class="fas fa-search"></i>
                                                    Detail
                                        </a>
                                        <?php 
                                        $sql2 = $koneksi->query("SELECT IFNULL( (SELECT DISTINCT A.id_beg_balance
                                                                 FROM itv_beg_balance_detail as A                                                                                                                          
                                                                 WHERE A.id_beg_balance='$data[id]'),'1')");                                                                                  
                                        while ($data2= $sql2->fetch_row()) {   
                                        $row_cnt = $data2[0];                                                                                                            
                                        if ($row_cnt == '1') 
                                        { ?>                                         
                                          <button class="btn btn-primary btn-sm btn_submit" id="<?php echo $data['id']; ?>" disabled><i class="fa fa-paper-plane"></i>
                                          Submit
                                          </button>
                                            <?php
                                        }
                                        else 
                                        {   ?> 
                                          <button class="btn btn-primary btn-sm btn_submit" id="<?php echo $data['id']; ?>" onclick="return confirm('Do you really want to submit ?')"><i class="fa fa-paper-plane"></i>
                                          Submit
                                          </button>
                                            <?php
                                        }
                                        } 
                                            ?>
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
                  <!-- /.Tab BB -->
                  <!-- Tab LNSW -->
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                  <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Beginning Balance LNSW Data</h3>
                        </div>
                          <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>Activity No</th>
                                  <th>Date Activity</th> 
                                  <th>Company</th>                                            
                                  <th>NPWP</th>
                                  <th>NIB</th> 
                                  <th>Total Item</th> 
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php                     
                                  $sql = $koneksi->query("SELECT
                                                          A.id_beg_balance as id,
                                                          A.no_kegiatan as no_kegiatan,
                                                          A.datetime_beg_balance as tgl_kegiatan,
                                                          A.npwp as npwp,
                                                          A.nib as nib 
                                                          FROM
                                                          itv_beg_balance as A
                                                          WHERE 
                                                          A.isdelete = 1
                                                          AND
                                                          A.submit_status = 2
                                                          ORDER BY A.no_kegiatan,A.datetime_beg_balance																																													
																					                ");                                 
                                  while ($data= $sql->fetch_assoc()) {
                                ?>
                                  <tr> 
                                    <td><?php echo $data['no_kegiatan']; ?></td>                                       
                                    <td><?php echo $data['tgl_kegiatan']; ?></td> 
                                    <td>PT Maju Bersama Gemilang</td>                                               
                                    <td><?php echo $data['npwp']; ?></td>                                                     
                                    <td><?php echo $data['nib']; ?></td>   
                                    <td>
                                        <?php 
                                            $sql2 = $koneksi->query("SELECT IFNULL( (SELECT COUNT(A.id_beg_balance)
                                                                    FROM itv_beg_balance_detail as A                                                                                                                          
                                                                    WHERE A.id_beg_balance='$data[id]'),'0')");                                                                                  
                                            while ($data2= $sql2->fetch_row()) {   
                                            $row_cnt = $data2[0];                                                                                                                                                       
                                            if ($row_cnt == '0') 
                                            { ?>                                         
                                              0
                                                <?php
                                            }
                                            else 
                                            {   
                                              echo $row_cnt;
                                                ?>                                                
                                                <?php
                                            }
                                            } 
                                                ?>
                                    </td>  
                                    <td>
                                        <a class="btn btn-default btn-sm" href="?page=beg_balance_detail_view_blocked&kode=<?php echo $data['id']; ?>">
                                                    <i class="fas fa-search"></i>
                                                    Detail
                                        </a>    
                                        
                                        <?php 
                                        $sql_final = $koneksi->query("SELECT finalisasi_status
                                                                 FROM itv_beg_balance                                                                                                                        
                                                                 WHERE id_beg_balance='$data[id]'");                                                                                  
                                        while ($data_final= $sql_final->fetch_assoc()) {   
                                        $final_flag = $data_final['finalisasi_status'];                                                                                                            
                                        if ($final_flag == '1') 
                                        { ?>                                         
                                          <button class="btn btn-primary btn-sm btn_finalize" id="<?php echo $data['id']; ?>" onclick="return confirm('Do you really want to finalize ?')"><i class="fa fa-check"></i>
                                          Finalization
                                          </button>
                                            <?php
                                        }
                                        else 
                                        {   ?> 
                                          <button class="btn btn-primary btn-sm btn_finalize" id="<?php echo $data['id']; ?>" onclick="return confirm('Do you really want to finalize ?')" disabled><i class="fa fa-check"></i>
                                          Finalization
                                          </button> 
                                            <?php
                                        }
                                        } 
                                            ?>                                                                
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
                    <!-- /.Tab LNSW -->
                  </div>
                  <!-- /.Tab -->
                </div>
                <!-- /.Card Body -->
              </div>
            </div>
          </div>
        </div>
</section>
<!-- /.Main content -->

<!------------------- Modal Add Beginning Balance ---------------------------------->
  
<div class="modal fade" id="modal_add_bb">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Beginning Balance</h4>
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
                            <label><h5>Activity No</h5></label>                           
                            <input type="text" class="form-control" id="no_kegiatan" name="no_kegiatan">                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Date Activity</h5></label>                             
                            <input type="datetime-local" class="form-control" id="datetime_beg_balance" name="datetime_beg_balance">                         
                          </div>  
                          <div class="form-group">   
                            <label><h5>Company</h5></label>                        
                            <textarea class="form-control" rows="3" placeholder="PT Maju Bersama Gemilang" id="company" name="company" value="PT Maju Bersama Gemilang"disabled></textarea>                         
                          </div>      
                          <div class="form-group">
                            <label><h5>NPWP</h5></label>                           
                            <input type="text" class="form-control" id="npwp" name="npwp" value="031339922063000" disabled>
                          </div>
                          <div class="form-group">
                           <label><h5>NIB</h5></label>
                           <input type="text" class="form-control" id="nib" name="nib" value="8120218022499" disabled>
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
            <button type="button" class="btn btn-success" id="btn_add_bb">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add Beginning Balance<END> ---------------------------------->    

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add Beginning Balance ========================= */
          $(document).ready(function(){
            $('#btn_add_bb').on('click', function(){
            var no_kegiatan = $('#no_kegiatan').val();
            var datetime_beg_balance = $('#datetime_beg_balance').val();
            var npwp = $('#npwp').val();
            var nib = $('#nib').val();         

            $.ajax({
              url : "itv/administrator/submit_lnsw/beginning_balance/beg_balance_controller.php",
              type : "POST",
              data : {
                no_kegiatan : no_kegiatan, 
                datetime_beg_balance : datetime_beg_balance, 
                npwp : npwp, 
                nib : nib               
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#no_kegiatan').val("");
                $('#datetime_beg_balance').val("");
                $('#npwp').val("");
                $('#nib').val("");
                $('#modal_add_bb').modal("hide");
                setInterval('location.reload()',1500);
              }
            });
          });
        });
        /* ======================== <END> Add Beginning Balance <END> ===================== */

        /* ========================  Submit BB Data To LNSW  ===================== */
        $('#example2').on('click','.btn_submit', function(){
          var id_beg_balance = $(this).attr('id');   

          $.ajax({
            url : "itv/administrator/submit_lnsw/beginning_balance/beg_balance_controller.php",
            type : 'POST',
            data : {id_beg_balance_API : id_beg_balance                              
            },
            success : function(response){
              console.log(response)
              if(response == "1"){
                Swal.fire("Data submited succesfully",'','success');
              } else {
                Swal.fire("Submit data failed",'','error')
              }
              setInterval('location.reload()',1500);
            }
          });
        });
        /* ======================== <END> Submit BB Data To LNSW <END> ===================== */

        /* ========================  Finalize BB Data To LNSW  ===================== */
          $('#example1').on('click','.btn_finalize', function(){
          var id_beg_balance = $(this).attr('id');   

          $.ajax({
            url : "itv/administrator/submit_lnsw/beginning_balance/beg_balance_controller.php",
            type : 'POST',
            data : {id_beg_balance_API_Final : id_beg_balance                              
            },
            success : function(response){
              console.log(response)
              if(response == "1"){
                Swal.fire("Data finalize succesfully",'','success');
              } else {
                Swal.fire("Finalize data failed",'','error')
              }
              setInterval('location.reload()',1500);
            }
          });
        });
        /* ======================== <END> Finalize BB Data To LNSW <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>MASTER DATA/Business Partner</b></a></li>
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
                <h3 class="card-title">Data Business Partner</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_bp"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Business Partner Code</th>
                    <th>Business Partner Name</th>
                    <th>Business Partner Type</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM itv_masterdata_bp WHERE isdelete = '1' 
                                                order by id_bp asc");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $no++; ?></td>
                    <td><?php echo $data['bp_code']; ?></td>
                    <td><?php echo $data['bp_name']; ?></td>
                    <td>
                        <?php $bp_type = $data['bp_type']; ?>
                        <?php if($bp_type == "10"){?>
                        <span class="badge bg-success">Customer</span>
                        <?php }elseif($bp_type == "20"){ ?>  
                        <span class="badge bg-warning">Supplier</span> 
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>  
                    <td>
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_bp']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_bp']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
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

    <!------------------- Modal Add BP ---------------------------------->
  
<div class="modal fade" id="modal_add_bp">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Business Partner</h4>
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
                            <label><h5>Business Partner Code</h5></label>                           
                            <input type="text" class="form-control" placeholder="CS0001 or SP0001" id="bp_code" name="bp_code" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Business Partner Name</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="PT. xxx or CV. xxx or anything else" id="bp_name" name="bp_name" required></textarea>                       
                          </div>  
                          <div class="form-group">
                            <label><h5>Business Partner Type</h5></label>
                            <select class="form-control custom-select" id="bp_type" name="bp_type">
                            <?php 
                              $unitcodeisi = mysqli_query($koneksi, "select * from itv_masterdata_bptype"); 
                              while($row = mysqli_fetch_array($unitcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[bp_type]>$row[bp_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>   
                          <div class="form-group"> 
                            <label><h5>City</h5></label>                             
                            <input type="text" class="form-control" placeholder="Jakarta or Bandung or Surabaya or anything else" id="bp_city" name="bp_city" required>                       
                          </div>        
                          <div class="form-group"> 
                            <label><h5>Address</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="Jl. Komisaris Bambang..." id="bp_address" name="bp_address" required></textarea>                       
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
            <button type="button" class="btn btn-success" id="btn_add_bp">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add BP<END> ---------------------------------->   

<!------------------- Modal Edit BP ---------------------------------->
<div class="modal fade" id="bp_edit_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Business Partner</h4>
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
                          <input type="hidden" class="form-control" id="id_bp_edit" name="id_bp_edit">
                          <div class="form-group"> 
                            <label><h5>Business Partner Code</h5></label>                           
                            <input type="text" class="form-control" placeholder="CS0001 or SP0001" id="bp_code_edit" name="bp_code_edit" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Business Partner Name</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="PT. xxx or CV. xxx or anything else" id="bp_name_edit" name="bp_name_edit" required></textarea>                       
                          </div>  
                          <div class="form-group">
                            <label><h5>Business Partner Type</h5></label>
                            <select class="form-control custom-select" id="bp_type_edit" name="bp_type_edit">
                            <?php 
                              $unitcodeisi = mysqli_query($koneksi, "select * from itv_masterdata_bptype"); 
                              while($row = mysqli_fetch_array($unitcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[bp_type]>$row[bp_desc]</option>";
                                  ?>
                            <?php } ?>
                          </select>
                          </div>   
                          <div class="form-group"> 
                            <label><h5>City</h5></label>                             
                            <input type="text" class="form-control" placeholder="Jakarta or Bandung or Surabaya or anything else" id="bp_city_edit" name="bp_city_edit" required>                       
                          </div>        
                          <div class="form-group"> 
                            <label><h5>Address</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="Jl. Komisaris Bambang..." id="bp_address_edit" name="bp_address_edit" required></textarea>                       
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
                        <button type="button" class="btn btn-success" id="btn_bp_update">Update</button>
                      </div>
                    
                    </form>
                </div>
              </div>
            </div>
          </div>
				</div>
			</div>
		</div>
	</div>
  <!------------------- <END>Modal Edit BP<END> ---------------------------------->

  <!----------------------- Modal Delete BP-------------------------------------->
       <div class="modal fade" id="bp_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Business Partner</h4>
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
  <!----------------------- <END>Modal Delete BP<END>---------------------------->

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add BP ========================= */
          $(document).ready(function(){
            $('#btn_add_bp').on('click', function(){
            var bp_code = $('#bp_code').val();
            var bp_name = $('#bp_name').val();
            var bp_type = $('#bp_type').find(":selected").val(); 
            var bp_city = $('#bp_city').val();   
            var bp_address = $('#bp_address').val();      

            $.ajax({
              url : "sash/administrator/business_partner/bp_controller.php",
              type : "POST",
              data : {
                bp_code : bp_code, 
                bp_name : bp_name, 
                bp_type : bp_type,
                bp_city : bp_city,
                bp_address : bp_address              
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#bp_code').val("");
                $('#bp_name').val("");
                $('#bp_type').val("");
                $('#bp_city').val("");
                $('#bp_address').val("");
                $('#modal_add_bp').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add BP <END> ===================== */

        /* ======================= Menampilkan edit modal BP ======================= */
      $('#example1').on('click','.btn_edit', function(){
        let id_bp_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/business_partner/bp_controller.php",
          type : 'POST',
          data : {id_bp_edit : id_bp_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#bp_edit_modal").modal("show");
            $('#id_bp_edit').val(response.id_bp);
            $('#bp_code_edit').val(response.bp_code);
            $('#bp_name_edit').val(response.bp_name);
            $('#bp_city_edit').val(response.bp_city);
            $('#bp_address_edit').val(response.bp_address);
            $('#bp_type_edit').val(response.bp_type).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal BP <END> ==================== */

      /* ======================= Mengupdate BP ======================= */
            $('#btn_bp_update').on('click', function(e){
				e.preventDefault();
				let id_bp = $('#id_bp_edit').val();
				let bp_code = $('#bp_code_edit').val();
				let bp_name = $('#bp_name_edit').val();
				let bp_type = $('#bp_type_edit').find(":selected").val(); 
                let bp_city = $('#bp_city_edit').val(); 
                let bp_address = $('#bp_address_edit').val(); 

				$.ajax({
					url : "sash/administrator/business_partner/bp_controller.php",
					type : 'POST',
					data : {id_bp_update : id_bp, 
                                    bp_code_update : bp_code,
									bp_name_update : bp_name,
									bp_type_update : bp_type,
                                    bp_city_update : bp_city,
                                    bp_address_update : bp_address,
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

			$('#id_bp_edit').val();
            $('#bp_code_edit').val("");
            $('#bp_name_edit').val("");
            $('#bp_type_edit').val("");
            $('#bp_city_edit').val("");
            $('#bp_address_edit').val("");
            $('#bp_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate BP <END> ======================= */

     /* =========================== Delete BP ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_bp = $(this).attr('id');
        $('#bp_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/business_partner/bp_controller.php",
            type : 'POST',
            data : {id_bp_delete : id_bp},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#bp_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete BP <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


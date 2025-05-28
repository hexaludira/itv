<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>SYSTEM/Manage User</b></a></li>
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
                <h3 class="card-title">Data User</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_user"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM user WHERE isdelete = '1' 
                                                order by id_user asc");
                        while ($data= $sql->fetch_assoc()) {
                    ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $no++; ?></td>
                    <td><?php echo $data['username']; ?></td>
                    <td style="text-align:center;"><a class="h10"><?php echo $data['email']; ?></a></td>
                    <td>
                        <?php $level = $data['id_level']; ?>
                        <?php if($level == "1"){?>
                        <span class="badge bg-primary">Administrator</span>
                        <?php }elseif($level == "2"){ ?>  
                        <span class="badge bg-secondary">Exim PO</span> 
                        <?php }elseif($level == "3"){ ?>  
                        <span class="badge bg-secondary">Exim SO</span> 
                        <?php }elseif($level == "4"){ ?>  
                        <span class="badge bg-secondary">Purchase</span> 
                        <?php }elseif($level == "5"){ ?>  
                        <span class="badge bg-secondary">Sales</span> 
                        <?php }elseif($level == "6"){ ?>  
                        <span class="badge bg-secondary">Production</span> 
                        <?php }elseif($level == "7"){ ?>  
                        <span class="badge bg-secondary">Warehouse</span> 
                        <?php }elseif($level == "8"){ ?>  
                        <span class="badge bg-secondary">Custom</span> 
                        <?php }elseif($level == "9"){ ?>  
                        <span class="badge bg-secondary">Super Admin</span>
                        <?php }elseif($level == "10"){ ?>  
                        <span class="badge bg-secondary">Production & Warehouse</span>  
                        <?php }else{ ?>
                        <span class="badge bg-danger">Error</span>
                        <?php } ?>
                    </td>  
                    <td>
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_user']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_user']; ?>"><i class="fas fa-trash-can"></i>
                              Delete
                        </button>
                        <button class="btn btn-dark btn-sm btn_reset" id="<?php echo $data['id_user']; ?>"><i class="fas fa-registered"></i>                             
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

<!------------------- Modal Add User ---------------------------------->
  
<div class="modal fade" id="modal_add_user">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add User</h4>
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
                            <label><h5>Username</h5></label>                           
                            <input type="text" class="form-control" placeholder="username" id="username" name="username" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Email</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="someone@mbgfiber.com" id="email" name="email" required></textarea>                       
                          </div>  
                          <div class="form-group">
                            <label><h5>Level</h5></label>
                            <select class="form-control custom-select" id="id_level" name="id_level">
                            <?php 
                              $unitcodeisi = mysqli_query($koneksi, "select * from level_user"); 
                              while($row = mysqli_fetch_array($unitcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_level]>$row[level]</option>";
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
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_user">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>

<!------------------- <END>Modal Add User<END> ---------------------------------->   
  
<!------------------- Modal Edit User ---------------------------------->
<div class="modal fade" id="user_edit_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit User</h4>
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
                          <input type="hidden" class="form-control" id="user_id_edit" name="user_id_edit">
                            <label><h5>Username</h5></label>                           
                            <input type="text" class="form-control" placeholder="username" id="username_edit" name="username_edit" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>Email</h5></label>                             
                            <textarea class="form-control" rows="2" placeholder="someone@mbgfiber.com" id="email_edit" name="email_edit" required></textarea>                       
                          </div>  
                          <div class="form-group">
                            <label><h5>Level</h5></label>
                            <select class="form-control custom-select" id="id_level_edit" name="id_level_edit">
                            <?php 
                              $unitcodeisi = mysqli_query($koneksi, "select * from level_user"); 
                              while($row = mysqli_fetch_array($unitcodeisi)){?>
                                  <?php                                  
                                    echo "<option value=$row[id_level]>$row[level]</option>";
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
        </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btn_user_update">Update</button>
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
  <!------------------- <END>Modal Edit User<END> ---------------------------------->

  	<!----------------------- Modal Delete user-------------------------------------->
    <div class="modal fade" id="user_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete User</h4>
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
  <!----------------------- <END>Modal Delete user<END>---------------------------->

    <!----------------------- Modal reset user-------------------------------------->
      <div class="modal fade" id="user_reset_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Reset User Password</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Reset user password?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_reset">Reset</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal reset user<END>---------------------------->


<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add User ========================= */
          $(document).ready(function(){
            $('#btn_add_user').on('click', function(){
            var username = $('#username').val();
            var email = $('#email').val();
            var id_level = $('#id_level').find(":selected").val();       

            $.ajax({
              url : "sash/administrator/user/user_controller.php",
              type : "POST",
              data : {
                username : username, 
                email : email, 
                id_level : id_level              
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#username').val("");
                $('#email').val("");
                $('#id_level').val("");
                $('#modal_add_bb').modal("hide");
                setInterval('location.reload()',1500);
              }
            });
          });
        });
        /* ======================== <END> Add User <END> ===================== */

        /* ======================= Menampilkan edit modal user ======================= */
      $('#example1').on('click','.btn_edit', function(){
        let user_edit_id = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/user/user_controller.php",
          type : 'POST',
          data : {user_edit_id : user_edit_id},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#user_edit_modal").modal("show");
            $('#user_id_edit').val(response.id_user);
            $('#username_edit').val(response.username);
            $('#email_edit').val(response.email);
            $('#id_level_edit').val(response.id_level).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal user <END> ==================== */

      /* ======================= Mengupdate user ======================= */
      $('#btn_user_update').on('click', function(e){
				e.preventDefault();
				let id_user = $('#user_id_edit').val();
				let username = $('#username_edit').val();
				let email = $('#email_edit').val();
				let id_level = $('#id_level_edit').find(":selected").val();  

				$.ajax({
					url : "sash/administrator/user/user_controller.php",
					type : 'POST',
					data : {id_user_update : id_user, 
                  username_update : username,
									email_update : email,
									id_level_update : id_level
								},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

						$('#user_id_edit').val();
            $('#username_edit').val("");
            $('#email_edit').val("");
            $('#id_level_edit').val("");
            $('#user_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate user <END> ======================= */

      /* =========================== Delete user ========================= */
			 $('#example1').on('click','.btn_delete', function(){
        let id_user = $(this).attr('id');
        $('#user_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/user/user_controller.php",
            type : 'POST',
            data : {id_user_delete : id_user},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#user_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete user <END> ===================== */

      /* =========================== Reset user ========================= */
			 $('#example1').on('click','.btn_reset', function(){
        let id_user = $(this).attr('id');
        $('#user_reset_modal').modal('show');
        $('#btn_confirm_reset').on('click', function(){
          $.ajax({
            url : "sash/administrator/user/user_controller.php",
            type : 'POST',
            data : {id_user_reset : id_user},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been reset",'','success');
              } else {
                Swal.fire("Data failed to reset",'','error');
              }
              $('#user_reset_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Reset user <END> ===================== */
</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->

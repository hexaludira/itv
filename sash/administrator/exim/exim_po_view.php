<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">IT Inventory Gen 2.0</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a class='h10'>Active menu/<b>EXIM/KEK Document PO</b></a></li>
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
                <h3 class="card-title">Data KEK Document PO</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_add_exim_po"><i class="fas fa-plus-square"></i> Add</button>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>KEK Document No</th>
                    <th>Document Date</th>
                    <th>Document Type</th>
                    <th>Purchase Order No</th>
                    <th>Created By</th>
                    <th>Created Date Time</th>
                    <th>Last Updated By</th>
                    <th>Last Updated Time</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                        $no = 1;
                        $sql2 = $koneksi->query("SELECT 
                                                a.id_exim_po as id_exim_po,
                                                a.id_po_header as id_po_header,
                                                a.no_dokumen as no_dokumen,
                                                a.tanggal_dokumen as tanggal_dokumen,
                                                a.id_doc_code as id_doc_code,
                                                b.document as document,
                                                a.createdby as createdby,
                                                a.createddatetime as createddatetime,
                                                a.lastupdatedby as lastupdatedby,
                                                a.lastupdateddatetime as lastupdateddatetime,
                                                c.purchase_order_no as purchase_order_no,
                                                c.purchase_order_internal_no as purchase_order_internal_no,
                                                a.total_link as total_link
                                                FROM itv_exim_po as a
                                                LEFT JOIN itv_lnsw_masterdata_documentcode as b ON a.id_doc_code = b.id_doc_code   
                                                LEFT JOIN itv_po_header as c ON a.id_po_header = c.id_po_header                                            
                                                WHERE a.isdelete = '1' 
                                                ORDER BY a.tanggal_dokumen ASC");
                        while ($data= $sql2->fetch_assoc()) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['no_dokumen']; ?></td>
                    <td><?php echo $data['tanggal_dokumen']; ?></td>
                    <td><?php echo $data['id_doc_code']; echo ' ~ '; echo $data['document']; ?></td>
                    <td><a href="?page=exim_po_detail_blocked_view&kode=<?php echo $data['id_po_header']; ?>"><u><?php echo $data['purchase_order_no']; echo ' - '; echo $data['purchase_order_internal_no']; ?></u></a></td> 
                    <td><?php echo $data['createdby']; ?></td>
                    <td><?php echo $data['createddatetime']; ?></td>
                    <td><?php echo $data['lastupdatedby']; ?></td>
                    <td><?php echo $data['lastupdateddatetime']; ?></td>
                    <td>
                        <?php $total_link = $data['total_link']; ?>
                        <?php if($total_link == "0"){?>
                        <button class="btn btn-default btn-sm btn_link" id="<?php echo $data['id_exim_po']; ?>"><i class="fas fa-link"></i>
                            Link to PO
                        </button>
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_exim_po']; ?>"><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_exim_po']; ?>"><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }elseif($total_link > "0"){ ?> 
                        <button class="btn btn-default btn-sm btn_unlink" id="<?php echo $data['id_exim_po']; ?>"><i class="fas fa-unlink"></i>
                            UnLink from PO
                        </button>
                        <button class="btn btn-info btn-sm btn_edit" id="<?php echo $data['id_exim_po']; ?>" disabled><i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn_delete" id="<?php echo $data['id_exim_po']; ?>" disabled><i class="fas fa-trash-can"></i>
                            Delete
                        </button>
                        <?php }?>
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

    <!------------------- Modal Add Exim PO ---------------------------------->
  
<div class="modal fade" id="modal_add_exim_po">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add KEK Document PO</h4>
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
                                <label><h5>Document Type</h5></label>
                                <select class="form-control custom-select" id="id_doc_code" name="id_doc_code">
                                <?php 
                                $id_doc_isi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_documentcode"); 
                                while($row = mysqli_fetch_array($id_doc_isi)){?>
                                    <?php                                  
                                        echo "<option value=$row[id_doc_code]>$row[id_doc_code] $row[document]</option>";
                                    ?>
                                <?php } ?>
                            </select>                    
                            </div>                       
                          <div class="form-group"> 
                            <label><h5>KEK Document No</h5></label>                           
                            <input type="text" class="form-control" placeholder="KEK Document No" id="no_dokumen" name="no_dokumen" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>KEK Document Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="" id="tanggal_dokumen" name="tanggal_dokumen" required>                         
                          </div>                                         
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_add_exim_po">Add</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>

<!------------------- <END>Modal Add Exim PO<END> ---------------------------------->   

<!------------------- Modal Edit Exim PO ---------------------------------->
<div class="modal fade" id="exim_po_edit_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit KEK Document PO</h4>
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
                                <label><h5>Document Type</h5></label>
                                <input type="hidden" class="form-control" placeholder="" id="id_exim_po_edit" name="id_exim_po_edit">
                                <select class="form-control custom-select" id="id_doc_code_edit" name="id_doc_code_edit">
                                <?php 
                                $id_doc_isi = mysqli_query($koneksi, "select * from itv_lnsw_masterdata_documentcode"); 
                                while($row = mysqli_fetch_array($id_doc_isi)){?>
                                    <?php                                  
                                        echo "<option value=$row[id_doc_code]>$row[id_doc_code] $row[document]</option>";
                                    ?>
                                <?php } ?>
                            </select>                    
                            </div>    
                            <div class="form-group"> 
                            <label><h5>KEK Document No</h5></label>                           
                            <input type="text" class="form-control" placeholder="KEK Document No" id="no_dokumen_edit" name="no_dokumen_edit" required>                         
                          </div>
                          <div class="form-group"> 
                            <label><h5>KEK Document Date</h5></label>                           
                            <input type="date" class="form-control" placeholder="" id="tanggal_dokumen_edit" name="tanggal_dokumen_edit" required>                         
                          </div>                                     
                      </div>                                                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
				  <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_exim_po_update">Update</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Edit Exim PO<END> ---------------------------------->

  <!----------------------- Modal Delete PO-------------------------------------->
  <div class="modal fade" id="exim_po_delete_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete KEK Document</h4>
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

  <!------------------- Modal Link Exim PO ---------------------------------->
<div class="modal fade" id="exim_po_link_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Link KEK Document To PO</h4>
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
                                <label><h5>Purchase Order</h5></label>
                                <input type="hidden" class="form-control" placeholder="" id="id_exim_po_link" name="id_exim_po_link">
                                <select class="form-control custom-select" id="id_po_header_link" name="id_po_header_link">
                                <?php 
                                $id_po_isi = mysqli_query($koneksi, "select * from itv_po_header join itv_masterdata_bp on itv_po_header.id_bp=itv_masterdata_bp.id_bp where itv_po_header.isdelete='1' and itv_po_header.status<>'10'"); 
                                while($row = mysqli_fetch_array($id_po_isi)){?>
                                    <?php                                  
                                        echo "<option value=$row[id_po_header]>$row[purchase_order_no] - $row[purchase_order_internal_no] - $row[bp_code] $row[bp_name]</option>";
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
            <button type="button" class="btn btn-success" id="btn_exim_po_link">Link</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
    <!------------------- <END>Modal Link Exim PO<END> ---------------------------------->

      <!----------------------- Modal Unlink Exim PO-------------------------------------->
  <div class="modal fade" id="exim_po_unlink_modal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Unlink KEK Document From PO</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <h4>Are you sure you want to un-link?</h4>
				</div>
				<div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_confirm_unlink">Unlink</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <!----------------------- <END>Modal Unlink Exim PO<END>---------------------------->

<!------------------------------ JavaScript --------------------------------------->
<script type="text/javascript">
  $('a[data-toggle="pill"]').on('shown.bs.tab',function(e){
  $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust()
         .responsive.recalc();
  });

          /* ======================= Add Exim PO ========================= */
          $(document).ready(function(){
            // e.preventDefault();
            $('#id_po_header_link').select2();
            $('#btn_add_exim_po').on('click', function(){
            var no_dokumen = $('#no_dokumen').val();
            var tanggal_dokumen = $('#tanggal_dokumen').val();
            var id_doc_code = $('#id_doc_code').find(":selected").val();      

            $.ajax({
              url : "sash/administrator/exim/exim_po_controller.php",
              type : "POST",
              data : {
                no_dokumen : no_dokumen, 
                tanggal_dokumen : tanggal_dokumen, 
                id_doc_code : id_doc_code            
              },
              success : function(response){
                if(response == "1"){
                  Swal.fire("Data added succesfully",'','success');
                } else {
                  Swal.fire("Adding Data Failed",'','error');
                }

                $('#no_dokumen').val("");
                $('#tanggal_dokumen').val("");
                $('#id_doc_code').val("");
                $('#modal_add_exim_po').modal("hide");
                setInterval('location.reload()',1300);
              }
            });
          });
        });
        /* ======================== <END> Add Exim PO <END> ===================== */

        /* ======================= Menampilkan edit modal Exim PO ======================= */
      $('#example1').on('click','.btn_edit', function(){
        //e.preventDefault();
        let id_exim_po_edit = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/exim/exim_po_controller.php",
          type : 'POST',
          data : {id_exim_po_edit : id_exim_po_edit},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#exim_po_edit_modal").modal("show");
            $('#id_exim_po_edit').val(response.id_exim_po);
            $('#no_dokumen_edit').val(response.no_dokumen);
            $('#tanggal_dokumen_edit').val(response.tanggal_dokumen);
            $('#id_doc_code_edit').val(response.id_doc_code).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan edit modal Exim PO <END> ==================== */

      /* ======================= Mengupdate Exim PO ======================= */
        $('#btn_exim_po_update').on('click', function(e){
				e.preventDefault();
				let id_exim_po = $('#id_exim_po_edit').val();
				let no_dokumen = $('#no_dokumen_edit').val();
				let tanggal_dokumen = $('#tanggal_dokumen_edit').val();
                let id_doc_code = $('#id_doc_code_edit').find(":selected").val(); 

				$.ajax({
					url : "sash/administrator/exim/exim_po_controller.php",
					type : 'POST',
					data : {id_exim_po_update : id_exim_po, 
                            no_dokumen_update : no_dokumen,
							tanggal_dokumen_update : tanggal_dokumen,
                            id_doc_code_update : id_doc_code
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data updated succesfully",'','success');
            } else {
              Swal.fire("Update data failed",'','error');
            }

			$('#id_exim_po_edit').val();
            $('#no_dokumen_edit').val("");
            $('#tanggal_dokumen_edit').val("");
            $('#id_doc_code_edit').val("");
            $('#exim_po_edit_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Mengupdate Exim PO <END> ======================= */

     /* =========================== Delete PO ========================= */
	    $('#example1').on('click','.btn_delete', function(){
        let id_exim_po_delete = $(this).attr('id');
        $('#exim_po_delete_modal').modal('show');
        $('#btn_confirm_delete').on('click', function(){
          $.ajax({
            url : "sash/administrator/exim/exim_po_controller.php",
            type : 'POST',
            data : {id_exim_po_delete : id_exim_po_delete},
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been deleted",'','success');
              } else {
                Swal.fire("Data failed to delete",'','error');
              }
              $('#exim_po_delete_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Delete PO <END> ===================== */

     /* ======================= Menampilkan Link modal Exim PO ======================= */
        $('#example1').on('click','.btn_link', function(){
        //e.preventDefault();
        let id_exim_po_link = $(this).attr('id');
        $.ajax({
          url : "sash/administrator/exim/exim_po_controller.php",
          type : 'POST',
          data : {id_exim_po_link : id_exim_po_link},
          dataType : 'json',
          success : function(response){
            console.log(response);
            $("#exim_po_link_modal").modal("show");
            $('#id_exim_po_link').val(response.id_exim_po);
            $('#total_link').val(response.total_link);
           // $('#id_po_header_link').val(response.id_po_header).trigger('change');
          }
        });
        //Swal.fire(edit_id);
      });
      /* ==================== <END> Menampilkan Link modal Exim PO <END> ==================== */

            /* ======================= Update Link Exim PO ======================= */
            $('#btn_exim_po_link').on('click', function(e){
				e.preventDefault();
				let id_exim_po = $('#id_exim_po_link').val();
        let total_link = $('#total_link').val();
				let id_po_header = $('#id_po_header_link').val();

				$.ajax({
					url : "sash/administrator/exim/exim_po_controller.php",
					type : 'POST',
					data : {id_exim_po_update_link : id_exim_po, 
                            id_po_header_update_link : id_po_header,
                            total_link : total_link
							},
					success : function(response){
						console.log(response);
            if(response == "1"){
              Swal.fire("Data linked succesfully",'','success');
            } else {
              Swal.fire("Linked data failed",'','error');
            }

			      $('#id_exim_po_link').val();
            $('#id_po_header_link').val("");
            $('#exim_po_link_modal').modal("hide");
            setInterval('location.reload()',1300);

					}
				});
			});     
      /* ======================= <END> Update Link Exim PO <END> ======================= */

           /* =========================== Unlink Exim PO ========================= */
	    $('#example1').on('click','.btn_unlink', function(){
        let id_exim_po_unlink = $(this).attr('id');
        $('#exim_po_unlink_modal').modal('show');
        $('#btn_confirm_unlink').on('click', function(){
          $.ajax({
            url : "sash/administrator/exim/exim_po_controller.php",
            type : 'POST',
            data : {id_exim_po_unlink : id_exim_po_unlink
            },
            success : function(response){
              if(response == "1"){
                Swal.fire("Data has been unlinked",'','success');
              } else {
                Swal.fire("Data failed to unlinked",'','error');
              }
              $('#exim_po_unlink_modal').modal('hide');
              setInterval('location.reload()',1300);
            }
          });
        });
      });
      /* ======================== <END> Unlink Exim PO <END> ===================== */

</script>
<!------------------------------ <END> JavaScript <END> --------------------------------------->


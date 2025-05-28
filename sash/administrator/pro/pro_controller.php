<?php
    include $_SERVER['DOCUMENT_ROOT'].'/inc/koneksi.php'; //$_SERVER['DOCUMENT_ROOT'] = xampp/htdocs

    date_default_timezone_set('Asia/Jakarta');
    session_start();
    if (isset($_SESSION['ses_nama']) == "") {
      header("location: login.php");
    } else {
      $data_id = $_SESSION["ses_id"];
      $data_email = $_SESSION["ses_username"];
      $data_nama = $_SESSION["ses_nama"];
      $data_level = $_SESSION["ses_level"];
    }

    //===================== Insert prod  =======================//
    if (isset($_POST["prod_order_no"])){
 
    $prod_order_no =  $_POST["prod_order_no"];
    $prod_order_internal_no =  $_POST["prod_order_internal_no"];
    $id_production =  $_POST["id_production"];
    $remark = $_POST['remark'];
    $id_item = $_POST['id_item'];
    $id_bom_header = $_POST['id_bom_header'];
    $quantity = $_POST['quantity'];
    $prod_date = $_POST["prod_date"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

    //=================== auto number untuk field prod_order_no pada table itv_prod_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(prod_order_no) as prod_order_no FROM itv_prod_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $autonumber = $data_autonumber['prod_order_no'];
    $urutan = (int) substr($autonumber, 6, 6);
    $urutan++;
    $huruf = "ITV-PP";
    $autonumber = $huruf . sprintf("%05s", $urutan);  
    //=================== <END> auto number untuk field prod_order_no pada table itv_prod_header <END> ======================//

    $sql2 = "INSERT INTO itv_prod_header (prod_order_no,prod_order_internal_no,id_production,prod_date,remark,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$autonumber',
                                '$prod_order_internal_no',
                                '$id_production',
                                '$prod_date',
                                '$remark',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10'
                                )";  
                                
    $query_simpan = mysqli_query($koneksi, $sql2);
    $last_id_prod_header = mysqli_insert_id($koneksi);

    $sql_trigger1 = "INSERT INTO itv_prod_detail_fg (id_prod_header,id_bom_header,id_item,quantity,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$last_id_prod_header',
                                '$id_bom_header',
                                '$id_item',
                                '$quantity',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10'
                                )"; 

    $query_trigger1 = mysqli_query($koneksi, $sql_trigger1);
    
    //=================== autofill material production_detail_rm sesuai bom ======================//
    $sql_query_get_bom = $koneksi->query("SELECT 
    a.id_bom_header as id_bom_header,
    a.quantity_finish_good as quantity_finish_good,
    b.id_bom_detail as id_bom_detail,
    b.id_item as id_item,
    b.quantity_material as quantity_material
    FROM itv_masterdata_bom_header as a
    LEFT JOIN itv_masterdata_bom_detail as b ON a.id_bom_header = b.id_bom_header
    WHERE 
    a.id_bom_header = '$id_bom_header' 
    AND
    b.isdelete = '1'
    ORDER BY b.id_bom_detail ASC");
    while ($data_bom= $sql_query_get_bom->fetch_assoc()) {
    $quantity = $_POST['quantity'];
    $factor = ($quantity/$data_bom['quantity_finish_good']);
    $materialx = ($factor*$data_bom['quantity_material']);
    $id_itemx = $data_bom['id_item'];
    $sql2 = "INSERT INTO itv_prod_detail_rm (id_prod_header,id_item,quantity,createddatetime,createdby,isdelete,status)                                                                     
                        VALUES (
                            '$last_id_prod_header',
                            '$id_itemx',
                            '$materialx',               
                            '$createddatetime',
                            '$createdby',
                            '1',
                            '10'
                            )";
    $query_simpanx = mysqli_query($koneksi, $sql2);  
    }

    //=================== <END> autofill material production_detail_rm sesuai bom <END> ======================//

    if ($query_simpan === TRUE){
          echo "1";
    } else {
          echo "2";
    }
    }
    //================ <END> insert prod <END>===============//

    //============================ Menampilkan pro ke Modal Edit  ================================//
    else if(isset($_POST["id_prod_header_edit"])){
    $id_prod_header = $_POST["id_prod_header_edit"];
    $sql = $koneksi->query("SELECT 
                            a.id_prod_header as id_prod_header,
                            a.prod_order_no as prod_order_no,
                            a.prod_order_internal_no as prod_order_internal_no,
                            a.id_production as id_production,
                            a.prod_date as prod_date,
                            a.remark as remark,
                            b.id_item as id_item,
                            b.id_bom_header as id_bom_header,
                            b.quantity as quantity
                            FROM itv_prod_header as a 
                            LEFT JOIN
                            itv_prod_detail_fg as b ON a.id_prod_header = b.id_prod_header
                            WHERE a.id_prod_header = $id_prod_header");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan pro ke Modal Edit <END> ==========================//

  //======================= Mengupdate pro dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_prod_header_update"])){
    $id_prod_header = $_POST["id_prod_header_update"];
    $prod_order_internal_no =  $_POST["prod_order_internal_no_update"];
    $id_production =  $_POST["id_production_update"];
    $prod_date = $_POST["prod_date_update"];
    $remark=  $_POST["remark_update"];
    $id_item=  $_POST["id_item_update"];
    $quantity=  $_POST["quantity_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_prod_header SET prod_order_internal_no = '$prod_order_internal_no', id_production = '$id_production', prod_date = '$prod_date', remark = '$remark', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_header = $id_prod_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);  
    
    $sql_trigger1 = "UPDATE itv_prod_detail_fg SET id_item = '$id_item', quantity = '$quantity' WHERE id_prod_header = $id_prod_header";

    $query_trigger1 = mysqli_query($koneksi, $sql_trigger1);
    
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate pro dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete pro ======================================//
    else if(isset($_POST["id_prod_header_delete"])){
    $id_prod_header = $_POST["id_prod_header_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_prod_header SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_header = $id_prod_header";
    $query_delete = mysqli_query($koneksi, $sql_delete); 

    $sql_trigger1 = "UPDATE itv_prod_detail_fg SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_header = $id_prod_header";
    $query_trigger1 = mysqli_query($koneksi, $sql_trigger1); 
    
    if ($query_delete === TRUE){
          echo "1";
    } else {
          echo "2";
    }
}
  //=========================== <END> Delete pro <END> ==================================//

  //============================== Released pro ======================================//
  else if(isset($_POST["id_prod_header_released"])){
    $id_prod_header = $_POST["id_prod_header_released"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_plan = "UPDATE itv_prod_header SET status = '30', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_header = $id_prod_header";
    $query_plan = mysqli_query($koneksi, $sql_plan); 

    if ($query_plan === TRUE){
      echo "1";
    } else { echo "2";}
}
  //=========================== <END> Release pro <END> ==================================//

  //============================== To be complete pro ======================================//
  else if(isset($_POST["id_prod_header_tobe_complete"])){
    $id_prod_header = $_POST["id_prod_header_tobe_complete"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    //=================== auto number untuk field wh_order_no pada table itv_wo_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(wh_order_no) as wh_order_no FROM itv_wh_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $autonumber = $data_autonumber['wh_order_no'];
    $urutan = (int) substr($autonumber, 6, 6);
    $urutan++;
    $huruf = "ITV-WO";
    $autonumber = $huruf . sprintf("%05s", $urutan);  
    //=================== <END> auto number untuk field wh_order_no pada table itv_wo_header <END> ======================//

    $sql_plan = "UPDATE itv_prod_header SET status = '60', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_header = $id_prod_header";
    $query_plan = mysqli_query($koneksi, $sql_plan); 

    $send_from1 = 'WH-MBG';
    $send_from2 = 'Company Warehouse';
    $send_to1 = 'PROD-MBG';
    $send_to2 = 'Company Production';

    $sql_plan_trigger2 = "INSERT INTO itv_wh_header (wh_order_no,wh_order_internal_no,id_trx_type_code,id_order_type,id_order_header,send_from,send_to,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$autonumber',
                                    '-',
                                    '31',
                                    '140',
                                    '$id_prod_header',
                                    '$send_from1 - $send_from2',
                                    '$send_to1 - $send_to2',
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '50'
                                    )";
    $query_plan_trigger2 = mysqli_query($koneksi, $sql_plan_trigger2);

    $sql_plan_trigger3 = "SELECT
                          a.id_wh_header as id_wh_header,
                          c.id_prod_detail_rm as id_order_detail,
                          c.id_item as id_item,
                          c.quantity as order_quantity,
                          c.actual_quantity as actual_quantity,
                          c.batch as batch
                          FROM itv_wh_header as a
                          LEFT JOIN itv_prod_header as b ON a.id_order_header = b.id_prod_header
                          LEFT JOIN itv_prod_detail_rm as c ON b.id_prod_header = c.id_prod_header
                          WHERE a.id_order_header = '$id_prod_header' AND a.id_trx_type_code = '31' AND a.id_order_type = '140'";
    $query_plan_trigger3 = mysqli_query($koneksi, $sql_plan_trigger3);
    while ($data_trigger3 = $query_plan_trigger3->fetch_assoc()) {
    $id_wh_header = $data_trigger3['id_wh_header'];
    $id_order_detail = $data_trigger3['id_order_detail'];
    $id_item = $data_trigger3['id_item'];
    $order_quantity = $data_trigger3['order_quantity'];
    $actual_quantity = $data_trigger3['actual_quantity'];
    $batch = $data_trigger3['batch'];

    $sql_plan_trigger4 = "INSERT INTO itv_wh_detail (id_wh_header,id_order_detail,id_item,order_quantity,createddatetime,createdby,isdelete)
                          VALUES (
                                    '$id_wh_header',
                                    '$id_order_detail',
                                    '$id_item',
                                    '$order_quantity',                        
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1'
                                    )";
    $query_plan_trigger4 = mysqli_query($koneksi, $sql_plan_trigger4);
    $last_id_wh_detail = mysqli_insert_id($koneksi);

    $sql_plan_trigger5 = "INSERT INTO itv_wh_detail_root (id_wh_detail,actual_quantity,datetime,batch,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$last_id_wh_detail',   
                                    '$actual_quantity', 
                                    '$createddatetime',
                                    '$batch',                                             
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '50'
                                    )";
    $query_plan_trigger5 = mysqli_query($koneksi, $sql_plan_trigger5);
    }

    if ($query_plan === TRUE){
      echo "1";
    } else { echo "2";}
}
  //=========================== <END> To be complete pro <END> ==================================//

  //============================ Menampilkan pro ke Modal complete  ================================//
else if(isset($_POST["id_prod_header_complete"])){
  $id_prod_header = $_POST["id_prod_header_complete"];
  $sql = $koneksi->query("SELECT 
                          a.id_prod_header as id_prod_header,
                          a.prod_order_no as prod_order_no,
                          a.prod_order_internal_no as prod_order_internal_no,
                          a.id_production as id_production,
                          a.prod_date as prod_date,
                          a.remark as remark,
                          b.id_item as id_item,
                          b.id_bom_header as id_bom_header,
                          b.quantity as quantity
                          FROM itv_prod_header as a 
                          LEFT JOIN
                          itv_prod_detail_fg as b ON a.id_prod_header = b.id_prod_header
                          WHERE a.id_prod_header = $id_prod_header");

  $data = $sql->fetch_assoc();

  //kirim kembali ke view
  echo json_encode($data);
}
//======================= <END> Menampilkan pro ke Modal complete <END> ==========================//

//======================= Mengupdate pro dari Modal complete (UPDATE) =======================//
else if (isset($_POST["id_prod_header_complete_update"])){
  $id_prod_header = $_POST["id_prod_header_complete_update"];
  $datetime = $_POST["datetime_complete_update"];
  $actual_quantity=  $_POST["actual_quantity_update"];
  $createddatetime = date('Y-m-d H:i:s');
  $createdby = $data_nama;
  $lastupdateddatetime = date('Y-m-d H:i:s');
  $lastupdatedby = $data_nama;

  $sql_update = "UPDATE itv_prod_detail_fg SET actual_quantity = '$actual_quantity', datetime = '$datetime', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_header = $id_prod_header";

  $query_update = mysqli_query($koneksi, $sql_update);  
  
  $sql_trigger1 = "UPDATE itv_prod_header SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby'WHERE id_prod_header = $id_prod_header";

  $query_trigger1 = mysqli_query($koneksi, $sql_trigger1);

   //=================== auto number untuk field wh_order_no pada table itv_wo_header ======================//
   $query_autonumber = mysqli_query($koneksi, "SELECT max(wh_order_no) as wh_order_no FROM itv_wh_header");
   $data_autonumber = mysqli_fetch_array($query_autonumber);
   $autonumber = $data_autonumber['wh_order_no'];
   $urutan = (int) substr($autonumber, 6, 6);
   $urutan++;
   $huruf = "ITV-WO";
   $autonumber = $huruf . sprintf("%05s", $urutan);  
   //=================== <END> auto number untuk field wh_order_no pada table itv_wo_header <END> ======================//

    $send_from1 = 'PROD-MBG';
    $send_from2 = 'Company Production';
    $send_to1 = 'WH-MBG';
    $send_to2 = 'Company Warehouse';

    $sql_plan_trigger2 = "INSERT INTO itv_wh_header (wh_order_no,wh_order_internal_no,id_trx_type_code,id_order_type,id_order_header,send_from,send_to,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$autonumber',
                                    '-',
                                    '30',
                                    '120',
                                    '$id_prod_header',
                                    '$send_from1 - $send_from2',
                                    '$send_to1 - $send_to2',
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '10'
                                    )";
    $query_plan_trigger2 = mysqli_query($koneksi, $sql_plan_trigger2);
    
    $sql_plan_trigger3 = "SELECT
                          a.id_wh_header as id_wh_header,
                          c.id_prod_detail_fg as id_order_detail,
                          c.id_item as id_item,
                          c.actual_quantity as order_quantity
                          FROM itv_wh_header as a
                          LEFT JOIN itv_prod_header as b ON a.id_order_header = b.id_prod_header
                          LEFT JOIN itv_prod_detail_fg as c ON b.id_prod_header = c.id_prod_header
                          WHERE a.id_order_header = '$id_prod_header' AND a.id_trx_type_code = '30' AND a.id_order_type = '120'";
    $query_plan_trigger3 = mysqli_query($koneksi, $sql_plan_trigger3);
    while ($data_trigger3 = $query_plan_trigger3->fetch_assoc()) {
    $id_wh_header = $data_trigger3['id_wh_header'];
    $id_order_detail = $data_trigger3['id_order_detail'];
    $id_item = $data_trigger3['id_item'];
    $order_quantity = $data_trigger3['order_quantity'];

    $sql_plan_trigger4 = "INSERT INTO itv_wh_detail (id_wh_header,id_order_detail,id_item,order_quantity,createddatetime,createdby,isdelete)
                          VALUES (
                                    '$id_wh_header',
                                    '$id_order_detail',
                                    '$id_item',
                                    '$order_quantity',                        
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1'
                                    )";
    $query_plan_trigger4 = mysqli_query($koneksi, $sql_plan_trigger4);
    $last_id_wh_detail = mysqli_insert_id($koneksi);

    $sql_plan_trigger5 = "INSERT INTO itv_wh_detail_root (id_wh_detail,actual_quantity,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$last_id_wh_detail',
                                    '$order_quantity',                                                      
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '10'
                                    )";
    $query_plan_trigger5 = mysqli_query($koneksi, $sql_plan_trigger5);
    }
    
  
  if ($query_update === TRUE){
      echo "1";
  } else {
      echo "2";
  }
}
//================= <END> Mengupdate pro dari Modal complete (UPDATE) <END> =================//
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

    //===================== Insert  =======================//
    if (isset($_POST["scrap_no"])){
 
    $scrap_no =  $_POST["scrap_no"];
    $scrap_internal_no =  $_POST["scrap_internal_no"];
    $scrap_date = $_POST["scrap_date"];
    $remark = $_POST["remark"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

    //=================== auto number untuk field scrap_no pada table itv_scrap_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(scrap_no) as scrap_no FROM itv_scrap_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $huruf = "ITV-SR";

    // Cek apakah hasilnya NULL atau tidak
    if ($data_autonumber['scrap_no'] === null) {
    $urutan = 1;
    } else {
    $autonumber_lama = $data_autonumber['scrap_no'];
    $urutan = (int) substr($autonumber_lama, 6, 5);
    $urutan++;
    }

    $autonumber = $huruf . sprintf("%05s", $urutan);
    //=================== <END> auto number untuk field scrap_no pada table itv_scrap_header <END> ======================//

    $sql2 = "INSERT INTO itv_scrap_header (scrap_no,scrap_internal_no,scrap_date,remark,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$autonumber',
                                '$scrap_internal_no',
                                '$scrap_date',
                                '$remark',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10'
                                )";  
                                
    $query_simpan = mysqli_query($koneksi, $sql2);
                                             
    if ($query_simpan === TRUE){
          echo "1";
    } else {
          echo "2";
    }
    }
    //================ <END> Insert <END>===============//

    //============================ Menampilkan ke Modal Edit  ================================//
    else if(isset($_POST["id_scrap_header_edit"])){
    $id_scrap_header = $_POST["id_scrap_header_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_scrap_header WHERE id_scrap_header = $id_scrap_header");
      
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan ke Modal Edit <END> ==========================//

  //======================= Mengupdate dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_scrap_header_update"])){
    $id_scrap_header = $_POST["id_scrap_header_update"];
    $scrap_internal_no =  $_POST["scrap_internal_no_update"];
    $scrap_date = $_POST["scrap_date_update"];
    $remark =  $_POST["remark_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_scrap_header SET scrap_internal_no = '$scrap_internal_no', scrap_date = '$scrap_date', remark = '$remark', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_scrap_header = $id_scrap_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete ======================================//
    else if(isset($_POST["id_scrap_header_delete"])){
    $id_scrap_header = $_POST["id_scrap_header_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_scrap_header SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_scrap_header = $id_scrap_header";
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    
    if ($query_delete === TRUE){
          echo "1";
    } else {
          echo "2";
    }
}
  //=========================== <END> Delete <END> ==================================//

  //============================== Complete ======================================//
    else if(isset($_POST["id_scrap_header_complete"])){
    $id_scrap_header = $_POST["id_scrap_header_complete"];
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

    $sql_plan = "UPDATE itv_scrap_header SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_scrap_header = $id_scrap_header";
    $query_plan = mysqli_query($koneksi, $sql_plan); 

    $send_from1 = 'WH-MBG';
    $send_from2 = 'Company Warehouse';
    $send_to1 = 'WH-MBG';
    $send_to2 = 'Company Warehouse';
    

    $sql_plan_trigger2 = "INSERT INTO itv_wh_header (wh_order_no,wh_order_internal_no,id_trx_type_code,id_order_type,id_order_header,send_from,send_to,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$autonumber',
                                    '-',
                                    '30',
                                    '888',
                                    '$id_scrap_header',
                                    '$send_from1 - $send_from2',
                                    '$send_to1 - $send_to2',
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '70'
                                    )";
    $query_plan_trigger2 = mysqli_query($koneksi, $sql_plan_trigger2);


    $sql_plan_trigger3 = "SELECT
                          a.id_wh_header as id_wh_header,
                          c.id_scrap_detail as id_order_detail,
                          c.id_item as id_item,
                          c.quantity as order_quantity,
                          c.batch as batch,
                          b.scrap_date as scrap_date
                          FROM itv_wh_header as a
                          LEFT JOIN itv_scrap_header as b ON a.id_order_header = b.id_scrap_header
                          LEFT JOIN itv_scrap_detail as c ON b.id_scrap_header = c.id_scrap_header
                          WHERE a.id_order_header = '$id_scrap_header' AND a.id_trx_type_code = '30' AND a.id_order_type = '888'";
    $query_plan_trigger3 = mysqli_query($koneksi, $sql_plan_trigger3);
    while ($data_trigger3 = $query_plan_trigger3->fetch_assoc()) {
    $id_wh_header = $data_trigger3['id_wh_header'];
    $id_order_detail = $data_trigger3['id_order_detail'];
    $id_item = $data_trigger3['id_item'];
    $order_quantity = $data_trigger3['order_quantity'];
    $batch = $data_trigger3['batch'];
    $scrap_date = $data_trigger3['scrap_date'];

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
                                    '$order_quantity',  
                                    '$scrap_date',    
                                    '$batch',                                                
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '70'
                                    )";
    $query_plan_trigger5 = mysqli_query($koneksi, $sql_plan_trigger5);

    $sql_plan_trigger6 = "UPDATE itv_scrap_detail SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_scrap_header = $id_scrap_header AND id_scrap_detail = $id_order_detail";
    $query_plan_trigger6 = mysqli_query($koneksi, $sql_plan_trigger6); 

    }

    if ($query_plan === TRUE){
      echo "1";
    } else { echo "2";}
}
  //=========================== <END> Complete <END> ==================================//
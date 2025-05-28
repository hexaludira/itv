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

    //===================== Insert PO  =======================//
    if (isset($_POST["purchase_order_no"])){
 
    $purchase_order_no =  $_POST["purchase_order_no"];
    $purchase_order_internal_no =  $_POST["purchase_order_internal_no"];
    $id_purchase_type =  $_POST["id_purchase_type"];
    $id_bp =  $_POST["id_bp"];
    $purchase_date = $_POST["purchase_date"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

    //=================== auto number untuk field purchase_order_no pada table itv_po_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(purchase_order_no) as purchase_order_no FROM itv_po_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $autonumber = $data_autonumber['purchase_order_no'];
    $urutan = (int) substr($autonumber, 6, 6);
    $urutan++;
    $huruf = "ITV-PO";
    $autonumber = $huruf . sprintf("%05s", $urutan);  
    //=================== <END> auto number untuk field purchase_order_no pada table itv_po_header <END> ======================//

    $sql2 = "INSERT INTO itv_po_header (purchase_order_no,purchase_order_internal_no,id_purchase_type,purchase_date,id_bp,createddatetime,createdby,isdelete,status,total_link)                                                                     
                            VALUES (
                                '$autonumber',
                                '$purchase_order_internal_no',
                                '$id_purchase_type',
                                '$purchase_date',
                                '$id_bp',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10',
                                '0'
                                )";  
                                
    $query_simpan = mysqli_query($koneksi, $sql2);
                                             
    if ($query_simpan === TRUE){
          echo "1";
    } else {
          echo "2";
    }
    }
    //================ <END> insert PO <END>===============//

    //============================ Menampilkan PO ke Modal Edit  ================================//
    else if(isset($_POST["id_po_header_edit"])){
    $id_po_header = $_POST["id_po_header_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_po_header WHERE id_po_header = $id_po_header");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan PO ke Modal Edit <END> ==========================//

  //======================= Mengupdate PO dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_po_header_update"])){
    $id_po_header = $_POST["id_po_header_update"];
    $purchase_order_internal_no =  $_POST["purchase_order_internal_no_update"];
    $id_purchase_type =  $_POST["id_purchase_type_update"];
    $purchase_date = $_POST["purchase_date_update"];
    $id_bp =  $_POST["id_bp_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_po_header SET purchase_order_internal_no = '$purchase_order_internal_no', id_purchase_type = '$id_purchase_type', purchase_date = '$purchase_date', id_bp = '$id_bp', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_po_header = $id_po_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate PO dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete PO ======================================//
    else if(isset($_POST["id_po_header_delete"])){
    $id_po_header = $_POST["id_po_header_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_po_header SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_po_header = $id_po_header";
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    
    if ($query_delete === TRUE){
          echo "1";
    } else {
          echo "2";
    }
}
  //=========================== <END> Delete PO <END> ==================================//

  //============================== Plan PO ======================================//
    else if(isset($_POST["id_po_header_plan"])){
    $id_po_header = $_POST["id_po_header_plan"];
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

    $sql_plan = "UPDATE itv_po_header SET status = '20', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_po_header = $id_po_header";
    $query_plan = mysqli_query($koneksi, $sql_plan); 

    $sql_plan_trigger1 = "SELECT b.bp_code as bp_code, b.bp_name as bp_name  FROM itv_po_header as a LEFT JOIN itv_masterdata_bp as b ON a.id_bp = b.id_bp WHERE id_po_header = $id_po_header";
    $query_plan_trigger1 = mysqli_query($koneksi, $sql_plan_trigger1);
    while ($data_trigger1 = $query_plan_trigger1->fetch_assoc()) {
    $send_from1 = $data_trigger1['bp_code'];
    $send_from2 = $data_trigger1['bp_name'];
    $send_to1 = 'WH-MBG';
    $send_to2 = 'Company Warehouse';
    

    $sql_plan_trigger2 = "INSERT INTO itv_wh_header (wh_order_no,wh_order_internal_no,id_trx_type_code,id_order_type,id_order_header,send_from,send_to,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$autonumber',
                                    '-',
                                    '30',
                                    '110',
                                    '$id_po_header',
                                    '$send_from1 - $send_from2',
                                    '$send_to1 - $send_to2',
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '10'
                                    )";
    $query_plan_trigger2 = mysqli_query($koneksi, $sql_plan_trigger2);
    }

    $sql_plan_trigger3 = "SELECT
                          a.id_wh_header as id_wh_header,
                          c.id_po_detail as id_order_detail,
                          c.id_item as id_item,
                          c.quantity as order_quantity
                          FROM itv_wh_header as a
                          LEFT JOIN itv_po_header as b ON a.id_order_header = b.id_po_header
                          LEFT JOIN itv_po_detail as c ON b.id_po_header = c.id_po_header
                          WHERE a.id_order_header = '$id_po_header' AND a.id_trx_type_code = '30' AND a.id_order_type = '110'";
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

    $sql_plan_trigger5 = "INSERT INTO itv_wh_detail_root (id_wh_detail,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$last_id_wh_detail',                                                      
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '10'
                                    )";
    $query_plan_trigger5 = mysqli_query($koneksi, $sql_plan_trigger5);
    }

    if ($query_plan === TRUE){
      echo "1";
    } else { echo "2";}
}
  //=========================== <END> Plan PO <END> ==================================//
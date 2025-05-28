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
   $data_menu_wms = $_SESSION["ses_menuwms"];
   $data_menu_mesc = $_SESSION["ses_menumesc"];
   $data_menu_mesf = $_SESSION["ses_menumesf"];
   $data_menu_lapormas = $_SESSION["ses_menulapormas"];
   $data_menu_itinventory = $_SESSION["ses_menuitinventory"];
   $data_menu_hris = $_SESSION["ses_menuhris"];
   $data_menu_it = $_SESSION["ses_menuit"];
   $data_menu_ga = $_SESSION["ses_menuga"];
   $data_level = $_SESSION["ses_level"];


 }

    //============================ Menampilkan WO ke Modal Edit  ================================//
    if(isset($_POST["id_wh_detail_edit"])){
    $id_wh_detail = $_POST["id_wh_detail_edit"];
    $id_wh_detail_root = $_POST["id_wh_detail_root_edit"];
    $sql = $koneksi->query("SELECT 
                            a.id_wh_detail as id_wh_detail,
                            a.id_wh_header as id_wh_header,
                            a.id_order_detail as id_order_detail,
                            c.id_wh_detail_root as id_wh_detail_root,
                            a.order_quantity as order_quantity,
                            b.id_unit_code as id_unit_code,
                            a.id_item as id_item,
                            c.actual_quantity as actual_quantity,
                            c.datetime as datetime
                            FROM itv_wh_detail as a 
                            LEFT JOIN itv_masterdata_item as b ON a.id_item = b.id_item 
                            LEFT JOIN itv_wh_detail_root as c ON a.id_wh_detail = c.id_wh_detail
                            WHERE a.id_wh_detail = $id_wh_detail AND c.id_wh_detail_root = $id_wh_detail_root");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan WO ke Modal Edit <END> ==========================//

  //======================= Deliver dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_wh_detail_update"])){
    $id_wh_detail = $_POST["id_wh_detail_update"];
    $id_wh_header = $_POST["id_wh_header_update"];
    $id_order_detail = $_POST["id_order_detail_update"];
    $id_wh_detail_root = $_POST["id_wh_detail_root_update"];
    $actual_quantity =  $_POST["actual_quantity_update"];
    $receive_datetime =  $_POST["receive_datetime_update"];
    $batch = $_POST["batch_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_wh_detail SET lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_wh_detail = $id_wh_detail";
    $query_update = mysqli_query($koneksi, $sql_update);

    $sql_update_trigger1 = "SELECT a.id_order_header as id_order_header FROM itv_wh_header as a WHERE a.id_wh_header = $id_wh_header";
    $query_update_trigger1 = mysqli_query($koneksi, $sql_update_trigger1);
    while ($data_trigger1 = $query_update_trigger1->fetch_assoc()) {
      $id_order_header = $data_trigger1['id_order_header'];
    }
    
    $sql_update_trigger2 = "UPDATE itv_so_header SET status = '50', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_so_header = $id_order_header";
    $query_update_trigger2 = mysqli_query($koneksi, $sql_update_trigger2); 

    $sql_update_trigger3 = "UPDATE itv_wh_header SET status = '50', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_wh_header = $id_wh_header";
    $query_update_trigger3 = mysqli_query($koneksi, $sql_update_trigger3); 

    $sql_update_trigger4 = "UPDATE itv_so_detail SET status = '50', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_so_detail = $id_order_detail AND id_so_header = $id_order_header";
    $query_update_trigger4 = mysqli_query($koneksi, $sql_update_trigger4);

    $sql_update_trigger4 = "UPDATE itv_wh_detail_root SET actual_quantity = '$actual_quantity', datetime = '$receive_datetime', batch = '$batch', status = '50', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_wh_detail = $id_wh_detail AND id_wh_detail_root = $id_wh_detail_root";
    $query_update_trigger4 = mysqli_query($koneksi, $sql_update_trigger4);

    if ($query_update === TRUE){
          echo "1";
    } else {
      echo "2";
    }
}
  //================= <END> Deliver user dari Modal Edit (UPDATE) <END> =================//

  //===================== Insert More WH Detail  =======================//
  if (isset($_POST["id_wh_detail_add"])){
 
    $id_wh_detail =  $_POST["id_wh_detail_add"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

    $sql_add_more = "INSERT INTO itv_wh_detail_root (id_wh_detail,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$id_wh_detail',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10'
                                )";  
                                
    $query_simpan = mysqli_query($koneksi, $sql_add_more);
                                             
    if ($query_simpan === TRUE){
          echo "1";
    } else {
          echo "2";
    }
    }
    //================ <END> Insert More WH Detail <END>===============//

    //============================== Delete WO detail ======================================//
    else if(isset($_POST["id_wh_detail_delete"])){
      $id_wh_detail = $_POST["id_wh_detail_delete"];
      $id_wh_detail_root = $_POST["id_wh_detail_root_delete"];
      $lastupdateddatetime = date('Y-m-d H:i:s');
      $lastupdatedby = $data_nama;
  
      $sql_delete = "UPDATE itv_wh_detail_root SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_wh_detail = $id_wh_detail AND id_wh_detail_root = $id_wh_detail_root";
      $query_delete = mysqli_query($koneksi, $sql_delete); 
      
      
      if ($query_delete === TRUE){
            echo "1";
      } else {
            echo "2";
      }
  }
    //=========================== <END> Delete WO detail <END> ==================================//
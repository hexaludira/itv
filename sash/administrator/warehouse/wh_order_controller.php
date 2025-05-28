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
    if(isset($_POST["id_wh_header_edit"])){
    $id_wh_header = $_POST["id_wh_header_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_wh_header WHERE id_wh_header = $id_wh_header");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan WO ke Modal Edit <END> ==========================//

  //======================= Mengupdate WO dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_wh_header_update"])){
    $id_wh_header = $_POST["id_wh_header_update"];
    $wh_order_internal_no =  $_POST["wh_order_internal_no_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_wh_header SET wh_order_internal_no = '$wh_order_internal_no', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_wh_header = $id_wh_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate WO dari Modal Edit (UPDATE) <END> =================//


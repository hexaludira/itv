<?php
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

include $_SERVER['DOCUMENT_ROOT'].'/sash/inc/koneksi.php'; //$_SERVER['DOCUMENT_ROOT'] = xampp/htdocs
date_default_timezone_set('Asia/Jakarta');

//Menambahkan System baru
        if (isset ($_POST['PurchaseNo'])){    
          $Werks = $_POST["Werks"];  
          $PurchaseNo = $_POST["PurchaseNo"];
          $id_doc_code = $_POST["id_doc_code"];
          $nomorDokumen = $_POST["nomorDokumen"];
          $tanggalDokumen = strtodate($_POST["tanggalDokumen"]);
          $createddatetime = date('Y-m-d h:i:s');
          $createby = $data_nama;
          
          $sql_simpan = "INSERT INTO itv_masterdata_po_dokumen (Werks,PurchaseNo,id_doc_code,nomorDokumen,tanggalDokumen,createddatetime,createdby,isdelete)                                                                     
            VALUES (
                '$Werks',
                '$PurchaseNo',
                '$id_doc_code',
                '$nomorDokumen',
                '$tanggalDokumen',
                '$createddatetime',
                '$createby',
                '1'
                )";
            $query_simpan = mysqli_query($koneksi, $sql_simpan);
            if ($query_simpan === TRUE) {
              echo "1";
              }else{
              echo "2";
                 }
          }
?>
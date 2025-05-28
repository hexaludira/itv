<?php
 include $_SERVER['DOCUMENT_ROOT'].'/sash/inc/koneksi_wms.php'; //$_SERVER['DOCUMENT_ROOT'] = xampp/htdocs
 include $_SERVER['DOCUMENT_ROOT'].'/sash/inc/koneksi.php'; //$_SERVER['DOCUMENT_ROOT'] = xampp/htdocs

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
//===================== Insert Begining Balance Item dari Modal Add BB Item  =======================//
if (isset($_POST["id_beg_balance"])){
 
    $id_beg_balance =  $_POST["id_beg_balance"];
    $id_item_category_code =  $_POST["id_item_category_code"];
    $Matnr =  $_POST["Matnr"];
    $Matnr_Name =  $_POST["Matnr_Name"];
    $Quantity =  $_POST["Quantity"];
    $id_unit_code =  $_POST["id_unit_code"];
    $id_currency =  $_POST["id_currency"];
    $price_item =  $_POST["price_item"];
    $tot_price = ($_POST["Quantity"]*$_POST["price_item"]);
    $declare_date =  $_POST["declare_date"];
    $createddatetime = date('Y-m-d H:i:s');
    $createby = $data_nama;
  
    $sql = "INSERT INTO itv_beg_balance_detail (id_beg_balance,id_item_category_code,Matnr,Matnr_Name,Quantity,id_unit_code,id_currency,price_item,tot_price,declare_date,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$id_beg_balance',
                                '$id_item_category_code',
                                '$Matnr',
                                '$Matnr_Name',
                                '$Quantity',
                                '$id_unit_code',
                                '$id_currency',
                                '$price_item',
                                '$tot_price',
                                '$declare_date',
                                '$createddatetime',
                                '$createby',
                                '1'
                                )";
  
    $query_simpan = mysqli_query($koneksi, $sql);                        
  
    if ($query_simpan === TRUE){        
          echo "1";
        }
       
    } else {
          echo "2";
    }
    //================ <END> Insert Begining Balance Item dari Modal Add BB Item <END>===============//


 ?>
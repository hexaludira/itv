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

 //======================= Menampilkan data ke Edit Modal ==================================//
 if (isset($_POST['PurchaseItemNo_Edit'])) {
    $PurchaseItemNo = $_POST["PurchaseItemNo_Edit"];
    $PurchaseNo = $_POST["PurchaseNo"];

    $sql = "SELECT
                PurchaseNo as PurchaseNo,
                Werks as Werks,
                PurchaseItemNo as PurchaseItemNo,
                Matnr as Matnr,               
                Quantity as Quantity,
                Unit as Unit
                from PurchaseItem 
                where PurchaseItemNo='$PurchaseItemNo' AND PurchaseNo='$PurchaseNo'";
    $query = sqlsrv_query($koneksi_wms,$sql);
    $data = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    echo json_encode($data);
}
//=================== <END> Menampilkan data ke Edit Modal <END> =============================//

//===================== Mengupdate System dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["PurchaseItemNo_save"])){
    $Werks = $_POST["Werks"];
    $PurchaseNo = $_POST["PurchaseNo"];
    $PurchaseItemNo = $_POST["PurchaseItemNo_save"];
    $id_item_category_code = $_POST["id_item_category_code"];
    $Matnr = $_POST["Matnr"];
    $Quantity = $_POST["Quantity"];
    $Unit = $_POST["Unit"];
    $id_unit_code = $_POST["id_unit_code"];
    $id_currency = $_POST["id_currency"];
    $id_po_dokumen = $_POST["id_po_dokumen"];
    $price = $_POST["price"];
    $createddatetime = date('Y-m-d h:i:s');
    $createby = $data_nama;

    $sql2 = "INSERT INTO itv_masterdata_po_price (PurchaseNo,Werks,PurchaseItemNo,id_item_category_code,Matnr,Quantity,Unit,id_unit_code,price,id_po_dokumen,id_currency,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$PurchaseNo',
                                '$Werks',
                                '$PurchaseItemNo',
                                '$id_item_category_code',
                                '$Matnr',
                                '$Quantity',
                                '$Unit',
                                '$id_unit_code',
                                '$price',
                                '$id_po_dokumen',
                                '$id_currency',
                                '$createddatetime',
                                '$createby',
                                '1'
                                )";
    $query_simpan = mysqli_query($koneksi, $sql2);                            

    if ($query_simpan === TRUE){
        echo "1";
    } else {
        echo "2";
    }
    }
  //================ <END> Mengupdate System dari Modal Edit (UPDATE) <END>===============//

?>
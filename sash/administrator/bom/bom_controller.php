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

 //===================== Insert BOM  =======================//
if (isset($_POST["id_item"])){
 
    $id_item =  $_POST["id_item"];
    $quantity_finish_good =  $_POST["quantity_finish_good"];
    $remark =  $_POST["remark"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

//=================== auto number untuk field bill_of_material_no pada table itv_masterdata_bom_header ======================//
$query_autonumber = mysqli_query($koneksi, "SELECT max(bom_no) as bom_no FROM itv_masterdata_bom_header");
$data_autonumber = mysqli_fetch_array($query_autonumber);
$autonumber = $data_autonumber['bom_no'];
$urutan = (int) substr($autonumber, 6, 6);
$urutan++;
$huruf = "ITV-BM";
$autonumber = $huruf . sprintf("%05s", $urutan);  
//=================== <END> auto number untuk field purchase_order_no pada table itv_po_header <END> ======================//
  
    $sql2 = "INSERT INTO itv_masterdata_bom_header (bom_no,id_item,quantity_finish_good,remark,status,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$autonumber',
                                '$id_item',
                                '$quantity_finish_good',
                                '$remark',
                                '10',
                                '$createddatetime',
                                '$createdby',
                                '1'
                                )";                                                                
                              
    $query_simpan = mysqli_query($koneksi, $sql2);                       
  
    if ($query_simpan === TRUE){   
        echo "1";
      }     
     else {
          echo "2";
    }
    }
  
    //================ <END> Insert BOM <END>===============//

    //============================ Menampilkan BOM ke Modal Edit  ================================//
    else if(isset($_POST["id_bom_header_edit"])){
    $id_bom_header = $_POST["id_bom_header_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_masterdata_bom_header WHERE id_bom_header = $id_bom_header");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan BP ke Modal Edit <END> ==========================//

  //======================= Mengupdate BOM dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_bom_header_update"])){
    $id_bom_header = $_POST["id_bom_header_update"];
    $id_item =  $_POST["id_item_update"];
    $quantity_finish_good =  $_POST["quantity_finish_good_update"];
    $remark =  $_POST["remark_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_masterdata_bom_header SET id_item = '$id_item', quantity_finish_good = '$quantity_finish_good', remark = '$remark', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bom_header = $id_bom_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate user dari Modal Edit (UPDATE) <END> =================//

  //============================== Activate BOM ======================================//
  else if(isset($_POST["id_bom_header_activate"])){
    $id_bom_header = $_POST["id_bom_header_activate"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_activate = "UPDATE itv_masterdata_bom_header SET status = '60', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bom_header = $id_bom_header";
  
    $query_activate = mysqli_query($koneksi, $sql_activate); 
    if($query_activate === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Activate BOM <END> ==================================//

  //============================== Deactivate BOM ======================================//
  else if(isset($_POST["id_bom_header_deactivate"])){
    $id_bom_header = $_POST["id_bom_header_deactivate"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_deactivate = "UPDATE itv_masterdata_bom_header SET status = '80', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bom_header = $id_bom_header";
  
    $query_deactivate = mysqli_query($koneksi, $sql_deactivate); 
    if($query_deactivate === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Deactivate BOM <END> ==================================//

  //============================== Delete BOM ======================================//
    else if(isset($_POST["id_bom_header_delete"])){
    $id_bom_header = $_POST["id_bom_header_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_masterdata_bom_header SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bom_header = $id_bom_header";
  
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    if($query_delete === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Delete BOM <END> ==================================//
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

 //===================== Insert Item  =======================//
if (isset($_POST["item_code"])){
 
    $id_item_category_code =  $_POST["id_item_category_code"];
    $id_factory =  $_POST["id_factory"];
    $item_code =  $_POST["item_code"];
    $item_desc =  $_POST["item_desc"];
    $id_unit_code =  $_POST["id_unit_code"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
  
    $sql2 = "INSERT INTO itv_masterdata_item (id_item_category_code,id_factory,item_code,item_desc,id_unit_code,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$id_item_category_code',
                                '$id_factory',
                                '$item_code',
                                '$item_desc',
                                '$id_unit_code',
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
  
    //================ <END> Insert Item <END>===============//

    //============================ Menampilkan Email ke Modal Edit  ================================//
    else if(isset($_POST["id_item_edit"])){
    $id_item_edit = $_POST["id_item_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_masterdata_item WHERE id_item = $id_item_edit");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
    }
    //======================= <END> Menampilkan Email ke Modal Edit <END> ==========================//

    //======================= Mengupdate item dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_item_update"])){
    $id_item = $_POST["id_item_update"];
    $id_item_category_code =  $_POST["id_item_category_code_update"];
    $id_factory =  $_POST["id_factory_update"];
    $item_code =  $_POST["item_code_update"];
    $item_desc =  $_POST["item_desc_update"];
    $id_unit_code =  $_POST["id_unit_code_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_masterdata_item SET id_item_category_code = '$id_item_category_code', id_factory = '$id_factory', item_code = '$item_code', item_desc = '$item_desc', id_unit_code = '$id_unit_code', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_item = $id_item";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate item dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete user ======================================//
    else if(isset($_POST["id_item_delete"])){
    $id_item = $_POST["id_item_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_masterdata_item SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_item = $id_item";
  
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    if($query_delete === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Delete user <END> ==================================//

 ?>
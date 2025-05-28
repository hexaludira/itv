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

 //===================== Insert material Detail =======================//
if (isset($_POST["id_prod_header"])){
 
    $id_prod_header =  $_POST["id_prod_header"];
    $id_item =  $_POST["id_item"];
    $quantity =  $_POST["quantity"];
    $actual_quantity =  $_POST["actual_quantity"];
    $batch = $_POST["batch"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
  
    $sql2 = "INSERT INTO itv_prod_detail_rm (id_prod_header,id_item,quantity,batch,actual_quantity,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$id_prod_header',
                                '$id_item',
                                '$quantity',
                                '$batch',
                                '$actual_quantity',               
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10'
                                )";                                                                
                              
    $query_simpan = mysqli_query($koneksi, $sql2);                       
  
    if ($query_simpan === TRUE){   
        echo "1";
      }     
     else {
          echo "2";
    }
    }
  
    //================ <END> Insert material Detail<END>===============//

    //============================ Menampilkan pro Detail ke Modal Edit  ================================//
    else if(isset($_POST["id_prod_detail_rm_edit"])){
    $id_prod_detail_rm = $_POST["id_prod_detail_rm_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_prod_detail_rm WHERE id_prod_detail_rm = $id_prod_detail_rm");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan pro Detail ke Modal Edit <END> ==========================//

  //======================= Mengupdate pro Detail dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_prod_detail_rm_update"])){
    $id_prod_detail_rm = $_POST["id_prod_detail_rm_update"];
    $quantity =  $_POST["quantity_update"];
    $actual_quantity =  $_POST["actual_quantity_update"];
    $batch =  $_POST["batch_update"];
    $id_item =  $_POST["id_item_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_prod_detail_rm SET quantity = '$quantity', actual_quantity = '$actual_quantity', batch = '$batch', id_item = '$id_item', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_detail_rm = $id_prod_detail_rm";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate pro Detail dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete pro Detail ======================================//
    else if(isset($_POST["id_prod_detail_rm_delete"])){
    $id_prod_detail_rm = $_POST["id_prod_detail_rm_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_prod_detail_rm SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_prod_detail_rm = $id_prod_detail_rm";
  
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    if($query_delete === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Delete pro Detail <END> ==================================//
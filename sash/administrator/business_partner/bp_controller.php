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

 //===================== Insert BP  =======================//
if (isset($_POST["bp_code"])){
 
    $bp_code =  $_POST["bp_code"];
    $bp_name =  $_POST["bp_name"];
    $bp_type =  $_POST["bp_type"];
    $bp_city =  $_POST["bp_city"];
    $bp_address =  $_POST["bp_address"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
  
    $sql2 = "INSERT INTO itv_masterdata_bp (bp_code,bp_name,bp_type,bp_city,bp_address,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$bp_code',
                                '$bp_name',
                                '$bp_type',
                                '$bp_city',
                                '$bp_address',
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
  
    //================ <END> Insert BP <END>===============//

    //============================ Menampilkan BP ke Modal Edit  ================================//
    else if(isset($_POST["id_bp_edit"])){
    $id_bp = $_POST["id_bp_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_masterdata_bp WHERE id_bp = $id_bp");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan BP ke Modal Edit <END> ==========================//

  //======================= Mengupdate user dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_bp_update"])){
    $id_bp = $_POST["id_bp_update"];
    $bp_code =  $_POST["bp_code_update"];
    $bp_name =  $_POST["bp_name_update"];
    $bp_type =  $_POST["bp_type_update"];
    $bp_city =  $_POST["bp_city_update"];
    $bp_address =  $_POST["bp_address_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_masterdata_bp SET bp_code = '$bp_code', bp_name = '$bp_name', bp_type = '$bp_type', bp_city = '$bp_city', bp_address = '$bp_address', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bp = $id_bp";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate user dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete BP ======================================//
    else if(isset($_POST["id_bp_delete"])){
    $id_bp = $_POST["id_bp_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_masterdata_bp SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bp = $id_bp";
  
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    if($query_delete === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Delete BP <END> ==================================//
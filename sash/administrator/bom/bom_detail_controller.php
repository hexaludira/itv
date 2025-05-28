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

 //===================== Insert BOM Detail =======================//
if (isset($_POST["id_bom_header"])){
 
    $id_bom_header =  $_POST["id_bom_header"];
    $id_item =  $_POST["id_item"];
    $quantity_material =  $_POST["quantity_material"];
    $remark =  $_POST["remark"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
  
    $sql2 = "INSERT INTO itv_masterdata_bom_detail (id_bom_header,id_item,quantity_material,remark,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$id_bom_header',
                                '$id_item',
                                '$quantity_material',
                                '$remark',
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
  
    //================ <END> Insert BOM Detail<END>===============//

    //============================ Menampilkan BOM Detail ke Modal Edit  ================================//
    else if(isset($_POST["id_bom_detail_edit"])){
    $id_bom_detail = $_POST["id_bom_detail_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_masterdata_bom_detail WHERE id_bom_detail = $id_bom_detail");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan BOM Detail ke Modal Edit <END> ==========================//

  //======================= Mengupdate BOM Detail dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_bom_detail_update"])){
    $id_bom_detail = $_POST["id_bom_detail_update"];
    $id_item =  $_POST["id_item_update"];
    $quantity_material =  $_POST["quantity_material_update"];
    $remark =  $_POST["remark_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_masterdata_bom_detail SET  id_item = '$id_item', quantity_material = '$quantity_material', remark = '$remark', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bom_detail = $id_bom_detail";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate BOM Detail dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete BOM Detail ======================================//
    else if(isset($_POST["id_bom_detail_delete"])){
    $id_bom_detail = $_POST["id_bom_detail_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_masterdata_bom_detail SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_bom_detail = $id_bom_detail";
  
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    if($query_delete === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Delete BOM Detail <END> ==================================//
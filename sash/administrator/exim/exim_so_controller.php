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

 //===================== Insert Exim SO  =======================//
if (isset($_POST["no_dokumen"])){
 
    $no_dokumen =  $_POST["no_dokumen"];
    $tanggal_dokumen =  $_POST["tanggal_dokumen"];
    $id_doc_code =  $_POST["id_doc_code"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
  
    $sql2 = "INSERT INTO itv_exim_so (no_dokumen,tanggal_dokumen,id_doc_code,createddatetime,createdby,isdelete,total_link)                                                                     
                            VALUES (
                                '$no_dokumen',
                                '$tanggal_dokumen',
                                '$id_doc_code',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '0'
                                )";                                                                
                              
    $query_simpan = mysqli_query($koneksi, $sql2);                       
  
    if ($query_simpan === TRUE){   
        echo "1";
      }     
     else {
          echo "2";
    }
    }
  
    //================ <END> Insert Exim SO <END>===============//

    //============================ Menampilkan Exim SO ke Modal Edit  ================================//
    else if(isset($_POST["id_exim_so_edit"])){
    $id_exim_so = $_POST["id_exim_so_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_exim_so WHERE id_exim_so = $id_exim_so");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan Exim SO ke Modal Edit <END> ==========================//

        //============================ Menampilkan Exim SO ke Modal Link  ================================//
        else if(isset($_POST["id_exim_so_link"])){
            $id_exim_so = $_POST["id_exim_so_link"];
            $sql = $koneksi->query("SELECT * FROM itv_exim_so WHERE id_exim_so = $id_exim_so");
          
            $data = $sql->fetch_assoc();
          
            //kirim kembali ke view
            echo json_encode($data);
          }
          //======================= <END> Menampilkan Exim SO ke Modal Link <END> ==========================//

  //======================= Mengupdate Exim SO dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_exim_so_update"])){
    $id_exim_so = $_POST["id_exim_so_update"];
    $no_dokumen =  $_POST["no_dokumen_update"];
    $tanggal_dokumen =  $_POST["tanggal_dokumen_update"];
    $id_doc_code =  $_POST["id_doc_code_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_exim_so SET no_dokumen = '$no_dokumen', tanggal_dokumen = '$tanggal_dokumen', id_doc_code = '$id_doc_code', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_exim_so = $id_exim_so";
    
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate Exim SO dari Modal Edit (UPDATE) <END> =================//

  //======================= Mengupdate Exim SO dari Modal Link (UPDATE) =======================//
    else if (isset($_POST["id_exim_so_update_link"])){
    $id_exim_so = $_POST["id_exim_so_update_link"];
    $id_so_header =  $_POST["id_so_header_update_link"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
          
    $sql_update = "UPDATE itv_exim_so SET id_so_header = '$id_so_header', total_link = '1', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_exim_so = $id_exim_so";

    $sql_before_trigger = "SELECT
                          a.total_link as total_link
                          FROM itv_so_header as a
                          WHERE a.id_so_header = '$id_so_header' AND a.isdelete='1'";

    $sql_execute_before_trigger = mysqli_query($koneksi, $sql_before_trigger);
    while ($data_execute = $sql_execute_before_trigger->fetch_assoc()) {
    $total_link = $data_execute['total_link'];
    $total_link_plus1 = ($total_link + 1);

    $sql_trigger = "UPDATE itv_so_header SET total_link = '$total_link_plus1' WHERE id_so_header = $id_so_header";
    $query_trigger = mysqli_query($koneksi, $sql_trigger); 
    }
    $query_update = mysqli_query($koneksi, $sql_update);
      

    if ($query_update === TRUE){
    if ($query_trigger === TRUE){
          echo "1";
    }
      else {
          echo "1";
    }
    } else {
          echo "2";
    }
    }
  //================= <END> Mengupdate Exim SO dari Modal Link (UPDATE) <END> =================//

  //============================== Delete Exim SO ======================================//
    else if(isset($_POST["id_exim_so_delete"])){
    $id_exim_so = $_POST["id_exim_so_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_exim_so SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_exim_so = $id_exim_so";
  
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    if($query_delete === TRUE ){
        echo "1";
    } else {
        echo "2";
    }
  }
  //=========================== <END> Delete Exim SO <END> ==================================//

    //============================== Unlink Exim SO ======================================//
    else if(isset($_POST["id_exim_so_unlink"])){
        $id_exim_so = $_POST["id_exim_so_unlink"];
        $lastupdateddatetime = date('Y-m-d H:i:s');
        $lastupdatedby = $data_nama;
    
        $sql_unlink = "UPDATE itv_exim_so SET total_link = '0', id_so_header=NULL, lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_exim_so = $id_exim_so";

        $sql_get_so_header = "SELECT id_so_header FROM itv_exim_so WHERE id_exim_so = $id_exim_so";
        $query_get_so_header = mysqli_query($koneksi, $sql_get_so_header);
        while ($data_id_so_header = $query_get_so_header->fetch_assoc()) {
        $id_so_header = $data_id_so_header['id_so_header'];


        $sql_before_trigger = "SELECT
                                a.total_link as total_link
                                FROM itv_so_header as a
                                WHERE a.id_so_header = '$id_so_header' AND a.isdelete='1'";
        
        $sql_execute_before_trigger = mysqli_query($koneksi, $sql_before_trigger);
        while ($data_execute = $sql_execute_before_trigger->fetch_assoc()) {
        $total_link = $data_execute['total_link'];
        $total_link_min1 = ($total_link - 1);

        $sql_trigger = "UPDATE itv_so_header SET total_link = '$total_link_min1' WHERE id_so_header = $id_so_header";
        $query_trigger = mysqli_query($koneksi, $sql_trigger);  
        }
      }
        $query_unlink = mysqli_query($koneksi, $sql_unlink); 
        

        if($query_unlink === TRUE ){
            if ($query_trigger === TRUE){
                echo "1";
            }
            else {
                echo "1";
            }
        } else {
            echo "2";
        }
      }
      //=========================== <END> Unlink Exim SO <END> ==================================//



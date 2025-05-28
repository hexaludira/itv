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
      $data_level = $_SESSION["ses_level"];
    }

    //===================== Insert stockop  =======================//
    if (isset($_POST["stockop_no"])){
 
    $stockop_no =  $_POST["stockop_no"];
    $stockop_internal_no =  $_POST["stockop_internal_no"];
    $stockop_date = $_POST["stockop_date"];
    $remark = $_POST["remark"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

    //=================== auto number untuk field adj_order_no pada table itv_adj_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(stockop_no) as stockop_no FROM itv_stockop_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $huruf = "ITV-ST";

    // Cek apakah hasilnya NULL atau tidak
    if ($data_autonumber['stockop_no'] === null) {
    $urutan = 1;
    } else {
    $autonumber_lama = $data_autonumber['stockop_no'];
    $urutan = (int) substr($autonumber_lama, 6, 5);
    $urutan++;
    }

    $autonumber = $huruf . sprintf("%05s", $urutan);
    //=================== <END> auto number untuk field adj_order_no pada table itv_adj_header <END> ======================//

    $sql2 = "INSERT INTO itv_stockop_header (stockop_no,stockop_internal_no,stockop_date,remark,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$autonumber',
                                '$stockop_internal_no',
                                '$stockop_date',
                                '$remark',
                                '$createddatetime',
                                '$createdby',
                                '1',
                                '10'
                                )";  
                                
    $query_simpan = mysqli_query($koneksi, $sql2);
                                             
    if ($query_simpan === TRUE){
          echo "1";
    } else {
          echo "2";
    }
    }
    //================ <END> insert stockop <END>===============//

    //============================ Menampilkan ke Modal Edit  ================================//
    else if(isset($_POST["id_stockop_header_edit"])){
    $id_stockop_header = $_POST["id_stockop_header_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_stockop_header WHERE id_stockop_header = $id_stockop_header");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan ke Modal Edit <END> ==========================//

  //======================= Mengupdate dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_stockop_header_update"])){
    $id_stockop_header = $_POST["id_stockop_header_update"];
    $stockop_internal_no =  $_POST["stockop_internal_no_update"];
    $stockop_date = $_POST["stockop_date_update"];
    $remark =  $_POST["remark_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_stockop_header SET stockop_internal_no = '$stockop_internal_no', stockop_date = '$stockop_date', remark = '$remark', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_stockop_header = $id_stockop_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete ======================================//
    else if(isset($_POST["id_stockop_header_delete"])){
    $id_stockop_header = $_POST["id_stockop_header_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_stockop_header SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_stockop_header = $id_stockop_header";
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    
    if ($query_delete === TRUE){
          echo "1";
    } else {
          echo "2";
    }
}
  //=========================== <END> Delete <END> ==================================//

  //============================== Complete ======================================//
    else if(isset($_POST["id_stockop_header_complete"])){
    $id_stockop_header = $_POST["id_stockop_header_complete"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;


    $sql_plan = "UPDATE itv_stockop_header SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_stockop_header = $id_stockop_header";
    $query_plan = mysqli_query($koneksi, $sql_plan); 

    $sql_plan_trigger6 = "UPDATE itv_stockop_detail SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_stockop_header = $id_stockop_header";
    $query_plan_trigger6 = mysqli_query($koneksi, $sql_plan_trigger6); 

    

    if ($query_plan === TRUE){
      echo "1";
    } else { 
      echo "2";}
    }
  //=========================== <END> Complete <END> ==================================//
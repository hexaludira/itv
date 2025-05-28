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

    //===================== Insert adj  =======================//
    if (isset($_POST["adj_order_no"])){
 
    $adj_order_no =  $_POST["adj_order_no"];
    $adj_order_internal_no =  $_POST["adj_order_internal_no"];
    $adj_date = $_POST["adj_date"];
    $remark = $_POST["remark"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;

    //=================== auto number untuk field adj_order_no pada table itv_adj_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(adj_order_no) as adj_order_no FROM itv_adj_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $autonumber = $data_autonumber['adj_order_no'];
    $urutan = (int) substr($autonumber, 6, 6);
    $urutan++;
    $huruf = "ITV-AJ";
    $autonumber = $huruf . sprintf("%05s", $urutan);  
    //=================== <END> auto number untuk field adj_order_no pada table itv_adj_header <END> ======================//

    $sql2 = "INSERT INTO itv_adj_header (adj_order_no,adj_order_internal_no,adj_date,remark,createddatetime,createdby,isdelete,status)                                                                     
                            VALUES (
                                '$autonumber',
                                '$adj_order_internal_no',
                                '$adj_date',
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
    //================ <END> insert adj <END>===============//

    //============================ Menampilkan adj ke Modal Edit  ================================//
    else if(isset($_POST["id_adj_header_edit"])){
    $id_adj_header = $_POST["id_adj_header_edit"];
    $sql = $koneksi->query("SELECT * FROM itv_adj_header WHERE id_adj_header = $id_adj_header");
  
    $data = $sql->fetch_assoc();
  
    //kirim kembali ke view
    echo json_encode($data);
  }
  //======================= <END> Menampilkan adj ke Modal Edit <END> ==========================//

  //======================= Mengupdate adj dari Modal Edit (UPDATE) =======================//
    else if (isset($_POST["id_adj_header_update"])){
    $id_adj_header = $_POST["id_adj_header_update"];
    $adj_order_internal_no =  $_POST["adj_order_internal_no_update"];
    $adj_date = $_POST["adj_date_update"];
    $remark =  $_POST["remark_update"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;
  
    $sql_update = "UPDATE itv_adj_header SET adj_order_internal_no = '$adj_order_internal_no', adj_date = '$adj_date', remark = '$remark', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_adj_header = $id_adj_header";
  
    $query_update = mysqli_query($koneksi, $sql_update);   
    if ($query_update === TRUE){
        echo "1";
    } else {
        echo "2";
    }
  }
  //================= <END> Mengupdate adj dari Modal Edit (UPDATE) <END> =================//

  //============================== Delete adj ======================================//
    else if(isset($_POST["id_adj_header_delete"])){
    $id_adj_header = $_POST["id_adj_header_delete"];
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;

    $sql_delete = "UPDATE itv_adj_header SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_adj_header = $id_adj_header";
    $query_delete = mysqli_query($koneksi, $sql_delete); 
    
    if ($query_delete === TRUE){
          echo "1";
    } else {
          echo "2";
    }
}
  //=========================== <END> Delete adj <END> ==================================//

  //============================== Adjust adj ======================================//
    else if(isset($_POST["id_adj_header_plan"])){
    $id_adj_header = $_POST["id_adj_header_plan"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
    $lastupdateddatetime = date('Y-m-d H:i:s');
    $lastupdatedby = $data_nama;


    //=================== auto number untuk field wh_order_no pada table itv_wo_header ======================//
    $query_autonumber = mysqli_query($koneksi, "SELECT max(wh_order_no) as wh_order_no FROM itv_wh_header");
    $data_autonumber = mysqli_fetch_array($query_autonumber);
    $autonumber = $data_autonumber['wh_order_no'];
    $urutan = (int) substr($autonumber, 6, 6);
    $urutan++;
    $huruf = "ITV-WO";
    $autonumber = $huruf . sprintf("%05s", $urutan);  
    //=================== <END> auto number untuk field wh_order_no pada table itv_wo_header <END> ======================//

    $sql_plan = "UPDATE itv_adj_header SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_adj_header = $id_adj_header";
    $query_plan = mysqli_query($koneksi, $sql_plan); 

    $send_from1 = 'WH-MBG';
    $send_from2 = 'Company Warehouse';
    $send_to1 = 'WH-MBG';
    $send_to2 = 'Company Warehouse';
    

    $sql_plan_trigger2 = "INSERT INTO itv_wh_header (wh_order_no,wh_order_internal_no,id_trx_type_code,id_order_type,id_order_header,send_from,send_to,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$autonumber',
                                    '-',
                                    '33',
                                    '999',
                                    '$id_adj_header',
                                    '$send_from1 - $send_from2',
                                    '$send_to1 - $send_to2',
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '70'
                                    )";
    $query_plan_trigger2 = mysqli_query($koneksi, $sql_plan_trigger2);


    $sql_plan_trigger3 = "SELECT
                          a.id_wh_header as id_wh_header,
                          c.id_adj_detail as id_order_detail,
                          c.id_item as id_item,
                          c.quantity as order_quantity,
                          c.batch as batch,
                          b.adj_date as adj_date
                          FROM itv_wh_header as a
                          LEFT JOIN itv_adj_header as b ON a.id_order_header = b.id_adj_header
                          LEFT JOIN itv_adj_detail as c ON b.id_adj_header = c.id_adj_header
                          WHERE a.id_order_header = '$id_adj_header' AND a.id_trx_type_code = '33' AND a.id_order_type = '999'";
    $query_plan_trigger3 = mysqli_query($koneksi, $sql_plan_trigger3);
    while ($data_trigger3 = $query_plan_trigger3->fetch_assoc()) {
    $id_wh_header = $data_trigger3['id_wh_header'];
    $id_order_detail = $data_trigger3['id_order_detail'];
    $id_item = $data_trigger3['id_item'];
    $order_quantity = $data_trigger3['order_quantity'];
    $batch = $data_trigger3['batch'];
    $adj_date = $data_trigger3['adj_date'];

    $sql_plan_trigger4 = "INSERT INTO itv_wh_detail (id_wh_header,id_order_detail,id_item,order_quantity,createddatetime,createdby,isdelete)
                          VALUES (
                                    '$id_wh_header',
                                    '$id_order_detail',
                                    '$id_item',
                                    '$order_quantity',                        
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1'
                                    )";
    $query_plan_trigger4 = mysqli_query($koneksi, $sql_plan_trigger4);
    $last_id_wh_detail = mysqli_insert_id($koneksi);

    $sql_plan_trigger5 = "INSERT INTO itv_wh_detail_root (id_wh_detail,actual_quantity,datetime,batch,createddatetime,createdby,isdelete,status)
                          VALUES (
                                    '$last_id_wh_detail',  
                                    '$order_quantity',  
                                    '$adj_date',    
                                    '$batch',                                                
                                    '$createddatetime',
                                    'ITV-SYSTEM',
                                    '1',
                                    '70'
                                    )";
    $query_plan_trigger5 = mysqli_query($koneksi, $sql_plan_trigger5);

    $sql_plan_trigger6 = "UPDATE itv_adj_detail SET status = '70', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_adj_header = $id_adj_header AND id_adj_detail = $id_order_detail";
    $query_plan_trigger6 = mysqli_query($koneksi, $sql_plan_trigger6); 

    }

    if ($query_plan === TRUE){
      echo "1";
    } else { echo "2";}
}
  //=========================== <END> Adjust adj <END> ==================================//
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

 //===================== Insert Begining Balance dari Modal Add BB  =======================//
if (isset($_POST["no_kegiatan"])){
 
    $no_kegiatan =  $_POST["no_kegiatan"];
    $datetime_beg_balance =  $_POST["datetime_beg_balance"];
    $npwp =  $_POST["npwp"];
    $nib =  $_POST["nib"];
    $createddatetime = date('Y-m-d H:i:s');
    $createby = $data_nama;
  
    $sql2 = "INSERT INTO itv_beg_balance (no_kegiatan,datetime_beg_balance,npwp,nib,createddatetime,createdby,isdelete,submit_status,finalisasi_status)                                                                     
                            VALUES (
                                '$no_kegiatan',
                                '$datetime_beg_balance',
                                '$npwp',
                                '$nib',
                                '$createddatetime',
                                '$createby',
                                '1','1','1'
                                )";
    
    $sql3 = "UPDATE itv_total_beg_balance SET total='1'";                                                                     
                              
    $query_simpan = mysqli_query($koneksi, $sql2);  
    $query_simpan_total_bb = mysqli_query($koneksi, $sql3);                      
  
    if ($query_simpan === TRUE){   
      if($query_simpan_total_bb === TRUE){
        echo "1";
      }     
        } 
     else {
          echo "2";
    }
  }
  
    //================ <END> Insert Begining Balance dari Modal Add BB <END>===============//
    
//================  Submit To LNSW API & Update Status BB Data ===============//
else if (isset($_POST["id_beg_balance_API"])){

  $id_beg_balance =  $_POST["id_beg_balance_API"];

  $sql_API_H = $koneksi->query("SELECT
                              A.no_kegiatan as no_kegiatan,
                              DATE_FORMAT(A.datetime_beg_balance,'%d-%m-%Y %H:%m:%s') as tgl_kegiatan,
                              A.npwp as npwp,
                              A.nib as nib                            
                              FROM 
                              itv_beg_balance as A    
                              WHERE
                              A.id_beg_balance = '$id_beg_balance'
                              AND
                              A.isdelete = '1'");   

  $sql_API_D = $koneksi->query("SELECT                         
                            B.id_item_category_code as kd_kategori_barang,
                            B.Matnr as kd_barang,
                            B.Matnr_Name as uraian_barang,
                            B.Quantity as jumlah,
                            B.id_unit_code as satuan,
                            B.tot_price as nilai,
                            DATE_FORMAT(B.declare_date,'%d-%m-%Y %H:%m:%s') as tanggal_declare
                            FROM                            
                            itv_beg_balance_detail as B
                            WHERE
                            B.id_beg_balance = '$id_beg_balance'
                            AND
                            B.isdelete = '1'");    


  $data_RAW_H = $sql_API_H->fetch_assoc();
  $data_API_H = [
    "data" => [
        "no_kegiatan" => $data_RAW_H['no_kegiatan'],
        "tgl_kegiatan" => $data_RAW_H['tgl_kegiatan'],
        "npwp" => $data_RAW_H['npwp'],
        "nib" => $data_RAW_H['nib'],
        "barangSaldo" => [
      ],
    ],
  ];

  while ($data_RAW_D =  $sql_API_D->fetch_assoc()){ 
  $data_API_D= 
            [
                "kd_kategori_barang" => $data_RAW_D['kd_kategori_barang'],
                "kd_barang" => $data_RAW_D['kd_barang'],
                "uraian_barang" => $data_RAW_D['uraian_barang'],
                "jumlah" => (double)$data_RAW_D['jumlah'],
                "satuan" => $data_RAW_D['satuan'],
                "nilai" => (double)$data_RAW_D['nilai'],
                "tanggal_declare" => $data_RAW_D['tanggal_declare'],         
  ];

  array_push($data_API_H["data"]["barangSaldo"], $data_API_D);                                                   
  
}
  //echo json_encode($data_API_H,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
  $payload = json_encode($data_API_H,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    $ch = curl_init('https://api.insw.go.id/api-prod/inventory/tempInsertSaldoAwal');
    $api_key = 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp';
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-insw-key:' . $api_key, 'Content-Type:application/json'));

    $result = curl_exec($ch);
    
    $sql_respon = $koneksi->query("INSERT INTO itv_beg_balance_respon (id_beg_balance,respon) VALUES ('$id_beg_balance','$result')");

     if (!empty($result)){
        $sql_update = $koneksi->query("UPDATE itv_beg_balance SET submit_status='2' WHERE id_beg_balance='$id_beg_balance' AND isdelete='1'"); 
        echo '1';
     }
     else {
        echo '2';
     }
    curl_close($ch);
  }
  //================ <END> Submit To LNSW API Update Status BB Data <END>===============//

  //================  Finalize BB To LNSW API & Update Status BB Data ===============//
else if (isset($_POST["id_beg_balance_API_Final"])){

  $id_beg_balance =  $_POST["id_beg_balance_API_Final"];

  $sql_API= $koneksi->query("SELECT
                              A.npwp as npwp                           
                              FROM 
                              itv_beg_balance as A    
                              WHERE
                              A.id_beg_balance = '$id_beg_balance'
                              AND
                              A.isdelete = '1'");   

  $sql_final = "UPDATE itv_beg_balance SET finalisasi_status='2' WHERE id_beg_balance='$id_beg_balance' AND isdelete='1'";

  $query_update = mysqli_query($koneksi, $sql_final); 

  $data_RAW = $sql_API->fetch_assoc();

  $data_API = [
        "npwp" => $data_RAW['npwp']
  ];                                            

  //echo json_encode($data_API,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
  $payload = json_encode($data_API);
    $ch = curl_init('https://api.insw.go.id/api-prod/inventory/tempFinalisasiRegistrasi');
    $api_key = 'pZ66hobzPpXBn2bMHVPTz0wG1pxuWQdo';
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-insw-key:' . $api_key, 'Content-Type:application/json'));

    $result = curl_exec($ch);
    
    $sql_respon = $koneksi->query("INSERT INTO itv_finalize_respon (id_beg_balance,respon) VALUES ('$id_beg_balance','$result')");

     if (!empty($result)){
        $sql_update = $koneksi->query("UPDATE itv_beg_balance SET finalisasi_status='2' WHERE id_beg_balance='$id_beg_balance' AND isdelete='1'"); 
        echo '1';
     }
     else {
        echo '2';
     }
    curl_close($ch);
  }
  //================ <END> Finalize BB To LNSW API & Update Status BB Data <END>===============//
 ?>
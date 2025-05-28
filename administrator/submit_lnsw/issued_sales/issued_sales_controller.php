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
 if (isset($_POST['PurchaseReceiveItemNo_Edit'])) {
    $PurchaseReceiveItemNo = $_POST["PurchaseReceiveItemNo_Edit"];
    $PurchaseNo = $_POST["PurchaseNo"];

    $sql = "SELECT
						B.PurchaseReceiveItemNo as PurchaseReceiveItemNo,
						B.PurchaseNo as PurchaseNo,
            A.Werks as Werks,
            B.CreatedDateTime as PurchaseReceiveItemNo_CreatedDateTime,
						E.Name as Supplier_Name,
						A.Werks + '-' + B.Matnr as Matnr,
						C.Name as Matnr_Name,
						B.Quantity as Quantity,
						B.Unit as Unit,
            B.PurchaseItemNo as PurchaseItemNo
            FROM
            PurchaseReceive as A
            INNER JOIN PurchaseReceiveItem as B on A.PurchaseReceiveNo=B.PurchaseReceiveNo
            INNER JOIN Material as C on B.Matnr=C.Matnr AND b.Werks=c.Werks
            INNER JOIN Purchase as D on A.PurchaseNo=D.PurchaseNo
						INNER JOIN Supplier as E on D.SupplierNo=E.SupplierNo
            WHERE 
						B.PurchaseReceiveItemNo = '$PurchaseReceiveItemNo'
						AND
						B.PurchaseNo = '$PurchaseNo'
						AND
            A.CreatedDateTime > '2023-12-31 00:00:00'
            AND
            B.IsDelete = '0'
            AND
            C.IsDelete = '0'
						AND
						E.IsDelete = '0'";
    $query = sqlsrv_query($koneksi_wms,$sql);
    $data_1 = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    $PurchaseItemNo = $data_1['PurchaseItemNo'];

    $sql2 = $koneksi->query("SELECT
                              A.id_item_category_code as id_item_category_code,
                              A.id_unit_code as id_unit_code,
                              A.id_po_dokumen as id_po_dokumen,
                              B.id_doc_code as id_doc_code,
                              B.nomorDokumen as nomorDokumen,
                              B.tanggalDokumen as tanggalDokumen,
                              C.item_category_code as item_category_code,
                              D.unit as unitlnsw,
                              (A.price * A.Quantity) as tot_price
                              FROM 
                              itv_masterdata_po_price as A
                              INNER JOIN 
                              itv_masterdata_po_dokumen as B ON A.id_po_dokumen=B.id_po_dokumen
                              INNER JOIN 
                              itv_lnsw_masterdata_itemcategorycode as C ON A.id_item_category_code=C.id_item_category_code
                              INNER JOIN
                              itv_lnsw_masterdata_unitcode as D ON A.id_unit_code=D.id_unit_code
                              WHERE
                              A.PurchaseNo = '$PurchaseNo'
                              AND 
                              A.PurchaseItemNo = '$PurchaseItemNo'
                              AND
                              A.isdelete = '1'");
             
    $data_2 =  $sql2->fetch_assoc();
    echo json_encode(array($data_1,$data_2));

 
}
//=================== <END> Menampilkan data ke Edit Modal <END> =============================//

//===================== Mengupdate System dari Modal Edit (UPDATE) =======================//
else if (isset($_POST["PurchaseReceiveItemNo_Save"])){
 
  $flag_receipt_type =  $_POST["flag_receipt_type"];
  $id_trx_type_code =  $_POST["id_trx_type_code"];
  $npwp =  $_POST["npwp"];
  $nib =  $_POST["nib"];
  $PurchaseReceiveItemNo_Save =  $_POST["PurchaseReceiveItemNo_Save"];
  $PurchaseNo =  $_POST["PurchaseNo"];
  $Werks =  $_POST["Werks"];
  $PurchaseReceiveItemNo_CreatedDateTime =  $_POST["PurchaseReceiveItemNo_CreatedDateTime"];
  $Supplier_Name =  $_POST["Supplier_Name"];
  $id_item_category_code =  $_POST["id_item_category_code"];
  $Matnr =  $_POST["Matnr"];
  $Matnr_Name =  $_POST["Matnr_Name"];
  $Quantity =  $_POST["Quantity"];
  $id_unit_code =  $_POST["id_unit_code"];
  $tot_price =  $_POST["tot_price"];
  $id_po_dokumen =  $_POST["id_po_dokumen"];
  $id_doc_code =  $_POST["id_doc_code"];
  $nomorDokumen =  $_POST["nomorDokumen"];
  $tanggalDokumen =  $_POST["tanggalDokumen"];
  $createddatetime = date('Y-m-d H:i:s');
  $createby = $data_nama;

  $sql2 = "INSERT INTO itv_transform_receipt (flag_receipt_type,id_trx_type_code,npwp,nib,PurchaseReceiveItemNo,PurchaseNo,Werks,PurchaseReceiveItemNo_CreatedDateTime,Supplier_Name,
                                              id_item_category_code,Matnr,Matnr_Name,Quantity,id_unit_code,tot_price,id_po_dokumen,id_doc_code,nomorDokumen,tanggalDokumen,createddatetime,createdby,isdelete,submit_status)                                                                     
                          VALUES (
                              '$flag_receipt_type',
                              '$id_trx_type_code',
                              '$npwp',
                              '$nib',
                              '$PurchaseReceiveItemNo_Save',
                              '$PurchaseNo',
                              '$Werks',
                              '$PurchaseReceiveItemNo_CreatedDateTime',
                              '$Supplier_Name',
                              '$id_item_category_code',
                              '$Matnr',
                              '$Matnr_Name',
                              '$Quantity',
                              '$id_unit_code',
                              '$tot_price',
                              '$id_po_dokumen',
                              '$id_doc_code',
                              '$nomorDokumen',
                              '$tanggalDokumen',
                              '$createddatetime',
                              '$createby',
                              '1','1'
                              )";

  $sql3 = "UPDATE PurchaseReceiveItem SET itv_flag_status='1' WHERE PurchaseReceiveItemNo='$PurchaseReceiveItemNo_Save' AND PurchaseNo='$PurchaseNo' AND IsDelete='0'";

  $query_simpan = mysqli_query($koneksi, $sql2);     
  $query_update = sqlsrv_query($koneksi_wms,$sql3);                       

  if ($query_simpan === TRUE){
      if ($query_update === TRUE){
        
      }
      else {
        echo "1";
      }
     
  } else {
        echo "2";
  }
  }
  //================ <END> Mengupdate System dari Modal Edit (UPDATE) <END>===============//

  //================  Submit To LNSW API & Update Status Transformed Data ===============//
  else if (isset($_POST["PurchaseReceiveItemNo_API"])){

    $PurchaseReceiveItemNo =  $_POST["PurchaseReceiveItemNo_API"];
    $PurchaseNo =  $_POST["PurchaseNo"];
    $sql_API = $koneksi->query("SELECT
                              id_transform_receipt as id_transform_receipt,
                              id_trx_type_code as kdKegiatan,
                              npwp as npwp,
                              nib as nib,
                              PurchaseReceiveItemNo as nomorDokKegiatan,
                              DATE_FORMAT(PurchaseReceiveItemNo_CreatedDateTime,'%d-%m-%Y') as tanggalKegiatan,
                              Supplier_Name as namaEntitas,
                              id_item_category_code as kdKategoriBarang,
                              Matnr as kdBarang,
                              Matnr_Name as uraianBarang,
                              Quantity as jumlah,
                              id_unit_code as kdSatuan,
                              tot_price as nilai,
                              id_doc_code as kodeDokumen,
                              nomorDokumen as nomorDokumen,
                              DATE_FORMAT(tanggalDokumen,'%d-%m-%Y') as tanggalDokumen
                              FROM 
                              itv_transform_receipt                             
                              WHERE
                              PurchaseNo = '$PurchaseNo'
                              AND 
                              PurchaseReceiveItemNo = '$PurchaseReceiveItemNo'
                              AND
                              isdelete = '1'");    

    $data_RAW =  $sql_API->fetch_assoc(); 
    $data_API = [
      "data" => [
          [
              "kdKegiatan" => $data_RAW['kdKegiatan'],
              "npwp" => $data_RAW['npwp'],
              "nib" => $data_RAW['nib'],
              "dokumenKegiatan" => [
                  [
                      "nomorDokKegiatan" => $data_RAW['nomorDokKegiatan'],
                      "tanggalKegiatan" => $data_RAW['tanggalKegiatan'],
                      "namaEntitas" => $data_RAW['namaEntitas'],
                      "barangTransaksi" => [
                          [
                              "kdKategoriBarang" => $data_RAW['kdKategoriBarang'],
                              "kdBarang" => $data_RAW['kdBarang'],
                              "uraianBarang" => $data_RAW['uraianBarang'],       
                              "jumlah" => (double)$data_RAW['jumlah'],
                              "kdSatuan" => $data_RAW['kdSatuan'],
                              "nilai" => (double)$data_RAW['nilai'],
                              "dokumen" => [
                                  [
                                      "kodeDokumen" => $data_RAW['kodeDokumen'],
                                      "nomorDokumen" => $data_RAW['nomorDokumen'],
                                      "tanggalDokumen" => $data_RAW['tanggalDokumen'],
                                  ],
                              ],
                          ],
                      ],
                  ],
              ],
          ],
      ],
  ];
                                                          
    $payload = json_encode($data_API,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);

    $ch = curl_init('https://api.insw.go.id/api-prod/inventory/pemasukan/tempInsert');
    $api_key = 'RqT40lH7Hy202uUybBLkFhtNnfAvxrlp';
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-insw-key:' . $api_key, 'Content-Type:application/json'));

    $result = curl_exec($ch);
    
    $sql_respon = $koneksi->query("INSERT INTO itv_transform_receipt_respon (id_transform_receipt,respon) VALUES ('$data_RAW[id_transform_receipt]','$result')");

     if (!empty($result)){
        $sql_update = $koneksi->query("UPDATE itv_transform_receipt SET submit_status='2' WHERE id_transform_receipt='$data_RAW[id_transform_receipt]' AND PurchaseReceiveItemNo='$PurchaseReceiveItemNo' AND PurchaseNo='$PurchaseNo' AND isdelete='1'"); 
        echo '1';
     }
     else {
        echo '2';
     }
    curl_close($ch);
  }
  //================ <END> Submit To LNSW API Update Status Transformed Data <END>===============//

?>
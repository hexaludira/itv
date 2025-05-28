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

 //===================== Insert User  =======================//
if (isset($_POST["username"])){
 
    $username =  $_POST["username"];
    $email =  $_POST["email"];
    $id_level =  $_POST["id_level"];
    $createddatetime = date('Y-m-d H:i:s');
    $createdby = $data_nama;
    $password = 'itv123456';
  
    $sql2 = "INSERT INTO user (username,email,password,id_level,createddatetime,createdby,isdelete)                                                                     
                            VALUES (
                                '$username',
                                '$email',
                                MD5('$password'),
                                '$id_level',
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
  
    //================ <END> Insert User <END>===============//

    //============================ Menampilkan Email ke Modal Edit  ================================//
  else if(isset($_POST["user_edit_id"])){
  $user_edit_id = $_POST["user_edit_id"];
  $sql = $koneksi->query("SELECT * FROM user WHERE id_user = $user_edit_id");

  $data = $sql->fetch_assoc();

  //kirim kembali ke view
  echo json_encode($data);
}
//======================= <END> Menampilkan Email ke Modal Edit <END> ==========================//
    
//======================= Mengupdate user dari Modal Edit (UPDATE) =======================//
else if (isset($_POST["id_user_update"])){
  $id_user = $_POST["id_user_update"];
  $username =  $_POST["username_update"];
  $email =  $_POST["email_update"];
  $id_level =  $_POST["id_level_update"];
  $lastupdateddatetime = date('Y-m-d H:i:s');
  $lastupdatedby = $data_nama;

  $sql_update = "UPDATE user SET username = '$username', email = '$email', id_level = '$id_level', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_user = $id_user";

  $query_update = mysqli_query($koneksi, $sql_update);   
  if ($query_update === TRUE){
      echo "1";
  } else {
      echo "2";
  }
}
//================= <END> Mengupdate user dari Modal Edit (UPDATE) <END> =================//

//============================== Delete user ======================================//
else if(isset($_POST["id_user_delete"])){
  $id_user = $_POST["id_user_delete"];
  $lastupdateddatetime = date('Y-m-d H:i:s');
  $lastupdatedby = $data_nama;

  $sql_delete = "UPDATE user SET isdelete = '2', lastupdateddatetime = '$lastupdateddatetime', lastupdatedby = '$lastupdatedby' WHERE id_user = $id_user";

  $query_delete = mysqli_query($koneksi, $sql_delete); 
  if($query_delete === TRUE ){
      echo "1";
  } else {
      echo "2";
  }
}
//=========================== <END> Delete user <END> ==================================//

//============================== Reset user ======================================//
else if(isset($_POST["id_user_reset"])){
  $id_user = $_POST["id_user_reset"];
  $password = 'itv123456';

  $sql_reset = "UPDATE user SET password = MD5('$password') WHERE id_user = $id_user";

  $query_reset = mysqli_query($koneksi, $sql_reset); 
  if($query_reset === TRUE ){
      echo "1";
  } else {
      echo "2";
  }
}
//=========================== <END> Reset user <END> ==================================//
 ?>
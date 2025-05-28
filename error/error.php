<?php

$error = $_SERVER["REDIRECT_STATUS"];

$error_tittle = '';
$error_message = '';
$error_sub = '';

if ($error == 404) {
  $error_tittle = '404 Page Not Found';
  $error_message = 'Halaman Tidak Ditemukan';
  $error_sub = 'Pastikan URL yang anda tuju benar.';
} elseif ($error == 403) {
  $error_tittle = '403 Access Denied';
  $error_message = 'Silahkan hubungi pengembang untuk info lebih lanjut.';
  $error_sub = 'Akses ditolak untuk mengakses halaman ini.';
}
?>

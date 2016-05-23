<?php
session_start();
include "../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='kategori_produk' AND $act=='hapus'){
  mysql_query("DELETE FROM kategori_produk WHERE id_kategori='$_GET[id]'");
  header('location:media.php?module='.$module);
}

// Input kategori
elseif ($module=='kategori_produk' AND $act=='input'){
$testing = addslashes($_POST[nama_kategori]);
  mysql_query("INSERT INTO kategori_produk(nama_kategori) VALUES('$testing')");
  header('location:media.php?module='.$module);
}

// Update kategori
elseif ($module=='kategori_produk' AND $act=='update'){
  $kategori_seo = seo_title($_POST['nama_kategori']);
  mysql_query("UPDATE kategori_produk SET nama_kategori = '$_POST[nama_kategori]' WHERE id_kategori = '$_POST[id]'");
  header('location:media.php?module='.$module);
}
?>

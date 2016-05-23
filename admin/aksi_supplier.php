<?php
session_start();
include "../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus Kategori
if ($module=='supplier' AND $act=='hapus'){
  mysql_query("DELETE FROM supplier WHERE id_supplier='$_GET[id]'");
  header('location:media.php?module='.$module);
}

// Input kategori
elseif ($module=='supplier' AND $act=='input'){
  mysql_query("INSERT INTO supplier(nama_supplier, no_rekening) VALUES('$_POST[nama_supplier]','$_POST[no_rekening]')");
  header('location:media.php?module='.$module);
}

// Update kategori
elseif ($module=='supplier' AND $act=='update'){
  mysql_query("UPDATE supplier SET nama_supplier = '$_POST[nama_supplier]',no_rekening = '$_POST[no_rekening]' WHERE id_supplier = '$_POST[id]'");
  header('location:media.php?module='.$module);
}
?>

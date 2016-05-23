<?php
session_start();
include "../config/koneksi.php";
include "../config/library.php";

$module=$_GET[module];
$act=$_GET[act];

// Hapus produk
if ($module=='produk' AND $act=='hapus'){
  mysql_query("DELETE FROM produk WHERE id_produk='$_GET[id]'");
  header('location:media.php?module='.$module.'&act=');
}

// Input produk
elseif ($module=='produk' AND $act=='input'){

    mysql_query("INSERT INTO produk(nama_produk,
                                    id_kategori,
									id_supplier,
                                    harga,
									harga_grosir,
									harga_pokok,
                                    stok,
									satuan,
									berat,
									diskon,
                                    deskripsi,
                                    tgl_masuk) 
                            VALUES('$_POST[nama_produk]',
                                   '$_POST[kategori]',
								   '$_POST[id_supplier]',
                                   '$_POST[harga]',
								   '$_POST[harga_grosir]',
								   '$_POST[harga_pokok]',
                                   '$_POST[stok]',
								   '$_POST[satuan]',
								   '$_POST[berat]',
								   '$_POST[diskon]',
                                   '$_POST[deskripsi]',
                                   '$tgl_sekarang')");
  
  header('location:media.php?module='.$module);
}

// Update produk
elseif ($module=='produk' AND $act=='update'){
$stok = $_POST[stok] + $_POST[stokmasuk];
    mysql_query("UPDATE produk SET nama_produk       = '$_POST[judul]',
                                   id_kategori       = '$_POST[kategori]',
								   id_supplier       = '$_POST[id_supplier]',
                                   harga             = '$_POST[harga]',
								   harga_grosir      = '$_POST[harga_grosir]',
								   harga_pokok       = '$_POST[harga_pokok]',
                                   stok              = '$stok',
								   satuan            = '$_POST[satuan]',
								   berat             = '$_POST[berat]',
								   diskon            = '$_POST[diskon]',
                                   deskripsi         = '$_POST[deskripsi]'
                             WHERE id_produk         = '$_POST[id]'");
 
  header('location:media.php?module='.$module);
}
?>

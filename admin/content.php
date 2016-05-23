<?php
include "../config/koneksi.php";
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/class_paging.php";
include "../config/fungsi_rupiah.php";
include "../config/session_admin.php";

if ($_GET['module']=='supplier'){
  include "supplier.php";
}

elseif ($_GET['module']=='user'){
  include "users.php";
}

elseif ($_GET['module']=='produk'){
  include "produk.php";
}

elseif ($_GET['module']=='order'){
  include "order.php";
}

elseif ($_GET['module']=='kategori_produk'){
  include "kategori.php";
}

else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}
?>

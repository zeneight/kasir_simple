<?php 
  session_start();	
  include "../config/koneksi.php";
  include "../config/fungsi_indotgl.php";
  include "../config/class_paging.php";
  include "../config/library.php";
  include "../config/fungsi_rupiah.php";
  include "../config/session_member.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kasir - Aplikasi Penjualan</title>
<link href="../view/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../view/js/dropdown.js"></script>
<script type="text/javascript" src="../view/js/highslide-with-html.js"></script>
<script type="text/javascript" src="../view/js/slideshow.js"></script>
<script type="text/javascript" src="../view/js/jscript_jquery-1.6.4.js"></script>
<script type="text/javascript" src="../view/js/utilities.js"></script>
</head>
<body>

<div id="container_wrapper">
	<div class="spacer"></div>
<div id="container">	
  <div id="header">
      <div id="inner_header">
			<img src='../view/images/header.jpg'>
      </div>
  </div>
    <div id="top"> 
<span class="cpojer-links"> 
		<a href="index.php">Halaman Utama</a> 
		<a href="semua-produk.html">Lihat Semua Produk</a>
		<a href="keranjang-belanja.html">Transaksi Penjualan</a> 		
		<a href="status-pembelian.html">Laporan Pembelian</a> 
		
		<a href="../logout.php">Logout</a>
</span>
</div>
 
  
		<div id="left_column">
			<div class="text_area" align="justify">	
				<?php include "kiri.php"; ?>
			</div>
		</div>
<div style='clear:both;'></div>
   <div style='color:#fff;' id="footer">
		<center>Copyright (c) 2015 - Sistem Kasir - Created by: <a href="http://www.facebook.com/zeneight" target="_blank">Agung Priambada</a></center>
    </div>     
</div>
<div class="spacer"></div>
</div>
</body>
</html>
<script type="text/javascript" src="../view/js/table_filter.js"></script>
<script type="text/javascript">
    (function($) {
        var table = $('#twitter-table');
        var index = 2;
        var input = $('#filter');

        zFilter.setup(input, table, index);

    })(jQuery);
</script>
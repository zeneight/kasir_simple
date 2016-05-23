<?php
session_start();
include "../config/session_admin.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin - Aplikasi Penjualan</title>
<link href="../view/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../view/js/jscript_jquery-1.6.4.js"></script>
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
		            <a href=?module=user&act=>Data Kasir</a> 
					<a href=?module=kategori_produk&act=>Kategori Produk</a>
					<a href=?module=produk&act=>Data Produk</a>
					<a href=?module=order&act=>Data Orderan</a>
					<a href=?module=supplier&act=>Data Supplier</a>
					<a href=../logout.php>Logout</a>
		</span>
	</div>
  
		<div id="left_column">
			<div class="text_area" align="justify">	
	<?php include "content.php"; ?>
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
        var index = 1;
        var input = $('#filter');

        zFilter.setup(input, table, index);

    })(jQuery);
</script>
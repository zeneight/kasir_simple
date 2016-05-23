<?php 
  session_start();
  ?>
<head>
<title>Laporan - Toko Tanpa Nama</title>
<style>
.input1 {
	height: 20px;
	font-size: 12px;
	padding-left: 5px;
	margin: 5px 0px 0px 5px;
	width: 97%;
	border: none;
	color: red;
}
table {
	border: 1px solid #cecece;
}
.td {
	border: 1px solid #cecece;
}
#kiri{
width:50%;
float:left;
}

#kanan{
width:50%;
float:right;
padding-top:20px;
margin-bottom:9px;
}
</style>
</head>

<body onLoad="window.print()">
<?php 
  include "../config/koneksi.php";
  include "../config/fungsi_indotgl.php";
  include "../config/library.php";
  include "../config/fungsi_rupiah.php";
  
  $aksi=0; $total=0;

echo "<center><h2 style='margin-bottom:3px;'>TOKO TANPA NAMA</h2>
    Struk Penjualan Barang untuk Pelanggan</center><hr/>";
				
   $edit = mysql_query("SELECT * FROM orders WHERE id_orders='$_GET[id]'");
    $r    = mysql_fetch_array($edit);
    $tanggal=tgl_indo($r['tgl_order']);
		
    echo "<div class='post_title'><b>Detail Informasi Order.</b></div>
          <form method=POST action=$aksi?module=order&act=update>
          <input type=hidden name=id value=$r[id_orders]>
          <table width=100%>
          <tr><td style='width:200px'>No. Order</td>        <td> : $r[id_orders]</td></tr>
          <tr><td>Tgl. & Jam Order</td> <td> : $tanggal & $r[jam_order]</td></tr>
          </table></form>";

  // tampilkan rincian produk yang di order
  $sql2=mysql_query("SELECT * FROM orders_detail, produk 
                     WHERE orders_detail.id_produk=produk.id_produk 
                     AND orders_detail.id_orders='$_GET[id]'");
  
  echo "<table width=100%>
        <tr style='color:#fff; height:35px;' bgcolor=#000><th>Nama Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Diskon</th><th>Sub Total</th></tr>";
  
  while($s=mysql_fetch_array($sql2)){
    
	if($s['jumlah']<=11){
	$h=$s['harga'];
  	}else {$h=$s['harga_grosir'];}
	
	$subtotal1    = ($h * $s['jumlah'])* $s['diskon']/100 ;
    $subtotal2    = $h * $s['jumlah'] ;
	$subtotal    = $subtotal2 - $subtotal1 ;
    $total       = $total + $subtotal;
    $subtotal_rp = format_rupiah($subtotal);    
    $total_rp    = format_rupiah($total);    
    $harga       = format_rupiah($h);
    echo "<tr><td>$s[nama_produk]</td><td>$s[jumlah]</td><td>Rp. $harga</td><td>$s[diskon]%</td><td>Rp. $subtotal_rp</td></tr>";
  }   
		
echo "<div class='post_title'><b>Detail Order yang harus di bayar.</b></div>
	  <table width=100%>
	  <tr><td>Total</td><td> Rp. <b>$total_rp</b></td></tr>   
      </table>
	  
	  <tr><td col><br/><span style='float:right; text-align:center;'> TOKO TANPA NAMA, $tgl_sekarang <br/>
										Kasir<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
	  
?>
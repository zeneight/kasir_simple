<?php 
  session_start();
  ?>
<head>
<title>Laporan - TOKO TANPA NAMA</title>
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

  $filter = $_POST[tahun];
  $bulan = Bulan($_POST[bulan]);
  
if (isset($_POST[submit])){
echo "<center><h2 style='margin-bottom:3px;'>TOKO TANPA NAMA</h2>
    Laporan Daftar Orderan Pada TOKO TANPA NAMA pada tahun : $_POST[tahun]</center><hr/>
				
		  <table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>No.order</th><th>Nama Konsumen</th><th>Alamat Lengkap</th><th>No Telpon</th><th>Tgl. Order</th><th>Jam</th><th>Status</th></tr>";
		  
		  $tampil=mysql_query("SELECT orders_detail.jumlah * produk.harga as total, sum(orders_detail.jumlah) as jumlahh,  orders.id_orders, orders.alamat, orders.nama_kustomer, orders.telpon, orders.tgl_order, orders.jam_order, orders.status_order FROM orders left join orders_detail on orders.id_orders=orders_detail.id_orders 
		  left join produk on orders_detail.id_produk=produk.id_produk where tgl_order like '$filter%' GROUP BY orders.id_orders");
		  $no = $no+1;
		  while ($r=mysql_fetch_array($tampil)){
		  $tanggal=tgl_indo($r['tgl_order']);
		  echo "<tr bgcolor=$warna>
				<td align=center>$no</td>
				<td align=center>$r[id_orders]</td>
                <td>$r[nama_kustomer]</td>
				<td>$r[alamat]</td>
				<td>$r[telpon]</td>
                <td>$tanggal</td>
                <td>$r[jam_order]</td>
                <td>$r[status_order]</td></tr>";
				$no++;
}
echo "</table><tr><td><br/><span style='float:right; text-align:center;'> TOKO TANPA NAMA, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
}else{
echo "<center><h2 style='margin-bottom:3px;'>TOKO TANPA NAMA</h2>
    Laporan Transaksi Pembelian Pada TOKO TANPA NAMA : $bulan $_POST[tahun]</center><hr/>
				
		  <table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>No.order</th><th>Nama Produk</th><th>Berat</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th></tr>";
		  
		  $tampil=mysql_query("SELECT orders_detail.jumlah * produk.harga as total, sum(orders_detail.jumlah) as jumlahh,  orders.id_orders, orders.nama_kustomer, orders.telpon, orders.tgl_order, orders.jam_order, orders.status_order, orders_detail.jumlah, produk.nama_produk, produk.berat, produk.harga  FROM orders left join orders_detail on orders.id_orders=orders_detail.id_orders 
		  left join produk on orders_detail.id_produk=produk.id_produk where tgl_order like '$filter%' GROUP BY orders.id_orders");
		  $no = $no+1;
		  while ($r=mysql_fetch_array($tampil)){
		  $tanggal=tgl_indo($r['tgl_order']);
		  echo "<tr bgcolor=$warna>
				<td align=center>$no</td>
				<td align=center>$r[id_orders]</td>
                <td>$r[nama_produk]</td>
				<td>$r[berat] Kg</td>
				<td>$r[jumlah]</td>
                <td>Rp $r[harga]</td>
                <td>Rp $r[total]</td></tr>";
				$no++;
}
echo "</table><tr><td><br/><span style='float:right; text-align:center;'> TOKO TANPA NAMA, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
}
?>
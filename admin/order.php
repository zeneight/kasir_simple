<?php
$aksi="aksi_order.php";
$no=0;
switch($_GET['act']){
  // Tampil Order
  default:
    echo "<div class='post_title'><b>Manajemen Konsumen Yang Order Produk.</b></div><br/>
          <form target='_BLANK' style='float:right;' method=POST action='print.php'>
							Laporan Perbulan : <select name='bulan'>
									<option value=0 selected>- Pilih Bulan -</option>";
									$tampil=mysql_query("SELECT substring(tgl_order,6,2) as bulan FROM orders GROUP BY substring(tgl_order,6,2)");
									while($r=mysql_fetch_array($tampil)){
									$bulan = Bulan($r['bulan']);
									  echo "<option value=$r[bulan]>$bulan</option>";
									}	
							echo "</select>
							<select name='tahun'>
									<option value=0 selected>- Pilih Tahun -</option>";
									$tampil=mysql_query("SELECT substring(tgl_order,1,4) as tahun FROM orders GROUP BY substring(tgl_order,1,4)");
									while($r=mysql_fetch_array($tampil)){
									  echo "<option value=$r[tahun]>$r[tahun]</option>";
									}
							echo "</select>
						<input type='submit' class='submitt' name='submit' value='Cetak Laporan'>
					</form>
		  <table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No.order</th><th>Nama Kasir</th><th>Tgl. Order</th><th>Jam</th><th align='center' width='200px;'>Action</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM orders ORDER BY id_orders DESC LIMIT $posisi,$batas");
  
    while($r=mysql_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_order']);
	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{
			$warna="#E1E1E1";
		  }
      echo "<tr bgcolor=$warna><td align=center>$r[id_orders]</td>
                <td>$r[nama_kustomer]</td>
                <td>$tanggal</td>
                <td>$r[jam_order]</td>
		            <td><a href=?module=order&act=detailorder&id=$r[id_orders]>Detail Order</a> | 
					<a target='_BLANK' href='faktur.php?id=$r[id_orders]'>Cetak Faktur</a>
					</td></tr>";
      $no++;
    }
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM orders"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
    echo "</table><br/>Halaman : $linkHalaman";

    break;
  
    
  case "detailorder":
  	$total= 0;
    $edit = mysql_query("SELECT * FROM orders WHERE id_orders='$_GET[id]'");
    $r    = mysql_fetch_array($edit);
    $tanggal=tgl_indo($r['tgl_order']);

    echo "<div class='post_title'><b>Detail Order.</b></div>
          <form method=POST action=$aksi?module=order&act=update>
          <input type=hidden name=id value=$r[id_orders]>
          <table width=100%>
          <tr><td>No. Order</td>        <td> : $r[id_orders]</td></tr>
          <tr><td>Tgl. & Jam Order</td> <td> : $tanggal & $r[jam_order]</td></tr>
          </table></form>";

  // tampilkan rincian produk yang di order
  $sql2=mysql_query("SELECT * FROM orders_detail, produk 
                     WHERE orders_detail.id_produk=produk.id_produk 
                     AND orders_detail.id_orders='$_GET[id]'");
  
  echo "<table width=100%>
        <tr style='color:#fff; height:35px;' bgcolor=#000><th>Nama Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Diskon</th><th>Sub Total</th></tr>";
  
  while($s=mysql_fetch_array($sql2)){
     // rumus untuk menghitung subtotal dan total	
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
      <table>";
		
  // tampilkan data kustomer
  echo "<br/><div class='post_title'><b></b></div>
	</div><table width=100%>
        </table>";

    break;  
}
?>

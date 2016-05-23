<script>
function validasi(form){
		  if (form.id.value == ""){
			alert("Anda belum mengisikan Kode Barang.");
			form.id.focus();
			return (false);
		  }
}
</script>
<?php
include "../config/session_member.php";

$sid=0; $no=0; $total_rp=0; $total=0;

if ($_GET['module']=='home'){
    echo "<div class='post_title'>Selamat Datang di Sistem Kasir</div>
          <div class='text_area'>Program Kasir ini dibuat oleh Agung Priambada [131120001] dan Yudi Hartawan [131120005]</div>"; 
}

elseif ($_GET['module']=='semuaproduk'){
  		echo "<div class='post_title'><b>Semua Produk / Barang</b></div><br />
		<span style='float:right;'>
			Cari Nama Produk : <input type='text' id='filter' style='width:200px; margin-bottom:3px;'/>
		</span><br/>
			 <div class='h_line'></div>
			 <table id='twitter-table' width=100% cellpadding=6>
			 
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>Kode</th><th>Nama Produk</th><th>Harga Ecer</th><th>Harga Grosir</th><th>Stok</th><th align='center' width='90px;'>Action</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM produk ORDER BY nama_produk ASC LIMIT $posisi,$batas");
  
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_masuk']);
      $harga=format_rupiah($r['harga']);
	  $harga_grosir=format_rupiah($r['harga_grosir']);
	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{
			$warna="#E1E1E1";
		  }
      echo "<tr bgcolor=$warna><td>$no</td>
				<td>$r[id_produk]</td>
                <td>$r[nama_produk]</td>
                <td>Rp $harga</td>
				<td>Rp $harga_grosir</td>
                <td align=center>$r[stok] $r[satuan]</td>
		            <td><a href='aksi.php?module=keranjang&act=tambah&id=$r[id_produk]'>Pilih Produk</a></td>
		        </tr>";
      $no++;
    }
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM produk"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
    echo "</table><br/>Halaman : $linkHalaman";
}

elseif ($_GET['module']=='keranjangbelanja'){
  echo "<div class='post_title'><b>Ini adalah daftar barang yang sudah anda Order.</b></div><br />
			 <div class='h_line'></div>"; 
	?><form method='GET' action='aksi.php' onSubmit="return validasi(this)"> <?php
				echo "<input type='hidden' name='module' value='keranjang'>
				<input type='hidden' name='act' value='tambah'>
				<input type='text' name='id' placeholder='Kode Barang'>
				<input type='submit' value='Beli'><input type=button value='Cari Produk' onclick=\"window.location.href='semua-produk.html';\">
		  </form>";
	$sql = mysql_query("SELECT * FROM orders_temp, produk 
			                WHERE id_session='$_SESSION[namauser]' AND orders_temp.id_produk=produk.id_produk");
  $ketemu=mysql_num_rows($sql);
  
    echo "<form method=post action=aksi.php?module=keranjang&act=update>
          <table style='border:1px solid #e3e3e3;' width=100% celllpadding=6>
          <tr style='color:#fff;  height:35px;' bgcolor=#000><th>Kode</th><th>Nama Produk</th><th>Jumlah</th>
          <th>Harga</th><th>Sub Total</th><th></th></tr>";  
  
  $no=1;
	  
  while($r=mysql_fetch_array($sql)){
	  
	if($r['jumlah']<=11){
	$h=$r['harga'];
  	}else {$h=$r['harga_grosir'];}
	
	$subtotal    = $h * $r['jumlah'];
	$subtotaldiskon = $subtotal * $r['diskon']/100;
	$diskontotal = $subtotal - $subtotaldiskon;
    $total       = $total + $subtotal - $subtotaldiskon;  
    $subtotal_rp = format_rupiah($diskontotal);
    $total_rp    = format_rupiah($total);
    $harga       = format_rupiah($h);
    if(($no % 2)==0){
    $warna="#E1E1E1";
  	}
  	else{
	$warna="#ffffff";
	}

  
    echo "<tr bgcolor=$warna><input type=hidden name=id[$no] value=$r[id_orders_temp]>
              <td width='70px'>$r[id_produk]</td>
			  <td>$r[nama_produk]</td>
			  <input type=hidden name='stok[$no]' value='$r[stok]' size=4>
              <td><input type=text name='jml[$no]' value='$r[jumlah]' size=1 onkeypress=\"return harusangka(event)\"> $r[satuan]</td>
              <td>Rp $harga</td>
              <td>Rp $subtotal_rp</td>
              <td align=center><a href='aksi.php?module=keranjang&act=hapus&id=$r[id_orders_temp]'>
              Hapus</a></td>
          </tr>";
    $no++;
  }
  $sql = mysql_query("SELECT * FROM orders_temp, produk 
			                WHERE id_session='$sid' AND orders_temp.id_produk=produk.id_produk");
  $r=mysql_fetch_array($sql);
  echo "<tr>
  			<td colspan=4 align=right>
			<hr style='color:#e3e3e3;'><br><b style='font-size:27px; color:blue;'>Total</b> : </td>
			<td colspan=2><hr style='color:#e3e3e3;'><br><b style='font-size:27px; color:red;'> Rp. $total_rp</b></td>
		</tr>
        
		<tr>
			<td colspan=2><br />
			<input class='belanja' style='height:36px; width:150px; margin-left:9px;' type=submit value='Update' border=0><br /></td>
			<td colspan=4 align=right><br />
			<a class='belanja' href='simpan-transaksi.html'>Selesai</a><br /></td>
		</tr>
        </table></form><br />";  
}

elseif ($_GET['module']=='statuspembelian'){
    echo "<div class='post_title'><b>Berikut Ini adalah Laporan Pembelian Barang / Produk Oleh Customer</b></div><br/>
		 <div class='h_line'></div>
          <table cellpadding=6 width=100%>
          <tr style='color:#fff' bgcolor=#000><th>No order</th><th>Nama Kasir</th><th>Tgl Order</th><th>Jam</th><th align='center'>Action</th></tr>";
          
    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
					 
    $tampil = mysql_query("SELECT * FROM orders where nama_kustomer='$_SESSION[namalengkap]' ORDER BY id_orders DESC LIMIT $posisi,$batas");
  
    while($r=mysql_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_order']);
	  if(($no % 2)==0){
    $warna="#ffffff";
  	}
  	else{
    $warna="#E1E1E1";
  	}
      echo "<tr bgcolor=$warna><td align=center>$r[id_orders]</td>
                <td>$r[nama_kustomer]</td>
                <td>$tanggal</td>
                <td>$r[jam_order]</td>
				<td><center><a target='_BLANK' href='faktur.php?id=$r[id_orders]'>Cetak Struk Penjualan</a>
				</center></td></tr>";
      $no++;
    }
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM orders where nama_kustomer='$_SESSION[namalengkap]'"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "</table>";
    echo "<br/>Halaman: $linkHalaman<br>";
	}

elseif ($_GET['module']=='simpantransaksi'){
function isi_keranjang(){
	$isikeranjang = array();
	$sid = $_SESSION['namauser'];
	$sql = mysql_query("SELECT * FROM orders_temp WHERE id_session='$sid'");
	
	while ($r=mysql_fetch_array($sql)) {
		$isikeranjang[] = $r;
	}
	return $isikeranjang;
}

$tgl_skrg = date("Ymd");
$jam_skrg = date("H:i:s");

mysql_query("INSERT INTO orders(nama_kustomer, tgl_order, jam_order) 
             VALUES('$_SESSION[namalengkap]','$tgl_skrg','$jam_sekarang')");
  
$id_orders=mysql_insert_id();
$isikeranjang = isi_keranjang();
$jml          = count($isikeranjang);

for ($i = 0; $i < $jml; $i++){
  mysql_query("INSERT INTO orders_detail(id_orders, id_produk, jumlah) 
               VALUES('$id_orders',{$isikeranjang[$i]['id_produk']}, {$isikeranjang[$i]['jumlah']})");
}
  
for ($i = 0; $i < $jml; $i++) {
	mysql_query("UPDATE produk SET stok = stok - {$isikeranjang[$i]['jumlah']}
						    WHERE id_produk = {$isikeranjang[$i]['id_produk']}");
}

for ($i = 0; $i < $jml; $i++) {
	mysql_query("UPDATE produk SET dibeli = dibeli + {$isikeranjang[$i]['jumlah']}
						    WHERE id_produk = {$isikeranjang[$i]['id_produk']}");
}

  mysql_query("DELETE FROM orders_temp
	  	         WHERE id_session = '$_SESSION[namauser]'");
   
echo "<script>window.alert('Transaksi Sukses !!!');
        window.location=('keranjang-belanja.html')</script>";    
}
?>


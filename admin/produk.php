<?php
$aksi="aksi_produk.php";
switch($_GET['act']){
  // Tampil Produk
  default:
    echo "<div class='post_title'>
			<b>Manajemen Produk Mini Market.</b>
			
			<span style='float:right'>
				<a style='float:right;' target='_BLANK' href='print-produk.php'>Cetak Laporan Produk</a>
			</span>
		  </div>
		  <br/>
          
		  <input type=button value='Tambah Produk' onclick=\"window.location.href='?module=produk&act=tambahproduk';\">
          
		  <span style='float:right;'>
			Cari Nama Produk : <input type='text' id='filter' style='width:200px; margin-bottom:3px;'/>
		  </span>
		  <br/>
		  
		  <div class='h_line'>
		  </div>
			
			<table id='twitter-table' width=100% cellpadding=6>
          
		  		<tr style='color:#fff; height:35px;' bgcolor=#000>
		  			<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Ecer</th>
					<th>Harga Grosir</th>
					<th>Harga Pokok</th>
					<th>Stok</th>
					<th align='center' width='90px;'>Action</th>
		  		</tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM produk left join supplier on produk.id_supplier=supplier.id_supplier 
								left join kategori_produk on produk.id_kategori=kategori_produk.id_kategori ORDER BY nama_produk ASC LIMIT $posisi,$batas");
  
    $no = $posisi+1;
    
	while($r=mysql_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_masuk']);
      $harga=format_rupiah($r['harga']);
	  $harga_pokok=format_rupiah($r['harga_pokok']);
	  $harga_grosir=format_rupiah($r['harga_grosir']);
	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{	
			$warna="#E1E1E1";
		  }
      echo "<tr bgcolor=$warna><td>$no</td>
                <td><a href='#' title='Pemasok : $r[nama_supplier]'>$r[nama_produk]</td>
                <td>Rp $harga</td>
				<td>Rp $harga_grosir</td>
				<td>Rp $harga_pokok</td>
                <td align=center>$r[stok] $r[satuan]</td>
		            <td><a href=?module=produk&act=editproduk&id=$r[id_produk]>Edit</a> | 
		                <a href=$aksi?module=produk&act=hapus&id=$r[id_produk] onclick='return confirm('Apakah anda yakin akan menghapus data?')'	>Hapus</a></td>
		        </tr>";
      $no++;
    }
	$jmldata = mysql_num_rows(mysql_query("SELECT * FROM produk"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
    echo "</table><br/>Halaman : $linkHalaman";
 
    break;


  // Detail Kategori
  case "detail_kategori":
  	$idk=$_GET['idk'];
	echo "<div class='post_title'>
			<b>Manajemen Kategori Produk.</b>
		  </div>
		  
		  <br/>
		  <span style='float:right;'>
			Cari Nama Produk : <input type='text' id='filter' style='width:200px; margin-bottom:3px;'/>
		  </span>
		  <br/>
		  
		  <div class='h_line'>
		  </div>
			
			<table id='twitter-table' width=100% cellpadding=6>
          
		  		<tr style='color:#fff; height:35px;' bgcolor=#000>
		  			<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Ecer</th>
					<th>Harga Grosir</th>
					<th>Harga Pokok</th>
					<th>Stok</th>
					<th>Nama Kategori</th>
					<th align='center' width='90px;'>Action</th>
		  		</tr>";

    $tampil = mysql_query("SELECT * FROM produk left join supplier on produk.id_supplier=supplier.id_supplier 
								left join kategori_produk on produk.id_kategori=kategori_produk.id_kategori WHERE kategori_produk.id_kategori='$idk'");
  	$no=0;
	$no=$no+1;
    
	while($d=mysql_fetch_array($tampil)){
		
      $tanggal=tgl_indo($d['tgl_masuk']);
      $harga=format_rupiah($d['harga']);
	  $harga_pokok=format_rupiah($d['harga_pokok']);
	  $harga_grosir=format_rupiah($d['harga_grosir']);
	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{
			$warna="#E1E1E1";
		  }
      echo "<tr bgcolor=$warna><td>$no</td>
                <td><a href='#' title='Pemasok : $d[nama_supplier]'>$d[nama_produk]</td>
                <td>Rp $harga</td>
				<td>Rp $harga_grosir</td>
				<td>Rp $harga_pokok</td>
                <td align=center>$d[stok] $d[satuan]</td>
				<td>$d[nama_kategori]</td>
		        <td><a href=?module=produk&act=editproduk&id=$d[id_produk]>Edit</a> | 
		            <a href=$aksi?module=produk&act=hapus&id=$d[id_produk] onclick='return confirm('Apakah anda yakin akan menghapus data?')'>Hapus</a></td>
		    </tr>";
	   $no++;
	}
	
    echo "</table><br/>";
 
    break;
	
	
	// Detail Distributor
  case "detail_dis":
  	$idd=$_GET['idd'];
	echo "<div class='post_title'>
			<b>Manajemen Supplier Produk</b>
		  </div>
		  
		  <br/>
		  <span style='float:right;'>
			Cari Nama Produk : <input type='text' id='filter' style='width:200px; margin-bottom:3px;'/>
		  </span>
		  <br/>
		  
		  <div class='h_line'>
		  </div>
			
			<table id='twitter-table' width=100% cellpadding=6>
          
		  		<tr style='color:#fff; height:35px;' bgcolor=#000>
		  			<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Ecer</th>
					<th>Harga Grosir</th>
					<th>Harga Pokok</th>
					<th>Stok</th>
					<th>Nama Supplier</th>
					<th align='center' width='90px;'>Action</th>
		  		</tr>";

    $tampil = mysql_query("SELECT * FROM produk left join supplier on produk.id_supplier=supplier.id_supplier 
								left join kategori_produk on produk.id_kategori=kategori_produk.id_kategori WHERE supplier.id_supplier='$idd'");
  	$no=0;
	$no=$no+1;
    
	while($d=mysql_fetch_array($tampil)){
		
      $tanggal=tgl_indo($d['tgl_masuk']);
      $harga=format_rupiah($d['harga']);
	  $harga_pokok=format_rupiah($d['harga_pokok']);
	  $harga_grosir=format_rupiah($d['harga_grosir']);
	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{
			$warna="#E1E1E1";
		  }
      echo "<tr bgcolor=$warna><td>$no</td>
                <td><a href='#' title='Pemasok : $d[nama_supplier]'>$d[nama_produk]</td>
                <td>Rp $harga</td>
				<td>Rp $harga_grosir</td>
				<td>Rp $harga_pokok</td>
                <td align=center>$d[stok] $d[satuan]</td>
				<td>$d[nama_supplier]</td>
		        <td><a href=?module=produk&act=editproduk&id=$d[id_produk]>Edit</a> | 
		            <a href=$aksi?module=produk&act=hapus&id=$d[id_produk] onclick='return confirm('Apakah anda yakin akan menghapus data?')'>Hapus</a></td>
		    </tr>";
	   $no++;
	}
	
    echo "</table><br/>";
 
    break;
	
  
  
  case "tambahproduk":
    echo "<div class='post_title'><b>Tambah Produk.</b></div><br/>
          <form method=POST action='$aksi?module=produk&act=input' enctype='multipart/form-data'>
          <table>
          <tr><td width=120>Nama Produk</td>     <td> : <input type=text name='nama_produk' size=60></td></tr>
          <tr><td>Kategori</td>  <td> : 
          <select name='kategori'>
            <option value=0 selected>- Pilih Kategori -</option>";
            $tampil=mysql_query("SELECT * FROM kategori_produk ORDER BY nama_kategori");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
            }
    echo "</select></td></tr>
		  <tr><td>Supplier </td>  <td> : 
          <select name='id_supplier'>
            <option value=0 selected>- Pilih Supplier -</option>";
            $tampil=mysql_query("SELECT * FROM supplier ORDER BY nama_supplier");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[id_supplier]>$r[nama_supplier]</option>";
            }
    echo "</select></td></tr>
          <tr><td>Harga</td>     <td> : <input type=text name='harga' size=20></td></tr>
		  <tr><td>Harga grosir</td>     <td> : <input type=text name='harga_grosir' size=20></td></tr>
		  <tr><td>Harga Pokok</td>     <td> : <input type=text name='harga_pokok' size=20></td></tr>
		  <tr><td>Satuan</td>     <td> : <input type=text name='satuan' size=20></td></tr>
          <tr><td>Stok</td>     <td> : <input type=text name='stok' size=20></td></tr>
		  <input type=hidden name='berat' size=20 value='0'>
		  <tr><td>Diskon</td>     <td> : <input type=text name='diskon' size=20></td></tr>
          <tr><td>Deskripsi</td>  <td> : <textarea name='deskripsi' style='width: 470px; height: 60px;'></textarea>
          <tr><td colspan=2><br/><input style='float:right;' type=button value=Batal onclick=self.history.back()>
							<input style='float:right;' type=submit value=Simpan></td></tr>
          </table></form>";
     break;
    
  case "editproduk":
    $edit = mysql_query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<div class='post_title'><b>Edit Produk.</b></div><br/>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=produk&act=update>
          <input type=hidden name=id value=$r[id_produk]>
          <table>
          <tr><td width=120>Nama Produk</td>     <td> : <input type=text name='judul' size=60 value='$r[nama_produk]'></td></tr>
          <tr><td>Kategori</td>  <td> : <select name='kategori'>";
 
          $tampil=mysql_query("SELECT * FROM kategori_produk ORDER BY nama_kategori");
          if ($r['id_kategori']==0){
            echo "<option value=0 selected>- Pilih Kategori -</option>";
          }   

          while($w=mysql_fetch_array($tampil)){
            if ($r['id_kategori']==$w['id_kategori']){
              echo "<option value=$w[id_kategori] selected>$w[nama_kategori]</option>";
            }
            else{
              echo "<option value=$w[id_kategori]>$w[nama_kategori]</option>";
            }
          }
    echo "</select></td></tr>
	
		   <tr><td>Supplier</td>  <td> : <select name='id_supplier'>";
 
          $tampil=mysql_query("SELECT * FROM supplier ORDER BY nama_supplier");
          if ($r['id_supplier']==0){
            echo "<option value=0 selected>- Pilih Supplier -</option>";
          }   

          while($w=mysql_fetch_array($tampil)){
            if ($r['id_supplier']==$w['id_supplier']){
              echo "<option value=$w[id_supplier] selected>$w[nama_supplier]</option>";
            }
            else{
              echo "<option value=$w[id_supplier]>$w[nama_supplier]</option>";
            }
          }
    echo "</select></td></tr>
          <tr><td>Harga</td>     <td> : <input type=text name='harga' value='$r[harga]' size=20></td></tr>
		  <tr><td>Harga Grosir</td>     <td> : <input type=text name='harga_grosir' value='$r[harga_grosir]' size=20></td></tr>
		  <tr><td>Harga Pokok</td>     <td> : <input type=text name='harga_pokok' value='$r[harga_pokok]' size=20></td></tr>
          <tr><td>Satuan</td>     <td> : <input type=text name='satuan' value='$r[satuan]' size=20></td></tr>
		  <tr><td>Stok</td>     <td> : <input type=text name='stok' value='$r[stok]' size=10> - <input type=text name='stokmasuk' size=10></td></tr>
		  <input type=hidden name='berat' size=20 value='0'>
		  <tr><td>Diskon</td>     <td> : <input type=text name='diskon' value='$r[diskon]' size=20></td></tr>
          <tr><td>Deskripsi</td>   <td> : <textarea name='deskripsi' style='width: 470px; height: 60px;'>$r[deskripsi]</textarea>
          <tr><td colspan=2><br/><input style='float:right;' type=button value=Batal onclick=self.history.back()>
							<input style='float:right;' type=submit value=Update></td></tr>
         </table></form>";
    break;  
}
?>
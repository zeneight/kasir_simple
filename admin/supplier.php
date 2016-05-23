<?php
$aksi="aksi_supplier.php";
switch($_GET['act']){
  // Tampil Kategori
  default:
    echo "<div class='post_title'><b>Manajemen supplier Produk.</b></div><br/>
          <input type=button value='Tambah Supplier' 
          onclick=\"window.location.href='?module=supplier&act=tambahsupplier';\">
          <table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>Nama supplier</th><th>No Rekening</th><th align='center' width='90px;'>Action</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM supplier ORDER BY id_supplier DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
	if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{
			$warna="#E1E1E1";
		  }
       echo "<tr bgcolor=$warna><td>$no</td>
             <td><a href=?module=produk&act=detail_dis&idd=$r[id_supplier]>$r[nama_supplier]</a></td>
			 <td>$r[no_rekening]</td>
             <td><a href=?module=supplier&act=editsupplier&id=$r[id_supplier]>Edit</a> | 
	               <a href=$aksi?module=supplier&act=hapus&id=$r[id_supplier]>Hapus</a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah Kategori
  case "tambahsupplier":
    echo "<div class='post_title'><b>Tambah supplier Produk.</b></div><br/>
          <form method=POST action='$aksi?module=supplier&act=input'>
          <table>
          <tr><td>Nama supplier</td><td> : <input type=text name='nama_supplier' style='width:350px;'></td></tr>
		  <tr><td>No Rekening</td><td> : <input type=text name='no_rekening' style='width:350px;'></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Kategori  
  case "editsupplier":
    $edit=mysql_query("SELECT * FROM supplier WHERE id_supplier='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<div class='post_title'><b>Edit supplier Produk.</b></div><br/>
          <form method=POST action=$aksi?module=supplier&act=update>
          <input type=hidden name=id value='$r[id_supplier]'>
          <table>
          <tr><td>Nama supplier</td><td> : <input type=text name='nama_supplier' value='$r[nama_supplier]' style='width:350px;'></td></tr>
          <tr><td>No Rekening</td><td> : <input type=text name='no_rekening' value='$r[no_rekening]' style='width:350px;'></td></tr>
		  <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

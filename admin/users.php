<?php
  $aksi="aksi_users.php";
switch($_GET['act']){
  // Tampil User
  default:
      $tampil = mysql_query("SELECT * FROM users ORDER BY username");
      echo "<div class='post_title'><b>Manajemen User / Kasir Minimarket.</b></div><br/>";
    
    echo "<table width=100% cellpadding='7'>
			 <a style='float:right;' target='_BALNK' href='print-members.php'>Cetak laporan Members</a>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>Username</th><th>Nama Lengkap</th><th>Alamat Email</th><th>No.Telp/HP</th><th align='center' width='100px'>Action</th></tr>"; 
    $no=1;
	
    while ($r=mysql_fetch_array($tampil)){
	if(($no % 2)==0){
    $warna="#ffffff";
  }
  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
  else{
    $warna="#E1E1E1";
  }
       if ($r['level'] == 'admin'){
	   echo "<tr bgcolor=red style='color:#fff;'>";
	   }else{
	   echo "<tr bgcolor=$warna>";
	   }
			echo " <td>$no</td>
             <td>$r[username]</td>
             <td>$r[nama_lengkap]</td>
			 <td>$r[email]</td>
		         <td>$r[no_telp]</td>
             <td><a href=?module=user&act=edituser&id=$r[id_session]>Edit Data</a></td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  case "aktif":
   mysql_query("UPDATE users set aktif='Y' where username='$_GET[user]'");
   echo "<script>window.alert('Sukses Aktifkan User Terpilih');
        window.location=('?module=user')</script>";
  break;
  
  case "edituser":
    $edit=mysql_query("SELECT * FROM users WHERE id_session='$_GET[id]'");
    $r=mysql_fetch_array($edit);
    echo "<div class='post_title'><b>Edit User.</b></div><br/>
		 <div class='h_line'></div>
          <form method=POST action=$aksi?module=user&act=update>
          <input type=hidden name=id value='$r[id_session]'>
          <table width='100%'>
          <tr><td>Username</td>     <td> : <input type=text name='username' value='$r[username]' disabled> **)</td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password'> *) </td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' size=30  value='$r[nama_lengkap]'></td></tr>
          <tr><td>E-mail</td>       <td> : <input type=text name='email' size=30 value='$r[email]'></td></tr>
          <tr><td>No.Telp/HP</td>   <td> : <input type=text name='no_telp' size=30 value='$r[no_telp]'></td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";      
  
    break;  
}

?>

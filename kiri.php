<?php
if ($_GET['module']=='home'){
echo "<div class=post_title><center><b>Silahkan Login dengan Username dan Password anda.</b></center></div><br /><br /><br />

		<form method=POST name='formku' onSubmit='return valid()' action=cek_login.php>
			<td align=center><div align='center'>
			  <pad><table>
				<tr><td><b>Username</b></td><td> : <input type=text name=id_user class=input> </td></tr>
				<tr><td><b>Level</b></td>
				  <td> : <select name=level class=input>
					<option value='Customer' selected>Kasir</option>
					<option value='Admin'>Admin</option>
					</select>
					<tr><td><b>Password</b></td>
					<td> : <input type=password name=password class=input></td><td><input type=submit value=Login class=submit></td></tr>
			  </table></pad>
			</div></td>
		</form><br/><br/><br/><br /><br />";  
}
?>
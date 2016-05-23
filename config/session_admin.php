<?php
if(!($_SESSION['sesi']=="admin"))
{
		echo "<script>window.alert('Untuk mengakses, Anda harus Login Sebagai Admin');
        window.location=('../login.html')</script>";
}
?>
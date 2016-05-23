<?php
if(!($_SESSION['sesi']=="member"))
{
	echo "<script>window.alert('Untuk mengakses, Anda harus Login Sebagai Kasir');
        window.location=('../login.html')</script>";
}
?>
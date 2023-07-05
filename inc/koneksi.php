<?php 
	$server = "localhost"; 
	$username = "root"; 
	$password = ""; 

	$conn = mysqli_connect($server, $username, $password);

	if($conn){ 
		mysqli_select_db($conn, "dbnectarine");
	}else{
		die("Server Gagal! Silahkan Kontak Admin!");
	}
?>
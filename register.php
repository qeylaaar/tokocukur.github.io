<?php

require 'db.php';

if (isset($_POST['submit'])) {
	if (registrasi($_POST) > 0) {
		echo "<script>
			alert('Registrasi berhasil');
		</script>";
	} else {
		echo "<script>
			alert('Registrasi gagal ');
		</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daftar | Tokocukur</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body id="bg-login">
	<div class="box-login">
		<h2>Register</h2>
		<form action="" method="POST">
			<input type="text" name="username" placeholder="New Username" class="input-control">
			<input type="password" name="password1" placeholder="New Password" class="input-control">
			<input type="password" name="password2" placeholder="Confirm Password" class="input-control">
			<input type="number" name="no_telp" placeholder="No Telp" class="input-control">
			<input type="email" name="email" placeholder="New Email" class="input-control">
			<input type="text" name="address" placeholder="New Address" class="input-control">
			<input type="submit" name="submit" value="Register" class="button">
		</form>
		<p>Sudah punya akun ? Login <a href="login.php" style="color: blue;">Disini</a></p>
	</div>
</body>

</html>
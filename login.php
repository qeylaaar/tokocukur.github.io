<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Tokocukur</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body id="bg-login">
	<div class="box-login">
		<h2>Login</h2>
		<form action="" method="POST">
			<input type="text" name="user" placeholder="Username" class="input-control">
			<input type="password" name="pass" placeholder="Password" class="input-control">
			<input type="submit" name="submit" value="Login" class="button">
		</form>
		<p>Tidak punya akun ? Register <a href="register.php" style="color: blue;">Disini</a></p>
		<?php
		if (isset($_POST['submit'])) {
			session_start();
			include 'db.php';
			$user = mysqli_real_escape_string($conn, $_POST['user']);
			$pass = mysqli_real_escape_string($conn, $_POST['pass']);

			$cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$user' ");
			if (mysqli_num_rows($cek) === 1) {
				$d = mysqli_fetch_object($cek);
				$_SESSION['status_login'] = true;
				$_SESSION['a_global'] = $d;
				$_SESSION['id'] = $d->admin_id;
				echo '<script>window.location="dashboard.php"</script>';
			} else {
				echo '<script>alert("Username Atau Password Anda Salah!")</script>';
			}
		}
		?>
	</div>
</body>

</html>
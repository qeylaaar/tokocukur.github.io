<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
	echo '<script>window.location="login.php"</script>';
}
$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '" . $_SESSION['id'] . "' ");
$d = mysqli_fetch_object($query);

// GET URL
$edit_profile = (isset($_GET['edit_profile'])) ? $_GET['edit_profile'] : false;

if (isset($_POST['edit_profile'])) {
	if(ubahProfile($_POST) > 0 ){
		echo "
			<script>
				alert('data berhasil diubah');
				window.location.href = 'profile.php';
			</script>
		";
	}else{
		echo "
			<script>
				alert('data gagal diubah');
			</script>
		";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tokocukur</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<style>
		.card {
			border: 2px solid #2381d9;
			box-shadow: 5px 6px 0px #2381d9;
			transition: 0.3s all;
			border-radius: 3px;
			margin: 0 auto;
			background-color: #fff;
			padding: 21px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			text-align: center;
			width: 340px;
			max-width: 95%;
		}

		.title {
			font-size: 26px;
			margin-top: 18px;
			color: #2381d9;
		}

		.description {
			font-size: 17px;
			margin-top: 18px;
			color: #64707d;
		}
	</style>
</head>

<body>
	<!-- Header boi -->
	<header>
		<div class="container">
			<h1><a href="dashboard.php">Tokocukur</a></h1>
			<ul>
				<li><a href="dashboard.php">Dashboard</a></li>
				<li><a href="profile.php">Profile</a></li>
				<li><a href="data-kategori.php">Data Kategori</a></li>
				<li><a href="data-produk.php">Data Produk</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
	</header>
	</div>

	<!-- Content -->
	<div class="card" style="margin-top: 1rem; margin-bottom: 3rem;">
		<div class="title">
			<h2><?= $d->username ?></h2>
		</div>
		<div class="description">
			<form action="" method="POST">
				<input type="hidden" name="id" id="id" value="<?= $d->admin_id ?>">
				<input type="text" name="username" class="input-control" value="<?= $d->username ?>" <?php if($edit_profile === 'true'){echo '';}else{echo 'disabled';} ?>>
				<input type="number" name="no_telp" class="input-control" value="<?= $d->admin_telp ?>" <?php if($edit_profile === 'true'){echo '';}else{echo 'disabled';} ?>>
				<input type="email" name="email" class="input-control" value="<?= $d->admin_email ?>" <?php if($edit_profile === 'true'){echo '';}else{echo 'disabled';} ?>>
				<input type="text" name="address" class="input-control" value="<?= $d->admin_adress ?>" <?php if($edit_profile === 'true'){echo '';}else{echo 'disabled';} ?>>
				<?php if($edit_profile === 'true') : ?>
				<input type="submit" value="Edit" class="button" name="edit_profile">
				<?php endif; ?>
			</form>
			<?php if ($edit_profile === 'true') {
				echo "<a href='profile.php'>Batal &times;</a>";
			} else {
				echo "<a href='?edit_profile=true&id=$d->admin_id'>Edit Profile</a>";
			} ?>

		</div>
	</div>
	<!-- Content -->

	<!-- Footer -->
	<footer>
		<div class="container">
			<small>Anda Bosen Liat Copyright ini? Sama, saya juga bosen. &copy; 2021 - Alva</small>
		</div>
	</footer>
</body>

</html>
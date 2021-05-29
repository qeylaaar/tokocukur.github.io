<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
	echo '<script>window.location="login.php"</script>';
}
$sqlKategori = "SELECT * FROM tb_category ORDER BY category_id DESC";
$kategories = query($sqlKategori);

// URL GET
$modal = (isset($_GET['modal'])) ? $_GET['modal'] : null;
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
$categoriName = (isset($_GET['categoriName'])) ? $_GET['categoriName'] : null;
$hapus = (isset($_GET['hapus'])) ? $_GET['hapus'] : false;
// URL GET

// ADD CATEGORY LOGIC
if (isset($_POST['tambah-category'])) {
	if (tambahCategory($_POST) > 0) {
		echo "
			<script>
				alert('data berhasil ditambah');
				document.location.href = './data-kategori.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal ditambah');
				document.location.href = './data-kategori.php';
			</script>
		";
	}
}

// EDIT LOGIC
if (isset($_POST['edit-category'])) {
	if (ubahCategory($_POST) > 0) {
		echo "
			<script>
				alert('data berhasil diubah');
				document.location.href = './data-kategori.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal diubah');
				document.location.href = './data-kategori.php';
			</script>
		";
	}
}

// DELETE CATEGORY LOGIC
if ($hapus === 'true') {
	if (hapusCategory($id) > 0) {
		echo "
			<script>
				alert('data berhasil dihapus');
				document.location.href = './data-kategori.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal dihapus');
				document.location.href = './data-kategori.php';
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
		/* FORM STYLE */
		/* FORM */
		.form-grup {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
		}

		.input,
		select {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

		.submit-input {
			width: 100%;
			background-color: #2381d9;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		.submit-input:hover {
			background-color: #2381d9;
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

	<!-- <h1>sedang dalam perbaikan, biasalah</h1> -->
	<!-- Content -->
	<div class="section">
		<div class="container">
			<h3>Data Kategori</h3>
			<a href="?modal=true" class="fas fa-plus">Tambah Data Kategori</a>
			<div class="box">
				<table border="1" cellspacing="0" class="table" style="text-align: center;">
					<thead>
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; ?>
						<?php foreach ($kategories as $kategori) : ?>
							<tr>
								<td><?= $i ?></td>
								<td><?= $kategori['category_name'] ?></td>
								<td>
									<a href="?modal=true&id=<?= $kategori['category_id'] ?>&categoriName=<?= $kategori['category_name'] ?>" class="fas fa-edit"> Edit</a> | <a href="?hapus=true&id=<?= $kategori['category_id'] ?>" class="fas fa-trash" onclick="return confirm('Yakin')"> Hapus</a>
								</td>
							</tr>
							<?php $i++ ?>
						<?php endforeach; ?>
					</tbody>
				</table>

				<!-- EDIT FORM -->
				<?php if ($modal === 'true') : ?>
					<?php if ($id != null) : ?>
						<div class="form-grup" style="margin-top: 1rem;">
							<form action="" method="POST">
								<a style="float: right;" href="./data-kategori.php"><i class="fas fa-times"></i></a>
								<input type="hidden" name="id" id="id" value="<?= $id ?>">
								<input type="text" id="category_name" name="category_name" placeholder="<?= $categoriName ?>" class="input">

								<input type="submit" name="edit-category" value="Submit" class="submit-input">
							</form>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<!-- EDIT FORM -->

				<!-- FORM ADD CATEGORY -->
				<?php if ($modal === 'true') : ?>
					<?php if ($id === null) : ?>
						<div class="form-grup" style="margin-top: 1rem;">
							<form action="" method="POST">
								<a style="float: right;" href="./data-kategori.php"><i class="fas fa-times"></i></a>
								<input type="text" id="category_name" name="category_name" placeholder="<?= $categoriName ?>" class="input">

								<input type="submit" name="tambah-category" value="Tambah" class="submit-input">
							</form>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<!-- FORM ADD CATEGORY -->
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer>
		<div class="container">
			<small>Anda Bosen Liat Copyright ini? Sama, saya juga bosen. &copy; 2021 - Alva</small>
		</div>
	</footer>

	<script src="https://kit.fontawesome.com/6d2ea823d0.js"></script>
</body>

</html>
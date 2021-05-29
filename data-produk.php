<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
	echo '<script>window.location="login.php"</script>';
}
$sqlProduct = "SELECT * FROM tb_product ORDER BY product_id DESC";
$products = query($sqlProduct);

// URL GET
$modal = (isset($_GET['modal'])) ? $_GET['modal'] : null;
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
$categoriName = (isset($_GET['categoriName'])) ? $_GET['categoriName'] : null;
$hapus = (isset($_GET['hapus'])) ? $_GET['hapus'] : false;
$successAdd = (isset($_GET['add'])) ? $_GET['add'] : null;
// URL GET

// ADD PRODUCT LOGIC
if (isset($_POST['tambah-product'])) {
	if (tambahProduct($_POST) > 0) {
		echo "
			<script>
				alert('data berhasil ditambah');
				document.location.href = './data-produk.php?add=success';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal ditambah');
				document.location.href = './data-produk.php';
			</script>
		";
	}
}

// EDIT PRODUCT LOGIC
if (isset($_POST['edit-product'])) {
	if (ubahProduct($_POST) > 0) {
		echo "
			<script>
				alert('data berhasil diubah');
				document.location.href = './data-produk.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal diubah');
				document.location.href = './data-produk.php';
			</script>
		";
	}
}

// DELETE CATEGORY LOGIC
if ($hapus === 'true') {
	if (hapusProduct($id) > 0) {
		echo "
			<script>
				alert('data berhasil dihapus');
				document.location.href = './data-produk.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal dihapus');
				document.location.href = './data-produk.php';
			</script>
		";
	}
}

$sqlProductById = "SELECT * FROM tb_product WHERE product_id = $id";
if ($id) {
	$productsById = query($sqlProductById);
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
		/* alert */
		.badge {
			width: 100%;
			background-color: #2381d9;
			text-align: center;
			padding: 14px 16px;
			color: #f2f2f2;
		}

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

		.custom-file-upload {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
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
	<div class="section">
		<div class="container">
			<h3>Data Produk</h3>
			<a href="?modal=true" class="fas fa-plus">Tambah Data Product</a>
			<?php if ($successAdd) : ?>
				<div class="badge">
					<a style="float: right;" href="./data-produk.php">&times;</a>
					<h4>Data berhasil di tambah, silahkan edit status menjadi '1' untuk publish Product</h4>
				</div>
			<?php endif; ?>
			<div class="box">
				<table border="1" cellspacing="0" class="table" style="text-align: center;">
					<thead>
						<tr>
							<th width="60px">No</th>
							<th>Nama Produk</th>
							<th>Harga</th>
							<th>Deskripsi</th>
							<th>Gambar</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; ?>
						<?php foreach ($products as $product) : ?>
							<tr>
								<td><?= $i ?></td>
								<td><?= $product['product_name'] ?></td>
								<td><?= $product['product_price'] ?></td>
								<td><?= $product['product_description'] ?></td>
								<td><img src="img/<?= $product['product_image'] ?>" width="100" height="100"></td>
								<td><?php if ($product['product_status'] === '1') {
										echo "Tersedia";
									} else {
										echo "Tidak tersedia";
									} ?></td>
								<td>
									<a href="?modal=true&id=<?= $product['product_id'] ?>" class="fas fa-edit"> Edit</a> | <a href="?hapus=true&id=<?= $product['product_id'] ?>" class="fas fa-trash" onclick="return confirm('Yakin')"> Hapus</a>
								</td>
							</tr>
							<?php $i++ ?>
						<?php endforeach; ?>
					</tbody>
				</table>

				<!-- FORM ADD product -->
				<?php if ($modal === 'true') : ?>
					<?php if ($id === null) : ?>
						<div class="form-grup" style="margin-top: 1rem;">
							<form action="" method="POST" enctype="multipart/form-data">
								<a style="float: right;" href="./data-produk.php"><i class="fas fa-times">&times;</i></a>
								<input type="text" id="product_name" name="product_name" placeholder="Nama product" class="input">
								<input type="text" id="product_price" name="product_price" placeholder="Harga product" class="input">
								<input type="text" id="product_description" name="product_description" placeholder="Desc product" class="input">
								<label class="custom-file-upload">
									<input type="file" name="gambar" id="gambar" />
									<span style="float: right;">Gambar Product</span>
								</label>

								<input type="submit" name="tambah-product" value="Tambah" class="submit-input">
							</form>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<!-- FORM ADD product -->

				<!-- EDIT FORM -->
				<?php if ($modal === 'true') : ?>
					<?php if ($id != null) : ?>
						<?php foreach ($productsById as $productId) : ?>
							<div class="form-grup" style="margin-top: 1rem;">
								<form action="" method="POST" enctype="multipart/form-data">
									<a style="float: right;" href="./data-produk.php"><i class="fas fa-times">&times;</i></a>
									<input type="hidden" name="id" id="id" value="<?= $id ?>">
									<input type="hidden" name="gambar_lama" value="<?= $productId["product_image"]; ?>">
									<input type="text" id="product_name" name="product_name" value="<?= $productId['product_name'] ?>" class="input">
									<input type="text" id="product_price" name="product_price" value="<?= $productId['product_price'] ?>" class="input">
									<input type="text" id="product_description" name="product_description" value="<?= $productId['product_description'] ?>" class="input">
									<label class="custom-file-upload">
										<img src="img/<?= $productId['product_image'] ?>" width="300px">
										<input type="file" name="gambar" id="gambar" />
										<span style="float: right;">Gambar Product</span>
									</label>
									<input type="text" id="product_status" name="product_status" value="<?= $productId['product_status'] ?>" class="input">

									<input type="submit" name="edit-product" value="Submit" class="submit-input">
								</form>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				<!-- EDIT FORM -->
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
<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname	  = 'db_tokoku';

$conn =	mysqli_connect($hostname, $username, $password, $dbname) or die('Gagal Terhubung Ke Database');


function query($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

// UBAH Profile
function ubahProfile($data)
{
	global $conn;
	$id = $_GET['id'];

	$username = htmlspecialchars($data["username"]);
	$no_telp = htmlspecialchars($data["no_telp"]);
	$email = htmlspecialchars($data["email"]);
	$address = htmlspecialchars($data["address"]);

	$query = "UPDATE `tb_admin` SET `username`='$username',`admin_telp`='$no_telp',`admin_email`='$email',`admin_adress`='$address' WHERE admin_id = '$id'
				";


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}
function registrasi($data)
{
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password1"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$no_telp = mysqli_real_escape_string($conn, $data["no_telp"]);
	$email = mysqli_real_escape_string($conn, $data["email"]);
	$address = mysqli_real_escape_string($conn, $data["address"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM tb_admin WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
				alert ('username sudah terdaftarr');
			</script>";
		return false;
	}

	// cek konfirmasi password
	if ($password !== $password2) {
		echo "<script>
				alert ('konfirmasi password tidak sesuai');
			</script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO tb_admin VALUES('', '$username', '$username', '$password', '$no_telp', '$email', '$address')");

	return mysqli_affected_rows($conn);
}

// CRUD CATEGORY
function ubahCategory($data)
{
	global $conn;
	$id = $data["id"];
	$category_name = htmlspecialchars($data["category_name"]);

	$query = "UPDATE `tb_category` SET `category_name`='$category_name' WHERE category_id = '$id'
			";


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapusCategory($id)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM `tb_category` WHERE category_id = '$id'");
	return mysqli_affected_rows($conn);
}

function tambahCategory($data)
{
	global $conn;
	$category_name = htmlspecialchars($data["category_name"]);

	$query = "INSERT INTO tb_category
				VALUES
				('', '$category_name')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}
// CRUD CATEGORY

// CRUD PRODUCT
function tambahProduct($data)
{
	global $conn;
	$product_name = htmlspecialchars($data["product_name"]);
	$product_price = htmlspecialchars($data["product_price"]);
	$product_description = htmlspecialchars($data["product_description"]);

	$product_image = upload();
	if (!$product_image) {
		return false;
	}


	$query = "INSERT INTO `tb_product` VALUES ('','$product_name','$product_price','$product_description','$product_image','0')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahProduct($data)
{
	global $conn;
	$id = $data["id"];
	$product_name = htmlspecialchars($data["product_name"]);
	$product_price = htmlspecialchars($data["product_price"]);
	$product_description = htmlspecialchars($data["product_description"]);
	$gambar_lama = htmlspecialchars($data["gambar_lama"]);
	$product_status = htmlspecialchars($data["product_status"]);

	if ($_FILES['gambar']['error'] === 4) {
		$gambar = $gambar_lama;
	} else {
		$gambar = upload();
	}

	$angkaStatus = ['0', '1'];
	if (!in_array($product_status,  $angkaStatus)) {
		echo "<script>
				alert ('Status bisa diisi hanya dengan angka 1 / 2 saja !');
			</script>";
		return false;
	}




	$query = "UPDATE `tb_product` SET `product_name`='$product_name',`product_price`='$product_price',`product_description`='$product_description',`product_image`='$gambar',`product_status`='$product_status' WHERE product_id = '$id'
				";


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapusProduct($id)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM `tb_product` WHERE product_id = '$id'");
	return mysqli_affected_rows($conn);
}
// CRUD PRODUCT


// upload func
function upload()
{

	$nama_file = $_FILES['gambar']['name'];
	$ukuran_file = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmp_name = $_FILES['gambar']['tmp_name'];

	if ($error === 4) {
		echo "<script>
				alert ('pilih gambar terlebih dahulu');
			</script>";
		return false;
	}

	$ekstensi_gambar_valid = ['jpg', 'jpeg', 'png'];
	$ekstensi_gambar = explode('.', $nama_file);
	$ekstensi_gambar = strtolower(end($ekstensi_gambar));
	if (!in_array($ekstensi_gambar, $ekstensi_gambar_valid)) {
		echo "<script>
				alert ('yang anda upload bukan gambar');
			</script>";

		return false;
	}

	if ($ukuran_file > 1000000) {
		echo "<script>
				alert ('ukuran gambar terlalu besar');
			</script>";
	}

	$nama_file_baru = uniqid();
	$nama_file_baru .= '.';
	$nama_file_baru .= $ekstensi_gambar;

	move_uploaded_file($tmp_name, 'img/' . $nama_file_baru);

	return $nama_file_baru;
}

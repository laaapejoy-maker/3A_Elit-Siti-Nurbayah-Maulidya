<?php
session_start();
include "../function.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/".$gambar);

    mysqli_query($conn, "INSERT INTO db_produk 
    (nama_produk,harga,stok,gambar,deskripsi,created_at)
    VALUES
    ('$nama','$harga','$stok','$gambar','$deskripsi',NOW())");

    header("Location: produk.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
   
<div class="container h-100 d-flex justify-content-center align-items-center">

<div class="card shadow p-4 text-center"
     style="max-width:400px;width:100%;border-radius:16px;">

<h4 class="mb-3 text-center" style="color:#d84b8c;">
Tambah Produk
</h4>

<form method="POST" enctype="multipart/form-data">
<input class="form-control mb-2" name="nama_produk" placeholder="Nama Produk" required>
<input class="form-control mb-2" name="harga" placeholder="Harga" required>
<input class="form-control mb-2" name="stok" placeholder="Stok" required>
<textarea class="form-control mb-2" name="deskripsi" placeholder="Deskripsi"></textarea>
<input type="file" class="form-control mb-3" name="gambar" required>

<button name="simpan" class="btn w-100"
        style="background:#ff71b8;color:white;">
Simpan
</button>
</form>

</div>
</div>

</div>
</body>
</html>
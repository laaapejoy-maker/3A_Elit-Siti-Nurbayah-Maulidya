<?php
session_start();
include "../function.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

$id = $_GET['id'];
$p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_produk WHERE id='$id'"));

if (isset($_POST['update'])) {

    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/".$gambar);
        mysqli_query($conn,"UPDATE db_produk SET gambar='$gambar' WHERE id='$id'");
    }

    mysqli_query($conn,"UPDATE db_produk SET
        nama_produk='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi'
        WHERE id='$id'
    ");

    header("Location: produk.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
   
<div class="container h-100 d-flex justify-content-center align-items-center">

<div class="card shadow p-4 text-center"
     style="max-width:400px;width:100%;border-radius:16px;">
     
<h4 class="text-center mb-3" style="color:#d84b8c;">
Edit Produk
</h4>

<form method="POST" enctype="multipart/form-data">
<input class="form-control mb-2" name="nama_produk" value="<?= $p['nama_produk']; ?>">
<input class="form-control mb-2" name="harga" value="<?= $p['harga']; ?>">
<input class="form-control mb-2" name="stok" value="<?= $p['stok']; ?>">
<textarea class="form-control mb-2" name="deskripsi"><?= $p['deskripsi']; ?></textarea>
<input type="file" class="form-control mb-3" name="gambar">

<button name="update" class="btn w-100"
        style="background:#ff71b8;color:white;">
Update
</button>
</form>

</div>
</div>

</div>
</body>
</html>
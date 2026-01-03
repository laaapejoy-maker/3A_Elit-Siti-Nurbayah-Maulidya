<?php
session_start();
include "function.php";

/* CEK LOGIN */
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

/* SIMPAN REVIEW */
if (isset($_POST['kirim_review'])) {

    $user_id = $_SESSION['user_id'];
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);
    $pesan   = mysqli_real_escape_string($conn, $_POST['pesan']);
    $bintang = (int) $_POST['bintang'];

    mysqli_query($conn, "
        INSERT INTO db_customer_says
        (user_id, nama, alamat, pesan, bintang, created_at)
        VALUES
        ('$user_id', '$nama', '$alamat', '$pesan', '$bintang', NOW())
    ");

    /* LANGSUNG KEMBALI KE TOKO */
    header("Location: toko.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
    
body{
    background:linear-gradient(180deg,#ffd6eb,#ffffff);
    height:100vh;
}
</style>
<title>Tulis Review - ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<section class="container py-5">
<h4 class="fw-bold text-center mb-4" style="color:#d84b8c;">
Tulis Pengalamanmu 💕
</h4>

<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow-sm border-0 rounded-4">
<div class="card-body">

<form method="POST">

<input type="text" name="nama" class="form-control mb-2"
       placeholder="Nama kamu" required>

<input type="text" name="alamat" class="form-control mb-2"
       placeholder="Alamat / Kota" required>

<select name="bintang" class="form-select mb-2" required>
    <option value="">Rating</option>
    <option value="5">★★★★★</option>
    <option value="4">★★★★</option>
    <option value="3">★★★</option>
    <option value="2">★★</option>
    <option value="1">★</option>
</select>

<textarea name="pesan" rows="3"
          class="form-control mb-3"
          placeholder="Ceritakan pengalamanmu..." required></textarea>

<button name="kirim_review"
        class="btn w-100"
        style="background:#ff71b8;color:white;">
Kirim Review
</button>

</form>

<a href="toko.php" class="btn btn-light w-100 mt-3">
← Batal & Kembali
</a>

</div>
</div>

</div>
</div>
</section>

</body>
</html>
<?php
session_start();
include "function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: toko.php");
    exit;
}

$id = $_GET['id'];
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM db_produk WHERE id='$id'"));

if (!$p) {
    echo "<script>alert('Produk tidak ditemukan');window.location='toko.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Detail Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;"></body>

<div class="container mt-5">
<div class="row justify-content-center">

  <div class="col-md-4">
    <div class="ratio ratio-1x1 shadow rounded overflow-hidden mb-3">
      <img src="uploads/<?= $p['gambar']; ?>"
           class="w-100 h-100 object-fit-cover">
    </div>
  </div>

  <div class="col-md-6">
    <h3 class="fw-bold"><?= $p['nama_produk']; ?></h3>

    <h4 class="mb-3" style="color:#d84b8c;">
      Rp <?= number_format($p['harga']); ?>
    </h4>

    <div class="p-3 mb-3 rounded"
         style="background:#fff;border-left:5px solid #ff71b8;">
      <h6 class="fw-bold mb-2">Deskripsi Produk</h6>
      <p class="mb-0" style="text-align:justify;">
        <?= nl2br($p['deskripsi']); ?>
      </p>
    </div>

    <p class="text-muted">Stok tersedia: <?= $p['stok']; ?></p>

    <form method="POST" action="keranjang.php">
      <input type="hidden" name="id_produk" value="<?= $p['id']; ?>">

      <label class="fw-semibold">Jumlah</label>
      <input type="number"
             name="qty"
             value="1"
             min="1"
             max="<?= $p['stok']; ?>"
             class="form-control mb-3"
             style="width:120px;">

      <button class="btn px-4"
              style="background:#ff71b8;color:white;">
        Tambah ke Keranjang
      </button>
    </form>
  </div>

</div>
</div>

</body>
</html>
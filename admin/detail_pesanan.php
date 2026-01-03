<?php
session_start();
include "../function.php";

/* VALIDASI PARAMETER ID */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: pesanan.php");
    exit;
}

$id = $_GET['id'];

/* AMBIL DATA PESANAN */
$qPesanan = mysqli_query($conn, "SELECT * FROM db_pesanan WHERE id='$id'");
$pesanan  = mysqli_fetch_assoc($qPesanan);

/* JIKA PESANAN TIDAK ADA */
if (!$pesanan) {
    echo "<script>
        alert('Pesanan tidak ditemukan');
        window.location='pesanan.php';
    </script>";
    exit;
}

/* DETAIL PRODUK PESANAN */
$qDetail = mysqli_query($conn, "
    SELECT db_pesanan_detail.*, db_produk.nama_produk
    FROM db_pesanan_detail
    JOIN db_produk ON db_pesanan_detail.id_produk = db_produk.id
    WHERE db_pesanan_detail.id_pesanan = '$id'
");

/* UPDATE STATUS PESANAN */
if (isset($_POST['update'])) {
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE db_pesanan SET status='$status' WHERE id='$id'");
    header("Location: pesanan.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
<div class="container mt-4" style="max-width:900px;">

<!-- JUDUL -->
<h4 class="mb-3" style="color:#d84b8c;">
Detail Pesanan #<?= $pesanan['id']; ?>
</h4>

<!-- DATA PEMBELI -->
<div class="card shadow mb-4 border-0 rounded-4">
<div class="card-body">

<p><b>Nama Pembeli:</b> <?= htmlspecialchars($pesanan['nama_pembeli']); ?></p>
<p><b>No HP:</b> <?= htmlspecialchars($pesanan['no_hp']); ?></p>
<p><b>Alamat:</b> <?= htmlspecialchars($pesanan['alamat']); ?></p>
<p><b>Metode Pembayaran:</b> <?= htmlspecialchars($pesanan['pembayaran']); ?></p>

<p><b>Total:</b> 
   <span style="color:#d84b8c;">
   Rp <?= number_format($pesanan['total']); ?>
   </span>
</p>

<form method="POST" class="mt-3">
<label class="fw-bold">Status Pesanan</label>

<select name="status" class="form-control mb-3">
  <option value="Menunggu" <?= $pesanan['status']=='Menunggu'?'selected':''; ?>>Menunggu</option>
  <option value="Diproses" <?= $pesanan['status']=='Diproses'?'selected':''; ?>>Diproses</option>
  <option value="Dikirim" <?= $pesanan['status']=='Dikirim'?'selected':''; ?>>Dikirim</option>
  <option value="Selesai" <?= $pesanan['status']=='Selesai'?'selected':''; ?>>Selesai</option>
</select>

<button name="update" class="btn"
        style="background:#ff71b8;color:white;">
Update Status
</button>

<a href="pesanan.php" class="btn btn-secondary">
Kembali
</a>
</form>

</div>
</div>

<!-- DETAIL PRODUK -->
<div class="card shadow border-0 rounded-4">
<div class="card-body">

<h6 class="mb-3 fw-bold" style="color:#d84b8c;">
Produk yang Dipesan
</h6>

<div class="row g-3">
<?php while($d = mysqli_fetch_assoc($qDetail)): ?>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm h-100 rounded-3">
      <div class="card-body">

        <h6 class="fw-semibold"><?= htmlspecialchars($d['nama_produk']); ?></h6>

        <p class="mb-1">Qty: <b><?= $d['qty']; ?></b></p>
        <p class="mb-1">Harga: Rp <?= number_format($d['harga']); ?></p>

        <p class="fw-bold" style="color:#d84b8c;">
          Subtotal: Rp <?= number_format($d['subtotal']); ?>
        </p>

      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>

</div>
</div>

</div>
</body>
</html>
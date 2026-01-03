<?php
session_start();
include "../function.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

$q = mysqli_query($conn,"
    SELECT * FROM db_pesanan
    WHERE status='Selesai'
    ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Riwayat Transaksi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.card-riwayat{
    border-radius:16px;
    transition:.3s;
}
.card-riwayat:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 30px rgba(0,0,0,.15);
}
</style>
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">

<div class="container py-4">

<h4 class="fw-bold mb-4" style="color:#d84b8c;">
<i class="bi bi-clock-history"></i> Riwayat Transaksi
</h4>

<div class="row g-4">

<?php if(mysqli_num_rows($q)>0){ ?>
<?php while($p=mysqli_fetch_assoc($q)){ ?>
<div class="col-md-4">
<div class="card card-riwayat shadow-sm border-0 h-100">
<div class="card-body">

<h6 class="fw-bold"><?= htmlspecialchars($p['nama_pembeli']); ?></h6>
<p class="small text-muted"><?= $p['tanggal']; ?></p>

<p class="mb-1"><b>Pembayaran:</b> <?= $p['pembayaran']; ?></p>

<p class="fw-bold" style="color:#d84b8c;">
Rp <?= number_format($p['total']); ?>
</p>

<span class="badge bg-success">Selesai</span>

<a href="detail_pesanan.php?id=<?= $p['id']; ?>"
   class="btn btn-sm w-100 mt-3"
   style="background:#ff71b8;color:white;">
<i class="bi bi-receipt"></i> Detail Pesanan
</a>

</div>
</div>
</div>
<?php } ?>
<?php } else { ?>
<div class="text-center text-muted">Belum ada transaksi selesai</div>
<?php } ?>

</div>
</div>

</body>
</html>
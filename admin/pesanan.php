<?php
session_start();
include "../function.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Data Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.order-card{
    border-radius:16px;
    transition:.3s;
}
.order-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 30px rgba(0,0,0,.15);
}
.badge-status{
    font-size:13px;
    padding:6px 12px;
}
</style>
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
<div class="container py-4">

<!-- HEADER + BACK -->
<div class="d-flex align-items-center mb-4 gap-3">
    <a href="dashboard_admin.php"
       class="btn btn-light shadow-sm rounded-circle">
        <i class="bi bi-arrow-left"></i>
    </a>

    <h3 class="fw-bold mb-0" style="color:#d84b8c;">
        Data Pesanan
    </h3>
</div>

<div class="row g-4">

<?php
$q = mysqli_query($conn, "SELECT * FROM db_pesanan ORDER BY id DESC");

if (mysqli_num_rows($q) > 0) {
while ($p = mysqli_fetch_assoc($q)) {
?>
<div class="col-md-4">
<div class="card order-card border-0 shadow-sm h-100">
<div class="card-body">

<h6 class="fw-bold mb-1"><?= htmlspecialchars($p['nama_pembeli']); ?></h6>
<p class="small text-muted mb-2"><?= htmlspecialchars($p['no_hp']); ?></p>

<p class="mb-1">
<b>Pembayaran:</b> <?= htmlspecialchars($p['pembayaran']); ?>
</p>

<p class="fw-bold mb-2" style="color:#d84b8c;">
Rp <?= number_format($p['total']); ?>
</p>

<span class="badge rounded-pill badge-status
<?=
$p['status']=='Menunggu'?'bg-secondary':
($p['status']=='Diproses'?'bg-warning':
($p['status']=='Dikirim'?'bg-info':'bg-success'))
?>">
<?= $p['status']; ?>
</span>

<p class="small text-muted mt-2">
<i class="bi bi-calendar"></i> <?= $p['tanggal']; ?>
</p>

<a href="detail_pesanan.php?id=<?= $p['id']; ?>"
   class="btn btn-sm w-100 mt-3"
   style="background:#ff71b8;color:white;">
<i class="bi bi-receipt"></i> Detail Pesanan
</a>

</div>
</div>
</div>
<?php
}
} else {
?>
<div class="col-12 text-center text-muted">
Belum ada pesanan
</div>
<?php } ?>

</div>
</div>

</body>
</html>
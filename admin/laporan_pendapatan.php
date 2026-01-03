<?php
session_start();
include "../function.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

/* PILIH TAHUN */
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');
if ($tahun < 2025 || $tahun > 2026) {
    $tahun = date('Y');
}

/* TOTAL */
$qTotal = mysqli_query($conn,"
    SELECT 
        SUM(total) AS total_uang,
        COUNT(*) AS jumlah_transaksi
    FROM db_pesanan
    WHERE status='Selesai'
    AND YEAR(tanggal)='$tahun'
");
$data = mysqli_fetch_assoc($qTotal);

/* GRAFIK BULANAN */
$qGrafik = mysqli_query($conn,"
    SELECT 
        MONTH(tanggal) AS bulan,
        SUM(total) AS total
    FROM db_pesanan
    WHERE status='Selesai'
    AND YEAR(tanggal)='$tahun'
    GROUP BY MONTH(tanggal)
");

/* Bulan Januari - Desember */
$bulanLabel = [
    "Januari","Februari","Maret","April","Mei","Juni",
    "Juli","Agustus","September","Oktober","November","Desember"
];

$pendapatanBulanan = array_fill(1, 12, 0);

while($g=mysqli_fetch_assoc($qGrafik)){
    $pendapatanBulanan[$g['bulan']] = $g['total'];
}

$labels = $bulanLabel;
$values = array_values($pendapatanBulanan);
?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan Pendapatan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    background: linear-gradient(180deg, #ffe1efff 0%, #ffffffff 100%);
}
.card-laporan{
    border-radius:18px;
}
.select-tahun{
    width:150px;
}
</style>
</head>

<body>

<div class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-4">
<h4 class="fw-bold" style="color:#d84b8c;">
📊 Laporan Pendapatan
</h4>

<form method="GET">
<select name="tahun" class="form-select select-tahun" onchange="this.form.submit()">
<option value="2025" <?= $tahun==2025?'selected':''; ?>>Tahun 2025</option>
<option value="2026" <?= $tahun==2026?'selected':''; ?>>Tahun 2026</option>
</select>
</form>
</div>

<div class="row mb-4">

<div class="col-md-6">
<div class="card card-laporan shadow border-0">
<div class="card-body">
<h6 class="fw-bold">Total Pendapatan</h6>
<h3 style="color:#d84b8c;">
Rp <?= number_format($data['total_uang'] ?? 0); ?>
</h3>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card card-laporan shadow border-0">
<div class="card-body">
<h6 class="fw-bold">Total Transaksi</h6>
<h3><?= $data['jumlah_transaksi'] ?? 0; ?> Transaksi</h3>
</div>
</div>
</div>

</div>

<div class="card shadow border-0 card-laporan">
<div class="card-body">
<h6 class="fw-bold mb-3">
Grafik Pendapatan Bulanan Tahun <?= $tahun; ?>
</h6>
<canvas id="chartPendapatan" height="110"></canvas>
</div>
</div>

</div>

<script>
new Chart(document.getElementById('chartPendapatan'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
            label: 'Pendapatan Bulanan',
            data: <?= json_encode($values); ?>,
            borderColor: '#d84b8c',
            backgroundColor: 'rgba(216,75,140,.25)',
            borderWidth: 3,
            tension: .4,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#d84b8c'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                ticks: {
                    callback: function(value){
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>
<?php
session_start();
include "../function.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];

/* UPDATE BIODATA */
if (isset($_POST['update_biodata'])) {

    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telp  = mysqli_real_escape_string($conn, $_POST['telp']);

    $foto = $_POST['foto_lama'];

    if (!empty($_FILES['foto']['name'])) {

        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {

            if (!empty($_POST['foto_lama']) && file_exists("../uploads/".$_POST['foto_lama'])) {
                unlink("../uploads/".$_POST['foto_lama']);
            }

            $foto = "admin_".$admin_id."_".time().".".$ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/".$foto);
        }
    }

    mysqli_query($conn, "
        UPDATE db_admin SET
        nama='$nama',
        email='$email',
        telp='$telp',
        foto='$foto'
        WHERE id='$admin_id'
    ");

    $_SESSION['admin_nama'] = $nama;
    header("Location: dashboard_admin.php");
    exit;
}

/* DATA ADMIN */
$admin = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM db_admin WHERE id='$admin_id'
"));
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin - ElCharm</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.sidebar{
    background:linear-gradient(180deg, #ff71b8,#c084fc);
    min-height:100vh;
}
.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:10px;
    border-radius:8px;
}
.sidebar a:hover{
    background:rgba(255, 190, 190, 0.6);
}
.sidebar-card{
    background:rgba(247, 112, 112, 0.15);
    border-radius:16px;
}
.sidebar-card img{
    width:90px;
    height:90px;
    object-fit:cover;
    border-radius:50%;
    border:3px solid white;
}
.topbar{
    background:white;
    border-radius:14px;
}
iframe{
    width:100%;
    height:650px;
    border:none;
    border-radius:16px;
}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-3 col-lg-2 sidebar p-4">
<h4 class="fw-bold text-white mb-4">ElCharm Admin</h4>

<div class="sidebar-card p-3 text-center text-white mb-4">
    <img src="../uploads/<?= $admin['foto'] ?: 'default.png'; ?>">
    <h6 class="fw-bold mt-2 mb-0"><?= $admin['nama']; ?></h6>
    <small><?= $admin['email']; ?></small>

    <button class="btn btn-light btn-sm mt-2 w-100"
    data-bs-toggle="modal" data-bs-target="#editProfil">
        Edit Profil
    </button>
</div>

<a href="dashboard_admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
<a href="produk.php" target="contentFrame"><i class="bi bi-box"></i> Produk</a>
<a href="pesanan.php" target="contentFrame"><i class="bi bi-cart"></i> Pesanan</a>
<a href="riwayat_transaksi.php" target="contentFrame"><i class="bi bi-clock-history"></i> Riwayat Transaksi</a>
<a href="laporan_pendapatan.php" target="contentFrame"><i class="bi bi-graph-up"></i> Laporan Pendapatan</a>
<a href="../toko.php" target="_blank"><i class="bi bi-shop"></i> Lihat Toko</a>
<a href="chat_admin.php" target="contentFrame"><i class="bi bi-chat-dots"></i> Chat User</a>

<hr class="border-light">
<a href="logout_admin.php" class="text-warning">
<i class="bi bi-box-arrow-right"></i> Logout
</a>
</div>

<div class="col-md-9 col-lg-10 p-4">

<div class="d-flex justify-content-between align-items-center mb-4 px-4 py-3 shadow-sm topbar">
<h5 class="fw-bold mb-0" style="color:#d84b8c;">Dashboard Admin</h5>
<div class="d-flex align-items-center gap-2">
<span class="fw-semibold"><?= $_SESSION['admin_nama']; ?></span>
<i class="bi bi-person-circle fs-4 text-secondary"></i>
</div>
</div>

<div class="card shadow-sm border-0 rounded-4">
<div class="card-body p-0">

<iframe name="contentFrame"
srcdoc="
<!DOCTYPE html>
<html>
<head>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css' rel='stylesheet'>
<style>
body{
    background:linear-gradient(#ffffff);
    font-family:Arial;
}
.welcome{
    background:linear-gradient(135deg,#ff71b8,#c084fc);
    color:white;
    border-radius:20px;
    padding:30px;
    box-shadow:0 15px 30px rgba(0,0,0,.15);
}
.stat-card{
    border-radius:20px;
    color:white;
    padding:25px;
    transition:.3s;
    cursor:pointer;
    text-decoration:none;
}
.stat-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 30px rgba(0,0,0,.2);
}

.bg-produk{ background:linear-gradient(135deg,#ff71b8,#ec4899); }
.bg-pesanan{ background:linear-gradient(135deg,#ff71b8,#ec4899); }
.bg-transaksi{ background:linear-gradient(135deg,#ff71b8,#ec4899); }
.icon{
    font-size:38px;
    opacity:.9;
}
a{text-decoration:none;}
#editProfil .modal-header{
    background: linear-gradient(135deg, #ffadd3ff,#ec4899);
    color:white;
    border:none;
}

#editProfil .modal-footer{
    background: transparent;
    border:none;
}

#editProfil input{
    border-radius:12px;
}
</style>
</head>

<body>

<div class='container py-5'>

<!-- SAPAAN -->
<div class='welcome mb-5'>
<h3 class='fw-bold mb-1'>Halo, Selamat Datang Admin 👋</h3>
<p class='mb-0'>Kelola produk, pesanan, dan transaksi dengan mudah & nyaman</p>
</div>

<!-- CARD STATISTIK -->
<div class='row g-4'>

<!-- PRODUK -->
<div class='col-md-4'>
<a href='produk.php' target='_parent' class='stat-card bg-produk d-block'>
<i class='bi bi-box-seam icon'></i>
<h6 class='mt-3'>Total Produk</h6>
<h3 class='fw-bold'>
<?php
$q=mysqli_fetch_row(mysqli_query($conn,'SELECT COUNT(*) FROM db_produk'));
echo $q[0];
?>
</h3>
<small>Lihat semua produk</small>
</a>
</div>

<!-- PESANAN -->
<div class='col-md-4'>
<a href='pesanan.php' target='_parent' class='stat-card bg-pesanan d-block'>
<i class='bi bi-cart-check icon'></i>
<h6 class='mt-3'>Total Pesanan</h6>
<h3 class='fw-bold'>
<?php
$q=mysqli_fetch_row(mysqli_query($conn,'SELECT COUNT(*) FROM db_pesanan'));
echo $q[0];
?>
</h3>
<small>Lihat pesanan masuk</small>
</a>
</div>

<!-- TRANSAKSI -->
<div class='col-md-4'>
<a href='riwayat_transaksi.php' target='_parent' class='stat-card bg-transaksi d-block'>
<i class='bi bi-cash-stack icon'></i>
<h6 class='mt-3'>Total Transaksi</h6>
<h3 class='fw-bold'>
<?php
$q=mysqli_fetch_row(mysqli_query($conn,"SELECT SUM(total) FROM db_pesanan WHERE status='Selesai'"));
$total = $q[0] ?? 0;
echo 'Rp '.number_format($total);
?>
</h3>
<small>Lihat riwayat transaksi</small>
</a>
</div>

</div>
</div>

</body>
</html>
">
</iframe>

</div>
</div>

</div>
</div>
</div>

<div class="modal fade" id="editProfil" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content" style="
background:linear-gradient(180deg,#ffe4ef 0%,#ffffff 65%);
border-radius:20px;
border:none;
">

<div class="modal-header" style="
background:linear-gradient(135deg,#ff71b8,#ec4899);
color:white;
border-top-left-radius:20px;
border-top-right-radius:20px;
">
<h5 class="modal-title fw-bold">Edit Profil</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form method="POST" enctype="multipart/form-data">
<div class="modal-body px-4">

<input type="hidden" name="foto_lama" value="<?= $admin['foto']; ?>">

<div class="mb-3">
<label class="fw-semibold">Nama</label>
<input type="text" name="nama" value="<?= $admin['nama']; ?>" class="form-control rounded-pill">
</div>

<div class="mb-3">
<label class="fw-semibold">Email</label>
<input type="email" name="email" value="<?= $admin['email']; ?>" class="form-control rounded-pill">
</div>

<div class="mb-3">
<label class="fw-semibold">No Telp</label>
<input type="text" name="telp" value="<?= $admin['telp']; ?>" class="form-control rounded-pill">
</div>

<div class="mb-3">
<label class="fw-semibold">Foto</label>
<input type="file" name="foto" class="form-control rounded-pill">
</div>

</div>

<div class="modal-footer border-0">
<button type="submit" name="update_biodata"
class="btn w-100 text-white rounded-pill"
style="background:linear-gradient(135deg,#ff71b8,#ec4899);">
Simpan Perubahan
</button>
</div>

</form>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
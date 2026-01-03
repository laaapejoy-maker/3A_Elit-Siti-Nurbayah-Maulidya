<?php
session_start();
include "../function.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

/* SEARCH */
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($keyword != '') {
    $q = mysqli_query($conn, 
        "SELECT * FROM db_produk 
         WHERE nama_produk LIKE '%$keyword%' 
         ORDER BY id DESC"
    );
} else {
    $q = mysqli_query($conn, "SELECT * FROM db_produk ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Produk - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(180deg, #ffe1efff 0%, #ffffffff 100%);
}

.card{
    border-radius:18px;
    background:#ffffff;
}

.table thead{
    background: linear-gradient(90deg,#ff71b8,#c084fc);
    color:white;
}
.table tbody tr:hover{
    background:#ffe4f1;
}

.img-produk{
    width:65px;
    height:65px;
    object-fit:cover;
    border-radius:12px;
    box-shadow:0 6px 14px rgba(0,0,0,.18);
}

.btn-add{
    background:#ff71b8;
    color:white;
    border-radius:20px;
    padding:6px 18px;
    font-size:13px;
}
.btn-add:hover{
    background:#e85aa3;
}

.btn-edit{
    background:#fb7185;
    color:white;
    border-radius:10px;
    font-size:12px;
    padding:4px 14px;
}
.btn-edit:hover{
    background:#f43f5e;
}

.btn-delete{
    background:#a855f7;
    color:white;
    border-radius:10px;
    font-size:12px;
    padding:4px 14px;
}
.btn-delete:hover{
    background:#9333ea;
}
</style>
</head>

<body>

<div class="container py-5">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="fw-bold" style="color:#d84b8c;">Manajemen Produk</h4>
    <small class="text-muted">Kelola data produk ElCharm</small>
  </div>

  <a href="tambah_produk.php" class="btn btn-add shadow-sm">
    + Tambah Produk
  </a>
</div>

<!-- SEARCH -->
<form method="GET" class="mb-3">
  <div class="input-group">
    <input type="text" name="search"
           class="form-control rounded-start-pill"
           placeholder="Cari nama produk..."
           value="<?= htmlspecialchars($keyword); ?>">
    <button class="btn btn-add rounded-end-pill px-4">
      Cari
    </button>
  </div>
</form>

<!-- TABLE CARD -->
<div class="card shadow border-0">
<div class="card-body">

<div class="table-responsive">
<table class="table align-middle mb-0">
<thead>
<tr>
  <th>Gambar</th>
  <th>Nama Produk</th>
  <th>Harga</th>
  <th>Stok</th>
  <th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>
<?php while($p=mysqli_fetch_assoc($q)): ?>
<tr>
  <td>
    <img src="../uploads/<?= $p['gambar']; ?>" class="img-produk">
  </td>

  <td class="fw-semibold">
    <?= $p['nama_produk']; ?>
  </td>

  <td class="fw-bold" style="color:#d84b8c;">
    Rp <?= number_format($p['harga']); ?>
  </td>

  <td>
    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
      <?= $p['stok']; ?>
    </span>
  </td>

  <td class="text-center">
  <div class="d-flex justify-content-center gap-2">
    <a href="edit_produk.php?id=<?= $p['id']; ?>"
       class="btn btn-edit">
       Edit
    </a>

    <a href="hapus_produk.php?id=<?= $p['id']; ?>"
       class="btn btn-delete"
       onclick="return confirm('Hapus produk ini?')">
       Hapus
    </a>
  </div>
</td>
</tr>
<?php endwhile; ?>
</tbody>

</table>
</div>

</div>
</div>

</div>

</body>
</html>
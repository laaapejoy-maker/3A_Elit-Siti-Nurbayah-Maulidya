<?php
session_start();
include "function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// TAMBAH QTY
if (isset($_GET['tambah'])) {
    $id = $_GET['tambah'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    }
    header("Location: keranjang.php");
    exit;
}

// KURANG QTY
if (isset($_GET['kurang'])) {
    $id = $_GET['kurang'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] < 1) {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: keranjang.php");
    exit;
}

// HAPUS PRODUK
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($_SESSION['cart'][$id]);
    header("Location: keranjang.php");
    exit;
}

// TAMBAH KE KERANJANG
if (isset($_POST['id_produk'])) {
    $id = $_POST['id_produk'];
    $qty = (int)$_POST['qty'];

    if ($qty < 1) $qty = 1;

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }

    header("Location: keranjang.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Keranjang - ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;"></body>

<div class="container mt-4">
<h3 class="text-center mb-4" style="color:#d84b8c;">
🛒 Keranjang Belanja
</h3>

<?php
$total = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {

        $q = mysqli_query($conn, "SELECT * FROM db_produk WHERE id='$id'");
        $p = mysqli_fetch_assoc($q);
        if (!$p) continue;

        $sub = $p['harga'] * $qty;
        $total += $sub;
?>

<div class="card border-0 shadow-sm mb-2">
  <div class="d-flex align-items-center p-2">

    <div class="me-2" style="width:70px;">
      <div class="ratio ratio-1x1 rounded overflow-hidden">
        <img src="uploads/<?= $p['gambar']; ?>"
             class="w-100 h-100 object-fit-cover">
      </div>
    </div>

    <div class="flex-grow-1">
      <div class="fw-semibold" style="font-size:14px;">
        <?= $p['nama_produk']; ?>
      </div>

      <div class="d-flex align-items-center gap-2 mt-1">
        <span class="badge"
              style="background:#ffe1ee;color:#d84b8c;">
          Rp <?= number_format($p['harga']); ?>
        </span>
      </div>

      <div class="d-flex align-items-center gap-2 mt-1">
        <a href="keranjang.php?kurang=<?= $id; ?>" class="btn btn-sm btn-light border">−</a>
        <span class="fw-semibold"><?= $qty; ?></span>
        <a href="keranjang.php?tambah=<?= $id; ?>" class="btn btn-sm btn-light border">+</a>

        <a href="keranjang.php?hapus=<?= $id; ?>"
           class="btn btn-sm btn-danger ms-2"
           onclick="return confirm('Hapus produk ini?')">✕</a>
      </div>

      <div class="fw-bold mt-1" style="color:#d84b8c;font-size:13px;">
        Subtotal: Rp <?= number_format($sub); ?>
      </div>
    </div>

  </div>
</div>

<?php
    }
} else {
?>
<div class="alert alert-light text-center shadow-sm">
  Keranjang kamu masih kosong 💖
</div>
<?php } ?>

<?php if (!empty($_SESSION['cart'])) { ?>
<div class="card shadow-sm border-0 mt-3">
  <div class="card-body py-2 d-flex justify-content-between">
    <span class="fw-semibold">Total</span>
    <span class="fw-bold" style="color:#d84b8c;">
      Rp <?= number_format($total); ?>
    </span>
  </div>
</div>

<div class="d-flex justify-content-between mt-3">
  <a href="toko.php" class="btn btn-outline-secondary btn-sm">← Belanja</a>
  <a href="checkout.php" class="btn btn-sm" style="background:#ff71b8;color:white;">Checkout</a>
</div>
<?php } ?>

</div>
</body>
</html>
<?php
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Pesanan Berhasil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#ffeef5;">
<div class="container text-center mt-5">
<h2 style="color:#d84b8c;"> Yeay Pesanan Berhasil 💖</h2>
<p>ID Pesanan: <b><?= $id; ?></b></p>

<a href="toko.php" class="btn" style="background:#ff71b8;color:white;">
Kembali ke Toko
</a>
</div>
</body>
</html>
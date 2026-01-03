<?php
session_start();
include "function.php";

/* CEK LOGIN USER */
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

/* CEK KERANJANG */
if (empty($_SESSION['cart'])) {
    header("Location: toko.php");
    exit;
}

$id_user = $_SESSION['user_id'];
$nama = $_POST['nama'];
$hp = $_POST['hp'];
$alamat = $_POST['alamat'];
$pembayaran = $_POST['pembayaran'];

/* HITUNG TOTAL */
$total = 0;
foreach ($_SESSION['cart'] as $id_produk => $qty) {
    $q = mysqli_query($conn, "SELECT harga FROM db_produk WHERE id='$id_produk'");
    if ($p = mysqli_fetch_assoc($q)) {
        $total += $p['harga'] * $qty;
    }
}

/* SIMPAN PESANAN */
$insertPesanan = mysqli_query($conn, "
INSERT INTO db_pesanan
(id_user, nama_pembeli, no_hp, alamat, pembayaran, total, status, tanggal)
VALUES
('$id_user','$nama','$hp','$alamat','$pembayaran','$total','Menunggu',NOW())
");

/* JIKA GAGAL */
if (!$insertPesanan) {
    die('Gagal menyimpan pesanan: '.mysqli_error($conn));
}

/* AMBIL ID PESANAN */
$id_pesanan = mysqli_insert_id($conn);

/* SIMPAN DETAIL PESANAN */
foreach ($_SESSION['cart'] as $id_produk => $qty) {

    $q = mysqli_query($conn, "SELECT harga, stok FROM db_produk WHERE id='$id_produk'");
    if ($p = mysqli_fetch_assoc($q)) {

        $harga = $p['harga'];
        $subtotal = $harga * $qty;

        mysqli_query($conn, "
        INSERT INTO db_pesanan_detail
        (id_pesanan, id_produk, qty, harga, subtotal)
        VALUES
        ('$id_pesanan','$id_produk','$qty','$harga','$subtotal')
        ");

        /* KURANGI STOK */
        mysqli_query($conn, "
        UPDATE db_produk SET stok = stok - $qty WHERE id='$id_produk'
        ");
    }
}

/* KOSONGKAN KERANJANG */
unset($_SESSION['cart']);

/* REDIRECT */
header("Location: selesai.php?id=$id_pesanan");
exit;
?>
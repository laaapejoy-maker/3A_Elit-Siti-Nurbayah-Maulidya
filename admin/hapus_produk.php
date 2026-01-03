<?php
session_start();
include "../function.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM db_produk WHERE id='$id'");

header("Location: produk.php");
exit;
?>
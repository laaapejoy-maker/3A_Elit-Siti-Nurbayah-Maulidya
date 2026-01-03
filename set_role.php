<?php
session_start();

if (!isset($_GET['role'])) {
    header("Location: pilih_role.php");
    exit;
}

$role = $_GET['role'];
$_SESSION['role'] = $role;

/* REDIRECT SESUAI ROLE */
if ($role == 'admin') {
    header("Location: admin/login_admin.php");
    exit;
}

if ($role == 'user') {
    header("Location: login_user.php");
    exit;
}

/* DEFAULT */
header("Location: pilih_role.php");
exit;
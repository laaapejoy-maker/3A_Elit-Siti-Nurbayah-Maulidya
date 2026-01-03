<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: pilih_role.php");
    exit;
}

include "function.php";

if (isset($_POST['register'])) {
    registerUser($_POST['nama'], $_POST['email'], $_POST['password']);
    echo "<script>alert('Register berhasil!');window.location='login_user.php'</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register User – ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
<div class="container h-100 d-flex justify-content-center align-items-center">
<div class="card shadow p-4 text-center"
     style="max-width:400px;width:100%;border-radius:16px;">


<h4 class="text-center" style="color:#d84b8c;">Register User</h4>

<form method="POST">
    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

    <button name="register" class="btn w-100" style="background:#ff71b8;color:white;">
        Register
    </button>
</form>

<p class="text-center mt-3">
    Sudah punya akun?
    <a href="login_user.php">Login sekarang</a>
</p>

</div>
</div>

</body>
</html>
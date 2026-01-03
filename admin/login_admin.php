<?php
session_start();
include "../function.php";

/* WAJIB SUDAH PILIH ROLE ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../pilih_role.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = loginAdmin($username, $password);

    if (mysqli_num_rows($cek) > 0) {
        $a = mysqli_fetch_assoc($cek);

        $_SESSION['admin_id']   = $a['id'];
        $_SESSION['admin_nama'] = $a['nama'];

        header("Location: dashboard_admin.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Admin - ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
   
<div class="container h-100 d-flex justify-content-center align-items-center">

<div class="card shadow p-4 text-center"
     style="max-width:400px;width:100%;border-radius:16px;">

<h4 class="text-center" style="color:#d84b8c;">Login Admin</h4>

<?php if ($error != "") { ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">
<input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button name="login" class="btn w-100" style="background:#ff71b8;color:white;">
Login Admin
</button>
</form>

<p class="text-center mt-3">
you dont have account?
<a href="register_admin.php">register now</a>
</p>

</div>
</div>
</body>
</html>
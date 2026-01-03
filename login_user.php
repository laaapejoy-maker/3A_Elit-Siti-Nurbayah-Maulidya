<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "function.php";

// Cegah akses langsung tanpa memilih role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: pilih_role.php");
    exit;
}

$error = "";

// PROSES LOGIN 
if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $cek = loginUser($email, $password);

    if (mysqli_num_rows($cek) > 0) {
        $u = mysqli_fetch_assoc($cek);

        $_SESSION['user_id']   = $u['id'];
        $_SESSION['user_nama'] = $u['nama'];

        header("Location: toko.php");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login User – ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
<div class="container h-100 d-flex justify-content-center align-items-center">
<div class="card shadow p-4 text-center"
     style="max-width:400px;width:100%;border-radius:16px;">

<h4 class="text-center mb-3" style="color:#d84b8c;">Login User</h4>

<?php if ($error != "") { ?>
<div class="alert alert-danger text-center">
    <?= $error; ?>
</div>
<?php } ?>

<form method="POST">
    <input type="email"
           name="email"
           class="form-control mb-2"
           placeholder="Email"
           required>

    <input type="password"
           name="password"
           class="form-control mb-3"
           placeholder="Password"
           required>

    <button name="login"
            class="btn w-100"
            style="background:#ff71b8;color:white;">
        Login
    </button>
</form>

<p class="text-center mt-3">
    Belum punya akun?
    <a href="register_user.php">Register sekarang</a>
</p>

</div>
</div>


</body>
</html>
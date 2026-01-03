<?php
// SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "function.php";

// CEK LOGIN USER
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = "";
$error   = "";

// MENGAMBIL DATA USER 
$q = mysqli_query($conn, "SELECT * FROM db_users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($q);

// PROSES UPDATE
if (isset($_POST['update'])) {
    $nama  = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pass  = $_POST['password'];

    // Jika password diisi → update password
    if ($pass != "") {
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $update = mysqli_query($conn, "
            UPDATE db_users SET
            nama='$nama',
            email='$email',
            password='$password'
            WHERE id='$user_id'
        ");
    } else {
        // Jika password kosong → tidak diubah
        $update = mysqli_query($conn, "
            UPDATE db_users SET
            nama='$nama',
            email='$email'
            WHERE id='$user_id'
        ");
    }

    if ($update) {
        $_SESSION['user_nama'] = $nama;
        $success = "Akun berhasil diperbarui";
    } else {
        $error = "Gagal memperbarui akun";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Akun Saya - ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">

<div class="container h-100 d-flex justify-content-center align-items-center">
<div class="card shadow p-4"
     style="max-width:450px;width:100%;border-radius:18px;">

<h4 class="text-center mb-3" style="color:#d84b8c;">
Akun Saya
</h4>

<?php if ($success != "") { ?>
<div class="alert alert-success text-center">
<?= $success; ?>
</div>
<?php } ?>

<?php if ($error != "") { ?>
<div class="alert alert-danger text-center">
<?= $error; ?>
</div>
<?php } ?>

<form method="POST">

<label class="fw-semibold">Nama</label>
<input type="text"
       name="nama"
       class="form-control mb-2"
       value="<?= htmlspecialchars($user['nama']); ?>"
       required>

<label class="fw-semibold">Email</label>
<input type="email"
       name="email"
       class="form-control mb-2"
       value="<?= htmlspecialchars($user['email']); ?>"
       required>

<label class="fw-semibold">
Password Baru <small class="text-muted">(opsional)</small>
</label>
<input type="password"
       name="password"
       class="form-control mb-3"
       placeholder="Kosongkan jika tidak diubah">

<button name="update"
        class="btn w-100"
        style="background:#ff71b8;color:white;">
Simpan Perubahan
</button>

<a href="toko.php"
   class="btn btn-light w-100 mt-2">
Kembali ke Toko
</a>

</form>

</div>
</div>

</body>
</html>
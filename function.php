<?php
// KONEKSI DATABASE 
$conn = mysqli_connect("localhost", "root", "", "elcharm");
if (!$conn) {
    die("Koneksi database gagal");
}

// REGISTER USER
function registerUser($nama, $email, $password) {
    global $conn;
    $password = md5($password);

    return mysqli_query($conn, "
        INSERT INTO db_users (nama, email, password)
        VALUES ('$nama', '$email', '$password')
    ");
}

// LOGIN USER
function loginUser($email, $password) {
    global $conn;
    $password = md5($password);

    return mysqli_query($conn, "
        SELECT * FROM db_users 
        WHERE email='$email' AND password='$password'
    ");
}

// Register Admin
function registerAdmin($nama, $username, $password) {
    global $conn;
    $password = md5($password);
    return mysqli_query($conn, "
        INSERT INTO db_admin (nama, username, password)
        VALUES ('$nama', '$username', '$password')
    ");
}

// Login Admin
function loginAdmin($username, $password) {
    global $conn;
    $password = md5($password);
    return mysqli_query($conn, "
        SELECT * FROM db_admin 
        WHERE username='$username' AND password='$password'
    ");
}

// Mengambil semua produk
function getProduk() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM db_produk ORDER BY id DESC");
}

// Mengambil produk berdasarkan ID
function getProdukById($id) {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM db_produk WHERE id='$id'");
}
?>
<?php
session_start();
include "function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

/* INIT VARIABLE */
$keyword = '';
$where   = '';

if (isset($_GET['search']) && $_GET['search'] !== '') {
    $keyword = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE nama_produk LIKE '%$keyword%'";
}

/* QUERY */
$produk = mysqli_query($conn, "
    SELECT * FROM db_produk
    $where
    ORDER BY created_at DESC
");

$review = mysqli_query($conn, "
    SELECT * FROM db_customer_says
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Toko - ElCharm</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(180deg,#ffeef5,#ffffff);
}

.navbar-brand{
    position:relative;
    display:flex;
    align-items:center;
    padding-left:60px;
}

.navbar-brand img{
    position:absolute;
    left:0;
    width:50px; 
    height:auto;
    object-fit:contain;
    background:transparent;
}

.hero-image{
    position:relative;
    height:70vh;
    background:url('dist/assets/img/bg1.jpeg') center/cover no-repeat;
    display:flex;
    align-items:center;
    justify-content:center;
}
.hero-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(180deg,rgba(156,113,113,.35),rgba(255,255,255,.65));
}
.hero-content{
    position:relative;
    z-index:2;
    text-align:center;
    color:white;
}
.hero-search{
    position:absolute;
    top:20px;
    right:30px;
    z-index:3;
    width:300px;
}
.marquee-wrapper {
    overflow:hidden;
    background: #ff69b4ff;
}
.marquee {
    display:inline-block;
    white-space:nowrap;
    padding:10px 0;
    color: #fdffe5ff;
    font-weight:600;
    animation: marqueeBounce 12s ease-in-out infinite alternate;
}
@keyframes marqueeBounce {
    from { transform: translateX(0); }
    to { transform: translateX(calc(100vw - 100%)); }
}

.review-wrapper{
    text-align:center;
}
.review-name-top{
    font-size:13px;
    font-weight:600;
    color:#d84b8c;
    margin-bottom:6px;
}
.review-card{
    background: #fdfdebff;
    border-radius:16px;
    padding-top:22px;
    position:relative;
    transition:.3s;
}
.review-star{
    color:#ff71b8 !important;
    font-size:14px;
}
.review-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 25px rgba(0,0,0,.12);
}
.review-btn{
    position:absolute;
    top:-14px;
    left:50%;
    transform:translateX(-50%);
    background:white;
    color:pink #fc80beff;
    border:none;
    padding:4px 14px;
    font-size:12px;
    font-weight:600;
    border-radius:20px;
    box-shadow:0 4px 10px rgba(0,0,0,.15);
}
.review-text{
    font-size:13px;
    color:#555;
    line-height:1.5;
}
.review-star{
    font-size:12px;
}
.review-container-card{
    background: #ffd8f2ff;
    border-radius:26px;
    padding:35px 25px;
    box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.owner-section{
    background:linear-gradient(180deg,#fff0f7,#ffffff);
}
.owner-card{
    background: #fff7b3ff;
    border-radius:22px;
    padding:30px;
    box-shadow:0 12px 30px rgba(0,0,0,.12);
}
.owner-img{
    width:130px;
    height:130px;
    border-radius:50%;
    object-fit:cover;
    border:6px solid white;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}
.owner-name{
    font-size:22px;
    font-weight:700;
    color:#d84b8c;
}
.owner-role{
    font-size:14px;
    color:#888;
}
.owner-bio{
    font-size:14px;
    color:#555;
    line-height:1.7;
}
.owner-info i{
    color:#ff71b8;
    margin-right:6px;
}


.card-produk{
    border-radius:32px !important; 
    overflow:hidden;               
    transition:.3s;
}

.card-produk:hover{
    transform:translateY(-10px);
    box-shadow:0 18px 35px rgba(0,0,0,.15);
}


.card-produk img{
    border-radius:28px 28px 0 0;
}
.card-produk{ transition:.3s; }
.card-produk:hover{
    transform:translateY(-10px);
    box-shadow:0 18px 35px rgba(0,0,0,.15);
}
.btn-pink{ background:#ff71b8;color:white; }
.btn-pink:hover{ background:#e85aa3;color:white; }
.btn-cart{ background:#c084fc;color:white; }
.social-icon{ transition:.4s; }
.social-icon:hover{ transform:translateX(10px) scale(1.2); }
</style>
</head>

<body>

<!-- MUSIC -->
<audio id="bgMusic" loop>
    <source src="dist/assets/audio/happy.mp3" type="audio/mpeg">
</audio>

<button id="musicBtn"
style="
position:fixed;
bottom:22px;
right:22px;
z-index:999;
width:45px;
height:45px;
border-radius:50%;
border:none;
background:#ff71b8;
color:white;
font-size:18px;
box-shadow:0 8px 20px rgba(0,0,0,.2);
">
🎵
</button>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm"
style="background:linear-gradient(90deg,#ff71b8,#c084fc);">
<div class="container">
<span class="navbar-brand fw-bold text-white fs-4">
    <img src="dist/assets/img/logo.png" alt="ElCharm Logo">
    ElCharm
</span>
<div class="d-flex align-items-center gap-3">
<span class="text-white">Halo, <?= $_SESSION['user_nama']; ?></span>
<a href="akun_user.php" class="btn btn-pink btn-sm">👤</a>
<a href="logout_user.php" class="btn btn-pink btn-sm">Logout</a>
<a href="keranjang.php" class="text-white fs-4"><i class="bi bi-cart"></i></a>
<a href="chat_user.php" class="text-white fs-4"><i class="bi bi-chat-dots"></i></a>
</div>
</div>
</nav>

<!-- HERO -->
<section class="hero-image">
<div class="hero-overlay"></div>

<form method="GET" class="hero-search">
<div class="input-group">
<input type="text" name="search" class="form-control"
placeholder="Cari produk..." value="<?= htmlspecialchars($keyword); ?>">
<button class="btn btn-pink"><i class="bi bi-search"></i></button>
</div>
</form>

<div class="hero-content">
<h1 class="fw-bold">Tinny Charms Full of Joy✨</h1>
<p class="mb-4">Adorable keychains to brighten your day</p>
<a href="#produk" class="btn btn-lg btn-pink px-5 rounded-pill"> Buy Now</a>
</div>
</section>

<!-- MARQUEE -->
<div class="marquee-wrapper">
<div class="marquee text-center">
★ Welcome to ElCharm Store — tiny plushies crafted to bring endless comfort, warmth, and a little peace to your soul ★ 
</div>
</div>

<!-- PRODUK -->
<section id="produk" class="container py-5">
<h3 class="text-center mb-4 fw-bold" style="color:#d84b8c;">
<?= $keyword !== '' ? "Hasil pencarian: “".htmlspecialchars($keyword)."”" : "Our Products"; ?>
</h3>

<div class="row g-4">
<?php if(mysqli_num_rows($produk)>0): ?>
<?php while($p=mysqli_fetch_assoc($produk)): ?>
<div class="col-md-3">
<div class="card border-0 shadow-sm h-100 rounded-4 card-produk">
<div class="ratio ratio-1x1">
<img src="uploads/<?= $p['gambar']; ?>" class="w-100 h-100 object-fit-cover">
</div>
<div class="card-body text-center">
<h6 class="fw-semibold"><?= $p['nama_produk']; ?></h6>
<p class="fw-bold" style="color:#d84b8c;">Rp <?= number_format($p['harga']); ?></p>
<div class="d-flex gap-2 justify-content-center">
<a href="detail_produk.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-pink">View Detail</a>
<form method="POST" action="keranjang.php">
<input type="hidden" name="id_produk" value="<?= $p['id']; ?>">
<input type="hidden" name="qty" value="1">
<button class="btn btn-sm btn-cart"><i class="bi bi-cart"></i></button>
</form>
</div>
</div>
</div>
</div>
<?php endwhile; ?>
<?php else: ?>
<p class="text-center text-muted">Produk tidak ditemukan 💔</p>
<?php endif; ?>
</div>
</section>

<!-- REVIEW -->
<section class="py-5" style="background:#fff0f7;">
<div class="container">

<div class="review-container-card">

<div class="text-center mb-4">
<a href="review.php" class="btn btn-pink px-4">✍️ Add Review</a>
</div>

<div class="row g-3 justify-content-center">

<?php while($r=mysqli_fetch_assoc($review)): ?>
<div class="col-md-2 col-sm-6">

<div class="review-wrapper">

<div class="card border-0 review-card">

<button class="review-btn">
<?= htmlspecialchars($r['nama']); ?>
</button>

<div class="card-body text-center p-3">

<p class="fst-italic review-text mb-2">
“<?= htmlspecialchars($r['pesan']); ?>”
</p>

<div class="review-star mb-1">
<?php for($i=1;$i<=$r['bintang'];$i++) echo "★"; ?>
</div>

<div class="small text-muted">
<?= htmlspecialchars($r['alamat']); ?>
</div>

</div>
</div>

</div>
</div>
<?php endwhile; ?>

</div>

</div>

</div>
</section>

<!-- OWNER PROFILE -->
<section class="owner-section py-5">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">

<div class="owner-card text-center">

<img src="dist/assets/img/me3.jpeg" class="owner-img mb-3">

<h4 class="owner-name mb-1">ELIT SNM</h4>
<div class="owner-role mb-3">Owner & Founder ElCharm</div>

<p class="owner-bio mb-4 ">
ElCharm dikelola oleh owner yang berfokus menghadirkan keychain 
desain aesthehic, iconic, dan berkualitas. 
Setiap produk dipilih dengan perhatian pada detail agar nyaman digunakan 
dan memberikan kesan hangat bagi pelanggan. ElCharm berkomitmen untuk 
memberikan pengalaman belanja yang menyenangkan dan terpercaya.
yang layak dirayakan dengan produk berkualitas dan penuh cinta 💕
</p>

<div class="row text-start owner-info">
<div class="col-md-6 mb-2">
<i class="bi bi-shop"></i> <strong>Name Toko:</strong> ElCharm 
</div>
<div class="col-md-6 mb-2">
<i class="bi bi-geo-alt"></i> <strong>Location:</strong> Purwakarta, Indonesia
</div>
<div class="col-md-6 mb-2">
<i class="bi bi-heart"></i> <strong>Product:</strong> Keychain
</div>
<div class="col-md-6 mb-2">
<i class="bi bi-stars"></i> <strong>Style:</strong> Crybaby
</div>
</div>

</div>

</div>
</div>
</div>
</section>

<!-- FOOTER -->

<!-- FOOTER -->
<footer class="pt-5 pb-3"
style="background:linear-gradient(90deg,#ff71b8,#c084fc);color:white;">
<div class="container">
<div class="row">
<div class="col-md-4 mb-3">
<h5 class="fw-bold">ElCharm</h5>
<p class="small">Tinny charms full of joy</p>
</div>
<div class="col-md-4 mb-3">
<h6 class="fw-bold">About</h6>
<ul class="list-unstyled small">
<li>Our Story</li>
<li>Products</li>
<li>Contact</li>
</ul>
</div>
<div class="col-md-4 mb-3">
<h6 class="fw-bold">Follow Us</h6>
<div class="fs-5 d-flex gap-3">
    <!-- INSTAGRAM -->
    <a href="https://www.instagram.com/____lita?igsh=bjBjNnY4bG00ZXJy"
       target="_blank"
       class="text-white social-icon">
        <i class="bi bi-instagram"></i>
    </a>

    <!-- TIKTOK -->
    <a href="https://www.tiktok.com/@lifebetter39?_r=1&_t=ZS-92WEOU6UF8v"
       target="_blank"
       class="text-white social-icon">
        <i class="bi bi-tiktok"></i>
    </a>

    <!-- WHATSAPP -->
    <a href="https://whatsapp.com/biz/"
       target="_blank"
       class="text-white social-icon">
        <i class="bi bi-whatsapp"></i>
    </a>
</div>
</footer>

<script>
const music = document.getElementById("bgMusic");
const btn = document.getElementById("musicBtn");

if(localStorage.getItem("musicStatus")==="play"){
    music.volume=0.25;
    music.play();
    btn.innerHTML="🔊";
}

btn.onclick=()=>{
    if(music.paused){
        music.volume=0.25;
        music.play();
        localStorage.setItem("musicStatus","play");
        btn.innerHTML="🔊";
    }else{
        music.pause();
        localStorage.setItem("musicStatus","pause");
        btn.innerHTML="🎵";
    }
};
</script>

</body>
</html>
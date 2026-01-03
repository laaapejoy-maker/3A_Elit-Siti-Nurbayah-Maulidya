<?php
session_start();
if (empty($_SESSION['cart'])) {
    header("Location: toko.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout - ElCharm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(180deg,#ffd6e8,#ffffff);
    min-height:100vh;
}
.checkout-card{
    background:white;
    border-radius:20px;
    padding:30px;
    box-shadow:0 15px 30px rgba(0,0,0,.15);
}
.label{
    font-weight:600;
    color:#d84b8c;
}
</style>
</head>

<body>

<div class="container mt-5" style="max-width:500px;">

<div class="checkout-card">

<h3 class="text-center mb-4" style="color:#d84b8c;">Checkout</h3>

<form method="POST" action="proses_checkout.php">

<label class="label">Nama</label>
<input type="text" name="nama" class="form-control mb-3" required>

<label class="label">No HP</label>
<input type="text" name="hp" class="form-control mb-3" required>

<label class="label">Alamat</label>
<textarea name="alamat" class="form-control mb-3" required></textarea>

<label class="label">Metode Pembayaran</label>
<select name="pembayaran" id="pembayaran" class="form-control mb-3" required>
    <option value="">-- Pilih --</option>
    <option value="Transfer Bank">Transfer Bank</option>
    <option value="COD">COD</option>
    <option value="E-Wallet">E-Wallet</option>
</select>

<!-- PILIH BANK -->
<div id="bankBox" style="display:none;">
<label class="label">Pilih Bank</label>
<select name="bank" id="bank" class="form-control mb-3">
    <option value="">-- Pilih Bank --</option>
    <option value="BCA">BCA</option>
    <option value="Mandiri">Mandiri</option>
    <option value="BRI">BRI</option>
    <option value="BJB">BJB</option>
</select>
</div>

<!-- NO REKENING -->
<div id="rekeningBox" style="display:none;">
<label class="label">Nomor Rekening</label>
<input type="text" id="rekening" class="form-control mb-3" readonly>
</div>

<!-- BARCODE E-WALLET -->
<div id="ewalletBox" class="text-center" style="display:none;">
<p class="label">Scan QR E-Wallet</p>
<img src="dist/assets/img/qr.jpeg"
style="width:220px;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.2);">
</div>

<button class="btn w-100 mt-4"
style="background:#ff71b8;color:white;border-radius:30px;font-weight:600;">
Bayar Sekarang
</button>

</form>

</div>
</div>

<script>
const pembayaran = document.getElementById('pembayaran');
const bankBox = document.getElementById('bankBox');
const bank = document.getElementById('bank');
const rekeningBox = document.getElementById('rekeningBox');
const rekening = document.getElementById('rekening');
const ewalletBox = document.getElementById('ewalletBox');

pembayaran.addEventListener('change', function(){
    bankBox.style.display = 'none';
    rekeningBox.style.display = 'none';
    ewalletBox.style.display = 'none';

    if(this.value === 'Transfer Bank'){
        bankBox.style.display = 'block';
    }

    if(this.value === 'E-Wallet'){
        ewalletBox.style.display = 'block';
    }
});

bank.addEventListener('change', function(){
    let no = '';

    if(this.value === 'BCA') no = '1234567890';
    if(this.value === 'Mandiri') no = '9876543210';
    if(this.value === 'BRI') no = '1122334455';
    if(this.value === 'BJB') no = '9988776655';

    if(no !== ''){
        rekeningBox.style.display = 'block';
        rekening.value = no;
    }else{
        rekeningBox.style.display = 'none';
        rekening.value = '';
    }
});
</script>

</body>
</html>
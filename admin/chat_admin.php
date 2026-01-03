<?php
session_start();
include "../function.php";

if (!isset($_SESSION['admin_id'])) {
    exit;
}

if (isset($_POST['balas'])) {
    $pesan = mysqli_real_escape_string($conn,$_POST['pesan']);
    $user  = $_POST['user_id'];

    mysqli_query($conn,"INSERT INTO db_chat (user_id,pesan,pengirim)
                        VALUES ('$user','$pesan','admin')");
}

$users = mysqli_query($conn,"
    SELECT DISTINCT user_id FROM db_chat ORDER BY user_id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Chat User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: #ffffffff
}
.user-card{ 
    border-radius:16px;
    padding:14px;
    cursor:pointer;
    transition:.3s;
}
.user-card:hover{
    background:#fff0f7;
}

.chat-area{
    display:none;
    margin-top:12px;
}
.chat-box{
    max-height:300px;
    overflow-y:auto;
    padding:14px;
    border-radius:18px;
    background:rgba(255, 199, 199, 0.75);
}

.bubble{
    display:inline-block;
    padding:8px 12px;
    border-radius:16px;
    font-size:14px;
    line-height:1.4;
    margin-bottom:6px;
    max-width:75%;
}
.admin{
    background:#ff71b8;
    color:white;
    border-bottom-right-radius:4px;
}
.user{
    background:#ff71b8;
    color:white;
    border-bottom-left-radius:4px;
}
.time{
    font-size:11px;
    opacity:.7;
    margin-top:2px;
    text-align:right;
}

.input-group input{
    border-radius:20px 0 0 20px;
}
.input-group button{
    border-radius:0 20px 20px 0;
    background:#ff71b8;
    color:white;
    border:none;
}
</style>
</head>

<body>
<div class="container py-4">

<h5 class="fw-bold text-center mb-4" style="color:#d84b8c;">💬 Chat User</h5>

<?php while($u=mysqli_fetch_assoc($users)): 
$user_id = $u['user_id'];
$chat = mysqli_query($conn,"
    SELECT * FROM db_chat
    WHERE user_id='$user_id'
    ORDER BY created_at ASC
");
?>

<div class="card border-0 shadow-sm mb-3 rounded-4"
     style="background:transparent;">

<div class="card-body p-2">

<!-- USER HEADER -->
<div class="user-card d-flex align-items-center gap-3"
     onclick="toggleChat('chat<?= $user_id; ?>')">

<div class="rounded-circle d-flex align-items-center justify-content-center"
     style="width:42px;height:42px;background:#ff71b8;color:white;font-weight:bold;">
U
</div>

<div>
<div class="fw-semibold">User <?= $user_id; ?></div>
<small class="text-muted">Klik untuk membuka chat</small>
</div>

</div>

<!-- CHAT -->
<div class="chat-area" id="chat<?= $user_id; ?>">

<div class="chat-box my-2">
<?php while($c=mysqli_fetch_assoc($chat)): ?>
<div class="<?= $c['pengirim']=='admin'?'text-end':'text-start'; ?>">
    <div class="bubble <?= $c['pengirim']=='admin'?'admin':'user'; ?>">
        <?= htmlspecialchars($c['pesan']); ?>
        <div class="time">
            <?= date('H:i', strtotime($c['created_at'])); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>

<form method="POST">
<input type="hidden" name="user_id" value="<?= $user_id; ?>">
<div class="input-group">
<input type="text" name="pesan" class="form-control" placeholder="Balas pesan..." required>
<button name="balas">Kirim</button>
</div>
</form>

</div>
</div>
</div>

<?php endwhile; ?>

</div>

<script>
function toggleChat(id){
    const el = document.getElementById(id);
    const isOpen = el.style.display === "block";

    document.querySelectorAll('.chat-area').forEach(c=>{
        c.style.display = "none";
    });

    if(!isOpen){
        el.style.display = "block";
        localStorage.setItem("openChat", id);
    }else{
        localStorage.removeItem("openChat");
    }
}

window.onload = function(){
    const openChat = localStorage.getItem("openChat");
    if(openChat){
        const el = document.getElementById(openChat);
        if(el){
            el.style.display = "block";
        }
    }
}
</script>

</body>
</html>
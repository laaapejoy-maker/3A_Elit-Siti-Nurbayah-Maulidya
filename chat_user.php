<?php
session_start();
include "function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['kirim'])) {
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
    mysqli_query($conn,"INSERT INTO db_chat (user_id,pesan,pengirim)
                         VALUES ('$user_id','$pesan','user')");
    header("Location: chat_user.php");
    exit;
}

$chat = mysqli_query($conn,"
    SELECT * FROM db_chat
    WHERE user_id='$user_id'
    ORDER BY created_at ASC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Chat Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(180deg,#ffd6eb,#ffffff);
    height:100vh;
}

.back-wrapper{
    max-width:600px;
    margin:20px auto 0;
}

.btn-back{
    background:white;
    color:#ff71b8;
    border:none;
    padding:6px 16px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    box-shadow:0 4px 12px rgba(0,0,0,.15);
}

.chat-wrapper{
    max-width:600px;
    margin:10px auto;
    height:85vh;
    display:flex;
    flex-direction:column;
    border-radius:20px;
    overflow:hidden;
}

.chat-header{
    background:linear-gradient(135deg,#ff71b8,#c084fc);
    color:white;
    padding:14px;
    text-align:center;
    font-weight:600;
}

.chat-box{
    flex:1;
    background:#fff0f8;
    padding:15px;
    overflow-y:auto;
}

.chat-row{
    display:flex;
    margin-bottom:8px;
}

.chat-row.left{ justify-content:flex-start; }
.chat-row.right{ justify-content:flex-end; }

.bubble{
    max-width:75%;
    padding:10px 14px;
    border-radius:18px;
    font-size:14px;
    line-height:1.4;
    box-shadow:0 6px 14px rgba(0,0,0,.12);
}

.user{
    background:linear-gradient(135deg,#ff71b8,#ff9ad5);
    color:white;
    border-bottom-right-radius:6px;
}

.admin{
    background:linear-gradient(135deg,#ff71b8,#ff9ad5);
    color:white;
    border-bottom-right-radius:6px;
}

.time{
    display:block;
    font-size:11px;
    opacity:.7;
    margin-top:4px;
    text-align:right;
}
</style>
</head>

<body>

<!-- BUTTON KEMBALI -->
<div class="back-wrapper">
    <a href="toko.php" class="btn-back">← Kembali</a>
</div>

<!-- CARD CHAT -->
<div class="chat-wrapper shadow-lg">

    <div class="chat-header">
        💬 Chat Admin
    </div>

    <div class="chat-box" id="chatBox">
        <?php while($c=mysqli_fetch_assoc($chat)): ?>
            <div class="chat-row <?= $c['pengirim']=='user'?'right':'left'; ?>">
                <div class="bubble <?= $c['pengirim']=='user'?'user':'admin'; ?>">
                    <?= htmlspecialchars($c['pesan']); ?>
                    <span class="time">
                        <?= date('H:i',strtotime($c['created_at'])); ?>
                    </span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <form method="POST" class="p-2 bg-white">
        <div class="input-group">
            <input type="text" name="pesan" class="form-control rounded-pill"
                   placeholder="Ketik pesan..." required>
            <button name="kirim" class="btn rounded-pill ms-2"
                    style="background:#ff71b8;color:white">
                Kirim
            </button>
        </div>
    </form>

</div>

<script>
const chatBox = document.getElementById("chatBox");
chatBox.scrollTop = chatBox.scrollHeight;
</script>

</body>
</html>
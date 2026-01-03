<?php
session_start();
unset($_SESSION['role']); // reset role
?>
<!DOCTYPE html>
<html>
<head>
<title>Pilih Role</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</style>
</head>

<body style="background:linear-gradient(180deg,#ffd6e8,#fff);height:100vh;">
   
<div class="container h-100 d-flex justify-content-center align-items-center">

<div class="card shadow p-4 text-center"
     style="max-width:400px;width:100%;border-radius:16px;">

<h4 class="mb-4 fw-bold" style="color:#d84b8c;">
Masuk Sebagai
</h4>

<!-- USER -->
<a href="set_role.php?role=user"
   class="btn mb-3 w-100"
   style="background:#ff71b8;color:white;">
👩‍💼 User
</a>

<!-- ADMIN -->
<a href="set_role.php?role=admin"
   class="btn w-100"
   style="background:#c084fc;color:white;">
🛠 Admin
</a>

</div>
</div>

</body>
</html>
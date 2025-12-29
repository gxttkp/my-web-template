<?php
session_start();
require_once "../connection.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - IPSC</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- ===== INLINE CSS (เฉพาะหน้า Login) ===== -->
    <style>
        *{
            box-sizing:border-box;
            margin:0;
            padding:0;
            font-family:'Kanit',sans-serif;
        }

        body{
            background:#f3f3f3;
            height:100vh;
        }

        .login-wrapper{
            height:100%;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-card{
            width:360px;
            background:#fff;
            padding:35px;
            border-radius:20px;
            text-align:center;
            box-shadow:0 10px 25px rgba(0,0,0,.15);
        }

        .login-card h1{
            font-size:24px;
            font-weight:600;
        }

        .login-card p{
            font-size:14px;
            margin-top:5px;
            color:#666;
        }

        .login-card input{
            width:100%;
            margin-top:18px;
            padding:12px;
            border-radius:8px;
            border:1px solid #ccc;
            font-size:14px;
        }

        .login-card input:focus{
            outline:none;
            border-color:#547792;
        }

        .login-card button{
            width:100%;
            margin-top:22px;
            padding:12px;
            border-radius:8px;
            border:none;
            background:#547792;
            color:#fff;
            font-size:16px;
            cursor:pointer;
        }

        .login-card button:hover{
            background:#47667c;
        }

        .error{
            background:#FD7979;
            color:#fff;
            padding:10px;
            border-radius:8px;
            margin-top:15px;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <h1>การแข่งขันกีฬา IPSC</h1>
        <p>(หน้าแอดมิน)</p>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </div>
</div>

</body>
</html>

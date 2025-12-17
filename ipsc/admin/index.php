<?php
    session_start();


    // ถ้า login แล้ว ให้เข้า dashboard เลย
    if (isset($_SESSION['admin'])) {
        header('Location: dashboard.php');
        exit;
    }


    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['password'] === 'ipsc-cmtc@2025') {
            $_SESSION['admin'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'รหัสผ่านไม่ถูกต้อง';
        }
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>


    <!-- Kanit Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Password</h2>
            <form method="post">
                <input type="password" name="password" placeholder="Enter Admin Password" required>
                <button type="submit">LOGIN</button>
            </form>

        <?php if ($error): ?>
            <p class="error">❌ <?= $error ?></p>
        <?php endif; ?>
        
        </div>
    </div>
</body>
</html>
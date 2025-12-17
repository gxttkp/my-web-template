<?php
require_once 'config/db.php';

// ดึงข้อมูลการตั้งค่าการแข่งขัน
$event = $conn->query("SELECT * FROM event_settings LIMIT 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>การแข่งขันกีฬา IPSC</title>

    <!-- Kanit Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <script defer src="assets/js/index.js"></script>
</head>
<body>

<div class="container">
    <h1 class="title">การแข่งขันกีฬา IPSC</h1>
    <p class="subtitle">
        วันที่ <?php echo $event['nDay']; ?>
        <?php echo $event['month_en']; ?>
        พ.ศ. <?php echo $event['year']; ?>
    </p>

    <!-- เมนูเลือก -->
    <div class="menu">
        <button class="menu-btn active" onclick="showSection('list')">รายชื่อผู้แข่งขัน</button>
        <button class="menu-btn" onclick="showSection('table')">ตารางการแข่งขัน</button>
    </div>

    <!-- รายชื่อผู้แข่งขัน -->
    <div id="list" class="section active">
        <div id="competitor-list" class="grid"></div>
    </div>

    <!-- ตารางการแข่งขัน -->
    <div id="table" class="section">
        <div id="competition-table" class="column"></div>
    </div>
</div>

</body>
</html>
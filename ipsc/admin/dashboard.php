<?php
session_start();
require_once '../config/db.php';


if (!isset($_SESSION['admin'])) {
header('Location: index.php');
exit;
}


// ดึงข้อมูลการแข่งขัน
$event = $conn->query("SELECT * FROM event_settings LIMIT 1")->fetch_assoc();


// ดึงผู้เข้าแข่งขัน
$competitors = $conn->query("SELECT * FROM competitors ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>


<!-- Kanit Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">


<link rel="stylesheet" href="../assets/css/style.css">
<script defer src="../assets/js/admin.js"></script>
</head>
<body>


<div class="container">
<h1 class="title">การแข่งขันกีฬา IPSC (หน้าแอดมิน)</h1>


<div class="menu">
<button onclick="showTab('event')">แก้ไขข้อมูล</button>
<button onclick="showTab('competitor')">ผู้เข้าแข่งขัน</button>
<a href="logout.php" class="logout">ออกจากระบบ</a>
</div>


<!-- แก้ไขข้อมูลการแข่งขัน -->
<div id="event" class="tab active">
<form id="eventForm">
<h3>วันที่/เดือน/ปี การแข่งขัน</h3>
<input type="number" name="nDay" value="<?= $event['nDay'] ?>">
<input type="text" name="month_en" value="<?= $event['month_en'] ?>">
<input type="number" name="year" value="<?= $event['year'] ?>">


<h3>จำนวนผู้เข้าแข่งขัน</h3>
<input type="number" name="total_competitors" value="<?= $event['total_competitors'] ?>">


<h3>จำนวนเป้ายิงทั้งหมด</h3>
<input type="number" name="total_targets" value="<?= $event['total_targets'] ?>">


<button type="submit">บันทึกข้อมูล</button>
</form>
</div>


<!-- ผู้เข้าแข่งขัน -->
<div id="competitor" class="tab">
</html>
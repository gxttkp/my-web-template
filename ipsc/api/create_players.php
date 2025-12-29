<?php
    require_once "../connection.php";
    session_start();

    // ตรวจสอบการเข้าสู่ระบบ
    if (!isset($_SESSION['admin'])) {
        exit(json_encode(['success'=>false,'message'=>'ไม่ได้เข้าสู่ระบบ']));
    }

    // จำนวนผู้แข่งขันที่ต้องการเพิ่ม
    $count = intval($_POST['count'] ?? 0);
    if ($count <= 0) {
        exit(json_encode(['success'=>false,'message'=>'จำนวนไม่ถูกต้อง']));
    }

    // ตรวจสอบจำนวนผู้แข่งขันปัจจุบัน
    $lastPlayer = $conn->query("SELECT id, code FROM players ORDER BY id DESC LIMIT 1")->fetch_assoc();
    $lastId = $lastPlayer['id'] ?? 0;
    $lastCode = $lastPlayer['code'] ?? 0;

    // เพิ่มผู้แข่งขันใหม่เฉพาะที่ยังไม่มี
    for ($i = $lastCode + 1; $i <= $count; $i++) {
        $name = "ผู้เข้าแข่งขันคนที่ " . $i;
        $code = $i;
        $time = 0.00; // ตั้งค่าเวลาเริ่มต้น

        // ใช้ prepared statement ปลอดภัย
        $stmt = $conn->prepare("INSERT INTO players (name, code, image, time) VALUES (?, ?, 'user.png', ?)");
        $stmt->bind_param("sid", $name, $code, $time);
        $stmt->execute();
    }

    echo json_encode(['success'=>true]);

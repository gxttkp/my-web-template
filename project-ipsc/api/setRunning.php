<?php
require 'db.php';

$id = intval($_POST['id']);

/* ยกเลิกสถานะ running ทุกคน */
$pdo->exec("UPDATE competitors SET is_running = 0");

/* ตั้งคนที่เลือก */
$stmt = $pdo->prepare("
    UPDATE competitors
    SET is_running = 1, is_dq = 0
    WHERE id = ?
");
$stmt->execute([$id]);

echo json_encode(["status" => "running"]);

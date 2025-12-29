<?php
session_start();
require_once "../connection.php";

if (!isset($_SESSION['admin'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$id  = intval($_POST['id'] ?? 0);
$cmd = $_POST['cmd'] ?? '';

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
    exit;
}

switch ($cmd) {
    case 'dq':
        $sql = "UPDATE players SET status='dq' WHERE id=?";
        break;

    case 'undq':
        $sql = "UPDATE players SET status='waiting' WHERE id=?";
        break;

    default:
        echo json_encode(["success" => false, "message" => "Invalid command"]);
        exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "อัปเดตสถานะเรียบร้อย"
]);

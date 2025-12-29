<?php
require_once "../connection.php";

header("Content-Type: application/json");

// อนุญาตเฉพาะ POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Method Not Allowed"
    ]);
    exit;
}

// รับค่า player_id
$player_id = intval($_POST['player_id'] ?? 0);

if ($player_id <= 0) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "ไม่พบรหัสผู้แข่งขัน"
    ]);
    exit;
}

/* ================= DISQUALIFY ================= */
$stmt = $conn->prepare(
    "UPDATE players
    SET status='dq', time=NULL
    WHERE id=?"
);
$stmt->bind_param("i", $player_id);
$stmt->execute();

echo json_encode([
    "status" => "success",
    "message" => "Disqualified สำเร็จ"
]);
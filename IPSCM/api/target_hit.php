<?php
require_once "../connection.php";

/*
รับจาก ESP32
POST:
- target_id
*/

$target_id = $_POST['target_id'] ?? null;

if (!$target_id) {
    echo json_encode(["success" => false, "message" => "No target_id"]);
    exit;
}

/* หา event */
$event = $conn->query("SELECT target_count FROM event LIMIT 1")->fetch_assoc();
$maxTargets = (int)$event['target_count'];

/* หา player ที่กำลังแข่ง */
$player = $conn->query("
    SELECT id FROM players
    WHERE status = 'running'
    LIMIT 1
")->fetch_assoc();

if (!$player) {
    echo json_encode(["success" => false, "message" => "No running player"]);
    exit;
}

$player_id = $player['id'];

/* บันทึกการยิง */
$conn->query("
    INSERT INTO target_log (player_id, target_id, hit_time)
    VALUES ($player_id, '$target_id', NOW())
");

/* นับจำนวนเป้า */
$count = $conn->query("
    SELECT COUNT(*) AS total
    FROM target_log
    WHERE player_id = $player_id
")->fetch_assoc()['total'];

/* ถ้ายิงครบ */
if ($count >= $maxTargets) {
    $conn->query("
        UPDATE players
        SET status='finished',
            time = TIMESTAMPDIFF(SECOND, start_time, NOW())
        WHERE id=$player_id
    ");
}

echo json_encode([
    "success" => true,
    "player_id" => $player_id,
    "hit" => $count,
    "max" => $maxTargets
]);

<?php
require_once "../connection.php";

$player_id = intval($_POST['player_id'] ?? 0);
if ($player_id <= 0) exit;

$stmt = $conn->prepare("
    UPDATE players
    SET status='running',
        start_time=NOW()
    WHERE id=? AND status='countdown'
");
$stmt->bind_param("i", $player_id);
$stmt->execute();

echo json_encode(["status" => "ok"]);

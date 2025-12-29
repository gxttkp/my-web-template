<?php
require_once "../connection.php";

/* event */
$event = $conn->query("SELECT target_count FROM event LIMIT 1")->fetch_assoc();

/* running player */
$player = $conn->query("
    SELECT id, name, start_time
    FROM players
    WHERE status='running'
    LIMIT 1
")->fetch_assoc();

if (!$player) {
    echo json_encode([
        "running" => false
    ]);
    exit;
}

/* count target */
$count = $conn->query("
    SELECT COUNT(*) AS total
    FROM target_log
    WHERE player_id={$player['id']}
")->fetch_assoc();

echo json_encode([
    "running" => true,
    "player" => $player['name'],
    "hit" => $count['total'],
    "max_target" => $event['target_count']
]);

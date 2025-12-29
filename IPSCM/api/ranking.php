<?php
    require_once "../connection.php";
    header("Content-Type: application/json; charset=utf-8");

    // ================= RUNNING =================
    $running = null;

    $qRunning = $conn->query("
        SELECT id, code, name, image, status
        FROM players
        WHERE status = 'running'
        LIMIT 1
    ");

    if ($qRunning && $qRunning->num_rows > 0) {
        $running = $qRunning->fetch_assoc();
    }

    // ================= RANKING =================
    $ranking = [];

    $qRanking = $conn->query("
        SELECT id, code, name, image, time, status
        FROM players
        WHERE time IS NOT NULL
        ORDER BY 
            CASE WHEN status='dq' THEN 1 ELSE 0 END,
            time ASC
    ");

    while ($row = $qRanking->fetch_assoc()) {
        if (!$row['image']) {
            $row['image'] = "user.png";
        }

        $row['time'] = floatval($row['time']);
        $ranking[] = $row;
    }

    echo json_encode([
        "running" => $running,
        "ranking" => $ranking
    ], JSON_UNESCAPED_UNICODE);

    exit;

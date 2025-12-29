<?php
    require_once "../connection.php";
    header("Content-Type: application/json");

    /* ผู้ที่มีเวลาแล้ว */
    $sql = "SELECT name, code, image, time, status
            FROM players
            WHERE time IS NOT NULL
            ORDER BY time ASC";

    $result = $conn->query($sql);
    $ranking = [];

    while ($row = $result->fetch_assoc()) {
        $ranking[] = $row;
    }

    /* คนที่กำลังแข่งขัน */
    $running = $conn->query(
        "SELECT name, code, image
        FROM players
        WHERE status='running'
        LIMIT 1"
    )->fetch_assoc();

    echo json_encode([
        "running" => $running,
        "ranking" => $ranking
    ]);

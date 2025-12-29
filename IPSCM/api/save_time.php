<?php
    require_once "../connection.php";

    /*
    ESP32 ส่งมาแบบ POST
    - code (IPSCxxx)
    - time (วินาที)
    */

    $code = $_POST['code'] ?? null;
    $time = $_POST['time'] ?? null;

    if (!$code || !$time) {
        http_response_code(400);
        exit;
    }

    $stmt = $conn->prepare(
        "UPDATE players
        SET time=?, status='finished'
        WHERE code=?"
    );
    $stmt->bind_param("ds", $time, $code);
    $stmt->execute();

    echo "OK";

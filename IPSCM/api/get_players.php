<?php
    require_once "../connection.php";
    header("Content-Type: application/json");

    $sql = "SELECT id, name, code, image, status
            FROM players
            ORDER BY id ASC";

    $result = $conn->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);

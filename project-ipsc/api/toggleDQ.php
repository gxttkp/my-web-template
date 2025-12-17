<?php
require 'db.php';

$id = intval($_POST['id']);

$stmt = $pdo->prepare("
    UPDATE competitors
    SET is_dq = NOT is_dq,
        time = IF(is_dq = 1, time, 0)
    WHERE id = ?
");
$stmt->execute([$id]);

echo json_encode(["status" => "dq_updated"]);

<?php
require 'db.php';

$stmt = $pdo->query("
    SELECT id, code, name, photo, time, is_dq
    FROM competitors
    ORDER BY id ASC
");

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

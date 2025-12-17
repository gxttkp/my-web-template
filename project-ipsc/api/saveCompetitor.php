<?php
require 'db.php';
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'])) {
    die(json_encode(["status" => "error", "message" => "No data provided"]));
}

$id = $data['id'];

if (isset($data['name']) && isset($data['photo'])) {
    $stmt = $pdo->prepare("UPDATE competitors SET name = ?, photo = ? WHERE id = ?");
    $stmt->execute([$data['name'], $data['photo'], $id]);
} elseif (isset($data['name'])) {
    $stmt = $pdo->prepare("UPDATE competitors SET name = ? WHERE id = ?");
    $stmt->execute([$data['name'], $id]);
} elseif (isset($data['photo'])) {
    $stmt = $pdo->prepare("UPDATE competitors SET photo = ? WHERE id = ?");
    $stmt->execute([$data['photo'], $id]);
}

echo json_encode(["status" => "ok"]);
?>
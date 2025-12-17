<?php
require 'db.php';

$name = $_POST['name'] ?? 'New Competitor';

// นับจำนวนที่มีอยู่เพื่อรันเลข IPSC001, IPSC002...
$count = $pdo->query("SELECT COUNT(*) FROM competitors")->fetchColumn();
$code = 'IPSC' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

$stmt = $pdo->prepare("INSERT INTO competitors (code, name) VALUES (?, ?)");
$stmt->execute([$code, $name]);

echo json_encode(["status" => "created"]);
?>
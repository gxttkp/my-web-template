<?php
    session_start();
    require_once "../connection.php";

    if (!isset($_SESSION['admin'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    if (!isset($_POST['player_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing player ID']);
        exit;
    }

    $id = intval($_POST['player_id']);

    $result = $conn->query("DELETE FROM players WHERE id = $id");

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'ลบผู้แข่งขันเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ลบไม่สำเร็จ']);
    }
    ?>

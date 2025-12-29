<?php
    require "../connection.php";

    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? null;

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../upload/players/" . $image
        );
    }

    if ($name && $image) {
        $stmt = $conn->prepare("UPDATE players SET name=?, image=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $image, $id);

    } elseif ($name) {
        $stmt = $conn->prepare("UPDATE players SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);

    } elseif ($image) {
        $stmt = $conn->prepare("UPDATE players SET image=? WHERE id=?");
        $stmt->bind_param("si", $image, $id);
    }

    $stmt->execute();

    // ส่งกลับไปหน้าแอดมิน
    header("Location: ../admin/dashboard.php");
    exit;

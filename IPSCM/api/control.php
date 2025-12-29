<?php
require_once "../connection.php";
header("Content-Type: application/json");

$cmd = $_POST['cmd'] ?? '';

if (!$cmd) {
    echo json_encode(["success" => false, "message" => "No command"]);
    exit;
}

switch ($cmd) {

    /* ===============================
       START : เริ่มผู้แข่งขันคนแรก
       (เข้า countdown)
    =============================== */
    case "START":

        $player = $conn->query("
            SELECT id FROM players
            WHERE status='waiting'
            ORDER BY id ASC
            LIMIT 1
        ")->fetch_assoc();

        if (!$player) {
            echo json_encode(["success" => false, "message" => "No waiting player"]);
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE players
            SET status='countdown', start_time=NULL
            WHERE id=?
        ");
        $stmt->bind_param("i", $player['id']);
        $stmt->execute();

        echo json_encode([
            "success" => true,
            "message" => "Countdown started",
            "player_id" => $player['id']
        ]);
        break;


    /* ===============================
       FORCE_START : ข้าม countdown
    =============================== */
    case "FORCE_START":

        $player_id = intval($_POST['player_id'] ?? 0);

        if (!$player_id) {
            echo json_encode(["success" => false, "message" => "No player id"]);
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE players
            SET status='running', start_time=NOW()
            WHERE id=?
        ");
        $stmt->bind_param("i", $player_id);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "Match running"]);
        break;


    /* ===============================
       RESET : รีเซ็ตคนที่กำลังแข่ง
    =============================== */
    case "RESET":

        $player = $conn->query("
            SELECT id FROM players
            WHERE status IN ('running','countdown')
            LIMIT 1
        ")->fetch_assoc();

        if ($player) {
            $pid = $player['id'];

            $conn->query("DELETE FROM target_log WHERE player_id=$pid");
            $conn->query("
                UPDATE players
                SET status='waiting', time=NULL, start_time=NULL
                WHERE id=$pid
            ");
        }

        echo json_encode(["success" => true, "message" => "Reset complete"]);
        break;


    /* ===============================
       NEXT : จบคนปัจจุบัน → คนถัดไป
    =============================== */
    case "NEXT":

        // ปิดคนปัจจุบัน
        $conn->query("
            UPDATE players
            SET status='finished'
            WHERE status IN ('running','countdown')
        ");

        // เปิดคนถัดไป
        $next = $conn->query("
            SELECT id FROM players
            WHERE status='waiting'
            ORDER BY id ASC
            LIMIT 1
        ")->fetch_assoc();

        if ($next) {
            $stmt = $conn->prepare("
                UPDATE players
                SET status='countdown', start_time=NULL
                WHERE id=?
            ");
            $stmt->bind_param("i", $next['id']);
            $stmt->execute();
        }

        echo json_encode(["success" => true, "message" => "Next player"]);
        break;


    /* ===============================
            INVALID
    =============================== */
    default:
        echo json_encode(["success" => false, "message" => "Invalid command"]);
}

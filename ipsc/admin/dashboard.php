<?php
session_start();
require_once "../connection.php";

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$event   = $conn->query("SELECT * FROM event LIMIT 1")->fetch_assoc();
$players = $conn->query("SELECT * FROM players ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - IPSC</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- ================== INLINE CSS (เฉพาะ Dashboard) ================== -->
<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:'Kanit',sans-serif;
}

body{
    background:#f3f3f3;
    color:#37353E;
}

/* ===== CONTAINER ===== */
.container{
    max-width:1200px;
    margin:40px auto;
    padding:30px;
    background: white;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}

.title{
    text-align:center;
    font-size:30px;
    font-weight:600;
}

/* ===== LAYOUT ===== */
.admin-content{
    display:flex;
    flex-direction:column;
    gap:15px;
    margin-top:25px;
}

.section{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 6px 15px rgba(0,0,0,.08);
}

.section-title{
    text-align:center;
    margin-bottom:15px;
    font-size:20px;
}

/* ===== EVENT FORM ===== */
.event-form{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.date-group{
    display:flex;
    gap:10px;
}

.event-form input{
    padding:8px;
    border-radius:6px;
    border:1px solid #ccc;
}

.event-center{
    max-width:500px;
    margin:0 auto;
}

/* แถวจำนวนคน + จำนวนเป้า */
.count-row{
    display:flex;
    gap:15px;
    margin-top:10px;
}

.count-box{
    flex:1;
    display:flex;
    flex-direction:column;
}

.count-box label{
    font-weight:500;
    margin-bottom:4px;
}

/* ===== PLAYER GRID ===== */
.admin-player-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
}

.player-card-admin{
    display:flex;
    align-items:center;
    gap:16px;
    background:#faf8f1;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 10px rgba(0,0,0,.1);
}

/* ===== STATUS ===== */
.player-card-admin.running{
    background:#547792;
    color:#fff;
}
.player-card-admin.dq{
    background:#D34E4E;
    color:#fff;
}

/* ===== IMAGE ===== */
.player-image-box{
    display:flex;
    flex-direction:column;
    align-items:center;
}

.player-img{
    width:90px;
    height:90px;
    border-radius:10px;
    object-fit:cover;
}

.upload-form{
    margin-top:6px;
}
.upload-form input{
    width:90px;
    font-size:11px;
}

/* ===== INFO ===== */
.player-info{
    flex:1;
}

.name-row{
    display:flex;
    align-items:center;
    gap:6px;
}

.edit-btn{
    width:18px;
    cursor:pointer;
    opacity:.6;
}
.edit-btn:hover{opacity:1;}

.player-code{
    font-weight:600;
    margin-top:6px;
}

/* ===== ACTIONS ===== */
.side-actions{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.side-actions button{
    width:42px;
    height:42px;
    border-radius:50%;
    border:none;
    background:#faf8f1;
    cursor:pointer;
    font-size:18px;
}

/* ===== FLOAT BUTTON ===== */
.admin-btn{
    position:fixed;
    right:25px;
    bottom:25px;
    padding:12px 22px;
    border-radius:30px;
    background:#547792;
    color:#fff;
    text-decoration:none;
    box-shadow:0 5px 15px rgba(0,0,0,.25);
}
/* ซ่อน input จริง */
.upload-form input[type="file"] {
    display: none;
}

/* สไตล์ปุ่ม */
.upload-btn {
    display: inline-block;
    cursor: pointer;
    background-color: #547792;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
}
.upload-btn:hover {
    background-color: #415f7a;
}


/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .admin-player-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:600px){
    .count-row{
        flex-direction:column;
    }
}
</style>

<script src="../assets/js/admin.js" defer></script>
</head>

<body>

<div class="container">
    <h1 class="title">การแข่งขันกีฬา IPSC (หน้าแอดมิน)</h1>

    <div class="admin-content">

        <!-- ===== EVENT ===== -->
        <div class="section">
            <h2 class="section-title">แก้ไขข้อมูลการแข่งขัน</h2>

            <form class="event-form event-center">
                <div class="count-row">
                    <div class="count-box">
                        <label>จำนวนผู้เข้าแข่งขัน</label>
                        <input type="number" name="player_count"
                            value="<?= $event['player_count'] ?? '' ?>">
                    </div>

                    <div class="count-box">
                        <label>จำนวนเป้ายิงทั้งหมด</label>
                        <input type="number" name="target_count"
                            value="<?= $event['target_count'] ?? '' ?>">
                    </div>
                </div>
            </form>
        </div>

        <!-- ===== PLAYERS ===== -->
        <div class="section">
            <h2 class="section-title">ผู้เข้าแข่งขัน</h2>

            <?php
            $totalPlayers = $conn->query("SELECT COUNT(*) as total FROM players")
                                ->fetch_assoc()['total'];
            ?>
            <p style="text-align:center;margin-bottom:15px;">
                จำนวนผู้เข้าแข่งขันทั้งหมด <?= $totalPlayers ?> คน
            </p>

            <div class="admin-player-grid">

            <?php while ($p = $players->fetch_assoc()): 
                $status = $p['status'] ?? '';
                $sec = (int)($p['time'] ?? 0);
                $min = floor($sec / 60);
                $remain = $sec % 60;

                $image = (
                    !empty($p['image']) &&
                    file_exists("../upload/players/".$p['image'])
                ) ? $p['image'] : "user.png";
            ?>

                <div class="player-card-admin <?= $status ?>"
                    data-id="<?= $p['id'] ?>">

                    <!-- รูป -->
                    <div class="player-image-box">
                        <img class="player-img"
                            src="../upload/players/<?= $image ?>">

                        <form class="upload-form"
                            action="../api/save_player.php"
                            method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <label class="upload-btn">
                                อัปโหลดรูป
                                <input type="file" name="image"
                                    onchange="this.form.submit()">
                            </label>
                        </form>
                    </div>

                    <!-- ข้อมูล -->
                    <div class="player-info">
                        <div class="name-row">
                            <img src="../assets/img/edit.png"
                                class="edit-btn"
                                onclick="enableEdit(this)">
                            <h3 data-id="<?= $p['id'] ?>">
                                <?= htmlspecialchars(
                                    $p['name'] ?: 'ผู้แข่งขันคนที่ '.$p['id']
                                ) ?>
                            </h3>
                        </div>

                        <p class="player-code">IPSC<?= $p['code'] ?></p>
                        <p class="player-time">
                            เวลา: <?= $min ?>:<?= str_pad($remain,2,'0',STR_PAD_LEFT) ?> นาที
                        </p>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="side-actions">
                        <button type="button" class="start">▶</button>
                        <button type="button" class="dq">🟥</button>
                        <button type="button" class="delete">🗑️</button>
                    </div>

                </div>
            <?php endwhile; ?>

            </div>
        </div>

    </div>
</div>

<!-- ปุ่มลอย -->
<a href="../index.php" class="admin-btn">INDEX</a>

</body>

</html>

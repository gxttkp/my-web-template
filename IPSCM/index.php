<?php
require_once "connection.php";

/* ดึงข้อมูลวันที่แข่งขัน */
$event = $conn->query("SELECT * FROM event LIMIT 1")->fetch_assoc();

/* ✅ นับจำนวนผู้เข้าแข่งขัน */
$totalPlayers = $conn->query("SELECT COUNT(*) AS total FROM players")
                    ->fetch_assoc()['total'];

$nday   = $event['nday'] ?? date("j");
$month  = $event['month_th'] ?? "เดือน";
$year   = $event['year'] ?? date("Y") + 543;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>การแข่งขันกีฬา IPSC</title>

    <!-- ===== GOOGLE FONT ===== -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- ===== INLINE CSS (เฉพาะที่ใช้ใน index.php) ===== -->
    <style>
    /* ===============================
    GLOBAL
    =============================== */
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

    /* ===============================
    CONTAINER
    =============================== */
    .container{
        max-width:90%;
        margin:40px auto;
        padding:30px;
        background:#fff;
        border-radius:20px;
        box-shadow:0 10px 25px rgba(0,0,0,.1);
    }

    /* md ลงไป ให้เต็มจอ */
    @media (max-width:768px){
        .container{
            max-width:100%;
            margin:20px auto;
            padding:20px;
        }
    }

    /* ===============================
    TITLE
    =============================== */
    .title{
        text-align:center;
        font-size:32px;
        font-weight:600;
    }

    .subtitle{
        text-align:center;
        margin-top:8px;
        font-size:16px;
    }

    /* ===============================
    TAB MENU
    =============================== */
    .tab-menu{
        display:flex;
        justify-content:center;
        gap:10px;
        margin-top:20px;
    }

    .tab-menu button{
        padding:10px 20px;
        border-radius:20px;
        border:none;
        background:#faf8f1;
        cursor:pointer;
        font-size:16px;
        box-shadow:0 4px 10px rgba(0,0,0,.1);
    }

    .tab-menu button.active{
        background:#547792;
        color:#fff;
    }

    /* ===============================
    CONTENT LAYOUT
    =============================== */
    .content{
        display:flex;
        gap:20px;
        margin-top:25px;
        align-items:flex-start;
    }

    @media (max-width:1200px){
        .content{
            flex-direction:column;
        }
    }

    .section{
        flex:1;
        background:#fff;
        border-radius:10px;
        padding:20px;
        align-self: center;
        justify-self: center;
    }

    .section-title{
        text-align:center;
        margin-bottom:15px;
        font-size:20px;
        font-weight:500;
    }

    /* =====================================================
    PLAYER LIST (รายชื่อผู้แข่งขัน)
    ===================================================== */

    /* DEFAULT : xs / sm / md → 1 คอลัมน์ */
    .player-grid{
        display:grid;
        grid-template-columns:1fr;
        gap:18px;
        justify-items:center;
        align-self: center;
    }

    /* CARD */
    .player-card{
        display:flex;
        align-items:center;

        width:100%;
        margin:0 auto;

        background:#fff;
        border-radius:14px;
        padding:18px;
        box-shadow:0 6px 14px rgba(0,0,0,.1);
    }

    /* IMAGE */
    .player-card img{
        width:90px;
        height:90px;
        object-fit:cover;
        border-radius:12px;
        margin-right:16px;
    }

    /* TEXT */
    .player-card h3{
        font-size:18px;
        font-weight:600;
    }

    .player-card p{
        font-size:15px;
        opacity:.85;
    }

    /* lg ≥992px → 2 คอลัมน์ */
    @media (min-width:992px){
        .player-grid{
            grid-template-columns:repeat(2,1fr);
            max-width:1000px;
            margin:0 auto;
        }
    }

    /* xl ≥1200px → 2 คอลัมน์ */
    @media (min-width:1200px){
        .player-grid{
            width:1100px;
        }
    }
    /* xxl ≥1400px → 3 คอลัมน์ */
    @media (min-width:1400px){
        .player-grid{
            grid-template-columns:repeat(3,1fr);
            width:1300px;
        }
    }
    /* =====================================================
    RANKING (ตารางการแข่งขัน)
    ===================================================== */
    #rankingSection{
        width:70%;
        margin:0 auto;
    }

    @media (max-width:1200px){
        #rankingSection{
            width:100%;
        }
    }

    .ranking-list{
        display:flex;
        flex-direction:column;
        gap:14px;
    }

    .ranking-card{
        display:flex;
        align-items:center;
        width:60%;
        align-self:center;
        background:#fff;
        border-radius:12px;
        padding:20px;
        min-height:110px;
        box-shadow:0 4px 10px rgba(0,0,0,.08);
    }

    @media (max-width:1200px){
        .ranking-card{
            width:100%;
            padding:16px;
            min-height:95px;
        }
    }

    .ranking-card.running{
        background:#90AB8B;
        color:#fff;
    }

    .ranking-card.dq{
        background:#FACE68;
    }

    .rank{
        width:40px;
        font-size:20px;
        font-weight:600;
    }

    .ranking-card img{
        width:110px;
        height:110px;
        object-fit:cover;
        border-radius:14px;
        margin:0 18px;
    }

    @media (max-width:1200px){
        .ranking-card img{
            width:80px;
            height:80px;
        }
    }

    .ranking-card h3{
        font-size:22px;
        font-weight:600;
    }

    .ranking-card p{
        font-size:16px;
    }

    .ranking-card.dq strong{
        color:#000;
        font-size:18px;
    }

    /* =====================================================
    MOBILE ≤ 576px (SYNC CARD SIZE)
    ===================================================== */
    @media (max-width:576px){
        .player-card{
            max-width:420px;
            min-height:78px;
            padding:12px;
        }

        .player-card img{
            width:58px;
            height:58px;
            margin-right:10px;
            border-radius:8px;
        }

        .player-card h3{
            font-size:15px;
            line-height:1.2;
        }

        .player-card p{
            font-size:13px;
            line-height:1.2;
        }
    }
    /* ===============================
    ADMIN BUTTON
    =============================== */
    .admin-btn{
        position:fixed;
        right:25px;
        bottom:25px;
        padding:12px 22px;
        border-radius:30px;
        background:#547792;
        color:#fff;
        text-decoration:none;
        font-weight:500;
        box-shadow:0 5px 15px rgba(0,0,0,.25);
    }
        
    </style>

    <script src="assets/js/clock.js" defer></script>
</head>
<body>

<div class="container">

    <h1 class="title">การแข่งขันกีฬา IPSC</h1>
    <p class="subtitle">
        วันที่ <span id="date"></span> |
        เวลาเรียลไทม์ ณ ปัจจุบัน <span id="clock"></span>
    </p>

    <div class="tab-menu">
        <button id="btnPlayers" class="active">รายชื่อผู้แข่งขัน</button>
        <button id="btnRanking">ตารางการแข่งขัน</button>
    </div>

    <div class="content">

        <!-- รายชื่อผู้แข่งขัน -->
        <div class="section" id="playersSection">
            <h2 class="section-title">รายชื่อผู้แข่งขัน</h2>

            <p style="
                text-align:center;
                margin-top:18px;
                font-size:16px;
                font-weight:500;
                color:#555;
            ">
                จำนวนผู้เข้าแข่งขันทั้งหมด <?= $totalPlayers ?> คน
            </p>

            <div class="player-grid" id="playerList"></div>
        </div>

        <!-- ตารางแข่งขัน -->
        <div class="section" id="rankingSection" style="display:none;">
            <h2 class="section-title">ตารางการแข่งขัน</h2>
            <div class="ranking-list" id="rankingList"></div>
        </div>

    </div>

</div>

<a href="admin/index.php" class="admin-btn">ADMIN</a>
<script src="assets/js/realtime.js" defer></script>

</body>
</html>

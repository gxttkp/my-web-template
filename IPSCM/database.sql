-- ===============================
-- DATABASE : ipsc
-- ===============================
CREATE DATABASE IF NOT EXISTS ipsc
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE ipsc;

-- ===============================
-- TABLE : admin
-- ===============================
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL
);

INSERT INTO admin (username, password)
VALUES ('admin', 'ipsc-cmtc2025');

-- ===============================
-- TABLE : event
-- เก็บข้อมูลการแข่งขัน (มีแค่ 1 แถว)
-- ===============================
CREATE TABLE event (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nday INT NOT NULL,
    month_th VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    player_count INT NOT NULL,
    target_count INT NOT NULL
);

INSERT INTO event (nday, month_th, year, player_count, target_count)
VALUES (1, 'มกราคม', 2568, 0, 0);

-- ===============================
-- TABLE : players
-- ===============================
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(100) DEFAULT 'user.png',
    time DOUBLE DEFAULT NULL,
    status ENUM('waiting','running','finished','dq') DEFAULT 'waiting',
    start_time DATETIME NULL
);

-- ===============================
-- TABLE : target_log
-- เก็บ log การล้มเป้า
-- ===============================
CREATE TABLE target_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT NOT NULL,
    target_id VARCHAR(20),
    hit_time DATETIME,
    INDEX (player_id)
);

-- ===============================
-- INDEX (เพิ่มความเร็ว)
-- ===============================
CREATE INDEX idx_players_status ON players(status);
CREATE INDEX idx_players_time ON players(time);
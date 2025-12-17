<?php
    // เริ่ม session กลาง
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    // รหัสผ่าน Admin
    define('ADMIN_PASSWORD', 'ipsc-cmtc@2025');


    // โหมดพัฒนา (true = แสดง error)
    define('DEV_MODE', true);


    if (DEV_MODE) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        error_reporting(0);
    }
?>
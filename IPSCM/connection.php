<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "ipsc";

    $conn = new mysqli($server,$username,$password,$database);
    $conn->set_charset("utf8");

    if($conn->connect_error){
        die("DB Error");
    }
?>

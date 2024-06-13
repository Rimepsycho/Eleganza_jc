<?php

    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "db_violin";

    try{
        $db_host = new PDO(
            "mysql:host={$servername};dbname={$dbname};charset=utf8", $username, $password
        );
        // echo "連線成功";
    } catch(PDOException $e) {
        echo "資料庫連線失敗<br>";
        echo "Error: ".$e->getMessage();
        exit;
    }
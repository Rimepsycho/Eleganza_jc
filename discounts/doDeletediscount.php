<?php
    require_once("../pdo-conncetion.php");

    $id = $_GET["id"];

    $sql = "UPDATE discount SET valid = '0' WHERE discount_id = $id";
    $stmt = $db_host->prepare($sql);

    try {
        $stmt->execute();
        header("location: ./discounts.php");
    } catch (PDOException $e) {
        echo "預處理陳述式失敗<br>";
        echo "Error: " . $e->getMessage();
        $db_host = null;
        exit;
    }
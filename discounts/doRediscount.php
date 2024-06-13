<?php
    require_once("../pdo-conncetion.php");

    if(!isset($_POST["id"])) {
        die("請循正常管道進入此頁");
    }

    $id = $_POST["id"];
    $main = $_POST["main"];
    $type = $_POST["type"];
    $amount = $_POST["amount"];
    $num = $_POST["num"];
    $low_consumption = $_POST["low_consumption"];
    $restriction = $_POST["restriction"];
    $start_date = $_POST["start_date"];
    $start_time = $_POST["start_time"];
    $end_date = $_POST["end_date"];
    $end_time = $_POST["end_time"];
    if(!isset($_POST["valid"])) {
        $valid = 1;
    } else {
        $valid = $_POST["valid"];
    }

    $start = $start_date. " ". $start_time.":00";
    $end = $end_date. " ". $end_time.":00";
    /* $now = date("Y:m:d H:i:s");
    if($now < $end) {
        $valid = 0;
    }
    echo $now."<br>";
    echo $valid;
    exit; */
    $sql = "UPDATE `discount` SET `main`='$main',`type`='$type',`amount`='$amount',`num`='$num',`low_consumption`='$low_consumption',`restriction`='$restriction',`start_date`='$start',`end_date`='$end',`valid`='$valid' WHERE discount_id = $id";
    $stmt = $db_host->prepare($sql);
    
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "預處理陳述式失敗<br>";
        echo "Error: " . $e->getMessage();
        $db_host = null;
        exit;
    }

    header("location: ./discounts.php");
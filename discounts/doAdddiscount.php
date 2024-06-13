<?php 
    require_once("../pdo-conncetion.php");

    if(!isset($_POST["main"])) {
        die("請循正常管道進入此頁");
    }

    $main = $_POST["main"];
    $serial_number = $_POST["serial_number"];
    $type = $_POST["type"];
    $amount = $_POST["amount"];
    $num = $_POST["num"];
    $low_consumption = $_POST["low_consumption"];
    $restriction = $_POST["restriction"];
    $start_date = $_POST["start_date"];
    $start_time = $_POST["start_time"];
    $end_date = $_POST["end_date"];
    $end_time = $_POST["end_time"];

    if(empty($main) || empty($serial_number) || $type =="0" || empty($amount) || empty($num) || empty($low_consumption) || empty($start_date) || empty($start_time) || empty($end_date) || empty($end_time)) {
        $data = [
            "status" => 0,
            "message" => "請輸入必填欄位"
        ];
        echo json_encode($data);
        exit;
    }


    $start = $start_date. " ". $start_time.":00";
    $end = $end_date. " ". $end_time.":00";

    // exit;
    $sql = "INSERT INTO discount(main, serial_number, type, amount, num, low_consumption, restriction, start_date, end_date, valid) VALUES ('$main', '$serial_number', '$type', '$amount', '$num', '$low_consumption', '$restriction', '$start', '$end', 1)";
    $stmt = $db_host->prepare($sql);

    try {
        $stmt->execute();
        $data = [
            "status" => 1,
            "message" => "新增成功"
        ];
        echo json_encode($data);
        exit;
    } catch (PDOException $e) {
        echo "預處理陳述式失敗<br>";
        echo "Error: " . $e->getMessage();
        $db_host = null;
        exit;
    }

    // header("location: ./discounts.php");
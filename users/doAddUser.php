<?php

session_start();
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入";
    exit;
}

$name = $_POST["name"];
$account = $_POST["account"];
$password = $_POST["password"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$birth = $_POST["birth"];

if (empty($name)) {
    $_SESSION["error"]["message"] = "請輸入姓名";
    header("location: add-user.php");
    exit;
}
if (empty($account)) {
    $_SESSION["error"]["message"] = "請輸入帳號";
    header("location: add-user.php");
    exit;
}
if (empty($password)) {
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("location: add-user.php");
    exit;
}
if (empty($email)) {
    $_SESSION["error"]["message"] = "請輸入電子郵件";
    header("location: add-user.php");
    exit;
}
if (empty($phone)) {
    $_SESSION["error"]["message"] = "請輸入電話";
    header("location: add-user.php");
    exit;
}
if (empty($birth)) {
    $_SESSION["error"]["message"] = "請輸入生日";
    header("location: add-user.php");
    exit;
}



$sql = "INSERT INTO users(name, account, password, email, phone, birth,valid)	VALUES ('$name','$account','$password','$email','$phone', '$birth',1)";

// echo $sql;
// exit;

if ($conn->query($sql)) {
    echo "新增資料完成";
    //$last_id = $conn->insert_id; //抓流水號ID
    //echo ", id 為 $last_id";
} else {
    echo "新增資料錯誤:" . $conn->error;
}

$conn->close();

header("location: ./user-list.php"); 
//輸入完返回原本的頁面


//小黃壓除錯法

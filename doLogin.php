<?php
session_start();
require_once("pdo-conncetion.php");

if (!isset($_POST["account"])) {
    die("請循正常管道進入此頁");
}

$account = $_POST["account"];
$password = $_POST["password"];

$account = $_POST["account"];
$password = $_POST["password"];

if (empty($account)) {
    $_SESSION["error"]["message"] = "請輸入帳號";
    header("location: login.php");
    exit;
}
if (empty($password)) {
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("location: login.php");
    exit;
}

$sql = "SELECT * FROM users WHERE account = '$account' AND password = '$password' AND valid = 2";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userExist = $stmt->rowCount();
    if ($userExist == 0) {
        $_SESSION["error"]["message"] = "帳號或密碼錯誤";
        if (isset($_SESSION["error"]["times"])) {
            $_SESSION["error"]["times"]++;
            $times = $_SESSION["error"]["times"];
        } else {
            $times = 1;
            $_SESSION["error"]["times"] = $times;
        }
        header("location: login.php");
    } else {
        $id = $row["id"];
        $_SESSION["user"] = [
            "account" => $row["account"],
            "name" => $row["name"],
            "email" => $row["email"],
            "phone" => $row["phone"]
        ];
        unset($_SESSION["error"]);
        header("location: index.php"); //需修改登入頁面檔案名稱
    }
} catch (PDOException $e) {
    echo "預處理陳述式失敗<br>";
    echo "Error: " . $e->getMessage();
    $db_host = null;
    exit;
}

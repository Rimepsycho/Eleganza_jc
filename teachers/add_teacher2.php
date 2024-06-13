<?php
require_once("../db_connect.php");

// 獲取 POST 資料
$name = $_POST["teacher_name"];
$gender= $_POST["teacher_gender"];
$phone = $_POST["teacher_phone"];
$email = $_POST["teacher_email"];
$introduction = $_POST["teacher_introduction"];

// 處理上傳的圖片
$img = "";

if (isset($_FILES["teacher_img_upload"]) && $_FILES["teacher_img_upload"]["error"] === 0) {
    $uploadDir = "../images/teacher_images/"; // 修改路徑
    $uploadFile = $uploadDir . basename($_FILES["teacher_img_upload"]["name"]);

    if (move_uploaded_file($_FILES["teacher_img_upload"]["tmp_name"], $uploadFile)) {
        $img = basename($_FILES["teacher_img_upload"]["name"]);
    } else {
        echo "可能是文件太大，請確認 PHP 的設定。\n";
    }
}

// 建立 SQL 語句
$sql = "INSERT INTO `teacher`(`name`,`gender`,`phone`, `email`, `introduction`, `img`, `valid`) VALUES ('$name', '$gender', '$phone', '$email', '$introduction', '$img', 1)";

// 執行 SQL 語句
if ($conn->query($sql)) {
    echo "成功新增老師";
} else {
    echo "新增老師失敗：" . $conn->error;
}

$conn->close();
header("Location: ./layout-static.php");
?>

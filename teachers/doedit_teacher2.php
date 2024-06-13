<?php
require_once("../db_connect.php");

// 獲取 POST 資料
$id = $_POST["teacher_id"];
$name = $_POST["teacher_name"];
$phone = $_POST["teacher_phone"];
$email = $_POST["teacher_email"];
$introduction = $_POST["teacher_introduction"];

// 處理上傳的圖片
$img = $row["img"]; // 預設圖片名稱

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
$sql = "UPDATE `teacher` SET `name`='$name', `phone`='$phone', `email`='$email', `introduction`='$introduction'";

// 如果有上傳新的圖片，加入更新圖片的語句
if (isset($_FILES["teacher_img_upload"]) && $_FILES["teacher_img_upload"]["error"] === 0) {
    $sql .= ", `img`='$img'";
}

$sql .= " WHERE teacher_id=$id";

// 執行 SQL 語句
if ($conn->query($sql)) {
    echo "成功更新老師";
} else {
    echo "更新老師失敗：" . $conn->error;
}

$conn->close();
header("Location: ./layout-static.php");
?>

<?php
// del_teacher.php

require_once("../db_connect.php");

$id = $_GET["id"];

$sql = "UPDATE teacher SET valid='1' WHERE teacher_id=$id";

if ($conn->query($sql)) {
    echo "取消隱藏成功";
} else {
    echo "取消隱藏錯誤: " . $conn->error;
}

$conn->close();

// 選擇重新導向到你的教師列表頁面
header("location: ./layout-static.php");
?>
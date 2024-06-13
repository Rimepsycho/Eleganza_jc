<?php
require_once("../db_connect.php");

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    echo "接收到的 ID: $id"; // 用于调试

    // 准备 SQL 语句
    $sql = "UPDATE users SET valid = '0' WHERE user_id = $id";


    // 打印出 SQL 语句，用于调试
    echo "執行的 SQL 語句: " . $sql . "<br>";

    // 执行 SQL 语句
    if ($conn->query($sql) === TRUE) {
        echo "刪除成功";
    } else {
        echo "刪除資料錯誤: " . $conn->error;
    }
} 
else {
    echo "未接收到有效的 ID";
    // 暂时注释掉重定向，以便看到调试信息
    // header("location: user-list.php");
    exit; // 防止继续执行下面的代码
}

$conn->close();

// 在确认一切正常后，可以取消注释下面这行
header("location: ./user-list.php");
?>

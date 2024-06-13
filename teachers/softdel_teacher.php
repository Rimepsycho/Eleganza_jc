<?php
require_once("../db_connect.php");


$sql="UPDATE teacher SET valid='0' WHERE teacher_id= 1";

if ($conn->query($sql) === TRUE) {
    // echo "刪除成功";
    } else {
        echo "刪除資料錯誤:. " . $conn->error;
    }

    $conn->close();

    header("location: ./layout-static.php");

?>
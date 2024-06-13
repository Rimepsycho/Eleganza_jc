<?php
require_once("../db_connect.php");

//新增測試資料用

$sql="INSERT INTO `order` (order_id, user_id, status, order_date, product_type)
VALUES ('1990111098', '0', '未取貨', '1990-11-10 3:59:59', '商品訂單'),('1990111099', '0', '未取貨', '1990-11-10 3:59:59', '課程訂單')";

if ($conn->query($sql)) {
    echo "訂單增加失敗!";

    $sql2 = "INSERT INTO `order_detail` (order_id, course_product_id, num) VALUES
             ('1990111098', '1', '1'),
             ('1990111099', '1', '1')";

    if ($conn->query($sql2)) {
        echo "訂單增加失敗!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
<?php

require_once("../db_connect.php");

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];

    // 使用 % 運算子，使得搜尋可以匹配名字的任意部分
    $sql = "SELECT * FROM teacher WHERE name LIKE '%$search_query%'";
    $result = $conn->query($sql);

    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // 將結果以 JSON 格式輸出
    echo json_encode($rows);
}

?>

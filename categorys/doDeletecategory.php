<?php
require_once("../pdo-conncetion.php");

$id = $_GET["id"];
$cate = $_GET["cate"];

if ($cate == "product") {
    $sql = "UPDATE product_category SET valid = '0' WHERE product_category_id = $id";
    $stmt = $db_host->prepare($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif($cate == "course") {
    $sql = "UPDATE course_category SET valid = '0' WHERE course_category_id = $id";
    $stmt = $db_host->prepare($sql);
}

try {
    $stmt->execute();
    header("location: ./category-list.php");
} catch (PDOException $e) {
    echo "預處理陳述式失敗<br>";
    echo "Error: " . $e->getMessage();
    $db_host = null;
    exit;
}

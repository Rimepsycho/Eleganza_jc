<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];
    $start_date = $_POST["start_date"];

    $insertSql = "INSERT INTO course (name, price, category_id, start_date) VALUES ('$name', '$price', '$category_id', '$start_date')";
    if ($conn->query($insertSql) === TRUE) {
        echo "課程新增成功";
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

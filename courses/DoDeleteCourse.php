<?php
require_once("../db_connect.php");

$id=$_GET["id"];
var_dump($id);
// $name = $_POST["name"];
// $course_category = number_format($_POST["course_category_level"]);
// $teacher = number_format($_POST["course_teacher_name"]);
// $style = $_POST["style"];
// $comment = $_POST["comment"];


// $des = $_POST["des"];
// // var_dump($_POST["course_category_level"]);
// $quota = number_format($_POST["quota"]);
// $price = ($_POST["price"]);
// $start_date = $_POST["start_date"];
// $end_date = $_POST["end_date"];
// $time = $_POST["time"];

$sql = "UPDATE course SET valid='0' WHERE course_id=$id";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();

header("location: ./course_list.php");


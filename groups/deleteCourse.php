<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseId = $_POST["courseId"];

    $deleteSql = "DELETE FROM course WHERE course_id = $courseId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "課程刪除成功";
    } else {
        echo "Error: " . $deleteSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

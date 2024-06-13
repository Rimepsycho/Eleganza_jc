<?php
require_once("../db_connect.php");

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$id=$_POST["course_id"];
// var_dump($id);
$name = $_POST["name"];
$course_category = $_POST["course_category_level"];
$teacher = $_POST["course_teacher_name"];
$style = $_POST["style"];
$comment = $_POST["comment"];
$valid = $_POST["valid"];

$des = $_POST["des"];
$quota = $_POST["quota"];
$price = ($_POST["price"]);
$start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : null;
$end_date = isset($_POST["end_date"]) ? $_POST["end_date"] : null;
$start_time = isset($_POST["start_time"]) ? $_POST["start_time"] : null;
$end_time = isset($_POST["end_time"]) ? $_POST["end_time"] : null;
// var_dump($start_date);
// var_dump($end_date);
// var_dump($end_time);
// var_dump($start_time);

// 預設圖片檔案名稱為原始圖片名稱，如果有新的圖片檔案被上傳，則使用新檔名
$filename = $_POST["original_img"];

if ($_FILES["course_images"]["error"] == 0) {
    $filename = time(); // 根據時間戳記
    $fileExt = pathinfo($_FILES["course_images"]["name"], PATHINFO_EXTENSION); // 還有副檔名
    $filename = $filename . "." . $fileExt; // 合成新的檔名

    if (move_uploaded_file($_FILES["course_images"]["tmp_name"], "../images/course_images/" . $filename)) {
        // 如果有新的圖片檔案被上傳，更新圖片
    }
}

// 執行更新，不論是否有新的圖片
// $sql = "UPDATE course SET name='$name', course_category_id='$course_category', teacher_id='$teacher', quota='$quota', price='$price', style_id='$style', description='$des', comment='$comment', start_date='$start_date', end_date='$end_date', start_time='$start_time', end_time='$end_time', valid=1, img='$filename' WHERE course_id=$id";

// 建立更新的 SQL
$sql = "UPDATE course SET name='$name', course_category_id='$course_category', teacher_id='$teacher', quota='$quota', price='$price', style_id='$style', description='$des', comment='$comment', start_date='$start_date', end_date='$end_date', start_time='$start_time', end_time='$end_time', valid='$valid'";

// 如果有新的圖片，加上更新圖片的部分
if ($_FILES["course_images"]["error"] == 0) {
    $sql .= ", img='$filename'";
}

// 加上 WHERE 條件
$sql .= " WHERE course_id=$id";


if ($conn->query($sql)) {
    echo "更新資料完成";
    $conn->close();
    header("location: ./course_list.php");
} else {
    echo "更新資料錯誤:" . $conn->error;
}
?>
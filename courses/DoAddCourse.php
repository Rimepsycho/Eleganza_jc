<?php
require_once("../db_connect.php");

$name = $_POST["name"];
$course_category = number_format($_POST["course_category_level"]);
$teacher = ($_POST["course_teacher_name"]);
$style = $_POST["style"];
$comment = $_POST["comment"];


$des = $_POST["des"];
$quota = ($_POST["quota"]);
$price = ($_POST["price"]);
$start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : null;
$end_date = isset($_POST["end_date"]) ? $_POST["end_date"] : null;
$start_time = isset($_POST["start_time"]) ? $_POST["start_time"] : null;
$end_time = isset($_POST["end_time"]) ? $_POST["end_time"] : null;

if(empty($name) || empty($teacher) || empty($quota)|| empty($price) || empty($course_category) || empty($style)){
      echo "請輸入必要欄位";
      exit;
  }

if ($_FILES["course_images"]["error"] == 0) {
    $filename = time(); //根據時間戳記
    $fileExt = pathinfo($_FILES["course_images"]["name"], PATHINFO_EXTENSION); //還有副檔名
    $filename = $filename . "." . $fileExt; //合成新的檔名
 
    if (move_uploaded_file($_FILES["course_images"]["tmp_name"], "../images/course_images/" . $filename)) { //改成重新命名的名字
        // 可以先var_dump來看一下資料夾路徑對不對
        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO course (name, course_category_id, teacher_id, quota, price, style_id, description, comment, start_date, end_date, start_time, end_time, valid, img)
                 VALUES ('$name', $course_category, $teacher, $quota, $price, '$style', '$des', '$comment', '$start_date', '$end_date', '$start_time', '$end_time', 1, '$filename')";

        
         if ($conn->query($sql)) {
             echo "新增資料完成";
         } else {
             echo "新增資料錯誤:" . $conn->error;
         }
      }
}
$conn->close();
header("location: ./course-upload.php");

// 日期時間的放置 要合併還是分開再想清楚、處理
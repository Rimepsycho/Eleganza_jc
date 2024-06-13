<?php
require_once("../db_connect.php");

$id = $_POST["addId"];
$name = trim($_POST["nameAdd"]);
$price = trim($_POST["priceAdd"]);
$num = trim($_POST["numAdd"]);
$intro = trim($_POST["introAdd"]);
$brand = trim($_POST["brandAdd"]);
$size = trim($_POST["sizeAdd"]);
$top = trim($_POST["topAdd"]);
$bas = trim($_POST["basAdd"]);
$neck = trim($_POST["neckAdd"]);
$finger = trim($_POST["fingerAdd"]);
$bow = trim($_POST["bowAdd"]);

$sqlAdd = "INSERT INTO product (product_category_id, name, price, num, introduction, brand, size, top, back_and_sides, neck, fingerboard, bow, valid, status)
VALUES ('$id','$name', '$price', '$num', '$intro', '$brand', '$size', '$top','$bas', '$neck', '$finger', '$bow', 1, 2)";

if ($conn->query($sqlAdd) === true) {
   $lastProductId = $conn->insert_id;  // 获取刚插入产品的 ID

   // 处理图片上传
   $targetDir = "../images/product_images/";
   $allowTypes = array('jpg', 'jpeg', 'png', 'gif');

   foreach ($_FILES['images']['name'] as $key => $val) {
      $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
      $targetFilePath = $targetDir . $fileName;
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

      if (in_array($fileType, $allowTypes)) {
         if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFilePath)) {
            // 将每张图片的信息插入 imgs 表
            $sqlInsertImage = "INSERT INTO imgs (product_id, pic) VALUES ($lastProductId, '$fileName')";
            // 执行图片信息插入查询
            if (!$conn->query($sqlInsertImage)) {
               echo "Error inserting image information: " . $conn->error;
            }
            
            // 如果是第一张图片，更新 product 表的 img 列
            if ($key === 0) {
               $sqlUpdateProduct = "UPDATE product SET img = '$fileName' WHERE product_id = $lastProductId";
               if (!$conn->query($sqlUpdateProduct)) {
                  echo "Error updating product information: " . $conn->error;
               }
            }
         } else {
            echo "Error uploading $fileName. Please try again.";
         }
      } else {
         echo "Invalid file type. Please upload valid image files.";
      }
   }
} else {
   echo "Error inserting product information: " . $conn->error;
}

header("location: ./product-list.php");

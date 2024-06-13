<?php
require_once("../db_connect.php");


$id = $_POST["editId"];
$name = trim($_POST["nameEdit"]);
$price = trim($_POST["priceEdit"]);
$num = trim($_POST["numEdit"]);
$intro = trim($_POST["introEdit"]);
$brand = trim($_POST["brandEdit"]);
$size = trim($_POST["sizeEdit"]);
$top = trim($_POST["topEdit"]);
$bas = trim($_POST["basEdit"]);
$neck = trim($_POST["neckEdit"]);
$finger = trim($_POST["fingerEdit"]);
$bow = trim($_POST["bowEdit"]);
$status = trim($_POST["statusEdit"]);



if ("$num" != 0) {
   
   $sql = "UPDATE product SET `name`='$name', price='$price', num='$num', introduction='$intro', brand='$brand', size='$size', top='$top', back_and_sides='$bas', neck='$neck', fingerboard='$finger', bow='$bow', status='$status' WHERE product_id=$id";
   
}else{

   $sql = "UPDATE product SET `name`='$name', price='$price', num='$num', introduction='$intro', brand='$brand', size='$size', top='$top', back_and_sides='$bas', neck='$neck', fingerboard='$finger', bow='$bow', status=2 WHERE product_id=$id";
}




$targetDir = "../images/product_images/";
$allowTypes = array('jpg', 'jpeg', 'png', 'gif');

foreach ($_FILES['images']['name'] as $key => $val) {
   $fileName = time() . '_' . basename($_FILES['images']['name'][$key]);
   $targetFilePath = $targetDir . $fileName;
   $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


   if (in_array($fileType, $allowTypes)) {
      if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFilePath)) {
         $sqlInsertImage = "INSERT INTO imgs (product_id, pic) VALUES ($id, '$fileName')";
         if (!$conn->query($sqlInsertImage)) {
            echo "Error inserting image information: " . $conn->error;
         }
      } else {
         echo "Error uploading $fileName. Please try again.";
      }
   } else {
      echo "Invalid file type. Please upload valid image files.";
   }
}

if ($conn->query($sql) === TRUE) {
   echo "Record updated successfully";
} else {
   echo "Error updating record: " . $conn->error;
}


header("location: ./product-list.php");

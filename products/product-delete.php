<?php
require_once("../db_connect.php");

if (isset($_GET["product_id"])) {
   $productId = $_GET["product_id"];

   $sql = "UPDATE product SET valid='0' WHERE product_id=$productId ";

   if ($conn->query($sql) === TRUE) {
      echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
   } else {
      echo json_encode(['success' => false, 'message' => 'Failed to delete product: ' . $conn->error]);
   }
   $conn->close();
   header("location: ./product-list.php");
} else {
   if (isset($_POST['img_id'])) {
      $imgId = $_POST['img_id'];
 
      global $conn; // 在函數內部使用全局變數 $conn
      $imgSql = "DELETE FROM imgs WHERE imgs_id = '$imgId'";
      $result = $conn->query($imgSql);

      if ($result) {
         echo json_encode(['success' => true, 'message' => 'Image deleted successfully.']);
      } else {
         echo json_encode(['success' => false, 'message' => 'Failed to delete image: ' . $conn->error]);
      }
   }
}
?>

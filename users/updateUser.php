<?php

require_once("../db_connect.php");

if(!isset($_POST["name"])){
    die("請循正常管道進入");
}

$name=$_POST["name"];
$account=$_POST["account"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$birth=$_POST["birth"];
$id=$_POST["user_id"];


$sql = "UPDATE users SET name='$name',account='$account', phone='$phone', email='$email', birth='$birth' WHERE user_id=$id";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
// header("location: user-edit.php?id=$id");

} else {
    echo "更新資料錯誤: " . $conn->error;
}



echo $sql;

header("location: ./user.php?id=$id");
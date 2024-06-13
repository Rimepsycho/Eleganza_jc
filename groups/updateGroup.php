<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseId = $_POST["courseId"];
    $selectedGroups = isset($_POST["groupSelection"]) ? $_POST["groupSelection"] : [];

    require_once("../db_connect.php");
    
    $deleteSql = "DELETE FROM course_group WHERE course_id = '$courseId'";
    $conn->query($deleteSql);
    foreach ($selectedGroups as $group) {
        $insertSql = "INSERT INTO course_group (course_id, group_name) VALUES ('$courseId', '$group')";
        $conn->query($insertSql);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseId = $_POST["courseId"];
        $groupSelection = isset($_POST["groupSelection"]) ? $_POST["groupSelection"] : [];
    
        $updateSql = "UPDATE course SET group_selection = '" . implode(",", $groupSelection) . "' WHERE course_id = $courseId";
        if ($conn->query($updateSql) === TRUE) {
            echo "群組更新成功";
        } else {
            echo "Error: " . $updateSql . "<br>" . $conn->error;
        }
    }
    
    $conn->close();
}
?>

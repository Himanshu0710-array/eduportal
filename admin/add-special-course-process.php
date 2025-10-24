<?php
ob_start();
include "../database-connect.php";

$specialCourseName = trim($_POST['specialCourseName']);
$specialCourseDescription = trim($_POST['specialCourseDescription']);
$courseId = $_REQUEST["courseId"];

if (strlen($specialCourseName) <= 0) {
    header("Location:add-special-course.php?err=1");
    exit();
}

try {
    $query = "INSERT INTO tblspecialcourse (specialCourseName,courseId, specialCourseDescription) VALUES (:specialCourseName,:courseId, :specialCourseDescription)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":specialCourseName", $specialCourseName);
    $stmt->bindParam(":courseId", $courseId);
    $stmt->bindParam(":specialCourseDescription", $specialCourseDescription);
    $stmt->execute();

    header("Location:admin-dashboard.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

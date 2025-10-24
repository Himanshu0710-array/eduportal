<?php
ob_start();
include "../database-connect.php";

$courseName = trim($_POST['courseName']);
$courseDescription = trim($_POST['courseDescription']);

if (strlen($courseName) <= 0) {
    header("Location:add-course-student.php?err=1");
    exit();
}

try {
    $query = "INSERT INTO tblCourse (courseName, courseDescription) VALUES (:courseName, :courseDescription)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":courseName", $courseName);
    $stmt->bindParam(":courseDescription", $courseDescription);
    $stmt->execute();

    header("Location:admin-dashboard.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php
ob_start();
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../database-connect.php";

$studentId = $_REQUEST['studentId'];
$studentPassword = $_REQUEST['studentPassword'];

if (empty($studentId)) {
    header("location:login-student.php?err=1");
    exit;
}

if (empty($studentPassword)) {
    header("location:login-student.php?err=2");
    exit;
}

$query = "SELECT * FROM tblstudent WHERE studentId = :studentId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":studentId", $studentId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header("location:login-student.php?err=3");
    exit;
}

if ($studentPassword !== $result["studentPassword"]) {
    header("location:login-student.php?err=3");
    exit;
}

setcookie("studentId", $studentId, time() + 3600, "/"); // 1-hour cookie


header("location:student-dashboard.php");
exit;
?>

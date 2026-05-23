<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

$teacherId = $_POST['teacherId'] ?? '';
$teacherPassword = $_POST['teacherPassword'] ?? '';

if (trim($teacherId) === '') {
    header("location:login-teacher.php?err=1");
    exit;
}

if (trim($teacherPassword) === '') {
    header("location:login-teacher.php?err=2");
    exit;
}


$query = "SELECT * FROM tblteacher WHERE teacherId = :teacherId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":teacherId", $teacherId);
$stmt->execute();
$result = $stmt->fetch();
if (!$result) {
    header("location:login-teacher.php?err=4");
    exit;
}

if ($teacherPassword != $result["teacherPassword"]) {
    header("location:login-teacher.php?err=3");
    exit;
}

setcookie("teacherId", $result["teacherId"], time() + 24 * 60 * 60, "/");

$_SESSION['teacherId'] = $result['teacherId'];
$_SESSION['teacherPassword'] = $result['teacherPassword'];

header("location:teacher-dashboard.php");
exit;
?>
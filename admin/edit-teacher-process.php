<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");

$teacherId = $_POST["teacherId"] ?? '';
$teacherName = $_POST["teacherName"] ?? '';
$teacherEmail = $_POST["teacherEmail"] ?? '';
$teacherPassword = $_POST["teacherPassword"] ?? '';
$teacherPhone = $_POST["teacherPhone"] ?? '';
$teacherGender = $_POST["teacherGender"] ?? '';
$subjectId = $_POST["subjectId"] ?? '';

$sections_arr = $_POST["sections"] ?? [];
$section = implode(",", $sections_arr);

$updatedIpAddress = $_SERVER['REMOTE_ADDR'];
$updatedDateTime = date('Y-m-d H:i:s');

if (strlen($teacherName) <= 0) {
    header("Location: edit-teacher.php?teacherId=" . $teacherId . "&err=1");
    exit;
}

if (strlen($teacherEmail) <= 0) {
    header("Location: edit-teacher.php?teacherId=" . $teacherId . "&err=2");
    exit;
}

if (strlen($teacherPhone) <= 0) {
    header("Location: edit-teacher.php?teacherId=" . $teacherId . "&err=3");
    exit;
}

$stmt = $conn->prepare("UPDATE tblteacher SET teacherName=:teacherName, teacherEmail=:teacherEmail, teacherPassword=:teacherPassword, teacherPhone=:teacherPhone, teacherGender=:teacherGender, subjectId=:subjectId, section=:section, updatedIpAddress=:updatedIpAddress, updatedDateTime=:updatedDateTime WHERE teacherId=:teacherId");
$stmt->bindParam(":teacherId", $teacherId);
$stmt->bindParam(":teacherName", $teacherName);
$stmt->bindParam(":teacherEmail", $teacherEmail);
$stmt->bindParam(":teacherPassword", $teacherPassword);
$stmt->bindParam(":teacherPhone", $teacherPhone);
$stmt->bindParam(":teacherGender", $teacherGender);
$stmt->bindParam(":subjectId", $subjectId);
$stmt->bindParam(":section", $section);
$stmt->bindParam(":updatedIpAddress", $updatedIpAddress);
$stmt->bindParam(":updatedDateTime", $updatedDateTime);
$stmt->execute();

header("location:teacher-table.php");
exit;
?>

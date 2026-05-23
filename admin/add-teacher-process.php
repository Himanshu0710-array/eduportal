<?php
ob_start();
session_start();
include "../database-connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Calcutta");

$teacherName = $_POST["teacherName"] ?? "";
$teacherEmail = $_POST["teacherEmail"] ?? "";
$teacherPassword = $_POST["teacherPassword"] ?? "";
$teacherPhone = $_POST["teacherPhone"] ?? "";
$teacherGender = $_POST["teacherGender"] ?? "-1";
$subjectId = $_POST["subjectId"] ?? "-1";

$sections_arr = $_POST["sections"] ?? [];
$section = implode(",", $sections_arr);

$addedIpAddress = $_SERVER['REMOTE_ADDR'];
$addedDateTime = date('Y-m-d H:i:s');
$updatedIpAddress = $_SERVER['REMOTE_ADDR'];
$updatedDateTime = date('Y-m-d H:i:s');

if (empty($teacherName)) {
    header("location:add-teacher.php?err=1");
    exit;
}
if (empty($teacherEmail)) {
    header("location:add-teacher.php?err=2");
    exit;
}
if (empty($teacherPassword)) {
    header("location:add-teacher.php?err=3");
    exit;
}
if (empty($teacherPhone)) {
    header("location:add-teacher.php?err=4");
    exit;
}
if ($subjectId == "-1") {
    header("location:add-teacher.php?err=5");
    exit;
}

$stmt = $conn->prepare("INSERT INTO tblteacher (teacherName, teacherEmail, teacherPassword, teacherPhone, teacherGender, subjectId, section, addedIpAddress, addedDateTime, updatedIpAddress, updatedDateTime) VALUES (:teacherName, :teacherEmail, :teacherPassword, :teacherPhone, :teacherGender, :subjectId, :section, :addedIpAddress, :addedDateTime, :updatedIpAddress, :updatedDateTime)");
$stmt->bindParam(":teacherName", $teacherName);
$stmt->bindParam(":teacherEmail", $teacherEmail);
$stmt->bindParam(":teacherPassword", $teacherPassword);
$stmt->bindParam(":teacherPhone", $teacherPhone);
$stmt->bindParam(":teacherGender", $teacherGender);
$stmt->bindParam(":subjectId", $subjectId);
$stmt->bindParam(":section", $section);
$stmt->bindParam(":addedIpAddress", $addedIpAddress);
$stmt->bindParam(":addedDateTime", $addedDateTime);
$stmt->bindParam(":updatedIpAddress", $updatedIpAddress);
$stmt->bindParam(":updatedDateTime", $updatedDateTime);
$stmt->execute();

header("location:teacher-table.php");
exit();
?>

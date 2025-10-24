<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
include "../database-connect.php";
$studentId          = $_REQUEST["studentId"];
$courseId           = $_REQUEST["courseId"];
$academicYearId     = $_REQUEST["academicYearId"];
$cutOffAttendence   = $_REQUEST["cutOffAttendence"];
$sessionId          = $_REQUEST["sessionId"];
$noticeDate         = $_REQUEST["noticeDate"];
$notice             = $_REQUEST["notice"];

$i = 0;
while ($i < count($studentId)) {
    $currentStudentId   = $studentId[$i];

$stmt=$conn->prepare("INSERT into tblnotice (studentId,courseId,academicYearId,cutOffAttendence,sessionId,noticeDate,notice) VALUES (:studentId,:courseId,:academicYearId,:cutOffAttendence,:sessionId,:noticeDate,:notice)");
$stmt->bindParam(":studentId",$currentStudentId);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":cutOffAttendence",$cutOffAttendence);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":noticeDate",$noticeDate);
$stmt->bindParam(":notice",$notice);

$stmt->execute();
$i++;
}
header("location:teacher-dashboard.php");
exit();
?>
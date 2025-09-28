<?php
ob_start();
session_start();
include "../database-connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Calcutta");

$dateOfAttendence   = $_REQUEST["dateOfAttendence"];
$courseId           = $_REQUEST["courseId"];
$academicYearId     = $_REQUEST["academicYearId"];
$subjectId          = $_REQUEST["subjectId"];
$sessionId          = $_REQUEST["sessionId"];
$studentId          = $_REQUEST["studentId"];  
$attendence         = $_REQUEST["attendence"]; 
$addedIpAddress     = $_SERVER['REMOTE_ADDR'];
$addedDateTime      = date('Y-m-d H:i:s');
$updatedIpAddress   = $_SERVER['REMOTE_ADDR'];
$updatedDateTime    = date('Y-m-d H:i:s');

$_SESSION["dateOfAttendence"] = $dateOfAttendence;
$_SESSION["courseId"]         = $courseId;
$_SESSION["academicYearId"]   = $academicYearId;
$_SESSION["subjectId"]        = $subjectId;
$_SESSION["sessionId"]        = $sessionId;


if (strlen($dateOfAttendence)<=0) {
    header("location:attendence-management.php?err=1");
    exit;
}
if ($courseId == -1) {
    header("location:attendence-management.php?err=2");
    exit;
}
if ($academicYearId == -1) {
    header("location:attendence-management.php?err=3");
    exit;
}
if ($subjectId == -1) {
    header("location:attendence-management.php?err=4");
    exit;
}
if ($sessionId == -1) {
    header("location:attendence-management.php?err=5");
    exit;
}

$i = 0;
while ($i < count($studentId)) {
    $currentStudentId   = $studentId[$i];
    $currentAttendence = $attendence[$currentStudentId] ?? 0;

    $stmt = $conn->prepare("INSERT INTO tblattendence 
        (dateOfAttendence, courseId, academicYearId, subjectId, sessionId, studentId, attendence, addedIpAddress, addedDateTime, updatedIpAddress, updatedDateTime) 
        VALUES 
        (:dateOfAttendence, :courseId, :academicYearId, :subjectId, :sessionId, :studentId, :attendence, :addedIpAddress, :addedDateTime, :updatedIpAddress, :updatedDateTime)");

    $stmt->bindParam(":dateOfAttendence", $dateOfAttendence);
    $stmt->bindParam(":courseId", $courseId);
    $stmt->bindParam(":academicYearId", $academicYearId);
    $stmt->bindParam(":subjectId", $subjectId);
    $stmt->bindParam(":sessionId", $sessionId);
    $stmt->bindParam(":studentId", $currentStudentId);
    $stmt->bindParam(":attendence", $currentAttendence);
    $stmt->bindParam(":addedIpAddress", $addedIpAddress);
    $stmt->bindParam(":addedDateTime", $addedDateTime);
    $stmt->bindParam(":updatedIpAddress", $updatedIpAddress);
    $stmt->bindParam(":updatedDateTime", $updatedDateTime);

    $stmt->execute();
    $i++;
}


session_destroy();
header("location:admin-dashboard.php");
exit();
?>

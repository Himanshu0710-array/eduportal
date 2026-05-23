<?php
ob_start();
session_start();
include "../database-connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Calcutta");

$dateOfAttendence   = $_POST["dateOfAttendence"] ?? "";
$courseId           = $_POST["courseId"] ?? "";
$academicYearId     = $_POST["academicYearId"] ?? "";
$subjectId          = $_POST["subjectId"] ?? "";
$sessionId          = $_POST["sessionId"] ?? "";
$studentId          = $_POST["studentId"] ?? [];  
$attendence         = $_POST["attendence"] ?? []; 
$addedIpAddress     = $_SERVER['REMOTE_ADDR'];
$addedDateTime      = date('Y-m-d H:i:s');
$updatedIpAddress   = $_SERVER['REMOTE_ADDR'];
$updatedDateTime    = date('Y-m-d H:i:s');

$_SESSION["dateOfAttendence"] = $dateOfAttendence;
$_SESSION["courseId"]         = $courseId;
$_SESSION["academicYearId"]   = $academicYearId;
$_SESSION["subjectId"]        = $subjectId;
$_SESSION["sessionId"]        = $sessionId;

// BUGFIX: ensure $studentId is always an array (single student sends a plain string)
if (!is_array($studentId)) {
    $studentId = ($studentId !== null && $studentId !== '') ? [$studentId] : [];
}
// Same for attendence, defensive
if (!is_array($attendence)) {
    $attendence = [];
}


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


unset($_SESSION["dateOfAttendence"]);
unset($_SESSION["courseId"]);
unset($_SESSION["academicYearId"]);
unset($_SESSION["subjectId"]);
unset($_SESSION["sessionId"]);

// Redirect back to management page with success flag + params for download
$params = http_build_query([
    'success'          => 1,
    'dateOfAttendence' => $dateOfAttendence,
    'courseId'         => $courseId,
    'academicYearId'   => $academicYearId,
    'subjectId'        => $subjectId,
    'sessionId'        => $sessionId,
]);
header("location:attendence-management.php?" . $params);
exit();
?>

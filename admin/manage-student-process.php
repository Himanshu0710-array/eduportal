<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");

$studentId          = $_REQUEST["studentId"];
$studentName          = $_REQUEST["studentName"];
$dob                  = $_REQUEST["dob"];
$courseId             = $_REQUEST["courseId"];
$sessionId            = $_REQUEST["sessionId"];
$studentNumber        = $_REQUEST["studentNumber"];
$studentGender        = $_REQUEST["studentGender"];
$studentEmail         = $_REQUEST["studentEmail"];
$studentPassword      = $_REQUEST["studentPassword"];
$fatherName           = $_REQUEST["fatherName"];
$motherName           = $_REQUEST["motherName"];
$parentNumber         = $_REQUEST["parentNumber"];
$parentEmail          = $_REQUEST["parentEmail"];
$dateOfRegistration   = $_REQUEST["dateOfRegistration"];
$address              = $_REQUEST["address"];
$addedIpAddress       = $_SERVER['REMOTE_ADDR'];
$addedDateTime        = date('Y-m-d H:i:s');
$updatedIpAddress     = $_SERVER['REMOTE_ADDR'];
$updatedDateTime      = date('Y-m-d H:i:s');

$_SESSION["studentName"]        =   $studentName;
$_SESSION["dob"]                =   $dob;
$_SESSION["courseId"]           =   $courseId;
$_SESSION["sessionId"]          =   $sessionId;
$_SESSION["studentNumber"]      =   $studentNumber;
$_SESSION["studentGender"]      =   $studentGender;
$_SESSION["studentEmail"]       =   $studentEmail;
$_SESSION["studentPassword"]    =   $studentPassword;
$_SESSION["fatherName"]         =   $fatherName;
$_SESSION["motherName"]         =   $motherName;
$_SESSION["parentNumber"]       =   $parentNumber;
$_SESSION["parentEmail"]        =   $parentEmail;
$_SESSION["dateOfRegistration"] =   $dateOfRegistration;
$_SESSION["address"]            =   $address;


if (strlen($studentName) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=1");
    exit;

}
if (strlen($dob) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=2");
    exit;

}
if ($courseId == -1) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=3");
    exit;

}
if ($sessionId== -1) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=4");
    exit;

}
if (strlen($studentNumber) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=5");
    exit;

}
if ($studentGender == -1) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=6");
    exit;

}
if (strlen($studentEmail) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=7");
    exit;

}
if (strlen($studentPassword) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=8");
    exit;

}
if (strlen($fatherName) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=9");
    exit;

}
if (strlen($motherName) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=10");
    exit;

}
if (strlen($parentNumber) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=11");
    exit;

}
if (strlen($parentEmail) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=12");
    exit;

}
if (strlen($dateOfRegistration) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=13");
    exit;

}
if (strlen($address) <= 0) {
    header("Location: /himanshu/admin/manage-student.php?studentId=" . $studentId . "&err=14");
    exit;

}

$query = "UPDATE tblstudent SET 
            studentName = :studentName, dob = :dob, courseId = :courseId, sessionId = :sessionId, 
            studentNumber = :studentNumber, studentGender = :studentGender, studentEmail = :studentEmail, 
            studentPassword = :studentPassword, fatherName = :fatherName, motherName = :motherName, 
            parentNumber = :parentNumber, parentEmail = :parentEmail, dateOfRegistration = :dateOfRegistration, 
            address = :address, addedIpAddress = :addedIpAddress, addedDateTime = :addedDateTime, 
            updatedIpAddress = :updatedIpAddress, updatedDateTime = :updatedDateTime 
          WHERE studentId = :studentId";

$stmt = $conn->prepare($query);
$stmt->bindParam(":studentId", $studentId);
$stmt->bindParam(":studentName", $studentName);
$stmt->bindParam(":dob", $dob);
$stmt->bindParam(":courseId", $courseId);
$stmt->bindParam(":sessionId", $sessionId);
$stmt->bindParam(":studentNumber", $studentNumber);
$stmt->bindParam(":studentGender", $studentGender);
$stmt->bindParam(":studentEmail", $studentEmail);
$stmt->bindParam(":studentPassword", $studentPassword);
$stmt->bindParam(":fatherName", $fatherName);
$stmt->bindParam(":motherName", $motherName);
$stmt->bindParam(":parentNumber", $parentNumber);
$stmt->bindParam(":parentEmail", $parentEmail);
$stmt->bindParam(":dateOfRegistration", $dateOfRegistration);
$stmt->bindParam(":address", $address);
$stmt->bindParam(":addedIpAddress", $addedIpAddress);
$stmt->bindParam(":addedDateTime", $addedDateTime);
$stmt->bindParam(":updatedIpAddress", $updatedIpAddress);
$stmt->bindParam(":updatedDateTime", $updatedDateTime);
$stmt->execute();

session_unset();



header("location:admin-dashboard.php");
exit;
?>
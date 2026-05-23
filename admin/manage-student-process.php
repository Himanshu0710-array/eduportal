<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");

// Get POST data with proper isset checks
$studentId          = isset($_REQUEST["studentId"]) ? trim($_REQUEST["studentId"]) : '';
$studentName        = isset($_REQUEST["studentName"]) ? trim($_REQUEST["studentName"]) : '';
$dob                = isset($_REQUEST["dob"]) ? trim($_REQUEST["dob"]) : '';
$courseId           = isset($_REQUEST["courseId"]) ? trim($_REQUEST["courseId"]) : '-1';
$academicYearId     = isset($_REQUEST["academicYearId"]) ? trim($_REQUEST["academicYearId"]) : '';
$sessionId          = isset($_REQUEST["sessionId"]) ? trim($_REQUEST["sessionId"]) : '-1';
$studentNumber      = isset($_REQUEST["studentNumber"]) ? trim($_REQUEST["studentNumber"]) : '';
$studentGender      = isset($_REQUEST["studentGender"]) ? trim($_REQUEST["studentGender"]) : '-1';
$studentEmail       = isset($_REQUEST["studentEmail"]) ? trim($_REQUEST["studentEmail"]) : '';
$studentPassword    = isset($_REQUEST["studentPassword"]) ? trim($_REQUEST["studentPassword"]) : '';
$fatherName         = isset($_REQUEST["fatherName"]) ? trim($_REQUEST["fatherName"]) : '';
$motherName         = isset($_REQUEST["motherName"]) ? trim($_REQUEST["motherName"]) : '';
$parentNumber       = isset($_REQUEST["parentNumber"]) ? trim($_REQUEST["parentNumber"]) : '';
$parentEmail        = isset($_REQUEST["parentEmail"]) ? trim($_REQUEST["parentEmail"]) : '';
$dateOfRegistration = isset($_REQUEST["dateOfRegistration"]) ? trim($_REQUEST["dateOfRegistration"]) : '';
$address            = isset($_REQUEST["address"]) ? trim($_REQUEST["address"]) : '';
$section            = isset($_REQUEST["section"]) ? trim($_REQUEST["section"]) : 'A';

$updatedIpAddress   = $_SERVER['REMOTE_ADDR'];
$updatedDateTime    = date('Y-m-d H:i:s');

// Store in session for error cases (preserve user input)
$_SESSION["studentName"]        = $studentName;
$_SESSION["dob"]                = $dob;
$_SESSION["courseId"]           = $courseId;
$_SESSION["sessionId"]          = $sessionId;
$_SESSION["studentNumber"]      = $studentNumber;
$_SESSION["studentGender"]      = $studentGender;
$_SESSION["studentEmail"]       = $studentEmail;
$_SESSION["studentPassword"]    = $studentPassword;
$_SESSION["fatherName"]         = $fatherName;
$_SESSION["motherName"]         = $motherName;
$_SESSION["parentNumber"]       = $parentNumber;
$_SESSION["parentEmail"]        = $parentEmail;
$_SESSION["dateOfRegistration"] = $dateOfRegistration;
$_SESSION["address"]            = $address;
$_SESSION["academicYearId"]     = $academicYearId;
$_SESSION["section"]            = $section;

// Validation
if (strlen($studentName) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=1");
    exit;
}
if (strlen($dob) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=2");
    exit;
}
if ($courseId == -1 || strlen($courseId) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=3");
    exit;
}
if ($sessionId == -1 || strlen($sessionId) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=4");
    exit;
}
if (strlen($studentNumber) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=5");
    exit;
}
if ($studentGender == -1 || strlen($studentGender) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=6");
    exit;
}
if (strlen($studentEmail) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=7");
    exit;
}
if (strlen($studentPassword) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=8");
    exit;
}
if (strlen($fatherName) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=9");
    exit;
}
if (strlen($motherName) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=10");
    exit;
}
if (strlen($parentNumber) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=11");
    exit;
}
if (strlen($parentEmail) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=12");
    exit;
}
if (strlen($dateOfRegistration) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=13");
    exit;
}
if (strlen($address) <= 0) {
    header("Location: manage-student.php?studentId=" . $studentId . "&err=14");
    exit;
}

// All validations passed - proceed with database update
try {
    $query = "UPDATE tblstudent SET 
                studentName = :studentName, 
                dob = :dob, 
                courseId = :courseId, 
                academicYearId = :academicYearId,
                sessionId = :sessionId, 
                studentNumber = :studentNumber, 
                studentGender = :studentGender, 
                studentEmail = :studentEmail, 
                studentPassword = :studentPassword, 
                fatherName = :fatherName, 
                motherName = :motherName, 
                parentNumber = :parentNumber, 
                parentEmail = :parentEmail, 
                dateOfRegistration = :dateOfRegistration, 
                address = :address, 
                section = :section,
                updatedIpAddress = :updatedIpAddress, 
                updatedDateTime = :updatedDateTime 
              WHERE studentId = :studentId";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":studentId", $studentId);
    $stmt->bindParam(":studentName", $studentName);
    $stmt->bindParam(":dob", $dob);
    $stmt->bindParam(":courseId", $courseId);
    $stmt->bindParam(":academicYearId", $academicYearId);
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
    $stmt->bindParam(":section", $section);
    $stmt->bindParam(":updatedIpAddress", $updatedIpAddress);
    $stmt->bindParam(":updatedDateTime", $updatedDateTime);
    
    $stmt->execute();

    // Clear form session variables
    unset($_SESSION["studentName"]);
    unset($_SESSION["dob"]);
    unset($_SESSION["courseId"]);
    unset($_SESSION["sessionId"]);
    unset($_SESSION["studentNumber"]);
    unset($_SESSION["studentGender"]);
    unset($_SESSION["studentEmail"]);
    unset($_SESSION["studentPassword"]);
    unset($_SESSION["fatherName"]);
    unset($_SESSION["motherName"]);
    unset($_SESSION["parentNumber"]);
    unset($_SESSION["parentEmail"]);
    unset($_SESSION["dateOfRegistration"]);
    unset($_SESSION["address"]);
    unset($_SESSION["academicYearId"]);
    unset($_SESSION["section"]);

    // Redirect to student table with success message
    header("location: student-table.php?success=1");
    exit;

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

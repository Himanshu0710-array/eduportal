<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

$studentId       = $_REQUEST["studentId"];
$studentNumber   = $_REQUEST["studentNumber"];
$studentEmail    = $_REQUEST["studentEmail"];
$studentPassword = $_REQUEST["studentPassword"];

if(strlen($studentNumber)<=0 || strlen($studentNumber)>10)
{
    header("location:student-profile.php?err=1");
    exit;
}
if(strlen($studentEmail)<=0)
{
    header("location:student-profile.php?err=2");
    exit;   
}
if(strlen($studentPassword)<=0)
{
    header("location:student-profile.php?err=3");
    exit;
}

$query = "UPDATE tblstudent SET studentNumber = :studentNumber, studentEmail = :studentEmail, studentPassword = :studentPassword WHERE studentId = :studentId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":studentId",$studentId);
$stmt->bindParam(":studentNumber",$studentNumber);
$stmt->bindParam(":studentEmail",$studentEmail);
$stmt->bindParam(":studentPassword",$studentPassword);

if($stmt->execute())
{
     $_SESSION['success_message'] = "Data Updated Successfully";
}

header("location:student-profile.php");
exit;
?>

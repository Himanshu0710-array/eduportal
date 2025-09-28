<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Calcutta");
include "../database-connect.php";

$academicYearName           =   $_REQUEST["academicYearName"];
$addedIpAddress             = $_SERVER['REMOTE_ADDR'];
$addedDateTime              = date('y-m-d h:i:s');
$updatedIpAddress           = $_SERVER['REMOTE_ADDR'];
$updatedDateTime            = date('y-m-d h:i:s');

if(strlen($academicYearName)<=0)
{
    header("location:add-academic-year.php?err=1");
    exit;
}

$query = "INSERT into tblAcademicYear (academicYearName,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) VALUES (:academicYearName,:addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)";
$stmt=$conn->prepare($query);
$stmt->bindParam(":academicYearName",$academicYearName);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);

$stmt->execute();

header("location:admin-dashboard.php");
exit;




?>
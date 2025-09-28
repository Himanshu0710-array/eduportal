<?php
session_start();
ob_start();
include "../database-connect.php";
date_default_timezone_set("Asia/Calcutta");

$testName       =   $_REQUEST["testName"];
$maximumMarks   =   $_REQUEST["maximumMarks"];

$_SESSION["testName"]           =   $testName;
$_SESSION["maximumMarks"]       = $maximumMarks;
$addedIpAddress                 =   $_SERVER['REMOTE_ADDR'];
$addedDateTime                  =   date('y-m-d h:i:s');
$updatedIpAddress               =   $_SERVER['REMOTE_ADDR'];
$updatedDateTime                =   date('y-m-d h:i:s');

if(strlen($testName)<=0)
{
    header("location:test-detail.php?err=1");
    exit();
}
if(strlen($maximumMarks)<=0)
{
    header("location:test-detail.php?err=2");
    exit();
}

$stmt=$conn->prepare("INSERT into tblTestDetail (testName,maximumMarks,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) VALUES (:testName,:maximumMarks,:addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)");
$stmt->bindParam(":testName",$testName);
$stmt->bindParam(":maximumMarks",$maximumMarks);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);

$stmt->execute();
header("location:admin-dashboard.php");
exit();

?>
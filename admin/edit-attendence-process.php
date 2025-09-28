<?php
ob_start();
include "../database-connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");
$id                 =   $_REQUEST["id"];
$attendence         =   $_REQUEST["attendence"];
$addedIpAddress     =   $_SERVER['REMOTE_ADDR'];
$addedDateTime      =   date('Y-m-d H:i:s');
$updatedIpAddress   =   $_SERVER['REMOTE_ADDR'];
$updatedDateTime    =   date('Y-m-d H:i:s');

$stmt=$conn->prepare("UPDATE tblattendence SET attendence=:attendence,addedIpAddress=:addedIpAddress,addedDateTime=:addedDateTime,updatedIpAddress=:updatedIpAddress,updatedDateTime=:updatedDateTime WHERE id=:id");
$stmt->bindParam(":id",$id);
$stmt->bindParam(":attendence",$attendence);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);

$stmt->execute();
header("location:admin-dashboard.php");
exit();


?>
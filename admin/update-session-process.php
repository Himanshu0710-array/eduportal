<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");

$sessionId            = $_REQUEST["sessionId"];
$sessionName          = $_REQUEST["sessionName"];
$status               = $_REQUEST["status"];
$addedIpAddress             = $_SERVER['REMOTE_ADDR'];
$addedDateTime              = date('y-m-d h:i:s');
$updatedIpAddress           = $_SERVER['REMOTE_ADDR'];
$updatedDateTime            = date('y-m-d h:i:s');


$_SESSION["sessionName"]        =   $sessionName;
$_SESSION["status"]             =   $status;

$stmt=$conn->prepare("UPDATE tblsession SET sessionName = :sessionName,status = :status,addedIpAddress = :addedIpAddress,addedDateTime = :addedDateTime,updatedIpAddress = :updatedIpAddress,updatedDateTime=:updatedDateTime WHERE sessionId=:sessionId");
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":sessionName",$sessionName);
$stmt->bindParam(":status",$status);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);
$stmt->execute();

header("location:admin-dashboard.php");
exit;



?>
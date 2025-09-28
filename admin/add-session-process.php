<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Calcutta");
include "../database-connect.php";

$sessionName    =   $_REQUEST["sessionName"];
$status         =   $_REQUEST["status"];
$addedIpAddress             = $_SERVER['REMOTE_ADDR'];
$addedDateTime              = date('y-m-d h:i:s');
$updatedIpAddress           = $_SERVER['REMOTE_ADDR'];
$updatedDateTime            = date('y-m-d h:i:s');
if(strlen($sessionName)<=0)
{
    header("location:add-session.php?err=1");
    exit;
}

$query = "INSERT into tblsession (sessionName,status,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) VALUES (:sessionName,:status,:addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)";
$stmt=$conn->prepare($query);
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
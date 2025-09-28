<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");

$adminId            =       $_REQUEST["adminId"];
$adminName          =       $_REQUEST["adminName"];
$adminPassword      =       $_REQUEST["adminPassword"];
$adminGender        =       $_REQUEST["adminGender"];
$adminNumber        =       $_REQUEST["adminNumber"];
$sessionId          =       $_REQUEST["sessionId"];
$adminOccupation    =       $_REQUEST["adminOccupation"];
$addedIpAddress     = $_SERVER['REMOTE_ADDR'];
$addedDateTime      = date('Y-m-d H:i:s');
$updatedIpAddress   = $_SERVER['REMOTE_ADDR'];
$updatedDateTime    = date('Y-m-d H:i:s');

if (strlen($adminName) <= 0) {
    header("location:edit-admin.php?err=1");
    exit;
}
if (strlen($adminPassword) <= 0) {
    header("location:edit-admin.php?err=2");
    exit;
}
if (strlen($adminNumber) <= 0 || strlen($adminNumber) > 10 || strlen($adminNumber) < 10){
    header("location:edit-admin.php?err=3");
    exit;
}

$stmt=$conn->prepare("UPDATE tbladmin SET adminName=:adminName,adminPassword=:adminPassword,adminGender=:adminGender,adminNumber=:adminNumber,sessionId=:sessionId,adminOccupation=:adminOccupation,addedIpAddress=:addedIpAddress,addedDateTime=:addedDateTime,updatedIpAddress=:updatedIpAddress,updatedDateTime=:updatedDateTime WHERE adminId=:adminId");
$stmt->bindParam(":adminId",$adminId);
$stmt->bindParam(":adminName",$adminName);
$stmt->bindParam(":adminPassword",$adminPassword);
$stmt->bindParam(":adminGender",$adminGender);
$stmt->bindParam(":adminNumber",$adminNumber);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":adminOccupation",$adminOccupation);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);

$stmt->execute();
header("location:admin-table.php");
exit;





?>
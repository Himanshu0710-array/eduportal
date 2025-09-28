<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";

date_default_timezone_set("Asia/Calcutta");

$id             =   $_REQUEST["id"];
$courseId       =   $_REQUEST["courseId"];
$academicYearId =   $_REQUEST["academicYearId"];
$totalFees      =   $_REQUEST["totalFees"];
$sessionId      =   $_REQUEST["sessionId"];
$dueDate        =   $_REQUEST["dueDate"];
$addedIpAddress     =   $_SERVER['REMOTE_ADDR'];
$addedDateTime      =   date('y-m-d h:i:s');
$updatedIpAddress   =   $_SERVER['REMOTE_ADDR'];
$updatedDateTime    =   date('y-m-d h:i:s');

if($courseId == -1)
{
    header("location:add-course-fees.php?err=1");
    exit;
}
if($academicYearId == -1)
{
    header("location:add-course-fees.php?err=2");
    exit;
}
if(strlen($totalFees)<=0)
{
    header("location:add-course-fees.php?err=3");
    exit;
}
if($sessionId == -1)
{
    header("location:add-course-fees.php?err=4");
    exit;
}
if(strlen($dueDate)<=0)
{
    header("location:add-course-fees.php?err=4");
    exit;
}

$stmt=$conn->prepare("UPDATE tblCourseFees SET courseId=:courseId,academicYearId=:academicYearId,totalFees=:totalFees,sessionId=:sessionId,dueDate=:dueDate,addedIpAddress=:addedIpAddress,addedDateTime=:addedDateTime,updatedIpAddress=:updatedIpAddress,updatedDateTime=:updatedDateTime WHERE id=:id");
$stmt->bindParam(":id",$id);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":totalFees",$totalFees);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":dueDate",$dueDate);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);
$stmt->execute();

header("location:course-fees-table.php");
exit();

?>
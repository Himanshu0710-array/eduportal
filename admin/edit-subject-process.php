<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Calcutta");
include "../database-connect.php";

$subjectId                  =   $_REQUEST["subjectId"];
$subjectName                =   $_REQUEST["subjectName"];
$courseId                   =   $_REQUEST["courseId"];
$academicYearId             =   $_REQUEST["academicYearId"];
$sessionId                  =   $_REQUEST["sessionId"];
$status                     =   $_REQUEST["status"];
$addedIpAddress             =   $_SERVER['REMOTE_ADDR'];
$addedDateTime              =   date('y-m-d h:i:s');
$updatedIpAddress           =   $_SERVER['REMOTE_ADDR'];
$updatedDateTime            =   date('y-m-d h:i:s'); 

if(strlen($subjectName)<=0)
{
    header("location:add-subject.php?err=1");
    exit();
}
if($courseId== -1)
{
    header("location:add-subject.php?err=2");
    exit();
}
if($academicYearId == -1)
{
    header("location:add-subject.php?err=3");
    exit();
}
if($sessionId == -1)
{
    header("location:add-subject.php?err=4");
    exit();
}

$stmt=$conn->prepare("UPDATE tblsubject SET subjectName=:subjectName , courseId=:courseId , academicYearId=:academicYearId , sessionId=:sessionId,status=:status ,addedIpAddress=:addedIpAddress,addedDateTime=:addedDateTime,updatedIpAddress=:updatedIpAddress,updatedDateTime=:updatedDateTime WHERE subjectId=:subjectId");
$stmt->bindParam(":subjectId",$subjectId);
$stmt->bindParam(":subjectName",$subjectName);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":status",$status);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);
$stmt->execute();

header("location:subject-table.php");
exit();





<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Calcutta");
include "../database-connect.php";

$id                 =   $_REQUEST["id"];
$testId             =   $_REQUEST["testId"];
$maximumMarks       =   $_REQUEST["maximumMarks"];
$courseId           =   $_REQUEST["courseId"];
$academicYearId     =   $_REQUEST["academicYearId"];
$subjectId          =   $_REQUEST["subjectId"];
$dateOfTest         =   $_REQUEST["dateOfTest"];
$sessionId          =   $_REQUEST["sessionId"];
$addedIpAddress     =   $_SERVER['REMOTE_ADDR'];
$addedDateTime      =   date('y-m-d h:i:s');
$updatedIpAddress   =   $_SERVER['REMOTE_ADDR'];
$updatedDateTime    =   date('y-m-d h:i:s'); 

if($testId == -1)
{
    header("location:add-fees.php?err=1");
    exit;
}
if($courseId==-1)
{
    header("location:add-fees.php?err=2");
    exit;
}
if($academicYearId==-1)
{
    header("location:add-fees.php?err=3");
    exit;
}
if($subjectId==-1)
{
    header("location:add-fees.php?err=4");
    exit;
}
if(strlen($dateOfTest)<=0)
{
    header("location:add-fees.php?err=5");
    exit;
}



$stmt=$conn->prepare("UPDATE tbltest SET testId=:testId,courseId=:courseId,academicYearId=:academicYearId,subjectId=:subjectId,dateOfTest=:dateOfTest,sessionId=:sessionId,addedIpAddress=:addedIpAddress,addedDateTime=:addedDateTime,updatedIpAddress=:updatedIpAddress,updatedDateTime=:updatedDateTime WHERE id=:id");
$stmt->bindParam(":id",$id);
$stmt->bindParam(":testId",$testId);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":subjectId",$subjectId);
$stmt->bindParam(":dateOfTest",$dateOfTest);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);
$stmt->execute();
header("location:test-table.php");
exit();





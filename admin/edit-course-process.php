<?php
ob_start();
include "../database-connect.php";

$courseId            =   $_REQUEST["courseId"];
$courseName          =   $_REQUEST["courseName"];
$courseDuration      =   $_REQUEST["courseDuration"];
$sessionId           =   $_REQUEST["sessionId"];

if(strlen($courseName)<=0)
{
    header("location:add-course.php?err=1");
    exit();
}
if($courseDuration==-1)
{
    header("location:add-course.php?err=2");
    exit();
}
if($sessionId==-1)
{
    header("location:add-course.php?err=4");
    exit();
}

$stmt=$conn->prepare("UPDATE tblcourse SET courseName=:courseName,courseDuration=:courseDuration,sessionId=:sessionId WHERE courseId=:courseId");

$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":courseName",$courseName);
$stmt->bindParam(":courseDuration",$courseDuration);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->execute();

header("location:course-table.php");
exit();
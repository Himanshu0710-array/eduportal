<?php
ob_start();
include "../database-connect.php";

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


$query = ("insert into tblcourse (courseName,courseDuration,sessionId) VALUES (:courseName,:courseDuration,:sessionId)" );

$stmt=$conn->prepare($query);


$stmt->bindParam(":courseName",$courseName);
$stmt->bindParam(":courseDuration",$courseDuration);
$stmt->bindParam(":sessionId",$sessionId);

$stmt->execute();

header("location:admin-dashboard.php");
exit();



?>
<?php
ob_start();
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";
date_default_timezone_set("Asia/Calcutta");

$testId             =   $_REQUEST["testId"];
$maximumMarks       =   $_REQUEST["maximumMarks"];
$courseId           =   $_REQUEST["courseId"];
$academicYearId     =   $_REQUEST["academicYearId"];
$subjectId          =   $_REQUEST["subjectId"];
$dateOfTest         =   $_REQUEST["dateOfTest"];
$sessionId          =   $_REQUEST["sessionId"];
$testStatus         =   $_REQUEST["testStatus"];
$addedIpAddress     =   $_SERVER['REMOTE_ADDR'];
$addedDateTime      =   date('y-m-d h:i:s');
$updatedIpAddress   =   $_SERVER['REMOTE_ADDR'];
$updatedDateTime    =   date('y-m-d h:i:s');


$_SESSION["testId"]           =   $testId;
$_SESSION["maximumMarks"]       = $maximumMarks;


$i = 0;
while($i < count($subjectId))
{
    $currentSubjectId = $subjectId[$i];
    $currentDateOfTest = $dateOfTest[$i];
$stmt=$conn->prepare("INSERT into tbltest (testId,maximumMarks,courseId,academicYearId,subjectId,dateOfTest,sessionId,testStatus,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) 
VALUES (:testId,:maximumMarks,:courseId,:academicYearId,:subjectId,:dateOfTest,:sessionId,:testStatus,:addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)");
$stmt->bindParam(":testId",$testId);
$stmt->bindParam(":maximumMarks",$maximumMarks);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":subjectId",$currentSubjectId);
$stmt->bindParam(":dateOfTest",$currentDateOfTest);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":testStatus",$testStatus);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);

$i++;
$stmt->execute();

}

header("location:admin-dashboard.php");
exit();

?>
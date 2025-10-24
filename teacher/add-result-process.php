<?php
ob_start();
include "../database-connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Calcutta");


$testId                     =   $_REQUEST["testId"];
$testStatus                 =   $_REQUEST["testStatus"];
$studentId                  =   $_REQUEST["studentId"];
$courseId                   =   $_REQUEST["courseId"];
$academicYearId             =   $_REQUEST["academicYearId"];
$subjectId                  =   $_REQUEST["subjectId"];
$marksObtained              =   $_REQUEST["marksObtained"];
$addedIpAddress             = $_SERVER['REMOTE_ADDR'];
$addedDateTime              = date('y-m-d h:i:s');
$updatedIpAddress           = $_SERVER['REMOTE_ADDR'];
$updatedDateTime            = date('y-m-d h:i:s'); 

$i=0;
while($i < count($studentId)){
    
$currentStudentId = $studentId[$i];
$currentMarksObtained = $marksObtained[$i];

$stmt=$conn->prepare("INSERT into tblresult (testId,studentId,courseId,academicYearId,subjectId,marksObtained,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) VALUES (:testId,:studentId,:courseId,:academicYearId,:subjectId,:marksObtained,:addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)");
$stmt->bindParam(":testId",$testId);
$stmt->bindParam(":studentId",$currentStudentId);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":subjectId",$subjectId);
$stmt->bindParam(":marksObtained",$currentMarksObtained);
$stmt->bindParam(":addedIpAddress"          ,$addedIpAddress);
$stmt->bindParam(":addedDateTime"           ,$addedDateTime);
$stmt->bindParam(":updatedIpAddress"        ,$updatedIpAddress);
$stmt->bindParam(":updatedDateTime"         ,$updatedDateTime);
$stmt->execute();
$i++;
}
$teststmt=$conn->prepare("UPDATE tbltest SET testStatus=:testStatus WHERE testId=:testId AND subjectId=:subjectId");
$teststmt->bindParam(":subjectId",$subjectId);
$teststmt->bindParam(":testId",$testId);
$teststmt->bindParam(":testStatus",$testStatus);
$teststmt->execute();

header("location:teacher-dashboard.php");
exit();

?>
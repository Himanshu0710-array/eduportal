<?php
include "../database-connect.php"; 

$studentId  = $_REQUEST["studentId"];
$subjectId  = $_REQUEST["subjectId"];

$totalstmt = $conn->prepare("SELECT * FROM tblattendence WHERE subjectId=:subjectId AND studentId=:studentId");
$totalstmt->bindParam(":subjectId", $subjectId);
$totalstmt->bindParam(":studentId",$studentId);
$totalstmt->execute();

$totalClasses = $totalstmt->rowCount();


$stmt = $conn->prepare("SELECT * FROM tblattendence WHERE subjectId=:subjectId AND studentId=:studentId AND attendence = 1");
$stmt->bindParam(":subjectId", $subjectId);
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();

$classAttended = $stmt->rowCount();

function percent($x, $y) {
    if ($y == 0) {
        return 0; 
    }
    return ($x / $y) * 100;
}

$overallAttendence = number_format(percent($classAttended,$totalClasses),2);

echo $overallAttendence . "%";
?>

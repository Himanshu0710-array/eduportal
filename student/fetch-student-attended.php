<?php
include "../database-connect.php"; 

$studentId  = $_REQUEST["studentId"];
$subjectId  = $_REQUEST["subjectId"];


$stmt = $conn->prepare("SELECT * FROM tblattendence WHERE subjectId=:subjectId AND studentId=:studentId AND attendence = 1");
$stmt->bindParam(":subjectId", $subjectId);
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();
$result=$stmt->fetch();
$totalClasses = $stmt->rowCount();
echo $totalClasses; 
?>

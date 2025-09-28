<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$studentId = $_REQUEST['studentId']; 

include "../database-connect.php";


$query = "DELETE FROM tblstudent WHERE studentId=:studentId";
$stmt=$conn->prepare($query);
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();


header("location:student-table.php");
exit;
?>

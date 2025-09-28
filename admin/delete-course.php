<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$courseId = $_REQUEST['courseId']; 

include "../database-connect.php";


$query = "DELETE FROM tblcourse WHERE courseId=:courseId";
$stmt=$conn->prepare($query);
$stmt->bindParam(":courseId",$courseId);
$stmt->execute();


header("location:course-table.php");
exit;
?>

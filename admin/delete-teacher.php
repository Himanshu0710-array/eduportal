<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$teacherId = $_POST['teacherId'] ?? ''; 

include "../database-connect.php";

$query = "DELETE FROM tblteacher WHERE teacherId=:teacherId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":teacherId", $teacherId);
$stmt->execute();

header("location:teacher-table.php");
exit;
?>

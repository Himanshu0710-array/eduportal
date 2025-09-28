<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";
$id      =   $_REQUEST["id"];

$stmt=$conn->prepare("DELETE FROM tblCourseFees WHERE id=:id");
$stmt->bindParam(":id",$id);
$stmt->execute();
header("location:course-fees-table.php");
exit;

?>
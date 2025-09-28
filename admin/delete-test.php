<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";
$testId      =   $_REQUEST["testId"];

$stmt=$conn->prepare("DELETE FROM tbltest WHERE testId=:testId");
$stmt->bindParam(":testId",$testId);
$stmt->execute();
header("location:test-table.php");
exit;

?>
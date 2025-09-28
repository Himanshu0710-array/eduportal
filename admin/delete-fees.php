<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../database-connect.php";
$feeId      =   $_REQUEST["feeId"];

$stmt=$conn->prepare("DELETE FROM tblfees WHERE feeId=:feeId");
$stmt->bindParam(":feeId",$feeId);
$stmt->execute();
header("location:fees-table.php");
exit;

?>
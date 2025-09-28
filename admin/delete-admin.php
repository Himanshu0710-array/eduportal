<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$adminId = $_REQUEST['adminId']; 

include "../database-connect.php";


$query = "DELETE FROM tbladmin WHERE adminId=:adminId";
$stmt=$conn->prepare($query);
$stmt->bindParam(":adminId",$adminId);
$stmt->execute();


header("location:admin-table.php");
exit;
?>

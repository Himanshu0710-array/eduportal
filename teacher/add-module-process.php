<?php
ob_start();
include "../database-connect.php";

$moduleName = trim($_REQUEST["moduleName"]);
$moduleDescription = trim($_REQUEST["moduleDescription"]);
$courseId = $_REQUEST["courseId"];

// Validation
if(strlen($moduleName) <= 0) {
    header("location:add-module.php?err=1");
    exit();
}

if(strlen($moduleDescription) <= 0) {
    header("location:add-module.php?err=2");
    exit();
}

if($courseId == -1) {
    header("location:add-module.php?err=3");
    exit();
}

// Insert into tblModule
$query = "INSERT INTO tblModule (moduleName, moduleDescription, courseId) 
          VALUES (:moduleName, :moduleDescription, :courseId)";
$stmt = $conn->prepare($query);

$stmt->bindParam(":moduleName", $moduleName);
$stmt->bindParam(":moduleDescription", $moduleDescription);
$stmt->bindParam(":courseId", $courseId);

$stmt->execute();

header("location:add-module.php?success=1");
exit();
?>

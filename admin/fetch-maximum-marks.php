<?php
include "../database-connect.php";
$testId =   $_REQUEST["testId"];

$stmt=$conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
$stmt->bindParam(":testId",$testId);
$stmt->execute();
$test=$stmt->fetch();

echo $test["maximumMarks"];

?>
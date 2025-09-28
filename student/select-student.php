<?php
$query1 = "SELECT * FROM tblstudent where studentId=:studentId";
$stmt2=$conn2->prepare($query1);
$stmt2->bindParam(":studentId",$studentId);
$stmt2->execute();

$row = $stmt2->fetch();
?>
<?php
include "../database-connect.php";
$studentId = $_REQUEST["studentId"];
$query = "SELECT * FROM tblstudent where studentId=:studentId";
$stmt=$conn->prepare($query);
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();
$result=$stmt->fetch();

$courseId = $result['courseId'];

$coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId = :courseId");
$coursestmt->bindParam(":courseId",$courseId);
$coursestmt->execute();
$course = $coursestmt->fetch();

if($result)
{
    echo "Student Name = " . $result["studentName"] . " || ";
echo "Course = " . $course["courseName"];



}
else
{
    echo "No Student Found";
}

?>
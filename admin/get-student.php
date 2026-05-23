<?php
include "../database-connect.php";
$studentId = $_GET["studentId"] ?? $_POST["studentId"] ?? "";
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

header('Content-Type: application/json');
if ($result) {
    echo json_encode([
        'status' => 'success',
        'studentName' => $result['studentName'],
        'courseId' => (int) $result['courseId'],
        'academicYearId' => (int) $result['academicYearId']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No Student Found'
    ]);
}

?>

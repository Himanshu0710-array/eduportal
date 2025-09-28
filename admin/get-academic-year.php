<?php
include "../database-connect.php";


$courseId = $_REQUEST["courseId"];


$stmt = $conn->prepare("SELECT courseDuration FROM tblcourse WHERE courseId = :courseId");
$stmt->bindParam(":courseId", $courseId, PDO::PARAM_INT);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

$courseDuration = (int) $course["courseDuration"];


$stmt = $conn->prepare("SELECT * FROM tblAcademicYear ORDER BY academicYearId ASC LIMIT $courseDuration");
$stmt->execute();
?>

<option value="-1">--Select Academic Year--</option>
<?php

while ($years = $stmt->fetch()) {
    echo '<option value="' . $years['academicYearId'] . '">' . $years['academicYearName'] . '</option>';
}
?>

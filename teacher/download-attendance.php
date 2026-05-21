<?php
include "../database-connect.php";

$dateOfAttendence = $_GET["dateOfAttendence"] ?? '';
$courseId         = $_GET["courseId"] ?? '';
$academicYearId   = $_GET["academicYearId"] ?? '';
$subjectId        = $_GET["subjectId"] ?? '';
$sessionId        = $_GET["sessionId"] ?? '';

if (!$dateOfAttendence || !$courseId || !$academicYearId || !$subjectId || !$sessionId) {
    die("Missing parameters. Please go back and load the attendance first.");
}

// Fetch attendance records with student and course names
$stmt = $conn->prepare("
    SELECT 
        a.studentId,
        s.studentName,
        c.courseName,
        a.dateOfAttendence,
        a.attendence
    FROM tblattendence a
    LEFT JOIN tblstudent s ON a.studentId = s.studentId
    LEFT JOIN tblcourse c ON a.courseId = c.courseId
    WHERE 
        a.dateOfAttendence = :dateOfAttendence AND
        a.courseId = :courseId AND
        a.academicYearId = :academicYearId AND
        a.subjectId = :subjectId AND
        a.sessionId = :sessionId
    ORDER BY s.studentName ASC
");
$stmt->bindParam(":dateOfAttendence", $dateOfAttendence);
$stmt->bindParam(":courseId", $courseId);
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->bindParam(":subjectId", $subjectId);
$stmt->bindParam(":sessionId", $sessionId);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send headers to force file download
$filename = "Attendance_" . $dateOfAttendence . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// CSV Header Row
fputcsv($output, ['Student ID', 'Student Name', 'Course', 'Date', 'Attendance']);

// CSV Data Rows
foreach ($rows as $row) {
    fputcsv($output, [
        $row['studentId'],
        $row['studentName'],
        $row['courseName'],
        date('d/m/Y', strtotime($row['dateOfAttendence'])),
        ($row['attendence'] == 1) ? 'Present' : 'Absent'
    ]);
}

fclose($output);
exit;
?>

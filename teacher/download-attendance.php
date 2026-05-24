<?php
include "../database-connect.php";

$dateOfAttendence = $_GET["dateOfAttendence"] ?? '';
$courseId         = $_GET["courseId"] ?? '';
$academicYearId   = $_GET["academicYearId"] ?? '';
$subjectId        = $_GET["subjectId"] ?? '';
$sessionId        = $_GET["sessionId"] ?? '';
$section          = $_GET["section"] ?? '';

if (!$dateOfAttendence || !$courseId || !$academicYearId || !$subjectId || !$sessionId) {
    die("Missing parameters. Please go back and load the attendance first.");
}

$query = "
    SELECT 
        a.studentId,
        s.studentName,
        s.section,
        c.courseName,
        sub.subjectName,
        a.dateOfAttendence,
        a.attendence
    FROM tblattendence a
    LEFT JOIN tblstudent s ON a.studentId = s.studentId
    LEFT JOIN tblcourse c ON a.courseId = c.courseId
    LEFT JOIN tblsubject sub ON a.subjectId = sub.subjectId
    WHERE 
        a.dateOfAttendence = :dateOfAttendence AND
        a.courseId = :courseId AND
        a.academicYearId = :academicYearId AND
        a.subjectId = :subjectId AND
        a.sessionId = :sessionId
";

if (!empty($section) && $section !== '-1') {
    $query .= " AND s.section = :section";
}

$query .= " ORDER BY s.studentName ASC";

$stmt = $conn->prepare($query);
$stmt->bindParam(":dateOfAttendence", $dateOfAttendence);
$stmt->bindParam(":courseId", $courseId);
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->bindParam(":subjectId", $subjectId);
$stmt->bindParam(":sessionId", $sessionId);

if (!empty($section) && $section !== '-1') {
    $stmt->bindParam(":section", $section);
}

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send headers to force file download
$filename = "Attendance_" . $dateOfAttendence . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// CSV Header Row
fputcsv($output, ['Student ID', 'Student Name', 'Section', 'Course', 'Subject', 'Date', 'Attendance']);

// CSV Data Rows
foreach ($rows as $row) {
    fputcsv($output, [
        $row['studentId'],
        $row['studentName'],
        $row['section'],
        $row['courseName'],
        $row['subjectName'],
        ' ' . $row['dateOfAttendence'], // Prepend space to force Excel to treat it as string
        ($row['attendence'] == 1) ? 'Present' : 'Absent'
    ]);
}

fclose($output);
exit;
?>

<?php
session_start();
require_once("../database-connect.php");

// Set JSON header
header('Content-Type: application/json');

$courseId = $_POST['courseId'] ?? '';
$academicYearId = $_POST['academicYearId'] ?? '';
$section = $_POST['section'] ?? '';
$subjectId = $_POST['subjectId'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$cutoff = isset($_POST['cutoff']) && $_POST['cutoff'] !== '' ? (float)$_POST['cutoff'] : null;

if (empty($courseId) || empty($academicYearId) || empty($section) || empty($startDate) || empty($endDate)) {
    echo json_encode(['error' => 'Missing required parameters.']);
    exit;
}

try {
    // Get all students for the given class
    $studentQuery = "SELECT studentId, studentName FROM tblstudent WHERE courseId = :courseId AND academicYearId = :academicYearId AND section = :section";
    $studentStmt = $conn->prepare($studentQuery);
    $studentStmt->bindParam(':courseId', $courseId);
    $studentStmt->bindParam(':academicYearId', $academicYearId);
    $studentStmt->bindParam(':section', $section);
    $studentStmt->execute();
    $students = $studentStmt->fetchAll(PDO::FETCH_ASSOC);

    $subjectCondition = "";
    if (!empty($subjectId) && $subjectId != '-1') {
        $subjectCondition = " AND subjectId = :subjectId";
    }

    $resultStudents = [];

    // For each student, calculate attendance percentage
    foreach ($students as $student) {
        $attQuery = "SELECT attendence FROM tblattendence 
                     WHERE studentId = :studentId 
                     AND dateOfAttendence BETWEEN :startDate AND :endDate
                     $subjectCondition";
        $attStmt = $conn->prepare($attQuery);
        $attStmt->bindParam(':studentId', $student['studentId']);
        $attStmt->bindParam(':startDate', $startDate);
        $attStmt->bindParam(':endDate', $endDate);
        if (!empty($subjectId) && $subjectId != '-1') {
            $attStmt->bindParam(':subjectId', $subjectId);
        }
        $attStmt->execute();
        $records = $attStmt->fetchAll(PDO::FETCH_ASSOC);

        $totalClasses = count($records);
        $attendedClasses = 0;
        foreach ($records as $record) {
            if ($record['attendence'] == 1) {
                $attendedClasses++;
            }
        }

        $percentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;

        // Apply cutoff filter (keep students with attendance LOWER than cutoff)
        if ($cutoff !== null && $percentage >= $cutoff) {
            continue; // Skip student if above or equal to cutoff
        }

        $student['percentage'] = $percentage;
        $student['totalClasses'] = $totalClasses;
        $resultStudents[] = $student;
    }

    echo json_encode([
        'success' => true,
        'students' => $resultStudents
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>

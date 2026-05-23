<?php
session_start();
require_once("../database-connect.php");

// Set JSON header
header('Content-Type: application/json');

// Get POST data
$studentId = $_POST['studentId'] ?? '';
$subjectId = $_POST['subjectId'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';

// Basic validation
if (empty($studentId) || empty($startDate) || empty($endDate)) {
    echo json_encode(['error' => 'Missing required parameters.']);
    exit;
}

try {
    // Determine condition for subject (if specific subject requested or all)
    $subjectCondition = "";
    if (!empty($subjectId)) {
        $subjectCondition = " AND subjectId = :subjectId";
    }

    // Query to fetch attendance records
    $query = "SELECT dateOfAttendence, attendence 
              FROM tblattendence 
              WHERE studentId = :studentId 
              AND dateOfAttendence BETWEEN :startDate AND :endDate
              $subjectCondition
              ORDER BY dateOfAttendence ASC";
              
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':studentId', $studentId);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    
    if (!empty($subjectId)) {
        $stmt->bindParam(':subjectId', $subjectId);
    }
    
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $totalClasses = count($records);
    $attendedClasses = 0;
    
    $dateBreakdown = [];
    foreach ($records as $record) {
        if ($record['attendence'] == 1) {
            $attendedClasses++;
            $status = 'Present';
        } else {
            $status = 'Absent';
        }
        
        $dateBreakdown[] = [
            'date' => date('M d, Y', strtotime($record['dateOfAttendence'])),
            'status' => $status
        ];
    }
    
    $missedClasses = $totalClasses - $attendedClasses;
    $percentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;
    
    $response = [
        'success' => true,
        'stats' => [
            'total' => $totalClasses,
            'attended' => $attendedClasses,
            'missed' => $missedClasses,
            'percentage' => $percentage
        ],
        'breakdown' => $dateBreakdown
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>

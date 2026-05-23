<?php
session_start();
require_once("../database-connect.php");

// Validate session
if (!isset($_SESSION['teacherId']) && !isset($_COOKIE['teacherLoginInfo'])) {
    die("Unauthorized access.");
}

$studentId = $_GET['studentId'] ?? '';
$subjectId = $_GET['subjectId'] ?? '';
$startDate = $_GET['startDate'] ?? '';
$endDate = $_GET['endDate'] ?? '';

if (empty($studentId) || empty($startDate) || empty($endDate)) {
    die("Missing required parameters.");
}

// Fetch student details
$studentQuery = "SELECT studentName, enrollmentNumber FROM tblstudent WHERE studentId = :studentId";
$studentStmt = $conn->prepare($studentQuery);
$studentStmt->bindParam(':studentId', $studentId);
$studentStmt->execute();
$student = $studentStmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}

// Fetch subject details if subjectId is provided
$subjectName = "All Subjects";
if (!empty($subjectId)) {
    $subjectQuery = "SELECT subjectName FROM tblsubject WHERE subjectId = :subjectId";
    $subjectStmt = $conn->prepare($subjectQuery);
    $subjectStmt->bindParam(':subjectId', $subjectId);
    $subjectStmt->execute();
    $subject = $subjectStmt->fetch(PDO::FETCH_ASSOC);
    if ($subject) {
        $subjectName = $subject['subjectName'];
    }
}

// Fetch attendance records
$subjectCondition = "";
if (!empty($subjectId)) {
    $subjectCondition = " AND subjectId = :subjectId";
}

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

foreach ($records as $record) {
    if ($record['attendence'] == 1) {
        $attendedClasses++;
    }
}

$missedClasses = $totalClasses - $attendedClasses;
$percentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report - <?php echo htmlspecialchars($student['studentName']); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .report-header {
            text-align: center;
            border-bottom: 2px solid #003366;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .report-header h1 {
            margin: 0;
            color: #003366;
            font-size: 24px;
            text-transform: uppercase;
        }
        .report-header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .student-details {
            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
        }
        .student-details td {
            padding: 8px;
            font-size: 14px;
        }
        .student-details td strong {
            color: #003366;
        }
        .stats-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .stat-box {
            text-align: center;
            flex: 1;
        }
        .stat-box:not(:last-child) {
            border-right: 1px solid #ddd;
        }
        .stat-box .label {
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }
        .stat-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #003366;
        }
        table.attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.attendance-table th, table.attendance-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table.attendance-table th {
            background-color: #003366;
            color: white;
            font-size: 14px;
        }
        table.attendance-table td {
            font-size: 13px;
        }
        .status-present {
            color: green;
            font-weight: bold;
        }
        .status-absent {
            color: red;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        /* Print specific styles */
        @media print {
            body {
                padding: 0;
                margin: 0;
                background-color: white;
            }
            @page {
                size: A4;
                margin: 20mm;
            }
            .no-print {
                display: none;
            }
            .report-header {
                border-bottom: 2px solid black;
            }
            table.attendance-table th {
                background-color: #f2f2f2 !important;
                color: black !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .stats-summary {
                background-color: transparent !important;
            }
        }
    </style>
</head>
<body onload="window.print();">

    <div class="report-header">
        <h1>Official Attendance Report</h1>
        <p>Generated on <?php echo date('F d, Y'); ?></p>
    </div>

    <table class="student-details">
        <tr>
            <td><strong>Student Name:</strong> <?php echo htmlspecialchars($student['studentName']); ?></td>
            <td><strong>Enrollment No:</strong> <?php echo htmlspecialchars($student['enrollmentNumber']); ?></td>
        </tr>
        <tr>
            <td><strong>Subject:</strong> <?php echo htmlspecialchars($subjectName); ?></td>
            <td><strong>Period:</strong> <?php echo date('M d, Y', strtotime($startDate)); ?> to <?php echo date('M d, Y', strtotime($endDate)); ?></td>
        </tr>
    </table>

    <div class="stats-summary">
        <div class="stat-box">
            <span class="label">Total Classes</span>
            <span class="value"><?php echo $totalClasses; ?></span>
        </div>
        <div class="stat-box">
            <span class="label">Attended</span>
            <span class="value" style="color: green;"><?php echo $attendedClasses; ?></span>
        </div>
        <div class="stat-box">
            <span class="label">Missed</span>
            <span class="value" style="color: red;"><?php echo $missedClasses; ?></span>
        </div>
        <div class="stat-box">
            <span class="label">Percentage</span>
            <span class="value"><?php echo $percentage; ?>%</span>
        </div>
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($records) > 0): ?>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?php echo date('F d, Y', strtotime($record['dateOfAttendence'])); ?></td>
                        <td>
                            <?php if ($record['attendence'] == 1): ?>
                                <span class="status-present">Present</span>
                            <?php else: ?>
                                <span class="status-absent">Absent</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center;">No attendance records found for this period.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        This is a computer-generated document. No signature is required.
    </div>

</body>
</html>

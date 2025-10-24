<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../database-connect.php";
include "teacher-dashboard-top.php";
include "teacher-dashboard-content.php"; 

$students = $conn->query("SELECT * FROM tblstudent")->fetchAll(PDO::FETCH_ASSOC);
$marks = $conn->query("SELECT * FROM tblresult")->fetchAll(PDO::FETCH_ASSOC);

$lowPerformers = [];
foreach ($students as $student) {
    $studentMarks = [];
    foreach ($marks as $m) {
        if ($m['studentId'] == $student['studentId']) {
            $studentMarks[] = $m;
        }
    }
    $total = 0;
    $count = 0;
    foreach ($studentMarks as $m) {
        if (isset($m['marksObtained']) && $m['marksObtained'] !== null) {
            $total += $m['marksObtained'];
            $count++;
        }
    }
    $avg = $count > 0 ? ($total / $count) : 0;
    if ($avg < 50) {
        $lowPerformers[] = [
            'studentName' => $student['studentName'],
            'avg_percentage' => $avg
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Low Performers</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.low-performers-page {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f8;
    padding: 20px;
}
.low-performers-page .card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    padding: 25px;
    margin-top: 20px;
}
.low-performers-page .card h2 {
    color: #334E68;
    margin-bottom: 20px;
}
.low-performers-page .data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.low-performers-page .data-table th, 
.low-performers-page .data-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #e0e0e0;
    text-align: left;
}
.low-performers-page .data-table th {
    background: #e9f1ff;
    color: #334E68;
}
.low-performers-page .data-table tr:hover {
    background: #f1f7ff;
}
.low-performers-page .btn-knowmore {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #667EEA;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s;
}
.low-performers-page .btn-knowmore:hover {
    background-color: #5563c1;
}
</style>
</head>
<body>
<div class="low-performers-page">
    <div class="card">
        <h2>Low Performers</h2>
        <?php if (count($lowPerformers) == 0): ?>
            <p>No low performers currently.</p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Average %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowPerformers as $lp): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($lp['studentName']); ?></td>
                            <td><?php echo round($lp['avg_percentage'], 1); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="teacher-dashboard.php" class="btn-knowmore">Return To Dashboard</a>
    </div>
</div>
</body>
</html>

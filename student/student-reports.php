<?php
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$stmt3 = $conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
$stmt3->bindParam(":studentId", $studentId);
$stmt3->execute();
$studentDetail = $stmt3->fetch();

$courseId = $studentDetail["courseId"];
$academicYearId = $studentDetail["academicYearId"];
?>
<title>My 15-Day Reports</title>
<style>
.reports-container {
    padding: 20px;
    background: #f8f9fa;
    min-height: 100vh;
}
.report-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
@media print {
    .left-side, .filters, .btn-print, .footer {
        display: none !important;
    }
    .reports-container {
        padding: 0;
        background: #fff;
    }
    .report-card {
        box-shadow: none;
        padding: 0;
    }
    .right-side {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}
</style>
<div class="reports-container">
    <div class="report-card">
        <h2 class="mb-4 text-primary">My Bi-Monthly Progress Reports</h2>
        
        <form method="GET" class="row g-3 mb-4 filters">
            <div class="col-md-4">
                <label class="form-label">Month & Year</label>
                <input type="month" name="month_year" class="form-control" value="<?php echo isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m'); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Period</label>
                <select name="period" class="form-select" required>
                    <option value="1" <?php echo (isset($_GET['period']) && $_GET['period'] == '1') ? 'selected' : ''; ?>>1st to 15th</option>
                    <option value="2" <?php echo (isset($_GET['period']) && $_GET['period'] == '2') ? 'selected' : ''; ?>>16th to End of Month</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">View Report</button>
            </div>
        </form>

        <?php
        if (isset($_GET['month_year']) && isset($_GET['period'])) {
            $monthYear = $_GET['month_year'];
            $period = $_GET['period'];

            $startDate = $monthYear . "-01";
            if ($period == '1') {
                $endDate = $monthYear . "-15";
            } else {
                $endDate = date("Y-m-t", strtotime($startDate));
                $startDate = $monthYear . "-16";
            }
            
            $reportTitle = "Report from " . date("d M Y", strtotime($startDate)) . " to " . date("d M Y", strtotime($endDate));
            
            $subjectStmt = $conn->prepare("SELECT subjectId, subjectName FROM tblsubject WHERE courseId = :courseId AND academicYearId = :academicYearId");
            $subjectStmt->bindParam(":courseId", $courseId);
            $subjectStmt->bindParam(":academicYearId", $academicYearId);
            $subjectStmt->execute();
            $subjects = $subjectStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><?php echo $reportTitle; ?></h5>
                <button class="btn btn-outline-secondary btn-print" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print / Download PDF
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Subject</th>
                            <th>Attendance %</th>
                            <th>Average Test Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($subjects as $sub) {
                            $subjectId = $sub['subjectId'];
                            $subjectName = $sub['subjectName'];
                            
                            $attStmt = $conn->prepare("SELECT COUNT(*) FROM tblattendence WHERE studentId = :studentId AND subjectId = :subjectId AND dateOfAttendence >= :startDate AND dateOfAttendence <= :endDate");
                            $attStmt->bindParam(":studentId", $studentId);
                            $attStmt->bindParam(":subjectId", $subjectId);
                            $attStmt->bindParam(":startDate", $startDate);
                            $attStmt->bindParam(":endDate", $endDate);
                            $attStmt->execute();
                            $totalClasses = $attStmt->fetchColumn();
                            
                            $attStmt2 = $conn->prepare("SELECT COUNT(*) FROM tblattendence WHERE studentId = :studentId AND subjectId = :subjectId AND dateOfAttendence >= :startDate AND dateOfAttendence <= :endDate AND attendence = 1");
                            $attStmt2->bindParam(":studentId", $studentId);
                            $attStmt2->bindParam(":subjectId", $subjectId);
                            $attStmt2->bindParam(":startDate", $startDate);
                            $attStmt2->bindParam(":endDate", $endDate);
                            $attStmt2->execute();
                            $attendedClasses = $attStmt2->fetchColumn();
                            
                            $attendancePercentage = ($totalClasses > 0) ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;
                            
                            $testStmt = $conn->prepare("SELECT t.testId FROM tbltest t WHERE t.subjectId = :subjectId AND t.dateOfTest >= :startDate AND t.dateOfTest <= :endDate AND t.courseId = :courseId");
                            $testStmt->bindParam(":subjectId", $subjectId);
                            $testStmt->bindParam(":startDate", $startDate);
                            $testStmt->bindParam(":endDate", $endDate);
                            $testStmt->bindParam(":courseId", $courseId);
                            $testStmt->execute();
                            $testsInPeriod = $testStmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            $totalMarks = 0;
                            $testCount = 0;
                            
                            foreach ($testsInPeriod as $test) {
                                $tId = $test['testId'];
                                $resStmt = $conn->prepare("SELECT marksObtained FROM tblresult WHERE studentId = :studentId AND testId = :testId");
                                $resStmt->bindParam(":studentId", $studentId);
                                $resStmt->bindParam(":testId", $tId);
                                $resStmt->execute();
                                $res = $resStmt->fetch();
                                
                                if ($res) {
                                    $totalMarks += $res['marksObtained'];
                                    $testCount++;
                                }
                            }
                            
                            $averageMarks = ($testCount > 0) ? round($totalMarks / $testCount, 2) : "N/A";
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subjectName); ?></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar <?php echo $attendancePercentage < 75 ? 'bg-danger' : 'bg-success'; ?>" role="progressbar" style="width: <?php echo $attendancePercentage; ?>%;" aria-valuenow="<?php echo $attendancePercentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $attendancePercentage; ?>%</div>
                                    </div>
                                </td>
                                <td><?php echo $averageMarks; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php include "../splitting-student/footer.php"; ?>

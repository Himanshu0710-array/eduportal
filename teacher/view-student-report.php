<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "../database-connect.php";
if (!isset($_SESSION['teacherId']) && !isset($_COOKIE['teacherId'])) {
    header("Location: login-teacher.php");
    exit;
}

$teacherId = isset($_SESSION['teacherId']) ? $_SESSION['teacherId'] : (isset($_COOKIE['teacherId']) ? htmlspecialchars($_COOKIE['teacherId']) : '');
$query = "SELECT * FROM tblteacher WHERE teacherId = :teacherId";
$stmt = $conn->prepare($query);
$stmt->bindParam(":teacherId", $teacherId);
$stmt->execute();
$result = $stmt->fetch();

$studentId = isset($_GET['studentId']) ? $_GET['studentId'] : null;

if (!$studentId) {
    die("Student ID is missing.");
}

$stuStmt = $conn->prepare("SELECT * FROM tblstudent WHERE studentId = :studentId");
$stuStmt->bindParam(":studentId", $studentId);
$stuStmt->execute();
$student = $stuStmt->fetch();

if (!$student) {
    die("Student not found.");
}

include "teacher-dashboard-top.php";
?>
<title>Student Report</title>
<?php
include "teacher-dashboard-content.php";
?>
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
    .sidebar, .navbar, .filters, .btn-print, .footer {
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
}
</style>
<div class="reports-container">
    <div class="report-card">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="text-primary">Student Report: <?php echo htmlspecialchars($student['studentName']); ?> (ID: <?php echo $student['studentId']; ?>)</h2>
            <a href="student-table.php" class="btn btn-secondary">Back</a>
        </div>
        
        <form method="GET" class="row g-3 mb-4 filters">
            <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>">
            <div class="col-md-3">
                <label class="form-label">Month & Year</label>
                <input type="month" name="month_year" class="form-control" value="<?php echo isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m'); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Period</label>
                <select name="period" class="form-select" required>
                    <option value="1" <?php echo (isset($_GET['period']) && $_GET['period'] == '1') ? 'selected' : ''; ?>>1st to 15th</option>
                    <option value="2" <?php echo (isset($_GET['period']) && $_GET['period'] == '2') ? 'selected' : ''; ?>>16th to End of Month</option>
                    <option value="3" <?php echo (isset($_GET['period']) && $_GET['period'] == '3') ? 'selected' : ''; ?>>Full Month</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Generate Report</button>
            </div>
        </form>

        <?php
        if (isset($_GET['month_year']) && isset($_GET['period'])) {
            $monthYear = $_GET['month_year'];
            $period = $_GET['period'];

            $startDate = $monthYear . "-01";
            if ($period == '1') {
                $endDate = $monthYear . "-15";
            } elseif ($period == '2') {
                $endDate = date("Y-m-t", strtotime($startDate));
                $startDate = $monthYear . "-16";
            } else {
                $endDate = date("Y-m-t", strtotime($startDate));
            }
            
            $reportTitle = "Report from " . date("d M Y", strtotime($startDate)) . " to " . date("d M Y", strtotime($endDate));
            
            $teacherCourseId = -1;
            $teacherSubjectId = $result['subjectId'];
            
            if (!empty($teacherSubjectId)) {
                $subStmt = $conn->prepare("SELECT courseId FROM tblsubject WHERE subjectId = :subjectId");
                $subStmt->bindParam(":subjectId", $teacherSubjectId);
                $subStmt->execute();
                $subRow = $subStmt->fetch();
                if ($subRow) {
                    $teacherCourseId = $subRow['courseId'];
                }
            }

            $attStmt = $conn->prepare("SELECT COUNT(*) as totalClasses FROM tblattendence WHERE studentId = :studentId AND subjectId = :subjectId AND dateOfAttendence >= :startDate AND dateOfAttendence <= :endDate");
            $attStmt->bindParam(":studentId", $studentId);
            $attStmt->bindParam(":subjectId", $teacherSubjectId);
            $attStmt->bindParam(":startDate", $startDate);
            $attStmt->bindParam(":endDate", $endDate);
            $attStmt->execute();
            $totalClasses = $attStmt->fetchColumn();
            
            $attStmt2 = $conn->prepare("SELECT COUNT(*) as attendedClasses FROM tblattendence WHERE studentId = :studentId AND subjectId = :subjectId AND dateOfAttendence >= :startDate AND dateOfAttendence <= :endDate AND attendence = 1");
            $attStmt2->bindParam(":studentId", $studentId);
            $attStmt2->bindParam(":subjectId", $teacherSubjectId);
            $attStmt2->bindParam(":startDate", $startDate);
            $attStmt2->bindParam(":endDate", $endDate);
            $attStmt2->execute();
            $attendedClasses = $attStmt2->fetchColumn();
            
            $attendancePercentage = ($totalClasses > 0) ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;
            
            $testStmt = $conn->prepare("SELECT t.testId, td.testName, t.dateOfTest, td.maximumMarks, r.marksObtained FROM tbltest t JOIN tblTestDetail td ON t.testId = td.testId LEFT JOIN tblresult r ON t.testId = r.testId AND r.studentId = :studentId WHERE t.subjectId = :subjectId AND t.dateOfTest >= :startDate AND t.dateOfTest <= :endDate AND t.courseId = :courseId");
            $testStmt->bindParam(":studentId", $studentId);
            $testStmt->bindParam(":subjectId", $teacherSubjectId);
            $testStmt->bindParam(":startDate", $startDate);
            $testStmt->bindParam(":endDate", $endDate);
            $testStmt->bindParam(":courseId", $teacherCourseId);
            $testStmt->execute();
            $testsInPeriod = $testStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><?php echo $reportTitle; ?></h5>
                <button class="btn btn-outline-secondary btn-print filters" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print / Download PDF
                </button>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-primary h-100">
                        <div class="card-header bg-primary text-white">Attendance Summary</div>
                        <div class="card-body">
                            <p><strong>Total Classes:</strong> <?php echo $totalClasses; ?></p>
                            <p><strong>Classes Attended:</strong> <?php echo $attendedClasses; ?></p>
                            <div class="progress mt-3" style="height: 25px;">
                                <div class="progress-bar <?php echo $attendancePercentage < 75 ? 'bg-danger' : 'bg-success'; ?>" role="progressbar" style="width: <?php echo $attendancePercentage; ?>%;" aria-valuenow="<?php echo $attendancePercentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $attendancePercentage; ?>%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card border-info h-100">
                        <div class="card-header bg-info text-white">Test Performances</div>
                        <div class="card-body p-0">
                            <?php if (count($testsInPeriod) > 0) { ?>
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Test Name</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($testsInPeriod as $test) { ?>
                                            <tr>
                                                <td><?php echo date("d/m/Y", strtotime($test['dateOfTest'])); ?></td>
                                                <td><?php echo htmlspecialchars($test['testName']); ?></td>
                                                <td>
                                                    <?php 
                                                        if ($test['marksObtained'] !== null) {
                                                            echo $test['marksObtained'] . " / " . $test['maximumMarks']; 
                                                        } else {
                                                            echo "<span class='text-muted'>Not graded / Absent</span>";
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="p-3">No tests recorded in this period.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
include "teacher-dashboard-footer.php";
?>

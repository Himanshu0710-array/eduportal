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

include "teacher-dashboard-top.php";
?>
<title>15-Day Reports</title>
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
.table td, .table th {
    vertical-align: middle;
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
        <h2 class="mb-4 text-primary">Bi-Monthly Student Progress Reports</h2>
        
        <form method="GET" class="row g-3 mb-4 filters">
            <div class="col-md-3">
                <label class="form-label">Month & Year</label>
                <input type="month" name="month_year" class="form-control" value="<?php echo isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m'); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Period</label>
                <select name="period" class="form-select" required>
                    <option value="1" <?php echo (isset($_GET['period']) && $_GET['period'] == '1') ? 'selected' : ''; ?>>1st to 15th</option>
                    <option value="2" <?php echo (isset($_GET['period']) && $_GET['period'] == '2') ? 'selected' : ''; ?>>16th to End of Month</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Section</label>
                <select name="section" class="form-select">
                    <option value="">All Sections</option>
                    <?php
                    $teacherSections = !empty($result['section']) ? explode(',', $result['section']) : [];
                    foreach ($teacherSections as $sec) {
                        $sec = trim($sec);
                        if (!empty($sec)) {
                            $selected = (isset($_GET['section']) && $_GET['section'] == $sec) ? 'selected' : '';
                            echo "<option value='{$sec}' {$selected}>{$sec}</option>";
                        }
                    }
                    ?>
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
            $filterSection = isset($_GET['section']) ? $_GET['section'] : '';

            $startDate = $monthYear . "-01";
            if ($period == '1') {
                $endDate = $monthYear . "-15";
            } else {
                $endDate = date("Y-m-t", strtotime($startDate));
                $startDate = $monthYear . "-16";
            }
            
            $reportTitle = "Report from " . date("d M Y", strtotime($startDate)) . " to " . date("d M Y", strtotime($endDate));
            
            $teacherCourseId = -1;
            $teacherAcademicYearId = -1;
            $teacherSubjectId = $result['subjectId'];
            
            if (!empty($teacherSubjectId)) {
                $subStmt = $conn->prepare("SELECT courseId, academicYearId FROM tblsubject WHERE subjectId = :subjectId");
                $subStmt->bindParam(":subjectId", $teacherSubjectId);
                $subStmt->execute();
                $subRow = $subStmt->fetch();
                if ($subRow) {
                    $teacherCourseId = $subRow['courseId'];
                    $teacherAcademicYearId = $subRow['academicYearId'];
                }
            }
            
            $queryStr = "SELECT * FROM tblstudent WHERE courseId = ? AND academicYearId = ?";
            if (!empty($filterSection)) {
                $queryStr .= " AND section = ?";
            } else {
                $placeholders = [];
                $validSections = [];
                foreach ($teacherSections as $sec) {
                    $sec = trim($sec);
                    if (!empty($sec)) {
                        $validSections[] = $sec;
                        $placeholders[] = '?';
                    }
                }
                if (!empty($validSections)) {
                    $queryStr .= " AND section IN (" . implode(',', $placeholders) . ")";
                }
            }
            
            $stmtStudents = $conn->prepare($queryStr);
            if (!empty($filterSection)) {
                $stmtStudents->execute([$teacherCourseId, $teacherAcademicYearId, $filterSection]);
            } else {
                if (!empty($validSections)) {
                    $params = [$teacherCourseId, $teacherAcademicYearId];
                    foreach ($validSections as $sec) {
                        $params[] = $sec;
                    }
                    $stmtStudents->execute($params);
                } else {
                    $stmtStudents->execute([$teacherCourseId, $teacherAcademicYearId]);
                }
            }
            
            $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($students) > 0) {
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
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Section</th>
                                <th>Attendance %</th>
                                <th>Average Test Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($students as $student) {
                                $studentId = $student['studentId'];
                                
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
                                
                                $testStmt = $conn->prepare("SELECT t.testId FROM tbltest t WHERE t.subjectId = :subjectId AND t.dateOfTest >= :startDate AND t.dateOfTest <= :endDate AND t.courseId = :courseId");
                                $testStmt->bindParam(":subjectId", $teacherSubjectId);
                                $testStmt->bindParam(":startDate", $startDate);
                                $testStmt->bindParam(":endDate", $endDate);
                                $testStmt->bindParam(":courseId", $teacherCourseId);
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
                                    <td><?php echo $student['rollNo']; ?></td>
                                    <td><?php echo $student['studentName']; ?></td>
                                    <td><?php echo $student['section']; ?></td>
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
            } else {
                echo "<div class='alert alert-info'>No students found for the selected criteria.</div>";
            }
        }
        ?>
    </div>
</div>

<?php
include "teacher-dashboard-footer.php";
?>

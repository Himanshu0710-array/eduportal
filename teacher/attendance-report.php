<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "teacher-dashboard-top.php";
include "teacher-dashboard-content.php";
include_once "../database-connect.php";

$teacherCourseId = -1;
$teacherAcademicYearId = -1;
if (!empty($result['subjectId'])) {
    $subStmt = $conn->prepare("SELECT courseId, academicYearId FROM tblsubject WHERE subjectId = :subjectId");
    $subStmt->bindParam(":subjectId", $result['subjectId']);
    $subStmt->execute();
    $subRow = $subStmt->fetch();
    if ($subRow) {
        $teacherCourseId = $subRow['courseId'];
        $teacherAcademicYearId = $subRow['academicYearId'];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .report-container {
            margin-top: 20px;
            margin-bottom: 40px;
        }
        .filter-panel {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }
        .student-list-panel {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
            border: 1px solid #e5e7eb;
            max-height: 600px;
            overflow-y: auto;
        }
        .summary-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 25px;
            border: 1px solid #e5e7eb;
            display: none; /* Hidden until a student is selected */
        }
        .progress-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .bg-excellent { background: linear-gradient(135deg, #10b981, #059669); }
        .bg-average { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .bg-poor { background: linear-gradient(135deg, #ef4444, #dc2626); }
        
        .stat-box {
            text-align: center;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
        }
        .stat-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }
        .attendance-timeline {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }
        .timeline-item {
            padding: 10px 15px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
        }
        .timeline-item:last-child {
            border-bottom: none;
        }
        .btn-view-report {
            background-color: #0ea5e9;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 6px;
            transition: all 0.3s;
        }
        .btn-view-report:hover {
            background-color: #0284c7;
            color: white;
        }
    </style>
</head>
<body>

<div class="container-fluid report-container">
    <div class="row">
        <!-- Left Column: Filters and Student List -->
        <div class="col-lg-5">
            <div class="filter-panel">
                <h5 class="mb-4" style="color: #1e293b; font-weight: 600;"><i class="bi bi-funnel"></i> Report Filters</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" value="<?php echo date('Y-m-01'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" value="<?php echo date('Y-m-t'); ?>">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <select class="form-select" id="courseId" disabled>
                            <option value="-1">--Select Course--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tblcourse");
                            $stmt->execute();
                            while ($course = $stmt->fetch()) {
                                $selected = ($course['courseId'] == $teacherCourseId) ? "selected" : "";
                                echo "<option value='{$course['courseId']}' $selected>{$course['courseName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Section</label>
                        <select class="form-select" id="section">
                            <option value="-1">--Select Section--</option>
                            <?php
                            $teacherSections = !empty($result['section']) ? explode(',', $result['section']) : [];
                            foreach ($teacherSections as $index => $sec) {
                                $sec = trim($sec);
                                $selected = ($index == 0) ? "selected" : "";
                                echo "<option value=\"$sec\" $selected>Section $sec</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Academic Year</label>
                        <select class="form-select" id="academicYearId" disabled>
                            <option value="-1">--Select Academic Year--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tblAcademicYear");
                            $stmt->execute();
                            while ($year = $stmt->fetch()) {
                                $selected = ($year['academicYearId'] == $teacherAcademicYearId) ? "selected" : "";
                                echo "<option value='{$year['academicYearId']}' $selected>{$year['academicYearName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <select class="form-select" id="subjectId">
                            <option value="-1">--Select Subject--</option>
                            <?php
                            if (!empty($result['subjectId'])) {
                                $sstmt = $conn->prepare("SELECT * FROM tblsubject WHERE subjectId = :subjectId AND status = 1");
                                $sstmt->bindParam(":subjectId", $result['subjectId']);
                                $sstmt->execute();
                                while ($subj = $sstmt->fetch()) {
                                    echo "<option value='{$subj['subjectId']}' selected>" . htmlspecialchars($subj['subjectName']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Session</label>
                        <select class="form-select" id="sessionId">
                            <option value="-1">--Select Session--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tblsession WHERE status = 1");
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                echo "<option value='{$row["sessionId"]}' selected>{$row["sessionName"]}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cut-off Attendance (%)</label>
                        <input type="number" class="form-control" id="cutoff" placeholder="e.g. 75" min="0" max="100">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary w-100" id="btnLoadStudents" style="font-weight: 600;">
                        <i class="bi bi-search"></i> Load Students
                    </button>
                </div>

            </div>

            <div class="student-list-panel">
                <h5 class="mb-3" style="color: #1e293b; font-weight: 600;"><i class="bi bi-people"></i> Select Student</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Student Name</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentListBody">
                            <tr>
                                <td colspan="2" class="text-center text-muted">Loading students...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Attendance Summary Card -->
        <div class="col-lg-7">
            <div class="summary-card" id="summaryCard">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h4 class="mb-0" style="color: #0f172a; font-weight: 600;">Attendance Summary</h4>
                    <button class="btn btn-primary" id="btnDownloadPdf" style="border-radius: 8px;">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </button>
                </div>

                <div class="text-center mb-4">
                    <h5 id="reportStudentName" style="color: #334155; font-size: 22px;">Student Name</h5>
                    <p class="text-muted" id="reportDateRange">Jan 01, 2026 - Jan 31, 2026</p>
                </div>

                <div class="progress-circle bg-excellent" id="reportPercentage">
                    100%
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-value" id="reportTotalClasses">0</div>
                            <div class="stat-label">Total Classes</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-value" id="reportAttended" style="color: #16a34a;">0</div>
                            <div class="stat-label">Attended</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-value" id="reportMissed" style="color: #dc2626;">0</div>
                            <div class="stat-label">Missed</div>
                        </div>
                    </div>
                </div>

                <h6 style="color: #475569; font-weight: 600; margin-bottom: 10px;">Date Breakdown</h6>
                <div class="attendance-timeline" id="attendanceTimeline">
                    <!-- Timeline items loaded via AJAX -->
                </div>
            </div>
            
            <div class="summary-card" id="emptyStateCard" style="display: block; text-align: center; padding: 60px 20px;">
                <i class="bi bi-file-earmark-bar-graph text-muted" style="font-size: 48px;"></i>
                <h5 class="mt-3 text-muted">Select a student to view their attendance report</h5>
            </div>
        </div>
    </div>
</div>

<?php include "teacher-dashboard-footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // Dependent dropdown for Subject
    $("#courseId, #academicYearId").change(function(){
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        if(courseId == -1 || academicYearId == -1) {
            $("#subjectId").html('<option value="-1">--Select Subject--</option>');
        } else {
            $.ajax({
                url:"fetch-subject.php",
                type:"POST",
                data : { courseId: courseId , academicYearId: academicYearId },
                success: function (response){
                    $("#subjectId").html(response);
                }
            });
        }
    });

    // Load Students based on filters
    function loadStudentsForReport() {
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        var sessionId = $("#sessionId").val();
        var section = $("#section").val();
        var subjectId = $("#subjectId").val();
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var cutoff = $("#cutoff").val();
        
        if(!startDate || !endDate) {
            alert("Please select start and end dates.");
            return;
        }

        if(courseId != "-1" && academicYearId != "-1" && sessionId != "-1" && section != "-1") {
            $("#studentListBody").html('<tr><td colspan="2" class="text-center text-muted">Loading students...</td></tr>');
            $.ajax({
                url: "fetch-students-for-report.php",
                type: "POST",
                dataType: "json",
                data: { 
                    courseId: courseId, 
                    academicYearId: academicYearId, 
                    sessionId: sessionId, 
                    section: section,
                    subjectId: subjectId,
                    startDate: startDate,
                    endDate: endDate,
                    cutoff: cutoff
                },
                success: function(response) {
                    var html = '';
                    if(!response.success || response.students.length === 0) {
                        html = '<tr><td colspan="2" class="text-center text-muted">No students found matching criteria.</td></tr>';
                    } else {
                        response.students.forEach(function(student) {
                            var pctColor = student.percentage >= 75 ? 'text-success' : (student.percentage >= 50 ? 'text-warning' : 'text-danger');
                            html += `
                                <tr>
                                    <td>
                                        <div class="fw-bold">${student.studentName}</div>
                                        <div class="text-muted small">ID: ${student.studentId} | <span class="fw-bold ${pctColor}">Att: ${student.percentage}%</span></div>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn-view-report" onclick="viewReport('${student.studentId}', '${student.studentName}')">
                                            View Report
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    $("#studentListBody").html(html);
                },
                error: function() {
                    $("#studentListBody").html('<tr><td colspan="2" class="text-center text-danger">Error loading students.</td></tr>');
                }
            });
        }
    }

    $("#btnLoadStudents").click(function(){
        loadStudentsForReport();
    });

    // Remove the autoloading on filter change since we now have a load button
    // $("#courseId, #academicYearId, #sessionId, #section").change(function(){
    //     loadStudentsForReport();
    // });

    // Initial load
    loadStudentsForReport();
    
    // Define global viewReport function
    window.viewReport = function(studentId, studentName) {
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var subjectId = $("#subjectId").val();
        
        if(!startDate || !endDate) {
            alert("Please select start and end dates.");
            return;
        }
        
        $("#emptyStateCard").hide();
        $("#summaryCard").show();
        
        $("#reportStudentName").text(studentName);
        
        // Format dates for display
        var startObj = new Date(startDate);
        var endObj = new Date(endDate);
        var options = { month: 'short', day: 'numeric', year: 'numeric' };
        $("#reportDateRange").text(startObj.toLocaleDateString('en-US', options) + " - " + endObj.toLocaleDateString('en-US', options));
        
        // Setup PDF download link
        var downloadUrl = `print-attendance-report.php?studentId=${studentId}&subjectId=${subjectId == -1 ? '' : subjectId}&startDate=${startDate}&endDate=${endDate}`;
        
        // Bind download button
        $("#btnDownloadPdf").off('click').on('click', function() {
            window.open(downloadUrl, '_blank');
        });
        
        // Fetch data
        $("#reportTotalClasses, #reportAttended, #reportMissed").text("...");
        $("#reportPercentage").text("%");
        $("#attendanceTimeline").html('<div class="text-center p-3 text-muted">Loading attendance data...</div>');
        
        $.ajax({
            url: "fetch-attendance-report.php",
            type: "POST",
            data: {
                studentId: studentId,
                subjectId: subjectId == -1 ? '' : subjectId,
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    var stats = res.stats;
                    $("#reportTotalClasses").text(stats.total);
                    $("#reportAttended").text(stats.attended);
                    $("#reportMissed").text(stats.missed);
                    $("#reportPercentage").text(stats.percentage + "%");
                    
                    var circle = $("#reportPercentage");
                    circle.removeClass("bg-excellent bg-average bg-poor");
                    if(stats.percentage >= 75) {
                        circle.addClass("bg-excellent");
                    } else if(stats.percentage >= 50) {
                        circle.addClass("bg-average");
                    } else {
                        circle.addClass("bg-poor");
                    }
                    
                    var html = '';
                    if(res.breakdown.length > 0) {
                        res.breakdown.forEach(function(item) {
                            var statusColor = item.status === 'Present' ? 'color: #16a34a;' : 'color: #dc2626;';
                            html += `
                                <div class="timeline-item">
                                    <div>
                                        <div class="fw-bold" style="color: #334155;">${item.date}</div>
                                        <div class="small text-muted">${item.subjectName}</div>
                                    </div>
                                    <div style="${statusColor} font-weight: 600;">${item.status}</div>
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="text-center p-3 text-muted">No attendance records found for this date range.</div>';
                    }
                    $("#attendanceTimeline").html(html);
                } else {
                    $("#attendanceTimeline").html('<div class="text-center p-3 text-danger">Error loading data.</div>');
                }
            },
            error: function() {
                $("#attendanceTimeline").html('<div class="text-center p-3 text-danger">Failed to connect to server.</div>');
            }
        });
    };
});
</script>
</body>
</html>

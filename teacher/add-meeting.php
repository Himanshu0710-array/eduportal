<?php
include "../database-connect.php";
session_start();
if (!isset($_COOKIE['teacherId'])) {
    header("Location: login-teacher.php");
    exit;
}
include "teacher-dashboard-top.php";
include "teacher-dashboard-content.php";

$teacherId = $_COOKIE['teacherId'];

// Fetch teacher's subject details
$stmt = $conn->prepare("
    SELECT t.*, s.subjectName, s.subjectId, c.courseName, c.courseId, y.academicYearName, y.academicYearId
    FROM tblteacher t
    JOIN tblsubject s ON t.subjectId = s.subjectId
    JOIN tblcourse c ON s.courseId = c.courseId
    JOIN tblacademicyear y ON s.academicYearId = y.academicYearId
    WHERE t.teacherId = :teacherId
");
$stmt->bindParam(":teacherId", $teacherId);
$stmt->execute();
$teacherData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$teacherData) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Error: You must be assigned a subject to schedule meetings.</div></div>";
    include "teacher-dashboard-footer.php";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Schedule Meeting</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    background: #f5f7fb;
    font-family: 'Segoe UI', sans-serif;
}
.form-section {
    background: #fff;
    margin: 40px auto;
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    border-radius: 18px;
    padding: 30px;
    max-width: 700px;
}
.heading {
    text-align: center;
    border-bottom: 2px solid #eef2f6;
    margin-bottom: 25px;
    padding-bottom: 15px;
}
.submit-btn {
    border-radius: 12px;
    padding: 12px;
    font-weight: 600;
}
.info-box {
    background: #f0f6ff;
    border: 1px solid #dbeafe;
    border-radius: 12px;
    padding: 15px;
}
</style>
</head>
<body>
<div class="container py-4">
    <div class="form-section">
        <form action="add-meeting-process.php" method="POST">
            <div class="heading">
                <h3><i class="bi bi-calendar-plus text-primary me-2"></i>Schedule Meeting</h3>
                <p class="text-muted">Create a live classroom meeting room for your students</p>
            </div>

            <!-- Pre-filled Teacher/Class Info (Read-only) -->
            <div class="info-box mb-4">
                <h6 class="text-primary mb-2"><i class="bi bi-info-circle-fill me-1"></i> Class Information</h6>
                <div class="row g-2">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Subject</small>
                        <strong><?php echo htmlspecialchars($teacherData['subjectName']); ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Course</small>
                        <strong><?php echo htmlspecialchars($teacherData['courseName']); ?></strong>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <small class="text-muted d-block">Academic Year</small>
                        <strong><?php echo htmlspecialchars($teacherData['academicYearName']); ?></strong>
                    </div>
                </div>
                <!-- Hidden inputs to submit alongside the meeting -->
                <input type="hidden" name="subjectId" value="<?php echo $teacherData['subjectId']; ?>">
                <input type="hidden" name="courseId" value="<?php echo $teacherData['courseId']; ?>">
                <input type="hidden" name="academicYearId" value="<?php echo $teacherData['academicYearId']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Meeting Title</b></label>
                <input type="text" class="form-control" name="meetingTitle" placeholder="e.g. Chapter 4: Array Functions" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Description (Optional)</b></label>
                <textarea class="form-control" name="meetingDescription" rows="3" placeholder="Brief outline of the meeting topics..."></textarea>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label"><b>Meeting Date</b></label>
                    <input type="date" class="form-control" name="meetingDate" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><b>Meeting Time</b></label>
                    <input type="time" class="form-control" name="meetingTime" value="<?php echo date('H:i'); ?>" required>
                </div>
            </div>

            <div class="d-flex gap-3">
                <a href="meeting-teacher.php" class="btn btn-light flex-fill py-2" style="border-radius:12px;">Cancel</a>
                <button type="submit" class="btn btn-primary submit-btn flex-fill">Create Meeting</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
include "teacher-dashboard-footer.php";
?>

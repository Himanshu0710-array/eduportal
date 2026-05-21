<?php
include_once "../database-connect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['teacherId']) && !isset($_COOKIE['teacherId'])) {
    header("Location: login-teacher.php");
    exit;
}
include "teacher-dashboard-top.php";
include "teacher-dashboard-content.php";

$teacherId = isset($_SESSION['teacherId']) ? $_SESSION['teacherId'] : htmlspecialchars($_COOKIE['teacherId']);

// 1. Fetch Stats
// Total meetings scheduled by this teacher
$statsQuery1 = $conn->prepare("SELECT COUNT(*) FROM tblmeetings WHERE teacherId = :teacherId");
$statsQuery1->bindParam(":teacherId", $teacherId);
$statsQuery1->execute();
$totalMeetings = $statsQuery1->fetchColumn();

// Meetings scheduled today by this teacher
$statsQuery2 = $conn->prepare("SELECT COUNT(*) FROM tblmeetings WHERE teacherId = :teacherId AND meetingDate = CURDATE()");
$statsQuery2->bindParam(":teacherId", $teacherId);
$statsQuery2->execute();
$todayMeetings = $statsQuery2->fetchColumn();

// 2. Fetch Scheduled Meetings list
$meetingsQuery = $conn->prepare("
    SELECT m.*, s.subjectName, c.courseName, y.academicYearName 
    FROM tblmeetings m 
    JOIN tblsubject s ON m.subjectId = s.subjectId 
    JOIN tblcourse c ON m.courseId = c.courseId 
    JOIN tblacademicyear y ON m.academicYearId = y.academicYearId 
    WHERE m.teacherId = :teacherId 
    ORDER BY m.meetingDate ASC, m.meetingTime ASC
");
$meetingsQuery->bindParam(":teacherId", $teacherId);
$meetingsQuery->execute();
$scheduledMeetings = $meetingsQuery->fetchAll(PDO::FETCH_ASSOC);

// Generate a random room ID for instant meetings
$instantRoomId = "room_inst_" . bin2hex(random_bytes(4));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Meeting Room</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    background: #f5f7fb;
    font-family: 'Segoe UI', sans-serif;
}
.page-title { font-weight: 600; }
a { text-decoration: none !important; }

.card-ui,
.stat-card,
.meeting-card,
.info-panel,
.quick-tile {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}
.quick-tile {
    padding: 22px;
    text-align: center;
    transition: 0.3s;
}
.quick-tile:hover { transform: translateY(-4px); }
.quick-icon { font-size: 30px; margin-bottom: 6px; }
.quick-title { font-weight: 600; }

.zoom-btn {
    border-radius: 14px;
    padding: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: 0.25s;
}
.zoom-btn-primary {
    background: #2563eb;
    color: #fff;
}
.zoom-btn-primary:hover {
    background: #1e40af;
    color: #fff;
    transform: translateY(-2px);
}
.zoom-btn-secondary {
    background: #10b981;
    color: #fff;
}
.zoom-btn-secondary:hover {
    background: #047857;
    color: #fff;
    transform: translateY(-2px);
}
.meeting-card { padding: 18px; transition: 0.3s; }
.meeting-card:hover { transform: translateY(-4px); }
.meeting-title { font-weight: 600; }
.meeting-time {
    background: #eef3ff;
    color: #2563eb;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
}
.status {
    font-size: 12px;
    padding: 6px 14px;
    border-radius: 20px;
}
.status-live { background: #dcfce7; color: #166534; }
.status-upcoming { background: #e0f2fe; color: #0369a1; }

.info-panel { padding: 20px; text-align: center; }
.clock {
    font-size: 34px;
    font-weight: 700;
    color: #1e40af;
}
.date-text { color: #64748b; font-size: 14px; }
.stat-card {
    padding: 18px;
    text-align: center;
    background: linear-gradient(135deg, #e0e7ff, #eef2ff);
}
.stat-card h3 { margin: 0; font-weight: 700; color: #1e3a8a; }
.stat-card span { font-size: 13px; color: #475569; }
</style>
</head>
<body>
<div class="container-fluid py-4">
<div class="row">

<!-- LEFT -->
<div class="col-lg-8">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title">👨‍🏫 Teacher Meeting Room</h4>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Meeting scheduled successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Meeting deleted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- QUICK ACTIONS -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <a href="../webrtc-room.php?room=<?php echo $instantRoomId; ?>&role=teacher" target="_blank">
                <div class="quick-tile">
                    <div class="quick-icon text-primary">
                        <i class="bi bi-camera-video-fill"></i>
                    </div>
                    <div class="quick-title">Start</div>
                    <small class="text-muted">Instant meeting</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="add-meeting.php">
                <div class="quick-tile">
                    <div class="quick-icon text-success">
                        <i class="bi bi-calendar-plus"></i>
                    </div>
                    <div class="quick-title">Schedule</div>
                    <small class="text-muted">Add meeting</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="quick-tile">
                <div class="quick-icon text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="quick-title">History</div>
                <small class="text-muted">Past sessions</small>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="stat-card">
                <h3><?php echo $totalMeetings; ?></h3>
                <span>Total Meetings</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <h3><?php echo $todayMeetings; ?></h3>
                <span>Meetings Today</span>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="row mb-4 g-3">
        <div class="col-md-6">
            <a href="../webrtc-room.php?room=<?php echo $instantRoomId; ?>&role=teacher"
                target="_blank"
                class="zoom-btn zoom-btn-primary">
                <i class="bi bi-camera-video-fill"></i> Start Instant Meeting
            </a>
        </div>
        <div class="col-md-6">
            <a href="add-meeting.php" class="zoom-btn zoom-btn-secondary">
                <i class="bi bi-calendar-plus"></i> Schedule Meeting
            </a>
        </div>
    </div>

    <!-- SCHEDULED -->
    <h5 class="mb-3">
        <i class="bi bi-calendar-event text-primary me-2"></i>
        Scheduled Meetings
    </h5>

    <div class="row g-3">
        <?php if (empty($scheduledMeetings)): ?>
            <div class="col-12">
                <div class="alert alert-light text-center border py-4">
                    <i class="bi bi-calendar-x fs-2 text-muted d-block mb-2"></i>
                    No meetings scheduled yet. Click <strong>Schedule Meeting</strong> to create one.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($scheduledMeetings as $meeting): 
                $mDate = strtotime($meeting['meetingDate']);
                $formattedDate = date('d M', $mDate);
                $formattedTime = date('h:i A', strtotime($meeting['meetingTime']));
                $isToday = (date('Y-m-d', $mDate) === date('Y-m-d'));
                $statusClass = $isToday ? "status-live" : "status-upcoming";
                $statusText = $isToday ? "Today" : "Upcoming";
            ?>
            <div class="col-md-6">
                <div class="meeting-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="meeting-title text-wrap"><?php echo htmlspecialchars($meeting['meetingTitle']); ?></div>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-book-half"></i> <?php echo htmlspecialchars($meeting['subjectName']); ?>
                                </small>
                                <small class="text-muted d-block">
                                    <i class="bi bi-people-fill"></i> <?php echo htmlspecialchars($meeting['courseName']) . " - " . htmlspecialchars($meeting['academicYearName']); ?>
                                </small>
                            </div>
                            <span class="status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                        </div>
                        <?php if(!empty($meeting['meetingDescription'])): ?>
                            <p class="text-muted mt-2 mb-0" style="font-size: 0.85rem;"><?php echo htmlspecialchars($meeting['meetingDescription']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mt-3">
                        <div class="meeting-time"><?php echo $formattedDate; ?> • <?php echo $formattedTime; ?></div>
                        <div class="row g-2 mt-2">
                            <div class="col-8">
                                <a href="../webrtc-room.php?room=<?php echo htmlspecialchars($meeting['meetingRoomId']); ?>&role=teacher"
                                   target="_blank"
                                   class="btn btn-primary w-100 btn-sm" style="border-radius:10px;">
                                    <i class="bi bi-play-circle"></i> Start
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="delete-meeting.php?id=<?php echo $meeting['meetingId']; ?>"
                                   onclick="return confirm('Are you sure you want to delete this meeting?');"
                                   class="btn btn-outline-danger w-100 btn-sm" style="border-radius:10px;">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- RIGHT -->
<div class="col-lg-4 mt-4 mt-lg-0">
    <div class="info-panel mb-4">
        <div class="clock" id="clock"></div>
        <div class="date-text" id="date"></div>
    </div>

    <div class="info-panel">
        <i class="bi bi-info-circle fs-1 text-muted"></i>
        <p class="text-muted mt-2 mb-0">
            You can start or schedule meetings anytime
        </p>
    </div>
</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateClock() {
    const now = new Date();
    document.getElementById("clock").innerText =
        now.toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' });
    document.getElementById("date").innerText =
        now.toLocaleDateString(undefined, {
            weekday:'long',
            year:'numeric',
            month:'long',
            day:'numeric'
        });
}
setInterval(updateClock, 1000);
updateClock();
</script>
</body>
</html>

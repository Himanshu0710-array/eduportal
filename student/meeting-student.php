<?php
include_once "../database-connect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['studentId']) && !isset($_COOKIE['studentId'])) {
    header("Location: login-student.php");
    exit;
}
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$studentId = isset($_SESSION['studentId']) ? $_SESSION['studentId'] : htmlspecialchars($_COOKIE['studentId']);

// 1. Fetch Student Class Details
$studentQuery = $conn->prepare("SELECT courseId, academicYearId FROM tblstudent WHERE studentId = :studentId");
$studentQuery->bindParam(":studentId", $studentId);
$studentQuery->execute();
$studentData = $studentQuery->fetch(PDO::FETCH_ASSOC);

$totalMeetings = 0;
$todayMeetings = 0;
$studentMeetings = [];

if ($studentData) {
    $courseId = $studentData['courseId'];
    $academicYearId = $studentData['academicYearId'];

    // 2. Fetch Stats
    // Total upcoming meetings
    $statsQuery1 = $conn->prepare("SELECT COUNT(*) FROM tblmeetings WHERE courseId = :courseId AND academicYearId = :academicYearId AND meetingDate >= CURDATE()");
    $statsQuery1->bindParam(":courseId", $courseId);
    $statsQuery1->bindParam(":academicYearId", $academicYearId);
    $statsQuery1->execute();
    $totalMeetings = $statsQuery1->fetchColumn();

    // Meetings today
    $statsQuery2 = $conn->prepare("SELECT COUNT(*) FROM tblmeetings WHERE courseId = :courseId AND academicYearId = :academicYearId AND meetingDate = CURDATE()");
    $statsQuery2->bindParam(":courseId", $courseId);
    $statsQuery2->bindParam(":academicYearId", $academicYearId);
    $statsQuery2->execute();
    $todayMeetings = $statsQuery2->fetchColumn();

    // 3. Fetch Scheduled Meetings list
    $meetingsQuery = $conn->prepare("
        SELECT m.*, s.subjectName, t.teacherName 
        FROM tblmeetings m 
        JOIN tblsubject s ON m.subjectId = s.subjectId 
        JOIN tblteacher t ON m.teacherId = t.teacherId 
        WHERE m.courseId = :courseId AND m.academicYearId = :academicYearId AND m.meetingDate >= CURDATE()
        ORDER BY m.meetingDate ASC, m.meetingTime ASC
    ");
    $meetingsQuery->bindParam(":courseId", $courseId);
    $meetingsQuery->bindParam(":academicYearId", $academicYearId);
    $meetingsQuery->execute();
    $studentMeetings = $meetingsQuery->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Meeting Room</title>
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
.action-card,
.meeting-card,
.info-panel,
.stat-card,
.quick-tile {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}
.quick-tile {
    padding: 20px;
    text-align: center;
    transition: 0.3s;
}
.quick-tile:hover { transform: translateY(-4px); }
.quick-icon { font-size: 28px; margin-bottom: 8px; }
.quick-title { font-weight: 600; }

.action-card { padding: 25px; }
.join-input {
    border-radius: 30px;
    padding: 12px 20px;
}
.join-btn {
    border-radius: 30px;
    padding: 12px;
    background: #2563eb;
    color: #fff;
    border: none;
    font-weight: 600;
}
.join-btn:hover {
    background: #1e40af;
    color: #fff;
}
.meeting-card { padding: 18px; transition: 0.3s; }
.meeting-card:hover { transform: translateY(-4px); }
.meeting-title { font-weight: 600; }
.badge-time {
    background: #eef3ff;
    color: #2563eb;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 13px;
}
.status-badge {
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
.stat-card h3 { font-weight: 700; color: #1e3a8a; margin: 0; }
.stat-card span { font-size: 13px; color: #475569; }
</style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">

        <!-- LEFT CONTENT -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="page-title">🎓 Student Meeting Room</h4>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="quick-tile" style="cursor: pointer;" onclick="document.getElementsByName('room')[0].focus();">
                        <div class="quick-icon text-primary">
                            <i class="bi bi-camera-video-fill"></i>
                        </div>
                        <div class="quick-title">Join</div>
                        <small class="text-muted">Enter meeting ID</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="quick-tile">
                        <div class="quick-icon text-success">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="quick-title">Schedule</div>
                        <small class="text-muted">View meetings</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="quick-tile">
                        <div class="quick-icon text-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="quick-title">History</div>
                        <small class="text-muted">Past classes</small>
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

            <!-- JOIN MEETING -->
            <div class="action-card mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-camera-video-fill text-primary me-2"></i>
                    Join a Meeting
                </h5>
                <form action="../webrtc-room.php" method="GET" target="_blank">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <input type="text" name="room" class="form-control join-input" placeholder="Enter Meeting ID (e.g. room_xxxxxx)" required>
                            <input type="hidden" name="role" value="student">
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="join-btn">Join Meeting</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- SCHEDULED -->
            <h5 class="mb-3">
                <i class="bi bi-calendar-event text-primary me-2"></i>
                Scheduled Meetings
            </h5>

            <div class="row g-3">
                <?php if (empty($studentMeetings)): ?>
                    <div class="col-12">
                        <div class="alert alert-light text-center border py-4">
                            <i class="bi bi-calendar-x fs-2 text-muted d-block mb-2"></i>
                            No classes or meetings scheduled for your course.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($studentMeetings as $meeting): 
                        $mDate = strtotime($meeting['meetingDate']);
                        $formattedDate = date('d M', $mDate);
                        $formattedTime = date('h:i A', strtotime($meeting['meetingTime']));
                        $isToday = (date('Y-m-d', $mDate) === date('Y-m-d'));
                        $statusClass = $isToday ? "status-live" : "status-upcoming";
                        $statusText = $isToday ? "Live" : "Upcoming";
                    ?>
                    <!-- MEETING -->
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
                                            <i class="bi bi-person-fill"></i> <?php echo htmlspecialchars($meeting['teacherName']); ?>
                                        </small>
                                    </div>
                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </div>
                                <?php if(!empty($meeting['meetingDescription'])): ?>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 0.85rem;"><?php echo htmlspecialchars($meeting['meetingDescription']); ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="mt-3">
                                <div class="badge-time"><?php echo $formattedDate; ?> • <?php echo $formattedTime; ?></div>
                                <div class="d-grid mt-2">
                                    <a href="../webrtc-room.php?room=<?php echo htmlspecialchars($meeting['meetingRoomId']); ?>&role=student"
                                        target="_blank"
                                        class="join-btn text-center py-2" style="font-size:0.9rem;">
                                            <i class="bi bi-camera-video"></i> Join Meeting
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="info-panel mb-4">
                <div class="clock" id="clock"></div>
                <div class="date-text" id="date"></div>
            </div>

            <div class="info-panel">
                <i class="bi bi-calendar-check fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Check back regularly for updates to your classroom schedule.</p>
            </div>
        </div>

    </div>
</div>

<!-- CHATBOT -->
<a href="../hayatWorking/index.php" class="chatbot-btn" title="Chat with AI Assistant">
    <div class="chatbot-icon-wrapper">
        <i class="bi bi-chat-dots-fill"></i>
        <span class="chatbot-badge">AI</span>
    </div>
</a>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateClock() {
    const now = new Date();
    document.getElementById("clock").innerText =
        now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
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

<style>
/* CHATBOT */
.chatbot-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chatbot-badge {
    position: absolute;
    bottom: 0;
    right: 0;
    background: #22c55e;
    color: white;
    font-size: 10px;
    border-radius: 50%;
    padding: 2px 5px;
}
</style>
</body>
</html>

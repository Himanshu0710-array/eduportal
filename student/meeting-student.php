<?php
include "../database-connect.php";
session_start();
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Meeting Room</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f5f7fb;
    font-family: 'Segoe UI', sans-serif;
}

/* ===== COMMON ===== */
.page-title {
    font-weight: 600;
}

a {
    text-decoration: none !important;
}

/* ===== CARDS ===== */
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

/* ===== QUICK ACTIONS (ZOOM STYLE) ===== */
.quick-tile {
    padding: 20px;
    text-align: center;
    transition: 0.3s;
}

.quick-tile:hover {
    transform: translateY(-4px);
}

.quick-icon {
    font-size: 28px;
    margin-bottom: 8px;
}

.quick-title {
    font-weight: 600;
}

/* ===== JOIN SECTION ===== */
.action-card {
    padding: 25px;
}

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

/* ===== MEETINGS ===== */
.meeting-card {
    padding: 18px;
    transition: 0.3s;
}

.meeting-card:hover {
    transform: translateY(-4px);
}

.meeting-title {
    font-weight: 600;
}

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

.status-live {
    background: #dcfce7;
    color: #166534;
}

.status-upcoming {
    background: #e0f2fe;
    color: #0369a1;
}

/* ===== RIGHT PANEL ===== */
.info-panel {
    padding: 20px;
    text-align: center;
}

.clock {
    font-size: 34px;
    font-weight: 700;
    color: #1e40af;
}

.date-text {
    color: #64748b;
    font-size: 14px;
}

/* ===== STATS ===== */
.stat-card {
    padding: 18px;
    text-align: center;
    background: linear-gradient(135deg, #e0e7ff, #eef2ff);
}

.stat-card h3 {
    font-weight: 700;
    color: #1e3a8a;
    margin: 0;
}

.stat-card span {
    font-size: 13px;
    color: #475569;
}
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

            <!-- QUICK ACTIONS (LIKE ZOOM TOP BAR) -->
            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <a href="../webrtc-room.php?room=ROOM_TEST_1&role=student"
                        target="_blank">
                        <div class="quick-tile">
                            <div class="quick-icon text-primary">
                                <i class="bi bi-camera-video-fill"></i>
                            </div>
                            <div class="quick-title">Join</div>
                            <small class="text-muted">Enter meeting ID</small>
                        </div>
                    </a>
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
                        <h3>4</h3>
                        <span>Total Meetings</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <h3>1</h3>
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

                <form>
                    <div class="row g-3">
                        <div class="col-md-9">
                            <input type="text" class="form-control join-input" placeholder="Enter Meeting ID">
                        </div>
                        <div class="col-md-3 d-grid">
                            <a href="../webrtc-room.php?room=ROOM_TEST_1&role=student"
                                target="_blank"
                                class="join-btn">
                                Join Meeting
                            </a>


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

                <!-- MEETING -->
                <div class="col-md-6">
                    <div class="meeting-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="meeting-title">Data Structures Lecture</div>
                                <small class="text-muted">
                                    <i class="bi bi-person-fill"></i> Prof. Sharma
                                </small>
                            </div>
                            <span class="status-badge status-live">Live</span>
                        </div>

                        <div class="badge-time mt-2">16 Dec • 8:30 PM</div>

                        <div class="d-grid mt-3">
                            <a href="../webrtc-room.php?room=ROOM_TEST_1"
                                target="_blank"
                                class="join-btn text-center">
                                    <i class="bi bi-camera-video"></i> Join Meeting
                            </a>

                        </div>
                    </div>
                </div>

                <!-- MEETING -->
                <div class="col-md-6">
                    <div class="meeting-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="meeting-title">Operating Systems Class</div>
                                <small class="text-muted">
                                    <i class="bi bi-person-fill"></i> Dr. Mehta
                                </small>
                            </div>
                            <span class="status-badge status-upcoming">Upcoming</span>
                        </div>

                        <div class="badge-time mt-2">17 Dec • 10:00 AM</div>

                        <div class="d-grid mt-3">
                            <a href="../webrtc-room.php?room=ROOM_TEST_1"
                                target="_blank"
                                class="join-btn text-center">
                                    <i class="bi bi-camera-video"></i> Join Meeting
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="info-panel mb-4">
                <div class="clock" id="clock"></div>
                <div class="date-text" id="date"></div>
            </div>

            <div class="info-panel">
                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No more meetings today</p>
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

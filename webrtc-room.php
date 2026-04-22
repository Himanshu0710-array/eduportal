<?php
session_start();
if (!isset($_GET['room'])) {
    die("Room ID missing");
}
$roomId = $_GET['room'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Live Meeting</title>
    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --primary: #3b82f6;
            --danger: #ef4444;
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header-bar {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        h2 { margin: 0; font-weight: 600; font-size: 1.2rem; }
        
        .status-container {
            display: flex;
            gap: 10px;
        }
        .video-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            width: 100%;
            max-width: 1400px;
            margin-bottom: 100px; /* Space for footer */
        }
        .video-card {
            width: 480px;
            height: 360px; /* 4:3 Aspect Ratio */
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.2s;
        }
        .video-card:hover { border-color: rgba(255,255,255,0.3); }
        
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .controls-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(30, 30, 30, 0.8);
            backdrop-filter: blur(12px);
            padding: 12px 24px;
            border-radius: 50px;
            display: flex;
            gap: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.1);
            z-index: 1000;
        }
        
        .btn-control {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn-control:hover { transform: scale(1.1); }
        .btn-secondary { background: #333; color: white; }
        .btn-secondary:hover { background: #444; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #d32f2f; }
    </style>
</head>
<body>

<!-- LOBBY SCREEN -->
<div id="lobby-screen" style="position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: #121212; z-index: 2000; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <h2 class="mb-4">Ready to join?</h2>
    
    <div style="width: 640px; height: 480px; background: black; border-radius: 16px; overflow: hidden; position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
        <video id="lobbyVideo" autoplay muted playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 15px;">
            <button id="btn-lobby-audio" class="btn-control btn-secondary"><i class="bi bi-mic-fill"></i></button>
            <button id="btn-lobby-video" class="btn-control btn-secondary"><i class="bi bi-camera-video-fill"></i></button>
        </div>
    </div>

    <div class="mt-4" style="display: flex; gap: 15px;">
        <input type="text" id="username-input" class="form-control" placeholder="Enter your name" style="width: 300px; font-size: 1.2rem;">
        <button id="btn-join" class="btn btn-primary" style="font-size: 1.2rem; padding: 0 30px;">Join Now</button>
    </div>
</div>

<div class="header-bar" id="main-interface" style="display: none;">
    <h2>Live Classroom</h2>
    <div class="status-container">
        <div id="connection-status" class="badge bg-secondary">Connecting...</div>
        <div id="audio-status" class="badge bg-secondary">Checking Audio...</div>
        <!-- Visualizer Hidden but working -->
        <canvas id="audio-meter" width="50" height="20" style="display:none;"></canvas> 
    </div>
</div>

<div id="video-grid" class="video-grid">
    <div class="video-card">
        <video id="localVideo" autoplay muted playsinline></video>
        <div class="user-badge"><i class="bi bi-person-fill"></i> You</div>
    </div>
</div>

<div class="controls-bar">
    <button id="btn-audio" class="btn-control btn-secondary">
        <i class="bi bi-mic-fill"></i>
    </button>
    
    <button class="btn-control btn-danger" onclick="leaveMeeting()">
        <i class="bi bi-telephone-x-fill"></i>
    </button>

    <button id="btn-video" class="btn-control btn-secondary">
        <i class="bi bi-camera-video-fill"></i>
    </button>
</div>

<?php

$roomId = $_GET['room'] ?? '';
$role = $_GET['role'] ?? 'student'; // default
?>

<script>
const ROOM_ID = "<?php echo $roomId; ?>";
const ROLE = "<?php echo $role; ?>"; // teacher | student
</script>


<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script src="webrtc.js?v=<?php echo time(); ?>"></script>

</body>
</html>

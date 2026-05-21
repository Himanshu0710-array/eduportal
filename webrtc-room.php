<?php
session_start();
if (!isset($_GET['room'])) {
    die("Room ID missing");
}
$roomId = $_GET['room'];
$role = $_GET['role'] ?? 'student'; // default
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
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Prevent body scroll */
        }
        
        /* Layout */
        .app-container {
            display: flex;
            flex: 1;
            height: 100%;
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
            transition: all 0.3s;
        }
        .chat-panel {
            width: 350px;
            background: var(--card-bg);
            border-left: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            transform: translateX(0);
            transition: transform 0.3s ease;
        }
        
        /* Mobile Chat Overlay */
        @media (max-width: 768px) {
            .chat-panel {
                position: fixed;
                top: 0;
                right: 0;
                height: 100%;
                z-index: 1500;
                transform: translateX(100%);
                box-shadow: -5px 0 15px rgba(0,0,0,0.5);
            }
            .chat-panel.active {
                transform: translateX(0);
            }
            .main-content {
                padding: 10px;
                padding-bottom: 120px;
            }
            .video-card {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 4/3;
            }
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chat-msg {
            background: rgba(255,255,255,0.05);
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.9rem;
            max-width: 90%;
            word-wrap: break-word;
        }
        .chat-msg.self {
            background: var(--primary);
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }
        .chat-msg.other {
            align-self: flex-start;
            border-bottom-left-radius: 2px;
        }
        .msg-sender {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 4px;
            display: block;
        }
        .chat-msg.self .msg-sender {
            color: rgba(255,255,255,0.7);
        }
        .chat-input-area {
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            gap: 10px;
        }
        .chat-input {
            flex: 1;
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 20px;
            outline: none;
        }
        .chat-send-btn {
            background: var(--primary);
            border: none;
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Header */
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
        
        /* Video Grid */
        .video-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            width: 100%;
            max-width: 1400px;
            margin-bottom: 120px;
        }
        .video-card {
            width: 400px;
            height: 300px;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.2s;
        }
        
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

        .hand-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #eab308;
            color: #000;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 1.2rem;
            display: none; /* Hidden by default */
            animation: bounce 1s infinite alternate;
        }
        @keyframes bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-5px); }
        }

        /* Controls */
        .controls-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(30, 30, 30, 0.85);
            backdrop-filter: blur(12px);
            padding: 12px 24px;
            border-radius: 50px;
            display: flex;
            gap: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.1);
            z-index: 1000;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn-control {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 18px;
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
        .btn-primary { background: var(--primary); color: white; }
        .btn-warning { background: #eab308; color: black; }
        
        /* Lobby */
        #lobby-screen {
            position: fixed; top: 0; left: 0; width: 100%; height: 100vh; 
            background: #121212; z-index: 2000; 
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .lobby-video-container {
            width: 640px; height: 480px; background: black; border-radius: 16px; 
            overflow: hidden; position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            max-width: 90vw;
        }
        @media (max-width: 768px) {
            .lobby-video-container { height: 60vh; }
        }
    </style>
</head>
<body>

<!-- LOBBY SCREEN -->
<div id="lobby-screen">
    <h2 class="mb-4">Ready to join?</h2>
    
    <div class="lobby-video-container">
        <video id="lobbyVideo" autoplay muted playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 15px;">
            <button id="btn-lobby-audio" class="btn-control btn-secondary"><i class="bi bi-mic-fill"></i></button>
            <button id="btn-lobby-video" class="btn-control btn-secondary"><i class="bi bi-camera-video-fill"></i></button>
        </div>
    </div>

    <div class="mt-4" style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
        <input type="text" id="username-input" class="form-control" placeholder="Enter your name" style="width: 250px; font-size: 1.1rem;">
        <button id="btn-join" class="btn btn-primary" style="font-size: 1.1rem; padding: 0 30px; border-radius: 30px;">Join Now</button>
    </div>
</div>

<div class="app-container" id="main-interface" style="display: none;">
    <!-- LEFT: VIDEO AREA -->
    <div class="main-content">
        <div class="header-bar">
            <h2>Live Classroom</h2>
            <div class="status-container">
                <div id="connection-status" class="badge bg-secondary">Connecting...</div>
                <div id="audio-status" class="badge bg-secondary">Checking Audio...</div>
                <canvas id="audio-meter" width="50" height="20" style="display:none;"></canvas> 
            </div>
        </div>

        <div id="video-grid" class="video-grid">
            <div class="video-card">
                <video id="localVideo" autoplay muted playsinline></video>
                <div class="hand-badge" id="local-hand">✋</div>
                <div class="user-badge"><i class="bi bi-person-fill"></i> You</div>
            </div>
        </div>
    </div>

    <!-- RIGHT: CHAT PANEL -->
    <div class="chat-panel" id="chat-panel">
        <div class="chat-header">
            <span>Live Chat</span>
            <button class="btn-close btn-close-white d-md-none" onclick="toggleChat()"></button>
        </div>
        <div class="chat-messages" id="chat-messages">
            <div class="text-center text-muted small mt-2">Welcome to the chat!</div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="chat-input" class="chat-input" placeholder="Type a message..." onkeypress="if(event.key === 'Enter') sendChat()">
            <button class="chat-send-btn" onclick="sendChat()"><i class="bi bi-send-fill"></i></button>
        </div>
    </div>
</div>

<!-- FLOATING CONTROLS -->
<div class="controls-bar" id="controls-bar" style="display: none;">
    <!-- Audio / Video -->
    <button id="btn-audio" class="btn-control btn-secondary" title="Toggle Mic">
        <i class="bi bi-mic-fill"></i>
    </button>
    <button id="btn-video" class="btn-control btn-secondary" title="Toggle Camera">
        <i class="bi bi-camera-video-fill"></i>
    </button>
    
    <!-- Camera Switch (Mobile) -->
    <button id="btn-switch-cam" class="btn-control btn-secondary" title="Flip Camera" onclick="switchCamera()">
        <i class="bi bi-arrow-repeat"></i>
    </button>

    <!-- Raise Hand -->
    <button id="btn-hand" class="btn-control btn-secondary" title="Raise Hand" onclick="toggleHand()">
        <i class="bi bi-hand-index-thumb"></i>
    </button>

    <!-- Teacher Only: Mute All -->
    <?php if ($role === 'teacher'): ?>
    <button id="btn-mute-all" class="btn-control btn-danger" title="Mute All Students" onclick="if(confirm('Mute all students?')) { socket.emit('mute-all', ROOM_ID); }">
        <i class="bi bi-mic-mute"></i>
    </button>
    <?php endif; ?>
    
    <!-- Chat Toggle -->
    <button id="btn-chat-toggle" class="btn-control btn-primary d-md-none" title="Toggle Chat" onclick="toggleChat()">
        <i class="bi bi-chat-dots-fill"></i>
    </button>

    <!-- Leave -->
    <button class="btn-control btn-danger" onclick="leaveMeeting()" title="Leave Meeting">
        <i class="bi bi-telephone-x-fill"></i>
    </button>
</div>

<script>
const ROOM_ID = "<?php echo $roomId; ?>";
const ROLE = "<?php echo $role; ?>"; 

function toggleChat() {
    const panel = document.getElementById('chat-panel');
    panel.classList.toggle('active');
}
</script>

<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script src="webrtc.js?v=<?php echo time(); ?>"></script>

</body>
</html>

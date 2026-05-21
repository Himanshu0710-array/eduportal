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
            background: linear-gradient(135deg, #0f172a, #1e293b, #0f172a);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            height: 100vh;
            height: 100dvh;
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
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 350px;
            z-index: 1500;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(15px);
            border-left: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            transform: translateX(100%); /* Hidden by default */
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -10px 0 30px rgba(0,0,0,0.5);
        }
        .chat-panel.active {
            transform: translateX(0); /* Show when active */
        }
        
        /* Mobile Overrides */
        @media (max-width: 768px) {
            .chat-panel {
                width: 100%;
            }
            .main-content {
                padding: 10px;
                padding-bottom: 120px;
            }
            .video-card {
                width: 100% !important;
                height: auto !important;
                border-radius: 12px;
            }
            
            /* Make controls scrollable horizontally on mobile */
            .controls-bar {
                width: 95%;
                border-radius: 40px;
                padding: 10px 15px;
                justify-content: flex-start;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                background: rgba(15, 23, 42, 0.9);
            }
            .controls-bar::-webkit-scrollbar {
                display: none;
            }
            .btn-control {
                min-width: 48px;
                height: 48px;
                font-size: 20px;
            }
        }

        .chat-header {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        /* Fix the Bootstrap close button in dark mode */
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: 0.8;
            cursor: pointer;
        }
        .btn-close-white:hover { opacity: 1; }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .chat-msg {
            background: rgba(255,255,255,0.08);
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 0.95rem;
            max-width: 85%;
            word-wrap: break-word;
            line-height: 1.4;
        }
        .chat-msg.self {
            background: var(--primary);
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        .chat-msg.other {
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        .msg-sender {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .chat-msg.self .msg-sender {
            color: rgba(255,255,255,0.8);
        }
        .chat-input-area {
            background: rgba(15, 23, 42, 1);
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            gap: 12px;
            z-index: 10;
        }
        .chat-input {
            flex: 1;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 12px 18px;
            border-radius: 25px;
            outline: none;
            font-size: 1rem;
            transition: border 0.2s;
        }
        .chat-input:focus { border-color: var(--primary); }
        .chat-send-btn {
            background: var(--primary);
            border: none;
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* Header */
        .header-bar {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
        }
        h2 { margin: 0; font-weight: 600; font-size: 1.2rem; letter-spacing: 0.5px; }
        
        .status-container {
            display: flex;
            gap: 10px;
        }
        
        /* Video Grid */
        .video-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            width: 100%;
            max-width: 1400px;
            margin-bottom: 120px;
        }
        .video-card {
            width: 420px;
            height: 315px;
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .video-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.6); }
        
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-badge {
            position: absolute;
            bottom: 16px;
            left: 16px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .hand-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #eab308;
            color: #000;
            padding: 6px 12px;
            border-radius: 14px;
            font-size: 1.3rem;
            display: none; /* Hidden by default */
            animation: bounce 1s infinite alternate;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.4);
        }

        .media-status-badges {
            position: absolute;
            top: 16px;
            left: 16px;
            display: flex;
            gap: 8px;
            z-index: 5;
        }
        
        .media-badge {
            background: rgba(220, 38, 38, 0.9);
            backdrop-filter: blur(4px);
            color: white;
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 1rem;
            display: none; /* Hidden by default */
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .allow-btn {
            position: absolute;
            top: 16px;
            right: 65px;
            background: #22c55e;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 600;
            display: none; /* Hidden by default */
            cursor: pointer;
            z-index: 5;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
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
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            padding: 12px 24px;
            border-radius: 50px;
            display: flex;
            gap: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.08);
            z-index: 1000;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn-control {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            flex-shrink: 0;
        }
        .btn-control:hover { transform: scale(1.1) translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.3); }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.05); }
        .btn-secondary:hover { background: rgba(255,255,255,0.2); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: #2563eb; }
        .btn-warning { background: #eab308; color: black; }
        
        /* Lobby */
        #lobby-screen {
            position: fixed; top: 0; left: 0; width: 100%; height: 100vh; 
            background: linear-gradient(135deg, #0f172a, #1e293b, #0f172a); z-index: 2000; 
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .lobby-video-container {
            width: 640px; height: 480px; background: black; border-radius: 24px; 
            overflow: hidden; position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            max-width: 90vw;
            border: 1px solid rgba(255,255,255,0.1);
        }
        @media (max-width: 768px) {
            .lobby-video-container { height: 60vh; }
        }
    </style>
</head>
<body>

<!-- LOBBY SCREEN -->
<div id="lobby-screen">
    <h2 class="mb-4" style="font-size: 1.8rem; font-weight: 600;">Ready to join?</h2>
    
    <div class="lobby-video-container">
        <video id="lobbyVideo" autoplay muted playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 15px;">
            <button id="btn-lobby-audio" class="btn-control btn-secondary"><i class="bi bi-mic-fill"></i></button>
            <button id="btn-lobby-video" class="btn-control btn-secondary"><i class="bi bi-camera-video-fill"></i></button>
        </div>
    </div>

    <div class="mt-4" style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
        <input type="text" id="username-input" class="form-control" placeholder="Enter your name" style="width: 250px; font-size: 1.1rem; border-radius: 12px; background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2);">
        <button id="btn-join" class="btn btn-primary" style="font-size: 1.1rem; padding: 0 30px; border-radius: 12px; font-weight: 600;">Join Now</button>
    </div>
</div>

<div class="app-container" id="main-interface" style="display: none;">
    <!-- VIDEO AREA -->
    <div class="main-content">
        <div class="header-bar">
            <h2>Live Classroom</h2>
            <div class="status-container">
                <div id="connection-status" class="badge bg-secondary" style="font-size: 0.9rem; padding: 8px 12px; border-radius: 8px;">Connecting...</div>
                <div id="audio-status" class="badge bg-secondary" style="font-size: 0.9rem; padding: 8px 12px; border-radius: 8px;">Checking Audio...</div>
                <canvas id="audio-meter" width="50" height="20" style="display:none;"></canvas> 
            </div>
        </div>

        <div id="video-grid" class="video-grid">
            <div class="video-card">
                <video id="localVideo" autoplay muted playsinline></video>
                <div class="hand-badge" id="local-hand">✋</div>
                <div class="user-badge"><i class="bi bi-person-fill"></i> You</div>
                <div class="media-status-badges">
                    <div class="media-badge local-mute-badge" title="Microphone Off"><i class="bi bi-mic-mute-fill"></i></div>
                    <div class="media-badge local-cam-badge" title="Camera Off"><i class="bi bi-camera-video-off-fill"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- SLIDE-IN CHAT PANEL -->
    <div class="chat-panel" id="chat-panel">
        <div class="chat-header">
            <span>Live Chat</span>
            <button class="btn-close btn-close-white" onclick="toggleChat()"></button>
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
    <!-- Chat Toggle -->
    <button id="btn-chat-toggle" class="btn-control btn-primary" title="Toggle Chat" onclick="toggleChat()">
        <i class="bi bi-chat-dots-fill"></i>
    </button>

    <!-- Audio / Video -->
    <button id="btn-audio" class="btn-control btn-secondary" title="Toggle Mic">
        <i class="bi bi-mic-fill"></i>
    </button>
    <button id="btn-video" class="btn-control btn-secondary" title="Toggle Camera">
        <i class="bi bi-camera-video-fill"></i>
    </button>
    
    <!-- Camera Switch -->
    <button id="btn-switch-cam" class="btn-control btn-secondary" title="Flip Camera" onclick="switchCamera()">
        <i class="bi bi-arrow-repeat"></i>
    </button>

    <!-- Raise Hand -->
    <button id="btn-hand" class="btn-control btn-secondary" title="Raise Hand" onclick="toggleHand()">
        <i class="bi bi-hand-index-thumb"></i>
    </button>

    <!-- Teacher Only: Hard Mute All -->
    <?php if ($role === 'teacher'): ?>
    <button id="btn-hard-mute" class="btn-control btn-danger" style="background:#b91c1c;" title="Lock Student Microphones" onclick="if(confirm('Lock all student microphones?')) { socket.emit('hard-mute-all', ROOM_ID); }">
        <i class="bi bi-lock-fill"></i>
    </button>
    <?php endif; ?>
    
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

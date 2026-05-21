console.log("WebRTC Multi-User Loaded");

// Socket connection
const signalingUrl = (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1')
    ? `${window.location.protocol}//${window.location.hostname}:3000`
    : `https://eduportal-signal.onrender.com`;
const socket = io(signalingUrl);

// Connection Validation
socket.on("connect_error", (err) => {
    console.error("Socket Connection Error:", err);
    updateStatus("Server Unreachable (Firewall?)", "danger");
    if (!window.socketErrorShown) {
        alert("Cannot connect to Signaling Server at " + window.location.hostname + ":3000.\n\nPossible Causes:\n1. Firewall blocking Port 3000 on PC.\n2. Phone and PC on different Wi-Fi.\n3. Server not running.");
        window.socketErrorShown = true;
    }
});

const videoGrid = document.getElementById("video-grid");
const localVideo = document.getElementById("localVideo");
const lobbyVideo = document.getElementById("lobbyVideo"); // Lobby Preview
const lobbyScreen = document.getElementById("lobby-screen");
const mainInterface = document.getElementById("main-interface"); // Header
const controlsBar = document.querySelector(".controls-bar"); // Footer

// Default Hidden
if (mainInterface) mainInterface.style.display = "none";
if (videoGrid) videoGrid.style.display = "none";
if (controlsBar) controlsBar.style.display = "none";

let localStream;
const peers = {}; // Map: socketId -> RTCPeerConnection
let MY_NAME = "User";

// Status Helpers
const statusDiv = document.getElementById("connection-status");
const audioStatusDiv = document.getElementById("audio-status");

function updateStatus(msg, color) {
    if (statusDiv) {
        statusDiv.innerText = msg;
        statusDiv.className = `badge bg-${color} text-dark mb-3`;
    }
}

// 1. INITIALIZE LOBBY (Run Immediately)
// OPTIMIZED: Lower resolution/fps to fix lag on mobile/wifi
const constraints = {
    video: { width: 480, height: 360, frameRate: 15 },
    audio: true
};

if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    alert("CRITICAL ERROR: Camera access is blocked! (Use HTTPS or chrome://flags)");
    updateStatus("Camera Blocked", "danger");
} else {
    navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
            localStream = stream;

            // Show in Lobby
            if (lobbyVideo) lobbyVideo.srcObject = stream;

            // Ready for Main Room
            localVideo.srcObject = stream;

            // Check Audio tracks
            const audioTracks = stream.getAudioTracks();
            if (audioTracks.length > 0) {
                if (audioStatusDiv) {
                    audioStatusDiv.innerText = "Mic: " + audioTracks[0].label;
                    audioStatusDiv.className = "badge bg-success mb-3";
                }
            } else {
                if (audioStatusDiv) {
                    audioStatusDiv.innerText = "Mic: NONE FOUND";
                    audioStatusDiv.className = "badge bg-danger mb-3";
                }
            }

            // Visualizer
            visualizeAudio(stream);

            // Lobby Logic: Toggle Buttons
            setupLobbyControls();
        })
        .catch(err => {
            console.error("Media error:", err);
            updateStatus("Media Error", "danger");
            alert("Camera Error: " + err.name);
        });
}

function setupLobbyControls() {
    const btnAudio = document.getElementById("btn-lobby-audio");
    const btnVideo = document.getElementById("btn-lobby-video");

    if (btnAudio) {
        btnAudio.addEventListener("click", function () {
            toggleAudio(this);
        });
    }
    if (btnVideo) {
        btnVideo.addEventListener("click", function () {
            toggleVideo(this);
        });
    }
}

let isHardMuted = false;
function toggleAudio(btn) {
    if (!localStream) return;
    
    // Check if hard muted by teacher
    if (isHardMuted) {
        alert("You are hard muted by the teacher. Please raise your hand to speak.");
        return;
    }

    const track = localStream.getAudioTracks()[0];
    if (track) {
        track.enabled = !track.enabled;
        btn.innerHTML = track.enabled ? '<i class="bi bi-mic-fill"></i>' : '<i class="bi bi-mic-mute-fill"></i>';
        btn.classList.toggle("btn-danger");
        btn.classList.toggle("btn-secondary");
    }
}

function toggleVideo(btn) {
    if (!localStream) return;
    const track = localStream.getVideoTracks()[0];
    if (track) {
        track.enabled = !track.enabled;
        btn.innerHTML = track.enabled ? '<i class="bi bi-camera-video-fill"></i>' : '<i class="bi bi-camera-video-off-fill"></i>';
        btn.classList.toggle("btn-danger");
        btn.classList.toggle("btn-secondary");
    }
}

// 2. JOIN MEETING HANDLER
const joinBtn = document.getElementById("btn-join");
if (joinBtn) {
    joinBtn.addEventListener("click", () => {
        const nameInput = document.getElementById("username-input");
        if (!nameInput.value.trim()) {
            alert("Please enter your name");
            return;
        }
        MY_NAME = nameInput.value.trim();

        // UI Switch
        if (lobbyScreen) lobbyScreen.style.display = "none";
        if (mainInterface) mainInterface.style.display = "flex";
        if (videoGrid) videoGrid.style.display = "flex";
        if (controlsBar) controlsBar.style.display = "flex";

        // Update Local Badge
        const myBadge = localVideo.parentElement.querySelector(".user-badge");
        if (myBadge) myBadge.innerHTML = `<i class="bi bi-person-fill"></i> ${MY_NAME} (You)`;

        // Connect
        console.log("Joining room as", MY_NAME);
        socket.emit("join-room", { roomId: ROOM_ID, role: ROLE, userName: MY_NAME });
    });
}

// 3. Handle New User Joining
socket.on("user-connected", ({ userId, userName }) => {
    console.log("User connected:", userId, userName);
    connectToNewUser(userId, userName, localStream);
});

// 4. Handle Disconnect
socket.on("user-disconnected", userId => {
    console.log("User disconnected:", userId);
    if (peers[userId]) {
        peers[userId].close(); // Close WebRTC connection
        delete peers[userId];
    }
    // Remove video element
    const vid = document.getElementById(userId);
    if (vid) {
        vid.parentElement.remove(); // Safely remove just this user's video card
    }
});

// 5. Connect to New User (Initiator)
function connectToNewUser(userId, userName, stream) {
    const peer = createPeer(userId, userName);

    // Add local tracks
    if (stream) {
        stream.getTracks().forEach(track => peer.addTrack(track, stream));
    }

    // Create Offer
    peer.createOffer()
        .then(offer => peer.setLocalDescription(offer))
        .then(() => {
            socket.emit("offer", {
                target: userId,
                caller: socket.id,
                callerName: MY_NAME,
                sdp: peer.localDescription
            });
        });

    peers[userId] = peer;
}

// 6. Create Peer Helper
function createPeer(userId, userName = "User") {
    const peer = new RTCPeerConnection({
        iceServers: [{ urls: "stun:stun.l.google.com:19302" }]
    });

    peer.onicecandidate = e => {
        if (e.candidate) {
            socket.emit("ice-candidate", {
                target: userId,
                caller: socket.id,
                candidate: e.candidate
            });
        }
    };

    peer.ontrack = e => {
        console.log("Received track from:", userId);

        let vid = document.getElementById(userId);
        if (!vid) {
            // Create Video Container from CSS class
            const container = document.createElement("div");
            container.className = "video-card";

            vid = document.createElement("video");
            vid.id = userId;
            vid.autoplay = true;
            vid.playsInline = true;

            const badge = document.createElement("div");
            badge.className = "user-badge";
            badge.innerHTML = `<i class="bi bi-person-fill"></i> ${userName}`;

            container.appendChild(vid);
            container.appendChild(badge);
            videoGrid.appendChild(container);
        }
        vid.srcObject = e.streams[0];
        vid.play().catch(e => console.error("Autoplay error", e));
    };

    return peer;
}

// 7. Handle Incoming Offer
socket.on("offer", payload => {
    console.log("Received Offer from:", payload.caller, payload.callerName);
    const peer = createPeer(payload.caller, payload.callerName || "User");
    peers[payload.caller] = peer;

    if (localStream) {
        localStream.getTracks().forEach(track => peer.addTrack(track, localStream));
    }

    peer.setRemoteDescription(payload.sdp)
        .then(() => peer.createAnswer())
        .then(answer => peer.setLocalDescription(answer))
        .then(() => {
            socket.emit("answer", {
                target: payload.caller,
                caller: socket.id,
                sdp: peer.localDescription
            });
        });
});

// 8. Handle Incoming Answer
socket.on("answer", payload => {
    console.log("Received Answer from:", payload.caller);
    if (peers[payload.caller]) {
        peers[payload.caller].setRemoteDescription(payload.sdp);
    }
});

// 9. Handle Incoming ICE Candidate
socket.on("ice-candidate", payload => {
    if (peers[payload.caller]) {
        peers[payload.caller].addIceCandidate(payload.candidate).catch(e => console.error(e));
    }
});

// 10. Handle Meeting Ended by Host
socket.on("meeting-ended", () => {
    alert("The meeting has been ended by the host.");
    redirectUser();
});

// 11. Handle Force Mute (Mute All Students)
socket.on("force-mute", () => {
    if (localStream) {
        const track = localStream.getAudioTracks()[0];
        if (track && track.enabled) {
            track.enabled = false;
            // Update the UI button
            const btnAudio = document.getElementById("btn-audio");
            if (btnAudio) {
                btnAudio.innerHTML = '<i class="bi bi-mic-mute-fill"></i>';
                btnAudio.classList.add("btn-danger");
                btnAudio.classList.remove("btn-secondary");
            }
            alert("The teacher has muted all microphones.");
        }
    }
});

// 12. Handle Hard Mute (Lock)
socket.on("hard-mute", () => {
    if (ROLE === 'teacher') return; // Teacher shouldn't hard mute themselves
    isHardMuted = true;
    if (localStream) {
        const track = localStream.getAudioTracks()[0];
        if (track && track.enabled) {
            track.enabled = false;
            const btnAudio = document.getElementById("btn-audio");
            if (btnAudio) {
                btnAudio.innerHTML = '<i class="bi bi-mic-mute-fill"></i>';
                btnAudio.classList.add("btn-danger");
                btnAudio.classList.remove("btn-secondary");
            }
        }
    }
    alert("The teacher has locked all microphones. Raise your hand to speak.");
});

// 13. Handle Allow Unmute
socket.on("unmute-allowed", () => {
    isHardMuted = false;
    alert("The teacher has allowed you to unmute. You can now turn on your microphone.");
});

// Attach Room Control Listeners
const btnAudio = document.getElementById("btn-audio");
const btnVideo = document.getElementById("btn-video");

if (btnAudio) {
    btnAudio.addEventListener("click", function () {
        toggleAudio(this);
    });
}
if (btnVideo) {
    btnVideo.addEventListener("click", function () {
        toggleVideo(this);
    });
}

function leaveMeeting() {
    // If Teacher, end for everyone
    if (typeof ROLE !== 'undefined' && ROLE === 'teacher') {
        if (confirm("End meeting for everyone?")) {
            socket.emit("end-meeting", ROOM_ID);
        } else {
            return; // Cancelled
        }
    }
    redirectUser();
}

function redirectUser() {
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
    }
    // Redirect logic
    if (typeof ROLE !== 'undefined' && ROLE === 'teacher') {
        window.location.href = 'teacher/meeting-teacher.php';
    } else {
        window.location.href = 'student/meeting-student.php';
    }
}

// Audio Visualizer Helper
function visualizeAudio(stream) {
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const analyser = audioContext.createAnalyser();
    const microphone = audioContext.createMediaStreamSource(stream);
    const javascriptNode = audioContext.createScriptProcessor(2048, 1, 1);

    analyser.smoothingTimeConstant = 0.8;
    analyser.fftSize = 1024;

    microphone.connect(analyser);
    analyser.connect(javascriptNode);
    javascriptNode.connect(audioContext.destination);

    const canvas = document.getElementById("audio-meter");
    if (canvas) {
        const ctx = canvas.getContext("2d");

        javascriptNode.onaudioprocess = function () {
            const array = new Uint8Array(analyser.frequencyBinCount);
            analyser.getByteFrequencyData(array);
            let values = 0;
            const length = array.length;
            for (let i = 0; i < length; i++) values += (array[i]);
            const average = values / length;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (average > 10) ctx.fillStyle = "#22c55e";
            else if (average > 0) ctx.fillStyle = "#eab308";
            else ctx.fillStyle = "#ef4444";
            ctx.fillRect(0, 0, (average * 2), canvas.height);
        };
    }
}

// HTTPS / Mixed Content Warning
if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
    const warningDiv = document.createElement('div');
    warningDiv.style.cssText = 'position:fixed;top:0;left:0;right:0;background:#ffcc00;color:black;padding:10px;z-index:9999;text-align:center;font-weight:bold;box-shadow:0 2px 10px rgba(0,0,0,0.5);';
    warningDiv.innerHTML = `
        ⚠️ MOBILE CAMERA ISSUE: You are on HTTP. Browsers block camera access.<br>
        <small>Use <b>Firefox</b> on Android OR enable <b>chrome://flags/#unsafely-treat-insecure-origin-as-secure</b> for this IP.</small>
        <button onclick="this.parentElement.remove()" style="margin-left:10px;border:1px solid #000;background:transparent;cursor:pointer;">✕</button>
    `;
    document.body.prepend(warningDiv);
}

// ----------------------------------------------------
// NEW FEATURES: CHAT, RAISE HAND, CAMERA SWITCH
// ----------------------------------------------------

// Chat Logic
function sendChat() {
    const input = document.getElementById("chat-input");
    const text = input.value.trim();
    if (!text) return;

    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const payload = { roomId: ROOM_ID, userName: MY_NAME, text, time };
    
    // Emit to server
    socket.emit("send-chat", payload);
    
    // Append locally
    appendMessage(MY_NAME, text, time, true);
    input.value = "";
}

socket.on("receive-chat", (payload) => {
    appendMessage(payload.userName, payload.text, payload.time, false);
});

function appendMessage(sender, text, time, isSelf) {
    const chatContainer = document.getElementById("chat-messages");
    if (!chatContainer) return;

    const msgDiv = document.createElement("div");
    msgDiv.className = `chat-msg ${isSelf ? 'self' : 'other'}`;
    
    msgDiv.innerHTML = `
        <span class="msg-sender">${sender} • ${time}</span>
        <div>${text}</div>
    `;
    chatContainer.appendChild(msgDiv);
    chatContainer.scrollTop = chatContainer.scrollHeight; // Auto-scroll
}

// Raise Hand Logic
let isHandRaised = false;
function toggleHand() {
    isHandRaised = !isHandRaised;
    const localHand = document.getElementById("local-hand");
    if (localHand) localHand.style.display = isHandRaised ? "block" : "none";

    const btn = document.getElementById("btn-hand");
    if (btn) {
        btn.classList.toggle("btn-warning", isHandRaised);
        btn.classList.toggle("btn-secondary", !isHandRaised);
    }

    socket.emit("toggle-hand", { roomId: ROOM_ID, userId: socket.id, isRaised: isHandRaised });
}

socket.on("hand-toggled", (payload) => {
    const vid = document.getElementById(payload.userId);
    if (vid && vid.parentElement) {
        // Find existing hand badge or create one
        let badge = vid.parentElement.querySelector(".hand-badge");
        if (!badge) {
            badge = document.createElement("div");
            badge.className = "hand-badge";
            badge.innerHTML = "✋";
            vid.parentElement.appendChild(badge);
        }
        badge.style.display = payload.isRaised ? "block" : "none";

        // Teacher Only: Show "Allow" button to unmute
        if (ROLE === 'teacher') {
            let allowBtn = vid.parentElement.querySelector(".allow-btn");
            if (!allowBtn) {
                allowBtn = document.createElement("button");
                allowBtn.className = "allow-btn";
                allowBtn.innerHTML = "Allow Mic";
                allowBtn.onclick = () => {
                    socket.emit("allow-unmute", { roomId: ROOM_ID, userId: payload.userId });
                    allowBtn.style.display = "none";
                    badge.style.display = "none";
                };
                vid.parentElement.appendChild(allowBtn);
            }
            allowBtn.style.display = payload.isRaised ? "block" : "none";
        }
    }
});

// Mobile Camera Switch
let currentFacingMode = "user"; // "user" (front) or "environment" (back)
async function switchCamera() {
    if (!localStream) return;

    currentFacingMode = currentFacingMode === "user" ? "environment" : "user";
    console.log("Switching camera to:", currentFacingMode);

    const videoTrack = localStream.getVideoTracks()[0];
    if (videoTrack) videoTrack.stop(); // Stop current track

    try {
        const newStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: currentFacingMode, width: 480, height: 360, frameRate: 15 },
            audio: false // keep existing audio track
        });

        const newVideoTrack = newStream.getVideoTracks()[0];
        
        // Update local video element
        localStream.removeTrack(videoTrack);
        localStream.addTrack(newVideoTrack);
        document.getElementById("localVideo").srcObject = localStream;

        // Replace track on ALL active peer connections (seamless switch!)
        for (let peerId in peers) {
            const sender = peers[peerId].getSenders().find(s => s.track && s.track.kind === 'video');
            if (sender) {
                sender.replaceTrack(newVideoTrack);
            }
        }
        
        // Check if user had video disabled, ensure it matches state
        const btnVideo = document.getElementById("btn-video");
        if (btnVideo && btnVideo.classList.contains("btn-danger")) {
            newVideoTrack.enabled = false;
        }

    } catch (err) {
        console.error("Error switching camera:", err);
        alert("Could not switch camera. Check permissions or device capabilities.");
    }
}

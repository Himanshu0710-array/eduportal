const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);

const io = new Server(server, {
    cors: {
        origin: "*"
    }
});

io.on("connection", socket => {
    console.log("User connected:", socket.id);

    socket.on("join-room", ({ roomId, role, userName }) => {
        socket.join(roomId);
        // Broadcast to others that a new user connected (with their ID and Name)
        socket.to(roomId).emit("user-connected", { userId: socket.id, userName });
        console.log(`User ${socket.id} (${userName}) joined ${roomId}`);
    });

    // Relay Offer to specific user
    socket.on("offer", (payload) => {
        io.to(payload.target).emit("offer", payload);
    });

    // Relay Answer to specific user
    socket.on("answer", (payload) => {
        io.to(payload.target).emit("answer", payload);
    });

    // Relay ICE Candidate to specific user
    socket.on("ice-candidate", (payload) => {
        io.to(payload.target).emit("ice-candidate", payload);
    });

    // Handle Meeting End (Teacher ends for everyone)
    socket.on("end-meeting", (roomId) => {
        socket.to(roomId).emit("meeting-ended");
        console.log(`Meeting ${roomId} ended by host`);
    });

    // Handle Mute All Students (Teacher only)
    socket.on("mute-all", (roomId) => {
        socket.to(roomId).emit("force-mute");
        console.log(`Teacher muted all students in ${roomId}`);
    });

    // Handle Chat Messages
    socket.on("send-chat", (payload) => {
        // payload = { roomId, userName, text, time }
        socket.to(payload.roomId).emit("receive-chat", payload);
    });

    // Handle Raise Hand
    socket.on("toggle-hand", (payload) => {
        // payload = { roomId, userId, isRaised }
        socket.to(payload.roomId).emit("hand-toggled", payload);
    });

    socket.on("disconnect", () => {
        console.log("User disconnected:", socket.id);
        io.emit("user-disconnected", socket.id);
    });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`✅ Signaling server running at port ${PORT}`);
});

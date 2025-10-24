<footer>
    <div class="container">
        <p class="mb-2">&copy; 2025 EduPulse. All rights reserved.</p>
        <div class="d-flex justify-content-center mb-2">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
        </div>
        <small>"Empowering Minds, Shaping Futures."</small>
    </div>
</footer>

<!-- Chatbot Icon -->
<a href="../hayatWorking" class="chatbot-btn">
    <i class="bi bi-chat-dots"></i>
</a>

<!-- Bootstrap + AOS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: false 
    });
</script>

<style>
    .chatbot-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #6366f1;
        color: white;
        font-size: 28px;
        padding: 14px 16px;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        transition: transform 0.2s ease-in-out;
        z-index: 1000;
    }

    .chatbot-btn:hover {
        transform: scale(1.1);
        background: #4f46e5;
        color: #fff;
    }
</style>
</body>
</html>

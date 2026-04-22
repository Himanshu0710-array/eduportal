</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Chatbot Floating Button -->
<a href="http://localhost/himanshu/hayatWorking/index.php" class="chatbot-btn" title="Chat with AI Assistant">
    <div class="chatbot-icon-wrapper">
        <i class="bi bi-chat-dots-fill"></i>
        <span class="chatbot-badge">AI</span>
    </div>
</a>

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
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        width: 65px;
        height: 65px;
        border-radius: 50%;
        box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
        transition: all 0.3s ease-in-out;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .chatbot-btn:hover {
        transform: scale(1.12);
        background: linear-gradient(135deg, #4f46e5, #3730a3);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.6);
    }

    .chatbot-icon-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-btn i {
        font-size: 28px;
        color: #fff;
        transition: transform 0.2s;
    }

    .chatbot-btn:hover i {
        transform: scale(1.1);
    }

    .chatbot-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #22c55e;
        color: white;
        font-size: 10px;
        font-weight: 600;
        border-radius: 50%;
        padding: 2px 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }
</style>
    
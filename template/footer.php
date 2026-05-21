<style>
    .custom-footer {
        background-color: #0b2447; /* Deep blue background */
        color: #e2e8f0;
        padding: 60px 0 30px;
        margin-top: 50px;
    }
    
    .footer-brand {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .footer-brand img {
        height: 40px;
        margin-right: 15px;
        background-color: #ffffff;
        padding: 4px;
        border-radius: 6px;
    }
    
    .footer-brand-text {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }
    
    .footer-desc {
        color: #93c5fd;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    
    .social-links {
        display: flex;
        gap: 15px;
    }
    
    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        color: #ffffff;
        font-size: 1.2rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .social-icon:hover {
        background-color: #2563eb;
        color: #ffffff;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    }
    
    .footer-heading {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .footer-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background-color: #2563eb;
        border-radius: 2px;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 12px;
    }
    
    .footer-links a {
        color: #94a3b8;
        text-decoration: none;
        transition: color 0.3s ease;
        display: inline-block;
    }
    
    .footer-links a:hover {
        color: #ffffff;
        transform: translateX(5px);
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 30px;
        margin-top: 40px;
        text-align: center;
    }
    
    .footer-bottom p {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0;
    }
</style>

<footer class="custom-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">
                    <img src="/images/logo1.png" alt="EduPulse">
                    <h3 class="footer-brand-text">EduPulse</h3>
                </div>
                <p class="footer-desc">Empowering minds and shaping futures through innovative education, cutting-edge programs, and a commitment to holistic development.</p>
                <div class="social-links">
                    <a href="https://linkedin.com" target="_blank" class="social-icon" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://github.com" target="_blank" class="social-icon" aria-label="GitHub">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="mailto:contact@edupulse.edu" class="social-icon" aria-label="Email">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 ms-lg-auto">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="/index.php">Home</a></li>
                    <li><a href="#courses">Programs</a></li>
                    <li><a href="/student/register.php">Admission</a></li>
                    <li><a href="/student/login-student.php">Student Portal</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h4 class="footer-heading">Contact Us</h4>
                <ul class="footer-links">
                    <li class="d-flex align-items-start text-secondary">
                        <i class="bi bi-geo-alt me-2 mt-1 text-primary"></i>
                        <span>123 University Avenue, Knowledge City, ED 10001</span>
                    </li>
                    <li class="d-flex align-items-center text-secondary">
                        <i class="bi bi-telephone me-2 text-primary"></i>
                        <span>+1 (555) 123-4567</span>
                    </li>
                    <li class="d-flex align-items-center text-secondary">
                        <i class="bi bi-envelope me-2 text-primary"></i>
                        <span>info@edupulse.edu</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> EduPulse. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });
</script>
<style>
    #page-loader {
        position: fixed; inset: 0;
        background: rgba(255,255,255,0.85);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 14px;
        opacity: 1;
        transition: opacity 0.35s ease;
        pointer-events: none;
    }
    #page-loader.hidden { opacity: 0; }
    .loader-ring {
        width: 52px; height: 52px;
        border: 5px solid #e2e8f0;
        border-top-color: #2563eb;
        border-radius: 50%;
        animation: spin 0.75s linear infinite;
    }
    .loader-text { color: #64748b; font-size: 0.9rem; font-weight: 500; font-family: 'Outfit', sans-serif; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<!-- Page Loader -->
<div id="page-loader">
    <div class="loader-ring"></div>
    <span class="loader-text">Loading...</span>
</div>

<script>
(function() {
    // Hide the loader once DOM is ready
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('page-loader').classList.add('hidden');
        }, 300);
    });
    // Show loader on navigation
    document.addEventListener('click', function(e) {
        var target = e.target.closest('a');
        if (target && target.href && !target.href.startsWith('#') && !target.href.startsWith('javascript') && target.target !== '_blank') {
            document.getElementById('page-loader').classList.remove('hidden');
        }
    });
})();
</script>
</body>
</html>

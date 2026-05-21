<style>
    .hero-section {
        background-color: #f1f5f9;
        padding: 120px 0 60px;
        margin-bottom: 60px;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        color: #475569;
        margin-bottom: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2rem;
    }
    
    .course-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        transition: transform 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    .course-card img {
        height: 180px;
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    
    .course-card .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }
    
    .course-card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.75rem;
    }
    
    .course-card .card-text {
        color: #64748b;
        font-size: 0.95rem;
        flex-grow: 1;
    }
    
    .enroll-btn {
        background-color: #e2e8f0;
        color: #334155;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 6px;
        transition: all 0.2s ease;
        margin-top: 1rem;
        text-decoration: none;
        display: inline-block;
    }
    
    .enroll-btn:hover {
        background-color: #4f46e5;
        color: #ffffff;
    }
    
    .about-section {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 3rem 2rem;
        margin-bottom: 60px;
    }
    
    .about-text {
        font-size: 1rem;
        line-height: 1.7;
        color: #475569;
    }
    
    .feature-box {
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f8fafc;
        height: 100%;
    }
</style>

<div class="content-wrapper">
    <div class="hero-section text-center">
        <div class="container" data-aos="fade-up">
            <h1 class="hero-title">Welcome to EduPulse</h1>
            <p class="hero-subtitle">Quality education and innovative programs to shape your future.</p>
            <div class="mt-4">
                <a href="student/register.php" class="btn btn-primary px-4 py-2 me-2">Apply Now</a>
                <a href="#courses" class="btn btn-outline-secondary px-4 py-2">View Courses</a>
            </div>
        </div>
    </div>

    <div class="container" id="courses">
        <div class="text-center" data-aos="fade-up">
            <h2 class="section-title">Programs We Offer</h2>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="course-card">
                    <img src="images/course-1.webp" class="card-img-top w-100" alt="B.Tech">
                    <div class="card-body">
                        <h5 class="card-title">B.Tech</h5>
                        <p class="card-text">Cutting-edge engineering programs to shape future innovators.</p>
                        <a href="student/register.php" class="enroll-btn">Discover Program</a>
                    </div>
                </div>    
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="course-card">
                    <img src="images/course-2.png" class="card-img-top w-100" alt="BCA">
                    <div class="card-body">
                        <h5 class="card-title">BCA</h5>
                        <p class="card-text">Industry-focused computer application programs building future IT professionals.</p>
                        <a href="student/register.php" class="enroll-btn">Discover Program</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="course-card">
                    <img src="images/course-3.png" class="card-img-top w-100" alt="BBA">
                    <div class="card-body">
                        <h5 class="card-title">BBA</h5>
                        <p class="card-text">Comprehensive business administration programs nurturing global business leaders.</p>
                        <a href="student/register.php" class="enroll-btn">Discover Program</a>
                    </div>
                </div>    
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="course-card">
                    <img src="images/course-4.jpg" class="card-img-top w-100" alt="LLB">
                    <div class="card-body">
                        <h5 class="card-title">LLB</h5>
                        <p class="card-text">Rigorous legal studies programs shaping skilled and proficient legal professionals.</p>
                        <a href="student/register.php" class="enroll-btn">Discover Program</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <h2 class="section-title">About Our Institute</h2>
        </div>
        
        <div class="about-section" data-aos="fade-up">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3 fs-4 text-dark">Empowering the Next Generation</h3>
                    <p class="about-text">
                        At this esteemed institution, the focus is on equipping the next generation with the skills and knowledge they need to thrive in an ever-changing world. With a forward-thinking approach, we emphasize upskilling young minds, providing a strong foundation in both academic learning and practical expertise.
                    </p>
                    <p class="about-text">
                        By offering a diverse range of programs designed to foster innovation, critical thinking, and leadership, we ensure that students are well-prepared for tomorrow's challenges.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <h6 class="fw-bold">Innovation First</h6>
                                <p class="text-muted small mb-0">Dynamic curriculum blending theory with hands-on learning.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <h6 class="fw-bold">Global Perspective</h6>
                                <p class="text-muted small mb-0">Building resilience for a technology-driven world.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <h6 class="fw-bold">Industry Aligned</h6>
                                <p class="text-muted small mb-0">Strong industry partnerships and mentorship.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-box">
                                <h6 class="fw-bold">Holistic Growth</h6>
                                <p class="text-muted small mb-0">Nurturing ethical leadership and responsibility.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

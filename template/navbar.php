<link rel="icon" type="image/png" href="/images/1logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
    :root {
        --primary-color: #2563eb; /* Bright blue */
        --bg-color: #f4f7fc; /* Very light blueish gray */
    }
    
    body {
        font-family: 'Outfit', sans-serif;
        background-color: var(--bg-color);
    }

    .navbar {
        background-color: #ffffff !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        padding: 0 0 !important; 
        min-height: 60px !important;
        border-bottom: 1px solid #eee !important;
    }
    
    .navbar .nav-link {
        color: #4b5563 !important;
        font-weight: 500;
        margin: 0 5px;
        transition: color 0.2s ease;
    }

    .navbar .nav-link:hover {
        color: var(--primary-color) !important;
    }
    
    .logo img {
        height: 45px !important;
        width: auto;
    }
</style>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand logo" href="/index.php"><img src="/images/logo1.png" alt="EduPulse Logo"></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/student/register.php">Admission</a></li>
                <li class="nav-item"><a class="nav-link" href="/student/login-student.php">Fees</a></li>
            </ul>
            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-2">
                    <a class="nav-link" href="/student/register.php">Register</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn btn-primary px-3 py-1 rounded dropdown-toggle" style="background-color: var(--primary-color); border: none;" href="#" role="button" data-bs-toggle="dropdown">
                        Login
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="/student/login-student.php">Student</a></li>
                        <li><a class="dropdown-item py-2" href="/teacher/login-teacher.php">Teacher</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

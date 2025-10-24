<link rel="icon" type="image/png" href="/images/1logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9fb;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .navbar {
            background: linear-gradient(90deg, #004080, #0066cc);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            padding: 10px 0;
        }
        .navbar .nav-link, .navbar .btn {
            color: #fff !important;
            font-weight: 600;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .navbar .nav-link:hover, .navbar .btn:hover {
            color: #ffbf80 !important;
            transform: scale(1.1);
        }
        .navbar .btn {
            background-color: #003366;
            border-radius: 5px;
            border: none;
        }
        .navbar .btn:hover {
            background-color: #002244;
        }
        .logo img {
            height: 80px;
            width: auto;
            transition: transform 0.3s ease;
        }
        .logo img:hover {
            transform: scale(1.05);
        }

        .carousel-inner img {
            width: 100%;
            height: 650px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.5s ease, filter 0.5s ease;
        }
        .carousel-inner img:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .section-title {
            text-align: center;
            font-weight: 600;
            font-size: 32px;
            color: #0d6efd;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            background-color: #fff;
        }
        .card:hover {
            transform: translateY(-7px) scale(1.02);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        .card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .card:hover img {
            transform: scale(1.05);
        }
        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #0d6efd;
        }
        .card-text {
            color: #555;
            font-size: 15px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-primary:hover {
            background-color: #0056d2;
            transform: scale(1.05);
        }

        .about-p {
            border: 3.5px solid #ffbf80;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: justify;
            font-size: 1rem;
            line-height: 1.8;
            margin: 40px auto;
        }

        footer {
            background-color: #0d6efd;
            color: white;
            padding: 40px 20px;
            text-align: center;
            font-size: 14px;
        }
        footer a {
            color: #ffd580;
            margin: 0 8px;
            font-size: 20px;
            transition: color 0.3s, transform 0.3s;
        }
        footer a:hover {
            color: #fff;
            transform: scale(1.2);
        }
        footer small {
            display: block;
            margin-top: 10px;
            color: #ffd699;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand logo" href="#"><img src="images/logo1.png" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link" href="/himanshu/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/himanshu/student/register.php">Admission</a></li>
                <li class="nav-item"><a class="nav-link" href="/himanshu/student/login-student.php">Fees</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class=" nav-link" href="/himanshu/student/register.php">Register</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Login</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/himanshu/student/login-student.php">Student</a></li>
                        <li><a class="dropdown-item" href="/himanshu/teacher/login-teacher.php">Teacher</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
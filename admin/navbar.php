 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .logo
        {
            font-size:25px;
        }
        .navbar-1
        {
            margin-left:auto;
            margin-right:auto;
        }
        .heading
        {
            text-align:center;
            margin:25px 0px 30px 0px;

        }
        .about-p
        {
            border:3.5px solid #ffbf80;
            border-radius:20px;
        }
        .footer
        {
           margin:40px 0px 30px 0px;
           border-bottom:2px solid black;
        }
    </style>
    </head>
    <body>
        <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary border-bottom">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="logo">
                    <p><b>HIMANSHU</b></p>  
                </div>
                <div class="collapse navbar-collapse " id="navbarNav">
                    <ul class="navbar-nav navbar-1">
                        <li class="nav-item ">
                          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="register.php">Admission</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="login-student.php">Fees</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-2">
                    <ul class="navbar-nav navbar-2">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="register.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                  <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                                <br>Register
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="btn  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Login
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu ">
                                <li><a class="dropdown-item" href="login-student.php">Student</a></li>
                                <li><a class="dropdown-item" href="admin/login-admin.php">Admin</a></li>
                            </ul>
                        </li>
                    </ul>    
                </div>
            </div>
        </nav>
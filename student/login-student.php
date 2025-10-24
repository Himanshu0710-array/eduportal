<?php
include "../template/navbar.php";

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Student Login</title>
    <link rel="icon" type="image/png" href="../images/logo1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background: #f0f6ff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1; /* push footer down */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            margin: 60px 0px 0px 0px;
        }
        .login-card h2 {
            text-align: center;
            font-weight: bold;
            color: #0d47a1;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
        }
        .form-label {
            font-weight: 600;
            color: #0d6efd;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
        }
        .btn-login {
            width: 100%;
            background: linear-gradient(90deg, #0d47a1, #1a73e8);
            border: none;
            padding: 12px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #08306b, #0d6efd);
        }
        .extra-links {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .extra-links a {
            color: #0d6efd;
            text-decoration: none;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
        footer {
            background: #0d47a1;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
  </head>
  <body>
    <main>
        <div class="login-card">
            <h2>Student Login</h2>
            <form action="login-student-process.php" method="post">

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Student ID is not filled.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php } ?>
                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Password is not filled.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php } ?>
                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 3) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Password is not correct.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">Student ID</label>
                    <input class="form-control" type="number" name="studentId" value="studentId" placeholder="Enter Student ID">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="studentPassword" placeholder="Enter Password">
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div class="extra-links">
                    Don't have an account? <a href="register.php">Register now</a>
                </div>
            </form>
        </div>
    </main>
    <?php
        include "../template/footer.php";
    ?>
    


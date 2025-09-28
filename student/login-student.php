<?php
include "../template/navbar.php";
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fees Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .login-bg
        {
            
            background-image: url('images/login-1.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .main
        {
            margin-top:150px;
            margin-bottom:100px;
        }
        .heading
        {
            margin-bottom:50px;
            padding-bottom:10px;
            border-bottom:2px solid black;
            text-align:center;
        }
        .content
        {
            border:1px solid black;
            padding-bottom:25px;
            border-radius:10px;
        }
        .submit-btn
        {
            width:100px;
            margin-left:10px;
        }
        .connect
        {
            float:left;
        }
    </style>
  </head>
  <body class="login-bg">
    <div class="container">
        <div class="row main">
            <div class="col-md-3"></div>
            <div class="col-md-6 content">
                <h2 class="heading">Login Page</h2>
                <form class="row" action="login-student-process.php" method="post">
                    <?php if ($_REQUEST["err"] == 1) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> student id is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if ($_REQUEST["err"] == 2) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> password is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if ($_REQUEST["err"] == 3) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> password is not correct
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                  <div class="mb-3">
                    <label class="form-label">Student Id</label>
                    <input class="form-control" name="studentId" value="<?php echo $_SESSION["studentId"]?>" type="number" placeholder="Student id" aria-label="default input example">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="studentPassword" value="<?php echo $_SESSION["studentPassword"]?>" class="form-control" placeholder="password"   id="exampleInputPassword1">
                  </div>
                  <div>
                      Don't have an account? Register now.  <a href="register.php">Register</a>
                  </div>
                  <button type="submit" class="btn btn-primary submit-btn">Login</button>
                </form>
            </div>
            <div class="col-md-3"></div>    
        </div>
        
    </div>
    
  </body>
</html>
<?php
include "../template/footer.php";
session_destroy();
?>
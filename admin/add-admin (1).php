<?php
session_start();
  include "admin-dashboard-top.php";
  include "admin-dashboard-navbar.php";
  include "admin-dashboard-content.php";
    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .main
        {
            margin-top:20px;
        }
        .heading-add-admin
        {
            margin-bottom:50px;
            padding-bottom:10px;
            border-bottom:2px solid black;
            text-align:center;
        }
        .content-add-admin
        {
            border:1px solid black;
            padding-bottom:25px;
            border-radius:10px;
            background: #fff;
             margin:40px auto;
             box-shadow:0 0 10px;
             border-radius:10px;
        }
        .submit-btn
        {
            width: 96%;
            margin:10px auto;
        }
        
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row main">
            <div class="col-md-1"></div>
            <div class="col-md-10 content-add-admin">
                <h2 class="heading-add-admin">Admin Registration</h2>
                <form class="row" action="add-admin-process.php" method="post">
                    <?php if ($_REQUEST["err"] == 1) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Admin Name is not filled
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
                        <strong>Error!</strong> Gender is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if ($_REQUEST["err"] == 4) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Number is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if ($_REQUEST["err"] == 5) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> session is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if ($_REQUEST["err"] == 6) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Occupation is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin Name</b></label>
                        <input class="form-control" name="adminName"  type="text" value="<?php echo $_SESSION['adminName'] ?>" placeholder="Admin Name" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label"><b>Password</b></label>
                        <input type="password" name="adminPassword" value="<?php echo $_SESSION['adminPassword'] ?>"  class="form-control" placeholder="password"   id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin's Gender</b></label>
                            <select class="form-select" name="adminGender" aria-label="Default select example">
                                <option value="-1">--Select Gender--</option>
                                <option <?php if($_SESSION['adminGender'] == 1){ echo "selected" ;} ?> value="1">Female</option>
                                <option <?php if($_SESSION['adminGender'] == 2){ echo "selected" ;} ?> value="2">Male</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin Contact Number</b></label>
                        <input class="form-control" type="number" name="adminNumber" value="<?php echo $_SESSION['adminNumber'] ?>" placeholder="Admin Mobile Number " aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Session</b></label>
                        <select class="form-select" name="sessionId"  aria-label="Default select example">
                            <option value="-1">--Select Session--</option>
                            <?php
                                $query1 = "SELECT * FROM tblsession WHERE status = 1";
                                $stmt = $conn->prepare($query1);
                                $stmt->execute();
                    
                                
                                while ($row = $stmt->fetch()) {
                            ?>
                            <option <?php if($_SESSION["sessionId"]==$row['sessionId']){ echo "selected"; }  ?> value="<?php echo $row["sessionId"]; ?>">
                                <?php echo htmlspecialchars($row["sessionName"]); ?>
                            </option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin's Occupation</b></label>
                            <select class="form-select" name="adminOccupation" aria-label="Default select example">
                                <option value="-1">--Select occupation--</option>
                                <option <?php if($_SESSION['adminOccupation'] == 1){ echo "selected" ;} ?> value="1">Principal</option>
                                <option <?php if($_SESSION['adminOccupation'] == 2){ echo "selected" ;} ?> value="2">HOD</option>
                                <option <?php if($_SESSION['adminOccupation'] == 3){ echo "selected" ;} ?> value="3">Accountant</option>
                                <option <?php if($_SESSION['adminOccupation'] == 4){ echo "selected" ;} ?> value="3">Teacher</option>
                            </select>
                    </div>
                  <button type="submit" class="btn btn-primary submit-btn">Register</button>
                </form>
            </div>
            <div class="col-md-1"></div>    
        </div>
    </div>
</div>
</div>
<?php
    include "admin-dashboard-footer.php";
    session_destroy();
?>  
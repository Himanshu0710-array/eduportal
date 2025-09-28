<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-navbar.php";
  include "admin-dashboard-content.php";

  $adminId=$_REQUEST['adminId'];
  $stmt=$conn->prepare("SELECT * FROM tbladmin where adminId=:adminId");
  $stmt->bindParam(":adminId",$adminId);
  $stmt->execute();
  $row=$stmt->fetch();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Admin</title>
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
                <h2 class="heading-add-admin">Edit Admin</h2>
                <form class="row" action="edit-admin-process.php" method="post">
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
                        <strong>Error!</strong> Number is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    
                    <input type="hidden" name="adminId" value="<?php echo $row['adminId']; ?>">

                    <div class="mb-3">
                        <label class="form-label"><b>Admin Name</b></label>
                        <input class="form-control" name="adminName"  type="text" placeholder="Admin Name" value="<?php echo $row['adminName'] ?>" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label"><b>Password</b></label>
                        <input type="text" name="adminPassword"  class="form-control" placeholder="password" value="<?php echo $row['adminPassword'] ?>"   id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin's Gender</b></label>
                        <select class="form-select" name="adminGender">
                            <option value="1" <?php echo ($row["adminGender"] == 1) ? 'selected' : ''; ?>>Female</option>
                            <option value="2" <?php echo ($row["adminGender"] == 2) ? 'selected' : ''; ?>>Male</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin Contact Number</b></label>
                        <input class="form-control" type="number" name="adminNumber" placeholder="Admin Mobile Number"  value="<?php echo $row['adminNumber'] ?>" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Session Of Registrartion</b></label>
                        <select class="form-select" name="sessionId"   aria-label="Default select example" >
                            <?php
                                $stmt=$conn->prepare("SELECT * FROM tblsession");
                                $stmt->execute();
                                while ($session = $stmt->fetch()) {
                            ?>
                            <option value="<?php echo $session["sessionId"]; ?>" <?php echo ($row["sessionId"] == $session['sessionId']) ? 'selected' : ''; ?>>
                                <?php echo ($session["sessionName"]); ?>
                            </option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Admin's Occupation</b></label>
                        <select class="form-select" name="adminOccupation" aria-label="Default select example">
                            <option value="1" <?php echo ($row["adminOccupation"] == 1) ? 'selected' : ''; ?>>Principal</option>
                            <option value="2" <?php echo ($row["adminOccupation"] == 2) ? 'selected' : ''; ?>>HOD</option>
                            <option value="3" <?php echo ($row["adminOccupation"] == 3) ? 'selected' : ''; ?>>Accountant</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Update</button>
                </form>
            </div>
            <div class="col-md-1"></div>    
        </div>
    </div>
</div>
</div>
<?php
    include "admin-dashboard-footer.php"
?>  
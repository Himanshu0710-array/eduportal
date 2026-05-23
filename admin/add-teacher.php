<?php
include_once "../database-connect.php";
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .main { margin-top:20px; }
        .heading-add-teacher { margin-bottom:50px; padding-bottom:10px; border-bottom:2px solid black; text-align:center; }
        .content-add-teacher { border:1px solid black; padding-bottom:25px; border-radius:10px; background:#fff; margin:40px auto; box-shadow:0 0 10px; }
        .submit-btn { width:96%; margin:10px auto; }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row main">
            <div class="col-md-1"></div>
            <div class="col-md-10 content-add-teacher">
                <h2 class="heading-add-teacher">Teacher Registration</h2>
                <form class="row px-3" action="add-teacher-process.php" method="post">
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Teacher Name is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Email is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 3) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Password is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 4) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Phone is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 5) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Subject is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label class="form-label"><b>Teacher Name</b></label>
                        <input class="form-control" name="teacherName" type="text" placeholder="Teacher Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Email Address</b></label>
                        <input class="form-control" name="teacherEmail" type="email" placeholder="Teacher Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Password</b></label>
                        <input type="password" name="teacherPassword" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Contact Number</b></label>
                        <input class="form-control" type="text" name="teacherPhone" placeholder="Teacher Mobile Number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Gender</b></label>
                        <select class="form-select" name="teacherGender" required>
                            <option value="-1">--Select Gender--</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Assigned Subject</b></label>
                        <select class="form-select" name="subjectId" required>
                            <option value="-1">--Select Subject--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT s.*, c.courseName FROM tblsubject s JOIN tblcourse c ON s.courseId = c.courseId");
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                            ?>
                            <option value="<?php echo $row["subjectId"]; ?>">
                                <?php echo htmlspecialchars($row["subjectName"] . ' (' . $row["courseName"] . ')'); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Assigned Section(s)</b></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="A" id="secA">
                                <label class="form-check-label" for="secA">Section A</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="B" id="secB">
                                <label class="form-check-label" for="secB">Section B</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="C" id="secC">
                                <label class="form-check-label" for="secC">Section C</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="D" id="secD">
                                <label class="form-check-label" for="secD">Section D</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Register Teacher</button>
                </form>
            </div>
            <div class="col-md-1"></div>    
        </div>
    </div>
<?php
include "admin-dashboard-footer.php";
?>

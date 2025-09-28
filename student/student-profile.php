<?php
include "../database-connect.php";
session_start();
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";


$query = "SELECT * FROM tblstudent where studentId=:studentId";
$stmt=$conn->prepare($query);
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();
$row=$stmt->fetch();
?>

<!doctype html>
<title>Student Profile</title>
<style>
    .header h2
    {
        text-align: center;
        padding: 10px;
        border-bottom: 5px solid black;
    }

    .content {
        margin-top: 10px;
        box-shadow:0 0 10px;
        border-radius:10px;
    }

    .left1 h4 {
        text-align: center;
    }

    .right h4 {
        text-align: center;
    }
    .submit-btn
    {
        float:right;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid content">
    <div class="row ">
        <?php if ($_SESSION['success_message']) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_message']);  ?>
                <?php } ?>
        <div class="col-md-1"></div>
        <div class="col-md-10 ">
            <div class="header">
                <h2>STUDENT PROFILE</h2>
            </div>
            <form class="row" action="student-profile-process.php" method="post">
                 <?php if ($_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your Number is not Valid
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your E-Mail is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 3) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your Password is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 4) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> You have entered the same password as before. Please choose a new password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <div class="col-md-6 left1">
                    <h4>Student Details</h4>
                    <div class="mb-3">
                        <input class="form-control" type="hidden" name="studentId" placeholder="Student Id" value="<?php echo $row["studentId"] ?>" aria-label="default input example" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Full Name </label>
                        <input class="form-control" type="text" name="studentName"  value="<?php echo $row["studentName"]?>" placeholder="Student Full Name" aria-label="default input example" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Date of Birth</label>
                        <input class="form-control" type="Date" name="dob" value="<?php echo $row["dob"]?>" placeholder="DD/MM/YYY" aria-label="default input example" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Selected</label>
                        <select class="form-select" name="courseId" disabled>
                            <option value="-1">--Select Course--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tblcourse");
                            $stmt->execute();
                            while ($course = $stmt->fetch()) {
                            ?>
                                <option value="<?php echo $course['courseId']; ?>" <?php echo ($row["courseId"] == $course['courseId']) ? 'selected' : ''; ?>>
                                    <?php echo $course['courseName']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Academic Year</label>
                        <div class="input-group">
                            
                            <input class="form-control" type="text"  value=
                            "<?php
                                $academicYearId = $row['academicYearId'];
                                $stmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                                $stmt->bindParam(":academicYearId",$academicYearId);
                                $stmt->execute();
                                $academicYear = $stmt->fetch();
                                echo $academicYear["academicYearName"];
                            ?>" 
                            placeholder="Academic Year" aria-label="default input example" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Session Of Registrartion</label>
                        <select class="form-select" name="sessionId"   aria-label="Default select example" disabled>
                            <option value="-1">--Select Session--</option>
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
                        <label class="form-label">Student's Mobile Number </label>
                        <input class="form-control" type="number" name="studentNumber" value="<?php echo $row["studentNumber"]?>" placeholder="Student Mobile Number " aria-label="default input example" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student's Gender - </label>
                            <select class="form-select" name="studentGender" aria-label="Default select example" disabled>
                                <option value="-1">--Select Gender--</option>
                                <option value="1" <?php echo ($row['studentGender'] == 1) ? 'selected' : ''; ?>>Female</option>
                                <option value="2" <?php echo ($row['studentGender'] == 2) ? 'selected' : ''; ?>>Male</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Mail Id </label>
                        <input type="email" class="form-control" type="email" name="studentEmail" value="<?php echo $row["studentEmail"]?>"  id="exampleInputEmail1" placeholder="Student Mail Id" aria-label="default input example" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Login Password</label>
                        <input type="text" class="form-control" name="studentPassword" value="<?php echo $row["studentPassword"]?>"  placeholder="Student Password" aria-label="default input example" id="exampleInputPassword1">
                    </div>
                </div>
                <div class="col-md-6 right">
                    <h4>Parents Details</h4>
                    <div>
                        Father's Name
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Mr.</span>
                            <input type="text" placeholder="Father Name" name="fatherName" value="<?php echo $row["fatherName"]?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" readonly>
                    </div>
                    <div>
                        Mother's Name
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Mrs.</span>
                        <input type="text" placeholder="Mother Name"name="motherName" value="<?php echo $row["motherName"]?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Parent's Mobile Number</label>
                        <input class="form-control" type="number" name="parentNumber" value="<?php echo $row["parentNumber"]?>" placeholder="Parent's Mobile Number" aria-label="default input example" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Parent Mail Id</label>
                        <input class="form-control" type="email" name="parentEmail" value="<?php echo $row["parentEmail"]?>" placeholder="Parent Mail Id" aria-label="default input example" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Registration</label>
                        <input class="form-control" type="date" name="dateOfRegistration" value="<?php echo date('Y-m-d', strtotime($row['dateOfRegistration'])); ?>" aria-label="default input example" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address</label>
                        <div class="form-floating">
                            <textarea class="form-control" name="address" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 115px" readonly><?php echo $row['address'] ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Update Profile</button>
                </div>
            </form>
        </div> 
        <div class="col-md-1"></div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

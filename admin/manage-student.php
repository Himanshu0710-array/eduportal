<?php
include "../database-connect.php";
session_start();
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";


$studentId  = $_REQUEST["studentId"];


$query1 = "SELECT * FROM tblstudent WHERE studentId = :studentId";
$stmt = $conn->prepare($query1);
$stmt->bindParam(":studentId", $studentId);
$stmt->execute();
$row = $stmt->fetch();

$err = 0; // default
if (isset($_GET['err'])) {
    $err = (int) $_GET['err'];
}

?>

<!doctype html>
<title>Student Edit</title>
<style>
    .header h2 {
        text-align: center;
        padding: 10px;
        border-bottom: 5px solid black;
    }
    .content {
        margin-top: 10px;
        box-shadow: 0 0 10px;
        border-radius: 10px;
    }
    .left1 h4, .right h4 {
        text-align: center;
    }
    .submit-btn {
        float: right;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<body>
<div class="container-fluid content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="header">
                <h2>STUDENT PROFILE</h2>
            </div>
            <form class="row" action="manage-student-process.php" method="post">
                <?php if ($err == 1): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your name is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 2): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your DOB is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 3): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your course is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 4): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your session is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 5): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your number is not valid
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 6): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your gender is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 7): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your email is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 8): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your password is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 9): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your father’s name is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 10): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your mother’s name is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 11): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your parent’s number is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 12): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your parent’s email is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 13): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your registration date is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($err) && $err == 14): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error! Your address is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>


    
                <input type="hidden" name="studentId" value="<?php echo $row["studentId"]; ?>">

                <div class="col-md-6 left1">
                    <h4>Student Details</h4>
                    <div class="mb-3">
                        <label class="form-label">Student Full Name</label>
                        <input class="form-control" type="text" name="studentName" value="<?php echo htmlspecialchars($row["studentName"]); ?>" placeholder="Student Full Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input class="form-control" type="date" name="dob" value="<?php echo htmlspecialchars($row["dob"]); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Course</label>
                        <select class="form-select" name="courseId">
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
                            
                            <input class="form-control" type="text" name="academicYearId" value=
                            "<?php
                                $academicYearId = $row['academicYearId'];
                                $stmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                                $stmt->bindParam(":academicYearId",$academicYearId);
                                $stmt->execute();
                                $academicYear = $stmt->fetch();
                                echo $academicYear["academicYearName"];
                            ?>" 
                            placeholder="Academic Year" aria-label="default input example" readonly >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Session Of Registrartion</label>
                        <select class="form-select" name="sessionId"   aria-label="Default select example" >
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
                        <label class="form-label">Student's Mobile Number</label>
                        <input class="form-control" type="number" name="studentNumber" value="<?php echo htmlspecialchars($row["studentNumber"]); ?>" placeholder="Student Mobile Number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Student's Gender</label>
                        <select class="form-select" name="studentGender">
                            <option value="-1">--Select Gender--</option>
                            <option value="1" <?php echo ($row["studentGender"] == 1) ? 'selected' : ''; ?>>Female</option>
                            <option value="2" <?php echo ($row["studentGender"] == 2) ? 'selected' : ''; ?>>Male</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Student Mail Id</label>
                        <input type="email" class="form-control" name="studentEmail" value="<?php echo htmlspecialchars($row["studentEmail"]); ?>" placeholder="Student Email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Student Login Password</label>
                        <input type="text" class="form-control" name="studentPassword" value="<?php echo htmlspecialchars($row["studentPassword"]); ?>" placeholder="Student Password">
                    </div>
                </div>

                <div class="col-md-6 right">
                    <h4>Parents Details</h4>

                    <div>Father's Name</div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Mr.</span>
                        <input type="text" name="fatherName" value="<?php echo htmlspecialchars($row["fatherName"]); ?>" class="form-control">
                    </div>

                    <div>Mother's Name</div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Mrs.</span>
                        <input type="text" name="motherName" value="<?php echo htmlspecialchars($row["motherName"]); ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent's Mobile Number</label>
                        <input class="form-control" type="number" name="parentNumber" value="<?php echo htmlspecialchars($row["parentNumber"]); ?>" placeholder="Parent's Mobile Number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent Mail Id</label>
                        <input class="form-control" type="email" name="parentEmail" value="<?php echo htmlspecialchars($row["parentEmail"]); ?>" placeholder="Parent Mail Id">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Registration</label>
                        <input class="form-control" type="date" name="dateOfRegistration" value="<?php echo date('Y-m-d', strtotime($row['dateOfRegistration'])); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" name="address" value="<?php echo htmlspecialchars($row["address"]); ?>" placeholder="Address">
                    </div>

                    <button type="submit" class="btn btn-primary submit-btn">Update Profile</button>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

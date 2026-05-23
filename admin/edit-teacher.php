<?php
include_once "../database-connect.php";
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";

$teacherId = $_GET['teacherId'] ?? '';
$stmt = $conn->prepare("SELECT * FROM tblteacher WHERE teacherId = :teacherId");
$stmt->bindParam(":teacherId", $teacherId);
$stmt->execute();
$row = $stmt->fetch();

$assignedSections = !empty($row['section']) ? explode(',', $row['section']) : [];

$currentSubjectId = $row['subjectId'];
$subQuery = $conn->prepare("SELECT * FROM tblsubject WHERE subjectId = :subjectId");
$subQuery->bindParam(":subjectId", $currentSubjectId);
$subQuery->execute();
$currentSubject = $subQuery->fetch();

$currentCourseId = $currentSubject ? $currentSubject['courseId'] : -1;
$currentAcademicYearId = $currentSubject ? $currentSubject['academicYearId'] : -1;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Teacher</title>
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
                <h2 class="heading-add-teacher">Edit Teacher</h2>
                <form class="row px-3" action="edit-teacher-process.php" method="post">
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Teacher Name cannot be left blank
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Email cannot be left blank
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 3) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Phone cannot be left blank
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <input type="hidden" name="teacherId" value="<?php echo $row['teacherId']; ?>">

                    <div class="mb-3">
                        <label class="form-label"><b>Teacher Name</b></label>
                        <input class="form-control" name="teacherName" type="text" placeholder="Teacher Name" value="<?php echo htmlspecialchars($row['teacherName']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Email Address</b></label>
                        <input class="form-control" name="teacherEmail" type="email" placeholder="Teacher Email" value="<?php echo htmlspecialchars($row['teacherEmail']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Password</b></label>
                        <input type="text" name="teacherPassword" class="form-control" placeholder="Password" value="<?php echo htmlspecialchars($row['teacherPassword']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Contact Number</b></label>
                        <input class="form-control" type="text" name="teacherPhone" placeholder="Teacher Mobile Number" value="<?php echo htmlspecialchars($row['teacherPhone']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Gender</b></label>
                        <select class="form-select" name="teacherGender" required>
                            <option value="1" <?php echo ($row["teacherGender"] == 1) ? 'selected' : ''; ?>>Male</option>
                            <option value="2" <?php echo ($row["teacherGender"] == 2) ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Course</b></label>
                        <select class="form-select" name="courseId" id="courseId" required>
                            <option value="-1">--Select Course--</option>
                            <?php
                            $cStmt = $conn->prepare("SELECT * FROM tblcourse");
                            $cStmt->execute();
                            while ($cRow = $cStmt->fetch()) {
                            ?>
                            <option value="<?php echo $cRow["courseId"]; ?>" <?php echo ($cRow["courseId"] == $currentCourseId) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cRow["courseName"]); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Academic Year</b></label>
                        <select class="form-select" name="academicYearId" id="academicYearId" required>
                            <option value="-1">--Select Academic Year--</option>
                            <?php
                            $ayStmt = $conn->prepare("SELECT * FROM tblAcademicYear");
                            $ayStmt->execute();
                            while ($ayRow = $ayStmt->fetch()) {
                            ?>
                            <option value="<?php echo $ayRow["academicYearId"]; ?>" <?php echo ($ayRow["academicYearId"] == $currentAcademicYearId) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ayRow["academicYearName"]); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Assigned Subject</b></label>
                        <select class="form-select" name="subjectId" id="subjectId" required>
                            <option value="-1">--Select Subject--</option>
                            <?php
                            if ($currentCourseId != -1 && $currentAcademicYearId != -1) {
                                $sStmt = $conn->prepare("SELECT * FROM tblsubject WHERE courseId = :courseId AND academicYearId = :academicYearId AND status = 1");
                                $sStmt->bindParam(":courseId", $currentCourseId);
                                $sStmt->bindParam(":academicYearId", $currentAcademicYearId);
                                $sStmt->execute();
                                while ($sRow = $sStmt->fetch()) {
                                ?>
                                <option value="<?php echo $sRow["subjectId"]; ?>" <?php echo ($sRow["subjectId"] == $currentSubjectId) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($sRow["subjectName"]); ?>
                                </option>
                                <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Assigned Section(s)</b></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="A" id="secA" <?php echo in_array('A', $assignedSections) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="secA">Section A</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="B" id="secB" <?php echo in_array('B', $assignedSections) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="secB">Section B</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="C" id="secC" <?php echo in_array('C', $assignedSections) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="secC">Section C</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sections[]" value="D" id="secD" <?php echo in_array('D', $assignedSections) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="secD">Section D</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Update Teacher</button>
                </form>
            </div>
            <div class="col-md-1"></div>    
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#courseId, #academicYearId").change(function(){
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        if(courseId != "-1" && academicYearId != "-1"){
            $.ajax({
                url: "fetch-subject.php",
                type: "POST",
                data: { courseId: courseId, academicYearId: academicYearId },
                success: function(data){
                    $("#subjectId").html(data);
                }
            });
        } else {
            $("#subjectId").html('<option value="-1">--Select Subject--</option>');
        }
    });
});
</script>
<?php
include "admin-dashboard-footer.php";
?>

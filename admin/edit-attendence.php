<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-content.php";

  $studentId=$_REQUEST['studentId'];
  $subjectId = $_REQUEST["subjectId"];

  $stmt=$conn->prepare("SELECT * FROM tblattendence where studentId=:studentId AND subjectId=:subjectId");
  $stmt->bindParam(":studentId",$studentId);
  $stmt->bindParam(":subjectId",$subjectId);
  $stmt->execute();
  $row=$stmt->fetch();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Attendance</title>
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
                <h2 class="heading-add-admin">Edit Attendance</h2>
                <form class="row" action="edit-attendence-process.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                    <div class="mb-3">
                        <label class="form-label"><b>Date Of Attendance</b></label>
                        <input class="form-control" name="dateOfAttendence"  type="text" placeholder="Date Of Attendence" value="<?php echo date("d/m/Y", strtotime($row['dateOfAttendence'])); ?>" aria-label="default input example" readonly>
                    </div>
                    <?php
                    $studentId  =   $row["studentId"];
                    $stmt=$conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
                    $stmt->bindParam(":studentId",$studentId);
                    $stmt->execute();
                    $student=$stmt->fetch();
                    ?>
                    <div class="mb-3">
                        <label  class="form-label"><b>Student Name</b></label>
                        <input type="text" name="studentName"  class="form-control" placeholder="student Name" value="<?php echo $student['studentName'] ?>" readonly>
                    </div>
                    <?php
                        $courseId   = $student["courseId"];
                        $coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
                        $coursestmt->bindParam(":courseId",$courseId);
                        $coursestmt->execute();
                        $course = $coursestmt->fetch();
                    ?>
                    <div class="mb-3">
                        <label class="form-label"><b>Course</b></label>
                        <input type="text" name="courseId"  class="form-control" placeholder="Course" value="<?php echo $course['courseName'] ?>" readonly>
                    </div>
                    <?php
                    $academicYearId =   $row["academicYearId"];
                    $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                    $yearstmt->bindParam(":academicYearId",$academicYearId);
                    $yearstmt->execute();
                    $years = $yearstmt->fetch();
                    ?>
                    <div class="mb-3">
                        <label  class="form-label"><b>Academic Year</b></label>
                        <input type="text" name="academicYearName"  class="form-control" placeholder="Academic Year" value="<?php echo $years['academicYearName'] ?>" readonly>
                    </div>
                    <?php
                    $subjectstmt=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
                    $subjectstmt->bindParam(":subjectId",$subjectId);
                    $subjectstmt->execute();
                    $subject = $subjectstmt->fetch();
                    ?>
                    <div class="mb-3">
                        <label  class="form-label"><b>Subject</b></label>
                        <input type="text" name="subjectId"  class="form-control" placeholder="Subject" value="<?php echo $subject['subjectName'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <?php if ($row["attendence"] == 1) { ?>
                            <input type="radio" name="attendence" value="1" checked> 
                            <span class="present-btn" style="color:green;">Present</span>
                    
                            <input type="radio" name="attendence" value="0">
                            <span class="absent-btn" style="color:red;">Absent</span>
                        <?php } else { ?>
                            <input type="radio" name="attendence" value="1"> 
                            <span class="present-btn" style="color:green;">Present</span>
                    
                            <input type="radio" name="attendence" value="0" checked>
                            <span class="absent-btn" style="color:red;">Absent</span>
                        <?php } ?>
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
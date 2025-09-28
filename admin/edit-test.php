<?php
  session_start();
  include "admin-dashboard-top.php";
  include "admin-dashboard-navbar.php";
  include "admin-dashboard-content.php";
  $id = $_REQUEST["id"];
  $stmt=$conn->prepare("SELECT * FROM tbltest WHERE id=:id");
  $stmt->bindParam(":id",$id);
  $stmt->execute();
  $result=$stmt->fetch();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .fees-content
        {
            margin-top:20px;
        }
        .form-section
        {
             background: #fff;
             margin:40px auto;
             box-shadow:0 0 10px;
             border-radius:10px;
             padding:10px;
        }
        .heading-fees
        {
            text-align:center;
            border-bottom:2px solid black;
        }
        .submit
        {
            width: 98%;
            margin:10px 10px 10px 10px;
        }
    </style>
  </head>
    <div class="col-md-10 form-section">
        <body>
            <form class="fees-content" action="edit-test-process.php" method="POST">
                <?php if ($_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Test Type Not Selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Course Not Selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 3) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Academic Year Not Selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 4) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Subject Not Selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 5) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Date Is NOt Filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <div class="heading-fees">
                    <h3>EDIT TEST</h3>
                </div>
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                <div class="mb-3">
                    <label class="form-label"><b>Select Test</b></label>
                    <select class="form-select" name="testId" aria-label="Default select example" id="testId" >
                        <option value="-1">--Select Test--</option>
                        <?php
                        $teststmt=$conn->prepare("SELECT * FROM tblTestDetail");
                        $teststmt->execute();
                        
                        while($test=$teststmt->fetch())
                        {
                        ?>
                        <option value="<?php echo $test['testId'] ?>" <?php echo ($test['testId'] == $result['testId']) ? 'selected' : ''; ?>><?php echo $test['testName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Max Marks For The Test</b></label>
                    <input class="form-control" type="text" placeholder="Max Marks" name="maximumMarks" id="maximumMarks" value="<?php echo $result['maximumMarks'] ?>" aria-label="default input example" readonly>    
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Course</b></label>
                    <select class="form-select" name="courseId" aria-label="Default select example" id="courseId">
                        <option value="-1">--Select Course--</option>
                        <?php
                        $coursestmt=$conn->prepare("SELECT * FROM tblcourse");
                        $coursestmt->execute();
                        
                        while($course=$coursestmt->fetch())
                        {
                        ?>
                        <option value="<?php echo $course['courseId'] ?>" <?php echo ($course['courseId'] == $result['courseId']) ? 'selected' : ''; ?>><?php echo $course['courseName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Academic Year</b></label>
                    <select class="form-select" name="academicYearId" aria-label="Default select example" id="academicYearId">
                        <option value="-1">--Select Academic Year--</option>
                        <?php
                        $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear");
                        $yearstmt->execute();
                        
                        while($year=$yearstmt->fetch())
                        {
                        ?>
                        <option value="<?php echo $year['academicYearId'] ?>" <?php echo ($year['academicYearId'] == $result['academicYearId']) ? 'selected' : ''; ?>><?php echo $year['academicYearName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Subject</b></label>
                    <select class="form-select" name="subjectId" aria-label="Default select example" id="subjectId">
                        <option value="-1">--Select Subject--</option>
                        <?php
                        $courseId = $result["courseId"];
                        $academicYearId = $result["academicYearId"];
                        $subjectstmt=$conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId");
                        $subjectstmt->bindParam(":courseId",$courseId);
                        $subjectstmt->bindParam(":academicYearId",$academicYearId);
                        $subjectstmt->execute();
                        
                        while($subject=$subjectstmt->fetch())
                        {
                        ?>
                        <option value="<?php echo $subject['subjectId'] ?>" <?php echo ($subject['subjectId'] == $result['subjectId']) ? 'selected' : ''; ?>><?php echo $subject['subjectName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Date Of Test</b></label>
                    <input class="form-control" type="date" placeholder="DD/MM/YY" name="dateOfTest" value="<?php echo $result["dateOfTest"] ?>" aria-label="default input example">    
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Session</b></label>
                    <select class="form-select" name="sessionId"   aria-label="Default select example" id="sessionId">
                        <option value="-1">--Select Session--</option>
                        <?php
                            $query1 = "SELECT * FROM tblsession WHERE status = 1";
                            $stmt = $conn->prepare($query1);
                            $stmt->execute();
                
                            
                            while ($row = $stmt->fetch()) {
                        ?>
                        <option value="<?php echo $row["sessionId"]; ?>" <?php echo($result['sessionId'] == $row['sessionId'])? 'selected' : '' ?>>
                            <?php echo htmlspecialchars($row["sessionName"]); ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary submit">Edit Test</button>
            </form>
        </body>
    </div>
    </div>
    </div>
<?php
    include "admin-dashboard-footer.php";
    session_destroy();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#testId").change(function(){
            var testId = $("#testId").val();
            if(testId == -1)
            {
                return;
            } else {
                $.ajax({
                   url:"fetch-maximum-marks.php",
                   type:"POST",
                   data:{ testId: testId },
                   success: function(response)
                   {
                       $("#maximumMarks").val(response);
                   }
                });
            }
        });   
    });
</script>

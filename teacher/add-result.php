<?php
  session_start();
  include "teacher-dashboard-top.php";
  include "teacher-dashboard-content.php";
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Test Result</title>
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
            <form class="fees-content" action="add-result-process.php" method="POST">
                
                <div class="heading-fees">
                    <h3>ADD TEST RESULT</h3>
                </div>
                <input type="hidden" value="1" name="testStatus">
                <div class="mb-3">
                    <label class="form-label"><b>Select Test</b></label>
                    <select class="form-select" name="testId" aria-label="Default select example" id="testId">
                        <option value="-1">--Select Test--</option>
                        <?php
                        $teststmt=$conn->prepare("SELECT * FROM tblTestDetail");
                        $teststmt->execute();
                        
                        while($test=$teststmt->fetch())
                        {
                        ?>
                        <option value="<?php echo $test['testId'] ?>"><?php echo $test['testName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Max Marks For The Test</b></label>
                    <input class="form-control" type="text" placeholder="Max Marks" name="maximumMarks" id="maximumMarks" aria-label="default input example" readonly>    
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
                        <option value="<?php echo $course['courseId'] ?>"><?php echo $course['courseName'] ?></option>
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
                        <option value="<?php echo $year['academicYearId'] ?>"><?php echo $year['academicYearName'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Subject</b></label>
                    <select class="form-select" name="subjectId" aria-label="Default select example" id="subjectId">
                        <option value="-1">--Select Subject--</option>
                    </select>
                </div>
                <div class="mb-3">
                    <table class="table" >
                        <thead class="table-bordered table-dark">
                            <tr>
                                <th>Student Id</th>
                                <th>Student Name</th>
                                <th>Course</th>
                                <th>Academic Year</th>
                                <th>Subject</th>
                                <th>Marks Obtained</th>
                            </tr>
                        </thead> 
                        <tbody id="studentTable">
                            
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary submit">Add Test Result</button>
            </form>
        </body>
    </div>
    </div>
    </div>
<?php
    include "teacher-dashboard-footer.php";
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){

    
    $("#testId").change(function(){
        var testId = $("#testId").val();
        if(testId == -1){
            $("#maximumMarks").val('');
        } else {
            $.ajax({
                url:"fetch-maximum-marks.php",
                type:"POST",
                data:{ testId: testId },
                success: function(response){
                    $("#maximumMarks").val(response);
                }
            });
        }
    });

   
    $("#courseId , #academicYearId").change(function(){
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();

        if(courseId == -1 || academicYearId == -1){
            $("#subjectId").html('<option value="-1">--Select Subject--</option>');
        } else {
            $.ajax({
                url:"fetch-subject.php",
                type:"POST",
                data: { courseId: courseId, academicYearId: academicYearId },
                success: function(response){
                    $("#subjectId").html(response);
                    $("#studentTable").html(''); 
                }
            });
        }
    });

    
    $("#subjectId").change(function(){
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        var subjectId = $("#subjectId").val();
        var testId = $("#testId").val();

        if(courseId == -1 || academicYearId == -1 || subjectId == -1 || testId == -1){
            $("#studentTable").html('No Record Found');
        } else {
            $.ajax({
                url:"fetch-student-table-result.php",
                type:"POST",
                data: { courseId: courseId, academicYearId: academicYearId, subjectId: subjectId , testId: testId },
                success: function(response){
                    $("#studentTable").html(response);
                }
            });
        }
    });

});

</script>

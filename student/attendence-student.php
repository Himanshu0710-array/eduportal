<?php
    include "../splitting-student/top-student.php";
    include "../splitting-student/content-student.php";
    include "../database-connect.php";
    
    $query1 = "SELECT * FROM tblstudent where studentId=:studentId";
    $stmt=$conn->prepare($query1);
    $stmt->bindParam(":studentId",$studentId);
    $stmt->execute();
    $row = $stmt->fetch();
    
    $academicYearId =   $row["academicYearId"];
    $courseId       =   $row["courseId"];
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .content 
    {
        background-color: #f8f9fa;
        padding-bottom: 30px;
        height:130vh;
    }
    
    .heading-fees {
        text-align: center;
        border-bottom: 2px solid black;
        padding-bottom: 10px;
    }
    .fee-text {
        font-size: 20px;
        text-align: center;
        line-height: 1.4; 
        
    }
    .fee-text-1 {
        text-align: center;
        font-size: 20px;
        line-height: 1.4; 
        
    }
    .fees-box1, .fees-box2, .fees-box3 {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        height: 200px;
        border-radius: 25px;
        margin-top: 80px;
        padding: 20px; 
        transition: all 0.3s ease-in-out;
    }
    
    .fees-box1 
    { 
        background-color: #AED6F1; 
        
    }
    .discountMoney
    {
        padding:2px;
        border-radius:5px;
        font-size:18px;
    }
    .totalPayable
    {
        padding:2px;
        border-radius:5px;
        font-size:18px;
        
    }
    .fees-box2 
    { 
        background-color: #A9DFBF; 
        
    }
    .fees-box3 
    { 
        background-color: #F5B7B1; 
    }
    
    .fees-box1:hover, .fees-box2:hover, .fees-box3:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        transform: scale(1.02);
    }
    
    
    
    h4 {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
        text-align:center;
    }
    .transaction-table
    {
        margin-top:50px;
    }
    .duedate
    {
        margin-top:25px;
    }
  </style>
  
  </head>
  <body class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div>
                    <h2 class="heading-fees">ATTENDANCE TRACKER</h2>
                    <input type="hidden" name="studentId" value="<?php echo $row['studentId'] ?>" id="studentId">
                </div>
            </div>
        </div>
        <?php
            
            $stmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
            $stmt->bindParam(":academicYearId",$academicYearId);
            $stmt->execute();
            $year=$stmt->fetch();
        ?>
         <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Academic Year</label>
            <input type="text" value="<?php echo $year['academicYearName'] ?>" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Select Subject</b></label>
            <select class="form-select" name="subjectId" id="subjectId">
                <option value="-1">--Select Subject--</option>
                <?php
                $academicYearId =   $row["academicYearId"];
                $courseId       =   $row["courseId"];
                $stmt = $conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId AND status = 1");
                $stmt->bindParam(":courseId",$courseId);
                $stmt->bindParam(":academicYearId",$academicYearId);
                $stmt->execute();
                while ($subject = $stmt->fetch()) {
                ?>
                    <option value="<?php echo $subject['subjectId']; ?>">
                        <?php echo $subject['subjectName']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 fees-box1">
                <h4>Total Classes</h4>  
                <p class="fee-text" id="totalClass"><strong></strong></p>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 fees-box2">
                <h4>Classes Attended</h4>  
                <p class="fee-text-1" id="classAttended">
                   <strong></p></strong>
            </div> 
            <div class="col-md-1"></div>
            <div class="col-md-3 fees-box3">
                <h4>Overall Attendance</h4>  
                <p class="fee-text-1" id="overallAttendence"><strong></strong></p>
            </div> 
        </div>
    </div>
    
<div class="transaction-table">
    <div>
        <h3 class="heading-fees">CLASS ATTENDENCE RECORD FOR THIS SESSION</h3>
    </div>
    <table class="table table-hover table-bordered" >
        <thead class="table-dark">
            <tr>
                <th scope="col">COURSE</th>
                <th scope="col">ACADEMIC YEAR</th>
                <th scope="col">SUBJECT</th>
                <th scope="col">DATE OF CLASS</th>
                <th scope="col">ATTENDANCE</th>
            </tr>
        </thead>
        <tbody id="tbl-student-attendence">
                                    
        </tbody>
    </table>
</div>
<?php
include "../splitting-student/footer.php";
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
    $("#subjectId").change(function(){
        var subjectId = $("#subjectId").val();
        var studentId = $("#studentId").val();

        if(subjectId == -1) {
            return;
        }

        
        $.ajax({
            url: "fetch-student-attendence.php",
            type: "POST",
            data: {subjectId: subjectId , studentId: studentId},
            success: function(response) {
                $("#totalClass").text(response);
            }
        });

        
        $.ajax({
            url: "fetch-student-attended.php",
            type: "POST",
            data: {subjectId: subjectId , studentId: studentId},
            success: function(response) {
                $("#classAttended").text(response);
            }
        });

       
        $.ajax({
            url: "fetch-student-overall-attendence.php",
            type: "POST",
            data: {subjectId: subjectId , studentId: studentId},
            success: function(response) {
                $("#overallAttendence").text(response);
            }
        });

        
        $.ajax({
            url: "fetch-student-attendence-table.php",
            type: "POST",
            data: {subjectId: subjectId , studentId: studentId},
            success: function(response) {
                $("#tbl-student-attendence").html(response);
            }
        });
    });
});

</script>


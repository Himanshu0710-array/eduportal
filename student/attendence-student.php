<?php
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";
include "../database-connect.php";

$query1 = "SELECT * FROM tblstudent WHERE studentId=:studentId";
$stmt = $conn->prepare($query1);
$stmt->bindParam(":studentId", $studentId);
$stmt->execute();
$row = $stmt->fetch();

$academicYearId = $row["academicYearId"];
$courseId = $row["courseId"];

$stmt = $conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->execute();
$year = $stmt->fetch();
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Attendance Tracker</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #edf2fb, #e2eafc);
        color: #2c3e50;
    }

    .dashboard-container {
        margin-top: 10px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px 30px;
    }

    .heading-fees {
        text-align: center;
        color: #1f3c88;
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card {
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        color: #fff;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .stat-card h5 {
        font-weight: 600;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card p {
        font-size: 28px;
        font-weight: 700;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .bg-blue { background: linear-gradient(135deg, #74b9ff, #0984e3); }
    .bg-green { background: linear-gradient(135deg, #00b894, #55efc4); }
    .bg-pink { background: linear-gradient(135deg, #ff7675, #fab1a0); }

    label {
        font-weight: 600;
        color: #34495e;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 10px 15px;
        border: 1.5px solid #dcdcdc;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1f3c88;
        box-shadow: 0 0 6px rgba(31, 60, 136, 0.3);
    }

    .table-container {
        margin-top: 60px;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background: #1f3c88;
        color: #fff;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #f1f5ff;
        transition: 0.2s;
    }

    .no-data {
        color: #7f8c8d;
        text-align: center;
        padding: 25px;
    }

    @media (max-width: 768px) {
        .stat-card { margin-bottom: 20px; }
    }
</style>
</head>

<body>
<div class="container dashboard-container">
    <h2 class="heading-fees">Attendance Tracker</h2>

    <input type="hidden" name="studentId" id="studentId" value="<?php echo $row['studentId']; ?>">


    <div class="mb-4">
        <label>Academic Year</label>
        <input type="text" class="form-control" readonly 
               value="<?php echo $year['academicYearName'] ?? 'N/A'; ?>">
    </div>


    <div class="mb-5">
        <label>Select Subject</label>
        <select class="form-select" name="subjectId" id="subjectId">
            <option value="-1">-- Select Subject --</option>
            <?php
            $stmt = $conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId AND status = 1");
            $stmt->bindParam(":courseId",$courseId);
            $stmt->bindParam(":academicYearId",$academicYearId);
            $stmt->execute();
            while ($subject = $stmt->fetch()) {
                echo '<option value="'.$subject['subjectId'].'">'.$subject['subjectName'].'</option>';
            }
            ?>
        </select>
    </div>

    <div class="row text-center">
        <div class="col-md-4">
            <div class="stat-card bg-blue">
                <h5>Total Classes</h5>
                <p id="totalClass">--</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-green">
                <h5>Classes Attended</h5>
                <p id="classAttended">--</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-pink">
                <h5>Overall Attendance</h5>
                <p id="overallAttendence">--</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <h4 class="text-center mb-4 mt-4 text-uppercase" style="color:#1f3c88;">Attendance Record</h4>
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th>COURSE</th>
                        <th>ACADEMIC YEAR</th>
                        <th>SUBJECT</th>
                        <th>DATE OF CLASS</th>
                        <th>ATTENDANCE</th>
                    </tr>
                </thead>
                <tbody id="tbl-student-attendence">
                    <tr><td colspan="5" class="no-data">Select a subject to view your attendance records</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../splitting-student/footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#subjectId").change(function(){
        var subjectId = $("#subjectId").val();
        var studentId = $("#studentId").val();

        if(subjectId == -1) {
            $("#tbl-student-attendence").html("<tr><td colspan='5' class='no-data'>Please select a subject.</td></tr>");
            $("#totalClass, #classAttended, #overallAttendence").text("--");
            return;
        }


        $.post("fetch-student-attendence.php", {subjectId, studentId}, function(response){
            $("#totalClass").text(response);
        });


        $.post("fetch-student-attended.php", {subjectId, studentId}, function(response){
            $("#classAttended").text(response);
        });

      
        $.post("fetch-student-overall-attendence.php", {subjectId, studentId}, function(response){
            $("#overallAttendence").text(response);
        });

        $.post("fetch-student-attendence-table.php", {subjectId, studentId}, function(response){
            $("#tbl-student-attendence").html(response);
        });
    });
});
</script>
</body>
</html>

<?php
      include "admin-dashboard-top.php";
  include "admin-dashboard-content.php";
  include_once "../database-connect.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Management Of Student</title>
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
         .tbl-heading
        {
            text-align:center;
            border-bottom:2px solid black;
            margin-bottom:20px;
        }
    </style>
  </head>
  <body>
  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
        <div class="modal-header" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none;">
          <h5 class="modal-title" id="successModalLabel">✅ Attendance Marked Successfully!</h5>
        </div>
        <div class="modal-body text-center py-4">
          <p class="mb-3" style="font-size: 1.05rem; color: #374151;">Attendance has been saved. Would you like to download a copy?</p>
          <a id="downloadBtn" href="#" class="btn btn-success btn-lg me-2" style="border-radius: 10px;">
            <i class="bi bi-download me-1"></i> Download CSV
          </a>
        </div>
        <div class="modal-footer justify-content-center" style="border: none;">
          <a href="admin-dashboard.php" class="btn btn-primary px-4" style="border-radius: 10px;">OK &mdash; Go to Dashboard</a>
        </div>
      </div>
    </div>
  </div>
    <div class="container">
        <div class="row main">
            <div class="col-md-1"></div>
            <div class="col-md-10 content-add-admin">
                <h3 class="heading-add-admin">ATTENDENCE MANAGEMENT</h3>
                <form class="row" action="attendence-management-process.php" method="POST">
                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Date Of Attendance is Not Filled
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Course Is Not Selected
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 3) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Academic Year Is Not Selected
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 4) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Subject Is Not Selected
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 5) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Session Is Not Selected
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <div>
                        <label for="exampleFormControlInput1" class="form-label"><b>Date Of Attendence</b></label>
                        <input class="form-control" type="date" placeholder="DD/MM/YY" value="<?php echo date('Y-m-d'); ?>" name="dateOfAttendence" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Course</b></label>
                        <select class="form-select" name="courseId" id="courseId">
                            <option value="-1">--Select Course--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tblcourse");
                            $stmt->execute();
                            while ($course = $stmt->fetch()) {
                                $selected = (isset($_SESSION["courseId"]) && $_SESSION["courseId"] == $course['courseId']) ? "selected" : "";
                            ?>
                                <option value="<?php echo $course['courseId']; ?>" <?php echo $selected; ?>>
                                    <?php echo $course['courseName']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Select Academic Year</b></label>
                        <select class="form-select" name="academicYearId" id="academicYearId">
                            <option value="-1">--Select Academic Year--</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tblAcademicYear");
                            $stmt->execute();
                            while ($year = $stmt->fetch()) {
                                $selected = (isset($_SESSION["academicYearId"]) && $_SESSION["academicYearId"] == $year['academicYearId']) ? "selected" : "";
                            ?>
                                <option value="<?php echo $year['academicYearId']; ?>" <?php echo $selected; ?>>
                                    <?php echo $year['academicYearName']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Select Subject</b></label>
                        <select class="form-select" name="subjectId" id="subjectId">
                            <option value="-1">--Select Subject--</option>
                            
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Select Session</b></label>
                        <select class="form-select" name="sessionId" aria-label="Default select example" id="sessionId">
                            <option value="-1">--Select Session--</option>
                            <?php
                            $query1 = "SELECT * FROM tblsession WHERE status = 1";
                            $stmt = $conn->prepare($query1);
                            $stmt->execute();

                            while ($row = $stmt->fetch()) {
                                $selected = (isset($_SESSION["sessionId"]) && $_SESSION["sessionId"] == $row['sessionId']) ? "selected" : "";
                            ?>
                                <option value="<?php echo $row["sessionId"]; ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($row["sessionName"]); ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-center mt-4">Student List</h4>
                        <table class="table  table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Student Id</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">
                                    
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Mark Attendance</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
   $("#courseId , #academicYearId").change(function(){
    var courseId = $("#courseId").val();
    var academicYearId = $("#academicYearId").val();
    if(courseId == -1 || academicYearId == -1)
    {
        $("#subjectId").html('<option value="-1">--Select Subject--</option>');
    } else{
        $.ajax({
            url:"fetch-subject.php",
            type:"POST",
            data : { courseId: courseId , academicYearId: academicYearId },
            success: function (response){
                $("#subjectId").html(response);
            }
        });
    }
   }); 
});
$(document).ready(function(){
  $("#courseId,#academicYearId,#sessionId").change(function(){
      var courseId = $("#courseId").val();
      var academicYearId = $("#academicYearId").val();
      var sessionId = $("#sessionId").val();
      if(courseId == "-1" || academicYearId == "-1" || sessionId == "-1")
      {
         return; 
      } else{
          $.ajax({
            url:"fetch-student-table.php",
            type:"POST",
            data: { courseId: courseId, academicYearId: academicYearId, sessionId: sessionId },
            success: function (response) {
                $("#studentTableBody").html(response);
            }
          });
      }
  });  
});


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"></script>
<script>
$(document).ready(function() {
    // Show success modal if redirected after marking attendance
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        var downloadUrl = 'download-attendance.php?' +
            'dateOfAttendence=' + encodeURIComponent(urlParams.get('dateOfAttendence')) +
            '&courseId='        + encodeURIComponent(urlParams.get('courseId')) +
            '&academicYearId='  + encodeURIComponent(urlParams.get('academicYearId')) +
            '&subjectId='       + encodeURIComponent(urlParams.get('subjectId')) +
            '&sessionId='       + encodeURIComponent(urlParams.get('sessionId'));

        $('#downloadBtn').attr('href', downloadUrl);
        var modal = new bootstrap.Modal(document.getElementById('successModal'), { backdrop: 'static', keyboard: false });
        modal.show();
    }
});
</script>
<?php
// session_destroy removed - admin session must stay alive
?>

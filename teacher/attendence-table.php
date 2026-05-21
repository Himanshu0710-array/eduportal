<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
  include "teacher-dashboard-top.php";
  include "teacher-dashboard-content.php";
  include_once "../database-connect.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Table Of Student</title>
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
        /* ===== Page Loader ===== */
        #page-loader {
            position: fixed; inset: 0;
            background: rgba(15, 23, 42, 0.7);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 16px;
            transition: opacity 0.4s ease;
        }
        #page-loader.hidden { opacity: 0; pointer-events: none; }
        .loader-ring {
            width: 56px; height: 56px;
            border: 5px solid rgba(255,255,255,0.15);
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        .loader-text { color: #fff; font-size: 0.95rem; font-weight: 500; }
        @keyframes spin { to { transform: rotate(360deg); } }
        /* ===== AJAX Spinner ===== */
        #ajax-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .spinner-border-blue { color: #3b82f6; }
    </style>
  </head>
  <body>
  <!-- Page Loader -->
  <div id="page-loader" class="hidden">
      <div class="loader-ring"></div>
      <span class="loader-text">Loading...</span>
  </div>
    <div class="container">
        <div class="row main">
            <div class="col-md-1"></div>
            <div class="col-md-10 content-add-admin">
                <h3 class="heading-add-admin">ATTENDENCE TABLE</h3>
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
                        <label for="dateOfAttendence" class="form-label"><b>Date Of Attendance</b></label>
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" name="dateOfAttendence" id="dateOfAttendence" aria-label="default input example">
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
                        <button type="button" class="btn btn-primary w-100" id="loadStudents">Load Students</button>
                    </div>
                    <div class="mb-3" id="ajax-spinner">
                        <div class="spinner-border spinner-border-blue" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Fetching students...</p>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-center mt-4">Student List</h4>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span id="download-area"></span>
                        </div>
                        <table class="table  table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Student Id</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Date Of Attendence</th>
                                    <th scope="col">Attendence</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">
                                    
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
</div>
<?php
    include "teacher-dashboard-footer.php"
?>  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Page transition loader: show on all link clicks
    $("a:not([href^='#'])").on('click', function() {
        var href = $(this).attr('href');
        if (href && href !== '' && !href.startsWith('javascript')) {
            $('#page-loader').removeClass('hidden');
        }
    });
    // Hide loader when page is fully loaded
    $(window).on('load', function() {
        setTimeout(function() { $('#page-loader').addClass('hidden'); }, 200);
    });

    $("#courseId, #academicYearId").change(function() {
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        
        if (courseId == -1 || academicYearId == -1) {
            $("#subjectId").html('<option value="-1">--Select Subject--</option>');
        } else {
            $.ajax({
                url: "fetch-subject.php",
                type: "POST",
                data: { courseId: courseId, academicYearId: academicYearId },
                success: function(response) {
                    $("#subjectId").html(response);
                }
            });
        }
    });

    $("#loadStudents").click(function() {
        var dateOfAttendence = $("#dateOfAttendence").val();
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        var subjectId = $("#subjectId").val();
        var sessionId = $("#sessionId").val();

        if (courseId == "-1" || academicYearId == "-1" || subjectId == "-1" || sessionId == "-1") {
            alert("Please Fill All The Details");
            return;
        }

        // Show spinner, hide old table
        $('#ajax-spinner').show();
        $('#studentTableBody').html('');
        $('#download-area').html('');

        $.ajax({
            url: "fetch-student-table-attendence-table.php",
            type: "POST",
            data: { 
                dateOfAttendence: dateOfAttendence, 
                courseId: courseId, 
                academicYearId: academicYearId, 
                subjectId: subjectId, 
                sessionId: sessionId 
            },
            success: function(response) {
                $('#ajax-spinner').hide();
                $("#studentTableBody").html(response);
                // Show download button after results load
                var downloadUrl = 'download-attendance.php?dateOfAttendence=' + encodeURIComponent(dateOfAttendence)
                    + '&courseId=' + encodeURIComponent(courseId)
                    + '&academicYearId=' + encodeURIComponent(academicYearId)
                    + '&subjectId=' + encodeURIComponent(subjectId)
                    + '&sessionId=' + encodeURIComponent(sessionId);
                $('#download-area').html('<a href="' + downloadUrl + '" class="btn btn-success btn-sm"><i class="bi bi-download me-1"></i> Download CSV</a>');
            },
            error: function() {
                $('#ajax-spinner').hide();
                $('#studentTableBody').html('<tr><td colspan="6" class="text-danger">Error loading data. Please try again.</td></tr>');
            }
        });
    });
});
</script>
<?php
// Clear only the form-related session variables, NOT the login session
unset($_SESSION["dateOfAttendence"]);
unset($_SESSION["courseId"]);
unset($_SESSION["academicYearId"]);
unset($_SESSION["subjectId"]);
unset($_SESSION["sessionId"]);
?>

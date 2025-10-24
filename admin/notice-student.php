<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-content.php";
  include "../database-connect.php";
  $query = "SELECT * FROM tblcourse";
  $stmt=$conn->prepare($query);
  $stmt->execute();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendence Notice</title>
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
        .date
        {
            margin-bottom:10px;
        }
    </style>
  </head>
    <div class="col-md-10 form-section">
        <body>
            <form class="fees-content" action="notice-student-process.php" method="POST">
                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Course is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Academic Year not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 3): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Total Fees for Academic Year is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 4): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Session is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 5): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Due date not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="heading-fees">
                    <h3>NOTICE FOR SHORT ATTENDENCE</h3>
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label"><b>Select Course</b></label>
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" name="courseId" id="courseId">
                            <option value="-1" >--Select Course--</option>
                            <?php
                                    while($result=$stmt->fetch())
                                    {
                                ?>
                                <option value="<?php echo $result['courseId'] ?>" ><?php echo $result['courseName'] ?></option>
                                <?php
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label"><b>Select Academic Year</b></label>  
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" name="academicYearId" id="academicYearId">
                            <option value="-1" >--Select Academic Year--</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Cut Off Attendence</b></label>
                    <input class="form-control" type="number" placeholder="Minimum Attendence In The Subject In Percent" name="cutOffAttendence" aria-label="default input example" max="100" id="cutOffAttendence">    
                </div>
                <label for="exampleInputEmail1" class="form-label"></label>
                <div class="form-floating">
                    <textarea name="notice" class="form-control"  style="display:none;"readonly>We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.
                    </textarea>
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
                        <option value="<?php echo $row["sessionId"]; ?>">
                            <?php echo $row["sessionName"]; ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="date">
                    <label for="exampleFormControlInput1" class="form-label"><b>Notice Date</b></label>
                    <input class="form-control" type="date" name="noticeDate" aria-label="default input example" value="<?php echo date('Y-m-d'); ?>">    
                </div>
                <div class="col-mb-3">
                    <table class="table table-bordered table-hover" id="defaulterStudents">
                      
                    </table>
                </div>
                <button type="submit" class="btn btn-primary submit">Send Notice</button>
            </form>
        </body>
    </div>
    </div>
    </div>
<?php
    include "admin-dashboard-footer.php";
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
    $("#courseId").change(function () {
        var courseId = $("#courseId").val();

        if (courseId == "-1") {
            $("#academicYearId").html('');
        }

        $.ajax({
            url: "get-academic-year.php",
            type: "POST",
            data: { courseId: courseId },
            success: function (response) {
                $("#academicYearId").html(response);
            }
        });
    });

    function fetchDefaulters() {
        var courseId = $("#courseId").val();
        var academicYearId = $("#academicYearId").val();
        var cutOffAttendence = $("#cutOffAttendence").val(); 

        if (courseId == "-1" || academicYearId == "-1" || cutOffAttendence.length == 0) {
            return;
        } else {
            $.ajax({
                url: "get-defaulter-students.php",
                type: "POST",
                data: { courseId: courseId, academicYearId: academicYearId, cutOffAttendence: cutOffAttendence },
                success: function (response) {
                    $("#defaulterStudents").html(response);
                }
            });
        }
    }

    $("#courseId, #academicYearId").change(fetchDefaulters);
    $("#cutOffAttendence").keyup(fetchDefaulters);
});

</script>
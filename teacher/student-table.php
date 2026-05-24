<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "../database-connect.php";
include "teacher-dashboard-top.php";
include "teacher-dashboard-content.php";
include "fun-specialchar.php";
$tstmt = $conn->prepare("SELECT * FROM tblteacher WHERE teacherId = :teacherId");
$tstmt->bindParam(":teacherId", $teacherId);
$tstmt->execute();
$teacher = $tstmt->fetch();

$courseId = 0;
$academicYearId = 0;
$sections = [];
if ($teacher && !empty($teacher['subjectId'])) {
    $substmt = $conn->prepare("SELECT courseId, academicYearId FROM tblsubject WHERE subjectId = :subjectId");
    $substmt->bindParam(":subjectId", $teacher['subjectId']);
    $substmt->execute();
    $sub = $substmt->fetch();
    if ($sub) {
        $courseId = $sub['courseId'];
        $academicYearId = $sub['academicYearId'];
    }
    if (!empty($teacher['section'])) {
        $sections = explode(',', $teacher['section']);
    }
}

if ($courseId > 0 && $academicYearId > 0 && !empty($sections)) {
    $placeholders = implode(',', array_fill(0, count($sections), '?'));
    $query = "SELECT * FROM tblstudent WHERE courseId = ? AND academicYearId = ? AND section IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $params = array_merge([$courseId, $academicYearId], $sections);
    $stmt->execute($params);
} else {
    $stmt = $conn->prepare("SELECT * FROM tblstudent WHERE 1=0");
    $stmt->execute();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .tbl-heading
        {
            text-align:center;
            border-bottom:2px solid black;
            margin-bottom:20px;
        }
        .tbl-content
        {
            box-shadow:0 0 10px;
            margin-top:20px;
            border-radius:10px;
            padding: 20px;
            background: #fff;
        }
        .icons
        {
          float:left; 
        }
    </style>
  
  </head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="tbl-content">
            <div class="tbl-heading">
            <h2>STUDENT TABLE</h2>    
            </div>
            <table id="studentsTable" class="table table-hover table-bordered">
              <thead class="table-dark">
                <tr>
                  <th scope="col">Student Id</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Course</th>
                  <th scope="col">Academic Year</th>
                  <th scope="col">Section</th>
                  <th scope="col">E-Mail</th>
                  <th scope="col">Session</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    while($result=$stmt->fetch())
                    {
                ?>
                    <tr>
                    <td><?php echo $result['studentId']; ?></td>
                      <td><?php echo textSafe($result['studentName']); ?></td>
                      <td>
                          <?php  
                             $result['courseId']; 
                             $courseId=$result['courseId'];
                             $stmt2=$conn->prepare("SELECT * FROM tblcourse where courseId=:courseId");
                             $stmt2->bindParam(":courseId",$courseId);
                             $stmt2->execute();
                             $row=$stmt2->fetch();
                             echo $row["courseName"];
                          ?>
                      </td>
                      <td>
                          <?php  
                             $academicYearId=$result['academicYearId'];
                             $stmt3=$conn->prepare("SELECT * FROM tblAcademicYear where academicYearId=:academicYearId");
                             $stmt3->bindParam(":academicYearId",$academicYearId);
                             $stmt3->execute();
                             $row3=$stmt3->fetch();
                             if($row3) echo $row3["academicYearName"];
                          ?>
                      </td>
                      <td><?php echo $result['section']; ?></td>
                      <td><?php echo textSafe($result['studentEmail']); ?></td>
                    <td>
                        <?php  
                            $sessionId = $result['sessionId']; 
                            $sessionstmt=$conn->prepare("SELECT * FROM tblsession WHERE sessionId = :sessionId");
                            $sessionstmt->bindParam(":sessionId",$sessionId);
                            $sessionstmt->execute();
                            $session = $sessionstmt->fetch();
                            if($session) echo $session['sessionName'];
                        ?>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: center;">
                            <a href="view-student-report.php?studentId=<?php echo $result['studentId']; ?>" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-file-earmark-bar-graph"></i> View Report
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>
              </tbody>  
            </table>     
        </div>
    </div>    
</div>
</body>
</div>
</div>
<?php
    include "teacher-dashboard-footer.php";
?>  
<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#studentsTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "language": {
            "search": "Filter students:"
        }
    });
});
</script>

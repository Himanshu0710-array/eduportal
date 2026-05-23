<?php
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";
include "fun-specialchar.php";
$conditions = [];
$params = [];

if (isset($_GET['courseId']) && $_GET['courseId'] != '-1') {
    $conditions[] = "courseId = :courseId";
    $params[':courseId'] = $_GET['courseId'];
}
if (isset($_GET['academicYearId']) && $_GET['academicYearId'] != '-1') {
    $conditions[] = "academicYearId = :academicYearId";
    $params[':academicYearId'] = $_GET['academicYearId'];
}
if (isset($_GET['section']) && $_GET['section'] != '-1') {
    $conditions[] = "section = :section";
    $params[':section'] = $_GET['section'];
}

$query = "SELECT * FROM tblstudent";
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}
$stmt = $conn->prepare($query);
foreach ($params as $key => &$val) {
    $stmt->bindParam($key, $val);
}
$stmt->execute();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            
            <form method="GET" action="student-table.php" class="row mb-4 align-items-end g-3 px-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Course</label>
                    <select class="form-select" name="courseId">
                        <option value="-1">All Courses</option>
                        <?php
                        $c_stmt = $conn->prepare("SELECT * FROM tblcourse");
                        $c_stmt->execute();
                        while($c = $c_stmt->fetch()){
                            $sel = (isset($_GET['courseId']) && $_GET['courseId']==$c['courseId']) ? 'selected' : '';
                            echo "<option value='".$c['courseId']."' $sel>".$c['courseName']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Academic Year</label>
                    <select class="form-select" name="academicYearId">
                        <option value="-1">All Years</option>
                        <?php
                        $a_stmt = $conn->prepare("SELECT * FROM tblAcademicYear");
                        $a_stmt->execute();
                        while($a = $a_stmt->fetch()){
                            $sel = (isset($_GET['academicYearId']) && $_GET['academicYearId']==$a['academicYearId']) ? 'selected' : '';
                            echo "<option value='".$a['academicYearId']."' $sel>".$a['academicYearName']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Section</label>
                    <select class="form-select" name="section">
                        <option value="-1">All Sections</option>
                        <option value="A" <?php echo (isset($_GET['section']) && $_GET['section']=='A') ? 'selected' : ''; ?>>Section A</option>
                        <option value="B" <?php echo (isset($_GET['section']) && $_GET['section']=='B') ? 'selected' : ''; ?>>Section B</option>
                        <option value="C" <?php echo (isset($_GET['section']) && $_GET['section']=='C') ? 'selected' : ''; ?>>Section C</option>
                        <option value="D" <?php echo (isset($_GET['section']) && $_GET['section']=='D') ? 'selected' : ''; ?>>Section D</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Student Id</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Course</th>
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
                             $courseId=$result['courseId'];
                             $stmt2=$conn->prepare("SELECT * FROM tblcourse where courseId=:courseId");
                             $stmt2->bindParam(":courseId",$courseId);
                             $stmt2->execute();
                             $row=$stmt2->fetch();
                             echo $row ? $row["courseName"] : "<span class='text-danger'>Unknown Course</span>";
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
                            echo $session ? $session['sessionName'] : "<span class='text-danger'>Unknown Session</span>";
                        ?>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <a href="manage-student.php?studentId=<?php echo $result['studentId']; ?>" style="color: #0d6efd; text-decoration: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <span>|</span>
                            <a href="delete-student.php?studentId=<?php echo $result['studentId']; ?>" style="color: red; text-decoration: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
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
    include "admin-dashboard-footer.php";
    
?>  

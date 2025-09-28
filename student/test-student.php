<?php
include "../database-connect.php";
session_start();
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$stmt=$conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();
$student=$stmt->fetch();
function marks($x , $y)
{
    return $x/$y * 100;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-heading {
            text-align: center;
            border-bottom: 2px solid black;
            margin-top: 20px;
        }
        .table {
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  </head>
  <body>
     <div class="container-fluid">
         <div class="row">
            <div class="test-heading">
                <h2 class="animate__animated animate__fadeInDown animate__slower">TEST DETAILS</h2>    
            </div>
            <div class="table">
                <table class="table table-bordered animate__animated animate__fadeInUp animate__slower">
                  <thead class="table-dark">
                    <tr>
                      <th scope="col">Test</th>
                      <th scope="col">Course</th>
                      <th scope="col">Academic Year</th>
                      <th scope="col">Subject</th>
                      <th scope="col">Maximum Marks</th>
                      <th scope="col">Marks Obtained</th>
                      <th scope="col">Date Of Test</th>
                      <th scope="col">Session</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $courseId = $student["courseId"];
                      $academicYearId = $student["academicYearId"];
                      
                      $stmt = $conn->prepare("SELECT * FROM tbltest WHERE courseId=:courseId AND academicYearId=:academicYearId");
                      $stmt->bindParam(":courseId", $courseId);
                      $stmt->bindParam(":academicYearId", $academicYearId);
                      $stmt->execute();
                      
                      while($test = $stmt->fetch()) {
                          $testId = $test["testId"];
                          
                          $stmtDetail = $conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
                          $stmtDetail->bindParam(":testId", $testId);
                          $stmtDetail->execute();
                          $testDetail = $stmtDetail->fetch();
                      ?>
                        <tr class="animate__animated animate__fadeIn animate__slower">
                            <td><?php echo $testDetail['testName']; ?></td>
                            <td>
                              <?php  
                              $courseId = $student['courseId'];
                              $coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
                              $coursestmt->bindParam(":courseId",$courseId);
                              $coursestmt->execute();
                              $course=$coursestmt->fetch();
                              echo $course["courseName"];
                              ?>
                            </td>
                            <td>
                              <?php  
                              $academicYearId = $student['academicYearId'];
                              $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                              $yearstmt->bindParam(":academicYearId",$academicYearId);
                              $yearstmt->execute();
                              $year=$yearstmt->fetch();
                              echo $year["academicYearName"];
                              ?>
                            </td>
                            <td>
                              <?php  
                              $subjectId = $test['subjectId'];
                              $subjectstmt=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
                              $subjectstmt->bindParam(":subjectId",$subjectId);
                              $subjectstmt->execute();
                              $subject=$subjectstmt->fetch();
                              echo $subject["subjectName"];
                              ?>
                            </td>
                            <td><?php echo $test['maximumMarks']; ?></td>
                            <?php
                            $testId = $test["testId"];
                            $subjectId=$test['subjectId'];
                            $studentId = $student["studentId"];
                            
                            $resultstmt=$conn->prepare("SELECT * FROM tblresult WHERE testId=:testId AND subjectId=:subjectId AND studentId=:studentId");
                            $resultstmt->bindParam(":testId",$testId);
                            $resultstmt->bindParam(":subjectId",$subjectId);
                            $resultstmt->bindParam(":studentId",$studentId);
                            $resultstmt->execute();
                            $result=$resultstmt->fetch();
                            $resultCount = $resultstmt->rowCount();
                            if($resultCount > 0)
                            {
                            ?>
                            <td><?php echo $result['marksObtained']; ?></td>
                            <?php
                            } else{
                            ?>
                            <td><?php echo "-"; ?></td>
                            <?php
                            }
                            ?>
                            <td><?php echo date('d-m-Y', strtotime($test['dateOfTest'])); ?></td>
                            <td>
                                <?php  
                                    $sessionId = $test['sessionId']; 
                                    $sessionstmt=$conn->prepare("SELECT * FROM tblsession WHERE sessionId = :sessionId");
                                    $sessionstmt->bindParam(":sessionId",$sessionId);
                                    $sessionstmt->execute();
                                    $session = $sessionstmt->fetch();
                                    echo $session['sessionName'];
                                ?>
                            </td>
                            <?php
                                $status = $test["testStatus"];
                                if($status == 1 || $result=$resultstmt->fetch()) 
                                {
                                    $marksObtained = $result['marksObtained'];
                                    $percent = marks($marksObtained , $test['maximumMarks']);
                                    if($percent > 35)
                                    {
                                        echo "<td><span style='color: green; font-weight: bold;'>Pass</span></td>";
                                    } else {
                                        echo "<td><span style='color: red; font-weight: bold;'>Fail</span></td>";
                                    }
                                } else {
                                    echo "<td><span class='text-danger '>Upcoming</span></td>";
                                }
                            ?>
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
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 

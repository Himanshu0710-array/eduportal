<?php
include "../database-connect.php";
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";
include "fun-specialchar.php";
$query="SELECT * FROM tbltest";
$stmt=$conn->prepare($query);
$stmt->execute();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Table</title>
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
                <h2>TEST TABLE</h2>    
            </div>
            <div class="mb-3">
                <label class="form-label"><b>Search The Test By Course</b></label>
                <select class="form-select" name="courseId" id="courseId">
                    <option value="-1">--Select Course--</option>
                    <?php
                    $coursestmt = $conn->prepare("SELECT * FROM tblcourse");
                    $coursestmt->execute();
                    while ($course = $coursestmt->fetch()) {
                    ?>
                        <option value="<?php echo $course['courseId']; ?>">
                            <?php echo $course['courseName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <table class="table table-hover table-bordered" >
              <thead>
                <tr>
                  <th scope="col">Test Type</th>
                  <th scope="col">Course</th>
                  <th scope="col">Academic Year</th>
                  <th scope="col">Subject</th>
                  <th scope="col">Date Of Test</th>
                  <th scope="col">Session</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="table">
                <?php
                    while($result=$stmt->fetch())
                    {
                ?>
                    <tr>
                        <td>
                            <?php
                                $testId = $result["testId"];
                                $teststmt=$conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
                                $teststmt->bindParam(":testId",$testId);
                                $teststmt->execute();
                                $test=$teststmt->fetch();
                                echo $test["testName"];
                            ?>
                        </td>
                        <td>
                         <?php 
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
                                $academicYearId =  $result['academicYearId']; 
                                $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                                $yearstmt->bindParam(":academicYearId",$academicYearId);
                                $yearstmt->execute();
                                $year=$yearstmt->fetch();
                                echo $year["academicYearName"];
                            ?>
                        </td>
                        <td>
                            <?php  
                                $subjectId = $result['subjectId']; 
                                $subjectstmt=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
                                $subjectstmt->bindParam(":subjectId",$subjectId);
                                $subjectstmt->execute();
                                $year=$subjectstmt->fetch();
                                echo $year["subjectName"];
                            ?>
                        </td>
                     <td><?php echo date("d/m/Y", strtotime($result['dateOfTest'])); ?></td>
                     <td>
                            <?php  
                                $sessionId = $result['sessionId']; 
                                $sessionstmt=$conn->prepare("SELECT * FROM tblsession WHERE sessionId = :sessionId");
                                $sessionstmt->bindParam(":sessionId",$sessionId);
                                $sessionstmt->execute();
                                $session = $sessionstmt->fetch();
                                echo $session['sessionName'];
                            ?>
                        </td>
                    <td>
                        <a href="edit-test.php?id=<?php echo $result['id'];?> ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </a> 
                             |
                        <a href="delete-test.php?testId=<?php echo $result['testId']; ?>" style="color: red; text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </a>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
       $("#courseId").change(function(){
        var courseId = $("#courseId").val();
        if(courseId == -1)
        {
            $.ajax({
               url:"full-test-table.php",
               type:"POST",
               success: function(response){
                   $("#table").html(response);
               }
            });
        } else{
            $.ajax({
               url: "fetch-test-table-from-course.php",
               type: "POST",
               data: { courseId: courseId },
               success : function(response){
                   $("#table").html(response);
               }
               
            });
        }
       });
    });
</script>
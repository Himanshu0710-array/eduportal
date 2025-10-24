<?php
include "../database-connect.php";
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";
include "fun-specialchar.php";




$query = "SELECT * FROM tblfees ORDER BY feeId DESC";
$stmt=$conn->prepare($query);
$stmt->execute();


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fees Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .top
        {
            margin-top:10px;
            border-bottom:2px solid black;
            margin-bottom:10px;
        }
        .tbl-heading
        {
            text-align:center;
        }
        .tbl-content
        {
            box-shadow:0 0 10px;
            margin-top:20px;
            border-radius:10px;
        }
        .icons
        {
          display: flex; 
          align-items: center; 
          gap: 10px;  
        }
    </style>
  
  </head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 tbl-content">
            <div class="container-fluid">
                <div class="row top">
                    <div class="col-md-5 col-sm-5">    
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <div class="tbl-heading">
                            <h2>Fees Table</h2>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1">
                        
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Enter The Student Id " aria-label="Search" id="studentId">
                        </form>    
                    </div>
                </div>
            </div>
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Fees Id</th>
                  <th scope="col">Student Id</th>
                  <th scope="col">Course</th>
                  <th scope="col">Academic Year</th>
                  <th scope="col">Total Fees</th>
                  <th scope="col">Discount Money</th>
                  <th scope="col">Total Payable</th>
                  <th scope="col">Paid Fees</th>
                  <th scope="col">Session</th>
                  <th scope="col">Date Of Submission Of Fees</th>
                  <th scope="col">Edit/Delete</th>
                </tr>
              </thead>
              <tbody id="tbldata">
                <?php
                    
                    while($result=$stmt->fetch())
                    {
                        $totalPayable = $result["totalFees"] - $result["discountMoney"];
                ?>
                    <tr>
                    <td><?php echo $result['feeId'] ?></td>
                    <td><?php echo $result['studentId'] ?></td>
                    <td>
                    <?php 
                        $courseId=$result['courseId'];
                        $query="SELECT * FROM tblcourse WHERE courseId=:courseId";
                        $coursestmt=$conn->prepare($query);
                        $coursestmt->bindParam(":courseId",$courseId);
                        $coursestmt->execute();
                        $courses=$coursestmt->fetch();
                        echo $courses["courseName"];  
                    ?>
                    </td>
                    <td>
                        <?php 
                            $academicYearId = $result['academicYearId'];
                            $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                            $yearstmt->bindParam(":academicYearId",$academicYearId);
                            $yearstmt->execute();
                            $academicYears=$yearstmt->fetch();
                            
                            echo $academicYears["academicYearName"];
                        ?>
                    </td>
                    <td><?php echo $result['totalFees']; ?></td>
                    <td><?php echo $result['discountMoney']; ?></td>
                    <td><?php echo $totalPayable; ?></td>
                    <td><?php echo $result['paidFees']; ?></td>
                    <td>
                        <?php 
                            $sessionId = $result['sessionId']; 
                            $sessionstmt=$conn->prepare("SELECT * FROM tblsession WHERE sessionId=:sessionId");
                            $sessionstmt->bindParam(":sessionId",$sessionId);
                            $sessionstmt->execute();
                            $sessions=$sessionstmt->fetch();
                            echo $sessions["sessionName"];
                        ?>
                    </td>
                    <td>
                    <?php 
                        $formattedDate = date("d/m/y", strtotime($result['dateOfSubmissionOfFees']));
                        echo $formattedDate;
                    ?>
                    </td>
                    <td>
                        <div class="icons">
                            <a href="edit-fees.php?feeId=<?php echo $result['feeId']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>

                            |
                            <form action="delete-fees.php?feeId=<?php echo $fees['feeId'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this row?');">
                                <input type="hidden" name="feeId" value="<?php echo $result['feeId']; ?>">
                                <button type="submit" style="border: none; background: none; cursor: pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>
                            </form>
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
    include "admin-dashboard-footer.php"
?> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
  $("#studentId").keyup(function(){
    var studentId = $(this).val()

    if (studentId.length <= 0) {
        $.ajax({
            url: "fetch-all-fees.php", 
            type: "POST",
            success: function(response) {
                $("#tbldata").html(response);
            }
        });
    } else 
    {
       
        $.ajax({
        url: "search-student-fees.php",
        type: "POST",
        data: { studentId: studentId },
        success: function(response) {
          $("#tbldata").html(response);
        }
      });
    }
  });
});

</script>



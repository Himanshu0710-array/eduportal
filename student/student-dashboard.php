<?php
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$stmt3 = $conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
$stmt3->bindParam(":studentId",$studentId);
$stmt3->execute();
$studentDetail = $stmt3->fetch();

$courseId = $studentDetail["courseId"];
$academicYearId = $studentDetail["academicYearId"];


 
$totalstmt=$conn->prepare("SELECT * FROM tblattendence WHERE courseId=:courseId AND academicYearId=:academicYearId AND studentId=:studentId");
$totalstmt->bindParam(":courseId",$courseId);
$totalstmt->bindParam(":academicYearId",$academicYearId);
$totalstmt->bindParam(":studentId",$studentId);
$totalstmt->execute();

$totalClasses = $totalstmt->rowCount();


$attendstmt=$conn->prepare("SELECT * FROM tblattendence WHERE courseId=:courseId AND academicYearId=:academicYearId AND studentId=:studentId AND attendence = 1");
$attendstmt->bindParam(":courseId",$courseId);
$attendstmt->bindParam(":academicYearId",$academicYearId);
$attendstmt->bindParam(":studentId",$studentId);
$attendstmt->execute();

$ClassesAttended = $attendstmt->rowCount();

function percent($x,$y)
{
    if($y>0)
    {
       return number_format( $x/$y * 100 , 2);
    } else{
        echo " ";
    }
}

$currentAttendence = percent($ClassesAttended,$totalClasses);

?>
<title>Student Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<body class="">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-6 col-sm-6 data box-1 animate__animated animate__slideInDown animate__slow">
                <div class="row">
                    <div class="col-md-4 image text-center">
                        <?php
                        $query = "SELECT * FROM tblstudent WHERE studentId=:studentId";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(":studentId", $studentId);
                        $stmt->execute();
                        $result = $stmt->fetch();
                    
                        $imagePath = !empty($result['studentImage']) ? 'uploads/' . $result['studentImage'] : ($result['studentGender'] == '1' ? "images/female-logo.jpg" : "images/male-logo.jpg");
                        ?>
                    
                        <img src="<?php echo $imagePath; ?>" alt="Profile" style="width:150px; height:150px; border-radius:50%; object-fit:cover; cursor:pointer;" data-bs-target="#uploadModal">
                    </div>
                    <div class="col-md-7 text-box-1">
                        <p class="admin-name"><strong>Welcome, <?php echo $result['studentName']; ?></strong></p>
                        <p class="student-quote">Keep learning, keep growing!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 animate__animated animate__slideInRight animate__slow">
                <div class="container-fluid data box-2">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col text-center"><strong>Notice Board</strong></div>
                        <div class="col"></div>
                    </div>
                    <div>
                        <?php
                        $noticestmt=$conn->prepare("SELECT * FROM tblnotice WHERE studentId=:studentId ORDER BY id DESC");
                        $noticestmt->bindParam(":studentId",$studentId);
                        $noticestmt->execute();
                        
                        while($notices=$noticestmt->fetch())
                        {
                        ?>
                        <div class="notice-boxes">
                            <p class="notice-date"><b>Notice Date : </b><?php echo date('d-m-Y', strtotime($notices['noticeDate']));?></p>
                            <div>
                                
                                <span style="color: red;">SHORT ATTENDENCE NOTICE !!</span>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#noticeModal<?php echo $notices['id']; ?>">
                                    Read More
                                </button>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col data-2 box-test box-1  animate__animated animate__slideInUp animate__slow">
                <div><span class="text"><strong>Subjects</strong></span></div>
                <div class="container-fluid">
                    <table class="table table-bordered tbl-subject table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Subject</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $studentstmt = $conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
                            $studentstmt->bindParam(":studentId", $studentId);
                            $studentstmt->execute();
                            $student = $studentstmt->fetch();

                            $subjectstmt = $conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId");
                            $subjectstmt->bindParam(":courseId", $student["courseId"]);
                            $subjectstmt->bindParam(":academicYearId", $student["academicYearId"]);
                            $subjectstmt->execute();
                            
                            

                            while ($subject = $subjectstmt->fetch()) {
                                $subjectId = $subject["subjectId"];

                                $stmt = $conn->prepare("SELECT * FROM tblattendence WHERE studentId=:studentId AND subjectId=:subjectId");
                                $stmt->bindParam(":studentId", $studentId);
                                $stmt->bindParam(":subjectId", $subjectId);
                                $stmt->execute();
                                $totalClass = $stmt->rowCount();

                                $stmt = $conn->prepare("SELECT * FROM tblattendence WHERE studentId=:studentId AND subjectId=:subjectId AND attendence=1");
                                $stmt->bindParam(":studentId", $studentId);
                                $stmt->bindParam(":subjectId", $subjectId);
                                $stmt->execute();
                                $attended = $stmt->rowCount();
                                
                                
                                $attendancePercent = percent($attended , $totalClass);
                            ?>
                                <tr>
                                    <td><?php echo $subject['subjectName']; ?></td>
                                    <td>
                                        <?php echo $attendancePercent . '%'; ?>
                                        <div class="progress " style="height: 10px;  widht:10px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width:<?php echo $attendancePercent; ?>%;" aria-valuenow="<?php echo $attendancePercent; ?>" aria-valuemin="0" aria-valuemax="100">
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href="attendence-student.php" class="btn btn-primary btn-sm btn-attendence">View Details</a>
                </div>
            </div>
            <div class="col data-1 box-test box-1 animate__animated animate__slideInUp animate__slow">
                <?php
                    $courseId = $result["courseId"];
                    $academicYearId = $result["academicYearId"];
                    $teststmt=$conn->prepare("SELECT * FROM tbltest WHERE courseId=:courseId AND academicYearId=:academicYearId");
                    $teststmt->bindParam(":courseId",$courseId);
                    $teststmt->bindParam(":academicYearId",$academicYearId);
                    $teststmt->execute(); 
                ?>
                <span class="text"><strong>Tests Details</strong></span>
                <div class="container-fluid">
                    <table class="table table-bordered tbl-subject table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Subject</th>
                                <th scope="col">Test Type</th>
                                <th scope="col">Date Of Test</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($test=$teststmt->fetch())
                            {
                            $testId = $test["testId"];
                            $testIdstmt = $conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
                            $testIdstmt->bindParam(":testId", $testId);
                            $testIdstmt->execute();
                            
                           
                            $testDetail = $testIdstmt->fetch();
                            
                            

                            
                            $subjectId  =   $test["subjectId"];
                            
                            $stmt9=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
                            $stmt9->bindParam(":subjectId",$subjectId);
                            $stmt9->execute();
                            $subjects=$stmt9->fetch();
                            ?>
                            <tr>
                                <td><?php echo $subjects['subjectName']; ?></td>
                                <td><?php echo $testDetail['testName']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($test['dateOfTest']))?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                </table> 
                <a href="test-student.php" class="btn btn-primary btn-sm btn-attendence">View Details</a>
                </div>
            </div>
            <div class="col data-1 box-test box-1 animate__animated animate__slideInUp animate__slow">
                <div>
                    <span class="text"><strong>Fees Details</strong></span>
                </div>
                <div class="container-fluid">
                    <div>
                        <?php
                            $academicYearId=$student["academicYearId"];
                            $fstmt=$conn->prepare("SELECT *,(SELECT SUM(paidFees) FROM tblfees WHERE studentId=:studentId AND academicYearId=:academicYearId ) AS totalPaid FROM tblfees WHERE studentId=:studentId AND academicYearId=:academicYearId");
                            $fstmt->bindParam(":studentId",$studentId);
                            $fstmt->bindParam(":academicYearId",$academicYearId);
                            $fstmt->execute();
                            $fees=$fstmt->fetch();
                            $totalPaid = $fees["totalPaid"];
                        ?>
                        <p><strong>Total Fees:</strong> ₹<?php echo $fees['totalFees'] ?></p>
                        <p><strong>Paid:</strong> ₹<?php echo $totalPaid ?></p>
                        <p><strong>Discount:</strong> ₹<?php echo $fees['discountMoney'] ?></p>
                        <?php
                            function subtract($a, $b , $c) {
                                return $a - $b -$c;
                            }
                            
                            $dueFees = subtract($fees["totalFees"], $totalPaid , $fees["discountMoney"]);
                        ?>
                        <p><strong>Due:</strong> ₹<?php echo  $dueFees ;
                        ?></p>
                        <?php
                            if($dueFees == 0)
                            {
                             ?>
                             <p><strong>Status:</strong> <span style="color: green;">Paid</span></p>
                             <?php
                            } 
                            else 
                            {
                                ?>
                                <p><strong>Status:</strong> <span style="color: red;">Pending</span></p>
                            <?php
                            }
                            ?>
                        <a href="fees-student.php" class="btn btn-primary btn-sm">View Details</a>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <?php
        $noticestmt->execute();
        while($notices=$noticestmt->fetch())
        {
    ?>
    <div class="modal fade" id="noticeModal<?php echo $notices['id']; ?>" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noticeModalLabel">Notice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $id = $notices["id"];
                    $noticestmt2 = $conn->prepare("SELECT * FROM tblnotice WHERE id<=:id ORDER BY id DESC");
                    $noticestmt2->bindParam(":id", $id);
                    $noticestmt2->execute();
                    $noticeDetail = $noticestmt2->fetch();

                    
                    $studentstmt=$conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
                    $studentstmt->bindParam(":studentId",$studentId);
                    $studentstmt->execute();
                    $students=$studentstmt->fetch();
                    
                    
                    
                    ?>
                    <p><b>Notice Date:</b> <?php echo date('d-m-Y', strtotime($noticeDetail['noticeDate'])); ?></p>
                    <p><b>Dear:</b> <?php echo $students['studentName']; ?></p>
                    <p><?php echo $noticeDetail['notice']; ?></p>
                    <p><b>Your Current Attendance: </b> 
                       <span style="color: red;">
                           <?php 
                           if($currentAttendence > 0)
                           {
                           echo $currentAttendence; 
                           } else{
                              echo "0"; 
                           }
                           ?>%
                           </span>
                    </p>
                    <p><b>Minimum Attendance Required: </b> 
                       <span style="color: green;"><?php echo $noticeDetail['cutOffAttendence']; ?>%</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</body>
</html>
<?php include "../splitting-student/footer.php"; ?>
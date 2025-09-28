<?php
    include "../splitting-student/top-student.php";
    include "../splitting-student/content-student.php";
    include "../database-connect.php";
    
    
    
    $query1 = "SELECT * FROM tblstudent where studentId=:studentId";
    $stmt=$conn->prepare($query1);
    $stmt->bindParam(":studentId",$studentId);
    $stmt->execute();
    $row = $stmt->fetch();
    
    $academicYearId = $row["academicYearId"];
    
    
    $stmt=$conn->prepare("SELECT SUM(paidFees) as totalPaid , discountMoney FROM tblfees where studentId=:studentId AND academicYearId=:academicYearId");
    $stmt->bindParam(":studentId",$studentId);
    $stmt->bindParam(":academicYearId",$academicYearId);
    $stmt->execute();
    $totalPaid=$stmt->fetch();
    
    
    
    $courseId=$row["courseId"];
    $stmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
    $stmt->bindParam(":courseId",$courseId);
    $stmt->execute();
    $course=$stmt->fetch();
    $courseDuration=$course["courseDuration"];
    
    $stmt=$conn->prepare("SELECT * FROM tblAcademicYear");
    $stmt->execute();
    $academicYears=$stmt->fetchAll();
    $year=$academicYears["academicYearId"];
    
    $stmt=$conn->prepare("SELECT * FROM tblsession WHERE status=1");
    $stmt->execute();
    $sessionId=$stmt->fetch();
    
    
    $academicYearId =   $row["academicYearId"];
    $courseId       =   $row["courseId"];
    $sessionId      =   $sessionId["sessionId"];
    $stmt=$conn->prepare("SELECT * FROM tblCourseFees where courseId=:courseId AND academicYearId=:academicYearId AND sessionId=:sessionId");
    $stmt->bindParam(":courseId",$courseId);
    $stmt->bindParam(":academicYearId",$academicYearId);
    $stmt->bindParam(":sessionId",$sessionId);
    $stmt->execute();
    $courseFees=$stmt->fetch();
    
    function diff($x,$y)
    {
        return $x-$y;
    }
    $totalFees = diff($courseFees['totalFees'],$totalPaid["discountMoney"]);
    $dueFees = diff($totalFees,$totalPaid["totalPaid"]);
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fees Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .content 
    {
        background-color: #f8f9fa;
        padding-bottom: 30px;
        height:130vh;
    }
    
    .heading-fees {
        text-align: center;
        border-bottom: 2px solid black;
        padding-bottom: 10px;
    }
    .fee-text {
        font-size: 20px;
        text-align: center;
        line-height: 1.4; 
        
    }
    .fee-text-1 {
        text-align: center;
        font-size: 20px;
        line-height: 1.4; 
        
    }
    .fees-box1, .fees-box2, .fees-box3 {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        height: 200px;
        border-radius: 25px;
        margin-top: 80px;
        padding: 20px; 
        transition: all 0.3s ease-in-out;
    }
    
    .fees-box1 
    { 
        background-color: #AED6F1; 
        
    }
    .discountMoney
    {
        padding:2px;
        border-radius:5px;
        font-size:18px;
    }
    .totalPayable
    {
        padding:2px;
        border-radius:5px;
        font-size:18px;
        
    }
    .fees-box2 
    { 
        background-color: #A9DFBF; 
        
    }
    .fees-box3 
    { 
        background-color: #F5B7B1; 
    }
    
    .fees-box1:hover, .fees-box2:hover, .fees-box3:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        transform: scale(1.02);
    }
    
    
    
    h4 {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
        text-align:center;
    }
    .transaction-table
    {
        margin-top:50px;
    }
    .duedate
    {
        margin-top:25px;
    }
  </style>
  
  </head>
  <body class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div>
                    <h2 class="heading-fees">FEES TRACKER</h2>
                </div>
            </div>
        </div>
        <?php
            $academicYearId = $row["academicYearId"];
            $stmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
            $stmt->bindParam(":academicYearId",$academicYearId);
            $stmt->execute();
            $year=$stmt->fetch();
        ?>
         <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Academic Year</label>
            <input type="text" value="<?php echo $year['academicYearName'] ?>" class="form-control" readonly>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 fees-box1">
                <h4>Total Fees</h4>
                    <?php
                        if($totalPaid['discountMoney'] <= 0)
                        {
                        ?>
                            <p class="fee-text"><strong>₹<?php echo $courseFees['totalFees']; ?></strong></p>
                            
                    <?php
                        }else
                        {
                    ?>
                        <span style="padding: 2px; border-radius: 5px; font-size: 18px; text-align: center;">Total Fees: <strong>₹<?php echo $courseFees['totalFees']; ?></strong></span>
                        <br>
                        <span class="discountMoney">Discount Money: <strong>₹<?php echo $totalPaid['discountMoney']; ?></strong></span>
                        <br>
                        <span class="totalPayable">Total Payable: <strong>₹<?php echo $totalFees; ?></strong></span>   
                        <?php
                        }
                    ?>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 fees-box2">
                <h4>Paid Fees</h4>  
                <p class="fee-text-1">
                   <strong>₹<?php 
                        if($totalPaid["totalPaid"])
                        {
                            echo $totalPaid["totalPaid"]; 
                        }
                        else
                        {
                           $totalPaid["totalPaid"] = 0;  
                           echo $totalPaid["totalPaid"];
                        }

                    ?></p></strong>
            </div> 
            <div class="col-md-1"></div>
            <div class="col-md-3 fees-box3">
                <h4>Due Fees</h4>  
                <p class="fee-text-1"><strong>₹<?php echo $dueFees?></strong></p>
            </div> 
        </div>
    </div>
    <?php
    if($dueFees>0)
    {
    ?>
    <div class="alert alert-warning text-center duedate">
        <strong>Note:</strong> Your fee due date is <strong><?php echo date("d/m/Y", strtotime($courseFees['dueDate'])); ?></strong>
    </div>
    <?php
    }
    ?>
    

    
<?php
$academicYearId = $row["academicYearId"];
$stmt = $conn->prepare("SELECT * FROM tblfees WHERE studentId=:studentId AND academicYearId=:academicYearId ORDER BY feeId DESC ");
$stmt->bindParam(":studentId", $studentId);
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->execute(); 
?>

<div class="transaction-table">
    <div>
        <h2 class="heading-fees">TRANSACTION HISTORY OF THIS YEAR</h2>
    </div>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">Student Id</th>
                <th scope="col">Academic Year</th>
                <th scope="col">Transaction Money</th>
                <th scope="col">Date of Transaction</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($result = $stmt->fetch()) { 
            ?>
            <tr>
                <td><?php echo $result["studentId"]; ?></td>
                <td>
                <?php 
                    $academicYearId = $result['academicYearId'];
                    $academicYearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                    $academicYearstmt->bindParam(":academicYearId",$academicYearId);
                    $academicYearstmt->execute();
                    $academicYears=$academicYearstmt->fetch();
                    echo $academicYears["academicYearName"];
                ?>
                </td>
                <td><span style="color: green; font-weight: bold;">₹<?php echo $result["paidFees"]; ?></span></td>
                <td><?php echo date("d/m/Y", strtotime($result["dateOfSubmissionOfFees"])); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
include "../splitting-student/footer.php";
?>


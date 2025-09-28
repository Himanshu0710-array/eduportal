<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-navbar.php";
  include "admin-dashboard-content.php";
  include "../database-connect.php";
  $feeId    =   $_REQUEST["feeId"];
  $stmt=$conn->prepare("SELECT * FROM tblfees WHERE feeId=:feeId");
  $stmt->bindParam(":feeId",$feeId);
  $stmt->execute();
  $fees=$stmt->fetch();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Fees</title>
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
    </style>
  </head>
    <div class="col-md-10 form-section">
        <body>
            <form class="fees-content" action="edit-fees-process.php" method="POST">
                <?php if ($_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Student Id is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Course  is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 3) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Academic Year is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 4) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Total Fees is not Filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 5) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Paid Fees is not Filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 6) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Date Of Submission Of Fees is not Valid
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 7) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Session is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <div class="heading-fees">
                    <h3>FEES</h3>
                </div>
                <input type="hidden" name="feeId" value="<?php echo $fees["feeId"]; ?>">
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Student Id</b></label>
                    <input class="form-control" type="number" placeholder="Student Id"  name="studentId" value="<?php echo $fees["studentId"] ?>"  aria-label="default input example" id="studentId">    
                </div>
                <div>
                    <p id="studentName" ></p> 
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label"><b>Select Course</b></label>
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" name="courseId" id="class1">
                            <option value="-1" >--Select Course--</option>
                            <?php
                                $query = "SELECT * FROM tblcourse";
                                $stmt=$conn->prepare($query);
                                $stmt->execute();
                                while($courses=$stmt->fetch())
                                {
                                ?>
                                <option value="<?php echo $courses['courseId'] ?>" <?php echo ($fees['courseId'] == $courses['courseId']) ? 'selected' : ''; ?>>
                                    <?php echo $courses['courseName'] ?></option>
                                <?php
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label" ><b>Select Academic Year</b></label>
                    <div class="input-group">
                        <?php
                            $stmt=$conn->prepare("SELECT * FROM tblAcademicYear");
                            $stmt->execute();
                        ?>
                        <select class="form-select" aria-label="Default select example" name="academicYearId" id="academicYear" >
                            <option value="-1" >--Select Academic Year--</option>
                            <?php
                                while($year=$stmt->fetch())
                                {
                            ?>
                            <option value="<?php echo $year['academicYearId']; ?>" <?php echo ($fees['academicYearId'] == $year['academicYearId']) ? 'selected' : ''; ?>>
                                <?php echo $year['academicYearName']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Total Fees</b></label>
                    <input class="form-control" type="number" placeholder="Total Fees Of Course For Academic Year" id="totalFees" name="totalFees" value="<?php echo $fees["totalFees"] ?>" aria-label="default input example" readonly>    
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Discounted Money</b></label>
                    <input class="form-control" type="number" placeholder="Discounted Money" id="discountMoney" name="discountMoney" value="<?php echo $fees['discountMoney'] ?>"aria-label="default input example">    
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Paid Fees</b></label>
                    <input class="form-control" type="number" placeholder="Total Fees Of Course For Academic Year" name="paidFees" value="<?php echo $fees["paidFees"] ?>" aria-label="default input example">    
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Date Of Submission Of Fees</b></label>
                    <input class="form-control" type="date" placeholder="DD/MM/YY" name="dateOfSubmissionOfFees" value="<?php echo $fees["dateOfSubmissionOfFees"] ?>" aria-label="default input example">    
                </div>
                <div class="mb-3">
                    <label class="form-label">Select Session</label>
                    <select class="form-select" name="sessionId"   aria-label="Default select example">
                        <option value="-1">--Select Session--</option>
                        <?php
                            $query1 = "SELECT * FROM tblsession";
                            $stmt = $conn->prepare($query1);
                            $stmt->execute();
                
                            
                            while ($row = $stmt->fetch()) {
                        ?>
                        <option value="<?php echo $row["sessionId"]; ?>" <?php echo($fees['sessionId'] == $row['sessionId']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row["sessionName"]); ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary submit">Submit</button>
            </form>
        </body>
    </div>
    </div>
    </div>
<?php
    include "admin-dashboard-footer.php";
?>  
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
    <title>Add Course Fees</title>
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
            <form class="fees-content" action="add-course-fees-process.php" method="POST">
                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Course is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Academic Year not Selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 3) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Total Fees for Academic Year is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 4) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Session is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 5) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Due date not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <div class="heading-fees">
                    <h3>ADD COURSE FEES</h3>
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label"><b>Select Course</b></label>
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" name="courseId" id="class1">
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
                        <select class="form-select" aria-label="Default select example" name="academicYearId">
                            <option value="-1" >--Select Academic Year--</option>
                            <?php
                                $query = "SELECT * FROM tblAcademicYear";
                                $stmt=$conn->prepare($query);
                                $stmt->execute();
                                while($row=$stmt->fetch())
                                {
                            ?>
                                <option value="<?php echo $row['academicYearId'] ?>" ><?php echo $row['academicYearName'] ?></option>
                                <?php
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Total Fees</b></label>
                    <input class="form-control" type="number" placeholder="Total Fees For The Selected Academic Year" name="totalFees" aria-label="default input example">    
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Session</b></label>
                    <select class="form-select" name="sessionId"   aria-label="Default select example">
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
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Due Date</b></label>
                    <input class="form-control" type="date" placeholder="Last Date To Submit Fees" name="dueDate" aria-label="default input example">    
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
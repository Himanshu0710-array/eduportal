<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-navbar.php";
  include "admin-dashboard-content.php";
  include "../database-connect.php";
  
  $subjectId    =   $_REQUEST["subjectId"];
  
  $stmt=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
  $stmt->bindParam(":subjectId",$subjectId);
  $stmt->execute();
  $result=$stmt->fetch();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Subject</title>
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
            <form class="fees-content" action="edit-subject-process.php" method="POST">
                <?php if ($_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Subject Name not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Course is not selected
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
                    <strong>Error!</strong> Session is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <div class="heading-fees">
                    <h3>EDIT SUBJECT</h3>
                </div>
                <input type="hidden" name="subjectId" value="<?php echo $result['subjectId']?>" >
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Subject Name</b></label>
                    <input class="form-control" type="text" placeholder="Subject Name" name="subjectName" value="<?php echo $result['subjectName'] ?>" aria-label="default input example">    
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Course</b></label>
                    <select class="form-select" name="courseId" id="courseId">
                        <option value="-1">--Select Course--</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tblcourse");
                        $stmt->execute();
                        while ($course = $stmt->fetch()) {
                        ?>
                            <option value="<?php echo $course['courseId'];?>"<?php echo($result['courseId'] == $course['courseId'])? 'selected' : '' ?>>
                                <?php echo $course['courseName']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Academic Year</b></label>
                    <select class="form-select" name="academicYearId" id="academicYearId">
                        <option value="-1">--Select Academic Year--</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tblAcademicYear");
                        $stmt->execute();
                        while ($year = $stmt->fetch()) {
                        ?>
                            <option value="<?php echo $year['academicYearId']; ?>" <?php echo($result['academicYearId'] == $year['academicYearId'])? 'selected' : '' ?>>
                                <?php echo $year['academicYearName']; ?>
                            </option>
                        <?php } ?>
                    </select>
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
                        <option value="<?php echo $row["sessionId"]; ?>" <?php echo($result['sessionId'] == $row['sessionId'])? 'selected' : '' ?>>
                            <?php echo htmlspecialchars($row["sessionName"]); ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <?php
                if($result["status"] == 1)
                {
                 ?>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="1" checked>
                      <label class="form-check-label" for="flexRadioDefault1">
                        <span style="color:green;">Active</span>
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="2"  >
                      <label class="form-check-label" for="flexRadioDefault2">
                        <span style="color:red;">Inactive</span>
                      </label>
                    </div>
                 <?php
                } else{
                    ?>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="1" >
                      <label class="form-check-label" for="flexRadioDefault1">
                        <span style="color:green;">Active</span>
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="2" checked >
                      <label class="form-check-label" for="flexRadioDefault2">
                        <span style="color:red;">Inactive</span>
                      </label>
                    </div>
                    <?php
                }
                ?>
                <button type="submit" class="btn btn-primary submit">Edit Subject</button>
            </form>
        </body>
    </div>
</div>
</div>
<?php
    include "admin-dashboard-footer.php";
?>
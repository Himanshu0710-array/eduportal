<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-content.php";
  
  include "../database-connect.php";
  $courseId=$_REQUEST["courseId"];
  $stmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
  $stmt->bindParam(":courseId",$courseId);
  $stmt->execute();
  $courses=$stmt->fetch();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Course</title>
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
            width:100%;
            margin-top:10px;
            margin-bottom:10px;
        }
    </style>
  </head>
    <div class="col-md-10 form-section">
        <body>
            <form class="fees-content" action="edit-course-process.php" method="POST">
                <?php if ($_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Course Name is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Course Duration is not selected
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
                    <h3>EDIT COURSE</h3>
                </div>
                <input type="hidden" name="courseId" value="<?php echo $courses['courseId'] ?>" >
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Course Name</b></label>
                    <input class="form-control" type="text" placeholder="Course Name" name="courseName" value="<?php echo $courses['courseName'] ?>" aria-label="default input example">    
                </div>
                <div class="mb-3">
                    <label for="basic-url" class="form-label"><b>Select Course Duration</b></label>
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" name="courseDuration" value="<?php echo $courses['courseDuration'] ?>">
                            <option value="-1" >--Select Course Duration--</option>
                            <option value="1" <?php echo ($courses["courseDuration"] == 1) ? 'selected' : ''; ?>>1 Year</option>
                            <option value="2" <?php echo ($courses["courseDuration"] == 2) ? 'selected' : ''; ?>>2 years</option>
                            <option value="3" <?php echo ($courses["courseDuration"] == 3) ? 'selected' : ''; ?>>3 years</option>
                            <option value="4" <?php echo ($courses["courseDuration"] == 4) ? 'selected' : ''; ?>>4 years</option>
                            <option value="5" <?php echo ($courses["courseDuration"] == 5) ? 'selected' : ''; ?>>5 years</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Select Session</b></label>
                    <select class="form-select" name="sessionId"   aria-label="Default select example">
                        <option value="-1">--Select Session--</option>
                        <?php
                            $query1 = "SELECT * FROM tblsession";
                            $stmt = $conn->prepare($query1);
                            $stmt->execute();
                
                            
                            while ($row = $stmt->fetch()) {
                        ?>
                        <option value="<?php echo $row["sessionId"]; ?>" <?php echo($courses['sessionId'] == $row['sessionId']) ? 'selected' : ''; ?>>
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
    <div class="col-md-1"></div>
    </div>
    </div>
<?php
    include "admin-dashboard-footer.php"
?>  
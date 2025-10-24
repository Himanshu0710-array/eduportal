<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-content.php";

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Learning Modules</title>
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
            <form class="fees-content" action="add-special-course-process.php" method="POST">
                <div class="heading-fees">
                    <h3>ADD COURSE</h3>
                </div>
                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Course Name is not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 2) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Course is not selected
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Course Name</b></label>
                    <input class="form-control" type="text" placeholder="Course Name" name="specialCourseName" aria-label="default input example">    
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
                            <option value="<?php echo $course['courseId']; ?>">
                                <?php echo $course['courseName']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="exampleFormControlInput1" class="form-label"><b>Course Description</b></label>
                    <input class="form-control" type="text" placeholder="Course Description" name="specialCourseDescription" aria-label="default input example">    
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
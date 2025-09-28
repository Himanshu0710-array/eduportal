<?php
session_start();
include "../template/navbar.php";
include "../database-connect.php";
$query = "SELECT * FROM tblcourse";
$stmt=$conn->prepare($query);
$stmt->execute();


?>

<!doctype html>
<title>Student Register</title>
<style>
    .register-bg
    {
        background-image: url('images/register.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .header h2
    {
        text-align: center;
        padding: 10px;
        border-bottom: 5px solid black;
    }

    .content {
        margin-top: 100px;
    }

    .left1 h4 {
        text-align: center;
    }

    .right h4 {
        text-align: center;
    }
    .submit-btn
    {
        float:right;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="register-bg">
<div class="container-fluid content">
    <div class="row ">
        <div class="col-md-1"></div>
        <div class="col-md-10 ">
            <div class="header">
                <h2>STUDENT REGISTER</h2>
            </div>
            <form class="row" action="register-process.php" method="post">
                <?php if ($_REQUEST["err"] == 1) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your name is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 2) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your dob is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 3) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your course is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 4) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your session is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 5) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your number is not valid
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 6) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your gender is not selected
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 7) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your email is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 8) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your password is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 9) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your father name is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 10) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your mother name is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 11) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your parents number is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 12) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your parents email is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 13) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your date of registration number is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <?php if ($_REQUEST["err"] == 14) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> your address is not filled
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>
                <div class="col-md-6 left1">
                    <h4>Student Details</h4>
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Full Name</label>
                        <input class="form-control" type="text" name="studentName" value="<?php echo $_SESSION["studentName"]?>" placeholder="Student Name" aria-label="default input example" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Date of Birth</label>
                        <input class="form-control" type="Date" name="dob" value="<?php echo $_SESSION["dob"]?>" placeholder="DD/MM/YYY" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label for="basic-url" class="form-label" >Select Course</label>
                        <div class="input-group">
                            <select class="form-select" aria-label="Default select example" name="courseId" id="class1">
                                <option value="-1" >--Select Course--</option>
                                <?php
                                    while($result=$stmt->fetch())
                                    {
                                ?>
                                <option <?php if($_SESSION['courseId'] == $result['courseId'] ){ echo "selected" ;} ?> value="<?php echo $result['courseId'] ?>" ><?php echo $result['courseName'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden"  name="academicYearId" value="1">
                    <div class="mb-3">
                        <label class="form-label">Select Session</label>
                        <select class="form-select" name="sessionId"   aria-label="Default select example">
                            <option value="-1">--Select Session--</option>
                            <?php
                                $query1 = "SELECT * FROM tblsession WHERE status = 1";
                                $stmt = $conn->prepare($query1);
                                $stmt->execute();
                    
                                
                                while ($row = $stmt->fetch()) {
                            ?>
                            <option <?php if($_SESSION['sessionId'] == $row['sessionId'] ){ echo "selected" ;} ?>value="<?php echo $row["sessionId"]; ?>">
                                <?php echo $row["sessionName"]; ?>
                            </option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student's Mobile Number </label>
                        <input class="form-control" type="number" name="studentNumber" value="<?php echo $_SESSION["studentNumber"]?>" placeholder="Student Mobile Number " aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student's Gender - </label>
                            <select class="form-select" name="studentGender"  value="<?php echo $_SESSION["studentGender"]?>" aria-label="Default select example">
                                <option value="-1">--Select Gender--</option>
                                <option value="1" <?php if($_SESSION['studentGender'] == 1){ echo "selected" ;} ?>>Female</option>
                                <option value="2" <?php if($_SESSION['studentGender'] == 2){ echo "selected" ;} ?>>Male</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student Mail Id </label>
                        <input type="email" class="form-control" type="email" name="studentEmail" value="<?php echo $_SESSION["studentEmail"]?>"  id="exampleInputEmail1" placeholder="Student Mail Id" aria-label="Password input" aria-describedby="emailHelp">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Student Login Password</label>
                        <input type="password" class="form-control" name="studentPassword" value="<?php echo $_SESSION["studentPassword"]?>"  placeholder="Student Password" aria-label="default input example"  id="exampleInputPassword1">
                    </div>
                </div>
                <div class="col-md-6 right">
                    <h4>Parents Details</h4>
                    <div>
                        Father's Name
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Mr.</span>
                            <input type="text" placeholder="Father Name" name="fatherName" value="<?php echo $_SESSION["fatherName"]?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div>
                        Mother's Name
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Mrs.</span>
                        <input type="text" placeholder="Mother Name"name="motherName" value="<?php echo $_SESSION["motherName"]?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Parent's Mobile Number</label>
                        <input class="form-control" type="number" name="parentNumber" value="<?php echo $_SESSION["parentNumber"]?>" placeholder="Parent's Mobile Number" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Parent Mail Id</label>
                        <input class="form-control" type="email" name="parentEmail" value="<?php echo $_SESSION["parentEmail"]?>" placeholder="Parent Mail Id" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Registration</label>
                        <input class="form-control" type="Date" name="dateOfRegistration" value="<?php echo $_SESSION["dateOfRegistration"]?>" placeholder="DD/MM/YYY" aria-label="default input example">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address</label>
                        <div class="form-floating">
                            <input class="form-control" name="address" value="<?php echo $_SESSION["address"]?>" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 115px">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Add Student</button>
                </div>
            </form>
        </div> 
        <div class="col-md-1"></div>
    </div>
</div>
<?php
include "../template/footer.php";
session_destroy();
?>
</body>


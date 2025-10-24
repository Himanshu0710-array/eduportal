<?php
session_start();
include "../template/top.php";
include "../template/navbar.php";
include "../database-connect.php";

// Fetch courses
$query = "SELECT * FROM tblcourse";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch sessions
$query1 = "SELECT * FROM tblsession WHERE status = 1";
$stmtSession = $conn->prepare($query1);
$stmtSession->execute();

// Helper functions
$err = isset($_REQUEST["err"]) ? $_REQUEST["err"] : null;
function getSessionValue($key) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : '';
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/logo1.png">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #e0eafc, #cfdef3);
      font-family: 'Poppins', sans-serif;
    }
    .container {
      padding-top: 80px;
    }
    .register-card {
      background: #fff;
      border-radius: 15px;
      padding: 2rem 2.5rem;
      box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
      margin-top: 40px;
      margin-bottom: 40px;
    }
    .register-header h2 {
      font-weight: 600;
      color: #003366;
      text-align: center;
      margin-bottom: 1.5rem;
      border-bottom: 3px solid #003366;
      display: inline-block;
      padding-bottom: 0.5rem;
    }
    .form-section h4 {
      font-weight: 500;
      color: #444;
      margin-bottom: 1rem;
      border-bottom: 2px solid #eee;
      padding-bottom: 0.3rem;
    }
    .form-floating label {
      color: #555;
    }
    .btn-primary {
      background-color: #003366;
      border-color: #003366;
      border-radius: 10px;
      padding: 0.6rem 1.2rem;
      font-size: 1.1rem;
    }
    .btn-primary:hover {
      background-color: #0055aa;
    }
    .alert {
      font-size: 0.9rem;
      border-radius: 8px;
    }
  </style>
</head>

<body>
<div class="container">
  <div class="register-card">
    <div class="register-header text-center">
      <h2>STUDENT REGISTER</h2>
    </div>

    <form class="row g-4" action="register-process.php" method="post">

      <?php if ($err == 1): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Error! Your name is not filled
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <?php if ($err == 2): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Error! Your DOB is not filled
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <?php if ($err == 3): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your course is not selected
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <?php if ($err == 4): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your session is not selected
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
      <?php if ($err == 5): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your number is not valid
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 6): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your gender is not selected
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 7): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your email is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 8): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your password is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 9): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your father’s name is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 10): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your mother’s name is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 11): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your parent’s number is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 12): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your parent’s email is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 13): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your registration date is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($err == 14): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Error! Your address is not filled
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>


      <!-- Student Details -->
      <div class="col-md-6 form-section">
        <h4>Student Details</h4>

        <div class="mb-3">
          <label class="form-label">Student Full Name</label>
          <input class="form-control" type="text" name="studentName"
                 value="<?php echo getSessionValue('studentName'); ?>"
                 placeholder="Student Name">
        </div>

        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input class="form-control" type="date" name="dob"
                 value="<?php echo getSessionValue('dob'); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Select Course</label>
          <select class="form-select" name="courseId">
            <option value="-1">--Select Course--</option>
            <?php while($result = $stmt->fetch()) { ?>
              <option value="<?php echo $result['courseId']; ?>"
                <?php if (getSessionValue('courseId') == $result['courseId']) echo "selected"; ?>>
                <?php echo $result['courseName']; ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <input type="hidden" name="academicYearId" value="1">

        <div class="mb-3">
          <label class="form-label">Select Session</label>
          <select class="form-select" name="sessionId">
            <option value="-1">--Select Session--</option>
            <?php while($row = $stmtSession->fetch()) { ?>
              <option value="<?php echo $row["sessionId"]; ?>"
                <?php if (getSessionValue('sessionId') == $row['sessionId']) echo "selected"; ?>>
                <?php echo $row["sessionName"]; ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Mobile Number</label>
          <input class="form-control" type="number" name="studentNumber"
                 value="<?php echo getSessionValue('studentNumber'); ?>"
                 placeholder="Student Mobile Number">
        </div>

        <div class="mb-3">
          <label class="form-label">Gender</label>
          <select class="form-select" name="studentGender">
            <option value="-1">--Select Gender--</option>
            <option value="1" <?php if (getSessionValue('studentGender') == 1) echo "selected"; ?>>Female</option>
            <option value="2" <?php if (getSessionValue('studentGender') == 2) echo "selected"; ?>>Male</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="studentEmail"
                 value="<?php echo getSessionValue('studentEmail'); ?>"
                 placeholder="Student Email">
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="studentPassword"
                 value="<?php echo getSessionValue('studentPassword'); ?>"
                 placeholder="Student Password">
        </div>
      </div>

      <!-- Parent Details -->
      <div class="col-md-6 form-section">
        <h4>Parent Details</h4>

        <div class="mb-3">
          <label class="form-label">Father's Name</label>
          <div class="input-group">
            <span class="input-group-text">Mr.</span>
            <input type="text" class="form-control" placeholder="Father Name"
                   name="fatherName" value="<?php echo getSessionValue('fatherName'); ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Mother's Name</label>
          <div class="input-group">
            <span class="input-group-text">Mrs.</span>
            <input type="text" class="form-control" placeholder="Mother Name"
                   name="motherName" value="<?php echo getSessionValue('motherName'); ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Parent's Mobile Number</label>
          <input class="form-control" type="number" name="parentNumber"
                 value="<?php echo getSessionValue('parentNumber'); ?>"
                 placeholder="Parent Mobile Number">
        </div>

        <div class="mb-3">
          <label class="form-label">Parent's Email</label>
          <input class="form-control" type="email" name="parentEmail"
                 value="<?php echo getSessionValue('parentEmail'); ?>"
                 placeholder="Parent Email">
        </div>

        <div class="mb-3">
          <label class="form-label">Date of Registration</label>
          <input class="form-control" type="date" name="dateOfRegistration"
                 value="<?php echo getSessionValue('dateOfRegistration'); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <textarea class="form-control" name="address" rows="4"><?php echo getSessionValue('address'); ?></textarea>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Add Student</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
include "../template/footer.php";
session_unset(); // clear session safely
?>
</body>
</html>

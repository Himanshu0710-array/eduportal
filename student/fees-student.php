<?php
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";
include "../database-connect.php";

// Fetch student data
$query1 = "SELECT * FROM tblstudent WHERE studentId=:studentId";
$stmt = $conn->prepare($query1);
$stmt->bindParam(":studentId", $studentId);
$stmt->execute();
$row = $stmt->fetch();

$academicYearId = $row["academicYearId"];

// Fetch total paid fees and discount
$stmt = $conn->prepare("SELECT SUM(paidFees) AS totalPaid, discountMoney FROM tblfees WHERE studentId=:studentId AND academicYearId=:academicYearId");
$stmt->bindParam(":studentId", $studentId);
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->execute();
$totalPaid = $stmt->fetch();

// Fetch course info
$courseId = $row["courseId"];
$stmt = $conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
$stmt->bindParam(":courseId", $courseId);
$stmt->execute();
$course = $stmt->fetch();
$courseDuration = $course["courseDuration"];

// Fetch session and course fee
$stmt = $conn->prepare("SELECT * FROM tblsession WHERE status=1");
$stmt->execute();
$sessionId = $stmt->fetch();

$sessionId = $sessionId["sessionId"];
$stmt = $conn->prepare("SELECT * FROM tblCourseFees WHERE courseId=:courseId AND academicYearId=:academicYearId AND sessionId=:sessionId");
$stmt->bindParam(":courseId", $courseId);
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->bindParam(":sessionId", $sessionId);
$stmt->execute();
$courseFees = $stmt->fetch();

// Calculate fees
function diff($x, $y) { return $x - $y; }

$totalFees = diff($courseFees['totalFees'], $totalPaid["discountMoney"]);
$dueFees = diff($totalFees, $totalPaid["totalPaid"]);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fees Tracker</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #edf2fb, #e2eafc);
        color: #2c3e50;
    }

    .dashboard-container {
        margin-top: 10px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px 30px;
    }

    .heading-fees {
        text-align: center;
        color: #1f3c88;
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card {
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        color: #fff;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .stat-card h5 {
        font-weight: 600;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card p {
        font-size: 26px;
        font-weight: 700;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .bg-blue { background: linear-gradient(135deg, #74b9ff, #0984e3); }
    .bg-green { background: linear-gradient(135deg, #00b894, #55efc4); }
    .bg-pink { background: linear-gradient(135deg, #ff7675, #fab1a0); }

    label {
        font-weight: 600;
        color: #34495e;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 15px;
        border: 1.5px solid #dcdcdc;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #1f3c88;
        box-shadow: 0 0 6px rgba(31, 60, 136, 0.3);
    }

    .alert {
        border-radius: 12px;
        font-weight: 500;
    }

    .table-container {
        margin-top: 60px;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background: #1f3c88;
        color: #fff;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #f1f5ff;
        transition: 0.2s;
    }

    .no-data {
        color: #7f8c8d;
        text-align: center;
        padding: 25px;
    }

    @media (max-width: 768px) {
        .stat-card { margin-bottom: 20px; }
    }
</style>
</head>

<body>
<div class="container dashboard-container">
    <h2 class="heading-fees">Fees Tracker</h2>

    <?php
    $stmt = $conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
    $stmt->bindParam(":academicYearId", $academicYearId);
    $stmt->execute();
    $year = $stmt->fetch();
    ?>

    <div class="mb-4">
        <label>Academic Year</label>
        <input type="text" class="form-control" readonly value="<?php echo $year['academicYearName'] ?? 'N/A'; ?>">
    </div>

    <!-- Fees Summary -->
    <div class="row text-center">
        <div class="col-md-4">
            <div class="stat-card bg-blue">
                <h5>Total Fees</h5>
                <?php if($totalPaid['discountMoney'] <= 0) { ?>
                    <p>₹<?php echo $courseFees['totalFees']; ?></p>
                <?php } else { ?>
                    <p style="line-height: 1.6; font-size: 22px;">
                        Total: ₹<?php echo $courseFees['totalFees']; ?><br>
                        Discount: ₹<?php echo $totalPaid['discountMoney']; ?><br>
                        Payable: ₹<?php echo $totalFees; ?>
                    </p>
                <?php } ?>
            </div>
        </div>


        <div class="col-md-4">
            <div class="stat-card bg-green">
                <h5>Paid Fees</h5>
                <p>₹<?php echo $totalPaid["totalPaid"] ?? 0; ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card bg-pink">
                <h5>Due Fees</h5>
                <p>₹<?php echo $dueFees; ?></p>
            </div>
        </div>
    </div>

    <?php if($dueFees > 0) { ?>
    <div class="alert alert-warning text-center mt-4">
        <strong>Note:</strong> Your fee due date is <strong><?php echo date("d/m/Y", strtotime($courseFees['dueDate'])); ?></strong>
    </div>
    <?php } ?>

    <!-- Transaction History -->
    <div class="table-container">
        <h4 class="text-center mb-4 mt-4 text-uppercase" style="color:#1f3c88;">Transaction History (This Year)</h4>
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Academic Year</th>
                        <th>Transaction Amount</th>
                        <th>Date of Transaction</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM tblfees WHERE studentId=:studentId AND academicYearId=:academicYearId ORDER BY feeId DESC");
                    $stmt->bindParam(":studentId", $studentId);
                    $stmt->bindParam(":academicYearId", $academicYearId);
                    $stmt->execute();

                    if ($stmt->rowCount() == 0) {
                        echo "<tr><td colspan='4' class='no-data'>No transactions found.</td></tr>";
                    }

                    while ($result = $stmt->fetch()) {
                        $academicYearId = $result['academicYearId'];
                        $academicYearstmt = $conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                        $academicYearstmt->bindParam(":academicYearId", $academicYearId);
                        $academicYearstmt->execute();
                        $academicYears = $academicYearstmt->fetch();
                    ?>
                    <tr>
                        <td><?php echo $result["studentId"]; ?></td>
                        <td><?php echo $academicYears["academicYearName"]; ?></td>
                        <td><span style="color: green; font-weight: bold;">₹<?php echo $result["paidFees"]; ?></span></td>
                        <td><?php echo date("d/m/Y", strtotime($result["dateOfSubmissionOfFees"])); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../splitting-student/footer.php"; ?>
</body>
</html>

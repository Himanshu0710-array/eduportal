<?php
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$stmt3 = $conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
$stmt3->bindParam(":studentId",$studentId);
$stmt3->execute();
$studentDetail = $stmt3->fetch();

$courseId = $studentDetail["courseId"];
$academicYearId = $studentDetail["academicYearId"];

function percent($x,$y){
    return ($y>0) ? number_format($x/$y*100,2) : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Student Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { background: #f8f9fa; }
.card { border-radius: 10px; margin-bottom: 15px; font-size: 0.9rem; }
.card-header { font-weight: 600; }
.table td, .table th { padding: .4rem; font-size: 0.85rem; }
.progress { height: 8px; }
canvas { max-height: 150px !important; }
.notice-box { border-bottom:1px solid #ddd; padding:5px 0; display:flex; justify-content:space-between; align-items:center; }
.notice-box small { font-size:0.8rem; color:#555; }
</style>
</head>
<body>
<div class="container-fluid py-3">
<div class="row mb-2 g-2">
<div class="col-lg-4 col-md-12">
<div class="card shadow-sm animate__animated animate__slideInDown">
<div class="card-body d-flex align-items-center">
<?php
$imagePath = !empty($studentDetail['studentImage']) ? 'uploads/' . $studentDetail['studentImage'] : ($studentDetail['studentGender'] == '1' ? "images/female-logo.jpg" : "images/male-logo.jpg");
?>
<img src="<?php echo $imagePath; ?>" class="rounded-circle me-3" style="width:80px;height:80px;object-fit:cover;">
<div>
<h6 class="mb-1">Welcome, <?php echo $studentDetail['studentName']; ?></h6>
<p class="mb-0 text-muted">Keep learning, keep growing!</p>
</div>
</div>
</div>
</div>
<div class="col-lg-8 col-md-12">
<div class="card shadow-sm animate__animated animate__slideInRight">
<div class="card-header bg-primary text-white">
Notice Board
</div>
<div class="card-body" style="max-height:180px; overflow-y:auto;">
<?php
$noticestmt = $conn->prepare("SELECT * FROM tblnotice WHERE studentId=:studentId AND academicYearId=:academicYearId ORDER BY id DESC");
$noticestmt->bindParam(":studentId", $studentId);
$noticestmt->bindParam(":academicYearId", $academicYearId);
$noticestmt->execute();
while($notices=$noticestmt->fetch()){ ?>
<div class="notice-box">
<div>
<small><?php echo date('d-m-Y', strtotime($notices['noticeDate'])); ?></small>
<p class="mb-0"><?php echo substr($notices['notice'],0,50); ?>...</p>
</div>
<button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#noticeModal<?php echo $notices['id']; ?>">Read More</button>
</div>
<?php } ?>
</div>
</div>
</div>
</div>

<div class="row mb-2 g-2">
<div class="col-lg-4 col-md-6">
<div class="card shadow-sm">
<div class="card-header bg-info text-white">Subjects & Attendance</div>
<div class="card-body p-2">
<table class="table table-hover table-striped mb-2">
<thead>
<tr><th>Subject</th><th>Att%</th></tr>
</thead>
<tbody>
<?php
$subjectstmt = $conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId");
$subjectstmt->bindParam(":courseId",$courseId);
$subjectstmt->bindParam(":academicYearId",$academicYearId);
$subjectstmt->execute();

$attendanceLabels=[]; 
$attendanceData=[];
$totalAttended = 0; 
$totalClasses = 0;

while($subject=$subjectstmt->fetch()){
$subjectId = $subject['subjectId'];
$stmt=$conn->prepare("SELECT COUNT(*) FROM tblattendence WHERE studentId=:studentId AND subjectId=:subjectId");
$stmt->bindParam(":studentId",$studentId);
$stmt->bindParam(":subjectId",$subjectId);
$stmt->execute();
$subjectTotalClass = $stmt->fetchColumn();

$stmt=$conn->prepare("SELECT COUNT(*) FROM tblattendence WHERE studentId=:studentId AND subjectId=:subjectId AND attendence=1");
$stmt->bindParam(":studentId",$studentId);
$stmt->bindParam(":subjectId",$subjectId);
$stmt->execute();
$subjectAttended = $stmt->fetchColumn();

$percentVal = percent($subjectAttended,$subjectTotalClass);

$attendanceLabels[] = $subject['subjectName'];
$attendanceData[] = $percentVal;

$totalAttended += $subjectAttended;
$totalClasses += $subjectTotalClass;
?>
<tr>
<td><?php echo $subject['subjectName']; ?></td>
<td>
<div class="progress mb-1"><div class="progress-bar bg-info" style="width:<?php echo $percentVal; ?>%"></div></div>
<small><?php echo $percentVal; ?>%</small>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php $overallAttendance = percent($totalAttended, $totalClasses); ?>
<div class="mt-2 p-2 bg-light text-center rounded">
<strong>Overall Attendance: </strong><?php echo $overallAttendance; ?>%
</div>
<canvas id="attendanceChart" class="mt-2"></canvas>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm">
<div class="card-header bg-success text-white">Upcoming Tests</div>
<div class="card-body p-2">
<?php
$today = date('Y-m-d');
$teststmt = $conn->prepare("SELECT * FROM tbltest WHERE courseId=:courseId AND academicYearId=:academicYearId AND dateOfTest >= :today ORDER BY dateOfTest ASC");
$teststmt->bindParam(":courseId", $courseId);
$teststmt->bindParam(":academicYearId", $academicYearId);
$teststmt->bindParam(":today", $today);
$teststmt->execute();
?>
<table class="table table-hover table-striped mb-2">
<thead>
<tr><th>Subject</th><th>Test</th><th>Date</th></tr>
</thead>
<tbody>
<?php while($test=$teststmt->fetch()){
$testId = $test['testId'];
$testDetailStmt = $conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
$testDetailStmt->bindParam(":testId",$testId);
$testDetailStmt->execute();
$testDetail = $testDetailStmt->fetch();

$subStmt=$conn->prepare("SELECT subjectName FROM tblsubject WHERE subjectId=:subjectId");
$subStmt->bindParam(":subjectId",$test['subjectId']);
$subStmt->execute();
$sub = $subStmt->fetch();
?>
<tr>
<td><?php echo $sub['subjectName']; ?></td>
<td><?php echo $testDetail['testName']; ?></td>
<td><?php echo date('d-m-Y',strtotime($test['dateOfTest'])); ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>

<div class="col-lg-4 col-md-12">
<div class="card shadow-sm">
<div class="card-header bg-warning text-dark">Fees Details</div>
<div class="card-body p-2">
<?php
$fstmt = $conn->prepare("
SELECT 
COALESCE(SUM(totalFees),0) AS totalFees,
COALESCE(SUM(paidFees),0) AS totalPaid,
COALESCE(SUM(discountMoney),0) AS discount
FROM tblfees
WHERE studentId=:studentId AND academicYearId=:academicYearId
");
$fstmt->bindParam(":studentId",$studentId);
$fstmt->bindParam(":academicYearId",$academicYearId);
$fstmt->execute();
$fees = $fstmt->fetch();

if($fees['totalFees'] == 0){
    $totalFees = $fees['totalFees']; // just for display, assume 100 units
    $totalPaid = 0;
    $discount = 0;
    $dueFees = $totalFees;
} else {
    $totalFees = $fees['totalFees'];
    $totalPaid = $fees['totalPaid'];
    $discount = $fees['discount'];
    $dueFees = $totalFees - $totalPaid - $discount;
}

?>
<p class="mb-1"><strong>Total:</strong> ₹<?php echo $totalFees; ?> | <strong>Paid:</strong> ₹<?php echo $totalPaid; ?> | <strong>Discount:</strong> ₹<?php echo $discount; ?> | <strong>Due:</strong> ₹<?php echo $dueFees; ?></p>
<canvas id="feesChart"></canvas>
</div>
</div>
</div>
</div>

<?php
$noticestmt->execute();
while($notices=$noticestmt->fetch()){
?>
<div class="modal fade" id="noticeModal<?php echo $notices['id']; ?>" tabindex="-1" aria-labelledby="noticeModalLabel<?php echo $notices['id']; ?>" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-primary text-white">
<h5 class="modal-title" id="noticeModalLabel<?php echo $notices['id']; ?>">Notice Details</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<p><b>Date:</b> <?php echo date('d-m-Y', strtotime($notices['noticeDate'])); ?></p>
<p><?php echo $notices['notice']; ?></p>
<p><b>Minimum Attendance Required:</b> <?php echo $notices['cutOffAttendence']; ?>%</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<?php } ?>

<script>
const feesCtx = document.getElementById('feesChart').getContext('2d');
new Chart(feesCtx,{
    type:'doughnut',
    data:{
        labels:['Paid','Pending','Discount'],
        datasets:[{
            data:[<?php echo $totalPaid; ?>,<?php echo $dueFees; ?>,<?php echo $discount; ?>],
            backgroundColor:['rgba(75,192,192,0.7)','rgba(255,99,132,0.7)','rgba(255,206,86,0.7)']
        }]
    }
});

const attCtx = document.getElementById('attendanceChart').getContext('2d');
new Chart(attCtx,{
type:'bar',
data:{
labels:<?php echo json_encode($attendanceLabels); ?>,
datasets:[{
label:'Attendance %',
data:<?php echo json_encode($attendanceData); ?>,
backgroundColor:'rgba(54,162,235,0.7)'
}]
},
options:{scales:{y:{beginAtZero:true,max:100}}}
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include "../splitting-student/footer.php"; ?>
</body>
</html>

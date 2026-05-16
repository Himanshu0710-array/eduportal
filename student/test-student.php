<?php
include "../database-connect.php";
session_start();
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$stmt=$conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();
$student=$stmt->fetch();

function marks($x , $y)
{
    return $y > 0 ? round($x/$y * 100, 2) : 0;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Test Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f4f6fa;
        font-family: 'Poppins', sans-serif;
        color: #333;
        min-height: 100vh;
    }
    .test-heading {
        text-align: center;
        background: #e7efff;
        color: #1e3a8a;
        padding: 20px;
        border-radius: 10px;
        margin: 25px auto;
        width: 90%;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .test-heading h2 {
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .test-heading p {
        font-size: 0.9rem;
        color: #475569;
    }
    .table-container {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 20px;
        margin: 25px auto;
        width: 95%;
        overflow-x: auto;
    }
    .table thead th {
        background-color: #dbeafe;
        color: #1e3a8a;
        text-align: center;
        font-weight: 600;
        border-bottom: 2px solid #cbd5e1;
    }
    .table tbody tr {
        background: #f8fafc;
        transition: background 0.2s ease;
    }
    .table tbody tr:hover {
        background: #edf2f7;
    }
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
        padding: 10px;
        border-top: none;
    }
    .badge-pass {
        background-color: #3b82f6;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .badge-fail {
        background-color: #ef4444;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .badge-upcoming {
        background-color: #94a3b8;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
    }
</style>
</head>
<body>

<div class="container-fluid">
    <div class="test-heading animate__animated animate__fadeInDown">
        <h2>Test Details</h2>
        <p class="mb-0">View your marks and test progress.</p>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Test</th>
                    <th>Course</th>
                    <th>Academic Year</th>
                    <th>Subject</th>
                    <th>Max Marks</th>
                    <th>Marks Obtained</th>
                    <th>Date</th>
                    <th>Session</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $courseId = $student["courseId"];
                $academicYearId = $student["academicYearId"];

                $stmt = $conn->prepare("SELECT * FROM tbltest WHERE courseId=:courseId AND academicYearId=:academicYearId");
                $stmt->bindParam(":courseId", $courseId);
                $stmt->bindParam(":academicYearId", $academicYearId);
                $stmt->execute();

                while($test = $stmt->fetch()) {
                    $testId = $test["testId"];

                    $stmtDetail = $conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
                    $stmtDetail->bindParam(":testId", $testId);
                    $stmtDetail->execute();
                    $testDetail = $stmtDetail->fetch();
                ?>
                <tr>
                    <td><strong><?php echo $testDetail['testName']; ?></strong></td>
                    <td>
                        <?php  
                        $courseId = $student['courseId'];
                        $coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
                        $coursestmt->bindParam(":courseId",$courseId);
                        $coursestmt->execute();
                        $course=$coursestmt->fetch();
                        echo $course["courseName"];
                        ?>
                    </td>
                    <td>
                        <?php  
                        $academicYearId = $student['academicYearId'];
                        $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                        $yearstmt->bindParam(":academicYearId",$academicYearId);
                        $yearstmt->execute();
                        $year=$yearstmt->fetch();
                        echo $year["academicYearName"];
                        ?>
                    </td>
                    <td>
                        <?php  
                        $subjectId = $test['subjectId'];
                        $subjectstmt=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
                        $subjectstmt->bindParam(":subjectId",$subjectId);
                        $subjectstmt->execute();
                        $subject=$subjectstmt->fetch();
                        echo $subject["subjectName"];
                        ?>
                    </td>
                    <td><strong><?php echo $test['maximumMarks']; ?></strong></td>
                    <?php
                    $subjectId=$test['subjectId'];
                    $studentId = $student["studentId"];
                    $resultstmt=$conn->prepare("SELECT * FROM tblresult WHERE testId=:testId AND subjectId=:subjectId AND studentId=:studentId");
                    $resultstmt->bindParam(":testId",$testId);
                    $resultstmt->bindParam(":subjectId",$subjectId);
                    $resultstmt->bindParam(":studentId",$studentId);
                    $resultstmt->execute();
                    $result=$resultstmt->fetch();
                    $resultCount = $resultstmt->rowCount();

                    if($resultCount > 0) {
                        echo "<td>".$result['marksObtained']."</td>";
                    } else {
                        echo "<td>-</td>";
                    }
                    ?>
                    <td><?php echo date('d M Y', strtotime($test['dateOfTest'])); ?></td>
                    <td>
                        <?php  
                            $sessionId = $test['sessionId']; 
                            $sessionstmt=$conn->prepare("SELECT * FROM tblsession WHERE sessionId = :sessionId");
                            $sessionstmt->bindParam(":sessionId",$sessionId);
                            $sessionstmt->execute();
                            $session = $sessionstmt->fetch();
                            echo $session['sessionName'];
                        ?>
                    </td>
                    <?php
                        $status = $test["testStatus"];
                        if($status == 1 && $resultCount > 0) {
                            $marksObtained = $result['marksObtained'];
                            $percent = marks($marksObtained , $test['maximumMarks']);
                            if($percent >= 35) {
                                echo "<td><span class='badge-pass'>Pass</span></td>";
                            } else {
                                echo "<td><span class='badge-fail'>Fail</span></td>";
                            }
                        } else {
                            echo "<td><span class='badge-upcoming'>Upcoming</span></td>";
                        }
                    ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<a href="/hayatWorking/index.php" class="chatbot-btn" title="Chat with AI Assistant">
    <div class="chatbot-icon-wrapper">
        <i class="bi bi-chat-dots-fill"></i>
        <span class="chatbot-badge">AI</span>
    </div>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: false 
    });
</script>

<style>
    .chatbot-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        width: 65px;
        height: 65px;
        border-radius: 50%;
        box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
        transition: all 0.3s ease-in-out;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .chatbot-btn:hover {
        transform: scale(1.12);
        background: linear-gradient(135deg, #4f46e5, #3730a3);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.6);
    }

    .chatbot-icon-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-btn i {
        font-size: 28px;
        color: #fff;
        transition: transform 0.2s;
    }

    .chatbot-btn:hover i {
        transform: scale(1.1);
    }

    .chatbot-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #22c55e;
        color: white;
        font-size: 10px;
        font-weight: 600;
        border-radius: 50%;
        padding: 2px 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }
</style>
    

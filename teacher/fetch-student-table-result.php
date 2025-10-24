<?php
include "../database-connect.php";

$testId         = $_REQUEST["testId"];
$courseId       = $_REQUEST["courseId"];
$academicYearId = $_REQUEST["academicYearId"];
$subjectId      = $_REQUEST["subjectId"];

// Fetch test details
$teststmt = $conn->prepare("SELECT * FROM tblTestDetail WHERE testId=:testId");
$teststmt->bindParam(":testId", $testId);
$teststmt->execute();
$testDetail = $teststmt->fetch();

// Check if test exists for the selected combination AND dateOfTest has passed
$today = date('Y-m-d'); // Current date

$checkstmt = $conn->prepare("
    SELECT * FROM tbltest 
    WHERE testId=:testId 
      AND courseId=:courseId 
      AND academicYearId=:academicYearId 
      AND subjectId=:subjectId 
      AND dateOfTest <= :today
");
$checkstmt->bindParam(":testId", $testId);
$checkstmt->bindParam(":courseId", $courseId);
$checkstmt->bindParam(":academicYearId", $academicYearId);
$checkstmt->bindParam(":subjectId", $subjectId);
$checkstmt->bindParam(":today", $today);
$checkstmt->execute();
$testCheck = $checkstmt->rowCount();

if($testCheck > 0){

    $stmt = $conn->prepare("SELECT * FROM tblstudent WHERE courseId=:courseId AND academicYearId=:academicYearId");
    $stmt->bindParam(":courseId", $courseId);
    $stmt->bindParam(":academicYearId", $academicYearId);
    $stmt->execute();

    while($student = $stmt->fetch()) {
        ?>
        <tr>
            <td><?php echo $student['studentId']; ?></td>
            <td><?php echo $student['studentName']; ?></td>
            <td>
                <?php  
                    $coursestmt = $conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
                    $coursestmt->bindParam(":courseId", $student['courseId']);
                    $coursestmt->execute();
                    $course = $coursestmt->fetch();
                    echo $course["courseName"];
                ?>
            </td>
            <td>
                <?php  
                    $yearstmt = $conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
                    $yearstmt->bindParam(":academicYearId", $student['academicYearId']);
                    $yearstmt->execute();
                    $year = $yearstmt->fetch();
                    echo $year["academicYearName"];
                ?>
            </td>
            <td>
                <?php  
                    $subjectstmt = $conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
                    $subjectstmt->bindParam(":subjectId", $subjectId);
                    $subjectstmt->execute();
                    $subject = $subjectstmt->fetch();
                    echo $subject["subjectName"];
                ?>
            </td>
            <?php $maxMarks = $testDetail['maximumMarks']; ?>
            <td><input type="number" name="marksObtained[]" class="form-control form-control-sm text-center" placeholder="Marks" min="0" max="<?php echo $maxMarks ?>" required></td>
            <td><input type="hidden" name="studentId[]" value="<?php echo $student['studentId']; ?>"></td>
        </tr>
        <?php
    }

} else {
    echo '<tr><td colspan="7">
            <div class="alert alert-info text-center m-0" role="alert">
                No test records found or the test date has not arrived yet.
            </div>
          </td></tr>';
}

?>

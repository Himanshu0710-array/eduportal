
<?php
include "../database-connect.php";

function attendence($x , $y)
{
    return ($y > 0) ? ($x / $y) * 100 : 0;
}

$courseId = $_REQUEST["courseId"];
$academicYearId = $_REQUEST["academicYearId"];
$subjectId = $_REQUEST["subjectId"];
$section = $_REQUEST["section"];
$cutOffAttendence   =   $_REQUEST["cutOffAttendence"];

$studentstmt=$conn->prepare("SELECT * FROM tblstudent WHERE courseId=:courseId AND academicYearId=:academicYearId AND section=:section");
$studentstmt->bindParam(":courseId",$courseId);
$studentstmt->bindParam(":academicYearId",$academicYearId);
$studentstmt->bindParam(":section",$section);
$studentstmt->execute();


?>


<thead>
    <tr>
      <th scope="col">Student Id</th>
      <th scope="col">Student</th>
      <th scope="col">Course</th>
      <th scope="col">Academic Year</th>
      <th scope="col">Section</th>
      <th scope="col">Subject Attendence</th>
    </tr>
</thead>

<?php
while($student=$studentstmt->fetch()) {
    

$studentId = $student["studentId"];

$totalstmt=$conn->prepare("SELECT * FROM tblattendence WHERE courseId=:courseId AND academicYearId=:academicYearId AND subjectId=:subjectId AND studentId=:studentId");
$totalstmt->bindParam(":courseId",$courseId);
$totalstmt->bindParam(":academicYearId",$academicYearId);
$totalstmt->bindParam(":subjectId",$subjectId);
$totalstmt->bindParam(":studentId",$studentId);
$totalstmt->execute();

$totalClasses = $totalstmt->rowCount();


$attendstmt=$conn->prepare("SELECT * FROM tblattendence WHERE courseId=:courseId AND academicYearId=:academicYearId AND subjectId=:subjectId AND studentId=:studentId AND attendence = 1");
$attendstmt->bindParam(":courseId",$courseId);
$attendstmt->bindParam(":academicYearId",$academicYearId);
$attendstmt->bindParam(":subjectId",$subjectId);
$attendstmt->bindParam(":studentId",$studentId);
$attendstmt->execute();

$ClassesAttended = $attendstmt->rowCount();

$attendence = attendence($ClassesAttended,$totalClasses);
if($totalClasses > 0 && $attendence < $cutOffAttendence){
?>
<input type="hidden" value="<?php echo $student['studentId']; ?>" name="studentId[]">
<tr>
    <td><?php echo $student['studentId']; ?></td>
    <td><?php echo $student['studentName']; ?></td>
    <td>
        <?php  
            $courseId = $student['courseId']; 
            $coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
            $coursestmt->bindParam(":courseId",$courseId);
            $coursestmt->execute();
            $courses=$coursestmt->fetch();
            echo $courses["courseName"];
        ?>
    </td>
    <td>
        <?php 
            $academicYearId = $student['academicYearId'];
            $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
            $yearstmt->bindParam(":academicYearId",$academicYearId);
            $yearstmt->execute();
            $academicYear=$yearstmt->fetch();
            echo $academicYear["academicYearName"];
        ?>
    </td>
    <td>
        <?php echo htmlspecialchars($student['section']); ?>
    </td>
    <td>
        <span style="color: red;">
            <?php echo number_format($attendence, 2) . "%"; ?>
        </span>
    </td>
</tr>
<?php
}
}


?>

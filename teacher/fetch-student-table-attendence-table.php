<?php
include "../database-connect.php";
$dateOfAttendence   =   $_REQUEST["dateOfAttendence"];
$courseId   =   $_REQUEST["courseId"];
$academicYearId =   $_REQUEST["academicYearId"];
$subjectId      =   $_REQUEST["subjectId"];
$sessionId      =   $_REQUEST["sessionId"];

$stmt=$conn->prepare("SELECT * FROM tblattendence WHERE dateOfAttendence=:dateOfAttendence AND courseId=:courseId AND academicYearId=:academicYearId AND subjectId=:subjectId AND sessionId=:sessionId");
$stmt->bindParam(":dateOfAttendence",$dateOfAttendence);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":subjectId",$subjectId);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->execute();



while($result=$stmt->fetch())
{
 ?>
 <tr>
    <td><?php echo $result['studentId']; ?></td>
    <input type="hidden" name="studentId[]" value="<?php echo $result['studentId']; ?>">
    <td>
        <?php  
            $studentId = $result['studentId']; 
            $studentstmt=$conn->prepare("SELECT * FROM tblstudent WHERE studentId = :studentId");
            $studentstmt->bindParam(":studentId",$studentId);
            $studentstmt->execute();
            $students=$studentstmt->fetch();
            echo htmlspecialchars($students["studentName"]);
        ?>
    </td>
    <td>
        <?php
        $courseId = $result['courseId'];
        $coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
        $coursestmt->bindParam(":courseId",$courseId);
        $coursestmt->execute();
        $courses=$coursestmt->fetch();
        
        echo $courses["courseName"];
        ?>
    </td>
    <td>
        <?php
        echo date("d/m/y", strtotime($result["dateOfAttendence"]));
        ?>
    </td>
    <td>
        <?php if ($result['attendence'] == 1) { ?>
            <span class="present-btn" style="color: green;">Present</span>
        <?php } else { ?>
            <span class="absent-btn" style="color: red;">Absent</span>
        <?php } ?>
    </td>

    <td>
        <a href="edit-attendence.php?studentId=<?php echo $result['studentId'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
        </a>
    </td>
</tr>

 
<?php
}
?>
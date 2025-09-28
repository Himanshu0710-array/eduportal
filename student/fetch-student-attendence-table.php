<?php
include "../database-connect.php";
$subjectId   =   $_REQUEST["subjectId"];
$studentId =   $_REQUEST["studentId"];

$stmt=$conn->prepare("SELECT * FROM tblattendence  WHERE studentId=:studentId AND subjectId=:subjectId ORDER by id DESC");
$stmt->bindParam(":studentId",$studentId);
$stmt->bindParam(":subjectId",$subjectId);
$stmt->execute();



while($result=$stmt->fetch())
{
 ?>
 <tr>
    <td>
        <?php  
        $courseId = $result['courseId']; 
        $coursestmt=$conn->prepare("SELECT * FROM tblcourse WHERE courseId=:courseId");
        $coursestmt->bindParam(":courseId",$courseId);
        $coursestmt->execute();
        $row=$coursestmt->fetch();
        
        echo $row["courseName"];
        ?>
    </td>
    <td>
        <?php  
        $academicYearId = $result['academicYearId']; 
        $yearstmt=$conn->prepare("SELECT * FROM tblAcademicYear WHERE academicYearId=:academicYearId");
        $yearstmt->bindParam(":academicYearId",$academicYearId);
        $yearstmt->execute();
        $year=$yearstmt->fetch();
        
        echo $year["academicYearName"];
        ?>
    </td>
    <td>
        <?php  
        $subjectId = $result['subjectId']; 
        $subjectstmt=$conn->prepare("SELECT * FROM tblsubject WHERE subjectId=:subjectId");
        $subjectstmt->bindParam(":subjectId",$subjectId);
        $subjectstmt->execute();
        $subject=$subjectstmt->fetch();
        
        echo $subject["subjectName"];
        ?>
    </td>
    <td>
        <?php
            echo date("d/m/Y", strtotime($result['dateOfAttendence']));
        ?>
    </td>
    <td>
        <?php
        $attendence = $result["attendence"];
        if($attendence == 1)
        {
        ?>
        <span class="present-btn" style="color:green";>Present</span>
        <?php
        } else{
        ?>
        <span class="absent-btn"style="color:red";>Absent</span>
        <?php
        }
        ?>
    </td>
</tr>

 
<?php
}
?>
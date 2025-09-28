<?php
include "../database-connect.php";
$courseId   =   $_REQUEST["courseId"];
$academicYearId =   $_REQUEST["academicYearId"];

$stmt=$conn->prepare("SELECT * FROM tblstudent WHERE courseId=:courseId AND academicYearId=:academicYearId");
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->execute();



while($result=$stmt->fetch())
{
 ?>
 <tr>
    <td><?php echo $result['studentId']; ?></td>
    <input type="hidden" name="studentId[]" value="<?php echo $result['studentId']; ?>">
    <td><?php echo $result['studentName']; ?></td>
    <td>
        <input type="radio" name="attendence[<?php echo $result['studentId']; ?>]" value="1" checked> 
        <span class="present-btn" style="color:green";>Present</span>
        <input type="radio" name="attendence[<?php echo $result['studentId']; ?>]" value="0">
        <span class="absent-btn"style="color:red";>Absent</span>
    </td>
</tr>

 
<?php
}
?>
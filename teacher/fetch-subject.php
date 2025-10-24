<?php
include "../database-connect.php";

$courseId = $_REQUEST["courseId"];
$academicYearId =   $_REQUEST["academicYearId"];
$stmt=$conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId AND status = 1");
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->execute();
?>
<option value="-1">--Select Subject--</option>
<?php
while($result=$stmt->fetch())
{
 ?> 
 
 <option value="<?php echo $result['subjectId'] ?>"><?php echo $result['subjectName'] ?></option>
 
<?php
}
?>


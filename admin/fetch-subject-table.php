<?php
include "../database-connect.php";
$courseId = $_REQUEST["courseId"];
$academicYearId = $_REQUEST["academicYearId"];

$stmt = $conn->prepare("SELECT * FROM tblsubject WHERE courseId=:courseId AND academicYearId=:academicYearId");
$stmt->bindParam(":courseId", $courseId);
$stmt->bindParam(":academicYearId", $academicYearId);
$stmt->execute();
?>

<table class="table">
  <thead class="table-dark">
    <tr>
      <th>Subject Id</th>
      <th>Subject Name</th>
      <th>Course</th>
      <th>Academic Year</th>
      <th>Session</th>
      <th>Date Of Test</th>
    </tr>
  </thead>
  <tbody>
      <?php while ($subject = $stmt->fetch()) { ?>
        <tr>
          <td><?php echo $subject['subjectId']; ?></td>
          <td><?php echo $subject['subjectName']; ?></td>
          <td>
            <?php  
              $courseId = $subject['courseId']; 
              $coursestmt = $conn->prepare("SELECT courseName FROM tblcourse WHERE courseId=:courseId");
              $coursestmt->bindParam(":courseId", $courseId);
              $coursestmt->execute();
              $course = $coursestmt->fetch();
              echo $course["courseName"];
            ?>
          </td>
          <td>
            <?php  
              $academicYearId = $subject['academicYearId']; 
              $yearstmt = $conn->prepare("SELECT academicYearName FROM tblAcademicYear WHERE academicYearId=:academicYearId");
              $yearstmt->bindParam(":academicYearId", $academicYearId);
              $yearstmt->execute();
              $year = $yearstmt->fetch();
              echo $year["academicYearName"];
            ?>
          </td>
          <td>
            <?php  
              $sessionId = $subject['sessionId']; 
              $sessionstmt = $conn->prepare("SELECT sessionName FROM tblsession WHERE sessionId=:sessionId");
              $sessionstmt->bindParam(":sessionId", $sessionId);
              $sessionstmt->execute();
              $session = $sessionstmt->fetch();
              echo $session["sessionName"];
            ?>
          </td>
          <input type="hidden" name="subjectId[]" value="<?php echo $subject['subjectId']; ?>">
          <td>
            <input class="form-control" type="date" name="dateOfTest[]" >
          </td>
        </tr>
      <?php } ?>
  </tbody>
</table>

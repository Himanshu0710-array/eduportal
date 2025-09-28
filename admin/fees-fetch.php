<?php
    include "../database-connect.php";
    $courseId   =   $_REQUEST["courseId"];
    $academicYearId   =   $_REQUEST["academicYearId"];
    
    $sessionstmt=$conn->prepare("SELECT * FROM tblsession WHERE status=1");
    $sessionstmt->execute();
    $sessions=$sessionstmt->fetch();
    
    $sessionId=$sessions["sessionId"];
    
    
    
    
    $query = "SELECT * FROM tblCourseFees where courseId = :courseId AND academicYearId = :academicYearId AND sessionId=:sessionId";
    $stmt=$conn->prepare($query);
    $stmt->bindParam(":courseId",$courseId);
    $stmt->bindParam(":academicYearId",$academicYearId);
    $stmt->bindParam(":sessionId",$sessionId);
    $stmt->execute();
    $result=$stmt->fetch();
    if($result)
    {
       echo $result["totalFees"]; 
    }else 
    {
        echo "No Record Found";
    }  
?>
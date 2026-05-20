<?php
    include "admin-dashboard-top.php";
    include "admin-dashboard-content.php";
    // Update student academic year based on current active session
    $stmt = $conn->prepare("SELECT * FROM tblsession WHERE status = 1");
    $stmt->execute();
    $currentSession = $stmt->fetch();
    if ($currentSession) {
        $currentSessionId = $currentSession["sessionId"];
        $stmt = $conn->prepare("UPDATE tblstudent SET academicYearId = :currentSessionId - sessionId + 1");
        $stmt->bindParam(":currentSessionId", $currentSessionId);
        $stmt->execute();
    }
    include "admin-dashboard-footer.php";
?>

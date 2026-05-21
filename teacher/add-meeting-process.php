<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../database-connect.php";

if (!isset($_SESSION['teacherId']) && !isset($_COOKIE['teacherId'])) {
    header("Location: login-teacher.php");
    exit;
}

$teacherId = isset($_SESSION['teacherId']) ? $_SESSION['teacherId'] : htmlspecialchars($_COOKIE['teacherId']);
$subjectId = isset($_POST['subjectId']) ? intval($_POST['subjectId']) : 0;
$courseId = isset($_POST['courseId']) ? intval($_POST['courseId']) : 0;
$academicYearId = isset($_POST['academicYearId']) ? intval($_POST['academicYearId']) : 0;

$meetingTitle = isset($_POST['meetingTitle']) ? trim($_POST['meetingTitle']) : '';
$meetingDescription = isset($_POST['meetingDescription']) ? trim($_POST['meetingDescription']) : '';
$meetingDate = isset($_POST['meetingDate']) ? $_POST['meetingDate'] : '';
$meetingTime = isset($_POST['meetingTime']) ? $_POST['meetingTime'] : '';

if (empty($meetingTitle) || empty($meetingDate) || empty($meetingTime) || !$subjectId || !$courseId || !$academicYearId) {
    header("Location: add-meeting.php?err=1");
    exit;
}

// Generate a random unique room ID for the meeting
$meetingRoomId = "room_" . bin2hex(random_bytes(4)); 
$meetingType = "scheduled";
$meetingStatus = "upcoming";

try {
    $stmt = $conn->prepare("
        INSERT INTO tblmeetings (teacherId, subjectId, courseId, academicYearId, meetingTitle, meetingDescription, meetingRoomId, meetingDate, meetingTime, meetingType, meetingStatus)
        VALUES (:teacherId, :subjectId, :courseId, :academicYearId, :meetingTitle, :meetingDescription, :meetingRoomId, :meetingDate, :meetingTime, :meetingType, :meetingStatus)
    ");
    
    $stmt->bindParam(":teacherId", $teacherId);
    $stmt->bindParam(":subjectId", $subjectId);
    $stmt->bindParam(":courseId", $courseId);
    $stmt->bindParam(":academicYearId", $academicYearId);
    $stmt->bindParam(":meetingTitle", $meetingTitle);
    $stmt->bindParam(":meetingDescription", $meetingDescription);
    $stmt->bindParam(":meetingRoomId", $meetingRoomId);
    $stmt->bindParam(":meetingDate", $meetingDate);
    $stmt->bindParam(":meetingTime", $meetingTime);
    $stmt->bindParam(":meetingType", $meetingType);
    $stmt->bindParam(":meetingStatus", $meetingStatus);
    
    $stmt->execute();
    
    header("Location: meeting-teacher.php?success=1");
    exit;
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>

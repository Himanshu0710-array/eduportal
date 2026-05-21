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
$meetingId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($meetingId) {
    try {
        // Only delete the meeting if it belongs to the logged-in teacher
        $stmt = $conn->prepare("DELETE FROM tblmeetings WHERE meetingId = :meetingId AND teacherId = :teacherId");
        $stmt->bindParam(":meetingId", $meetingId);
        $stmt->bindParam(":teacherId", $teacherId);
        $stmt->execute();
        
        header("Location: meeting-teacher.php?deleted=1");
        exit;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: meeting-teacher.php");
    exit;
}
?>

<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include_once "../database-connect.php";
    if (!isset($_SESSION['teacherId']) && !isset($_COOKIE['teacherId'])) {
        header("Location: login-teacher.php");
        exit;
    }
    $teacherId = isset($_SESSION['teacherId']) ? $_SESSION['teacherId'] : (isset($_COOKIE['teacherId']) ? htmlspecialchars($_COOKIE['teacherId']) : '');
?>
<!doctype html>
<html lang="en">
  <head>

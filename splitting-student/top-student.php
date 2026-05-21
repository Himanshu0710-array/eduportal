<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include_once "../database-connect.php";
    if (!isset($_SESSION['studentId']) && !isset($_COOKIE['studentId'])) {
        header("Location: login-student.php");
        exit;
    }
    $studentId = isset($_SESSION['studentId']) ? $_SESSION['studentId'] : (isset($_COOKIE['studentId']) ? htmlspecialchars($_COOKIE['studentId']) : '');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

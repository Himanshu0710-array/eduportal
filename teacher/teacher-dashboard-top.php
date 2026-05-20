<?php
    include "../database-connect.php";
    $teacherId = isset($_COOKIE['teacherId']) ? htmlspecialchars($_COOKIE['teacherId']) : '';
    if (empty($teacherId)) {
        header("Location: login-teacher.php");
        exit;
    }
?>
<!doctype html>
<html lang="en">
  <head>

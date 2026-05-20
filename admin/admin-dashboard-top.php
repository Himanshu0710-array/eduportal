<?php
    session_start();
    if (!isset($_SESSION['adminId']) && !isset($_COOKIE['adminId'])) {
        header("Location: login-admin.php");
        exit;
    }
    include_once "../database-connect.php";
    $adminId = isset($_SESSION['adminId']) ? $_SESSION['adminId'] : htmlspecialchars($_COOKIE['adminId']);
?>
<!doctype html>
<html lang="en">
  <head>

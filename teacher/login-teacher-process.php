<?php
    ob_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "../database-connect.php";
    
    $teacherId = $_REQUEST['teacherId'];
    $teacherPassword = $_REQUEST['teacherPassword'];
    

    
    if (strlen($teacherId) == 0) {
        header("location:login-teacher.php?err=1");
        exit;
    }
    
    if (strlen($teacherPassword) == 0) {
        header("location:login-teacher.php?err=2");
        exit;
    }
    
    
    $query = "SELECT * FROM tblteacher WHERE teacherId = :teacherId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":teacherId", $teacherId);
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($teacherPassword != $result["teacherPassword"])
    {
        header("location:login-teacher.php?err=3");
        exit;
    }

    setcookie("teacherId", $result["teacherId"], time()+ 24*60*60 , "/");
    echo $_COOKIE["teacherId"];
    
    $_SESSION['teacherId']       = $result['teacherId'];
    $_SESSION['teacherPassword'] = $result['teacherPassword'];
    
        session_destroy();
    
    header("location:teacher-dashboard.php");
    exit;
?>

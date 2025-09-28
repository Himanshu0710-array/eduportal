<?php
    ob_start();
    session_start(); 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "../database-connect.php";
    
    $studentId = $_REQUEST['studentId'];
    $studentPassword = $_REQUEST['studentPassword'];
    
    $_SESSION["studentId"]  =   $studentId;
    $_SESSION["studentPassword"]  =   $studentPassword;
    
    if (strlen($studentId) == 0) {
        header("location:login-student.php?err=1");
        exit;
    }
    
    if (strlen($studentPassword) == 0) {
        header("location:login-student.php?err=2");
        exit;
    }
    
    
    
    $query = "SELECT * FROM tblstudent WHERE studentId = :studentId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":studentId", $studentId);
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($studentPassword != $result["studentPassword"])
    {
        header("location:login-student.php?err=3");
        exit;
    }
    

	setcookie("studentId", $result["studentId"], time()+ 24*60*60 , "/");
	echo $_COOKIE["studentId"];
	
    $_SESSION['studentId']       = $result['studentId'];
    $_SESSION['studentPassword'] = $result['studentPassword'];
    
    
        session_destroy();
    
    header("location:student-dashboard.php");
    exit;
    
?>

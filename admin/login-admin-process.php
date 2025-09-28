<?php
    ob_start();
    session_start(); 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $adminId        = $_REQUEST['adminId'];
    $adminPassword  = $_REQUEST['adminPassword'];
    
    if (strlen($adminId) == 0) {
        header("location:login-admin.php?err=1");
        exit;
    }
    
    if (strlen($adminPassword) == 0) {
        header("location:login-admin.php?err=2");
        exit;
    }
    
    include "../database-connect.php";
    
    $query = "SELECT * FROM tbladmin WHERE adminId = :adminId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":adminId", $adminId);
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($adminPassword != $result["adminPassword"])
    {
        header("location:login-admin.php?err=3");
        exit;
    }
    
    setcookie("adminId", $result["adminId"], time()+ 24*60*60 , "/");
	echo $_COOKIE["adminId"];
	
	
    $_SESSION['adminId']       = $result['adminId'];
    $_SESSION['adminPassword'] = $result['adminPassword'];
    
    
        
    
    header("location:admin-dashboard.php");
    exit;
    
?>

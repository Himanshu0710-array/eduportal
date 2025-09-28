<?php
    ob_start();
    session_start();
    include "../database-connect.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    date_default_timezone_set("Asia/Calcutta");
    
    $adminName          =   $_REQUEST["adminName"];
    $adminPassword      =   $_REQUEST["adminPassword"];
    $adminGender        =   $_REQUEST["adminGender"];
    $adminNumber        =   $_REQUEST["adminNumber"];
    $sessionId          =   $_REQUEST["sessionId"];
    $adminOccupation    =   $_REQUEST["adminOccupation"];
    $addedIpAddress     =   $_SERVER['REMOTE_ADDR'];
    $addedDateTime      =   date('y-m-d h:i:s');
    $updatedIpAddress   =   $_SERVER['REMOTE_ADDR'];
    $updatedDateTime    =   date('y-m-d h:i:s');
    
    $_SESSION["adminName"]          =   $adminName;
    $_SESSION["adminPassword"]      =   $adminPassword;
    $_SESSION["adminGender"]        =   $adminGender;
    $_SESSION["adminNumber"]        =   $adminNumber;
    $_SESSION["sessionId"]          =   $sessionId;
    $_SESSION["adminOccupation"]    =   $adminOccupation;
    
    if(strlen($adminName<=0))
    {
        header("location:add-admin.php?err=1");
		exit;
    }
    if(strlen($adminPassword<=0))
    {
        header("location:add-admin.php?err=2");
		exit;
    }
    if($adminGender==-1)
    {
        header("location:add-admin.php?err=3");
		exit;
    }
    if(strlen($adminNumber<=0))
    {
        header("location:add-admin.php?err=4");
		exit;
    }
    if($sessionId==-1)
    {
        header("location:add-admin.php?err=5");
		exit;
    }
    if($adminOccupation==-1)
    {
        header("location:add-admin.php?err=6");
		exit;
    }
    
    
    $stmt=$conn->prepare("insert into tbladmin (adminName,adminPassword,adminGender,adminNumber,sessionId,adminOccupation,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) VALUES(:adminName,:adminPassword,:adminGender,:adminNumber,:sessionId,:adminOccupation,:addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)");
    $stmt->bindParam(":adminName",$adminName);
    $stmt->bindParam(":adminPassword",$adminPassword);
    $stmt->bindParam(":adminGender",$adminGender);
    $stmt->bindParam(":adminNumber",$adminNumber);
    $stmt->bindParam(":sessionId",$sessionId);
    $stmt->bindParam(":adminOccupation",$adminOccupation);
    $stmt->bindParam(":addedIpAddress",$addedIpAddress);
    $stmt->bindParam(":addedDateTime",$addedDateTime);
    $stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
    $stmt->bindParam(":updatedDateTime",$updatedDateTime);
    $stmt->execute();
    
    session_destroy();
    header("location:admin-table.php");
    exit();
    
    




?>
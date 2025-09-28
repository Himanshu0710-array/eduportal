<?php
    ob_start();
    session_start();
    include "../database-connect.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Asia/Calcutta");
    
    $studentName            = $_REQUEST["studentName"];
    $dob                    = $_REQUEST["dob"];
    $courseId               = $_REQUEST["courseId"];
    $academicYearId         = $_REQUEST["academicYearId"];
    $sessionId              = $_REQUEST["sessionId"];
    $studentNumber          = $_REQUEST["studentNumber"];
    $studentGender          = $_REQUEST["studentGender"];
    $studentEmail           = $_REQUEST["studentEmail"];
    $studentPassword        = $_REQUEST["studentPassword"];
    $fatherName             = $_REQUEST["fatherName"];
    $motherName             = $_REQUEST["motherName"];
    $parentNumber           = $_REQUEST["parentNumber"];
    $parentEmail            = $_REQUEST["parentEmail"];
    $dateOfRegistration     = $_REQUEST["dateOfRegistration"];
    $address                = $_REQUEST["address"];
    $addedIpAddress         = $_SERVER['REMOTE_ADDR'];
    $addedDateTime          = date('y-m-d h:i:s');
    $updatedIpAddress       = $_SERVER['REMOTE_ADDR'];
    $updatedDateTime        = date('y-m-d h:i:s'); 
    
    
    
    $_SESSION["studentName"]            =   $studentName;
    $_SESSION["dob"]                    =   $dob;
    $_SESSION["courseId"]               =   $courseId;
    $_SESSION["academicYearId"]         =   $academicYearId;
    $_SESSION["sessionId"]              =   $sessionId;
    $_SESSION["studentNumber"]          =   $studentNumber;
    $_SESSION["studentGender"]          =   $studentGender;
    $_SESSION["studentEmail"]           =   $studentEmail;
    $_SESSION["studentPassword"]        =   $studentPassword;
    $_SESSION["fatherName"]             =   $fatherName;
    $_SESSION["motherName"]             =   $motherName;
    $_SESSION["parentNumber"]           =   $parentNumber;
    $_SESSION["parentEmail"]            =   $parentEmail;
    $_SESSION["dateOfRegistration"]     =   $dateOfRegistration;
    $_SESSION["address"]                =   $address;
    $_SESSION["addedIpAddress"]         =   $addedIpAddress;
    $_SESSION["addedDateTime"]          =   $addedDateTime;
    $_SESSION["updatedIpAddress"]       =   $updatedIpAddress;
    $_SESSION["updatedDateTime"]        =   $updatedDateTime;
    
    
    if(strlen($studentName)<=0)
	{
		header("location:register.php?err=1");
		exit;
	}
	if(strlen($dob)<=0)
	{
		header("location:register.php?err=2");
		exit;
	}
	if($courseId==-1)
	{
		header("location:register.php?err=3");
		exit;
	}
	if($sessionId==-1)
	{
		header("location:register.php?err=4");
		exit;
	}
	if(strlen($studentNumber)<=0 || strlen($studentNumber)>10 || strlen($studentNumber)<10)
	{
		header("location:register.php?err=5");
		exit;
	}
	if($studentGender==-1)
	{
		header("location:register.php?err=6");
		exit;
	}
	if(strlen($studentEmail)<=0)
	{
		header("location:register.php?err=7");
		exit;
	}
	if(strlen($studentPassword)<=0)
	{
		header("location:register.php?err=8");
		exit;
	}
	if(strlen($fatherName)<=0)
	{
		header("location:register.php?err=9");
		exit;
	}
	if(strlen($motherName)<=0)
	{
		header("location:register.php?err=10");
		exit;
	}
	if(strlen($parentNumber)<=0 || strlen($parentNumber)>10 || strlen($parentNumber)<10)
	{
		header("location:register.php?err=11");
		exit;
	}
	if(strlen($parentEmail)<=0)
	{
		header("location:register.php?err=12");
		exit;
	}
	if(strlen($dateOfRegistration)<=0)
	{
		header("location:register.php?err=13");
		exit;
	}
	if(strlen($address)<=0)
	{
		header("location:register.php?err=14");
		exit;
	}
	
	
	$query = ("INSERT into tblstudent (studentName,dob,courseId,academicYearId,sessionId,studentNumber,studentGender,studentEmail,studentPassword,fatherName,motherName,parentNumber,parentEmail,dateOfRegistration,
	            address,addedIpAddress,addedDateTime,updatedIpAddress,updatedDateTime) 
	     VALUES(:studentName,:dob,:courseId,:academicYearId,:sessionId,:studentNumber,:studentGender,:studentEmail,:studentPassword,:fatherName,:motherName,:parentNumber,:parentEmail,:dateOfRegistration,:address,
	     :addedIpAddress,:addedDateTime,:updatedIpAddress,:updatedDateTime)");
    $stmt=$conn->prepare($query);
    
    $stmt->bindParam(":studentName",$studentName);
    $stmt->bindParam(":dob",$dob);
    $stmt->bindParam(":courseId",$courseId);
    $stmt->bindParam(":academicYearId",$academicYearId);
    $stmt->bindParam(":sessionId",$sessionId);
    $stmt->bindParam(":studentNumber",$studentNumber);
    $stmt->bindParam(":studentGender",$studentGender);
    $stmt->bindParam(":studentEmail",$studentEmail);
    $stmt->bindParam(":studentPassword",$studentPassword);
    $stmt->bindParam(":fatherName",$fatherName);
    $stmt->bindParam(":motherName",$motherName);
    $stmt->bindParam(":parentNumber",$parentNumber);
    $stmt->bindParam(":parentEmail",$parentEmail);
    $stmt->bindParam(":dateOfRegistration",$dateOfRegistration);
    $stmt->bindParam(":address",$address);
    $stmt->bindParam(":addedIpAddress",$addedIpAddress);
    $stmt->bindParam(":addedDateTime",$addedDateTime);
    $stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
    $stmt->bindParam(":updatedDateTime",$updatedDateTime);
    $stmt->execute();
    
    session_destroy();
    
    $studentId = $conn->lastInsertId(); 


$_SESSION["studentId"] = $studentId;
    
    ?>
<?php
include "../database-connect.php";
$stmt=$conn->prepare("SELECT * FROM tblstudent WHERE studentId=:studentId");
$stmt->bindParam(":studentId",$studentId);
$stmt->execute();
$result=$stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-color: #d4edda;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .details {
            font-size: 18px;
            margin-top: 20px;
        }
        .login
        {
            font-size:16px;
            
        }
        .btn
        {
            color:white;
            background-color:#0d6efd;
            padding:10px 10px;
            border-radius:5px;
            font-weight:bold;
            margin-top:15px;
        }
        .note {
    font-size: 12px;
    color: rgba(0, 0,
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Successful!</h2>
        <p>Your Student ID and Password are:</p>
        <div class="details">
            <p><strong>Student ID:</strong> <span id="studentId"><?php echo $studentId ?></span></p>
            <p><strong>Password:</strong> <span id="password"><?php echo $result['studentPassword'] ?></span></p>
        </div>
        <p class="note">⚠ This page can only be opened once. Please save your credentials.</p>
        <p\ class="login">Go To The Login Pge and Enter Your Credentials <a href="login-student.php"><button class="btn">Login</button></a></p>
    </div>
</body>
</html>
    
    
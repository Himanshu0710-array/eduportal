<?php
include "../database-connect.php";
$studentId = htmlspecialchars($_COOKIE['studentId']); 
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Successful!</h2>
        <p>Your Student ID and Password are:</p>
        <div class="details">
            <p><strong>Student ID:</strong> <span id="studentId"><?php echo $result['studentId'] ?></span></p>
            <p><strong>Password:</strong> <span id="password"><?php echo $result['studentPassword'] ?></span></p>
        </div>
        <div>
            <p>Go To The Login Pge and Enter Your Credentials <button class="btn-primary">Login</button></p>
        </div>
    </div>
</body>
</html>
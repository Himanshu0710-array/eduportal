<?php
include "database-connect.php";

$names = ['Liam', 'Olivia', 'Noah', 'Emma', 'Oliver', 'Ava', 'Elijah', 'Charlotte', 'William', 'Sophia', 'Mason', 'Amelia', 'James', 'Isabella', 'Ben', 'Mia', 'Lucas', 'Evelyn', 'Henry', 'Harper'];
$lastnames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

for ($i = 0; $i < 100; $i++) {
    $firstName = $names[array_rand($names)];
    $lastName = $lastnames[array_rand($lastnames)];
    $studentName = $firstName . " " . $lastName;
    
    $timestamp = mt_rand(strtotime("2005-01-01"), strtotime("2010-12-31"));
    $dob = date("Y-m-d", $timestamp);
    
    $courseId = (mt_rand(0,1) == 0) ? 1 : 3;
    $academicYearId = 2;
    $sessionId = 9;
    
    $studentNumber = "9" . mt_rand(100000000, 999999999);
    $studentGender = mt_rand(1, 2);
    $studentEmail = strtolower($firstName) . "." . strtolower($lastName) . mt_rand(10,999) . "@example.com";
    $studentPassword = "password123";
    
    $fatherName = "Mr. " . $lastName;
    $motherName = "Mrs. " . $lastName;
    $parentNumber = "8" . mt_rand(100000000, 999999999);
    $parentEmail = "parent." . strtolower($lastName) . mt_rand(1, 100) . "@example.com";
    
    $dateOfRegistration = date("Y-m-d H:i:s");
    $address = mt_rand(1, 999) . " Dummy Street, City";
    
    $addedIpAddress = "127.0.0.1";
    $addedDateTime = date("Y-m-d H:i:s");
    $updatedIpAddress = "127.0.0.1";
    $updatedDateTime = date("Y-m-d H:i:s");

    $query = "INSERT INTO tblstudent (studentName, dob, courseId, academicYearId, sessionId, studentNumber, studentGender, studentEmail, studentPassword, fatherName, motherName, parentNumber, parentEmail, dateOfRegistration, address, addedIpAddress, addedDateTime, updatedIpAddress, updatedDateTime) VALUES (:studentName, :dob, :courseId, :academicYearId, :sessionId, :studentNumber, :studentGender, :studentEmail, :studentPassword, :fatherName, :motherName, :parentNumber, :parentEmail, :dateOfRegistration, :address, :addedIpAddress, :addedDateTime, :updatedIpAddress, :updatedDateTime)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':studentName', $studentName);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':courseId', $courseId);
    $stmt->bindParam(':academicYearId', $academicYearId);
    $stmt->bindParam(':sessionId', $sessionId);
    $stmt->bindParam(':studentNumber', $studentNumber);
    $stmt->bindParam(':studentGender', $studentGender);
    $stmt->bindParam(':studentEmail', $studentEmail);
    $stmt->bindParam(':studentPassword', $studentPassword);
    $stmt->bindParam(':fatherName', $fatherName);
    $stmt->bindParam(':motherName', $motherName);
    $stmt->bindParam(':parentNumber', $parentNumber);
    $stmt->bindParam(':parentEmail', $parentEmail);
    $stmt->bindParam(':dateOfRegistration', $dateOfRegistration);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':addedIpAddress', $addedIpAddress);
    $stmt->bindParam(':addedDateTime', $addedDateTime);
    $stmt->bindParam(':updatedIpAddress', $updatedIpAddress);
    $stmt->bindParam(':updatedDateTime', $updatedDateTime);
    
    $stmt->execute();
}
echo "100 students inserted successfully!";
?>

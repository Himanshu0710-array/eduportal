<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Calcutta");
include "../database-connect.php";

$feeId                      =   $_REQUEST["feeId"];
$studentId                  =   $_REQUEST["studentId"];
$courseId                   =   $_REQUEST["courseId"];
$academicYearId             =   $_REQUEST["academicYearId"];
$totalFees                  =   $_REQUEST["totalFees"];
$discountMoney              =   $_REQUEST["discountMoney"];
$paidFees                   =   $_REQUEST["paidFees"];
$dateOfSubmissionOfFees     =   $_REQUEST["dateOfSubmissionOfFees"];
$sessionId                  =   $_REQUEST["sessionId"];
$addedIpAddress             = $_SERVER['REMOTE_ADDR'];
$addedDateTime              = date('y-m-d h:i:s');
$updatedIpAddress           = $_SERVER['REMOTE_ADDR'];
$updatedDateTime            = date('y-m-d h:i:s'); 

if(strlen($studentId)<=0)
{
    header("location:add-fees.php?err=1");
    exit;
}
if($courseId==-1)
{
    header("location:add-fees.php?err=2");
    exit;
}
if($academicYearId==-1)
{
    header("location:add-fees.php?err=3");
    exit;
}
if(strlen($totalFees)<=0)
{
    header("location:add-fees.php?err=4");
    exit;
}
if(strlen($paidFees)<=0)
{
    header("location:add-fees.php?err=5");
    exit;
}
if(strlen($dateOfSubmissionOfFees)<=0)
{
    header("location:add-fees.php?err=6");
    exit;
}if($sessionId==-1)
{
    header("location:add-fees.php?err=7");
    exit;
}

$stmt=$conn->prepare("UPDATE tblfees SET studentId=:studentId,courseId=:courseId,academicYearId=:academicYearId,totalFees=:totalFees,discountMoney=:discountMoney,paidFees=:paidFees,dateOfSubmissionOfFees=:dateOfSubmissionOfFees,sessionId=:sessionId,addedIpAddress=:addedIpAddress,addedDateTime=:addedDateTime,updatedIpAddress=:updatedIpAddress,updatedDateTime=:updatedDateTime WHERE feeId=:feeId");
$stmt->bindParam(":feeId",$feeId);
$stmt->bindParam(":studentId",$studentId);
$stmt->bindParam(":courseId",$courseId);
$stmt->bindParam(":academicYearId",$academicYearId);
$stmt->bindParam(":totalFees",$totalFees);
$stmt->bindParam(":discountMoney",$discountMoney);
$stmt->bindParam(":paidFees",$paidFees);
$stmt->bindParam(":dateOfSubmissionOfFees",$dateOfSubmissionOfFees);
$stmt->bindParam(":sessionId",$sessionId);
$stmt->bindParam(":addedIpAddress",$addedIpAddress);
$stmt->bindParam(":addedDateTime",$addedDateTime);
$stmt->bindParam(":updatedIpAddress",$updatedIpAddress);
$stmt->bindParam(":updatedDateTime",$updatedDateTime);
$stmt->execute();
header("location:fees-table.php");
exit();





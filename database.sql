-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: himanshu_4604
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblacademicyear`
--

DROP TABLE IF EXISTS `tblacademicyear`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblacademicyear` (
  `academicYearId` int(10) NOT NULL AUTO_INCREMENT,
  `academicYearName` text NOT NULL,
  `addedIpAddress` varchar(100) NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` varchar(100) NOT NULL,
  `updatedDatetime` datetime NOT NULL,
  PRIMARY KEY (`academicYearId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblacademicyear`
--

/*!40000 ALTER TABLE `tblacademicyear` DISABLE KEYS */;
INSERT INTO `tblacademicyear` VALUES (1,'1st Year','171.49.208.16','2025-02-13 07:31:16','171.49.208.16','2025-02-13 07:31:16'),(2,'2nd Year','171.49.208.16','2025-02-13 07:31:53','171.49.208.16','2025-02-13 07:31:53'),(3,'3rd Year','171.49.208.16','2025-02-13 07:31:59','171.49.208.16','2025-02-13 07:31:59'),(4,'4th Year','171.49.208.16','2025-02-13 07:32:05','171.49.208.16','2025-02-13 07:32:05'),(5,'5th Year','171.49.208.16','2025-02-13 07:32:11','171.49.208.16','2025-02-13 07:32:11'),(6,'6th Year','122.181.92.233','2025-03-08 01:32:37','122.181.92.233','2025-03-08 01:32:37');
/*!40000 ALTER TABLE `tblacademicyear` ENABLE KEYS */;

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbladmin` (
  `adminId` int(100) NOT NULL AUTO_INCREMENT,
  `adminName` text NOT NULL,
  `adminPassword` varchar(100) NOT NULL,
  `adminGender` int(10) NOT NULL,
  `adminNumber` varchar(15) NOT NULL,
  `sessionId` int(10) NOT NULL,
  `adminOccupation` int(10) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime(6) NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime(6) NOT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbladmin`
--

/*!40000 ALTER TABLE `tbladmin` DISABLE KEYS */;
INSERT INTO `tbladmin` VALUES (1,'himanshu21','12342',2,'6375324604',8,2,'::1','2025-10-01 20:27:21.000000','::1','2025-10-01 20:27:21.000000'),(2,'pulkit1','1007',2,'9256470710',4,1,'183.83.53.10','2025-03-04 20:27:49.000000','183.83.53.10','2025-03-04 20:27:49.000000'),(4,'himanshuuu','0786',2,'6745735123',1,3,'182.68.79.23','2025-03-14 22:31:04.000000','182.68.79.23','2025-03-14 22:31:04.000000'),(5,'pulkit','678686',2,'9256470710',1,3,'182.68.102.28','2025-02-22 16:15:34.000000','182.68.102.28','2025-02-22 16:15:34.000000'),(7,'messi','23243',2,'7977574883',1,3,'183.83.53.10','2025-03-04 20:27:27.000000','183.83.53.10','2025-03-04 20:27:27.000000'),(8,'shubhra','101010',1,'9797777898',1,3,'106.201.148.39','2025-02-05 07:05:02.000000','106.201.148.39','2025-02-05 07:05:02.000000'),(9,'manoj1','8787',2,'9887658674',1,3,'183.83.53.10','2025-03-04 20:27:41.000000','183.83.53.10','2025-03-04 20:27:41.000000'),(10,'sanoj1','9879',2,'9877578756',1,3,'152.59.108.79','2025-03-10 17:00:41.000000','152.59.108.79','2025-03-10 17:00:41.000000'),(12,'yajat','0998',2,'9896979778',8,4,'182.68.79.23','2025-03-14 10:34:19.000000','182.68.79.23','2025-03-14 10:34:19.000000');
/*!40000 ALTER TABLE `tbladmin` ENABLE KEYS */;

--
-- Table structure for table `tblattendence`
--

DROP TABLE IF EXISTS `tblattendence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblattendence` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `dateOfAttendence` date NOT NULL,
  `courseId` int(10) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `subjectId` int(10) NOT NULL,
  `sessionId` int(10) NOT NULL,
  `studentId` int(10) NOT NULL,
  `attendence` int(1) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblattendence`
--

/*!40000 ALTER TABLE `tblattendence` DISABLE KEYS */;
INSERT INTO `tblattendence` VALUES (1,'2025-09-30',3,1,1,9,6,1,'::1','2025-10-01 20:15:36','::1','2025-10-01 20:15:36'),(2,'2025-09-30',3,1,2,9,6,1,'::1','2025-10-01 20:23:08','::1','2025-10-01 20:23:08'),(3,'2025-09-30',3,1,1,9,6,1,'::1','2025-10-01 00:23:29','::1','2025-10-01 00:23:29'),(4,'2025-09-30',3,1,3,9,6,0,'::1','2025-10-01 00:40:33','::1','2025-10-01 00:40:33'),(5,'2025-10-01',3,1,8,9,1,1,'::1','2025-10-01 20:23:30','::1','2025-10-01 20:23:30'),(6,'2025-10-01',3,1,8,9,6,1,'::1','2025-10-01 20:23:59','::1','2025-10-01 20:23:59');
/*!40000 ALTER TABLE `tblattendence` ENABLE KEYS */;

--
-- Table structure for table `tblcourse`
--

DROP TABLE IF EXISTS `tblcourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcourse` (
  `courseId` int(10) NOT NULL AUTO_INCREMENT,
  `courseName` varchar(100) NOT NULL,
  `courseDuration` varchar(10) NOT NULL,
  `sessionId` int(10) NOT NULL,
  PRIMARY KEY (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcourse`
--

/*!40000 ALTER TABLE `tblcourse` DISABLE KEYS */;
INSERT INTO `tblcourse` VALUES (1,'bba','3',8),(2,'bca','3',8),(3,'b tech','4',8),(4,'LLB','5',8),(5,'Mba','2',8),(9,'B com','3',8);
/*!40000 ALTER TABLE `tblcourse` ENABLE KEYS */;

--
-- Table structure for table `tblcoursefees`
--

DROP TABLE IF EXISTS `tblcoursefees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcoursefees` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `courseId` int(10) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `totalFees` int(10) NOT NULL,
  `sessionId` int(10) NOT NULL,
  `dueDate` date NOT NULL,
  `addedIpAddress` varchar(100) NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` varchar(100) NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcoursefees`
--

/*!40000 ALTER TABLE `tblcoursefees` DISABLE KEYS */;
INSERT INTO `tblcoursefees` VALUES (2,2,1,30000,8,'2025-07-22','223.184.108.166','2025-02-27 12:51:47','223.184.108.166','2025-02-27 12:51:47'),(4,3,1,120000,8,'2025-07-28','106.215.55.188','2025-02-17 07:25:07','106.215.55.188','2025-02-17 07:25:07'),(5,3,2,120000,8,'2026-06-09','106.215.55.188','2025-02-17 07:25:55','106.215.55.188','2025-02-17 07:25:55'),(6,1,2,200000,8,'2025-11-27','106.215.55.188','2025-02-17 07:55:43','106.215.55.188','2025-02-17 07:55:43'),(7,1,3,120000,8,'2025-10-14','183.83.52.235','2025-02-17 09:28:10','183.83.52.235','2025-02-17 09:28:10'),(8,3,1,110000,8,'2025-11-19','27.58.7.142','2025-02-21 04:12:42','27.58.7.142','2025-02-21 04:12:42'),(9,3,1,120000,9,'2026-10-13','27.58.7.142','2025-02-21 04:20:07','27.58.7.142','2025-02-21 04:20:07'),(10,1,1,100000,7,'2024-10-23','183.83.53.10','2025-02-25 08:49:26','183.83.53.10','2025-02-25 08:49:26'),(11,1,2,120000,7,'2024-05-14','183.83.53.10','2025-02-25 08:49:51','183.83.53.10','2025-02-25 08:49:51'),(12,2,2,110000,8,'2025-02-28','183.83.53.10','2025-02-25 09:56:01','183.83.53.10','2025-02-25 09:56:01'),(13,2,1,40000,9,'2025-07-22','122.172.4.102','2025-06-27 11:30:55','122.172.4.102','2025-06-27 11:30:55'),(14,3,2,200000,9,'2026-05-11','157.48.96.59','2025-09-25 05:25:29','157.48.96.59','2025-09-25 05:25:29'),(16,3,1,120000,9,'2025-09-27','183.83.54.121','2025-06-28 10:21:28','183.83.54.121','2025-06-28 10:21:28'),(17,3,2,200000,10,'2026-06-16','::1','2026-01-28 09:17:04','::1','2026-01-28 09:17:04');
/*!40000 ALTER TABLE `tblcoursefees` ENABLE KEYS */;

--
-- Table structure for table `tblfees`
--

DROP TABLE IF EXISTS `tblfees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfees` (
  `feeId` int(100) NOT NULL AUTO_INCREMENT,
  `studentId` int(100) NOT NULL,
  `courseId` int(100) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `totalFees` int(100) NOT NULL,
  `discountMoney` int(100) DEFAULT NULL,
  `paidFees` int(100) NOT NULL,
  `dateOfSubmissionOfFees` date NOT NULL,
  `sessionId` int(10) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime(6) NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDatetime` datetime(6) NOT NULL,
  PRIMARY KEY (`feeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfees`
--

/*!40000 ALTER TABLE `tblfees` DISABLE KEYS */;
INSERT INTO `tblfees` VALUES (1,6,3,1,120000,10000,20000,'2025-09-30',9,'::1','2025-09-30 11:00:17.000000','::1','2025-09-30 11:00:17.000000'),(2,1,3,1,120000,12000,45000,'2025-11-07',9,'::1','2025-11-07 08:23:53.000000','::1','2025-11-07 08:23:53.000000'),(3,6,3,2,200000,100000,50000,'2026-01-28',10,'::1','2026-01-28 09:17:31.000000','::1','2026-01-28 09:17:31.000000'),(4,1,3,2,200000,50000,100000,'2026-02-05',10,'::1','2026-02-05 09:57:22.000000','::1','2026-02-05 09:57:22.000000');
/*!40000 ALTER TABLE `tblfees` ENABLE KEYS */;

--
-- Table structure for table `tblmeetingparticipants`
--

DROP TABLE IF EXISTS `tblmeetingparticipants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmeetingparticipants` (
  `participantId` int(11) NOT NULL AUTO_INCREMENT,
  `meetingId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `joinTime` datetime DEFAULT current_timestamp(),
  `leaveTime` datetime DEFAULT NULL,
  PRIMARY KEY (`participantId`),
  KEY `meetingId` (`meetingId`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `tblmeetingparticipants_ibfk_1` FOREIGN KEY (`meetingId`) REFERENCES `tblmeetings` (`meetingId`) ON DELETE CASCADE,
  CONSTRAINT `tblmeetingparticipants_ibfk_2` FOREIGN KEY (`studentId`) REFERENCES `tblstudent` (`studentId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmeetingparticipants`
--

/*!40000 ALTER TABLE `tblmeetingparticipants` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmeetingparticipants` ENABLE KEYS */;

--
-- Table structure for table `tblmeetings`
--

DROP TABLE IF EXISTS `tblmeetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmeetings` (
  `meetingId` int(11) NOT NULL AUTO_INCREMENT,
  `teacherId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `academicYearId` int(11) NOT NULL,
  `meetingTitle` varchar(255) NOT NULL,
  `meetingDescription` text DEFAULT NULL,
  `meetingRoomId` varchar(100) NOT NULL,
  `meetingDate` date DEFAULT NULL,
  `meetingTime` time DEFAULT NULL,
  `meetingType` enum('scheduled','instant') DEFAULT 'scheduled',
  `meetingStatus` enum('upcoming','live','ended') DEFAULT 'upcoming',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`meetingId`),
  KEY `teacherId` (`teacherId`),
  KEY `subjectId` (`subjectId`),
  KEY `courseId` (`courseId`),
  KEY `meetingRoomId` (`meetingRoomId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmeetings`
--

/*!40000 ALTER TABLE `tblmeetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmeetings` ENABLE KEYS */;

--
-- Table structure for table `tblmodule`
--

DROP TABLE IF EXISTS `tblmodule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmodule` (
  `moduleId` int(11) NOT NULL AUTO_INCREMENT,
  `specialCourseId` int(11) NOT NULL,
  `moduleName` varchar(100) NOT NULL,
  `moduleDescription` text DEFAULT NULL,
  `moduleFile` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`moduleId`),
  KEY `courseId` (`specialCourseId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmodule`
--

/*!40000 ALTER TABLE `tblmodule` DISABLE KEYS */;
INSERT INTO `tblmodule` VALUES (1,1,'Introduction to Python','Overview of Python, installation, and setup.',NULL,'2025-09-27 17:01:20'),(2,1,'Variables and Data Types','Numbers, strings, lists, tuples, dictionaries.',NULL,'2025-09-27 17:03:17'),(3,1,'Operators and Expressions','Arithmetic, comparison, logical operators.',NULL,'2025-09-27 17:03:42');
/*!40000 ALTER TABLE `tblmodule` ENABLE KEYS */;

--
-- Table structure for table `tblnotice`
--

DROP TABLE IF EXISTS `tblnotice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblnotice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `studentId` int(10) NOT NULL,
  `courseId` int(10) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `cutOffAttendence` int(10) NOT NULL,
  `sessionId` int(10) NOT NULL,
  `noticeDate` date NOT NULL,
  `notice` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblnotice`
--

/*!40000 ALTER TABLE `tblnotice` DISABLE KEYS */;
INSERT INTO `tblnotice` VALUES (1,1,3,1,75,8,'2025-03-31','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(2,1,3,1,90,8,'2025-03-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(3,15,3,1,90,8,'2025-03-31','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(4,27,3,1,90,8,'2025-03-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(5,4,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(6,5,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(7,8,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(8,16,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(9,29,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(10,28,2,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(11,1,3,1,85,8,'2025-04-09','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(12,27,3,1,85,8,'2025-04-09','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(13,1,3,1,75,8,'2025-06-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(14,32,3,1,75,8,'2025-06-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(15,35,3,1,75,9,'2025-09-24','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(16,36,3,1,75,9,'2025-09-25','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(17,1,3,2,75,9,'2025-09-25','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(18,34,3,1,100,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(19,35,3,1,100,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(20,36,3,1,100,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(21,34,3,1,90,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(22,35,3,1,90,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(23,36,3,1,90,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(24,1,3,1,75,9,'2025-10-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(25,6,3,1,75,9,'2025-10-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(26,2,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(27,3,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(28,4,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(29,5,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(30,7,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(31,1,3,2,100,10,'2026-02-19','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(32,6,3,2,100,10,'2026-02-19','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    ');
/*!40000 ALTER TABLE `tblnotice` ENABLE KEYS */;

--
-- Table structure for table `tblresult`
--

DROP TABLE IF EXISTS `tblresult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblresult` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `testId` int(10) NOT NULL,
  `studentId` int(10) NOT NULL,
  `courseId` int(10) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `subjectId` int(10) NOT NULL,
  `marksObtained` int(10) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblresult`
--

/*!40000 ALTER TABLE `tblresult` DISABLE KEYS */;
INSERT INTO `tblresult` VALUES (103,1,1,3,1,1,30,'::1','2025-10-01 08:39:41','::1','2025-10-01 08:39:41'),(104,1,6,3,1,1,2,'::1','2025-10-01 08:39:41','::1','2025-10-01 08:39:41'),(105,1,1,3,1,1,30,'::1','2025-10-01 08:40:14','::1','2025-10-01 08:40:14'),(106,1,6,3,1,1,2,'::1','2025-10-01 08:40:14','::1','2025-10-01 08:40:14'),(107,1,1,3,1,2,32,'::1','2025-11-07 09:59:00','::1','2025-11-07 09:59:00'),(108,1,6,3,1,2,31,'::1','2025-11-07 09:59:00','::1','2025-11-07 09:59:00');
/*!40000 ALTER TABLE `tblresult` ENABLE KEYS */;

--
-- Table structure for table `tblsession`
--

DROP TABLE IF EXISTS `tblsession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsession` (
  `sessionId` int(10) NOT NULL AUTO_INCREMENT,
  `sessionName` varchar(15) NOT NULL,
  `addedIpAddress` varchar(100) NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` varchar(100) NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`sessionId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsession`
--

/*!40000 ALTER TABLE `tblsession` DISABLE KEYS */;
INSERT INTO `tblsession` VALUES (1,'2017-18','183.83.53.189','2025-03-10 08:26:26','183.83.53.189','2025-03-10 08:26:26',0),(2,'2018-19','171.49.193.112','2025-02-16 04:03:25','171.49.193.112','2025-02-16 04:03:25',0),(3,'2019-20','171.49.193.112','2025-02-16 04:03:35','171.49.193.112','2025-02-16 04:03:35',0),(4,'2020-21','171.49.193.112','2025-02-16 04:03:44','171.49.193.112','2025-02-16 04:03:44',0),(5,'2021-22','171.49.193.112','2025-02-16 05:06:07','171.49.193.112','2025-02-16 05:06:07',0),(6,'2022-23','171.49.193.112','2025-02-16 04:54:50','171.49.193.112','2025-02-16 04:54:50',0),(7,'2023-24','152.59.116.55','2025-04-09 08:22:48','152.59.116.55','2025-04-09 08:22:48',0),(8,'2024-25','157.48.102.121','2025-09-25 05:07:14','157.48.102.121','2025-09-25 05:07:14',0),(9,'2025-26','::1','2026-01-28 09:16:17','::1','2026-01-28 09:16:17',0),(10,'2026-27','::1','2026-01-28 09:16:10','::1','2026-01-28 09:16:10',1);
/*!40000 ALTER TABLE `tblsession` ENABLE KEYS */;

--
-- Table structure for table `tblspecialcourse`
--

DROP TABLE IF EXISTS `tblspecialcourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblspecialcourse` (
  `specialCourseId` int(11) NOT NULL AUTO_INCREMENT,
  `specialCourseName` varchar(255) NOT NULL,
  `courseId` int(10) NOT NULL,
  `specialCourseDescription` text DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`specialCourseId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblspecialcourse`
--

/*!40000 ALTER TABLE `tblspecialcourse` DISABLE KEYS */;
INSERT INTO `tblspecialcourse` VALUES (1,'Python Basics',3,'An introductory course to Python programming covering basics of syntax, data types, and simple projects.','2025-09-28 03:56:54'),(2,'Advance Java',3,'Java technologies for building dynamic, database-driven, and enterprise-level applications.','2025-10-01 23:06:13'),(3,'OOP',3,'Programming paradigm using objects and classes to model real-world entities.','2025-10-01 23:07:11');
/*!40000 ALTER TABLE `tblspecialcourse` ENABLE KEYS */;

--
-- Table structure for table `tblstudent`
--

DROP TABLE IF EXISTS `tblstudent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstudent` (
  `studentId` int(100) NOT NULL AUTO_INCREMENT,
  `studentName` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `courseId` int(100) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `sessionId` int(100) NOT NULL,
  `studentNumber` varchar(15) NOT NULL,
  `studentGender` int(100) NOT NULL,
  `studentEmail` varchar(100) NOT NULL,
  `studentPassword` varchar(100) NOT NULL,
  `fatherName` varchar(100) NOT NULL,
  `motherName` varchar(100) NOT NULL,
  `parentNumber` varchar(15) NOT NULL,
  `parentEmail` varchar(100) NOT NULL,
  `dateOfRegistration` datetime(6) NOT NULL,
  `address` varchar(100) NOT NULL,
  `studentImage` varchar(300) DEFAULT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime(6) NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  `section` varchar(10) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudent`
--

/*!40000 ALTER TABLE `tblstudent` DISABLE KEYS */;
INSERT INTO `tblstudent` VALUES (1,'Himanshbhj','2025-10-01',3,2,9,'6375324605',2,'jhvjhv@gmail.com','12312','hjgjhgjh','vjhfhjkgkjyg','8768757876','gjgkg@gmail.com','2025-09-29 00:00:00.000000','hj,jkv,mjh',NULL,'::1','2025-12-30 20:35:37.000000','::1','2025-12-30 20:35:37','A'),(2,'Himanshbhjvg','2011-10-29',1,2,9,'6375324604',2,'jhvjhv@gmail.com','101010','hjgjhgjh','vjhfhjkgkjyg','8768757876','gjgkg@gmail.com','2025-09-29 00:00:00.000000','hj,jkv,mjh',NULL,'::1','2025-09-29 10:44:30.000000','::1','2025-09-29 10:44:30','A'),(3,'Himanshbhjvg','2011-10-29',1,2,9,'6375324604',2,'jhvjhv@gmail.com','101010','hjgjhgjh','vjhfhjkgkjyg','8768757876','gjgkg@gmail.com','2025-09-29 00:00:00.000000','hj,jkv,mjh',NULL,'::1','2025-09-29 10:45:19.000000','::1','2025-09-29 10:45:19','A'),(4,'hbjbjm','2025-09-11',1,2,9,'9696787676',2,'himanshu@gmail.com','9887','kjnkbk','bkjbkhbj','9887679876','gjgkg@gmail.com','2025-09-30 00:00:00.000000','ujgbbgj',NULL,'::1','2025-09-30 09:37:16.000000','::1','2025-09-30 09:37:16','A'),(5,'rudra','2004-02-12',1,2,9,'9327950361',2,'rudra@gmail.com','103020','rajesh thakkar','meena ','6576887678','rajesh@gmail.com','2025-09-30 00:00:00.000000','gujrat',NULL,'::1','2025-09-30 10:07:59.000000','::1','2025-09-30 10:07:59','A'),(6,'pulkit','2007-10-10',3,2,9,'9256470710',2,'test@example.in','101112','indra kumar','sushila ','9829380661','test@example.com','2025-09-30 00:00:00.000000','jaipur',NULL,'::1','2025-09-30 10:19:03.000000','::1','2025-09-30 10:19:03','A'),(7,'hi,manshiuah','2025-12-10',1,2,9,'7879979878',2,'jhgbjh@gmail.com','87686','kjhbkjbk','bkgjkb','7897979979','jnmbj@gmail.com','2025-12-30 00:00:00.000000','njvngv mnknbk,',NULL,'::1','2025-12-30 07:53:26.000000','::1','2025-12-30 07:53:26','A');
/*!40000 ALTER TABLE `tblstudent` ENABLE KEYS */;

--
-- Table structure for table `tblstudentcourseprogress`
--

DROP TABLE IF EXISTS `tblstudentcourseprogress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstudentcourseprogress` (
  `progressId` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `progressPercentage` decimal(5,2) NOT NULL,
  `lastAccessed` datetime NOT NULL,
  PRIMARY KEY (`progressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudentcourseprogress`
--

/*!40000 ALTER TABLE `tblstudentcourseprogress` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblstudentcourseprogress` ENABLE KEYS */;

--
-- Table structure for table `tblsubject`
--

DROP TABLE IF EXISTS `tblsubject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsubject` (
  `subjectId` int(10) NOT NULL AUTO_INCREMENT,
  `subjectName` text NOT NULL,
  `courseId` int(10) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `sessionId` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`subjectId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsubject`
--

/*!40000 ALTER TABLE `tblsubject` DISABLE KEYS */;
INSERT INTO `tblsubject` VALUES (1,'DSA',3,1,9,1,'::1','2026-01-22 08:20:27','::1','2026-01-22 08:20:27'),(2,'SE',3,1,8,1,'183.83.53.10','2025-03-05 08:38:30','183.83.53.10','2025-03-05 08:38:30'),(3,'DE',3,1,8,1,'182.68.130.194','2025-03-05 01:46:07','182.68.130.194','2025-03-05 01:46:07'),(4,'BST',1,1,8,1,'182.68.130.194','2025-03-05 02:25:20','182.68.130.194','2025-03-05 02:25:20'),(5,'Econimics',1,2,8,1,'122.181.92.233','2025-03-08 12:11:19','122.181.92.233','2025-03-08 12:11:19'),(6,'Python',3,2,8,1,'183.83.53.189','2025-03-11 08:34:13','183.83.53.189','2025-03-11 08:34:13'),(7,'MP',3,2,8,1,'183.83.53.189','2025-03-11 08:34:25','183.83.53.189','2025-03-11 08:34:25'),(8,'ML',3,1,8,1,'182.68.79.23','2025-03-15 02:12:49','182.68.79.23','2025-03-15 02:12:49'),(9,'TC',3,1,8,1,'182.68.79.23','2025-03-15 02:13:07','182.68.79.23','2025-03-15 02:13:07'),(10,'English',3,1,8,1,'182.68.79.23','2025-03-15 02:13:34','182.68.79.23','2025-03-15 02:13:34'),(11,'DBMS',2,1,8,1,'183.83.52.52','2025-04-01 08:26:18','183.83.52.52','2025-04-01 08:26:18'),(12,'DBMS',3,2,9,1,'183.83.54.121','2025-06-28 10:22:51','183.83.54.121','2025-06-28 10:22:51'),(13,'ITC',3,1,9,1,'117.99.165.227','2025-09-24 10:18:38','117.99.165.227','2025-09-24 10:18:38'),(14,'AOA',3,2,9,1,'117.99.165.227','2025-09-25 04:36:32','117.99.165.227','2025-09-25 04:36:32');
/*!40000 ALTER TABLE `tblsubject` ENABLE KEYS */;

--
-- Table structure for table `tblteacher`
--

DROP TABLE IF EXISTS `tblteacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblteacher` (
  `teacherId` int(10) NOT NULL AUTO_INCREMENT,
  `teacherName` varchar(150) NOT NULL,
  `teacherEmail` varchar(150) NOT NULL,
  `teacherPhone` varchar(15) NOT NULL,
  `teacherGender` int(1) NOT NULL,
  `teacherPassword` varchar(100) NOT NULL,
  `subjectId` int(10) NOT NULL,
  `joiningDate` date NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`teacherId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblteacher`
--

/*!40000 ALTER TABLE `tblteacher` DISABLE KEYS */;
INSERT INTO `tblteacher` VALUES (4,'himanshu','himanshu@gmail.com','6375324604',1,'1123',1,'2025-09-26','182.68.187.223','2025-09-26 00:13:55','182.68.187.223','2025-09-26 00:13:55'),(5,'shubhra','shubhra@gmail.com','9786567465',2,'1321',5,'2025-09-26','182.68.187.223','2025-09-26 00:17:50','182.68.187.223','2025-09-26 00:17:50'),(6,'teju','teju@gmail.com','9327950361',1,'12324',6,'2025-09-28','103.54.14.83','2025-09-28 00:04:32','103.54.14.83','2025-09-28 00:04:32');
/*!40000 ALTER TABLE `tblteacher` ENABLE KEYS */;

--
-- Table structure for table `tbltest`
--

DROP TABLE IF EXISTS `tbltest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbltest` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `testId` int(10) NOT NULL,
  `maximumMarks` int(10) NOT NULL,
  `courseId` int(10) NOT NULL,
  `academicYearId` int(10) NOT NULL,
  `subjectId` int(10) NOT NULL,
  `dateOfTest` date NOT NULL,
  `sessionId` int(10) NOT NULL,
  `testStatus` int(2) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltest`
--

/*!40000 ALTER TABLE `tbltest` DISABLE KEYS */;
INSERT INTO `tbltest` VALUES (1,1,40,3,1,1,'2025-09-29',9,1,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(2,1,40,3,1,2,'2025-10-07',9,1,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(3,1,40,3,1,3,'2025-10-09',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(4,1,40,3,1,8,'2025-10-11',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(5,1,40,3,1,9,'2025-10-13',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(6,1,40,3,1,10,'2025-10-15',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(7,1,40,3,1,13,'2025-10-17',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(8,1,40,1,2,5,'2025-11-06',9,0,'::1','2025-11-07 10:12:50','::1','2025-11-07 10:12:50'),(9,1,40,1,2,5,'2025-11-06',9,0,'::1','2025-11-07 10:14:18','::1','2025-11-07 10:14:18'),(10,1,40,3,2,6,'2025-11-06',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54'),(11,1,40,3,2,7,'2025-11-09',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54'),(12,1,40,3,2,12,'2025-11-11',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54'),(13,1,40,3,2,14,'2025-11-13',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54');
/*!40000 ALTER TABLE `tbltest` ENABLE KEYS */;

--
-- Table structure for table `tbltestdetail`
--

DROP TABLE IF EXISTS `tbltestdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbltestdetail` (
  `testId` int(10) NOT NULL AUTO_INCREMENT,
  `testName` text NOT NULL,
  `maximumMarks` int(10) NOT NULL,
  `addedIpAddress` text NOT NULL,
  `addedDateTime` datetime NOT NULL,
  `updatedIpAddress` text NOT NULL,
  `updatedDateTime` datetime NOT NULL,
  PRIMARY KEY (`testId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltestdetail`
--

/*!40000 ALTER TABLE `tbltestdetail` DISABLE KEYS */;
INSERT INTO `tbltestdetail` VALUES (1,'MTT 1',40,'::1','2025-09-30 11:27:12','::1','2025-09-30 11:27:12');
/*!40000 ALTER TABLE `tbltestdetail` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-20 15:12:04

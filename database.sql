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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblacademicyear`
--

LOCK TABLES `tblacademicyear` WRITE;
/*!40000 ALTER TABLE `tblacademicyear` DISABLE KEYS */;
INSERT INTO `tblacademicyear` VALUES (1,'1st Year','171.49.208.16','2025-02-13 07:31:16','171.49.208.16','2025-02-13 07:31:16'),(2,'2nd Year','171.49.208.16','2025-02-13 07:31:53','171.49.208.16','2025-02-13 07:31:53'),(3,'3rd Year','171.49.208.16','2025-02-13 07:31:59','171.49.208.16','2025-02-13 07:31:59'),(4,'4th Year','171.49.208.16','2025-02-13 07:32:05','171.49.208.16','2025-02-13 07:32:05'),(5,'5th Year','171.49.208.16','2025-02-13 07:32:11','171.49.208.16','2025-02-13 07:32:11'),(6,'6th Year','122.181.92.233','2025-03-08 01:32:37','122.181.92.233','2025-03-08 01:32:37');
/*!40000 ALTER TABLE `tblacademicyear` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbladmin`
--

LOCK TABLES `tbladmin` WRITE;
/*!40000 ALTER TABLE `tbladmin` DISABLE KEYS */;
INSERT INTO `tbladmin` VALUES (1,'himanshu21','12342',2,'6375324604',8,2,'::1','2025-10-01 20:27:21.000000','::1','2025-10-01 20:27:21.000000'),(2,'pulkit1','1007',2,'9256470710',4,1,'183.83.53.10','2025-03-04 20:27:49.000000','183.83.53.10','2025-03-04 20:27:49.000000'),(4,'himanshuuu','0786',2,'6745735123',1,3,'182.68.79.23','2025-03-14 22:31:04.000000','182.68.79.23','2025-03-14 22:31:04.000000'),(5,'pulkit','678686',2,'9256470710',1,3,'182.68.102.28','2025-02-22 16:15:34.000000','182.68.102.28','2025-02-22 16:15:34.000000'),(7,'messi','23243',2,'7977574883',1,3,'183.83.53.10','2025-03-04 20:27:27.000000','183.83.53.10','2025-03-04 20:27:27.000000'),(8,'shubhra','101010',1,'9797777898',1,3,'106.201.148.39','2025-02-05 07:05:02.000000','106.201.148.39','2025-02-05 07:05:02.000000'),(9,'manoj1','8787',2,'9887658674',1,3,'183.83.53.10','2025-03-04 20:27:41.000000','183.83.53.10','2025-03-04 20:27:41.000000'),(10,'sanoj1','9879',2,'9877578756',1,3,'152.59.108.79','2025-03-10 17:00:41.000000','152.59.108.79','2025-03-10 17:00:41.000000'),(12,'yajat','0998',2,'9896979778',8,4,'182.68.79.23','2025-03-14 10:34:19.000000','182.68.79.23','2025-03-14 10:34:19.000000');
/*!40000 ALTER TABLE `tbladmin` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblattendence`
--

LOCK TABLES `tblattendence` WRITE;
/*!40000 ALTER TABLE `tblattendence` DISABLE KEYS */;
INSERT INTO `tblattendence` VALUES (1,'2025-09-30',3,1,1,9,6,1,'::1','2025-10-01 20:15:36','::1','2025-10-01 20:15:36'),(2,'2025-09-30',3,1,2,9,6,1,'::1','2025-10-01 20:23:08','::1','2025-10-01 20:23:08'),(3,'2025-09-30',3,1,1,9,6,1,'::1','2025-10-01 00:23:29','::1','2025-10-01 00:23:29'),(4,'2025-09-30',3,1,3,9,6,0,'::1','2025-10-01 00:40:33','::1','2025-10-01 00:40:33'),(5,'2025-10-01',3,1,8,9,1,1,'::1','2025-10-01 20:23:30','::1','2025-10-01 20:23:30'),(6,'2025-10-01',3,1,8,9,6,1,'::1','2025-10-01 20:23:59','::1','2025-10-01 20:23:59');
/*!40000 ALTER TABLE `tblattendence` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `tblcourse` WRITE;
/*!40000 ALTER TABLE `tblcourse` DISABLE KEYS */;
INSERT INTO `tblcourse` VALUES (1,'bba','3',8),(2,'bca','3',8),(3,'b tech','4',8),(4,'LLB','5',8),(5,'Mba','2',8),(9,'B com','3',8);
/*!40000 ALTER TABLE `tblcourse` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcoursefees`
--

LOCK TABLES `tblcoursefees` WRITE;
/*!40000 ALTER TABLE `tblcoursefees` DISABLE KEYS */;
INSERT INTO `tblcoursefees` VALUES (2,2,1,30000,8,'2025-07-22','223.184.108.166','2025-02-27 12:51:47','223.184.108.166','2025-02-27 12:51:47'),(4,3,1,120000,8,'2025-07-28','106.215.55.188','2025-02-17 07:25:07','106.215.55.188','2025-02-17 07:25:07'),(5,3,2,120000,8,'2026-06-09','106.215.55.188','2025-02-17 07:25:55','106.215.55.188','2025-02-17 07:25:55'),(6,1,2,200000,8,'2025-11-27','106.215.55.188','2025-02-17 07:55:43','106.215.55.188','2025-02-17 07:55:43'),(7,1,3,120000,8,'2025-10-14','183.83.52.235','2025-02-17 09:28:10','183.83.52.235','2025-02-17 09:28:10'),(8,3,1,110000,8,'2025-11-19','27.58.7.142','2025-02-21 04:12:42','27.58.7.142','2025-02-21 04:12:42'),(9,3,1,120000,9,'2026-10-13','27.58.7.142','2025-02-21 04:20:07','27.58.7.142','2025-02-21 04:20:07'),(10,1,1,100000,7,'2024-10-23','183.83.53.10','2025-02-25 08:49:26','183.83.53.10','2025-02-25 08:49:26'),(11,1,2,120000,7,'2024-05-14','183.83.53.10','2025-02-25 08:49:51','183.83.53.10','2025-02-25 08:49:51'),(12,2,2,110000,8,'2025-02-28','183.83.53.10','2025-02-25 09:56:01','183.83.53.10','2025-02-25 09:56:01'),(13,2,1,40000,9,'2025-07-22','122.172.4.102','2025-06-27 11:30:55','122.172.4.102','2025-06-27 11:30:55'),(14,3,2,200000,9,'2026-05-11','157.48.96.59','2025-09-25 05:25:29','157.48.96.59','2025-09-25 05:25:29'),(16,3,1,120000,9,'2025-09-27','183.83.54.121','2025-06-28 10:21:28','183.83.54.121','2025-06-28 10:21:28'),(17,3,2,200000,10,'2026-06-16','::1','2026-01-28 09:17:04','::1','2026-01-28 09:17:04');
/*!40000 ALTER TABLE `tblcoursefees` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfees`
--

LOCK TABLES `tblfees` WRITE;
/*!40000 ALTER TABLE `tblfees` DISABLE KEYS */;
INSERT INTO `tblfees` VALUES (1,6,3,1,120000,10000,20000,'2025-09-30',9,'::1','2025-09-30 11:00:17.000000','::1','2025-09-30 11:00:17.000000'),(2,1,3,1,120000,12000,45000,'2025-11-07',9,'::1','2025-11-07 08:23:53.000000','::1','2025-11-07 08:23:53.000000'),(3,6,3,2,200000,100000,50000,'2026-01-28',10,'::1','2026-01-28 09:17:31.000000','::1','2026-01-28 09:17:31.000000'),(4,1,3,2,200000,50000,100000,'2026-02-05',10,'::1','2026-02-05 09:57:22.000000','::1','2026-02-05 09:57:22.000000');
/*!40000 ALTER TABLE `tblfees` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `tblmeetingparticipants` WRITE;
/*!40000 ALTER TABLE `tblmeetingparticipants` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmeetingparticipants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmeetings`
--

DROP TABLE IF EXISTS `tblmeetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmeetings` (
  `meetingId` int(11) NOT NULL AUTO_INCREMENT,
  `teacherId` int(11) NOT NULL,
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
  KEY `courseId` (`courseId`),
  KEY `meetingRoomId` (`meetingRoomId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmeetings`
--

LOCK TABLES `tblmeetings` WRITE;
/*!40000 ALTER TABLE `tblmeetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmeetings` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmodule`
--

LOCK TABLES `tblmodule` WRITE;
/*!40000 ALTER TABLE `tblmodule` DISABLE KEYS */;
INSERT INTO `tblmodule` VALUES (1,1,'Introduction to Python','Overview of Python, installation, and setup.',NULL,'2025-09-27 17:01:20'),(2,1,'Variables and Data Types','Numbers, strings, lists, tuples, dictionaries.',NULL,'2025-09-27 17:03:17'),(3,1,'Operators and Expressions','Arithmetic, comparison, logical operators.',NULL,'2025-09-27 17:03:42');
/*!40000 ALTER TABLE `tblmodule` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblnotice`
--

LOCK TABLES `tblnotice` WRITE;
/*!40000 ALTER TABLE `tblnotice` DISABLE KEYS */;
INSERT INTO `tblnotice` VALUES (1,1,3,1,75,8,'2025-03-31','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(2,1,3,1,90,8,'2025-03-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(3,15,3,1,90,8,'2025-03-31','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(4,27,3,1,90,8,'2025-03-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(5,4,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(6,5,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(7,8,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(8,16,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(9,29,1,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(10,28,2,1,75,8,'2025-04-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(11,1,3,1,85,8,'2025-04-09','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(12,27,3,1,85,8,'2025-04-09','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(13,1,3,1,75,8,'2025-06-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(14,32,3,1,75,8,'2025-06-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(15,35,3,1,75,9,'2025-09-24','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(16,36,3,1,75,9,'2025-09-25','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(17,1,3,2,75,9,'2025-09-25','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(18,34,3,1,100,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(19,35,3,1,100,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(20,36,3,1,100,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(21,34,3,1,90,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(22,35,3,1,90,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(23,36,3,1,90,9,'2025-09-27','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(24,1,3,1,75,9,'2025-10-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(25,6,3,1,75,9,'2025-10-01','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(26,2,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(27,3,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(28,4,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(29,5,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(30,7,1,1,33,9,'2026-01-20','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(31,1,3,2,100,10,'2026-02-19','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    '),(32,6,3,2,100,10,'2026-02-19','We have observed that your attendance percentage has dropped below the required threshold. Maintaining a minimum attendance is essential for eligibility in exams and coursework.\r\n                    ');
/*!40000 ALTER TABLE `tblnotice` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblresult`
--

LOCK TABLES `tblresult` WRITE;
/*!40000 ALTER TABLE `tblresult` DISABLE KEYS */;
INSERT INTO `tblresult` VALUES (103,1,1,3,1,1,30,'::1','2025-10-01 08:39:41','::1','2025-10-01 08:39:41'),(104,1,6,3,1,1,2,'::1','2025-10-01 08:39:41','::1','2025-10-01 08:39:41'),(105,1,1,3,1,1,30,'::1','2025-10-01 08:40:14','::1','2025-10-01 08:40:14'),(106,1,6,3,1,1,2,'::1','2025-10-01 08:40:14','::1','2025-10-01 08:40:14'),(107,1,1,3,1,2,32,'::1','2025-11-07 09:59:00','::1','2025-11-07 09:59:00'),(108,1,6,3,1,2,31,'::1','2025-11-07 09:59:00','::1','2025-11-07 09:59:00');
/*!40000 ALTER TABLE `tblresult` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsession`
--

LOCK TABLES `tblsession` WRITE;
/*!40000 ALTER TABLE `tblsession` DISABLE KEYS */;
INSERT INTO `tblsession` VALUES (1,'2017-18','183.83.53.189','2025-03-10 08:26:26','183.83.53.189','2025-03-10 08:26:26',0),(2,'2018-19','171.49.193.112','2025-02-16 04:03:25','171.49.193.112','2025-02-16 04:03:25',0),(3,'2019-20','171.49.193.112','2025-02-16 04:03:35','171.49.193.112','2025-02-16 04:03:35',0),(4,'2020-21','171.49.193.112','2025-02-16 04:03:44','171.49.193.112','2025-02-16 04:03:44',0),(5,'2021-22','171.49.193.112','2025-02-16 05:06:07','171.49.193.112','2025-02-16 05:06:07',0),(6,'2022-23','171.49.193.112','2025-02-16 04:54:50','171.49.193.112','2025-02-16 04:54:50',0),(7,'2023-24','152.59.116.55','2025-04-09 08:22:48','152.59.116.55','2025-04-09 08:22:48',0),(8,'2024-25','157.48.102.121','2025-09-25 05:07:14','157.48.102.121','2025-09-25 05:07:14',0),(9,'2025-26','::1','2026-01-28 09:16:17','::1','2026-01-28 09:16:17',0),(10,'2026-27','::1','2026-01-28 09:16:10','::1','2026-01-28 09:16:10',1);
/*!40000 ALTER TABLE `tblsession` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblspecialcourse`
--

LOCK TABLES `tblspecialcourse` WRITE;
/*!40000 ALTER TABLE `tblspecialcourse` DISABLE KEYS */;
INSERT INTO `tblspecialcourse` VALUES (1,'Python Basics',3,'An introductory course to Python programming covering basics of syntax, data types, and simple projects.','2025-09-28 03:56:54'),(2,'Advance Java',3,'Java technologies for building dynamic, database-driven, and enterprise-level applications.','2025-10-01 23:06:13'),(3,'OOP',3,'Programming paradigm using objects and classes to model real-world entities.','2025-10-01 23:07:11');
/*!40000 ALTER TABLE `tblspecialcourse` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudent`
--

LOCK TABLES `tblstudent` WRITE;
/*!40000 ALTER TABLE `tblstudent` DISABLE KEYS */;
INSERT INTO `tblstudent` VALUES (1,'Himanshbhj','2025-10-01',3,2,9,'6375324605',2,'jhvjhv@gmail.com','12312','hjgjhgjh','vjhfhjkgkjyg','8768757876','gjgkg@gmail.com','2025-09-29 00:00:00.000000','hj,jkv,mjh',NULL,'::1','2025-12-30 20:35:37.000000','::1','2025-12-30 20:35:37'),(2,'Himanshbhjvg','2011-10-29',1,2,9,'6375324604',2,'jhvjhv@gmail.com','101010','hjgjhgjh','vjhfhjkgkjyg','8768757876','gjgkg@gmail.com','2025-09-29 00:00:00.000000','hj,jkv,mjh',NULL,'::1','2025-09-29 10:44:30.000000','::1','2025-09-29 10:44:30'),(3,'Himanshbhjvg','2011-10-29',1,2,9,'6375324604',2,'jhvjhv@gmail.com','101010','hjgjhgjh','vjhfhjkgkjyg','8768757876','gjgkg@gmail.com','2025-09-29 00:00:00.000000','hj,jkv,mjh',NULL,'::1','2025-09-29 10:45:19.000000','::1','2025-09-29 10:45:19'),(4,'hbjbjm','2025-09-11',1,2,9,'9696787676',2,'himanshu@gmail.com','9887','kjnkbk','bkjbkhbj','9887679876','gjgkg@gmail.com','2025-09-30 00:00:00.000000','ujgbbgj',NULL,'::1','2025-09-30 09:37:16.000000','::1','2025-09-30 09:37:16'),(5,'rudra','2004-02-12',1,2,9,'9327950361',2,'rudra@gmail.com','103020','rajesh thakkar','meena ','6576887678','rajesh@gmail.com','2025-09-30 00:00:00.000000','gujrat',NULL,'::1','2025-09-30 10:07:59.000000','::1','2025-09-30 10:07:59'),(6,'pulkit','2007-10-10',3,2,9,'9256470710',2,'test@example.in','101112','indra kumar','sushila ','9829380661','test@example.com','2025-09-30 00:00:00.000000','jaipur',NULL,'::1','2025-09-30 10:19:03.000000','::1','2025-09-30 10:19:03'),(7,'hi,manshiuah','2025-12-10',1,2,9,'7879979878',2,'jhgbjh@gmail.com','87686','kjhbkjbk','bkgjkb','7897979979','jnmbj@gmail.com','2025-12-30 00:00:00.000000','njvngv mnknbk,',NULL,'::1','2025-12-30 07:53:26.000000','::1','2025-12-30 07:53:26'),(8,'Kiran Pandey','2003-03-21',3,3,8,'725681388',2,'kiran.pandey61@example.com','263147','Akash Pandey','Kiran Pandey','796426599','akash.pandey@example.com','2026-05-19 17:31:45.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 17:31:45.000000','127.0.0.1','2026-05-19 17:31:45'),(9,'Kiran Pandey','2006-04-06',3,3,8,'799778078',2,'kiran.pandey82@example.com','110715','Sameer Pandey','Meera Pandey','972704990','sameer.pandey@example.com','2026-05-19 19:58:11.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 19:58:11.000000','127.0.0.1','2026-05-19 19:58:11'),(10,'Vijay Menon','2007-10-26',2,1,8,'780694180',2,'vijay.menon55@example.com','935497','Anil Menon','Shreya Menon','682413948','anil.menon@example.com','2026-05-19 15:34:14.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 15:34:14.000000','127.0.0.1','2026-05-19 15:34:14'),(11,'Vivaan Grewal','2002-03-15',2,2,10,'696232715',2,'vivaan.grewal55@example.com','833262','Karan Grewal','Shreya Grewal','616953482','karan.grewal@example.com','2026-05-19 11:25:50.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 11:25:50.000000','127.0.0.1','2026-05-19 11:25:50'),(12,'Pooja Dhillon','2005-07-19',9,3,9,'776795934',2,'pooja.dhillon44@example.com','751188','Yash Dhillon','Deepika Dhillon','620341409','yash.dhillon@example.com','2026-05-19 17:16:26.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 17:16:26.000000','127.0.0.1','2026-05-19 17:16:26'),(13,'Komal Pillai','2004-06-28',2,2,10,'828537430',2,'komal.pillai91@example.com','898937','Vijay Pillai','Saanvi Pillai','965714806','vijay.pillai@example.com','2026-05-19 18:49:49.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 18:49:49.000000','127.0.0.1','2026-05-19 18:49:49'),(14,'Meera Iyer','2007-09-20',9,3,8,'949275025',1,'meera.iyer95@example.com','830182','Vihaan Iyer','Sneha Iyer','935105728','vihaan.iyer@example.com','2026-05-19 11:42:30.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 11:42:30.000000','127.0.0.1','2026-05-19 11:42:30'),(15,'Varun Saxena','2004-05-28',1,1,9,'623548524',1,'varun.saxena75@example.com','441558','Gaurav Saxena','Riya Saxena','664497296','gaurav.saxena@example.com','2026-05-19 19:19:22.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 19:19:22.000000','127.0.0.1','2026-05-19 19:19:22'),(16,'Yash Roy','2002-02-09',3,3,10,'817678685',2,'yash.roy61@example.com','477623','Aarav Roy','Meera Roy','746009185','aarav.roy@example.com','2026-05-19 14:10:50.000000','404 Lake View Road, Udaipur',NULL,'127.0.0.1','2026-05-19 14:10:50.000000','127.0.0.1','2026-05-19 14:10:50'),(17,'Rajesh Gupta','2007-02-09',3,3,9,'874694735',1,'rajesh.gupta68@example.com','798394','Aditya Gupta','Sneha Gupta','789693884','aditya.gupta@example.com','2026-05-19 16:33:42.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 16:33:42.000000','127.0.0.1','2026-05-19 16:33:42'),(18,'Meera Singh','2006-02-10',2,3,8,'776449507',1,'meera.singh55@example.com','293905','Kabir Singh','Ritu Singh','640691092','kabir.singh@example.com','2026-05-19 16:10:58.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 16:10:58.000000','127.0.0.1','2026-05-19 16:10:58'),(19,'Saanvi Bose','2004-03-15',2,3,8,'619184017',2,'saanvi.bose36@example.com','750490','Anil Bose','Saanvi Bose','823614195','anil.bose@example.com','2026-05-19 18:45:16.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 18:45:16.000000','127.0.0.1','2026-05-19 18:45:16'),(20,'Siddharth Rao','2002-11-10',2,2,9,'949456026',1,'siddharth.rao50@example.com','951863','Harish Rao','Ritu Rao','816847243','harish.rao@example.com','2026-05-19 12:27:13.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 12:27:13.000000','127.0.0.1','2026-05-19 12:27:13'),(21,'Priti Malhotra','2005-01-25',1,1,10,'816898047',1,'priti.malhotra94@example.com','645735','Rahul Malhotra','Ritu Malhotra','922913829','rahul.malhotra@example.com','2026-05-19 13:20:51.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 13:20:51.000000','127.0.0.1','2026-05-19 13:20:51'),(22,'Karan Sodhi','2002-02-19',1,3,10,'763845226',2,'karan.sodhi97@example.com','849178','Gaurav Sodhi','Divya Sodhi','670573789','gaurav.sodhi@example.com','2026-05-19 18:43:38.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 18:43:38.000000','127.0.0.1','2026-05-19 18:43:38'),(23,'Komal Sodhi','2005-02-13',1,1,8,'825144118',2,'komal.sodhi93@example.com','296015','Kabir Sodhi','Priti Sodhi','733700526','kabir.sodhi@example.com','2026-05-19 19:59:43.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 19:59:43.000000','127.0.0.1','2026-05-19 19:59:43'),(24,'Gaurav Jain','2004-11-13',3,3,8,'947946964',2,'gaurav.jain27@example.com','961413','Anil Jain','Sonia Jain','868893498','anil.jain@example.com','2026-05-19 15:32:14.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 15:32:14.000000','127.0.0.1','2026-05-19 15:32:14'),(25,'Ritu Mukherjee','2004-06-17',1,2,8,'710515742',1,'ritu.mukherjee97@example.com','247075','Karan Mukherjee','Aanya Mukherjee','927656890','karan.mukherjee@example.com','2026-05-19 14:43:43.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 14:43:43.000000','127.0.0.1','2026-05-19 14:43:43'),(26,'Priya Rao','2006-09-18',3,2,9,'738176838',2,'priya.rao89@example.com','408507','Varun Rao','Priti Rao','998089114','varun.rao@example.com','2026-05-19 17:55:39.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 17:55:39.000000','127.0.0.1','2026-05-19 17:55:39'),(27,'Divya Chatterjee','2002-02-01',2,2,8,'643646224',1,'divya.chatterjee30@example.com','533566','Sunil Chatterjee','Shalini Chatterjee','773266298','sunil.chatterjee@example.com','2026-05-19 14:28:25.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 14:28:25.000000','127.0.0.1','2026-05-19 14:28:25'),(28,'Rajesh Gill','2005-12-19',3,1,8,'886002165',1,'rajesh.gill15@example.com','975437','Manish Gill','Shalini Gill','651810878','manish.gill@example.com','2026-05-19 19:12:30.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 19:12:30.000000','127.0.0.1','2026-05-19 19:12:30'),(29,'Kiran Jain','2005-07-14',2,2,8,'931965505',1,'kiran.jain27@example.com','544790','Kabir Jain','Ritu Jain','927616123','kabir.jain@example.com','2026-05-19 11:46:24.000000','909 High Street, Pune',NULL,'127.0.0.1','2026-05-19 11:46:24.000000','127.0.0.1','2026-05-19 11:46:24'),(30,'Saanvi Malhotra','2004-02-20',3,1,8,'856821120',1,'saanvi.malhotra31@example.com','715514','Vivaan Malhotra','Sonia Malhotra','751813068','vivaan.malhotra@example.com','2026-05-19 15:43:13.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 15:43:13.000000','127.0.0.1','2026-05-19 15:43:13'),(31,'Rohan Khanna','2003-05-14',2,2,9,'856815929',1,'rohan.khanna81@example.com','861593','Vijay Khanna','Aarti Khanna','779331366','vijay.khanna@example.com','2026-05-19 20:13:40.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 20:13:40.000000','127.0.0.1','2026-05-19 20:13:40'),(32,'Ishaan Sodhi','2004-04-10',3,1,9,'691072125',2,'ishaan.sodhi61@example.com','947474','Harish Sodhi','Nisha Sodhi','788851680','harish.sodhi@example.com','2026-05-19 13:34:37.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 13:34:37.000000','127.0.0.1','2026-05-19 13:34:37'),(33,'Amit Gupta','2007-04-23',2,3,8,'864504655',1,'amit.gupta44@example.com','414235','Rajesh Gupta','Saanvi Gupta','925562270','rajesh.gupta@example.com','2026-05-19 13:20:58.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 13:20:58.000000','127.0.0.1','2026-05-19 13:20:58'),(34,'Tanvi Das','2003-07-17',2,1,8,'957948325',1,'tanvi.das70@example.com','639917','Vivaan Das','Divya Das','748192802','vivaan.das@example.com','2026-05-19 16:51:42.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 16:51:42.000000','127.0.0.1','2026-05-19 16:51:42'),(35,'Shreya Mehta','2004-04-03',9,2,8,'846722686',2,'shreya.mehta53@example.com','359661','Kunwar Mehta','Ritu Mehta','837904071','kunwar.mehta@example.com','2026-05-19 14:47:33.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 14:47:33.000000','127.0.0.1','2026-05-19 14:47:33'),(36,'Aarti Gupta','2002-06-27',2,1,9,'813878251',2,'aarti.gupta62@example.com','425524','Yash Gupta','Deepika Gupta','864601027','yash.gupta@example.com','2026-05-19 10:36:10.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 10:36:10.000000','127.0.0.1','2026-05-19 10:36:10'),(37,'Ishaan Roy','2007-12-24',9,2,9,'653126289',1,'ishaan.roy55@example.com','827627','Vivaan Roy','Aarti Roy','824288206','vivaan.roy@example.com','2026-05-19 19:16:24.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 19:16:24.000000','127.0.0.1','2026-05-19 19:16:24'),(38,'Vikram Iyer','2002-05-07',1,2,8,'913264130',2,'vikram.iyer80@example.com','753727','Vijay Iyer','Komal Iyer','953397200','vijay.iyer@example.com','2026-05-19 16:32:43.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 16:32:43.000000','127.0.0.1','2026-05-19 16:32:43'),(39,'Gaurav Dhillon','2006-06-22',2,2,8,'837637408',2,'gaurav.dhillon82@example.com','261105','Kunwar Dhillon','Komal Dhillon','641780987','kunwar.dhillon@example.com','2026-05-19 11:25:39.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 11:25:39.000000','127.0.0.1','2026-05-19 11:25:39'),(40,'Rajesh Verma','2003-06-10',1,2,10,'852031725',1,'rajesh.verma92@example.com','451001','Karan Verma','Tanvi Verma','957376542','karan.verma@example.com','2026-05-19 17:33:33.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 17:33:33.000000','127.0.0.1','2026-05-19 17:33:33'),(41,'Sonia Patel','2003-05-19',3,1,8,'759622320',2,'sonia.patel94@example.com','391108','Yash Patel','Ananya Patel','791316668','yash.patel@example.com','2026-05-19 20:12:23.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 20:12:23.000000','127.0.0.1','2026-05-19 20:12:23'),(42,'Yash Roy','2002-01-15',2,3,9,'930536798',1,'yash.roy65@example.com','422722','Manish Roy','Priti Roy','631715827','manish.roy@example.com','2026-05-19 17:40:34.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 17:40:34.000000','127.0.0.1','2026-05-19 17:40:34'),(43,'Aarti Kumar','2002-02-15',1,2,10,'935386779',1,'aarti.kumar25@example.com','747760','Kabir Kumar','Ritu Kumar','756790429','kabir.kumar@example.com','2026-05-19 18:56:11.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 18:56:11.000000','127.0.0.1','2026-05-19 18:56:11'),(44,'Vijay Kumar','2007-07-02',3,2,8,'661505179',1,'vijay.kumar91@example.com','183150','Rahul Kumar','Sonia Kumar','963964259','rahul.kumar@example.com','2026-05-19 11:38:24.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 11:38:24.000000','127.0.0.1','2026-05-19 11:38:24'),(45,'Sneha Das','2007-04-10',2,3,9,'743155012',2,'sneha.das58@example.com','637045','Aarav Das','Ritu Das','977083904','aarav.das@example.com','2026-05-19 19:34:38.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 19:34:38.000000','127.0.0.1','2026-05-19 19:34:38'),(46,'Vikram Roy','2004-11-27',9,1,10,'853126393',1,'vikram.roy62@example.com','699922','Vivaan Roy','Sneha Roy','830881648','vivaan.roy@example.com','2026-05-19 15:33:57.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 15:33:57.000000','127.0.0.1','2026-05-19 15:33:57'),(47,'Aditi Pillai','2007-09-10',9,1,8,'925446413',2,'aditi.pillai70@example.com','296106','Amit Pillai','Nisha Pillai','955073108','amit.pillai@example.com','2026-05-19 12:36:18.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 12:36:18.000000','127.0.0.1','2026-05-19 12:36:18'),(48,'Aarav Giri','2005-01-09',3,1,9,'810324841',1,'aarav.giri97@example.com','838799','Karan Giri','Kriti Giri','870842943','karan.giri@example.com','2026-05-19 20:37:39.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 20:37:39.000000','127.0.0.1','2026-05-19 20:37:39'),(49,'Neha Shetty','2004-04-10',9,1,8,'825468896',1,'neha.shetty21@example.com','125817','Rohan Shetty','Komal Shetty','737537753','rohan.shetty@example.com','2026-05-19 15:24:37.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 15:24:37.000000','127.0.0.1','2026-05-19 15:24:37'),(50,'Varun Trivedi','2007-08-06',1,3,8,'852050572',1,'varun.trivedi51@example.com','995093','Yash Trivedi','Priti Trivedi','957475010','yash.trivedi@example.com','2026-05-19 19:24:18.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 19:24:18.000000','127.0.0.1','2026-05-19 19:24:18'),(51,'Kriti Singh','2004-08-27',9,1,8,'883350134',2,'kriti.singh12@example.com','758900','Aditya Singh','Komal Singh','884522322','aditya.singh@example.com','2026-05-19 15:47:22.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 15:47:22.000000','127.0.0.1','2026-05-19 15:47:22'),(52,'Gaurav Trivedi','2004-05-04',9,1,10,'868852251',2,'gaurav.trivedi29@example.com','980690','Aditya Trivedi','Meera Trivedi','727995752','aditya.trivedi@example.com','2026-05-19 20:46:28.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 20:46:28.000000','127.0.0.1','2026-05-19 20:46:28'),(53,'Shalini Pillai','2006-03-22',1,3,10,'983973685',1,'shalini.pillai76@example.com','549676','Vikram Pillai','Ananya Pillai','933179434','vikram.pillai@example.com','2026-05-19 14:49:51.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 14:49:51.000000','127.0.0.1','2026-05-19 14:49:51'),(54,'Sunil Pandey','2006-01-26',3,1,9,'798687245',1,'sunil.pandey34@example.com','154216','Arjun Pandey','Priti Pandey','978131243','arjun.pandey@example.com','2026-05-19 12:52:29.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 12:52:29.000000','127.0.0.1','2026-05-19 12:52:29'),(55,'Sneha Gupta','2005-06-17',3,3,9,'986703020',1,'sneha.gupta32@example.com','775202','Manish Gupta','Aarti Gupta','659583044','manish.gupta@example.com','2026-05-19 12:46:32.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 12:46:32.000000','127.0.0.1','2026-05-19 12:46:32'),(56,'Nisha Chatterjee','2002-06-13',3,1,9,'659280167',1,'nisha.chatterjee37@example.com','249663','Rohan Chatterjee','Sneha Chatterjee','759540535','rohan.chatterjee@example.com','2026-05-19 13:36:26.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 13:36:26.000000','127.0.0.1','2026-05-19 13:36:26'),(57,'Rahul Kumar','2007-02-09',2,1,10,'679273798',2,'rahul.kumar60@example.com','458080','Ishaan Kumar','Shreya Kumar','895720313','ishaan.kumar@example.com','2026-05-19 18:48:58.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 18:48:58.000000','127.0.0.1','2026-05-19 18:48:58'),(58,'Ritu Singh','2005-10-05',3,1,8,'940376185',2,'ritu.singh87@example.com','292823','Yash Singh','Nisha Singh','794194627','yash.singh@example.com','2026-05-19 10:11:28.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 10:11:28.000000','127.0.0.1','2026-05-19 10:11:28'),(59,'Riya Gill','2002-08-03',1,1,9,'641944232',1,'riya.gill62@example.com','413566','Vihaan Gill','Riya Gill','823842693','vihaan.gill@example.com','2026-05-19 14:42:39.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 14:42:39.000000','127.0.0.1','2026-05-19 14:42:39'),(60,'Sameer Sodhi','2006-05-04',9,2,10,'747423637',1,'sameer.sodhi14@example.com','491067','Arjun Sodhi','Deepika Sodhi','881408166','arjun.sodhi@example.com','2026-05-19 13:33:34.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 13:33:34.000000','127.0.0.1','2026-05-19 13:33:34'),(61,'Diya Dhillon','2005-10-20',1,2,8,'877853807',1,'diya.dhillon65@example.com','757796','Kabir Dhillon','Aarti Dhillon','938945576','kabir.dhillon@example.com','2026-05-19 19:21:49.000000','404 Lake View Road, Udaipur',NULL,'127.0.0.1','2026-05-19 19:21:49.000000','127.0.0.1','2026-05-19 19:21:49'),(62,'Komal Dutta','2003-01-16',9,1,10,'888200129',1,'komal.dutta62@example.com','611917','Amit Dutta','Aditi Dutta','898423936','amit.dutta@example.com','2026-05-19 12:19:19.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 12:19:19.000000','127.0.0.1','2026-05-19 12:19:19'),(63,'Ananya Das','2003-12-22',1,2,9,'812239482',2,'ananya.das99@example.com','860539','Rohan Das','Aditi Das','678421106','rohan.das@example.com','2026-05-19 12:10:58.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 12:10:58.000000','127.0.0.1','2026-05-19 12:10:58'),(64,'Priya Pillai','2002-11-10',9,3,9,'830418242',2,'priya.pillai30@example.com','213577','Siddharth Pillai','Sonia Pillai','926256079','siddharth.pillai@example.com','2026-05-19 11:14:34.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 11:14:34.000000','127.0.0.1','2026-05-19 11:14:34'),(65,'Riya Sharma','2004-01-17',2,1,8,'613176432',1,'riya.sharma40@example.com','108949','Anil Sharma','Nisha Sharma','819367423','anil.sharma@example.com','2026-05-19 16:35:55.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 16:35:55.000000','127.0.0.1','2026-05-19 16:35:55'),(66,'Saanvi Patel','2005-05-05',1,1,8,'627897514',2,'saanvi.patel51@example.com','352928','Ishaan Patel','Riya Patel','949958829','ishaan.patel@example.com','2026-05-19 15:26:15.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 15:26:15.000000','127.0.0.1','2026-05-19 15:26:15'),(67,'Rajesh Mehta','2005-12-10',2,2,8,'825149576',1,'rajesh.mehta35@example.com','799186','Anil Mehta','Shalini Mehta','664711034','anil.mehta@example.com','2026-05-19 19:25:15.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 19:25:15.000000','127.0.0.1','2026-05-19 19:25:15'),(68,'Ishaan Kumar','2004-12-17',1,3,10,'813059209',2,'ishaan.kumar52@example.com','276999','Rohan Kumar','Aanya Kumar','790650791','rohan.kumar@example.com','2026-05-19 10:52:58.000000','404 Lake View Road, Udaipur',NULL,'127.0.0.1','2026-05-19 10:52:58.000000','127.0.0.1','2026-05-19 10:52:58'),(69,'Divya Menon','2004-07-16',9,3,10,'840423223',1,'divya.menon27@example.com','881840','Kabir Menon','Priti Menon','870410128','kabir.menon@example.com','2026-05-19 16:57:30.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 16:57:30.000000','127.0.0.1','2026-05-19 16:57:30'),(70,'Varun Sharma','2003-09-10',1,1,10,'668187267',1,'varun.sharma88@example.com','508046','Vihaan Sharma','Riya Sharma','715665062','vihaan.sharma@example.com','2026-05-19 17:22:17.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 17:22:17.000000','127.0.0.1','2026-05-19 17:22:17'),(71,'Pooja Sodhi','2006-09-11',1,1,10,'673026424',1,'pooja.sodhi38@example.com','229284','Akash Sodhi','Ritu Sodhi','945263142','akash.sodhi@example.com','2026-05-19 14:49:50.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 14:49:50.000000','127.0.0.1','2026-05-19 14:49:50'),(72,'Sunil Iyer','2006-12-26',2,3,8,'898915787',2,'sunil.iyer79@example.com','223737','Vivaan Iyer','Priya Iyer','823744759','vivaan.iyer@example.com','2026-05-19 18:41:42.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 18:41:42.000000','127.0.0.1','2026-05-19 18:41:42'),(73,'Kabir Das','2005-07-19',1,1,9,'721626129',2,'kabir.das61@example.com','731411','Rajesh Das','Ananya Das','924436429','rajesh.das@example.com','2026-05-19 20:59:37.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 20:59:37.000000','127.0.0.1','2026-05-19 20:59:37'),(74,'Komal Malhotra','2005-03-16',2,1,9,'795765568',1,'komal.malhotra95@example.com','964971','Rajesh Malhotra','Nisha Malhotra','859753622','rajesh.malhotra@example.com','2026-05-19 12:26:17.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 12:26:17.000000','127.0.0.1','2026-05-19 12:26:17'),(75,'Komal Joshi','2006-08-11',3,2,10,'950075571',1,'komal.joshi50@example.com','350109','Vivaan Joshi','Meera Joshi','762457510','vivaan.joshi@example.com','2026-05-19 20:25:44.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 20:25:44.000000','127.0.0.1','2026-05-19 20:25:44'),(76,'Aarti Roy','2004-01-19',3,2,8,'756817773',2,'aarti.roy98@example.com','416476','Ishaan Roy','Ananya Roy','759687817','ishaan.roy@example.com','2026-05-19 14:54:12.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 14:54:12.000000','127.0.0.1','2026-05-19 14:54:12'),(77,'Kiran Mukherjee','2005-01-11',3,3,10,'641145416',2,'kiran.mukherjee31@example.com','296192','Varun Mukherjee','Komal Mukherjee','818970580','varun.mukherjee@example.com','2026-05-19 16:34:53.000000','404 Lake View Road, Udaipur',NULL,'127.0.0.1','2026-05-19 16:34:53.000000','127.0.0.1','2026-05-19 16:34:53'),(78,'Amit Saxena','2007-01-14',2,1,8,'934250272',1,'amit.saxena71@example.com','162176','Vihaan Saxena','Divya Saxena','892239754','vihaan.saxena@example.com','2026-05-19 14:59:42.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 14:59:42.000000','127.0.0.1','2026-05-19 14:59:42'),(79,'Amit Patel','2006-03-02',1,2,8,'779188937',1,'amit.patel36@example.com','666109','Karan Patel','Riya Patel','947721266','karan.patel@example.com','2026-05-19 20:40:18.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 20:40:18.000000','127.0.0.1','2026-05-19 20:40:18'),(80,'Sanjay Mukherjee','2005-02-22',1,3,8,'680827069',1,'sanjay.mukherjee64@example.com','243095','Vijay Mukherjee','Saanvi Mukherjee','920958857','vijay.mukherjee@example.com','2026-05-19 15:21:29.000000','909 High Street, Pune',NULL,'127.0.0.1','2026-05-19 15:21:29.000000','127.0.0.1','2026-05-19 15:21:29'),(81,'Sunil Sen','2003-08-25',9,1,9,'828402300',2,'sunil.sen21@example.com','797790','Varun Sen','Neha Sen','944911600','varun.sen@example.com','2026-05-19 11:19:17.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 11:19:17.000000','127.0.0.1','2026-05-19 11:19:17'),(82,'Akash Sen','2003-12-09',3,1,10,'745405596',2,'akash.sen99@example.com','947713','Karan Sen','Kiran Sen','776968565','karan.sen@example.com','2026-05-19 18:28:30.000000','707 Canal Road, Kanpur',NULL,'127.0.0.1','2026-05-19 18:28:30.000000','127.0.0.1','2026-05-19 18:28:30'),(83,'Pooja Sharma','2004-09-06',2,2,8,'790459188',2,'pooja.sharma64@example.com','800114','Vihaan Sharma','Kriti Sharma','884841818','vihaan.sharma@example.com','2026-05-19 18:12:30.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 18:12:30.000000','127.0.0.1','2026-05-19 18:12:30'),(84,'Gaurav Trivedi','2003-12-01',9,1,10,'840056631',1,'gaurav.trivedi73@example.com','249454','Rohan Trivedi','Priya Trivedi','729021784','rohan.trivedi@example.com','2026-05-19 14:58:48.000000','789 Residency Road, Bangalore',NULL,'127.0.0.1','2026-05-19 14:58:48.000000','127.0.0.1','2026-05-19 14:58:48'),(85,'Aarti Patel','2005-02-04',1,1,10,'955198543',1,'aarti.patel44@example.com','775390','Karan Patel','Tanvi Patel','739275687','karan.patel@example.com','2026-05-19 19:28:26.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 19:28:26.000000','127.0.0.1','2026-05-19 19:28:26'),(86,'Diya Dhillon','2005-08-26',9,2,10,'820915275',2,'diya.dhillon57@example.com','855842','Rahul Dhillon','Aanya Dhillon','632019518','rahul.dhillon@example.com','2026-05-19 18:20:54.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 18:20:54.000000','127.0.0.1','2026-05-19 18:20:54'),(87,'Vihaan Pandey','2004-11-27',3,1,10,'871814061',2,'vihaan.pandey21@example.com','614783','Rajesh Pandey','Aarti Pandey','989540802','rajesh.pandey@example.com','2026-05-19 17:30:37.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 17:30:37.000000','127.0.0.1','2026-05-19 17:30:37'),(88,'Siddharth Verma','2004-03-18',9,1,10,'733240897',1,'siddharth.verma43@example.com','761650','Yash Verma','Pooja Verma','966658604','yash.verma@example.com','2026-05-19 20:46:14.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 20:46:14.000000','127.0.0.1','2026-05-19 20:46:14'),(89,'Sameer Joshi','2004-05-05',1,1,9,'868241696',1,'sameer.joshi95@example.com','879976','Manish Joshi','Riya Joshi','684824132','manish.joshi@example.com','2026-05-19 16:52:42.000000','404 Lake View Road, Udaipur',NULL,'127.0.0.1','2026-05-19 16:52:42.000000','127.0.0.1','2026-05-19 16:52:42'),(90,'Varun Chatterjee','2004-10-13',9,2,10,'614592265',1,'varun.chatterjee29@example.com','994572','Vivaan Chatterjee','Pooja Chatterjee','766925751','vivaan.chatterjee@example.com','2026-05-19 20:19:22.000000','456 Park Street, Kolkata',NULL,'127.0.0.1','2026-05-19 20:19:22.000000','127.0.0.1','2026-05-19 20:19:22'),(91,'Riya Mehta','2002-09-14',9,3,9,'811961916',2,'riya.mehta47@example.com','125612','Karan Mehta','Meera Mehta','773632957','karan.mehta@example.com','2026-05-19 11:32:54.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 11:32:54.000000','127.0.0.1','2026-05-19 11:32:54'),(92,'Aanya Singh','2003-11-26',9,3,10,'972118520',1,'aanya.singh83@example.com','262030','Akash Singh','Saanvi Singh','923470338','akash.singh@example.com','2026-05-19 10:38:20.000000','404 Lake View Road, Udaipur',NULL,'127.0.0.1','2026-05-19 10:38:20.000000','127.0.0.1','2026-05-19 10:38:20'),(93,'Amit Saxena','2004-02-04',1,1,8,'789639359',1,'amit.saxena27@example.com','840492','Rajesh Saxena','Diya Saxena','746623574','rajesh.saxena@example.com','2026-05-19 17:50:45.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 17:50:45.000000','127.0.0.1','2026-05-19 17:50:45'),(94,'Aditya Sen','2007-05-15',3,1,10,'666252392',1,'aditya.sen66@example.com','170234','Siddharth Sen','Sonia Sen','853302683','siddharth.sen@example.com','2026-05-19 11:43:57.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 11:43:57.000000','127.0.0.1','2026-05-19 11:43:57'),(95,'Nisha Saxena','2003-11-07',2,2,8,'929756847',2,'nisha.saxena15@example.com','802150','Gaurav Saxena','Meera Saxena','796927330','gaurav.saxena@example.com','2026-05-19 14:47:52.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 14:47:52.000000','127.0.0.1','2026-05-19 14:47:52'),(96,'Kriti Menon','2007-03-24',3,3,10,'789435230',2,'kriti.menon59@example.com','192962','Vikram Menon','Shreya Menon','788478612','vikram.menon@example.com','2026-05-19 14:32:55.000000','909 High Street, Pune',NULL,'127.0.0.1','2026-05-19 14:32:55.000000','127.0.0.1','2026-05-19 14:32:55'),(97,'Kabir Dutta','2002-07-28',3,3,8,'666657883',2,'kabir.dutta21@example.com','789344','Rahul Dutta','Ananya Dutta','682179394','rahul.dutta@example.com','2026-05-19 19:22:31.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 19:22:31.000000','127.0.0.1','2026-05-19 19:22:31'),(98,'Siddharth Choudhary','2005-11-22',1,3,9,'726502027',2,'siddharth.choudhary46@example.com','629736','Gaurav Choudhary','Nisha Choudhary','672138952','gaurav.choudhary@example.com','2026-05-19 17:52:11.000000','123 MG Road, Mumbai',NULL,'127.0.0.1','2026-05-19 17:52:11.000000','127.0.0.1','2026-05-19 17:52:11'),(99,'Saanvi Shetty','2002-11-22',3,2,9,'983382718',1,'saanvi.shetty50@example.com','614623','Manish Shetty','Tanvi Shetty','696433047','manish.shetty@example.com','2026-05-19 13:30:45.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 13:30:45.000000','127.0.0.1','2026-05-19 13:30:45'),(100,'Sanjay Kumar','2003-04-12',9,1,10,'772348474',2,'sanjay.kumar62@example.com','717522','Manish Kumar','Nisha Kumar','849933942','manish.kumar@example.com','2026-05-19 19:51:29.000000','606 Beach Road, Goa',NULL,'127.0.0.1','2026-05-19 19:51:29.000000','127.0.0.1','2026-05-19 19:51:29'),(101,'Priya Mehra','2005-05-23',1,1,9,'696900199',2,'priya.mehra77@example.com','980073','Rajesh Mehra','Saanvi Mehra','764268771','rajesh.mehra@example.com','2026-05-19 13:31:40.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 13:31:40.000000','127.0.0.1','2026-05-19 13:31:40'),(102,'Priti Malhotra','2002-11-25',1,3,8,'770755828',2,'priti.malhotra64@example.com','430658','Aditya Malhotra','Ritu Malhotra','772674199','aditya.malhotra@example.com','2026-05-19 12:35:13.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 12:35:13.000000','127.0.0.1','2026-05-19 12:35:13'),(103,'Gaurav Shah','2004-06-17',2,3,10,'918188864',1,'gaurav.shah61@example.com','261006','Sanjay Shah','Priti Shah','782826462','sanjay.shah@example.com','2026-05-19 20:18:32.000000','202 Station Road, Chennai',NULL,'127.0.0.1','2026-05-19 20:18:32.000000','127.0.0.1','2026-05-19 20:18:32'),(104,'Vikram Dutta','2002-06-27',2,1,9,'620075546',2,'vikram.dutta46@example.com','873236','Akash Dutta','Nisha Dutta','829369208','akash.dutta@example.com','2026-05-19 10:53:41.000000','808 Ring Road, Ahmedabad',NULL,'127.0.0.1','2026-05-19 10:53:41.000000','127.0.0.1','2026-05-19 10:53:41'),(105,'Pooja Sodhi','2006-03-04',2,3,8,'882332602',1,'pooja.sodhi36@example.com','532973','Ishaan Sodhi','Ritu Sodhi','892591639','ishaan.sodhi@example.com','2026-05-19 16:10:51.000000','303 Palace Road, Jaipur',NULL,'127.0.0.1','2026-05-19 16:10:51.000000','127.0.0.1','2026-05-19 16:10:51'),(106,'Meera Singh','2007-09-01',1,1,9,'620593165',2,'meera.singh11@example.com','836960','Vivaan Singh','Shreya Singh','765934018','vivaan.singh@example.com','2026-05-19 10:37:43.000000','505 Mall Road, Shimla',NULL,'127.0.0.1','2026-05-19 10:37:43.000000','127.0.0.1','2026-05-19 10:37:43'),(107,'Aditya Khanna','2007-02-05',9,3,9,'733126525',2,'aditya.khanna45@example.com','815470','Aditya Khanna','Kiran Khanna','777513804','aditya.khanna@example.com','2026-05-19 14:46:27.000000','101 Link Road, Delhi',NULL,'127.0.0.1','2026-05-19 14:46:27.000000','127.0.0.1','2026-05-19 14:46:27');
/*!40000 ALTER TABLE `tblstudent` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudentcourseprogress`
--

LOCK TABLES `tblstudentcourseprogress` WRITE;
/*!40000 ALTER TABLE `tblstudentcourseprogress` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblstudentcourseprogress` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsubject`
--

LOCK TABLES `tblsubject` WRITE;
/*!40000 ALTER TABLE `tblsubject` DISABLE KEYS */;
INSERT INTO `tblsubject` VALUES (1,'DSA',3,1,9,1,'::1','2026-01-22 08:20:27','::1','2026-01-22 08:20:27'),(2,'SE',3,1,8,1,'183.83.53.10','2025-03-05 08:38:30','183.83.53.10','2025-03-05 08:38:30'),(3,'DE',3,1,8,1,'182.68.130.194','2025-03-05 01:46:07','182.68.130.194','2025-03-05 01:46:07'),(4,'BST',1,1,8,1,'182.68.130.194','2025-03-05 02:25:20','182.68.130.194','2025-03-05 02:25:20'),(5,'Econimics',1,2,8,1,'122.181.92.233','2025-03-08 12:11:19','122.181.92.233','2025-03-08 12:11:19'),(6,'Python',3,2,8,1,'183.83.53.189','2025-03-11 08:34:13','183.83.53.189','2025-03-11 08:34:13'),(7,'MP',3,2,8,1,'183.83.53.189','2025-03-11 08:34:25','183.83.53.189','2025-03-11 08:34:25'),(8,'ML',3,1,8,1,'182.68.79.23','2025-03-15 02:12:49','182.68.79.23','2025-03-15 02:12:49'),(9,'TC',3,1,8,1,'182.68.79.23','2025-03-15 02:13:07','182.68.79.23','2025-03-15 02:13:07'),(10,'English',3,1,8,1,'182.68.79.23','2025-03-15 02:13:34','182.68.79.23','2025-03-15 02:13:34'),(11,'DBMS',2,1,8,1,'183.83.52.52','2025-04-01 08:26:18','183.83.52.52','2025-04-01 08:26:18'),(12,'DBMS',3,2,9,1,'183.83.54.121','2025-06-28 10:22:51','183.83.54.121','2025-06-28 10:22:51'),(13,'ITC',3,1,9,1,'117.99.165.227','2025-09-24 10:18:38','117.99.165.227','2025-09-24 10:18:38'),(14,'AOA',3,2,9,1,'117.99.165.227','2025-09-25 04:36:32','117.99.165.227','2025-09-25 04:36:32');
/*!40000 ALTER TABLE `tblsubject` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblteacher`
--

LOCK TABLES `tblteacher` WRITE;
/*!40000 ALTER TABLE `tblteacher` DISABLE KEYS */;
INSERT INTO `tblteacher` VALUES (4,'himanshu','himanshu@gmail.com','6375324604',1,'1123',1,'2025-09-26','182.68.187.223','2025-09-26 00:13:55','182.68.187.223','2025-09-26 00:13:55'),(5,'shubhra','shubhra@gmail.com','9786567465',2,'1321',5,'2025-09-26','182.68.187.223','2025-09-26 00:17:50','182.68.187.223','2025-09-26 00:17:50'),(6,'teju','teju@gmail.com','9327950361',1,'12324',6,'2025-09-28','103.54.14.83','2025-09-28 00:04:32','103.54.14.83','2025-09-28 00:04:32');
/*!40000 ALTER TABLE `tblteacher` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltest`
--

LOCK TABLES `tbltest` WRITE;
/*!40000 ALTER TABLE `tbltest` DISABLE KEYS */;
INSERT INTO `tbltest` VALUES (1,1,40,3,1,1,'2025-09-29',9,1,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(2,1,40,3,1,2,'2025-10-07',9,1,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(3,1,40,3,1,3,'2025-10-09',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(4,1,40,3,1,8,'2025-10-11',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(5,1,40,3,1,9,'2025-10-13',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(6,1,40,3,1,10,'2025-10-15',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(7,1,40,3,1,13,'2025-10-17',9,0,'::1','2025-09-30 11:29:49','::1','2025-09-30 11:29:49'),(8,1,40,1,2,5,'2025-11-06',9,0,'::1','2025-11-07 10:12:50','::1','2025-11-07 10:12:50'),(9,1,40,1,2,5,'2025-11-06',9,0,'::1','2025-11-07 10:14:18','::1','2025-11-07 10:14:18'),(10,1,40,3,2,6,'2025-11-06',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54'),(11,1,40,3,2,7,'2025-11-09',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54'),(12,1,40,3,2,12,'2025-11-11',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54'),(13,1,40,3,2,14,'2025-11-13',9,0,'::1','2025-11-07 10:15:54','::1','2025-11-07 10:15:54');
/*!40000 ALTER TABLE `tbltest` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltestdetail`
--

LOCK TABLES `tbltestdetail` WRITE;
/*!40000 ALTER TABLE `tbltestdetail` DISABLE KEYS */;
INSERT INTO `tbltestdetail` VALUES (1,'MTT 1',40,'::1','2025-09-30 11:27:12','::1','2025-09-30 11:27:12');
/*!40000 ALTER TABLE `tbltestdetail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-17  2:33:53

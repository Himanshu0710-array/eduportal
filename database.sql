CREATE DATABASE IF NOT EXISTS `himanshu_4604`;
USE `himanshu_4604`;

CREATE TABLE IF NOT EXISTS `tblcourse` (
  `courseId` int(11) NOT NULL AUTO_INCREMENT,
  `courseName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`courseId`)
);

CREATE TABLE IF NOT EXISTS `tblsession` (
  `sessionId` int(11) NOT NULL AUTO_INCREMENT,
  `sessionName` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`sessionId`)
);

CREATE TABLE IF NOT EXISTS `tblacademicyear` (
  `academicYearId` int(11) NOT NULL AUTO_INCREMENT,
  `academicYearName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`academicYearId`)
);

CREATE TABLE IF NOT EXISTS `tblstudent` (
  `studentId` int(11) NOT NULL AUTO_INCREMENT,
  `studentName` varchar(255) DEFAULT NULL,
  `studentEmail` varchar(255) DEFAULT NULL,
  `studentPassword` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `courseId` int(11) DEFAULT NULL,
  `academicYearId` int(11) DEFAULT NULL,
  `sessionId` int(11) DEFAULT NULL,
  `studentNumber` varchar(20) DEFAULT NULL,
  `studentGender` int(11) DEFAULT NULL,
  `fatherName` varchar(255) DEFAULT NULL,
  `motherName` varchar(255) DEFAULT NULL,
  `parentNumber` varchar(20) DEFAULT NULL,
  `parentEmail` varchar(255) DEFAULT NULL,
  `dateOfRegistration` date DEFAULT NULL,
  `address` text,
  `studentImage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`studentId`)
);

CREATE TABLE IF NOT EXISTS `tbladmin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `adminName` varchar(255) DEFAULT NULL,
  `adminEmail` varchar(255) DEFAULT NULL,
  `adminPassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`adminId`)
);

CREATE TABLE IF NOT EXISTS `tblteacher` (
  `teacherId` int(11) NOT NULL AUTO_INCREMENT,
  `teacherName` varchar(255) DEFAULT NULL,
  `teacherEmail` varchar(255) DEFAULT NULL,
  `teacherPassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`teacherId`)
);

INSERT IGNORE INTO `tblcourse` (`courseId`, `courseName`) VALUES (1, 'B.Tech Computer Science'), (2, 'BCA');
INSERT IGNORE INTO `tblsession` (`sessionId`, `sessionName`, `status`) VALUES (1, '2025-2026', 1);
INSERT IGNORE INTO `tblacademicyear` (`academicYearId`, `academicYearName`) VALUES (1, 'First Year');
INSERT IGNORE INTO `tblstudent` (`studentId`, `studentName`, `studentEmail`, `studentPassword`, `courseId`, `academicYearId`, `sessionId`) VALUES (1, 'Dummy Student', 'student@test.com', '123456', 1, 1, 1);
INSERT IGNORE INTO `tbladmin` (`adminId`, `adminName`, `adminEmail`, `adminPassword`) VALUES (1, 'Admin', 'admin@test.com', 'admin123');
INSERT IGNORE INTO `tblteacher` (`teacherId`, `teacherName`, `teacherEmail`, `teacherPassword`) VALUES (1, 'Teacher', 'teacher@test.com', 'teacher123');

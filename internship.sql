
-- *** NOTES ***
-- -----------------------------------------------------------
-- USER SECURITY QUESTION
  -- What is the name of your first pet?
  -- In what city were you born?
  -- What is your favorite movie?
  -- What is your mother's maiden name?
  -- What was the name of your first school?

-- report change to url varchar100
-- all status pending/ reject/ accept / missing
-- qualification: diploma / degree
-- internshipStatus: active/ terminate/ complete 
-- all grade INT based: int


---------------------------------------------------------------

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2023 at 08:25 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internship`
--

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `internshipID` varchar(10) NOT NULL,
  `studID` varchar(10) DEFAULT NULL,
  `sessionID` varchar(10) DEFAULT NULL,
  `indemnity` varchar(100) DEFAULT NULL,
  `indemnityStatus` enum('Accepted','Rejected','Pending','Missing') DEFAULT NULL,
  `parentAcknowledgement` varchar(100) DEFAULT NULL,
  `parentAcknowledgementStatus` enum('Accepted','Rejected','Pending','Missing') DEFAULT NULL,
  `companyAcceptance` varchar(100) DEFAULT NULL,
  `companyAcceptanceStatus` enum('Accepted','Rejected','Pending','Missing') DEFAULT NULL,
  `monthlyReport1` varchar(100) DEFAULT NULL,
  `monthlyReport1Grade` int(11) DEFAULT NULL,
  `monthlyReport2` varchar(100) DEFAULT NULL,
  `monthlyReport2Grade` int(11) DEFAULT NULL,
  `monthlyReport3` varchar(100) DEFAULT NULL,
  `monthlyReport3Grade` int(11) DEFAULT NULL,
  `evaluationReport` varchar(100) DEFAULT NULL,
  `evaluationReportGrade` int(11) DEFAULT NULL,
  `finalGrade` int(11) DEFAULT NULL,
  `internshipStatus` enum('In Progress','Completed','Suspended','Terminated') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`internshipID`, `studID`, `sessionID`, `indemnity`, `indemnityStatus`, `parentAcknowledgement`, `parentAcknowledgementStatus`, `companyAcceptance`, `companyAcceptanceStatus`, `monthlyReport1`, `monthlyReport1Grade`, `monthlyReport2`, `monthlyReport2Grade`, `monthlyReport3`, `monthlyReport3Grade`, `evaluationReport`, `evaluationReportGrade`, `finalGrade`, `internshipStatus`) VALUES
('I2308001', '2205950', '202308', 'Sample indemnity text', 'Pending', 'Sample parent ack text', 'Pending', 'Sample company ack text', 'Pending', 'Sample report 1 text', 95, 'Sample report 2 text', 88, 'Sample report 3 text', 92, 'Sample eval report text', 90, 94, 'Completed'),
('I2308002', '2205951', '202308', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `sessionID` varchar(10) NOT NULL,
  `startMonthYear` date DEFAULT NULL,
  `endMonthYear` date DEFAULT NULL,
  `qualification` enum('Diploma','Degree') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`sessionID`, `startMonthYear`, `endMonthYear`, `qualification`) VALUES
('202308', '2023-09-01', '2023-12-31', 'Degree');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(10) NOT NULL,
  `staffName` varchar(50) DEFAULT NULL,
  `staffEmail` varchar(50) DEFAULT NULL,
  `staffIC` varchar(12) DEFAULT NULL,
  `staffGender` enum('Male','Female','Other') DEFAULT NULL,
  `staffPhoneNo` varchar(15) DEFAULT NULL,
  `staffPassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffName`, `staffEmail`, `staffIC`, `staffGender`, `staffPhoneNo`, `staffPassword`) VALUES
('ST0001', 'Jane Smith', 'jane.smith@example.com', '010120070669', 'Female', '0104012866', 'ef92b778bafe771e89245b89ecbc08a44a4e166c0665991188');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studID` varchar(10) NOT NULL,
  `studName` varchar(50) DEFAULT NULL,
  `studEmail` varchar(50) DEFAULT NULL,
  `studIC` varchar(12) DEFAULT NULL,
  `studGender` enum('Male','Female','Other') DEFAULT NULL,
  `studPhoneNo` varchar(15) DEFAULT NULL,
  `studPassword` varchar(50) DEFAULT NULL,
  `studQualification` enum('Diploma','Degree') DEFAULT NULL,
  `studSecurityQuestion` varchar(100) NOT NULL,
  `studSecurityAnswer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studID`, `studName`, `studEmail`, `studIC`, `studGender`, `studPhoneNo`, `studPassword`, `studQualification`, `studSecurityQuestion`, `studSecurityAnswer`) VALUES
('2205950', 'John Doe', 'john.doe@example.com', '010120070666', 'Male', '0174012866', 'ef92b778bafe771e89245b89ecbc08a44a4e166c0665991188', 'Degree', 'What is the name of your first pet?', 'Cat\r\n'),
('2205951', 'Vincent Choo', 'vincentchoo88@gmail.com', '111111223333', 'Male', '0174012863', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a', 'Diploma', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE `supervisor` (
  `sessionID` varchar(10) NOT NULL,
  `staffID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`sessionID`, `staffID`) VALUES
('202308', 'ST0001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`internshipID`),
  ADD KEY `studID` (`studID`),
  ADD KEY `sessionID` (`sessionID`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sessionID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studID`);

--
-- Indexes for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD PRIMARY KEY (`sessionID`,`staffID`),
  ADD KEY `staffID` (`staffID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `student` (`studID`),
  ADD CONSTRAINT `internship_ibfk_2` FOREIGN KEY (`sessionID`) REFERENCES `session` (`sessionID`);

--
-- Constraints for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD CONSTRAINT `supervisor_ibfk_1` FOREIGN KEY (`sessionID`) REFERENCES `session` (`sessionID`),
  ADD CONSTRAINT `supervisor_ibfk_2` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

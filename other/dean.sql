-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2023 at 06:27 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dean`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `employee_id` int(11) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `course_entry` tinyint(1) NOT NULL DEFAULT 0,
  `course_entered` tinyint(1) NOT NULL DEFAULT 0,
  `grade_entry` tinyint(1) NOT NULL DEFAULT 0,
  `grade_entered` tinyint(1) NOT NULL DEFAULT 0,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`employee_id`, `password_hash`, `course_entry`, `course_entered`, `grade_entry`, `grade_entered`, `semester`) VALUES
(1116, '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 0, 0, 0, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `stream` varchar(255) NOT NULL,
  `course_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_name`, `semester`, `credits`, `branch`, `stream`, `course_type`) VALUES
('CS13101', 'Data Structures', 3, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS13201', 'Object Oriented Programming', 3, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15101', 'Microprocessor and its Application', 5, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS15102', 'Operating Systems', 5, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15103', 'Database Management System', 5, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15104', 'Object Oriented Modeling', 5, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15105', 'Operation Research', 5, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS15106', 'Computer Architecture', 5, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS15201', 'Systems Calls Lab', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15202', 'Microprocessor', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15203', 'Operating Systems', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15204', 'Database System', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS16101', 'Embedded Systems', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16102', 'Compiler Construction', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16103', 'Data Mining', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16104', 'Cryptography & Network Security', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16105', 'Computer Networks', 6, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS16106', 'Software Engineering', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS21101', 'Data Science: Concepts and Methodologies', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'theory'),
('CS21201', 'Programming Lab - 1', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'practical'),
('CS21202', 'Programming Lab - 2', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'practical'),
('CS22201', 'Machine Learning', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'theory');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `course_code` varchar(255) NOT NULL,
  `student_registration_number` varchar(255) NOT NULL,
  `mid_semester_exam` int(11) NOT NULL DEFAULT 0,
  `end_semester_exam` int(11) NOT NULL DEFAULT 0,
  `teacher_assessment` int(11) NOT NULL DEFAULT 0,
  `points` int(11) NOT NULL DEFAULT 0,
  `semester` int(11) NOT NULL DEFAULT 0,
  `d_year` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `marks_distribution`
--

CREATE TABLE `marks_distribution` (
  `course_code` varchar(255) NOT NULL,
  `mid_semester_exam` int(11) NOT NULL,
  `end_semester_exam` int(11) NOT NULL,
  `teacher_assessment` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `dist_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_of_join` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`employee_id`, `first_name`, `last_name`, `phone_number`, `email`, `password_hash`, `date_of_join`) VALUES
(1111, 'Dr. Ranvijay', 'Singh', '1234567890', 'ranvijay@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1112, 'Lt. (Dr.) Divya', 'Kumar', '1234567890', 'divya@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1113, 'Dr. Mayank', 'Pandey', '1234567890', 'mayank@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1114, 'Prof. Neeraj', 'Tyagi', '1234567890', 'neeraj@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1115, 'Dr. Dinesh', 'Singh', '1234567890', 'dinesh@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1116, 'Dr. Dushyant', 'Kumar Singh', '1234567890', 'dushyant@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1117, 'Dr. Shashwati', 'Banerjea', '1234567890', 'shashwati@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1118, 'Dr. Srasij', 'Tripathi', '1234567890', 'sarsij@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `professor_allotment`
--

CREATE TABLE `professor_allotment` (
  `employee_id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `d_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `semester_marks`
--

CREATE TABLE `semester_marks` (
  `student_registration_number` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `d_year` int(11) NOT NULL,
  `spi` float NOT NULL DEFAULT 0,
  `cpi` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `registration_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `stream` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`registration_number`, `first_name`, `last_name`, `email`, `password_hash`, `stream`, `branch`, `semester`) VALUES
('2018MT11', 'Ankur', 'last_name', 'saurabh@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'M.Tech', 'Computer Science and Engineering', 5),
('2018PR01', 'Saurabh', 'last_name', 'saurabh@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'M.Tech', 'Computer Science and Engineering', 5),
('20204022', 'Amit', 'Kumar', 'amit.20204022@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204085', 'Hitesh', 'Mitruka', 'hitesh.20204085@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204120', 'Naman', 'Aggrawal', 'naman.20204120@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204156', 'Priyav', 'Kaneria', 'priyav.20204156@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204176', 'Sanskar', 'Omar', 'sanskar.20204176@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204184', 'Shashank', 'Verma', 'shashank.20204184@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`,`semester`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`course_code`,`student_registration_number`,`semester`,`d_year`),
  ADD KEY `student_registration_number` (`student_registration_number`);

--
-- Indexes for table `marks_distribution`
--
ALTER TABLE `marks_distribution`
  ADD PRIMARY KEY (`course_code`,`semester`,`dist_year`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `professor_allotment`
--
ALTER TABLE `professor_allotment`
  ADD PRIMARY KEY (`employee_id`,`course_code`,`semester`,`d_year`),
  ADD KEY `course_code` (`course_code`);

--
-- Indexes for table `semester_marks`
--
ALTER TABLE `semester_marks`
  ADD PRIMARY KEY (`student_registration_number`,`semester`,`d_year`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`registration_number`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `professor` (`employee_id`);

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`student_registration_number`) REFERENCES `student` (`registration_number`);

--
-- Constraints for table `marks_distribution`
--
ALTER TABLE `marks_distribution`
  ADD CONSTRAINT `marks_distribution_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`);

--
-- Constraints for table `professor_allotment`
--
ALTER TABLE `professor_allotment`
  ADD CONSTRAINT `professor_allotment_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `professor` (`employee_id`),
  ADD CONSTRAINT `professor_allotment_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`);

--
-- Constraints for table `semester_marks`
--
ALTER TABLE `semester_marks`
  ADD CONSTRAINT `semester_marks_ibfk_1` FOREIGN KEY (`student_registration_number`) REFERENCES `student` (`registration_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

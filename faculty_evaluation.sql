-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 07:38 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_evaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(25) NOT NULL,
  `section` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `faculty_f_id` int(11) NOT NULL,
  `department_d_id` int(11) NOT NULL,
  `semester_s_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`c_id`, `c_name`, `section`, `date`, `faculty_f_id`, `department_d_id`, `semester_s_id`) VALUES
(5, 'CSE301', 1, '2021-12-10', 2, 1, 1),
(6, 'CSE301', 2, '2021-12-10', 2, 1, 1),
(7, 'ENG101', 1, '2021-12-10', 1, 3, 1),
(9, 'GEB101', 1, '2021-12-20', 5, 4, 1),
(12, 'ACT101', 1, '2021-12-26', 6, 5, 1),
(13, 'ACT101', 2, '2021-12-26', 6, 5, 1),
(14, 'EEE101', 1, '2021-12-27', 3, 2, 1),
(15, 'CSE464', 1, '2021-12-30', 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `coursetaken`
--

CREATE TABLE `coursetaken` (
  `id` int(11) NOT NULL,
  `course_c_id` int(11) NOT NULL,
  `user_u_id` int(11) NOT NULL,
  `adv_status` varchar(5) NOT NULL DEFAULT 'False'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coursetaken`
--

INSERT INTO `coursetaken` (`id`, `course_c_id`, `user_u_id`, `adv_status`) VALUES
(9, 5, 1, 'True'),
(10, 6, 1, 'True'),
(11, 7, 6, 'True'),
(12, 9, 7, 'False'),
(13, 12, 8, 'True'),
(14, 14, 3, 'False'),
(15, 15, 9, 'True');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `cr_id` int(11) NOT NULL,
  `val_criteria` int(11) NOT NULL,
  `criteria_status` varchar(5) NOT NULL DEFAULT 'False'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`cr_id`, `val_criteria`, `criteria_status`) VALUES
(1, 1, 'True'),
(2, 2, 'False'),
(3, 3, 'False'),
(4, 4, 'False'),
(5, 5, 'False'),
(6, 6, 'False'),
(7, 7, 'False'),
(8, 8, 'False'),
(12, 9, 'False'),
(13, 10, 'False');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `d_id` int(11) NOT NULL,
  `d_name` varchar(25) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_id`, `d_name`, `date`) VALUES
(1, 'CSE', '2021-12-10'),
(2, 'EEE', '2021-12-10'),
(3, 'ENG', '2021-12-10'),
(4, 'GEB', '2021-12-21'),
(5, 'BA', '2021-12-26');

-- --------------------------------------------------------

--
-- Table structure for table `departmenttaken`
--

CREATE TABLE `departmenttaken` (
  `dt_id` int(11) NOT NULL,
  `department_d_id` int(11) NOT NULL,
  `user_u_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departmenttaken`
--

INSERT INTO `departmenttaken` (`dt_id`, `department_d_id`, `user_u_id`, `date`) VALUES
(1, 1, 1, '2021-12-26'),
(3, 2, 3, '2021-12-26'),
(4, 3, 6, '2021-12-26'),
(6, 4, 7, '2021-12-26'),
(7, 5, 8, '2021-12-26'),
(8, 1, 9, '2021-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) NOT NULL,
  `course_c_id` int(11) NOT NULL,
  `user_u_id` int(11) NOT NULL,
  `question_q_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id`, `date`, `rating`, `course_c_id`, `user_u_id`, `question_q_id`) VALUES
(1, '2021-12-27', 5, 5, 1, 1),
(2, '2021-12-27', 4, 5, 1, 2),
(3, '2021-12-27', 4, 5, 1, 4),
(4, '2021-12-27', 2, 5, 1, 5),
(5, '2021-12-27', 5, 5, 1, 6),
(6, '2021-12-27', 1, 5, 1, 7),
(7, '2021-12-27', 4, 5, 1, 8),
(8, '2021-12-27', 3, 5, 1, 9),
(9, '2021-12-27', 4, 5, 1, 10),
(10, '2021-12-27', 3, 5, 1, 11),
(11, '2021-12-27', 4, 6, 1, 1),
(12, '2021-12-27', 5, 6, 1, 2),
(13, '2021-12-27', 4, 6, 1, 4),
(14, '2021-12-27', 1, 6, 1, 5),
(15, '2021-12-27', 5, 6, 1, 6),
(16, '2021-12-27', 3, 6, 1, 7),
(17, '2021-12-27', 2, 6, 1, 8),
(18, '2021-12-27', 1, 6, 1, 9),
(19, '2021-12-27', 4, 6, 1, 10),
(20, '2021-12-27', 5, 6, 1, 11),
(21, '2021-12-27', 5, 12, 8, 1),
(22, '2021-12-27', 4, 12, 8, 2),
(23, '2021-12-27', 2, 12, 8, 4),
(24, '2021-12-27', 4, 12, 8, 5),
(25, '2021-12-27', 1, 12, 8, 6),
(26, '2021-12-27', 3, 12, 8, 7),
(27, '2021-12-27', 4, 12, 8, 8),
(28, '2021-12-27', 5, 12, 8, 9),
(29, '2021-12-27', 2, 12, 8, 10),
(30, '2021-12-27', 1, 12, 8, 11),
(31, '2021-12-30', 5, 15, 9, 1),
(32, '2021-12-30', 4, 15, 9, 2),
(33, '2021-12-30', 5, 15, 9, 4),
(34, '2021-12-30', 2, 15, 9, 5),
(35, '2021-12-30', 4, 15, 9, 6),
(36, '2021-12-30', 5, 15, 9, 7),
(37, '2021-12-30', 3, 15, 9, 8),
(38, '2021-12-30', 1, 15, 9, 9),
(39, '2021-12-30', 4, 15, 9, 10),
(40, '2021-12-30', 4, 15, 9, 11),
(41, '2022-01-12', 5, 7, 6, 1),
(42, '2022-01-12', 2, 7, 6, 2),
(43, '2022-01-12', 4, 7, 6, 4),
(44, '2022-01-12', 1, 7, 6, 5),
(45, '2022-01-12', 3, 7, 6, 6),
(46, '2022-01-12', 4, 7, 6, 7),
(47, '2022-01-12', 1, 7, 6, 8),
(48, '2022-01-12', 5, 7, 6, 9),
(49, '2022-01-12', 2, 7, 6, 10),
(50, '2022-01-12', 4, 7, 6, 11);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `f_id` int(11) NOT NULL,
  `f_name` varchar(25) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `department_d_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`f_id`, `f_name`, `date`, `department_d_id`) VALUES
(1, 'AJA', '2021-12-10', 3),
(2, 'THJ', '2021-12-10', 1),
(3, 'FJM', '2021-12-10', 2),
(5, 'ABS', '2021-12-26', 4),
(6, 'SI', '2021-12-26', 5);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_u_id` int(11) NOT NULL,
  `faculty_f_id` int(11) NOT NULL,
  `course_c_id` int(11) NOT NULL,
  `course_feedback` varchar(200) NOT NULL,
  `faculty_feedback` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_u_id`, `faculty_f_id`, `course_c_id`, `course_feedback`, `faculty_feedback`) VALUES
(1, 1, 2, 5, 'The course was Interesting.', 'Nice Faculty.'),
(2, 1, 2, 6, 'Amazing Course.', 'Brilliant Faculty..'),
(3, 8, 6, 12, 'Learned a lot of things.', 'Honest Faculty.'),
(4, 9, 2, 15, 'Not Bad', 'Nice Faculty.'),
(5, 6, 1, 7, 'it seems me interesting', 'awesome Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `page` varchar(255) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `email`, `page`, `page_id`, `number`) VALUES
(4, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewCourse.php', '71ad8762c310ca11cf3eb22d1730482b', '5'),
(5, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewStudent.php', 'c386ed976c99a527d63ed90540efd2be', '6'),
(6, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewFaculty.php', 'f425c84050a9526eaeb73b467ba46069', '7'),
(7, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewQuestion.php', '206e47db40ac4646a3cb2d34f977e3e9', '5'),
(8, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewAdmin.php', '6c566c58320876ed0fa4072d12224ff8', '6'),
(9, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewEvaluation.php', '135f94b70ecc36cce84ad672c5026bad', '1'),
(10, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewSemester.php', '647c7f8ad8278173a37689385294d220', '1'),
(11, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewCourseTaken.php', '7748f05c658aa9416723554bda246138', '3'),
(12, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewQuestionCriteria.php', '9c21a224db3c1ca3d6b37f595b24b7a7', '2'),
(13, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewEvaluationInd.php', '671e72131d55c1903a4f0197b778e4bc', '3'),
(14, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewStuEvaluation.php', '0b612320453864c15ca7f7e296a23781', '2'),
(15, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewStuEvaluationResult.php', '0038441f7c4fa56eefdc8dbf65d08a98', '2'),
(16, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewDepartment.php', '2566cc04a79d9c90a14a2f04bbc7a3ae', '2'),
(17, 'tanvir@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewFeedback.php', 'da9dff7eec5d1193fb300b968bb582b8', '2'),
(18, 'admint@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewStudent.php', 'c386ed976c99a527d63ed90540efd2be', '1'),
(19, 'admint@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewCourse.php', '71ad8762c310ca11cf3eb22d1730482b', '1'),
(20, 'admint@gmail.com', 'http://localhost/Faculty%20Evaluation%20System/admin/viewDepartment.php', '2566cc04a79d9c90a14a2f04bbc7a3ae', '1');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `q_id` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `criteria_cr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`q_id`, `question`, `criteria_cr_id`) VALUES
(1, 'The instructor was well prepared for class ?', 1),
(2, 'The instructor’s teaching methods were effective ?', 1),
(4, 'The instructor encouraged student participation in class ?', 1),
(5, 'The instructor used class time effectively ?', 1),
(6, 'The instructor presented course material in a clear manner that facilitated understanding ?', 1),
(7, 'The instructor provided feedback in a timely manner ?', 1),
(8, 'The course was organized in a manner that helped me understand underlying concepts ?', 1),
(9, 'Exams and assignments were reflective of the course content ?', 1),
(10, 'This course gave me confidence to do more advanced work in the subject ?', 1),
(11, 'Exams/assignments were a fair assessment of my knowledge of the course material ?', 1),
(12, 'Individual class meetings were well prepared ?', 2),
(13, 'The instructor was well prepared for class ?', 2),
(14, 'The instructor communicated clearly and was easy to understand ?', 2),
(15, 'The instructor stimulated my interest in the subject matter ?', 2),
(16, 'The instructor was available to students ?', 2),
(17, 'The instructor cared about the students, their progress, and successful course completion ?', 2),
(18, 'The instructional materials (i.e., books, readings, handouts, study guides, lab manuals, multimedia, software) increased my knowledge and skills in the subject matter ?', 2),
(19, 'The tests/assessments accurately assess what I have learned in this course ?', 2),
(20, 'The instructor grades consistently with the evaluation criteria ?', 2),
(21, 'This course gave me confidence to do more advanced work in the subject ?', 2);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(25) NOT NULL,
  `s_running` varchar(5) NOT NULL DEFAULT 'False',
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`s_id`, `s_name`, `s_running`, `date`) VALUES
(1, 'Spring-22', 'True', '2021-12-10'),
(2, 'Summer-22', 'False', '2021-12-10'),
(4, 'Fall-22', 'False', '2021-12-21');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `student_id` varchar(13) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(7) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `student_id`, `email`, `password`, `date`, `status`) VALUES
(1, 'Tanvir Hossain', '2018-1-60-234', 'tanvirjoardar@gmail.com', 'Tanvir123', '2021-11-30', 'student'),
(3, 'Asif Joardar', '2018-1-60-236', 'asifjoardar@gmail.com', 'Asif1234', '2021-11-30', 'student'),
(6, 'Ashonaz joardar', '2018-1-60-111', 'ashonaz@gmail.com', 'Ashonaz123', '2021-12-23', 'student'),
(7, 'Ramzan Ali', '2018-1-60-235', 'ramzanali@gmail.com', 'Ramzan123', '2021-12-26', 'student'),
(8, 'Hamin Lasker', '2018-1-60-237', 'hamim@gmail.com', 'Hamim123', '2021-12-26', 'student'),
(9, 'Nirjhor Ahmed', '2018-1-60-238', 'nirjhor@gmail.com', 'Nirjhor123', '2021-12-27', 'student'),
(10, 'Samia Islam', '2018-1-60-239', 'samia@gmail.com', 'Samia123', '2022-01-12', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `useradmin`
--

CREATE TABLE `useradmin` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` varchar(7) NOT NULL DEFAULT 'admin',
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useradmin`
--

INSERT INTO `useradmin` (`id`, `name`, `email`, `password`, `status`, `date`) VALUES
(1, 'Tanvir Hossain', 'tanvir@gmail.com', 'Admin5050', 'admin', '2021-12-05'),
(4, 'Asif Joardar', 'asifjoardar@gmail.com', 'Admin5050', 'admin', '2021-12-25'),
(5, 'Admin Test', 'admint@gmail.com', 'Admint5050', 'admin', '2022-01-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `faculty_f_id` (`faculty_f_id`),
  ADD KEY `department_d_id` (`department_d_id`),
  ADD KEY `semeser_s_id` (`semester_s_id`);

--
-- Indexes for table `coursetaken`
--
ALTER TABLE `coursetaken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_c_id` (`course_c_id`),
  ADD KEY `user_u_id` (`user_u_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`cr_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `departmenttaken`
--
ALTER TABLE `departmenttaken`
  ADD PRIMARY KEY (`dt_id`),
  ADD KEY `department_d_id` (`department_d_id`),
  ADD KEY `user_u_id` (`user_u_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_c_id` (`course_c_id`),
  ADD KEY `user_u_id` (`user_u_id`),
  ADD KEY `question_q_id` (`question_q_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `department_d_id` (`department_d_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_c_id` (`course_c_id`),
  ADD KEY `faculty_f_id` (`faculty_f_id`),
  ADD KEY `user_u_id` (`user_u_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`q_id`),
  ADD KEY `criteria_cr_id` (`criteria_cr_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useradmin`
--
ALTER TABLE `useradmin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `coursetaken`
--
ALTER TABLE `coursetaken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departmenttaken`
--
ALTER TABLE `departmenttaken`
  MODIFY `dt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `useradmin`
--
ALTER TABLE `useradmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`faculty_f_id`) REFERENCES `faculty` (`f_id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`department_d_id`) REFERENCES `department` (`d_id`),
  ADD CONSTRAINT `course_ibfk_3` FOREIGN KEY (`semester_s_id`) REFERENCES `semester` (`s_id`);

--
-- Constraints for table `coursetaken`
--
ALTER TABLE `coursetaken`
  ADD CONSTRAINT `coursetaken_ibfk_1` FOREIGN KEY (`course_c_id`) REFERENCES `course` (`c_id`),
  ADD CONSTRAINT `coursetaken_ibfk_2` FOREIGN KEY (`user_u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `departmenttaken`
--
ALTER TABLE `departmenttaken`
  ADD CONSTRAINT `departmenttaken_ibfk_1` FOREIGN KEY (`department_d_id`) REFERENCES `department` (`d_id`),
  ADD CONSTRAINT `departmenttaken_ibfk_2` FOREIGN KEY (`user_u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`course_c_id`) REFERENCES `course` (`c_id`),
  ADD CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`user_u_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `evaluation_ibfk_4` FOREIGN KEY (`question_q_id`) REFERENCES `question` (`q_id`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`department_d_id`) REFERENCES `department` (`d_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`course_c_id`) REFERENCES `course` (`c_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`faculty_f_id`) REFERENCES `faculty` (`f_id`),
  ADD CONSTRAINT `feedback_ibfk_3` FOREIGN KEY (`user_u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`criteria_cr_id`) REFERENCES `criteria` (`cr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

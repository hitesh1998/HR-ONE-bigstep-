-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2021 at 05:37 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emp`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `Attendance_Id` int NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Time` time NOT NULL,
  `Date` varchar(15) NOT NULL,
  `Mentor_email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Attendance_Id`, `Name`, `Email`, `Type`, `Time`, `Date`, `Mentor_email`) VALUES
(81, 'Hitesh Jivanani', 'hiteshgirish@ymail.com', 'In', '12:51:00', '2021-05-19', 'ankitgupt@gmail.com'),
(82, 'Hitesh Jivanani', 'hiteshgirish@ymail.com', 'Out', '12:51:00', '2021-05-19', 'ankitgupt@gmail.com'),
(83, 'Nayan Agrawal', 'nayan@gmail.com', 'In', '13:14:00', '2021-05-19', 'ankitgupta@gmail.com'),
(84, 'Nayan Agrawal', 'nayan@gmail.com', 'Out', '13:14:00', '2021-05-19', 'ankitgupta@gmail.com'),
(85, 'Hitesh jivnani', 'hiteshgirish@ymail.com', 'In', '21:08:00', '2021-05-20', 'mentor@gmail.com'),
(86, 'Hitesh jivnani', 'hiteshgirish@ymail.com', 'Out', '21:08:00', '2021-05-20', 'mentor@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_request`
--

CREATE TABLE `attendance_request` (
  `AR_ID` int NOT NULL,
  `User_name` varchar(20) NOT NULL,
  `User_email` varchar(30) NOT NULL,
  `Reason` varchar(30) NOT NULL,
  `Remark` varchar(1000) NOT NULL,
  `Date` varchar(15) NOT NULL,
  `Punch-in` varchar(10) NOT NULL,
  `Punch-out` varchar(10) NOT NULL,
  `Mentor_email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Half_day` int NOT NULL,
  `Approved` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance_request`
--

INSERT INTO `attendance_request` (`AR_ID`, `User_name`, `User_email`, `Reason`, `Remark`, `Date`, `Punch-in`, `Punch-out`, `Mentor_email`, `Half_day`, `Approved`) VALUES
(5, 'Nayan Agrawal', 'nayan@gmail.com', 'Forgot checkin', 'sorry by mistake ..', '2021-05-19', '09:00', '19:00', 'ankitgupta@gmail.com', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `emp_dtls`
--

CREATE TABLE `emp_dtls` (
  `Id` mediumint NOT NULL,
  `First_Name` varchar(10) NOT NULL,
  `Last_Name` varchar(10) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `PhoneNu` varchar(15) NOT NULL,
  `Mentor` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Menter_email` varchar(30) NOT NULL,
  `Role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Passward` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Gender` varchar(5) NOT NULL,
  `Pimg` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `emp_dtls`
--

INSERT INTO `emp_dtls` (`Id`, `First_Name`, `Last_Name`, `Email`, `PhoneNu`, `Mentor`, `Menter_email`, `Role`, `Passward`, `Gender`, `Pimg`) VALUES
(42, 'shubham', 'soni', 'shubham@gmail.com', '7509876643', 'Ankit gupta', 'ankitgupta@gmail.com', 'Software Engineer', '$2y$10$geEBckZSaQMvJGQwZEj76.Lys4dWQDuwJlX4BCkTGAPCx2pgbiq4m', 'male', 'whisket2.jpg'),
(43, 'Hitesh', 'jivnani', 'hiteshgirish@ymail.com', '7509876643', 'Mentor', 'mentor@gmail.com', 'Product manager', '$2y$10$qRPO6HJFJ8rwIJWpDl7VfumbfyGZ2m/wNjQcALa5vQ41puluEYJM.', 'male', 'hitesh.png'),
(44, 'Ankit', 'Gupta', 'ankitgupta@gmail.com', '7509876643', 'Mentor', 'mentor@gmail.com', 'Software Engineer', '$2y$10$Kewyh6inW4tZVDcajD/MaO1eAtWNQu7XihMlOzXIBJidcM2akGk1K', 'male', 'male.png'),
(45, 'Ankit', 'chaturvedi', 'ankit@gmail.com', '7509876643', 'Ankit gupta', 'ankitgupta@gmail.com', 'Software Engineer', '$2y$10$bwOxe5HepwLs6Vb32y8Y9uhi0dEumGYL1rHnfZAZ9zuK8kRVZ55Me', 'male', 'male6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `full_attendance`
--

CREATE TABLE `full_attendance` (
  `A_id` int NOT NULL,
  `User_name` varchar(20) NOT NULL,
  `User_email` varchar(30) NOT NULL,
  `Date` varchar(15) NOT NULL,
  `Mentor_email` varchar(30) NOT NULL,
  `Full_day` int NOT NULL,
  `Approved` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `full_attendance`
--

INSERT INTO `full_attendance` (`A_id`, `User_name`, `User_email`, `Date`, `Mentor_email`, `Full_day`, `Approved`) VALUES
(7, 'Hitesh Jivanani', 'hiteshgirish@ymail.com', '2021-05-19', 'ankitgupta@gmail.com', 0, 1),
(8, 'Nayan Agrawal', 'nayan@gmail.com', '2021-05-19', 'ankitgupta@gmail.com', 1, 1),
(9, 'Hitesh jivnani', 'hiteshgirish@ymail.com', '2021-05-20', 'mentor@gmail.com', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leverequest`
--

CREATE TABLE `leverequest` (
  `Request_id` int NOT NULL,
  `User_email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `User_name` varchar(20) NOT NULL,
  `Leave_type` varchar(15) NOT NULL,
  `Start_date` varchar(15) NOT NULL,
  `End_date` varchar(15) NOT NULL,
  `Reason` text NOT NULL,
  `Mentor_email` varchar(30) NOT NULL,
  `Half_day` int NOT NULL,
  `Approved` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leverequest`
--

INSERT INTO `leverequest` (`Request_id`, `User_email`, `User_name`, `Leave_type`, `Start_date`, `End_date`, `Reason`, `Mentor_email`, `Half_day`, `Approved`) VALUES
(11, 'nayan@gmail.com', 'Nayan Agrawal', 'Casual Leave', '2021-05-20', '2021-05-21', 'gumne jana h yrr', 'ankitgupta@gmail.com', 0, '2'),
(12, 'nayan@gmail.com', 'Nayan Agrawal', 'Casual Leave', '2021-05-21', '2021-05-22', 'haggdf ', 'ankitgupta@gmail.com', 0, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`Attendance_Id`);

--
-- Indexes for table `attendance_request`
--
ALTER TABLE `attendance_request`
  ADD PRIMARY KEY (`AR_ID`);

--
-- Indexes for table `emp_dtls`
--
ALTER TABLE `emp_dtls`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `full_attendance`
--
ALTER TABLE `full_attendance`
  ADD PRIMARY KEY (`A_id`);

--
-- Indexes for table `leverequest`
--
ALTER TABLE `leverequest`
  ADD PRIMARY KEY (`Request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `Attendance_Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `attendance_request`
--
ALTER TABLE `attendance_request`
  MODIFY `AR_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emp_dtls`
--
ALTER TABLE `emp_dtls`
  MODIFY `Id` mediumint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `full_attendance`
--
ALTER TABLE `full_attendance`
  MODIFY `A_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leverequest`
--
ALTER TABLE `leverequest`
  MODIFY `Request_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

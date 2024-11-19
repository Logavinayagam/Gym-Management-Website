-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Nov 19, 2024 at 06:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `diet_plan`
--

DROP TABLE IF EXISTS `diet_plan`;
CREATE TABLE `diet_plan` (
  `diet_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `meal_type` enum('breakfast','lunch','snack','dinner') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plan`
--

INSERT INTO `diet_plan` (`diet_id`, `trainer_id`, `date`, `meal_type`) VALUES
(1, 1, '2024-11-14', NULL),
(2, 1, '2024-11-14', NULL),
(3, 1, NULL, NULL),
(4, 1, '2024-11-17', 'breakfast'),
(5, 1, '2024-11-17', 'breakfast'),
(6, 1, '2024-11-17', 'breakfast'),
(7, 1, '2024-11-17', NULL),
(8, 1, '2024-11-23', 'breakfast'),
(9, 1, '2024-11-23', 'breakfast'),
(10, 1, '2024-11-30', 'breakfast'),
(11, 1, '2024-12-06', 'breakfast'),
(12, 1, '2024-12-06', 'breakfast'),
(13, 1, '2024-12-06', 'breakfast'),
(14, 1, '2024-11-23', 'dinner'),
(15, 1, '2024-11-22', 'lunch'),
(16, 1, '2024-11-22', 'lunch'),
(17, 1, '2024-11-22', 'lunch'),
(18, 1, '2024-11-09', 'lunch'),
(19, 1, '2024-11-09', 'lunch'),
(20, 1, '2024-12-02', 'breakfast'),
(21, 1, '2024-12-02', 'breakfast'),
(22, 1, '2024-12-02', 'breakfast'),
(23, 1, '2024-12-02', 'breakfast'),
(24, 1, '2024-12-01', 'breakfast'),
(25, 1, '2024-11-15', 'dinner');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plan_meals`
--

DROP TABLE IF EXISTS `diet_plan_meals`;
CREATE TABLE `diet_plan_meals` (
  `id` int(11) NOT NULL,
  `diet_id` int(11) DEFAULT NULL,
  `member_id` varchar(10) DEFAULT NULL,
  `meal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plan_meals`
--

INSERT INTO `diet_plan_meals` (`id`, `diet_id`, `member_id`, `meal_id`) VALUES
(1, 1, 'JRM003', 2),
(2, 2, 'JRM003', 2),
(3, 3, 'JRM002', 1),
(4, 4, 'JRM003', 1),
(5, 5, 'JRM003', 1),
(6, 5, 'JRM003', 8),
(7, 6, 'JRM003', 1),
(8, 6, 'JRM003', 8),
(9, 7, 'JRM003', 1),
(10, 8, 'JRM003', 4),
(11, 8, 'JRM003', 2),
(12, 9, 'JRM003', 4),
(13, 9, 'JRM003', 2),
(14, 11, 'JRM001', 10),
(16, 12, 'JRM001', 10),
(17, 13, 'JRM001', 10),
(18, 14, 'JRM002', 9),
(19, 15, 'JRM003', 7),
(20, 16, 'JRM003', 7),
(21, 17, 'JRM003', 7),
(22, 18, 'JRM003', 8),
(23, 19, 'JRM001', 2),
(24, 20, 'JRM002', 8),
(25, 21, 'JRM002', 8),
(26, 22, 'JRM001', 8),
(27, 23, 'JRM001', 2),
(28, 23, 'JRM001', 6),
(29, 23, 'JRM001', 4),
(30, 24, 'JRM001', 9),
(31, 25, 'JRM004', 2),
(32, 25, 'JRM004', 3);

-- --------------------------------------------------------

--
-- Table structure for table `diet_plan_trainees`
--

DROP TABLE IF EXISTS `diet_plan_trainees`;
CREATE TABLE `diet_plan_trainees` (
  `id` int(11) NOT NULL,
  `diet_id` int(11) DEFAULT NULL,
  `member_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plan_trainees`
--

INSERT INTO `diet_plan_trainees` (`id`, `diet_id`, `member_id`) VALUES
(1, 3, 'JRM002'),
(2, 4, 'JRM003'),
(3, 5, 'JRM003'),
(4, 6, 'JRM003'),
(5, 7, 'JRM003'),
(6, 8, 'JRM003'),
(7, 9, 'JRM003'),
(8, 12, 'JRM001'),
(9, 13, 'JRM001'),
(10, 14, 'JRM002'),
(11, 15, 'JRM003'),
(12, 16, 'JRM003'),
(13, 17, 'JRM003'),
(14, 18, 'JRM003'),
(15, 19, 'JRM001'),
(16, 20, 'JRM002'),
(17, 21, 'JRM002'),
(18, 22, 'JRM001'),
(19, 23, 'JRM001'),
(20, 24, 'JRM001'),
(21, 25, 'JRM004');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `condition` varchar(50) NOT NULL,
  `maintenance_date` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `name`, `quantity`, `condition`, `maintenance_date`, `location`) VALUES
(1, 'Dumbell', 12, 'Good', '2024-11-15', 'Gym');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_list`
--

DROP TABLE IF EXISTS `exercise_list`;
CREATE TABLE `exercise_list` (
  `exercise_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `muscle_group` varchar(50) DEFAULT NULL,
  `type` enum('circuit','rest','push','pull','leg','chest','back','arm','abs','split') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise_list`
--

INSERT INTO `exercise_list` (`exercise_id`, `name`, `muscle_group`, `type`) VALUES
(1, 'Push-up', 'Chest', 'push'),
(2, 'Pull-up', 'Back', 'pull'),
(3, 'Squat', 'Legs', 'leg'),
(4, 'Deadlift', 'Back', 'pull'),
(5, 'Bench Press', 'Chest', 'push'),
(6, 'Dumbbell Row', 'Back', 'pull'),
(7, 'Lunges', 'Legs', 'leg'),
(8, 'Plank', 'Abs', 'abs'),
(9, 'Bicep Curl', 'Arms', 'push'),
(10, 'Tricep Dips', 'Arms', 'push'),
(11, 'Leg Press', 'Legs', 'leg'),
(12, 'Chest Fly', 'Chest', 'push'),
(13, 'Overhead Press', 'Shoulders', 'push'),
(14, 'Lat Pulldown', 'Back', 'pull'),
(15, 'Leg Curl', 'Legs', 'leg');

-- --------------------------------------------------------

--
-- Table structure for table `meal_list`
--

DROP TABLE IF EXISTS `meal_list`;
CREATE TABLE `meal_list` (
  `meal_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `protein` int(11) DEFAULT NULL,
  `fat` int(11) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_list`
--

INSERT INTO `meal_list` (`meal_id`, `name`, `protein`, `fat`, `calories`) VALUES
(1, 'Oats with Almonds', 10, 5, 200),
(2, 'Grilled Chicken Breast', 30, 5, 250),
(3, 'Boiled Eggs', 12, 10, 180),
(4, 'Brown Rice with Vegetables', 8, 3, 150),
(5, 'Avocado Toast', 6, 15, 300),
(6, 'Greek Yogurt with Berries', 15, 8, 250),
(7, 'Salmon Salad', 25, 15, 350),
(8, 'Tofu Stir Fry', 18, 7, 220),
(9, 'Chicken and Vegetable Soup', 22, 6, 280),
(10, 'Beef Stir Fry', 26, 12, 350);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `member_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) GENERATED ALWAYS AS (timestampdiff(YEAR,`date_of_birth`,curdate())) VIRTUAL,
  `location` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT `phone_number`,
  `membership_expire_date` date DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `name`, `height`, `weight`, `phone_number`, `date_of_birth`, `location`, `password`, `membership_expire_date`, `payment_id`, `email`) VALUES
('JRM001', 'loga', 170.00, 63.00, '9514831525', '2004-10-28', 'Vellore', '2345', '2024-12-28', 3, 'logavinayagam74@gmail.com'),
('JRM002', 'yogesh', 170.00, 85.00, '9988776655', '2004-09-11', 'Vellore', '9988776655', '2024-10-28', 6, NULL),
('JRM003', 'lokesh', 180.00, 86.00, '9751364124', '2005-03-15', 'vellore', '1513', '2025-10-22', 7, 'loki39401@gmail.com'),
('JRM004', 'DK', 187.00, 92.00, '9789255031', '2005-01-05', 'Vellore', '9789255031', '2025-11-15', 8, NULL);

--
-- Triggers `member`
--
DROP TRIGGER IF EXISTS `generate_member_id`;
DELIMITER $$
CREATE TRIGGER `generate_member_id` BEFORE INSERT ON `member` FOR EACH ROW BEGIN
    DECLARE new_id VARCHAR(10);
    
    -- Generate the new member ID with a prefix 'JRM' and incremented number
    SELECT CONCAT('JRM', LPAD(COUNT(*) + 1, 3, '0')) INTO new_id FROM member;

    -- Assign the generated ID to the new row
    SET NEW.member_id = new_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `member_trainer`
--

DROP TABLE IF EXISTS `member_trainer`;
CREATE TABLE `member_trainer` (
  `member_id` varchar(10) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `membership_start` date DEFAULT NULL,
  `membership_expire` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_trainer`
--

INSERT INTO `member_trainer` (`member_id`, `trainer_id`, `membership_start`, `membership_expire`, `is_active`) VALUES
('JRM001', 1, '2024-11-04', '2024-12-04', 1),
('JRM002', 1, '2024-10-22', '2024-11-22', 1),
('JRM003', 1, '2024-10-22', '2024-12-22', 1),
('JRM004', 1, '2024-11-15', '2025-03-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

DROP TABLE IF EXISTS `owner`;
CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `upi_id` varchar(100) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `phone_number`, `email`, `password`, `upi_id`, `contact_number`, `name`) VALUES
(1, '9876543210', 'loga@gmail.com', '9876543210', 'logavinayagam74@oksbi', NULL, 'Loga');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `member_id` varchar(10) DEFAULT NULL,
  `owner_upi_id` varchar(100) DEFAULT NULL,
  `trainer_upi_id` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date DEFAULT curdate(),
  `status` enum('Paid','Pending','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `member_id`, `owner_upi_id`, `trainer_upi_id`, `amount`, `payment_date`, `status`) VALUES
(3, 'JRM001', NULL, NULL, 1700.00, '2024-09-28', 'Pending'),
(4, 'JRM001', 'owner_upi_id_here', 'trainer_upi_id_here', 700.00, '2024-09-28', 'Pending'),
(5, 'JRM001', 'logavinayagam74@oksbi', 'logavinayagam74@oksbi', 2400.00, '2024-09-28', 'Pending'),
(6, 'JRM002', NULL, NULL, 600.00, '2024-09-29', 'Pending'),
(7, 'JRM003', NULL, NULL, 6500.00, '2024-10-22', 'Pending'),
(8, 'JRM004', NULL, NULL, 6500.00, '2024-11-15', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `member_id` varchar(10) DEFAULT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `day_of_week` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `time_slot` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `member_id`, `trainer_id`, `day_of_week`, `start_time`, `end_time`, `time_slot`) VALUES
(1, 'JRM001', 1, 'Sunday', '00:00:00', '00:00:00', '06:30:00'),
(2, 'JRM002', 1, 'Sunday', '00:00:00', '00:00:00', '06:30:00'),
(3, 'JRM002', 1, 'Monday', '00:00:00', '00:00:00', '07:00:00'),
(4, 'JRM002', 1, 'Tuesday', '00:00:00', '00:00:00', '07:00:00'),
(5, 'JRM002', 1, 'Wednesday', '00:00:00', '00:00:00', '06:30:00'),
(6, 'JRM002', 1, 'Thursday', '00:00:00', '00:00:00', '09:00:00'),
(7, 'JRM003', 1, 'Tuesday', '00:00:00', '00:00:00', '05:30:00'),
(8, 'JRM001', 1, 'Tuesday', '00:00:00', '00:00:00', '06:00:00'),
(9, 'JRM001', 1, 'Monday', '09:00:00', '10:30:00', NULL),
(10, 'JRM004', 1, 'Friday', '18:00:00', '20:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spotlight`
--

DROP TABLE IF EXISTS `spotlight`;
CREATE TABLE `spotlight` (
  `spotlight_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spotlight`
--

INSERT INTO `spotlight` (`spotlight_id`, `content`, `start_date`, `end_date`, `title`) VALUES
(1, 'HI is this spotlight working', '2024-09-28', '2024-09-30', 'checking');

-- --------------------------------------------------------

--
-- Table structure for table `supplement`
--

DROP TABLE IF EXISTS `supplement`;
CREATE TABLE `supplement` (
  `supplement_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `expiration_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplement`
--

INSERT INTO `supplement` (`supplement_id`, `name`, `type`, `quantity`, `expiration_date`, `supplier`) VALUES
(1, 'Wellcore', 'Cretaine', 5, '2025-11-15', 'Wellcore');

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

DROP TABLE IF EXISTS `trainer`;
CREATE TABLE `trainer` (
  `trainer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) GENERATED ALWAYS AS (timestampdiff(YEAR,`date_of_birth`,curdate())) VIRTUAL,
  `grade` enum('Grade 1','Grade 2','Assistant') NOT NULL,
  `is_certified` tinyint(1) DEFAULT 0,
  `password` varchar(255) DEFAULT `phone_number`,
  `upi_id` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`trainer_id`, `name`, `phone_number`, `date_of_birth`, `grade`, `is_certified`, `password`, `upi_id`, `email`) VALUES
(1, 'loga', '9444818125', '2004-10-28', 'Grade 1', 1, '2345', 'logavinayagam74@oksbi', 'trainer@gmail.com');

--
-- Triggers `trainer`
--
DROP TRIGGER IF EXISTS `generate_trainer_id`;
DELIMITER $$
CREATE TRIGGER `generate_trainer_id` BEFORE INSERT ON `trainer` FOR EACH ROW BEGIN
    DECLARE new_id INT;
    SELECT IFNULL(MAX(trainer_id), 0) + 1 INTO new_id FROM trainer;
    SET NEW.trainer_id = new_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `training_plan`
--

DROP TABLE IF EXISTS `training_plan`;
CREATE TABLE `training_plan` (
  `plan_id` int(11) NOT NULL,
  `member_id` varchar(10) DEFAULT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `plan_content` text NOT NULL,
  `plan_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_plan`
--

INSERT INTO `training_plan` (`plan_id`, `member_id`, `trainer_id`, `plan_content`, `plan_date`) VALUES
(1, 'JRM001', 1, 'checking for the website', '2024-09-28'),
(2, 'JRM001', 1, 'checking the plan', '2024-09-30'),
(3, 'JRM003', 1, 'come to gym regularly!!! ', '2024-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `workout_plan`
--

DROP TABLE IF EXISTS `workout_plan`;
CREATE TABLE `workout_plan` (
  `plan_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `workout_type` enum('circuit','rest','push','pull','leg','chest','back','arm','abs','split') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_plan`
--

INSERT INTO `workout_plan` (`plan_id`, `trainer_id`, `date`, `workout_type`) VALUES
(1, 1, '2024-11-08', 'circuit'),
(2, 1, '2024-11-14', 'circuit'),
(3, 1, '2024-11-14', 'circuit'),
(4, 1, '2024-11-14', 'circuit'),
(5, 1, '2024-11-14', 'circuit'),
(6, 1, '2024-11-14', 'circuit'),
(7, 1, '2024-11-15', 'circuit'),
(8, 1, '2024-11-15', 'circuit'),
(10, 1, '2024-11-19', NULL),
(11, 1, '2024-11-14', 'push'),
(12, 1, NULL, 'push'),
(13, 1, '2024-11-17', 'leg'),
(14, 1, '2024-11-17', 'leg'),
(15, 1, '2024-11-17', 'leg'),
(16, 1, '2024-11-23', 'leg'),
(17, 1, '2024-11-23', 'leg'),
(18, 1, '2024-11-23', 'pull'),
(19, 1, '2024-11-23', 'pull'),
(20, 1, '2024-11-23', 'pull'),
(21, 1, '2024-11-23', 'pull'),
(22, 1, '2024-11-23', 'pull'),
(23, 1, '2024-11-22', 'leg'),
(24, 1, '2024-11-09', 'pull'),
(25, 1, '2024-11-09', 'pull'),
(26, 1, '2024-11-09', 'pull'),
(27, 1, '2024-11-09', 'pull'),
(28, 1, '2024-11-09', 'pull'),
(29, 1, '2024-12-02', 'circuit'),
(30, 1, '2024-12-02', 'circuit'),
(31, 1, '2024-12-02', 'circuit'),
(32, 1, '2024-12-01', 'push'),
(33, 1, '2024-11-15', 'circuit');

-- --------------------------------------------------------

--
-- Table structure for table `workout_plan_exercises`
--

DROP TABLE IF EXISTS `workout_plan_exercises`;
CREATE TABLE `workout_plan_exercises` (
  `entry_id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `member_id` varchar(10) DEFAULT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `sets` int(11) DEFAULT NULL,
  `reps` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_plan_exercises`
--

INSERT INTO `workout_plan_exercises` (`entry_id`, `plan_id`, `member_id`, `exercise_id`, `sets`, `reps`, `weight`) VALUES
(1, 3, NULL, 1, 3, 10, 0),
(2, 4, 'JRM001', 1, 3, 10, 0),
(3, 5, 'JRM001', 2, 3, 10, 5),
(4, 6, 'JRM001', 2, 3, 10, 5),
(5, 7, NULL, 1, 3, 10, 0),
(6, 7, NULL, 2, 2, 6, 0),
(7, 7, NULL, 12, 2, 12, 15),
(8, 8, NULL, 1, 3, 10, 0),
(9, 8, NULL, 2, 2, 6, 0),
(10, 8, NULL, 12, 2, 12, 15),
(11, 11, 'JRM002', 2, NULL, NULL, NULL),
(12, 11, 'JRM002', NULL, 2, NULL, NULL),
(13, 11, 'JRM002', NULL, NULL, 3, NULL),
(14, 11, 'JRM002', NULL, NULL, NULL, 0),
(15, 12, 'JRM001', 1, NULL, NULL, NULL),
(16, 12, 'JRM001', NULL, 2, NULL, NULL),
(17, 12, 'JRM001', NULL, NULL, 10, NULL),
(18, 12, 'JRM001', NULL, NULL, NULL, 0),
(19, 12, 'JRM001', 9, NULL, NULL, NULL),
(20, 12, 'JRM001', NULL, 2, NULL, NULL),
(21, 12, 'JRM001', NULL, NULL, 12, NULL),
(22, 12, 'JRM001', NULL, NULL, NULL, 5),
(23, 24, 'JRM003', 13, NULL, NULL, NULL),
(24, 24, 'JRM003', NULL, 3, NULL, NULL),
(25, 24, 'JRM003', NULL, NULL, 3, NULL),
(26, 24, 'JRM003', NULL, NULL, NULL, 3),
(27, 25, 'JRM003', 13, NULL, NULL, NULL),
(28, 25, 'JRM003', NULL, 3, NULL, NULL),
(29, 25, 'JRM003', NULL, NULL, 3, NULL),
(30, 25, 'JRM003', NULL, NULL, NULL, 3),
(31, 26, 'JRM003', 13, NULL, NULL, NULL),
(32, 26, 'JRM003', NULL, 3, NULL, NULL),
(33, 26, 'JRM003', NULL, NULL, 3, NULL),
(34, 26, 'JRM003', NULL, NULL, NULL, 3),
(35, 28, 'JRM001', 11, 5, 7, 8),
(36, 29, 'JRM002', 14, 9, 6, 10),
(37, 30, 'JRM002', 14, 9, 6, 10),
(38, 31, 'JRM001', 12, 9, 6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `workout_plan_trainees`
--

DROP TABLE IF EXISTS `workout_plan_trainees`;
CREATE TABLE `workout_plan_trainees` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `member_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_plan_trainees`
--

INSERT INTO `workout_plan_trainees` (`id`, `plan_id`, `member_id`) VALUES
(1, 3, 'JRM001'),
(2, 4, 'JRM001'),
(3, 5, 'JRM001'),
(4, 6, 'JRM001'),
(5, 7, 'JRM001'),
(6, 8, 'JRM001'),
(7, 11, 'JRM002'),
(8, 12, 'JRM001'),
(9, 13, 'JRM003'),
(10, 14, 'JRM003'),
(11, 15, 'JRM003'),
(12, 16, 'JRM003'),
(13, 17, 'JRM003'),
(14, 18, 'JRM002'),
(15, 19, 'JRM002'),
(16, 20, 'JRM002'),
(17, 21, 'JRM002'),
(18, 22, 'JRM002'),
(19, 23, 'JRM003'),
(20, 24, 'JRM003'),
(21, 25, 'JRM003'),
(22, 26, 'JRM003'),
(23, 27, 'JRM003'),
(24, 28, 'JRM001'),
(25, 29, 'JRM002'),
(26, 30, 'JRM002'),
(27, 31, 'JRM001'),
(28, 32, 'JRM001'),
(29, 33, 'JRM004');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diet_plan`
--
ALTER TABLE `diet_plan`
  ADD PRIMARY KEY (`diet_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `diet_plan_meals`
--
ALTER TABLE `diet_plan_meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diet_id` (`diet_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `meal_id` (`meal_id`);

--
-- Indexes for table `diet_plan_trainees`
--
ALTER TABLE `diet_plan_trainees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diet_id` (`diet_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `exercise_list`
--
ALTER TABLE `exercise_list`
  ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `meal_list`
--
ALTER TABLE `meal_list`
  ADD PRIMARY KEY (`meal_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `fk_payment_id` (`payment_id`);

--
-- Indexes for table `member_trainer`
--
ALTER TABLE `member_trainer`
  ADD PRIMARY KEY (`member_id`,`trainer_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `spotlight`
--
ALTER TABLE `spotlight`
  ADD PRIMARY KEY (`spotlight_id`);

--
-- Indexes for table `supplement`
--
ALTER TABLE `supplement`
  ADD PRIMARY KEY (`supplement_id`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`trainer_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `training_plan`
--
ALTER TABLE `training_plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `workout_plan`
--
ALTER TABLE `workout_plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `workout_plan_exercises`
--
ALTER TABLE `workout_plan_exercises`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `exercise_id` (`exercise_id`);

--
-- Indexes for table `workout_plan_trainees`
--
ALTER TABLE `workout_plan_trainees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diet_plan`
--
ALTER TABLE `diet_plan`
  MODIFY `diet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `diet_plan_meals`
--
ALTER TABLE `diet_plan_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `diet_plan_trainees`
--
ALTER TABLE `diet_plan_trainees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exercise_list`
--
ALTER TABLE `exercise_list`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `meal_list`
--
ALTER TABLE `meal_list`
  MODIFY `meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `spotlight`
--
ALTER TABLE `spotlight`
  MODIFY `spotlight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplement`
--
ALTER TABLE `supplement`
  MODIFY `supplement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training_plan`
--
ALTER TABLE `training_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `workout_plan`
--
ALTER TABLE `workout_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `workout_plan_exercises`
--
ALTER TABLE `workout_plan_exercises`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `workout_plan_trainees`
--
ALTER TABLE `workout_plan_trainees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diet_plan`
--
ALTER TABLE `diet_plan`
  ADD CONSTRAINT `diet_plan_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`);

--
-- Constraints for table `diet_plan_meals`
--
ALTER TABLE `diet_plan_meals`
  ADD CONSTRAINT `diet_plan_meals_ibfk_1` FOREIGN KEY (`diet_id`) REFERENCES `diet_plan` (`diet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diet_plan_meals_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diet_plan_meals_ibfk_3` FOREIGN KEY (`meal_id`) REFERENCES `meal_list` (`meal_id`) ON DELETE CASCADE;

--
-- Constraints for table `diet_plan_trainees`
--
ALTER TABLE `diet_plan_trainees`
  ADD CONSTRAINT `diet_plan_trainees_ibfk_1` FOREIGN KEY (`diet_id`) REFERENCES `diet_plan` (`diet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diet_plan_trainees_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `fk_payment_id` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE SET NULL;

--
-- Constraints for table `member_trainer`
--
ALTER TABLE `member_trainer`
  ADD CONSTRAINT `member_trainer_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_trainer_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`) ON DELETE CASCADE;

--
-- Constraints for table `training_plan`
--
ALTER TABLE `training_plan`
  ADD CONSTRAINT `training_plan_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `training_plan_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`) ON DELETE CASCADE;

--
-- Constraints for table `workout_plan`
--
ALTER TABLE `workout_plan`
  ADD CONSTRAINT `workout_plan_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`) ON DELETE CASCADE;

--
-- Constraints for table `workout_plan_exercises`
--
ALTER TABLE `workout_plan_exercises`
  ADD CONSTRAINT `workout_plan_exercises_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `workout_plan` (`plan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workout_plan_exercises_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workout_plan_exercises_ibfk_3` FOREIGN KEY (`exercise_id`) REFERENCES `exercise_list` (`exercise_id`) ON DELETE CASCADE;

--
-- Constraints for table `workout_plan_trainees`
--
ALTER TABLE `workout_plan_trainees`
  ADD CONSTRAINT `workout_plan_trainees_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `workout_plan` (`plan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workout_plan_trainees_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

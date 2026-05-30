-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2026 at 02:00 PM
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
-- Database: `greenleafenergy`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_members`
--

CREATE TABLE `about_members` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `role` varchar(150) NOT NULL,
  `quote` text DEFAULT NULL,
  `translation` text DEFAULT NULL,
  `dream_job` varchar(100) DEFAULT NULL,
  `favourite_food` varchar(100) DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `favourite_sport` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_members`
--

INSERT INTO `about_members` (`member_id`, `member_name`, `role`, `quote`, `translation`, `dream_job`, `favourite_food`, `hometown`, `favourite_sport`) VALUES
(1, 'Owen Sinclair', 'About page developer', 'Wer kämpft, kann verlieren. Wer nicht kämpft, hat schon verloren.', 'Those who fight may lose. Those who do not fight have already lost.', 'Pro Golfer', 'Pizza', 'Melbourne', 'Golf'),
(2, 'Will Daly', 'Job application page developer', 'Deus faustus', 'Lucky day', 'Garbage Truck Driver', 'Rice', 'Kyoto', 'Cricket'),
(3, 'Raffay Ahmad', 'Jobs page developer', 'L’essentiel est invisible pour les yeux', 'What is essential is invisible to the eye', 'Software Engineer', 'Burger', 'Cape Town', 'Football'),
(4, 'Sazzad Hossain Shafin', 'Home page developer', 'Caminante, no hay camino, se hace camino al andar', 'Traveler, there is no path; the path is made by walking.', 'Web Developer', 'Pasta', 'Dhaka', 'Football');

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `job_reference` varchar(5) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `date_of_birth` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `street_address` varchar(40) NOT NULL,
  `suburb_town` varchar(40) NOT NULL,
  `state` varchar(3) NOT NULL,
  `postcode` varchar(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `skill_1` varchar(50) DEFAULT NULL,
  `skill_2` varchar(50) DEFAULT NULL,
  `skill_3` varchar(50) DEFAULT NULL,
  `other_skills` text DEFAULT NULL,
  `status` enum('New','Current','Final') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `job_reference`, `first_name`, `last_name`, `date_of_birth`, `gender`, `street_address`, `suburb_town`, `state`, `postcode`, `email`, `phone`, `skill_1`, `skill_2`, `skill_3`, `other_skills`, `status`) VALUES
(4, 'DA002', 'Sazzad', 'Shafin', '21/04/2006', 'Male', '21 woodlands ave', 'kew east', 'VIC', '3102', 'shshafin@gmail.com', '0400000001', 'Teamwork', 'Coding', 'Frontend Development, Software Development', 'kegwmwrkaenf', 'Current'),
(5, 'WD001', 'Sazzad', 'Shafin', '21/04/2006', 'Male', '21 woodlands ave', 'kew east', 'NT', '3102', 'shshafin35@gmail.com', '0400000001', 'Teamwork', 'Coding', 'Frontend Development, Software Development', 'ml/jnjon', 'Final'),
(6, 'EE003', 'Sazzad', 'Shafin', '21/04/2006', 'Male', '21 woodlands ave', 'kew east', 'NSW', '3102', 'shshafin@gmail.com', '0400000000', 'Teamwork', 'Coding', 'Frontend Development', 'b ,bb', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `job_reference` varchar(5) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_description` text NOT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `reports_to` varchar(100) DEFAULT NULL,
  `position_type` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `responsibilities` text DEFAULT NULL,
  `qualifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `job_reference`, `job_title`, `job_description`, `salary`, `reports_to`, `position_type`, `location`, `responsibilities`, `qualifications`) VALUES
(1, 'WD001', 'Web Developer', 'Develop and maintain responsive websites that promote renewable energy solutions, project updates, and community information.', '$75,000 - $90,000', 'Digital Services Manager', 'Full-time', 'Melbourne, VIC', 'Build and maintain webpages using HTML, CSS, and PHP. Ensure pages are responsive and accessible. Update website content based on project requirements. Work with the digital team to improve user experience.', 'Essential: Basic HTML, CSS, and PHP knowledge; responsive design; clean code. Preferable: Basic database knowledge; GitHub experience; interest in renewable energy projects.'),
(2, 'DA002', 'Data Analyst', 'Collect, organise, and analyse data to help Green Leaf Energy make informed decisions about projects and public engagement.', '$70,000 - $85,000', 'Data and Reporting Manager', 'Full-time', 'Melbourne, VIC', 'Collect and clean project data. Create reports and summaries for internal teams. Analyse trends related to renewable energy projects. Support decision-making through clear data insights.', 'Essential: Excel or spreadsheet skills; attention to detail; ability to explain data clearly. Preferable: Basic SQL knowledge; data visualisation tools; interest in sustainability data.'),
(3, 'EE003', 'Environmental Engineer', 'Support environmental projects by helping reduce pollution, improve sustainability practices, and monitor project impacts.', '$65,000 - $78,000', 'Environmental Projects Manager', 'Full-time', 'Hybrid', 'Monitor environmental project data. Support pollution reduction activities. Prepare reports and documentation. Recommend practical environmental improvements.', 'Essential: Knowledge of environmental sustainability; report writing skills; problem-solving ability. Preferable: Environmental reporting experience; project coordination skills; interest in clean energy systems.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(3, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_members`
--
ALTER TABLE `about_members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `job_reference` (`job_reference`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_members`
--
ALTER TABLE `about_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

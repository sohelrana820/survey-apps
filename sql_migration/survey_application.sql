-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 22, 2020 at 04:37 AM
-- Server version: 5.7.30-0ubuntu0.16.04.1
-- PHP Version: 7.3.19-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `impact_group_size` varchar(255) NOT NULL,
  `occurrence_frequency` varchar(255) NOT NULL,
  `experience_impact` varchar(255) NOT NULL,
  `business_impact` varchar(255) NOT NULL,
  `financial_feasibility` varchar(255) NOT NULL,
  `technical_feasibility` varchar(255) NOT NULL,
  `total_score` varchar(255) NOT NULL,
  `average_score` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20180303214313, 'InitialMigration', '2020-07-21 22:35:51', '2020-07-21 22:35:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `impact_group_size` int(11) NOT NULL,
  `occurrence_frequency` int(11) NOT NULL,
  `experience_impact` int(11) NOT NULL,
  `business_impact` int(11) NOT NULL,
  `financial_feasibility` int(11) NOT NULL,
  `technical_feasibility` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `survey_id`, `question`, `impact_group_size`, `occurrence_frequency`, `experience_impact`, `business_impact`, `financial_feasibility`, `technical_feasibility`, `created_at`, `updated_at`) VALUES
(1, 1, 'Office entry without ID card (Retina scan or proximity sensor etc.)', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(2, 1, 'Virtual personal assistant for every employee', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(3, 1, 'Create meeting minutes on voice command, send to intended recipients and make archives for quick reference', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(4, 1, 'Online employee community for different references & recommendations', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(5, 1, 'Contextual/personalized rewards for employees using analytics', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(6, 1, 'AI-powered talent tool to predict future talent demands, search talent and eliminate hiring bias', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(7, 1, 'Wearable tech to monitor Workplace wellbeing and keep social distancing', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(8, 1, 'Build AI chatbot which will answer all types of employee queries', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(9, 1, 'Gamification of KPIs & goal tracking', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(10, 1, 'Modern ideation platforms to promote innovation', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(11, 1, 'Employee data warehouse to take informed decisions about our people by using real time data and analytics', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(12, 1, 'Interpreting employee emotions during virtual collaboration via a webcam', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(13, 1, 'Augmented and Virtual reality (AR/VR) to turn any space into employee\'s own customizable workspace and gives him/her an immersive learning experience', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(14, 1, 'AI-led video analysis to identify work style, collaboration potential, and general cognitive ability of an applicant during pre-hire assessments', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(15, 1, 'Instead of one-time annual surveys, allow for frequent two-way conversations and real-time feedback between employee & machine (AI) to measure employee engagement.', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(16, 1, 'A central go-to location for all employee information, resources and communication which is intuitive and easy to search', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(17, 1, 'Get AI assisted research (internal/external) insights and automated document review and analysis', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(18, 1, 'Allow crowdsourcing to obtain needed services, ideas, or content by soliciting contributions from a large group of people, especially from the online community rather than from traditional employees', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(19, 1, 'Use sensors, AI software, and data analytics to track employees’ interactions to better understand the relationship between team-building and productivity', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(20, 1, 'Connect the community of healthcare between employees, physicians and care teams with a cloud-based Virtual Care Management solution', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(21, 1, 'Using video analytics software for CCTV and thermal cameras to determine whether social distancing is being maintained and monitor employee body temperature in real time, etc.', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(22, 1, 'Using the lift by calling ahead and indicate the floor employee wants to go to using smartphone app.', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(23, 1, 'Arrange multiplayer online role-playing games to build engagement as well as promoting ideal workplace behavior simulations', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(24, 1, 'Virtual Room Collaboration Platform where team members can use holography, use whiteboard with editing tools, virtual brainstorming etc. in one convenient online location', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(25, 1, 'Use sensor technology in Elevator buttons, washroom etc. to help curb the spread of bacteria and to reduce the need for employees to touch surfaces', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22'),
(26, 1, 'Real time recognition and performance feedback via digital and automated technology', 10, 10, 10, 10, 10, 10, '2020-07-22 04:37:22', '2020-07-22 04:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Survey Number 01', '2020-07-22 04:37:10', '2020-07-22 04:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT '2' COMMENT 'role: 1 = Admin, 2 = General',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Survey Admin', 'survey_admin@gpsurvey.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '1', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(2, 'arifuddin', 'arifuddin@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(3, 'smhaque', 'smhaque@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(4, 'ejaz', 'ejaz@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(5, 'tkhan', 'tkhan@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(6, 'farhana.islam', 'farhana.islam@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(7, 'saiful_alam', 'saiful_alam@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(8, 'shaila.rahman', 'shaila.rahman@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(9, 'zahid_zaman', 'zahid_zaman@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(10, 'aem.saidur', 'aem.saidur@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(11, 'sanat', 'sanat@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(12, 'shabbir', 'shabbir@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(13, 'ashfaqur', 'ashfaqur@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(14, 'naureen.quayum', 'naureen.quayum@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(15, 'khairul.basher', 'khairul.basher@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(16, 'shareef', 'shareef@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(17, 'tanvir.husain', 'tanvir.husain@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(18, 'aneeq', 'aneeq@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(19, 'sizaman', 'sizaman@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39'),
(20, 'mehadi.ghani', 'mehadi.ghani@grameenphone.com', '$2y$10$fdv1XRqn//hMNR2TytXjcuHf2tennFhhjC4YuFDnR28eeH9.GNZ0.', '2', '2020-07-22 04:37:39', '2020-07-22 04:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `users_surveys`
--

CREATE TABLE `users_surveys` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `iux_users_email` (`email`);

--
-- Indexes for table `users_surveys`
--
ALTER TABLE `users_surveys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users_surveys`
--
ALTER TABLE `users_surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `answers_ibfk_3` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users_surveys`
--
ALTER TABLE `users_surveys`
  ADD CONSTRAINT `users_surveys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_surveys_ibfk_2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2020 at 01:51 PM
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
(20180303214313, 'InitialMigration', '2020-07-20 07:50:44', '2020-07-20 07:50:47', 0);

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
(1, 1, 'Office entry without ID card (Retina scan, proximity sensor etc.]', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(2, 1, 'Virtual personal assistant for every employees', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(3, 1, 'Deep Curated learning based on role, skill and aspiration', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(4, 1, 'Washroom clean-up based on censors', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(5, 1, 'Meeting minutes on voice command and sent to recipients', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(6, 1, 'Online employee community for different reference & recommendations', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(7, 1, 'Gamification in employee onboarding', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(8, 1, 'Gamification to cultivate collaboration', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(9, 1, 'Contextual rewards for employees', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(10, 1, 'Critical reminders through voice-overs', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(11, 1, 'AI driven eCommerce for employees', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(12, 1, 'Online support groups to share best practices & learning', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(13, 1, 'Office should be converted to communal facilities', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(14, 1, 'Eliminating hiring bias with AI', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(15, 1, 'Wearable tech to monitor Workplace health', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(16, 1, 'AI-based analytics tools to monitor meetings and emails overload', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(17, 1, 'Putting more focus on cognitive diversity in a Team', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(18, 1, 'AI based job suggestion pop-up', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(19, 1, 'An internal online platform where employees can invest their skills', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(20, 1, 'Git hub like software development platform', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(21, 1, 'Build AI chatbot', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(22, 1, 'Gamification of KPIs', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(23, 1, 'Holographic meeting room', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(24, 1, 'Smart integration of Collaboration, meassaging, ideation & learning tools', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(25, 1, 'Online tests and assessments', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(26, 1, 'Pulse survey tools', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(27, 1, 'Online gaming', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(28, 1, 'Modern ideation platforms', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(29, 1, 'having fluid teams and workers with broad skill sets', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(30, 1, 'Gamification For Goal Tracking', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(31, 1, 'Real time feedback and performance management tools', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(32, 1, 'Permenantly flexible future', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56'),
(33, 1, 'Full Digitalization B2B sales', 10, 10, 10, 10, 10, 10, '2020-07-20 13:50:56', '2020-07-20 13:50:56');

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
(1, 'Survey Number 01', '2020-07-20 13:50:52', '2020-07-20 13:50:52');

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
(1, 'Survey Admin', 'survey_admin@gmail.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '1', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(2, 'Survey User 01', 'survey_user_01@gmail.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(3, 'Survey User 02', 'survey_user_02@gmail.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(4, 'arifuddin', 'arifuddin@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(5, 'smhaque', 'smhaque@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(6, 'ejaz', 'ejaz@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(7, 'tkhan', 'tkhan@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(8, 'farhana.islam', 'farhana.islam@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(9, 'saiful_alam', 'saiful_alam@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(10, 'shaila.rahman', 'shaila.rahman@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(11, 'zahid_zaman', 'zahid_zaman@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(12, 'aem.saidur', 'aem.saidur@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(13, 'sanat', 'sanat@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(14, 'shabbir', 'shabbir@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(15, 'ashfaqur', 'ashfaqur@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(16, 'naureen.quayum', 'naureen.quayum@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(17, 'khairul.basher', 'khairul.basher@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(18, 'shareef', 'shareef@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(19, 'tanvir.husain', 'tanvir.husain@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(20, 'aneeq', 'aneeq@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(21, 'sizaman', 'sizaman@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00'),
(22, 'mehadi.ghani', 'mehadi.ghani@grameenphone.com', '$2y$10$SqB0CCuDAvLosIebikcGOeieM7JcARdmMM/Z6UDrmOVmowUv0lXFa', '2', '2020-07-20 13:51:00', '2020-07-20 13:51:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
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

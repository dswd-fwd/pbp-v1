-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 25, 2025 at 07:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dswd-pbp-v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_multiple` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `section_id`, `question_text`, `is_multiple`, `created_at`, `updated_at`) VALUES
(1, 1, 'In what type of building does the family reside?', 0, '2025-03-19 06:44:13', '2025-03-19 06:44:13'),
(6, 1, 'What type of construction materials are the roofs made of?', 0, '2025-03-19 06:52:12', '2025-03-19 06:52:12'),
(7, 1, 'What type of construction materials are the outer walls made of?', 0, '2025-03-19 06:53:03', '2025-03-19 06:53:03'),
(8, 1, 'What is the tenure status of the house and lot does the family have?', 0, '2025-03-19 06:53:47', '2025-03-19 06:53:47'),
(9, 1, ' What is your family’s main source of water supply?', 0, '2025-03-19 06:55:04', '2025-03-19 06:55:04'),
(10, 1, 'What is the main type of toilet facility the family uses?', 0, '2025-03-19 06:56:01', '2025-03-19 06:56:01'),
(11, 1, 'What is the main system of garbage disposal adopted by the family?', 0, '2025-03-19 06:56:56', '2025-03-19 06:56:56'),
(12, 1, 'What is the main source of electricity in the dwelling place?', 0, '2025-03-19 06:57:49', '2025-03-19 06:57:49'),
(32, 3, 'What is the health condition of the family members in the past six months? ', 0, '2025-03-20 06:13:41', '2025-03-20 06:13:41'),
(33, 3, 'Have the family members availed health services in the past 6 months? ', 0, '2025-03-20 06:14:13', '2025-03-20 06:14:13'),
(34, 3, 'What is the nutritional status of your family members?', 0, '2025-03-20 06:15:36', '2025-03-20 06:15:36'),
(35, 3, 'How does your family access food?', 0, '2025-03-20 06:16:10', '2025-03-20 06:16:10'),
(36, 3, 'In the past six months, how many times did your family experience hunger and not have anything to eat because of lack of money or other resources?', 0, '2025-03-20 06:16:47', '2025-03-20 06:16:47'),
(37, 3, 'In cases of pregnancies, where do women in the family give birth? Check all that applies:', 1, '2025-03-20 06:17:25', '2025-03-20 06:18:10'),
(38, 3, 'Where do the pregnant women in the family visit for pre and postnatal care? Check all that applies:', 1, '2025-03-20 06:18:18', '2025-03-20 06:18:23'),
(39, 3, 'Is there anyone in the family currently 19 years old or below and has either given birth or is pregnant? ', 0, '2025-03-20 06:19:08', '2025-03-20 06:19:08'),
(40, 3, 'Has any woman in the family died due to pregnancy?', 0, '2025-03-20 06:19:25', '2025-03-20 06:19:25'),
(41, 3, 'Has any child in the family below 5 years old died?', 0, '2025-03-20 06:19:40', '2025-03-20 06:19:40'),
(42, 3, 'Has any member of the family availed immunization? Check all that applies:', 1, '2025-03-20 06:19:54', '2025-03-20 06:20:06'),
(43, 3, 'Have any of the family members availed early childhood care and development services in the past 6 months? ', 0, '2025-03-20 06:20:51', '2025-03-20 06:20:51'),
(44, 3, 'Do you practice any family planning methods?', 0, '2025-03-20 06:23:03', '2025-03-20 06:23:03'),
(45, 3, 'What family planning methods do you use? Check all that applies:', 0, '2025-03-20 06:23:27', '2025-03-20 06:23:27'),
(46, 3, 'What are the reasons for not using any family planning method? Check all that applies:', 1, '2025-03-20 06:24:34', '2025-03-20 06:24:40'),
(47, 3, 'What are the burial practices in the family?', 0, '2025-03-20 06:25:14', '2025-03-20 06:25:14'),
(48, 4, 'How often do family members experience stress?', 0, '2025-03-20 06:54:27', '2025-03-20 06:54:27'),
(49, 4, 'How would you describe your family\'s access to mental health support?', 0, '2025-03-20 06:54:54', '2025-03-20 06:54:54'),
(50, 4, 'Are there any known mental health conditions in your family?', 0, '2025-03-20 06:55:17', '2025-03-20 06:55:17'),
(52, 4, 'How does your family cope with stress?', 0, '2025-03-20 06:55:47', '2025-03-20 06:55:47'),
(53, 4, 'How would you describe communication within your family?', 0, '2025-03-20 06:56:23', '2025-03-20 06:56:23'),
(54, 4, 'How often does your family engage in recreational activities?', 0, '2025-03-20 06:57:01', '2025-03-20 06:57:01'),
(55, 4, 'Does your family have access to recreational facilities?', 0, '2025-03-20 06:57:38', '2025-03-20 06:57:38'),
(56, 5, 'What educational resources does your family have access to? (Check all that apply)', 1, '2025-03-20 07:03:11', '2025-03-20 07:03:48'),
(57, 5, 'Do children in the family participate in school-based programs? (e.g., feeding programs, scholarships, extracurricular activities)', 0, '2025-03-20 07:03:55', '2025-03-20 07:03:55'),
(58, 5, 'Does your family receive educational assistance from the government or a non-government organization?', 0, '2025-03-20 07:04:10', '2025-03-20 07:04:10'),
(59, 5, 'Are there out-of-school youths (OSY) in your family?', 0, '2025-03-20 07:04:26', '2025-03-20 07:04:26'),
(60, 5, 'Does your family prioritize education as part of your goals?', 0, '2025-03-20 07:05:52', '2025-03-20 07:05:52'),
(61, 5, 'What are your family\'s educational aspirations for your children? (Check all that apply)', 1, '2025-03-20 07:06:18', '2025-03-20 07:06:29'),
(62, 6, 'How would you describe your family’s participation in the community?', 0, '2025-03-21 02:53:48', '2025-03-21 02:53:48'),
(63, 6, 'Does your family have any conflicts or issues with neighbors or community members?', 0, '2025-03-21 02:54:12', '2025-03-21 02:54:12'),
(64, 6, 'Who does your family rely on for social support? (Check all that apply)', 1, '2025-03-21 02:54:34', '2025-03-21 02:54:39'),
(65, 6, 'What social issues affect your family? (Check all that apply)', 1, '2025-03-21 02:55:14', '2025-03-21 02:55:18'),
(66, 7, 'Has the family experienced any natural disasters in the last 5 years? Check all that applies.', 1, '2025-03-21 03:05:56', '2025-03-21 03:06:01'),
(67, 7, 'Has the family experienced any human-induced hazards in the last 5 years?', 0, '2025-03-21 03:06:55', '2025-03-21 03:06:55'),
(68, 7, 'Has your family experienced forced displacement brought about by natural and human-induced disasters?', 0, '2025-03-21 03:07:32', '2025-03-21 03:07:32'),
(69, 7, 'Has any member of the family ever experienced any form of the following violence? Check all that applies.', 0, '2025-03-21 03:07:50', '2025-03-21 03:07:50'),
(75, 8, 'Does your family operate any small business or entrepreneurial activity?', 0, '2025-03-21 05:53:51', '2025-03-21 05:53:51'),
(76, 8, 'Do any family members engage in informal work (e.g., street vending, freelancing)?', 0, '2025-03-21 05:54:05', '2025-03-21 05:54:05'),
(78, 8, 'What barriers prevent your family from participating in economic activities? (Check all that apply)', 1, '2025-03-21 05:54:25', '2025-03-21 05:54:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_section_id_foreign` (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

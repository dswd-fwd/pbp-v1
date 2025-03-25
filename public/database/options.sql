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
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `option_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_other` int NOT NULL,
  `has_child` int NOT NULL,
  `is_multiple` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `has_other`, `has_child`, `is_multiple`, `created_at`, `updated_at`) VALUES
(1, 1, 'Single house', 0, 0, 0, '2025-03-19 06:46:06', '2025-03-19 06:46:06'),
(2, 1, 'Duplex', 0, 0, 0, '2025-03-19 06:46:13', '2025-03-19 06:46:13'),
(3, 1, 'Multi-unit residential', 0, 0, 0, '2025-03-19 06:46:19', '2025-03-19 06:46:19'),
(4, 1, 'Commercial/industrial/agricultural building (office, factory and others)', 0, 0, 0, '2025-03-19 06:46:25', '2025-03-19 06:46:25'),
(5, 1, 'Other housing unit (boat, cave, and others), specify', 1, 0, 0, '2025-03-19 06:46:35', '2025-03-19 06:46:35'),
(6, 6, 'Makeshift/salvaged/improvised materials', 0, 0, 0, '2025-03-19 06:52:22', '2025-03-19 06:52:22'),
(7, 6, 'Mixed but predominantly makeshift/salvaged/improvised materials', 0, 0, 0, '2025-03-19 06:52:28', '2025-03-19 06:52:28'),
(8, 6, 'Light materials such as bamboo/sawali/ cogon/ nipa but not sturdy and durable', 0, 0, 0, '2025-03-19 06:52:34', '2025-03-19 06:52:34'),
(9, 6, 'Mixed but predominantly light materials', 0, 0, 0, '2025-03-19 06:52:38', '2025-03-19 06:52:38'),
(10, 6, 'Strong materials such as concrete/brick/ stone or wood or half galvanized iron and half concrete or galvanized iron/aluminum or glass', 0, 0, 0, '2025-03-19 06:52:43', '2025-03-19 06:52:43'),
(11, 6, 'Bamboo/ sawali/cogon /nipa but sturdy and durable', 0, 0, 0, '2025-03-19 06:52:48', '2025-03-19 06:52:48'),
(12, 7, 'Makeshift/salvaged/improvised materials', 0, 0, 0, '2025-03-19 06:53:09', '2025-03-19 06:53:09'),
(13, 7, 'Mixed but predominantly makeshift/salvaged/improvised materials', 0, 0, 0, '2025-03-19 06:53:14', '2025-03-19 06:53:14'),
(14, 7, 'Light materials such as bamboo/sawali/ cogon/ nipa but not sturdy and durable', 0, 0, 0, '2025-03-19 06:53:19', '2025-03-19 06:53:19'),
(15, 7, 'Mixed but predominantly light materials', 0, 0, 0, '2025-03-19 06:53:25', '2025-03-19 06:53:25'),
(16, 7, 'Strong materials such as concrete/brick/ stone or wood or half galvanized iron and half concrete or galvanized iron/aluminum or glass', 0, 0, 0, '2025-03-19 06:53:32', '2025-03-19 06:53:32'),
(17, 7, 'Bamboo/ sawali/cogon /nipa but sturdy and durable', 0, 0, 0, '2025-03-19 06:53:37', '2025-03-19 06:53:37'),
(18, 8, 'Own house and lot', 0, 0, 0, '2025-03-19 06:53:55', '2025-03-19 06:53:55'),
(19, 8, 'Own house, rent-free lot without consent of owner', 0, 0, 0, '2025-03-19 06:54:00', '2025-03-19 06:54:00'),
(20, 8, 'Own house, rent-free lot with consent of owner', 0, 0, 0, '2025-03-19 06:54:04', '2025-03-19 06:54:04'),
(21, 8, 'Rent-free house and lot without consent of owner', 0, 0, 0, '2025-03-19 06:54:09', '2025-03-19 06:54:09'),
(22, 8, 'Rent-free house and lot with consent of owner', 0, 0, 0, '2025-03-19 06:54:13', '2025-03-19 06:54:13'),
(23, 8, 'Rented house and lot for less than three years', 0, 0, 0, '2025-03-19 06:54:17', '2025-03-19 06:54:17'),
(24, 8, 'Own house, rented lot for less than three years', 0, 0, 0, '2025-03-19 06:54:23', '2025-03-19 06:54:23'),
(25, 8, 'Other tenure status, specify:', 1, 0, 0, '2025-03-19 06:54:31', '2025-03-19 06:54:31'),
(26, 9, 'Unprotected spring, lake, river, rain, dug well', 0, 0, 0, '2025-03-19 06:55:11', '2025-03-19 06:55:11'),
(27, 9, 'Commercial sources, e.g., tanker, truck, peddler (except bottled water)', 0, 0, 0, '2025-03-19 06:55:15', '2025-03-19 06:55:15'),
(28, 9, 'Source of safe drinking water but the time to collect water including the time to walk to the water source, collect it and return is longer than 30 minutes', 0, 0, 0, '2025-03-19 06:55:21', '2025-03-19 06:55:21'),
(29, 9, 'Own use faucet community water system (gripo)', 0, 0, 0, '2025-03-19 06:55:26', '2025-03-19 06:55:26'),
(30, 9, 'Shared faucet community water system', 0, 0, 0, '2025-03-19 06:55:30', '2025-03-19 06:55:30'),
(31, 9, 'Own use tubed/piped deep well', 0, 0, 0, '2025-03-19 06:55:34', '2025-03-19 06:55:34'),
(32, 9, 'Shared tubed/ piped deep well, tubed/piped shallow well', 0, 0, 0, '2025-03-19 06:55:39', '2025-03-19 06:55:39'),
(33, 9, 'Bought bottled water including those being delivered', 0, 0, 0, '2025-03-19 06:55:44', '2025-03-19 06:55:44'),
(34, 9, 'Others, specify', 1, 0, 0, '2025-03-19 06:55:54', '2025-03-19 06:55:54'),
(35, 10, 'Water-sealed, sewer septic tank, used exclusively by the family', 0, 0, 0, '2025-03-19 06:56:08', '2025-03-19 06:56:08'),
(36, 10, 'Water-sealed, sewer septic tank, shared with other families ', 0, 0, 0, '2025-03-19 06:56:13', '2025-03-19 06:56:13'),
(37, 10, 'Closed pit', 0, 0, 0, '2025-03-19 06:56:18', '2025-03-19 06:56:18'),
(38, 10, 'Open pit', 0, 0, 0, '2025-03-19 06:56:22', '2025-03-19 06:56:22'),
(40, 10, 'Others (pail system, and others), specify:', 1, 0, 0, '2025-03-19 06:56:46', '2025-03-19 06:56:46'),
(41, 10, 'None', 0, 0, 0, '2025-03-19 06:56:49', '2025-03-19 06:56:49'),
(42, 11, 'Garbage collection', 0, 0, 0, '2025-03-19 06:57:02', '2025-03-19 06:57:02'),
(43, 11, 'Burning', 0, 0, 0, '2025-03-19 06:57:07', '2025-03-19 06:57:07'),
(44, 11, 'Composting', 0, 0, 0, '2025-03-19 06:57:10', '2025-03-19 06:57:10'),
(45, 11, 'Recycling', 0, 0, 0, '2025-03-19 06:57:14', '2025-03-19 06:57:14'),
(46, 11, 'Waste Segregation', 0, 0, 0, '2025-03-19 06:57:18', '2025-03-19 06:57:18'),
(47, 11, 'Pit with cover', 0, 0, 0, '2025-03-19 06:57:22', '2025-03-19 06:57:22'),
(48, 11, 'Pit without cover ', 0, 0, 0, '2025-03-19 06:57:26', '2025-03-19 06:57:26'),
(49, 11, 'Throwing of garbage in rivers, vacant lots, etc.', 0, 0, 0, '2025-03-19 06:57:30', '2025-03-19 06:57:30'),
(50, 11, 'Others, specify:', 1, 0, 0, '2025-03-19 06:57:38', '2025-03-19 06:57:38'),
(51, 12, 'Electric company', 0, 0, 0, '2025-03-19 06:57:55', '2025-03-19 06:57:55'),
(52, 12, 'Generator', 0, 0, 0, '2025-03-19 06:58:02', '2025-03-19 06:58:02'),
(53, 12, 'Solar', 0, 0, 0, '2025-03-19 06:58:07', '2025-03-19 06:58:07'),
(54, 12, 'Battery', 0, 0, 0, '2025-03-19 06:58:10', '2025-03-19 06:58:10'),
(55, 12, 'Others, specify:', 1, 0, 0, '2025-03-19 06:58:18', '2025-03-19 06:58:18'),
(56, 12, 'None', 0, 0, 0, '2025-03-19 06:58:23', '2025-03-19 06:58:23'),
(147, 32, 'At least one family member got sick of an illness needing hospital confinement.', 0, 0, 0, '2025-03-20 06:13:55', '2025-03-20 06:13:55'),
(148, 32, 'At least one family member got sick of an illness needing medical attention (diarrhea, high fever, etc.) but did not need hospital confinement.', 0, 0, 0, '2025-03-20 06:14:01', '2025-03-20 06:14:01'),
(149, 32, 'No family member got sick of an illness needing medical attention or confinement (other than ordinary headaches, colds, etc.)', 0, 0, 0, '2025-03-20 06:14:05', '2025-03-20 06:14:05'),
(150, 33, 'Yes. ', 0, 1, 0, '2025-03-20 06:14:40', '2025-03-20 06:14:40'),
(151, 33, 'No. The family did not avail health services in the past 6 months. Cite reasons (check all that applies):', 0, 1, 1, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(152, 34, 'All family members are healthy.', 0, 0, 0, '2025-03-20 06:15:54', '2025-03-20 06:15:54'),
(153, 34, 'Some members of the family are malnourished/overweight/underweight.', 0, 0, 0, '2025-03-20 06:15:59', '2025-03-20 06:15:59'),
(154, 34, 'All family members are malnourished/overweight/underweight.', 0, 0, 0, '2025-03-20 06:16:04', '2025-03-20 06:16:04'),
(155, 35, 'We purchase our own food.', 0, 0, 0, '2025-03-20 06:16:16', '2025-03-20 06:16:16'),
(156, 35, 'We grow our own food (e.g., bac', 0, 0, 0, '2025-03-20 06:16:21', '2025-03-20 06:16:21'),
(157, 35, 'We rely on food assistance programs.', 0, 0, 0, '2025-03-20 06:16:26', '2025-03-20 06:16:26'),
(158, 35, 'We have no secured access to a food supply.', 0, 0, 0, '2025-03-20 06:16:29', '2025-03-20 06:16:29'),
(159, 36, 'Always (more than 30 times in the last 6 months)', 0, 0, 0, '2025-03-20 06:17:00', '2025-03-20 06:17:00'),
(160, 36, 'Oftentimes (10-30 times in the last 6 months)', 0, 0, 0, '2025-03-20 06:17:03', '2025-03-20 06:17:03'),
(161, 36, 'A few times (3-9 times in the last 6 months)', 0, 0, 0, '2025-03-20 06:17:07', '2025-03-20 06:17:07'),
(162, 36, 'Rarely (1-2 times in the last 6 months)', 0, 0, 0, '2025-03-20 06:17:10', '2025-03-20 06:17:10'),
(163, 36, 'Never', 0, 0, 0, '2025-03-20 06:17:12', '2025-03-20 06:17:12'),
(164, 37, 'Not Applicable', 0, 0, 0, '2025-03-20 06:17:31', '2025-03-20 06:17:31'),
(165, 37, 'Own home', 0, 0, 0, '2025-03-20 06:17:35', '2025-03-20 06:17:35'),
(166, 37, 'Other home', 0, 0, 0, '2025-03-20 06:17:38', '2025-03-20 06:17:38'),
(167, 37, 'Government hospital', 0, 0, 0, '2025-03-20 06:17:41', '2025-03-20 06:17:41'),
(168, 37, 'Rural/Urban health center / Public Lying Inn', 0, 0, 0, '2025-03-20 06:17:46', '2025-03-20 06:17:46'),
(169, 37, 'Barangay Health Station', 0, 0, 0, '2025-03-20 06:17:49', '2025-03-20 06:17:49'),
(170, 37, 'Private Hospital/Clinic/Lying Inn', 0, 0, 0, '2025-03-20 06:17:53', '2025-03-20 06:17:53'),
(171, 37, 'Industry-based Clinic', 0, 0, 0, '2025-03-20 06:17:56', '2025-03-20 06:17:56'),
(172, 37, 'Others, specify', 1, 0, 0, '2025-03-20 06:18:06', '2025-03-20 06:18:06'),
(173, 38, 'None', 0, 0, 0, '2025-03-20 06:18:33', '2025-03-20 06:18:33'),
(174, 38, 'Government Hospital', 0, 0, 0, '2025-03-20 06:18:37', '2025-03-20 06:18:37'),
(175, 38, 'Rural/Urban health center / Public Lying Inn', 0, 0, 0, '2025-03-20 06:18:41', '2025-03-20 06:18:41'),
(176, 38, 'Barangay Health Station', 0, 0, 0, '2025-03-20 06:18:44', '2025-03-20 06:18:44'),
(177, 38, 'Private Hospital/Clinic/Lying Inn', 0, 0, 0, '2025-03-20 06:18:47', '2025-03-20 06:18:47'),
(178, 38, 'Traditional healers i.e. hilot ', 0, 0, 0, '2025-03-20 06:18:51', '2025-03-20 06:18:51'),
(179, 38, 'Others, specify:', 1, 0, 0, '2025-03-20 06:19:01', '2025-03-20 06:19:01'),
(180, 39, 'Yes', 0, 0, 0, '2025-03-20 06:19:15', '2025-03-20 06:19:15'),
(181, 39, 'No', 0, 0, 0, '2025-03-20 06:19:19', '2025-03-20 06:19:19'),
(182, 40, 'Yes', 0, 0, 0, '2025-03-20 06:19:30', '2025-03-20 06:19:30'),
(183, 40, 'No', 0, 0, 0, '2025-03-20 06:19:33', '2025-03-20 06:19:33'),
(184, 41, 'Yes', 0, 0, 0, '2025-03-20 06:19:44', '2025-03-20 06:19:44'),
(185, 41, 'No', 0, 0, 0, '2025-03-20 06:19:47', '2025-03-20 06:19:47'),
(186, 42, 'None', 0, 0, 0, '2025-03-20 06:20:08', '2025-03-20 06:20:08'),
(187, 42, 'BCG birth dose', 0, 0, 0, '2025-03-20 06:20:11', '2025-03-20 06:20:11'),
(188, 42, 'Tetanus Toxoid', 0, 0, 0, '2025-03-20 06:20:14', '2025-03-20 06:20:14'),
(189, 42, 'Oral Poliovirus', 0, 0, 0, '2025-03-20 06:20:18', '2025-03-20 06:20:18'),
(190, 42, 'Pentavalent', 0, 0, 0, '2025-03-20 06:20:21', '2025-03-20 06:20:21'),
(191, 42, 'Hepatitis B birth dose', 0, 0, 0, '2025-03-20 06:20:25', '2025-03-20 06:20:25'),
(192, 42, 'Antimeasles, Mumps, Rubella', 0, 0, 0, '2025-03-20 06:20:28', '2025-03-20 06:20:28'),
(193, 42, 'Pneumococcal', 0, 0, 0, '2025-03-20 06:20:32', '2025-03-20 06:20:32'),
(194, 42, 'Anti Flu', 0, 0, 0, '2025-03-20 06:20:35', '2025-03-20 06:20:35'),
(195, 42, 'Covid 19', 0, 0, 0, '2025-03-20 06:20:38', '2025-03-20 06:20:38'),
(196, 42, 'Others, specify', 1, 0, 0, '2025-03-20 06:20:42', '2025-03-20 06:20:42'),
(197, 43, 'Yes.', 0, 1, 1, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(198, 43, 'No.', 0, 1, 1, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(199, 44, 'Yes (Proceed to question 14)', 0, 0, 0, '2025-03-20 06:23:14', '2025-03-20 06:23:14'),
(200, 44, 'No (Proceed to question 15)', 0, 0, 0, '2025-03-20 06:23:19', '2025-03-20 06:23:19'),
(201, 45, 'Female Sterilization', 0, 0, 0, '2025-03-20 06:23:32', '2025-03-20 06:23:32'),
(202, 45, 'Male Sterilization', 0, 0, 0, '2025-03-20 06:23:36', '2025-03-20 06:23:36'),
(203, 45, 'Oral contraceptive pills', 0, 0, 0, '2025-03-20 06:23:39', '2025-03-20 06:23:39'),
(204, 45, 'Implants', 0, 0, 0, '2025-03-20 06:23:42', '2025-03-20 06:23:42'),
(205, 45, 'Injectables', 0, 0, 0, '2025-03-20 06:23:45', '2025-03-20 06:23:45'),
(206, 45, 'Patches', 0, 0, 0, '2025-03-20 06:23:48', '2025-03-20 06:23:48'),
(207, 45, 'Vaginal rings', 0, 0, 0, '2025-03-20 06:23:52', '2025-03-20 06:23:52'),
(208, 45, 'Intra- uterine devices', 0, 0, 0, '2025-03-20 06:23:55', '2025-03-20 06:23:55'),
(209, 45, 'Condoms', 0, 0, 0, '2025-03-20 06:23:58', '2025-03-20 06:23:58'),
(210, 45, 'Withdrawal', 0, 0, 0, '2025-03-20 06:24:00', '2025-03-20 06:24:00'),
(211, 45, 'Calendar/Rhythm/Periodic Abstinence', 0, 0, 0, '2025-03-20 06:24:06', '2025-03-20 06:24:06'),
(212, 45, 'Basal Body Temperature', 0, 0, 0, '2025-03-20 06:24:10', '2025-03-20 06:24:10'),
(213, 45, 'Cultural Practices, specify:', 1, 0, 0, '2025-03-20 06:24:20', '2025-03-20 06:24:20'),
(214, 45, 'Other methods, specify:', 1, 0, 0, '2025-03-20 06:24:27', '2025-03-20 06:24:27'),
(215, 46, 'Planning to have a baby', 0, 0, 0, '2025-03-20 06:24:42', '2025-03-20 06:24:42'),
(216, 46, 'Lack of information', 0, 0, 0, '2025-03-20 06:24:46', '2025-03-20 06:24:46'),
(217, 46, 'Opposition by partners or families', 0, 0, 0, '2025-03-20 06:24:49', '2025-03-20 06:24:49'),
(218, 46, 'Opposition by community tribal leaders', 0, 0, 0, '2025-03-20 06:24:52', '2025-03-20 06:24:52'),
(219, 46, 'Against cultural belief or customary practices', 0, 0, 0, '2025-03-20 06:24:55', '2025-03-20 06:24:55'),
(220, 46, 'Discomfort in the use of barriers during sexual act', 0, 0, 0, '2025-03-20 06:24:58', '2025-03-20 06:24:58'),
(221, 46, 'Risk of producing an unwanted pregnancy adds flavor to the sexual act', 0, 0, 0, '2025-03-20 06:25:01', '2025-03-20 06:25:01'),
(222, 46, 'Others, specify:', 1, 0, 0, '2025-03-20 06:25:07', '2025-03-20 06:25:07'),
(223, 47, 'Natural/green burial (Bodies are buried in a shroud or biodegradable caskets made of wood, bamboo or cardboard)', 0, 0, 0, '2025-03-20 06:25:21', '2025-03-20 06:25:21'),
(224, 47, 'Embalming or mummification', 0, 0, 0, '2025-03-20 06:25:24', '2025-03-20 06:25:24'),
(225, 47, 'Use of containers for the dead, such as shrouds, coffins, grave liners, and burial vaults, all of which can slow decomposition of the body', 0, 0, 0, '2025-03-20 06:25:28', '2025-03-20 06:25:28'),
(226, 47, 'Buried in the mountains ', 0, 0, 0, '2025-03-20 06:25:31', '2025-03-20 06:25:31'),
(227, 47, 'Burial grounds near their residences', 0, 0, 0, '2025-03-20 06:25:35', '2025-03-20 06:25:35'),
(228, 47, 'Cemeteries in which casketed or cremated remains are buried in the ground', 0, 0, 0, '2025-03-20 06:25:39', '2025-03-20 06:25:39'),
(229, 47, 'Above-Ground Entombment', 0, 0, 0, '2025-03-20 06:25:42', '2025-03-20 06:25:42'),
(231, 47, 'In-Ground Burial', 0, 0, 0, '2025-03-20 06:25:51', '2025-03-20 06:25:51'),
(232, 47, 'Mausoleum', 0, 0, 0, '2025-03-20 06:25:55', '2025-03-20 06:25:55'),
(233, 47, 'Hand-carved coffins that are tied or nailed to the side of a cliff and suspended high above the ground below', 0, 0, 0, '2025-03-20 06:26:01', '2025-03-20 06:26:01'),
(234, 47, 'Others, specify:', 1, 0, 0, '2025-03-20 06:26:07', '2025-03-20 06:26:07'),
(235, 48, 'Rarely experience stress', 0, 0, 0, '2025-03-20 06:54:33', '2025-03-20 06:54:33'),
(236, 48, 'Occasionally stressed but manage well', 0, 0, 0, '2025-03-20 06:54:37', '2025-03-20 06:54:37'),
(237, 48, 'Frequently stressed, affecting daily activities', 0, 0, 0, '2025-03-20 06:54:42', '2025-03-20 06:54:42'),
(238, 48, 'Constant, severe stress across multiple family members', 0, 0, 0, '2025-03-20 06:54:45', '2025-03-20 06:54:45'),
(239, 49, 'Regular access to mental health professionals or support groups', 0, 0, 0, '2025-03-20 06:55:00', '2025-03-20 06:55:00'),
(240, 49, 'Occasional access, limited by cost or location', 0, 0, 0, '2025-03-20 06:55:03', '2025-03-20 06:55:03'),
(241, 49, 'Rare access, mainly informal or community-based', 0, 0, 0, '2025-03-20 06:55:06', '2025-03-20 06:55:06'),
(242, 49, 'No access to mental health support', 0, 0, 0, '2025-03-20 06:55:10', '2025-03-20 06:55:10'),
(243, 50, 'No known mental health conditions', 0, 0, 0, '2025-03-20 06:55:28', '2025-03-20 06:55:28'),
(244, 50, 'One family member diagnosed, receiving treatment', 0, 0, 0, '2025-03-20 06:55:32', '2025-03-20 06:55:32'),
(245, 50, 'One or more members diagnosed but not receiving adequate care', 0, 0, 0, '2025-03-20 06:55:37', '2025-03-20 06:55:37'),
(246, 50, 'Multiple members with untreated mental health issues', 0, 0, 0, '2025-03-20 06:55:41', '2025-03-20 06:55:41'),
(247, 52, 'Uses healthy coping strategies (e.g., communication, relaxation techniques)', 0, 0, 0, '2025-03-20 06:55:53', '2025-03-20 06:55:53'),
(248, 52, 'Sometimes relies on unhealthy coping mechanisms (e.g., alcohol, smoking)', 0, 0, 0, '2025-03-20 06:55:57', '2025-03-20 06:55:57'),
(249, 52, 'Significantly relies on unhealthy behaviors to cope', 0, 0, 0, '2025-03-20 06:56:01', '2025-03-20 06:56:01'),
(250, 52, 'No evident coping mechanisms, leading to conflict or dysfunction', 0, 0, 0, '2025-03-20 06:56:05', '2025-03-20 06:56:05'),
(251, 53, 'Open and supportive communication', 0, 0, 0, '2025-03-20 06:56:28', '2025-03-20 06:56:28'),
(252, 53, 'Communication is present but inconsistent', 0, 0, 0, '2025-03-20 06:56:32', '2025-03-20 06:56:32'),
(253, 53, 'Communication issues cause occasional conflicts', 0, 0, 0, '2025-03-20 06:56:36', '2025-03-20 06:56:36'),
(254, 53, 'Severe communication breakdown leads to frequent conflicts', 0, 0, 0, '2025-03-20 06:56:40', '2025-03-20 06:56:40'),
(255, 54, 'Regularly (e.g., sports, outings, shared hobbies)', 0, 0, 0, '2025-03-20 06:57:12', '2025-03-20 06:57:12'),
(256, 54, 'Occasionally', 0, 0, 0, '2025-03-20 06:57:18', '2025-03-20 06:57:18'),
(257, 54, 'Rarely', 0, 0, 0, '2025-03-20 06:57:23', '2025-03-20 06:57:23'),
(258, 54, 'Never', 0, 0, 0, '2025-03-20 06:57:27', '2025-03-20 06:57:27'),
(259, 55, 'Easy access to safe recreational spaces (e.g., parks, sports facilities)', 0, 0, 0, '2025-03-20 06:57:44', '2025-03-20 06:57:44'),
(260, 55, 'Limited access due to cost, location, or availability', 0, 0, 0, '2025-03-20 06:57:49', '2025-03-20 06:57:49'),
(261, 55, 'Rare access, facilities are far or poorly maintained', 0, 0, 0, '2025-03-20 06:57:52', '2025-03-20 06:57:52'),
(262, 55, 'No access to recreational facilities', 0, 0, 0, '2025-03-20 06:57:56', '2025-03-20 06:57:56'),
(263, 56, 'Books', 0, 0, 0, '2025-03-20 07:03:20', '2025-03-20 07:03:20'),
(264, 56, 'Notebooks and school supplies', 0, 0, 0, '2025-03-20 07:03:24', '2025-03-20 07:03:24'),
(265, 56, 'Internet', 0, 0, 0, '2025-03-20 07:03:28', '2025-03-20 07:03:28'),
(266, 56, 'Gadgets for online learning (e.g., laptop, tablet, smartphone)', 0, 0, 0, '2025-03-20 07:03:31', '2025-03-20 07:03:31'),
(267, 56, 'Learning modules from schools', 0, 0, 0, '2025-03-20 07:03:35', '2025-03-20 07:03:35'),
(268, 56, 'Tutorial services', 0, 0, 0, '2025-03-20 07:03:38', '2025-03-20 07:03:38'),
(269, 56, 'None at all', 0, 0, 0, '2025-03-20 07:03:43', '2025-03-20 07:03:43'),
(270, 57, 'Yes', 0, 0, 0, '2025-03-20 07:04:00', '2025-03-20 07:04:00'),
(271, 57, 'No', 0, 0, 0, '2025-03-20 07:04:03', '2025-03-20 07:04:03'),
(272, 58, 'Yes', 0, 0, 0, '2025-03-20 07:04:15', '2025-03-20 07:04:15'),
(273, 58, 'No', 0, 0, 0, '2025-03-20 07:04:19', '2025-03-20 07:04:19'),
(274, 59, 'No', 0, 0, 0, '2025-03-20 07:04:42', '2025-03-20 07:04:42'),
(275, 59, 'Yes, due to:', 0, 1, 1, '2025-03-20 07:05:41', '2025-03-20 07:05:41'),
(276, 60, 'No', 0, 0, 0, '2025-03-20 07:06:07', '2025-03-20 07:06:07'),
(277, 60, 'Yes, because:', 1, 0, 0, '2025-03-20 07:06:12', '2025-03-20 07:06:12'),
(278, 61, 'Complete a Bachelor\'s Degree', 0, 0, 0, '2025-03-20 07:06:29', '2025-03-20 07:06:29'),
(279, 61, 'Finish High School/Senior High', 0, 0, 0, '2025-03-20 07:06:33', '2025-03-20 07:06:33'),
(280, 61, 'Take Technical/Vocational Courses', 0, 0, 0, '2025-03-20 07:06:38', '2025-03-20 07:06:38'),
(281, 61, 'Enroll in Alternative Learning System (ALS)', 0, 0, 0, '2025-03-20 07:06:42', '2025-03-20 07:06:42'),
(282, 61, 'Others:', 1, 0, 0, '2025-03-20 07:06:50', '2025-03-20 07:06:50'),
(283, 62, 'Active and engaged', 0, 0, 0, '2025-03-21 02:53:54', '2025-03-21 02:53:54'),
(284, 62, 'Neutral/occasionally participates', 0, 0, 0, '2025-03-21 02:53:58', '2025-03-21 02:53:58'),
(285, 62, 'Isolated/limited engagement', 0, 0, 0, '2025-03-21 02:54:01', '2025-03-21 02:54:01'),
(286, 63, 'No', 0, 0, 0, '2025-03-21 02:54:19', '2025-03-21 02:54:19'),
(287, 63, 'Yes, please specify:', 1, 0, 0, '2025-03-21 02:54:26', '2025-03-21 02:54:26'),
(288, 64, 'Extended family', 0, 0, 0, '2025-03-21 02:54:48', '2025-03-21 02:54:48'),
(289, 64, 'Community leaders', 0, 0, 0, '2025-03-21 02:54:51', '2025-03-21 02:54:51'),
(290, 64, 'Others:', 1, 0, 0, '2025-03-21 02:55:01', '2025-03-21 02:55:01'),
(291, 64, 'None at all', 0, 0, 0, '2025-03-21 02:55:05', '2025-03-21 02:55:05'),
(292, 65, 'Domestic violence', 0, 0, 0, '2025-03-21 02:55:24', '2025-03-21 02:55:24'),
(293, 65, 'Substance abuse', 0, 0, 0, '2025-03-21 02:55:26', '2025-03-21 02:55:26'),
(294, 65, 'Child labor', 0, 0, 0, '2025-03-21 02:55:29', '2025-03-21 02:55:29'),
(295, 65, 'Early marriage or union', 0, 0, 0, '2025-03-21 02:55:32', '2025-03-21 02:55:32'),
(296, 65, 'Unemployment', 0, 0, 0, '2025-03-21 02:55:36', '2025-03-21 02:55:36'),
(297, 65, 'Bullying (in school or community)', 0, 0, 0, '2025-03-21 02:55:39', '2025-03-21 02:55:39'),
(298, 65, 'Discrimination (e.g., gender, ethnicity, religion, disability)', 0, 0, 0, '2025-03-21 02:55:42', '2025-03-21 02:55:42'),
(299, 65, 'Others:', 1, 0, 0, '2025-03-21 02:55:47', '2025-03-21 02:55:47'),
(300, 66, 'None', 0, 0, 0, '2025-03-21 03:06:06', '2025-03-21 03:06:06'),
(301, 66, 'Drought', 0, 0, 0, '2025-03-21 03:06:10', '2025-03-21 03:06:10'),
(302, 66, 'Flooding', 0, 0, 0, '2025-03-21 03:06:13', '2025-03-21 03:06:13'),
(303, 66, 'Earthquake', 0, 0, 0, '2025-03-21 03:06:16', '2025-03-21 03:06:16'),
(304, 66, 'Volcanic eruptions', 0, 0, 0, '2025-03-21 03:06:19', '2025-03-21 03:06:19'),
(305, 66, 'Typhoon', 0, 0, 0, '2025-03-21 03:06:22', '2025-03-21 03:06:22'),
(306, 66, 'Landslide', 0, 0, 0, '2025-03-21 03:06:25', '2025-03-21 03:06:25'),
(307, 66, 'Tsunami', 0, 0, 0, '2025-03-21 03:06:27', '2025-03-21 03:06:27'),
(308, 66, 'Storm Surge', 0, 0, 0, '2025-03-21 03:06:31', '2025-03-21 03:06:31'),
(309, 66, 'Others, specify:', 1, 0, 0, '2025-03-21 03:06:37', '2025-03-21 03:06:37'),
(310, 67, 'None', 0, 0, 0, '2025-03-21 03:07:00', '2025-03-21 03:07:00'),
(311, 67, 'Armed-conflict', 0, 0, 0, '2025-03-21 03:07:02', '2025-03-21 03:07:02'),
(312, 67, 'Crime', 0, 0, 0, '2025-03-21 03:07:05', '2025-03-21 03:07:05'),
(313, 67, 'Arson', 0, 0, 0, '2025-03-21 03:07:08', '2025-03-21 03:07:08'),
(314, 67, 'Cyber-attacks', 0, 0, 0, '2025-03-21 03:07:14', '2025-03-21 03:07:14'),
(315, 67, 'Accidents', 0, 0, 0, '2025-03-21 03:07:17', '2025-03-21 03:07:17'),
(316, 67, 'Others, specify:', 1, 0, 0, '2025-03-21 03:07:24', '2025-03-21 03:07:24'),
(317, 68, 'Yes', 0, 0, 0, '2025-03-21 03:07:39', '2025-03-21 03:07:39'),
(318, 68, 'No', 0, 0, 0, '2025-03-21 03:07:43', '2025-03-21 03:07:43'),
(319, 69, 'Yes.', 0, 1, 1, '2025-03-21 03:08:43', '2025-03-21 03:08:43'),
(320, 69, 'No.', 0, 0, 0, '2025-03-21 03:08:49', '2025-03-21 03:08:49'),
(321, 69, 'Prefer not to say', 0, 0, 0, '2025-03-21 03:08:53', '2025-03-21 03:08:53'),
(337, 75, 'Yes', 0, 0, 0, '2025-03-21 05:53:55', '2025-03-21 05:53:55'),
(338, 75, 'No', 0, 0, 0, '2025-03-21 05:53:59', '2025-03-21 05:53:59'),
(339, 76, 'Yes', 0, 0, 0, '2025-03-21 05:54:14', '2025-03-21 05:54:14'),
(340, 76, 'No', 0, 0, 0, '2025-03-21 05:54:15', '2025-03-21 05:54:15'),
(341, 78, 'Lack of job opportunities', 0, 0, 0, '2025-03-21 05:54:33', '2025-03-21 05:54:33'),
(342, 78, 'Limited skills or education', 0, 0, 0, '2025-03-21 05:54:36', '2025-03-21 05:54:36'),
(343, 78, 'Health issues or disability', 0, 0, 0, '2025-03-21 05:54:40', '2025-03-21 05:54:40'),
(344, 78, 'Household responsibilities', 0, 0, 0, '2025-03-21 05:54:43', '2025-03-21 05:54:43'),
(345, 78, 'Lack of capital for business', 0, 0, 0, '2025-03-21 05:54:47', '2025-03-21 05:54:47'),
(346, 78, 'Lack of access to transportation', 0, 0, 0, '2025-03-21 05:54:50', '2025-03-21 05:54:50'),
(347, 78, 'Others', 1, 0, 0, '2025-03-21 05:55:01', '2025-03-21 05:55:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_question_id_foreign` (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=348;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

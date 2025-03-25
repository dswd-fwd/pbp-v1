-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 25, 2025 at 07:36 AM
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
-- Table structure for table `sub_options`
--

CREATE TABLE `sub_options` (
  `id` bigint UNSIGNED NOT NULL,
  `option_id` bigint UNSIGNED NOT NULL,
  `sub_option_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_other` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_options`
--

INSERT INTO `sub_options` (`id`, `option_id`, `sub_option_text`, `has_other`, `created_at`, `updated_at`) VALUES
(40, 150, 'What health services availed? ', 1, '2025-03-20 06:14:40', '2025-03-20 06:14:40'),
(41, 150, 'The family members did not avail at all in the past 6 months but went instead to health service providers that are not professionally trained, like albularyo, hilot, etc.', 0, '2025-03-20 06:14:40', '2025-03-20 06:14:40'),
(42, 151, 'Poor health facilities', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(43, 151, 'Inadequate health practitioners', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(44, 151, 'Seldom in the availability of health practitioner', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(45, 151, 'Inadequate supplies of medicine or other medical supplies', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(46, 151, 'Poor client services were being offered, e.g., long queues,discourteous personnel, etc.', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(47, 151, 'Distance from health facilities', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(48, 151, 'Expensive cost of services', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(49, 151, 'Against cultural belief or customary practices', 0, '2025-03-20 06:15:29', '2025-03-20 06:15:29'),
(50, 197, 'Child Minding Services', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(51, 197, 'Day Care Services / ECCD', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(52, 197, 'Supplementary Feeding', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(53, 197, 'Home-based program (supervised neighborhood play, parent education, home visiting programs) ', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(54, 197, 'School supplies', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(55, 197, 'Health and nutrition services (deworming, dental/health check-up, provision of vitamins, etc.)', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(56, 197, 'Psychosocial intervention', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(57, 197, 'Referral to health, education and social services', 0, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(58, 197, 'Others, specify:', 1, '2025-03-20 06:22:02', '2025-03-20 06:22:02'),
(59, 198, 'Inadequate ECCD facilities', 0, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(60, 198, 'Inaccessible ECCD facilities', 0, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(61, 198, 'Against cultural belief or customary practices', 0, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(62, 198, 'Inadequate school supplies', 0, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(63, 198, 'Poor client services were being offered, e.g., long queues,discourteous personnel, etc.', 0, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(64, 198, 'Others, specify:', 1, '2025-03-20 06:22:53', '2025-03-20 06:22:53'),
(65, 275, 'Financial constraints', 0, '2025-03-20 07:05:41', '2025-03-20 07:05:41'),
(66, 275, 'Lack of interest', 0, '2025-03-20 07:05:41', '2025-03-20 07:05:41'),
(67, 275, 'Early marriage', 0, '2025-03-20 07:05:41', '2025-03-20 07:05:41'),
(68, 275, 'Peer influence', 0, '2025-03-20 07:05:41', '2025-03-20 07:05:41'),
(69, 275, 'Others:', 1, '2025-03-20 07:05:41', '2025-03-20 07:05:41'),
(70, 319, 'Physical', 0, '2025-03-21 03:08:43', '2025-03-21 03:08:43'),
(71, 319, 'Sexual', 0, '2025-03-21 03:08:43', '2025-03-21 03:08:43'),
(72, 319, 'Emotional', 0, '2025-03-21 03:08:43', '2025-03-21 03:08:43'),
(73, 319, 'Psychological', 0, '2025-03-21 03:08:43', '2025-03-21 03:08:43'),
(74, 319, 'Economic', 0, '2025-03-21 03:08:43', '2025-03-21 03:08:43'),
(75, 319, 'Others, specify', 1, '2025-03-21 03:08:43', '2025-03-21 03:08:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sub_options`
--
ALTER TABLE `sub_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_options_option_id_foreign` (`option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sub_options`
--
ALTER TABLE `sub_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_options`
--
ALTER TABLE `sub_options`
  ADD CONSTRAINT `sub_options_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

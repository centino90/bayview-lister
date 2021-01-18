-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2021 at 01:29 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_lister`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getDailyCertificationReport` (IN `class` VARCHAR(50))  BEGIN

    if (class = 'countAllByRow') THEN
        select count(id) AS count FROM residents WHERE date(issue_date) = CURDATE();
    ELSEIF (class = 'countAllByIssue') THEN
       select issue, count(issue) AS count FROM residents WHERE date(issue_date) = CURDATE() GROUP BY issue;
	ELSEIF (class = 'countAllByName') THEN
		select full_name(fname, mname, lname) as FullName, count(id) as count from residents WHERE date(issue_date) = CURDATE() GROUP BY full_name(fname, mname, lname);    
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getMonthlyCertificationReport` (IN `class` VARCHAR(50))  BEGIN

    if (class = 'countAllByRow') THEN
        select count(id) AS count FROM residents where month(created_at) = month(curdate());
    ELSEIF (class = 'countAllByIssue') THEN
       select issue, count(issue) AS count FROM residents where month(created_at) = month(curdate()) GROUP BY issue;
	ELSEIF (class = 'countAllByName') THEN
		select full_name(fname, mname, lname) as FullName, count(id) as count from residents where month(created_at) = month(curdate()) GROUP BY full_name(fname, mname, lname);    
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getWeeklyCertificationReport` (IN `class` VARCHAR(50))  BEGIN

    if (class = 'countAllByRow') THEN
        select count(id) AS count FROM residents where week(issue_date) = week(curdate());
    ELSEIF (class = 'countAllByIssue') THEN
       select issue, count(issue) AS count FROM residents where week(issue_date) = week(curdate()) GROUP BY issue;
	ELSEIF (class = 'countAllByName') THEN
		select full_name(fname, mname, lname) as FullName, count(id) as count from residents where week(issue_date) = week(curdate()) GROUP BY full_name(fname, mname, lname);    
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchRecords` (IN `fln` VARCHAR(70), IN `lim` INT(11))  SELECT full_name(fname, mname, lname) AS FullName, issue, purpose, issue_date, id FROM residents WHERE CONCAT(fname, ' ' ,mname, ' ', lname) LIKE fln LIMIT lim$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `full_name` (`fname` VARCHAR(50), `mname` CHAR(1), `lname` VARCHAR(50)) RETURNS VARCHAR(100) CHARSET utf8mb4 RETURN CONCAT(fname, " " , mname, " ", lname)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(47, '2014_10_12_000000_create_users_table', 1),
(48, '2014_10_12_100000_create_password_resets_table', 1),
(49, '2019_08_19_000000_create_failed_jobs_table', 1),
(52, '2021_01_14_122112_add_updatedat_to_residents_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(50) COLLATE utf8_bin NOT NULL,
  `mname` char(1) COLLATE utf8_bin NOT NULL,
  `lname` varchar(50) COLLATE utf8_bin NOT NULL,
  `issue` varchar(50) COLLATE utf8_bin NOT NULL,
  `purpose` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `issue_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `fname`, `mname`, `lname`, `issue`, `purpose`, `issue_date`, `created_at`, `updated_at`) VALUES
(1, 'Anthony', 'P', 'Ansit', 'Foodpacks', 'wqe', '2021-01-17', '2021-01-17 16:34:54', '2021-01-18 12:29:29'),
(2, 'bryan', 'p', 'Ansit', 'travel pass', NULL, '2021-01-13', '2021-01-17 16:40:26', NULL),
(3, 'Jerry', 'S', 'Ansit', 'Travel Pass', NULL, '2021-01-17', '2021-01-17 16:41:41', NULL),
(4, 'ab', 'p', 'Ansit', 'travel pass', NULL, '2021-01-18', '2021-01-17 16:42:02', NULL),
(5, 'jon', 'd', 'snow', 'travel pass', 'to the wall', '2021-01-18', '2021-01-18 04:58:14', NULL),
(6, 'ma theresa', 'b', 'bantog dako', 'foodpacks', NULL, '2021-01-18', '2021-01-18 11:06:55', NULL),
(7, 'Da Berry Mantos', 'b', 'Be Rrry Kreggi', 'foodpacks', NULL, '2021-01-18', '2021-01-18 11:32:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

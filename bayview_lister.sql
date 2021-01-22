-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2021 at 02:52 PM
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
-- Database: `bayview_lister`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getDailyCertificationReport` (IN `class` VARCHAR(50))  BEGIN
select count(*) INTO @count from residents WHERE date(issue_date) = CURDATE();
    if (class = 'countAllByRow') THEN
        select count(id) AS count FROM residents WHERE date(issue_date) = CURDATE();
    ELSEIF (class = 'countAllByIssue') THEN
     	if(@count = 0) THEN
        	select NULL AS issue, 0 AS count;
       	ELSE 
       		select issue, count(*) AS count FROM residents WHERE date(issue_date) = CURDATE() GROUP BY issue;
        END IF;
	ELSEIF (class = 'countAllByName') THEN
        if(@count = 0) THEN
        	select NULL AS FullName, 0 AS count;
        ELSE 
			select full_name(fname, mname, lname) AS FullName, count(*) as count from residents WHERE date(issue_date) = CURDATE() GROUP BY full_name(fname, mname, lname);
        END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getMonthlyCertificationReport` (IN `class` VARCHAR(50))  BEGIN
select count(*) INTO @count from residents WHERE month(issue_date) = month(curdate());

    if (class = 'countAllByRow') THEN
        select count(id) AS count FROM residents where month(created_at) = month(curdate());
    ELSEIF (class = 'countAllByIssue') THEN
    if(@count = 0) THEN
        	select NULL AS issue, 0 AS count;
        ELSE 
       select issue, count(issue) AS count FROM residents where month(created_at) = month(curdate()) GROUP BY issue;
      END IF;
	ELSEIF (class = 'countAllByName') THEN
    if(@count = 0) THEN
        	select NULL AS FullName, 0 AS count;
        ELSE 
		select full_name(fname, mname, lname) as FullName, count(id) as count from residents where month(created_at) = month(curdate()) GROUP BY full_name(fname, mname, lname);    
        END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRecordsByDate` (IN `isd` DATE, OUT `sess_am` INT(11), OUT `sess_pm` INT(11), OUT `counter` INT(11))  BEGIN
		SELECT IFNULL(full_name(fname, mname, lname), CONCAT(fname, " ", lname)) AS FullName, issue, category, IFNULL(purpose, 'N/A') AS purpose, issue_date, session FROM residents WHERE issue_date = isd ORDER BY session, full_name(fname, mname, lname) ASC;
        SELECT count(session) INTO sess_am FROM residents WHERE issue_date = isd AND session = 'AM';
        SELECT count(session) INTO sess_pm FROM residents WHERE issue_date = isd AND session = 'PM';
        SELECT count(*) INTO counter FROM residents WHERE issue_date = isd;
        
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getWeeklyCertificationReport` (IN `class` VARCHAR(50))  BEGIN
select count(*) INTO @count from residents WHERE week(issue_date) = week(curdate());
    if (class = 'countAllByRow') THEN
        select count(id) AS count FROM residents where week(issue_date) = week(curdate());
    ELSEIF (class = 'countAllByIssue') THEN
    if(@count = 0) THEN
        	select NULL AS issue, 0 AS count;
       	ELSE 
       select issue, count(*) AS count FROM residents where week(issue_date) = week(curdate()) GROUP BY issue;
       END IF;
	ELSEIF (class = 'countAllByName') THEN
    if(@count = 0) THEN
        	select NULL AS FullName, 0 AS count;
        ELSE 
		select full_name(fname, mname, lname) as FullName, count(*) as count from residents where week(issue_date) = week(curdate()) GROUP BY full_name(fname, mname, lname);    
       END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchRecords` (IN `fln` VARCHAR(70), IN `lim` INT(11))  SELECT IFNULL(full_name(fname, mname, lname), CONCAT(fname, " ", lname)) AS FullName, fname, mname, lname, issue, category, purpose, issue_date, session, id FROM residents WHERE IFNULL(full_name(fname, mname, lname), CONCAT(fname, " ", lname)) LIKE fln ORDER BY full_name(fname, mname, lname) ASC, issue_date DESC LIMIT lim$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `full_day` (`fname` VARCHAR(50), `mname` CHAR(1), `lname` VARCHAR(50)) RETURNS VARCHAR(100) CHARSET utf8mb4 BEGIN
IF (mname = NULL) THEN
RETURN CONCAT(fname, " " , mname, " ", lname);
ELSE 
RETURN CONCAT(fname, " ", lname);
END IF;
END$$

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_01_14_122112_add_updatedat_to_residents_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('aj123@gmail.com', '$2y$10$81S2BoL0MMe9lp7xe0rB7uEOWbnEiUAhP6R6W6kWtx6olAAlKhtOW', '2021-01-20 07:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(50) COLLATE utf8_bin NOT NULL,
  `mname` char(1) COLLATE utf8_bin DEFAULT NULL,
  `lname` varchar(50) COLLATE utf8_bin NOT NULL,
  `issue` varchar(50) COLLATE utf8_bin NOT NULL,
  `category` varchar(30) COLLATE utf8_bin NOT NULL,
  `purpose` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `issue_date` date NOT NULL,
  `session` varchar(2) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `fname`, `mname`, `lname`, `issue`, `category`, `purpose`, `issue_date`, `session`, `created_at`, `updated_at`) VALUES
(16, 'roderick', 'g', 'javier', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-21 13:08:49', NULL),
(17, 'jimmy', NULL, 'morega', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-21 13:09:26', '2021-01-21 13:09:42'),
(18, 'joan', 'o', 'tabugoy', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-21 13:10:16', NULL),
(19, 'jenielyn', 'n', 'manait', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-21 13:13:06', NULL),
(20, 'mario', 'f', 'palo', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-21 13:15:14', NULL),
(21, 'susana', 'p', 'agay', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-21 13:15:41', NULL),
(22, 'carlito', NULL, 'puerin', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-21 13:16:22', NULL),
(23, 'karen', NULL, 'dela peña', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-21 13:18:33', NULL),
(24, 'jezel', NULL, 'ogtip', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-21 13:19:00', NULL),
(25, 'rea', 'l', 'barnaja', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-21 13:19:55', NULL),
(26, 'rodolfo', 'p', 'castañares', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'AM', '2021-01-21 13:20:31', NULL),
(27, 'evelyn', NULL, 'noya', 'Food-Packs', 'Womens', NULL, '2021-01-17', 'AM', '2021-01-21 13:21:09', NULL),
(28, 'nena', 's', 'gucor', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'AM', '2021-01-21 13:22:47', NULL),
(29, 'lie lan lea', NULL, 'canubas', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'AM', '2021-01-21 13:23:22', NULL),
(30, 'conchita', NULL, 'cagampang', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'AM', '2021-01-21 13:23:44', NULL),
(31, 'jenalyn', NULL, 'Cagampang', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'AM', '2021-01-21 13:23:58', NULL),
(32, 'marites', 'c', 'hornada', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'PM', '2021-01-21 13:24:44', NULL),
(33, 'eugenio', NULL, 'yonson', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'PM', '2021-01-21 13:25:46', NULL),
(34, 'marcos', NULL, 'platero', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'PM', '2021-01-21 13:26:08', NULL),
(35, 'norma', NULL, 'araño', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'PM', '2021-01-21 13:27:58', NULL),
(36, 'raymundo', 'm', 'juntilla', 'Food-Packs', 'Normal', NULL, '2021-01-18', 'PM', '2021-01-21 13:29:07', NULL),
(37, 'divina', 'd', 'narvasa', 'Food-Packs', 'Normal', NULL, '2021-01-21', 'AM', '2021-01-21 13:29:32', '2021-01-21 13:30:35'),
(38, 'naome', NULL, 'diacoma', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:29:54', '2021-01-21 13:30:53'),
(39, 'marisol', 'r', 'tipudan', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:31:18', NULL),
(40, 'maria theresa', NULL, 'buot', 'Food-Packs', 'Normal', NULL, '2021-01-19', 'AM', '2021-01-21 13:31:58', NULL),
(41, 'maria evelyn', 'c', 'de jesus', 'Food-Packs', 'Normal', NULL, '2021-01-19', 'AM', '2021-01-21 13:32:18', NULL),
(42, 'lane', 'n', 'estimada', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:32:50', NULL),
(43, 'rejay', 'g', 'baste', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:33:06', NULL),
(44, 'lita', NULL, 'mamhot', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:33:23', NULL),
(45, 'nancy', NULL, 'baste', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:33:36', '2021-01-21 20:49:11'),
(46, 'ann', 'm', 'gapo', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-21 13:33:57', NULL),
(47, 'alodia', NULL, 'pahayahay', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-21 13:37:12', NULL),
(48, 'shamay latiban', NULL, 'panayo', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-21 13:37:41', NULL),
(49, 'rosalina', NULL, 'giduguio', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-21 13:38:20', NULL),
(50, 'aira fe', 'd', 'culanag', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-21 13:38:37', NULL),
(51, 'jocelyn', 'c', 'mejia', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'PM', '2021-01-21 13:38:52', NULL),
(52, 'esterleta', 'b', 'gamale', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'PM', '2021-01-21 13:39:09', NULL),
(53, 'eddie', 'b', 'pulvera', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'PM', '2021-01-21 13:39:29', NULL),
(54, 'elpedio', NULL, 'nagun', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'PM', '2021-01-21 13:41:34', NULL),
(55, 'pilar', 't', 'sobretodo', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'AM', '2021-01-21 13:41:47', NULL),
(56, 'rowena', 'p', 'villas', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'AM', '2021-01-21 13:42:10', NULL),
(57, 'benito', 's', 'mercado', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'AM', '2021-01-21 13:42:24', NULL),
(58, 'cristina', 'b', 'bondame', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'AM', '2021-01-21 13:43:08', NULL),
(59, 'mercy', 'r', 'bermejo', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'PM', '2021-01-21 13:44:05', NULL),
(60, 'juana', 'b', 'denoyo', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'PM', '2021-01-21 13:46:09', NULL),
(61, 'elvira', NULL, 'tambis', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'PM', '2021-01-21 13:46:38', NULL),
(62, 'katherin', NULL, 'tambis', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'PM', '2021-01-21 13:46:52', NULL),
(63, 'paula', NULL, 'tambis', 'Food-Packs', 'Normal', NULL, '2021-01-12', 'PM', '2021-01-21 13:47:11', NULL),
(64, 'cyril mae', NULL, 'mendoza', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-21 13:47:36', NULL),
(65, 'primitiva', 'a', 'aying', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-21 13:47:51', NULL),
(66, 'erlinda', NULL, 'delos santos', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-21 13:48:05', NULL),
(67, 'arlene', NULL, 'entero', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-21 13:48:21', NULL),
(68, 'luz', NULL, 'macabenta', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-21 13:48:35', NULL),
(69, 'sharlen', NULL, 'capina', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-21 13:48:52', NULL),
(70, 'rex earl', NULL, 'de guzman', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-21 13:49:08', NULL),
(71, 'patricinio', NULL, 'sigasig', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-21 13:50:01', NULL),
(72, 'nelson', NULL, 'vargas', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-21 13:50:42', NULL),
(73, 'avelita', NULL, 'masumpad', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-21 13:50:56', NULL),
(74, 'evelyn', 'c', 'bautista', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-21 13:51:08', NULL),
(75, 'alice', 's', 'suero', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-21 13:51:21', NULL),
(76, 'honorina', 'l', 'estimada', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-21 13:52:24', NULL),
(77, 'vivencia', 'l', 'calubag', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-21 13:52:50', NULL),
(80, 'gemma', NULL, 'sinogaya', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-22 11:17:13', NULL),
(81, 'judy', 'a', 'garcero', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-22 11:17:38', NULL),
(82, 'maritess', 'a', 'garcero', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-22 11:18:52', NULL),
(83, 'genelyn', 'm', 'repole', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'AM', '2021-01-22 11:19:08', NULL),
(84, 'jeziel jane mae', 'b', 'balolong', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-22 11:20:39', NULL),
(85, 'archie', NULL, 'secuya', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-22 11:20:53', NULL),
(86, 'ellen', NULL, 'tabasa', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-22 11:21:07', NULL),
(87, 'dhan christopher', 'c', 'lasola', 'Food-Packs', 'Normal', NULL, '2021-01-13', 'PM', '2021-01-22 11:21:42', NULL),
(88, 'gemma', NULL, 'borinaga', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-22 11:21:54', NULL),
(89, 'analyn', NULL, 'phala', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-22 11:22:09', NULL),
(90, 'jaynel', NULL, 'jagocoy', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-22 11:22:29', NULL),
(91, 'vanessa', NULL, 'jagocoy', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'AM', '2021-01-22 11:22:43', NULL),
(92, 'irene', NULL, 'ang', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'PM', '2021-01-22 11:22:59', NULL),
(93, 'jenny', NULL, 'tutaan', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'PM', '2021-01-22 11:23:20', NULL),
(94, 'jeciel', 's', 'baliguat', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'PM', '2021-01-22 11:23:36', NULL),
(95, 'lilibeth', 's', 'fabian', 'Food-Packs', 'Normal', NULL, '2021-01-14', 'PM', '2021-01-22 11:23:47', '2021-01-22 11:24:01'),
(96, 'shiela', 'l', 'polestico', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-22 11:24:27', NULL),
(97, 'mirabel', 'p', 'gomera', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-22 11:24:46', NULL),
(98, 'lhorlie may', 'b', 'perez', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-22 11:25:24', NULL),
(99, 'john carlo', NULL, 'maturan', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'AM', '2021-01-22 11:25:37', NULL),
(100, 'shurkey', 'd', 'dalis', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-22 11:27:47', NULL),
(101, 'john bryan', NULL, 'nipales', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-22 11:28:43', NULL),
(102, 'euni mae', NULL, 'bacud', 'Food-Packs', 'Normal', NULL, '2021-01-15', 'PM', '2021-01-22 11:29:02', NULL),
(103, 'liza', NULL, 'liaging', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'AM', '2021-01-22 11:29:18', NULL),
(104, 'alen', 'h', 'rojas', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'AM', '2021-01-22 11:29:57', NULL),
(105, 'arnel', NULL, 'sanaoy', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'AM', '2021-01-22 11:30:24', NULL),
(106, 'luzminda', 'o', 'juntilla', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'AM', '2021-01-22 11:32:23', NULL),
(107, 'lucila', 'm', 'caldamo', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'PM', '2021-01-22 11:32:48', NULL),
(108, 'luminada', 'm', 'mangaca', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'PM', '2021-01-22 11:33:03', NULL),
(109, 'reynato', 'm', 'sumaya', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'PM', '2021-01-22 11:33:15', NULL),
(110, 'nena', 's', 'gucor', 'Food-Packs', 'Normal', NULL, '2021-01-16', 'PM', '2021-01-22 11:33:36', NULL),
(111, 'crisostomo', 't', 'zamora', 'Food-Packs', 'Normal', NULL, '2021-01-17', 'AM', '2021-01-22 11:36:18', NULL),
(112, 'joan', NULL, 'asenita', 'Food-Packs', 'Normal', NULL, '2021-01-17', 'AM', '2021-01-22 11:36:32', NULL),
(113, 'arvin', 'b', 'tutor', 'Food-Packs', 'Normal', NULL, '2021-01-17', 'AM', '2021-01-22 11:36:46', NULL),
(114, 'leslie', 'n', 'paje', 'Food-Packs', 'Normal', NULL, '2021-01-17', 'AM', '2021-01-22 11:37:03', NULL),
(115, 'arlen', 'c', 'querol', 'Food-Packs', 'Normal', NULL, '2021-01-17', 'AM', '2021-01-22 11:37:15', NULL),
(116, 'erlinda', 'n', 'sanchez', 'Food-Packs', 'Normal', NULL, '2021-01-17', 'PM', '2021-01-22 11:37:31', NULL),
(117, 'gelyn', 'q', 'recemiento', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 11:38:15', NULL),
(118, 'bryan', 'b', 'dayoc', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 11:38:28', NULL),
(119, 'shandrey', 'l', 'estimada', 'Food-Packs', 'Normal', NULL, '2021-01-06', 'AM', '2021-01-22 11:38:59', NULL),
(120, 'kristine joyce', 'm', 'garcero', 'Food-Packs', 'Normal', NULL, '2021-01-06', 'AM', '2021-01-22 11:39:22', NULL),
(121, 'lenny grace', 'v', 'sarabia', 'Food-Packs', 'Normal', NULL, '2021-01-06', 'AM', '2021-01-22 11:39:43', NULL),
(122, 'joy', 'a', 'gonzaga', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 11:40:04', NULL),
(123, 'roldan', 'm', 'galendez', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 11:40:19', NULL),
(124, 'mylene', 'a', 'gabato', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:40:34', NULL),
(125, 'erwin', 'l', 'nacua', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:40:48', '2021-01-22 11:45:59'),
(126, 'pio', 'r', 'bondame', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:41:04', '2021-01-22 11:46:10'),
(127, 'michael', NULL, 'sta. iglesia', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:41:25', NULL),
(128, 'sonia', 'b', 'tutor', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:42:00', NULL),
(129, 'mari', NULL, 'gomera', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:42:28', NULL),
(130, 'ronald', 'c', 'donguines', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:42:44', '2021-01-22 11:46:41'),
(131, 'gina', NULL, 'cumambot', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 11:43:14', '2021-01-22 11:46:54'),
(132, 'arsel', 'e', 'tomale', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'PM', '2021-01-22 11:43:30', NULL),
(133, 'josephane', 'd', 'laginan', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 11:44:23', NULL),
(134, 'jeffrey', NULL, 'zamora', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-22 11:44:34', NULL),
(135, 'segundina', 'b', 'rupado', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-22 11:45:25', NULL),
(136, 'ribecca', 'r', 'congreso', 'Food-Packs', 'Normal', NULL, '2021-01-11', 'AM', '2021-01-22 11:45:41', NULL),
(137, 'emiley', NULL, 'cabias', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'AM', '2021-01-22 11:49:24', NULL),
(138, 'zara jean', 'b', 'longakit', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'AM', '2021-01-22 11:49:38', NULL),
(139, 'jovelyn', 'u', 'briones', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'AM', '2021-01-22 11:50:07', NULL),
(140, 'love joy', 'g', 'rakiin', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'AM', '2021-01-22 11:50:50', NULL),
(141, 'jacqueline', 'v', 'santiago', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-22 11:51:15', NULL),
(142, 'nelsa', NULL, 'jagocoy', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-22 11:51:29', NULL),
(143, 'rosebe', NULL, 'basalan', 'Food-Packs', 'Normal', NULL, '2021-01-20', 'PM', '2021-01-22 11:51:42', NULL),
(144, 'emma', NULL, 'monteza', 'Food-Packs', 'Normal', NULL, '2021-01-21', 'AM', '2021-01-22 11:52:28', NULL),
(145, 'jocelyn', NULL, 'babala', 'Food-Packs', 'Normal', NULL, '2021-01-21', 'AM', '2021-01-22 11:53:16', NULL),
(146, 'lyka', 'y', 'santiago', 'Food-Packs', 'Normal', NULL, '2021-01-21', 'AM', '2021-01-22 11:54:25', NULL),
(147, 'ricky jean', 'c', 'manzano', 'Food-Packs', 'Normal', NULL, '2021-01-21', 'AM', '2021-01-22 11:54:35', NULL),
(148, 'lorita', 's', 'balili', 'Food-Packs', 'Normal', NULL, '2021-01-21', 'AM', '2021-01-22 11:54:44', NULL),
(149, 'bobie', NULL, 'duran', 'Food-Packs', 'Normal', NULL, '2021-01-22', 'AM', '2021-01-22 11:54:59', NULL),
(150, 'junnary', 'v', 'tan', 'Food-Packs', 'Normal', NULL, '2021-01-22', 'AM', '2021-01-22 11:55:09', NULL),
(151, 'linalyn', NULL, 'catayas', 'Food-Packs', 'Normal', NULL, '2021-01-22', 'AM', '2021-01-22 11:55:45', NULL),
(152, 'ricardo', NULL, 'calubag', 'Food-Packs', 'Normal', NULL, '2021-01-22', 'AM', '2021-01-22 11:55:56', NULL),
(153, 'diamon', 'a', 'mamangcao', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:56:35', NULL),
(154, 'lorena', 'c', 'ewag', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:56:49', NULL),
(155, 'sheryl', 'a', 'balbido', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:57:00', NULL),
(156, 'charmane', 'a', 'aldamar', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:57:12', NULL),
(157, 'jeanylyn', 'l', 'luganao', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'PM', '2021-01-22 11:57:27', NULL),
(158, 'leslie', NULL, 'pandi', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'PM', '2021-01-22 11:57:48', NULL),
(159, 'norisa', NULL, 'diasis', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'PM', '2021-01-22 11:58:02', NULL),
(160, 'cristine', NULL, 'auxtero', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:58:42', NULL),
(161, 'lucile', 'm', 'esquibel', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:58:57', NULL),
(162, 'bernadeth', 'b', 'mondinido', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:59:09', NULL),
(163, 'janel roxanna', 'b', 'maratas', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:59:28', NULL),
(164, 'alma', 'r', 'bituin', 'Food-Packs', 'Normal', NULL, '2021-01-25', 'AM', '2021-01-22 11:59:41', NULL),
(165, 'lucita', NULL, 'ramos', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 11:59:53', NULL),
(166, 'dedina', 'a', 'luna', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:00:55', '2021-01-22 12:01:09'),
(167, 'agnes', 'a', 'luna', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:01:29', NULL),
(168, 'harold kim', 'a', 'luna', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:01:44', NULL),
(169, 'leonardo', NULL, 'solatorio', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:02:09', NULL),
(170, 'jimmy', NULL, 'yonson', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:02:58', NULL),
(171, 'jimmy', NULL, 'yonson', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:02:58', NULL),
(172, 'joriljian', NULL, 'balili', 'Food-Packs', 'Normal', NULL, '2021-01-26', 'AM', '2021-01-22 12:03:13', NULL),
(173, 'mary jane', NULL, 'osorio', 'Food-Packs', 'Normal', NULL, '2021-01-27', 'AM', '2021-01-22 12:03:34', NULL),
(174, 'rizalyn', 'g', 'negro', 'Food-Packs', 'Normal', NULL, '2021-01-27', 'AM', '2021-01-22 12:03:50', NULL),
(175, 'jade', 'm', 'ligad', 'Food-Packs', 'Normal', NULL, '2021-01-28', 'AM', '2021-01-22 12:04:57', NULL),
(176, 'laica', 'z', 'yongson', 'Food-Packs', 'Normal', NULL, '2021-01-28', 'AM', '2021-01-22 12:05:09', NULL),
(177, 'cecil', 'h', 'masayon', 'Food-Packs', 'Normal', NULL, '2021-01-28', 'AM', '2021-01-22 12:05:19', NULL),
(178, 'siony', 't', 'ruiz', 'Food-Packs', 'Normal', NULL, '2021-01-28', 'AM', '2021-01-22 12:05:42', NULL),
(179, 'zorohaida', NULL, 'tagalawan', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 12:09:29', NULL),
(180, 'casiano', NULL, 'garate', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 12:09:47', NULL),
(181, 'richard', 'c', 'donguines', 'Food-Packs', 'Normal', NULL, '2021-01-07', 'AM', '2021-01-22 12:10:02', NULL),
(182, 'clyde', NULL, 'latras', 'Food-Packs', 'Normal', NULL, '2021-01-22', 'AM', '2021-01-22 12:10:31', NULL),
(183, 'jenny', NULL, 'bagocboc', 'Food-Packs', 'Normal', NULL, '2021-01-27', 'AM', '2021-01-22 12:10:54', NULL),
(184, 'analyn', NULL, 'magdusa', 'Food-Packs', 'Normal', NULL, '2021-01-22', 'AM', '2021-01-22 12:12:36', NULL),
(185, 'analou', 'r', 'del rosario', 'Food-Packs', 'Normal', NULL, '2021-01-27', 'AM', '2021-01-22 12:12:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Anthony Ansit', 'aj123@gmail.com', NULL, '$2y$10$SZMUbY3LHQW8X4uScK0JNOQflWGmGQGccmsn.WhQ4ngyddwAlT2y.', NULL, '2021-01-20 04:46:48', '2021-01-20 04:46:48');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

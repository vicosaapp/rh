-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2023 at 07:06 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workday`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_data`
--

CREATE TABLE `company_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `reference` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `jobposition` varchar(255) DEFAULT NULL,
  `companyemail` varchar(255) DEFAULT NULL,
  `idno` varchar(255) DEFAULT NULL,
  `startdate` varchar(255) DEFAULT NULL,
  `dateregularized` varchar(255) DEFAULT NULL,
  `reason` varchar(455) DEFAULT NULL,
  `leaveprivilege` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_data`
--

INSERT INTO `company_data` (`id`, `reference`, `company`, `department`, `jobposition`, `companyemail`, `idno`, `startdate`, `dateregularized`, `reason`, `leaveprivilege`, `created_at`) VALUES
(1, 1, '', '', '', '', '001122', '2022-01-01', '2022-02-01', '', NULL, '0000-00-00 00:00:00'),
(2, 2, '', '', '', '', '001133', '2022-01-01', '2022-02-01', '', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_company`
--

CREATE TABLE `form_company` (
  `id` int(11) UNSIGNED NOT NULL,
  `company` varchar(250) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_department`
--

CREATE TABLE `form_department` (
  `id` int(11) UNSIGNED NOT NULL,
  `department` varchar(250) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_jobtitle`
--

CREATE TABLE `form_jobtitle` (
  `id` int(11) UNSIGNED NOT NULL,
  `jobtitle` varchar(250) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_leavegroup`
--

CREATE TABLE `form_leavegroup` (
  `id` int(11) UNSIGNED NOT NULL,
  `leavegroup` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `leaveprivileges` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_leavetype`
--

CREATE TABLE `form_leavetype` (
  `id` int(11) UNSIGNED NOT NULL,
  `leavetype` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `percalendar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(6) UNSIGNED NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `mi` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `emailaddress` varchar(255) DEFAULT NULL,
  `civilstatus` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `mobileno` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `nationalid` varchar(255) DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `homeaddress` varchar(255) DEFAULT NULL,
  `employmentstatus` varchar(11) DEFAULT NULL,
  `employmenttype` varchar(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `firstname`, `mi`, `lastname`, `age`, `gender`, `emailaddress`, `civilstatus`, `height`, `weight`, `mobileno`, `birthday`, `nationalid`, `birthplace`, `homeaddress`, `employmentstatus`, `employmenttype`, `avatar`, `created_at`) VALUES
(1, 'MANAGER', '', 'DEMO', 0, '', 'manager@example.com', '', '', '', '', '2022-01-03', '', '', '', 'Active', '', '', '0000-00-00 00:00:00'),
(2, 'EMPLOYEE', '', 'DEMO', 0, '', 'employee@example.com', '', NULL, NULL, NULL, '2022-01-03', '', '', '', 'Active', NULL, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `people_attendance`
--

CREATE TABLE `people_attendance` (
  `id` int(11) UNSIGNED NOT NULL,
  `reference` int(11) DEFAULT NULL,
  `idno` varchar(11) DEFAULT '',
  `date` date DEFAULT NULL,
  `employee` varchar(255) DEFAULT '',
  `timein` varchar(255) DEFAULT NULL,
  `timeout` varchar(255) DEFAULT NULL,
  `totalhours` varchar(255) DEFAULT '',
  `status_timein` varchar(255) DEFAULT '',
  `status_timeout` varchar(255) DEFAULT '',
  `reason` varchar(255) DEFAULT '',
  `comment` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_leaves`
--

CREATE TABLE `people_leaves` (
  `id` int(11) UNSIGNED NOT NULL,
  `reference` int(11) DEFAULT NULL,
  `idno` varchar(11) DEFAULT NULL,
  `employee` varchar(255) DEFAULT '',
  `typeid` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT '',
  `leavefrom` date DEFAULT NULL,
  `leaveto` date DEFAULT NULL,
  `returndate` date DEFAULT NULL,
  `reason` varchar(255) DEFAULT '',
  `status` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `archived` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people_schedules`
--

CREATE TABLE `people_schedules` (
  `id` int(11) UNSIGNED NOT NULL,
  `reference` int(11) DEFAULT NULL,
  `idno` varchar(11) DEFAULT NULL,
  `employee` varchar(255) DEFAULT NULL,
  `intime` text DEFAULT NULL,
  `outime` text DEFAULT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `restday` varchar(255) DEFAULT NULL,
  `archive` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_views`
--

CREATE TABLE `report_views` (
  `id` int(11) UNSIGNED NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `last_viewed` varchar(255) DEFAULT NULL,
  `title` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_views`
--

INSERT INTO `report_views` (`id`, `report_id`, `last_viewed`, `title`) VALUES
(1, 1, '', 'Employee List Report'),
(5, 5, '', 'Company Overview'),
(6, 6, '', 'User Accounts Report'),
(7, 7, '', 'Employee Birthdays');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `time_format` int(11) DEFAULT NULL,
  `rfid` varchar(255) DEFAULT NULL,
  `iprestriction` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `timezone`, `time_format`, `rfid`, `iprestriction`) VALUES
(1, 'America/New_York', 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` int(11) DEFAULT NULL,
  `idno` varchar(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `acc_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reference`, `idno`, `role_id`, `acc_type`, `status`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, '001122', 1, 2, 1, 'DEMO, MANAGER', 'manager@example.com', '2022-11-11 12:12:55', '$2y$10$mDAH.R8JG5ThPelt4zRXc.8sxizt.tqXQfndx5s/W/3j0Sq6xS3LG', NULL, '2022-11-11 12:15:23', '2022-11-11 12:15:25'),
(2, 2, '001133', 2, 1, 1, 'DEMO, EMPLOYEE', 'employee@example.com', '2022-11-11 12:16:22', '$2y$10$3qjhKES39RmTl4k7PQWJ.OfG4uFzzF/iYJI8A1BLgYs2uDEfe5pry', NULL, '2022-11-11 12:16:31', '2022-11-11 12:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `perm_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`id`, `role_id`, `perm_id`) VALUES
(1890, 1, 1),
(1891, 1, 2),
(1892, 1, 21),
(1893, 1, 22),
(1894, 1, 23),
(1895, 1, 24),
(1896, 1, 25),
(1897, 1, 3),
(1898, 1, 31),
(1899, 1, 32),
(1900, 1, 4),
(1901, 1, 41),
(1902, 1, 42),
(1903, 1, 43),
(1904, 1, 44),
(1905, 1, 5),
(1906, 1, 51),
(1907, 1, 52),
(1908, 1, 7),
(1909, 1, 8),
(1910, 1, 81),
(1911, 1, 82),
(1912, 1, 83),
(1913, 1, 9),
(1914, 1, 91),
(1915, 1, 10),
(1916, 1, 101),
(1917, 1, 102),
(1918, 1, 103),
(1919, 1, 104),
(1920, 1, 11),
(1921, 1, 111),
(1922, 1, 112),
(1923, 1, 12),
(1924, 1, 121),
(1925, 1, 122),
(1926, 1, 13),
(1927, 1, 131),
(1928, 1, 132),
(1929, 1, 14),
(1930, 1, 141),
(1931, 1, 142),
(1932, 1, 15),
(1933, 1, 151),
(1934, 1, 152),
(1935, 1, 153);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `role_name`, `status`, `created_at`) VALUES
(1, 'MANAGER', 'Active', '2022-05-19 12:10:04'),
(2, 'EMPLOYEE', 'Active', '2022-05-19 12:10:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_data`
--
ALTER TABLE `company_data`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `form_company`
--
ALTER TABLE `form_company`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `form_department`
--
ALTER TABLE `form_department`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `form_jobtitle`
--
ALTER TABLE `form_jobtitle`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `form_leavegroup`
--
ALTER TABLE `form_leavegroup`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `form_leavetype`
--
ALTER TABLE `form_leavetype`
  ADD PRIMARY KEY (`id`) USING BTREE;

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
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `people_attendance`
--
ALTER TABLE `people_attendance`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `people_leaves`
--
ALTER TABLE `people_leaves`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `people_schedules`
--
ALTER TABLE `people_schedules`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `report_views`
--
ALTER TABLE `report_views`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_data`
--
ALTER TABLE `company_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_company`
--
ALTER TABLE `form_company`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_department`
--
ALTER TABLE `form_department`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_jobtitle`
--
ALTER TABLE `form_jobtitle`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_leavegroup`
--
ALTER TABLE `form_leavegroup`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_leavetype`
--
ALTER TABLE `form_leavetype`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `people_attendance`
--
ALTER TABLE `people_attendance`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_leaves`
--
ALTER TABLE `people_leaves`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people_schedules`
--
ALTER TABLE `people_schedules`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_views`
--
ALTER TABLE `report_views`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1936;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

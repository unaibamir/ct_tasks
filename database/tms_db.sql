-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2019 at 06:10 AM
-- Server version: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `aauth_groups`
--

CREATE TABLE `aauth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `definition` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_groups`
--

INSERT INTO `aauth_groups` (`id`, `name`, `definition`) VALUES
(1, 'Admin', 'Super Admin Group'),
(2, 'Manager', 'Moderator'),
(3, 'Employee', 'End User');

-- --------------------------------------------------------

--
-- Table structure for table `aauth_group_to_group`
--

CREATE TABLE `aauth_group_to_group` (
  `group_id` int(11) UNSIGNED NOT NULL,
  `subgroup_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_login_attempts`
--

CREATE TABLE `aauth_login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(39) DEFAULT '0',
  `timestamp` datetime DEFAULT NULL,
  `login_attempts` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aauth_login_attempts`
--

INSERT INTO `aauth_login_attempts` (`id`, `ip_address`, `timestamp`, `login_attempts`) VALUES
(2, '127.0.0.1', '2019-10-03 23:05:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_perms`
--

CREATE TABLE `aauth_perms` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `definition` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_perms`
--

INSERT INTO `aauth_perms` (`id`, `name`, `definition`) VALUES
(1, 'add_task', ''),
(2, 'assign_task', ''),
(3, 'history_task', ''),
(4, 'forum', ''),
(5, 'search', ''),
(6, 'alert_tasks', ''),
(7, 'daily_report', ''),
(8, 'monthly_report', ''),
(9, 'finish_task', ''),
(10, 'enquiry_form', ''),
(11, 'profile_user', ''),
(12, 'all_task', '');

-- --------------------------------------------------------

--
-- Table structure for table `aauth_perm_to_group`
--

CREATE TABLE `aauth_perm_to_group` (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_perm_to_group`
--

INSERT INTO `aauth_perm_to_group` (`perm_id`, `group_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_perm_to_user`
--

CREATE TABLE `aauth_perm_to_user` (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_pms`
--

CREATE TABLE `aauth_pms` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `receiver_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `date_sent` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `pm_deleted_sender` int(1) DEFAULT NULL,
  `pm_deleted_receiver` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_users`
--

CREATE TABLE `aauth_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `forgot_exp` text,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text,
  `verification_code` text,
  `totp_secret` varchar(16) DEFAULT NULL,
  `ip_address` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_users`
--

INSERT INTO `aauth_users` (`id`, `first_name`, `last_name`, `email`, `pass`, `username`, `banned`, `last_login`, `last_activity`, `date_created`, `forgot_exp`, `remember_time`, `remember_exp`, `verification_code`, `totp_secret`, `ip_address`) VALUES
(1, 'adnan', 'Haider', 'adnanhaider44@gmail.com', 'dd5073c93fb477a167fd69072e95455834acd93df8fed41a2c468c45b394bfe3', 'Admin', 0, '2019-10-05 08:57:04', '2019-10-05 08:57:04', NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1'),
(3, 'Lina', 'Wonder', 'alice_manager@example.com', '9721a796dd679b9ffd50b672f2d66990654bfb6e233d89cef431b5f2814a1055', '332', 0, '2019-10-07 18:28:39', '2019-10-07 18:28:39', '2019-10-05 13:22:31', NULL, NULL, NULL, NULL, NULL, '127.0.0.1'),
(4, 'Amir', 'Aziz', 'AbdulAziz@yopmail.com', '6b741bb0a6941af528881a9b87802be648aa42ad1a44777b58b3f50df94fa1ef', '249', 0, '2019-10-08 03:52:29', '2019-10-08 03:52:29', '2019-10-05 14:09:47', NULL, NULL, NULL, NULL, NULL, '127.0.0.1'),
(5, 'Hussain ', 'Al Mulla', 'Hussain_Al_Mulla@yopmail.com', '19ce34b7d31aad3a3afe671b0ce80d726de492a454c5deb033ab239011a0a4ba', 'Hussain_Al_Mulla', 0, NULL, NULL, '2019-10-05 14:10:37', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Muralee', 'dharan', 'Muraleedharan@yopmail.com', '19e1b554fbeba8ac3d990b3b2e8b50e1e0530b7a524a67ab07fbe90f45922737', 'Muraleedharan', 0, NULL, NULL, '2019-10-05 14:12:46', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_to_group`
--

CREATE TABLE `aauth_user_to_group` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_user_to_group`
--

INSERT INTO `aauth_user_to_group` (`user_id`, `group_id`) VALUES
(1, 1),
(3, 2),
(4, 3),
(5, 3),
(6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_variables`
--

CREATE TABLE `aauth_user_variables` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `data_key` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `cid` int(11) NOT NULL,
  `c_name` varchar(55) COLLATE utf8_bin NOT NULL,
  `code` int(11) NOT NULL,
  `short_code` varchar(55) COLLATE utf8_bin NOT NULL,
  `c_description` varchar(111) COLLATE utf8_bin NOT NULL,
  `c_status` int(11) NOT NULL,
  `c_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `c_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`cid`, `c_name`, `code`, `short_code`, `c_description`, `c_status`, `c_created_at`, `c_updated_at`) VALUES
(1, 'CEO / Owner ', 11, 'co11', 'CEO / Owner ', 1, '2019-10-05 20:25:42', '2019-10-05 20:25:42'),
(2, 'Marketing', 22, 'm22', 'Marketing', 1, '2019-10-05 20:25:42', '2019-10-05 20:25:42'),
(3, 'Sale & Operation', 33, 'so33', 'Sales', 1, '2019-10-05 20:26:24', '2019-10-05 20:26:24'),
(4, 'Account', 44, 'ac44', 'Human Resources', 1, '2019-10-05 20:26:24', '2019-10-05 20:26:24'),
(5, 'IT', 55, 'it55', 'IT', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(6, 'Legal', 66, 'le66', 'Legal', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(7, 'Site Operation Staff', 77, 'sos77', 'Site Operation Staff', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(8, 'BD Department', 88, 'bd88', 'BD Department', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(9, 'Safety', 99, 'sa99', 'Safety', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(10, 'Engr', 110, 'Eng111', 'Engr', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(11, 'Admin Pro', 220, 'ad220', 'Admin Pro', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39'),
(12, 'Management', 330, 'Ma330', 'Management', 1, '2019-10-05 20:26:39', '2019-10-05 20:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `fid` int(11) NOT NULL,
  `f_title` varchar(55) COLLATE utf8_bin NOT NULL,
  `url` varchar(55) COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` int(2) NOT NULL,
  `f_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `f_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `rid` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `berfore` text COLLATE utf8_bin NOT NULL,
  `after` text COLLATE utf8_bin NOT NULL,
  `status` varchar(11) COLLATE utf8_bin NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`rid`, `task_id`, `berfore`, `after`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'before break', 'after break', 'Y', 0, '2019-10-08 08:46:37', '2019-10-08 08:46:37'),
(2, 2, 'asf', 'afd', 'Y', 0, '2019-10-08 08:47:37', '2019-10-08 08:47:37'),
(3, 2, 'hello break', 'by after', 'N', 0, '2019-10-08 09:09:17', '2019-10-08 09:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `tid` int(11) NOT NULL,
  `t_title` varchar(55) COLLATE utf8_bin NOT NULL,
  `t_code` varchar(55) COLLATE utf8_bin NOT NULL,
  `department_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Project ID',
  `assignee` int(11) NOT NULL COMMENT 'Given person',
  `reporter` int(11) NOT NULL COMMENT 'Follow up',
  `t_status` varchar(11) COLLATE utf8_bin NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `t_description` text COLLATE utf8_bin NOT NULL,
  `t_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `t_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_date` datetime NOT NULL,
  `end_date` varchar(11) COLLATE utf8_bin NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tid`, `t_title`, `t_code`, `department_id`, `parent_id`, `assignee`, `reporter`, `t_status`, `attachment_id`, `t_description`, `t_created_at`, `t_updated_at`, `start_date`, `end_date`, `created_by`) VALUES
(1, 'asdf', '2393', 1, 2, 5, 4, '', 0, 'asdfas', '2019-10-06 00:26:29', '2019-10-06 00:26:29', '2019-10-07 00:00:00', '2019-10-31', 3),
(2, 'Task2', '3179', 2, 2, 4, 5, '', 0, 'ASDFASASFDS', '2019-10-06 06:00:03', '2019-10-06 06:00:03', '2019-10-07 00:00:00', '2019-10-17', 3),
(3, 'Task3', '4604', 1, 3, 4, 5, '', 0, 'Yeh perfect hai', '2019-10-06 06:51:23', '2019-10-06 06:51:23', '2019-10-05 00:00:00', '2019-10-18', 3),
(4, 'Task4', '6317', 1, 2, 4, 4, '', 0, 'ySL', '2019-10-06 07:09:09', '2019-10-06 07:09:09', '2019-10-10 00:00:00', '2019-10-26', 3),
(5, 'Task5', '9374', 2, 2, 4, 5, '', 0, 'testing ', '2019-10-06 07:26:33', '2019-10-06 07:26:33', '2019-10-07 00:00:00', '2019-10-15', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aauth_groups`
--
ALTER TABLE `aauth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_group_to_group`
--
ALTER TABLE `aauth_group_to_group`
  ADD PRIMARY KEY (`group_id`,`subgroup_id`);

--
-- Indexes for table `aauth_login_attempts`
--
ALTER TABLE `aauth_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_perms`
--
ALTER TABLE `aauth_perms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_perm_to_group`
--
ALTER TABLE `aauth_perm_to_group`
  ADD PRIMARY KEY (`perm_id`,`group_id`);

--
-- Indexes for table `aauth_perm_to_user`
--
ALTER TABLE `aauth_perm_to_user`
  ADD PRIMARY KEY (`perm_id`,`user_id`);

--
-- Indexes for table `aauth_pms`
--
ALTER TABLE `aauth_pms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`);

--
-- Indexes for table `aauth_users`
--
ALTER TABLE `aauth_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_user_to_group`
--
ALTER TABLE `aauth_user_to_group`
  ADD PRIMARY KEY (`user_id`,`group_id`);

--
-- Indexes for table `aauth_user_variables`
--
ALTER TABLE `aauth_user_variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_index` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aauth_groups`
--
ALTER TABLE `aauth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `aauth_login_attempts`
--
ALTER TABLE `aauth_login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `aauth_perms`
--
ALTER TABLE `aauth_perms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `aauth_pms`
--
ALTER TABLE `aauth_pms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aauth_users`
--
ALTER TABLE `aauth_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `aauth_user_variables`
--
ALTER TABLE `aauth_user_variables`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

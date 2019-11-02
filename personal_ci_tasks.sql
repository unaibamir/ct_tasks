-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2019 at 03:21 AM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.3.3-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personal_ci_tasks`
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
(12, 'all_task', ''),
(13, 'view_employees', NULL);

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
(1, 3),
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
(12, 2),
(13, 2);

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
  `dept_id` int(11) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `com_mob_no` varchar(20) DEFAULT NULL,
  `per_mon_no` varchar(20) DEFAULT NULL,
  `cur_loc` varchar(100) DEFAULT NULL,
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

INSERT INTO `aauth_users` (`id`, `first_name`, `last_name`, `email`, `pass`, `username`, `dept_id`, `nationality`, `job_title`, `company_email`, `com_mob_no`, `per_mon_no`, `cur_loc`, `banned`, `last_login`, `last_activity`, `date_created`, `forgot_exp`, `remember_time`, `remember_exp`, `verification_code`, `totp_secret`, `ip_address`) VALUES
(1, 'adnan', 'Haider', 'adnanhaider44@gmail.com', 'dd5073c93fb477a167fd69072e95455834acd93df8fed41a2c468c45b394bfe3', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-10-05 08:57:04', '2019-10-05 08:57:04', NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1'),
(3, 'Lina', 'Wonder', 'alice_manager@example.com', '9721a796dd679b9ffd50b672f2d66990654bfb6e233d89cef431b5f2814a1055', '332', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-03 01:16:31', '2019-11-03 01:16:31', '2019-10-05 13:22:31', NULL, NULL, NULL, NULL, NULL, '::1'),
(4, 'Amir', 'Aziz', 'AbdulAziz@yopmail.com', '6b741bb0a6941af528881a9b87802be648aa42ad1a44777b58b3f50df94fa1ef', '249', 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-11-03 01:15:04', '2019-11-03 01:15:04', '2019-10-05 14:09:47', NULL, NULL, NULL, NULL, NULL, '::1'),
(5, 'Hussain ', 'Al Mulla', 'Hussain_Al_Mulla@yopmail.com', '19ce34b7d31aad3a3afe671b0ce80d726de492a454c5deb033ab239011a0a4ba', 'Hussain_Al_Mulla', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2019-10-05 14:10:37', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Muralee', 'dharan', 'Muraleedharan@yopmail.com', '19e1b554fbeba8ac3d990b3b2e8b50e1e0530b7a524a67ab07fbe90f45922737', 'Muraleedharan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2019-10-05 14:12:46', NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'Abdul', 'Aziz', 'abdulazizhusain67@yahoo.com', 'c90a088f27b57e13f40ca1aa8655cce88db0cac8366bc12f32f469e39cc8bb0d', '102', 1, 'Kuwait', 'Chairman', 'chairman@gulfenviro.ae', '050 426 2311', '+965 99588726', NULL, 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'Hussain', 'Al Mulla', 'greenworld1953@yahoo.com', '2e1db65f8532475d5e15ccf9d12462d624a38cf5de78374411b76086934863bf', '101', 1, 'Kuwait', 'Managing Director', 'hussain@gulfenviro.ae', '055 999 2277', '055 559 9244', NULL, 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Oleksandra', 'Kharytonova', 'zapozhanova@gmail.com', 'b52094efbf6dea29d8d8c8cec01aa3575401c3520bcccdacce7759a434864e97', '244', 2, 'Ukraine', 'Senior Marketing Executive', 'salesexecutive@gulfenviro.ae', '050 115 7009', NULL, 'Out of station', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Kateryna', 'Hamza', 'pa@gulfenviro.ae', 'dc7aaedc0bea413e8b0e70bc61c9a63ec9e00022c27da5a64c879800dd5b920c', '156', 2, 'Ukraine', 'Personal Assistant', 'pa@gulfenviro.ae', '054 591 3737', '380988880182', 'Out of station', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Mary', 'Grace', 'immrsgracemalit@yahoo.com', '3541653398ba4d2310dc53c922fbc4f51471970d631238ffee913c60eb10a7c7', '138', 3, 'Philippines', 'Admin Assistant', 'info@gulfenviro.ae', '056 183 1850', '055 732 6868', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Abdul', 'Rauf', 'khan_navid24@yahoo.co.in', 'a7a05dc8a550736956bd168b4f992648bed6befcb94a1c37ddc73424f6414eee', '150', 3, 'India', 'Sales Executive', 'business@gulfenviro.ae', '055 360 6604', '055 344 6862', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Harriett', 'Astodillo', 'harriettsakiwat@gmail.com', 'b260dedf19f3925c97498841b89e4ce1bae6eaddb728002b11c0590632bc50a7', '185', 3, 'Phillipines', 'Operations Assistant', 'info@gulfenviro.ae', NULL, '052 788 2950', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'Shushrut', 'Pattiwar', 'sales.gew@gulfenviro.ae', '967b6b18df0738b189a4c8411d0a6c4a300a791fc815a6beea9df18e0dea26c1', '229', 3, 'India', 'Outdoor Salesman', 'sales.gew@gulfenviro.ae', '050 302 7445', NULL, 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'Hassan', 'Istaqlal', 'hassan.istaqlal786@gmail.com', 'e14a32bceecee2a3e4cb4e3ace3e20378ce020e441ca7ec6e1415c0a64982ffd', '228', 3, 'Pakistan', 'Outdoor Salesman', 'sales1@gulfenviro.ae', '054 308 6926', '050 973 8871', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'Rahul', 'Meethal Veedu', 'rahulunni50@yahoo.com', '01eedfca84814400e2452cc89e0d42681fed9227c939f857c1f413c419682605', '129', 3, 'India', 'Operation Incharge', 'rahulunni50@yahoo.com', '052 858 4308', '054 554 7418', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'Zeeshan', 'Fayaz', 'zeeshanabc13@gmail.com', '382a9544cd420336e113cf4675cdb236cb348c27613af791128f58e3213f1a9b', '118', 4, 'Pakistan', 'Sr. Accountant', 'accounts@gulfenviro.ae', NULL, '052 789 6337', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'Ajeesh', 'Peetta Kandiyil', 'ajeesh98@gmail.com', 'ac62acfff02462cf3272c90aae4ff9a22e97a749422ba13d22a11717f71c869f', '148', 4, 'India', 'Asst. Accountant', 'accounts@gulfenviro.ae', NULL, '052 734 1169', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'Azhar', 'Shanihas', 'zhrsha92@gmail.com', 'd33281ae24d5df644a227cfd8ce972c2f99d14b8387a2d9ad477d483072fab72', '176', 5, 'India', 'Computer Engineer', 'admin@gulfenviro.ae', NULL, '052 771 2543', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Reda', 'Nagi', 'reda2010n@gmail.com', 'e198bbf5ed68379a4d7ae4b3e4f5f36a703b6e9971f58a74fd16cb5e1e774b1c', '152', 6, 'Egypt', 'Legal Advisor', 'legal@gulfenviro.ae', '052-858 4630', '055 238 5966', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'Elsideeg', 'Ahmed', 'sideeghassan7@gmail.com', '7457a867bad0e0d3b6a1dde0a7356400db827353a6738742131c82c3219ffab8', '172', 6, 'Sudan', 'Legal Advisor', 'legal@gulfenviro.ae', NULL, '058 904 5440', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Muhammad', 'Fasweeh', 'faseehmech@gmail.com', 'd822d4a138f093385ecf0b327ce0c013aada6cf13f04ef2d5db5c62e532a7b16', '181', 10, 'India', 'Fabrication Engineer', 'qaqc@atlasoasisgt.com', NULL, '055 581 3808', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'Fadi', 'Al-Zir', 'faalzir@gmail.com', '3c95f8871da6c7a43720d4003a0188389008f3da25ddca0a0cb84655b7f867e1', '169', 10, 'Russia', 'Research Engineer', 'research@gulfenviro.ae', '050 213 9105', '058 533 1488', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Sami', 'Masood', 'samimasoodniazi@gmail.com', '40e7ea620a5a6c027b770b05c9381bd29c57fcf74574ad5b112b3b373b09e682', '175', 10, 'Pakistan', 'Mechanical Engineer', 'mechanical2@gulfenviro.ae', NULL, '056 808 7158', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'Arjun', 'Anitha', 'arjun.1219@gmail.com', '0b4792453a196ae6e7d5e8bf357b1f2fe24f2fdf1b025813dac7c062f1bd04e1', '174', 10, 'India', 'Mechanical Engineer', 'mechanical1@gulfenviro.ae', '050 213 8945', '055 795 4331', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Sankarraj', 'Muthusamy', 'sankarraj2325@gmail.com', 'e3a405aa24b1fabd9b260d689f07085a16a1c777ede5c1d7e89cbb4d476fdf19', '222', 10, 'India', 'Fabrication Design Engineer', 'mechanical@gulfenviro.ae', NULL, '054 467 2753', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Ahmed', 'Saleem', 'ishtaiwi-4@hotmail.com', '029b6a104a9ab75dde62749016b866d57f5a833534901e868d21f07e3518e304', '247', 10, 'Jordan', 'Project Manager', 'civil@gulfenviro.ae', NULL, '054 309 7770', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Sayyed Shahzad', 'Hussain', 'shahzad6283626@gmail.com', 'f2091385ea8dfc90ac6a8d930b7e5d6edb86069caccaca58dc0e1cb62a7e97a1', '112', 7, 'Pakistan', 'Chemist', 'energy@gulfenviro.ae', '054 308 6925', '055 868 4481', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Mohamad', 'Charif', 'mohamadcharif1@hotmail.com', 'd9754e29fd1e3e98ece7957d741797ddfbfad2577cf6e0dbe52867c4b1191949', '114', 7, 'Syria', 'Operation Incharge', 'sales@gulfenviro.ae', '055-9354288', '056 288 3689', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Ali Mekkawi', 'Ali Shiha', 'alishiha2011@yahoo.com', '936f1f578d6e48055fa7632377965c4a06f635add2366b1708db29736de94010', '113', 7, 'Egypt', 'Transp Incharge', '', '050 732 9573', '055 177 1957', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Muhammad', 'Bilal', 'bilal_saleem1@hotmail.com', '91d4850a2551aa3da57ea7ba7789cfa1873edda38813918783effc1a6f2caa19', '119', 7, 'Pakistan', 'Electrical Engineer', 'siteops@gulfenviro.ae', NULL, '055 768 7927', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:05', NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Edmer', 'Mellijor', 'mellijored37@yahoo.com', 'c3381893ef3f2495170352c91de12dbe2e40c3471945e1c69f04424a482e6eb7', '133', 9, 'Phillipines', 'Safety Officer', 'maintenance@gulfenviro.ae', '054 308 6927', '058 869 4965', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Syed Fayyaz', 'Hussain', 'fayyaz.hussain463@yahoo.com', '11329658eb2ef41da32b69a8d23c0794c5a1b183999897b033fdbdd910cecf53', '511', 9, 'Pakistan', 'Safety Officer', 'safety@gulfenvironment.ae', NULL, '055 8749717', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Muraleedharan', '', 'magestco@gmail.com', '751cfc80abf2b7189de213fe380b9f050931efc2d8e5f5151ef38e5a2e66f627', '128', 8, 'India', 'Business Consultant', 'murali@gulfenvio.ae', NULL, '050 807 8626', 'Out of station', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Anca', 'Maria', 'dieseldxb1@gmail.com', 'd1fa60493543c338f0ceec29dc06422beb881622d6805fb32cb140806e43f0b9', '177', 8, 'Romania', 'Sales Executive', 'khreport@gulfenviro.ae\r\n\r\nfueloil@gulfenviro.ae', '052 858 2406', '055 8266204', 'Out of station', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Talat', '', 'talat256@gmail.com', '6aaf826ad88baa988476b468f7af75cf49aea7507cef3a8606460b241190b98f', '520', 8, 'Syria', 'Marketing Executive', 'alleqaa@gulfenviro.ae', '055 665 2794', '054 368 5805', 'Abu Dhabi', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Melissa', 'Jane', 'melissa_manlangit02@yahoo.com', '6095b27f78bff2c80e350f5dbccacf6c24b93485e542db15701866a365393728', '179', 11, 'Phillipines', 'HR Assistant', 'dubaislops@gulfenviro.ae', '050 932 0896', '050 901 8575', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Jemilyn', 'Bartolome', 'jemsbartolome28@yahoo.com', 'ebb123aafb8e8849a0ee1bbf6c716524c9919ae73d7352e010e703101cf014a4', '166', 11, 'Philippines', 'Receptionist', 'reception@gulfenviro.ae', NULL, '050 688 0294', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Essudheen', 'Hussain', 'echooshussain@yahoo.com', 'e1c3d11764f93b865f5ba55403c4b1d3248c3495315d155e322e0ab086632a97', '599', 11, 'India', 'PRO / Admin', 'pro@gulfenvironment.ae', '050 6291834', NULL, 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Prakash', '', 'prakashkp726@gmail.com', 'bff8db592fc37369251fc90db905ca8a0cd0981005a9260bd580ed5592da39ae', '590', 11, 'India', 'Admin / Clerk', 'admin@gulfenvironment.ae', '050 6291838', '054 4105067', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Vasilina', 'Vasilyeva', 'vas.vasilina@gmail.com', '37b991f3d44e251552bfd0f66c30a896163cdab7f040071f0541885acd8afa28', '226', 12, 'Russian', 'Office Manager', 'businessdevelopment@gulfenviro.ae', '052 858 5793', '058 533 8687', 'Dubai', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Junaid', 'Anwar', 'junaidey@live.com', '9c8de6c2cbca24d5e3cc6011b113cba705b025d190fedee7c5da0d678a9a3057', '145', 12, 'Pakistan', 'Senior Accountant', 'internalaudit@gulfenviro.ae', '050 899 2431', '056 992 4758', 'Fujairah', 0, NULL, NULL, '2019-10-26 07:59:06', NULL, NULL, NULL, NULL, NULL, NULL);

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
(6, 3),
(43, 5),
(44, 5),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3);

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
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` int(2) NOT NULL,
  `f_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `f_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`fid`, `f_title`, `url`, `type`, `status`, `is_deleted`, `f_created_at`, `f_updated_at`) VALUES
(2, 'TMS - LARAVEL.pdf', 'http://localhost/personal/tasks/uploads/tasks/TMS_-_LARAVEL1.pdf', 0, 0, 0, '2019-11-03 02:43:32', '2019-11-03 02:43:32'),
(3, 'tasks-dev.zip', 'http://localhost/personal/tasks/uploads/tasks/tasks-dev.zip', 0, 0, 0, '2019-11-03 03:09:21', '2019-11-03 03:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `rid` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `berfore` text COLLATE utf8_bin NOT NULL,
  `after` text COLLATE utf8_bin NOT NULL,
  `attachment_id` int(11) NOT NULL DEFAULT '0',
  `status` varchar(11) COLLATE utf8_bin NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`rid`, `task_id`, `user_id`, `berfore`, `after`, `attachment_id`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'before break', 'after break', 0, 'Y', 0, '2019-10-08 08:46:37', '2019-10-08 08:46:37'),
(12, 5, 4, 'perform job very well & Email all Result to MS LINA, ', 'After break work on ', 0, 'H', 0, '2019-10-16 09:48:36', '2019-10-16 09:48:36'),
(10, 2, 4, 'eeeeeeeeeeeeeeeeee', 'rwwwwwwwwwwwwwwwwwww', 0, 'N', 0, '2019-10-15 15:54:57', '2019-10-15 15:54:57'),
(11, 2, 4, 'asdsad', 'bbbbaaaaaahh', 0, 'N', 0, '2019-10-16 09:41:36', '2019-10-16 09:41:36'),
(13, 2, 4, 'est', 'test', 0, 'N', 0, '2019-10-21 02:56:56', '2019-10-21 02:56:56'),
(14, 8, 4, 'Before Break', 'After Break', 0, 'Y', 0, '2019-10-23 05:03:00', '2019-10-23 05:03:00'),
(15, 2, 4, 'BEfore testing', 'AFter testing', 0, 'H', 0, '2019-10-23 05:21:03', '2019-10-23 05:21:03'),
(16, 2, 4, 'Test', 'test', 0, 'N', 0, '2019-11-01 23:05:51', '2019-11-01 23:05:51'),
(17, 8, 4, 'asdasd', 'asdasd', 0, 'Y', 0, '2019-11-02 00:56:01', '2019-11-02 00:56:01'),
(18, 10, 4, 'asdasd', 'usdh kasd', 0, 'H', 0, '2019-11-02 00:59:57', '2019-11-02 00:59:57'),
(19, 10, 4, 'tesd', 'lsdjas ld', 3, 'N', 0, '2019-11-03 03:09:21', '2019-11-03 03:09:21');

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
  `assignee` int(11) NOT NULL COMMENT 'Assigned To',
  `given_by` int(11) NOT NULL COMMENT 'Given To',
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

INSERT INTO `tasks` (`tid`, `t_title`, `t_code`, `department_id`, `parent_id`, `assignee`, `given_by`, `reporter`, `t_status`, `attachment_id`, `t_description`, `t_created_at`, `t_updated_at`, `start_date`, `end_date`, `created_by`) VALUES
(1, 'Sale Report for HEAD department', '2393', 1, 2, 5, 0, 4, '', 0, 'Generate an Report for the sale department where they will mention all monthly sales etc.\r\n', '2019-10-06 00:26:29', '2019-10-06 00:26:29', '2019-10-07 00:00:00', '2019-10-31', 3),
(2, 'office equipment ', '3179', 2, 2, 4, 0, 5, '', 0, 'Manage all thing Expense etc in one file then share with higher management ', '2019-10-06 06:00:03', '2019-10-06 06:00:03', '2019-10-07 00:00:00', '2019-10-17', 3),
(3, 'Make Report for the Account Department', '4604', 1, 3, 3, 0, 4, '', 0, 'Your Main job is to build report on for the account department.Make Report for the Account Department, ', '2019-10-06 06:51:23', '2019-10-06 06:51:23', '2019-10-05 00:00:00', '2019-10-18', 3),
(4, 'Update Database', '6317', 1, 2, 4, 0, 5, '', 0, 'kindly update data base on daily basis , Move your all data on database, Don\'t forget to take back up files', '2019-10-06 07:09:09', '2019-10-06 07:09:09', '2019-10-10 00:00:00', '2019-10-26', 3),
(5, 'Make report for Fujairah', '9374', 2, 2, 4, 0, 5, '', 0, 'Make Report for the Fujairah Staff & Add All data in one file', '2019-10-06 07:26:33', '2019-10-06 07:26:33', '2019-10-07 00:00:00', '2019-10-15', 3),
(6, 'Test Title', '6441', 5, 4, 4, 0, 4, '', 0, 'Test Description', '2019-10-22 06:19:35', '2019-10-22 06:19:35', '2019-10-22 00:00:00', '2019-10-24', 3),
(7, 'Test ', '6747', 0, 1, 5, 0, 0, '', 0, '', '2019-10-23 04:01:56', '2019-10-23 04:01:56', '0000-00-00 00:00:00', '', 3),
(8, 'Test Task 2', '9928', 4, 1, 4, 0, 5, '', 0, 'test description goes here ', '2019-10-23 04:04:57', '2019-10-23 04:04:57', '2019-10-15 00:00:00', '2019-10-26', 3),
(9, 'Test Employee Task', '2361', 5, 2, 4, 0, 47, '', 0, 'test employee description', '2019-10-28 00:41:07', '2019-10-28 00:41:07', '2019-10-28 00:00:00', '2019-10-31', 4),
(10, 'Test Title Employee 2', '4459', 4, 1, 4, 0, 46, '', 0, 'Test Title Employee 2', '2019-10-28 01:44:37', '2019-10-28 01:44:37', '2019-10-28 00:00:00', '2019-10-31', 4),
(11, 'asdasd', '6696', 1, 3, 4, 0, 5, '', 0, 'sdasdasdasd', '2019-11-03 01:39:23', '2019-11-03 01:39:23', '0000-00-00 00:00:00', '11/19/2019', 4),
(12, 'asdasdas ', '3762', 4, 1, 4, 0, 6, '', 1, 'sdasdasd', '2019-11-03 02:41:35', '2019-11-03 02:41:35', '0000-00-00 00:00:00', '11/26/2019', 4),
(13, 'Section 1', '6715', 2, 1, 4, 0, 5, '', 2, 'asdasdasd', '2019-11-03 02:43:32', '2019-11-03 02:43:32', '0000-00-00 00:00:00', '11/13/2019', 4);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `aauth_perms`
--
ALTER TABLE `aauth_perms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `aauth_pms`
--
ALTER TABLE `aauth_pms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aauth_users`
--
ALTER TABLE `aauth_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

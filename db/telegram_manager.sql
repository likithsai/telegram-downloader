-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2021 at 07:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telegram_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_manager`
--

CREATE TABLE `t_manager` (
  `m_id` int(11) NOT NULL,
  `m_uid` varchar(100) CHARACTER SET latin1 NOT NULL,
  `m_type` int(11) NOT NULL,
  `m_userid` int(11) NOT NULL,
  `m_schedule` int(11) NOT NULL,
  `m_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_manager`
--

INSERT INTO `t_manager` (`m_id`, `m_uid`, `m_type`, `m_userid`, `m_schedule`, `m_date`) VALUES
(43, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 1, 1, 1, '2021-03-14 15:53:05');

-- --------------------------------------------------------

--
-- Table structure for table `t_manager_type`
--

CREATE TABLE `t_manager_type` (
  `mtype_id` int(11) NOT NULL,
  `mtype_name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `mtype_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_manager_type`
--

INSERT INTO `t_manager_type` (`mtype_id`, `mtype_name`, `mtype_date`) VALUES
(1, 'bot', '2021-03-01 08:33:53'),
(2, 'channel', '2021-03-01 08:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `t_messages`
--

CREATE TABLE `t_messages` (
  `msg_id` int(11) NOT NULL,
  `msg_content` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_uid` int(11) NOT NULL,
  `msg_botid` varchar(100) CHARACTER SET latin1 NOT NULL,
  `msg_schedule` tinyint(1) NOT NULL DEFAULT 0,
  `msg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_messages`
--

INSERT INTO `t_messages` (`msg_id`, `msg_content`, `msg_uid`, `msg_botid`, `msg_schedule`, `msg_date`) VALUES
(1, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 08:11:50'),
(2, 'scsacsa', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 08:21:00'),
(9, 'simple links\r\nhttps://stackoverflow.com/questions/6768793/get-the-full-url-in-php', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 16:20:31'),
(10, 'simple-message', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 1, '2021-03-20 16:26:37'),
(11, 'This is simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 16:42:24'),
(12, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 1, '2021-03-20 17:10:33'),
(13, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:10:49'),
(14, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:13:42'),
(15, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:22:16'),
(16, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:23:33'),
(17, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:25:46'),
(18, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:28:53'),
(19, 'simple example', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:30:48'),
(20, 'idcbuidscu8dsguicdbsuivbdsuivdsugduicduicgudgciudciodsbcikdsbkbsduccbdsiucbuidscgiudskjsdbuidsgcuids', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 1, '2021-03-20 17:39:01'),
(21, '????', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:49:03'),
(22, '????????', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-20 17:49:42'),
(23, 'uydgyusdc\r\n', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-21 16:17:25'),
(24, 'uydgyusdc\r\n', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-21 16:17:38'),
(25, 'Djdbdh', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-27 16:55:42'),
(26, '???? Birthday', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-28 14:41:02'),
(27, '???? Birthday', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-28 14:44:11'),
(28, '🎂 Birthday', 1, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', 0, '2021-03-28 14:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `u_id` int(11) NOT NULL,
  `u_username` varchar(2000) CHARACTER SET latin1 NOT NULL,
  `u_password` varchar(2000) CHARACTER SET latin1 NOT NULL,
  `u_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`u_id`, `u_username`, `u_password`, `u_date`) VALUES
(1, 'admin', 'admin', '2021-03-01 08:08:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_manager`
--
ALTER TABLE `t_manager`
  ADD PRIMARY KEY (`m_id`),
  ADD UNIQUE KEY `m_uid` (`m_uid`),
  ADD KEY `manager_userid` (`m_userid`),
  ADD KEY `m_type` (`m_type`);

--
-- Indexes for table `t_manager_type`
--
ALTER TABLE `t_manager_type`
  ADD PRIMARY KEY (`mtype_id`);

--
-- Indexes for table `t_messages`
--
ALTER TABLE `t_messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `msg_uid` (`msg_uid`),
  ADD KEY `msg_botid` (`msg_botid`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_manager`
--
ALTER TABLE `t_manager`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `t_manager_type`
--
ALTER TABLE `t_manager_type`
  MODIFY `mtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_messages`
--
ALTER TABLE `t_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_manager`
--
ALTER TABLE `t_manager`
  ADD CONSTRAINT `t_manager_ibfk_1` FOREIGN KEY (`m_userid`) REFERENCES `t_user` (`u_id`),
  ADD CONSTRAINT `t_manager_ibfk_2` FOREIGN KEY (`m_type`) REFERENCES `t_manager_type` (`mtype_id`);

--
-- Constraints for table `t_messages`
--
ALTER TABLE `t_messages`
  ADD CONSTRAINT `t_messages_ibfk_1` FOREIGN KEY (`msg_uid`) REFERENCES `t_user` (`u_id`),
  ADD CONSTRAINT `t_messages_ibfk_2` FOREIGN KEY (`msg_botid`) REFERENCES `t_manager` (`m_uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 06:20 PM
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
  `m_chatid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `m_type` int(11) NOT NULL,
  `m_userid` int(11) NOT NULL,
  `m_schedule` int(11) NOT NULL,
  `m_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_manager`
--

INSERT INTO `t_manager` (`m_id`, `m_uid`, `m_chatid`, `m_type`, `m_userid`, `m_schedule`, `m_date`) VALUES
(46, '1642261514:AAGIyCFfX8UGkKLYEqGXKIjWOGLYLuXdd4U', '-1001436094290', 1, 1, 0, '2021-04-03 16:05:43');

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
  `telegram_msg_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_content` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_uid` int(11) NOT NULL,
  `msg_botid` varchar(100) CHARACTER SET latin1 NOT NULL,
  `msg_schedule` tinyint(1) NOT NULL DEFAULT 0,
  `msg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `t_manager_type`
--
ALTER TABLE `t_manager_type`
  MODIFY `mtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_messages`
--
ALTER TABLE `t_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `t_messages_ibfk_1` FOREIGN KEY (`msg_uid`) REFERENCES `t_user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

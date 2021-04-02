-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2021 at 08:55 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

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

DROP TABLE IF EXISTS `t_manager`;
CREATE TABLE IF NOT EXISTS `t_manager` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_uid` varchar(100) CHARACTER SET latin1 NOT NULL,
  `m_chatid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `m_type` int(11) NOT NULL,
  `m_userid` int(11) NOT NULL,
  `m_schedule` int(11) NOT NULL,
  `m_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`m_id`),
  UNIQUE KEY `m_uid` (`m_uid`),
  KEY `manager_userid` (`m_userid`),
  KEY `m_type` (`m_type`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_manager`
--

INSERT INTO `t_manager` (`m_id`, `m_uid`, `m_chatid`, `m_type`, `m_userid`, `m_schedule`, `m_date`) VALUES
(45, '1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI', '-1001436094290', 1, 1, 0, '2021-04-02 08:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `t_manager_type`
--

DROP TABLE IF EXISTS `t_manager_type`;
CREATE TABLE IF NOT EXISTS `t_manager_type` (
  `mtype_id` int(11) NOT NULL AUTO_INCREMENT,
  `mtype_name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `mtype_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mtype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `t_messages`;
CREATE TABLE IF NOT EXISTS `t_messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_content` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_uid` int(11) NOT NULL,
  `msg_botid` varchar(100) CHARACTER SET latin1 NOT NULL,
  `msg_schedule` tinyint(1) NOT NULL DEFAULT '0',
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`),
  KEY `msg_uid` (`msg_uid`),
  KEY `msg_botid` (`msg_botid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE IF NOT EXISTS `t_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(2000) CHARACTER SET latin1 NOT NULL,
  `u_password` varchar(2000) CHARACTER SET latin1 NOT NULL,
  `u_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`u_id`, `u_username`, `u_password`, `u_date`) VALUES
(1, 'admin', 'admin', '2021-03-01 08:08:52');

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

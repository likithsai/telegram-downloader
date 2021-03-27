-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 13, 2021 at 04:00 AM
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
  `m_title` varchar(20) NOT NULL,
  `m_desc` varchar(200) NOT NULL,
  `m_uid` varchar(100) NOT NULL,
  `m_type` int(11) NOT NULL,
  `m_userid` int(11) NOT NULL,
  `m_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`m_id`),
  KEY `manager_userid` (`m_userid`),
  KEY `m_type` (`m_type`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_manager`
--

INSERT INTO `t_manager` (`m_id`, `m_title`, `m_desc`, `m_uid`, `m_type`, `m_userid`, `m_date`) VALUES
(39, 'Simple Telegram Bot', 'simple telegram bot example', 'csucshjbijudfidvudibi', 1, 1, '2021-03-13 03:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `t_manager_type`
--

DROP TABLE IF EXISTS `t_manager_type`;
CREATE TABLE IF NOT EXISTS `t_manager_type` (
  `mtype_id` int(11) NOT NULL AUTO_INCREMENT,
  `mtype_name` varchar(20) NOT NULL,
  `mtype_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mtype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_manager_type`
--

INSERT INTO `t_manager_type` (`mtype_id`, `mtype_name`, `mtype_date`) VALUES
(1, 'bot', '2021-03-01 08:33:53'),
(2, 'channel', '2021-03-01 08:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE IF NOT EXISTS `t_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(2000) NOT NULL,
  `u_password` varchar(2000) NOT NULL,
  `u_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

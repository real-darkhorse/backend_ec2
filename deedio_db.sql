-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2016 at 11:37 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `deedio_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donate`
--

CREATE TABLE IF NOT EXISTS `tbl_donate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pay_production` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_donate`
--

INSERT INTO `tbl_donate` (`id`, `name`, `pay_production`) VALUES
(1, 'test', '111111111111'),
(2, 'testss', '222222222222');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donate_owner`
--

CREATE TABLE IF NOT EXISTS `tbl_donate_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pay_production` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_donate_owner`
--

INSERT INTO `tbl_donate_owner` (`id`, `name`, `pay_production`) VALUES
(1, 'test_owner', '111111111111');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

CREATE TABLE IF NOT EXISTS `tbl_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `tbl_log`
--

INSERT INTO `tbl_log` (`id`, `title`, `content`, `time`) VALUES
(44, 'pay2owner', 'abcdef paid to 3 $12', '2016-06-16 16:22:22'),
(45, 'pay2owner', 'abcdef paid to 3 $12', '2016-06-16 16:22:47'),
(46, 'pay2owner', 'abcdef paid to 3 $12', '2016-06-16 16:23:19'),
(47, 'pay2owner', 'abcdef paid to 3 $12', '2016-06-16 16:26:51'),
(48, 'pay2owner', 'abcdef paid to 3 $12', '2016-06-16 16:27:50'),
(49, 'pay2owner', 'abcdef paid to 2 $12', '2016-06-16 16:28:06'),
(50, 'pay2owner', 'abcdef paid to 2 $12', '2016-06-16 16:28:14'),
(51, 'pay2owner', 'abcdef paid to 2 $12', '2016-06-16 16:33:35'),
(52, 'edit profile', '122 updated profile', '2016-06-16 17:01:10'),
(53, 'edit profile', '122 updated profile', '2016-06-16 17:02:07'),
(54, 'edit profile', '122 updated profile', '2016-06-16 17:27:18'),
(55, 'signup', 'test1test2 signup', '2016-06-16 17:31:26'),
(56, 'donatelist', 'test1test2 get donatelist', '2016-06-16 17:31:27'),
(57, 'pay2owner', 'test1test2 paid to 2 $11.000000', '2016-06-16 17:31:45'),
(58, 'login', 'test1test2 login', '2016-06-16 17:32:42'),
(59, 'donatelist', 'test1test2 get donatelist', '2016-06-16 17:32:43'),
(60, 'edit profile', 'test1test2 updated profile', '2016-06-16 17:32:58'),
(61, 'login', 'test1test2 login', '2016-06-16 18:11:33'),
(62, 'donatelist', 'test1test2 get donatelist', '2016-06-16 19:18:26'),
(63, 'login', 'test1test2 login', '2016-06-16 19:22:34'),
(64, 'donatelist', 'test1test2 get donatelist', '2016-06-16 19:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pay2donate`
--

CREATE TABLE IF NOT EXISTS `tbl_pay2donate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p2o_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pay2owner`
--

CREATE TABLE IF NOT EXISTS `tbl_pay2owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `donate_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_pay2owner`
--

INSERT INTO `tbl_pay2owner` (`id`, `user_id`, `amount`, `donate_id`, `time`) VALUES
(1, 15, 12, 3, '2016-06-16 16:27:50'),
(2, 15, 12, 2, '2016-06-16 16:28:06'),
(3, 15, 12, 2, '2016-06-16 16:28:14'),
(4, 15, 12, 2, '2016-06-16 16:33:35'),
(5, 18, 11, 2, '2016-06-16 17:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `hash` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `firstname`, `lastname`, `username`, `email`, `mobile`, `password`, `active`, `hash`) VALUES
(14, 'm1', 'n1', 'm1n1', 'm1@n1.com', '1234567', '96e79218965eb72c92a549dd5a330112', 1, '0978055129d96b5f'),
(15, '12', '2', '122', 'aaa@ad.com', '3234211', 'ssssss', 1, 'eb1bfb4c8619080e'),
(16, '1111', '2222', '1111 2222', 'aaaa@aaaa.com', '1111', 'aaa', 1, '99c15a7463b1a67b'),
(17, '11112', '2222', '11112 2222', 'aaa2a@aaaa.com', '1111', 'aaa', 1, '9ccdf72d3ead7c3b'),
(18, 'test1', 'test2', 'test1test2', 'test1@a.com', '1111111', '47bce5c74f589f4867dbd57e9ca9f808', 1, 'e2a5114aeddaad54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

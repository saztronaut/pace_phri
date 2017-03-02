-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2017 at 05:59 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `paceup`
--

-- --------------------------------------------------------

--
-- Table structure for table `methods`
--

CREATE TABLE IF NOT EXISTS `methods` (
  `methodID` char(3) COLLATE utf8_general_mysql500_ci NOT NULL,
  `method_name` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`methodID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `methods`
--

INSERT INTO `methods` (`methodID`, `method_name`) VALUES
('ACT', 'Actigraph'),
('FIT', 'Fitbit'),
('GAR', 'Garmin'),
('JAW', 'Jawbone'),
('PED', 'Pedometer'),
('TOM', 'Tom Tom'),
('ZZZ', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `week` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`username`,`week`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`username`, `week`, `text`) VALUES
('bruce', 2, 'I will gain lots of friends and become more handsome'),
('bruce', 5, 'If no one wants to go for a walk with me I will bark until they take me '),
('bruce', 6, 'Me? So Handsome and so many friends. Friendship is so important to me');

-- --------------------------------------------------------

--
-- Table structure for table `practices`
--

CREATE TABLE IF NOT EXISTS `practices` (
  `pracID` char(3) COLLATE utf8_general_mysql500_ci NOT NULL,
  `practice_name` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`pracID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `practices`
--

INSERT INTO `practices` (`pracID`, `practice_name`) VALUES
('AAA', 'Dummy'),
('ELM', 'Elm Road Practice'),
('gry', 'grey');

-- --------------------------------------------------------

--
-- Table structure for table `readings`
--

CREATE TABLE IF NOT EXISTS `readings` (
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `date_read` date NOT NULL,
  `date_entered` date NOT NULL,
  `add_walk` tinyint(4) DEFAULT NULL,
  `steps` int(11) NOT NULL,
  `method` char(3) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`username`,`date_read`),
  KEY `method` (`method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `readings`
--

INSERT INTO `readings` (`username`, `date_read`, `date_entered`, `add_walk`, `steps`, `method`) VALUES
('bennet', '2017-01-03', '2017-01-03', NULL, 5000, NULL),
('bennet', '2017-01-04', '2017-01-04', NULL, 5555, NULL),
('bennet', '2017-01-05', '2017-01-05', NULL, 5000, NULL),
('bennet', '2017-06-04', '2017-06-04', NULL, 5555, NULL),
('bennett', '2017-02-17', '2017-02-23', 0, 9999, 'PED'),
('bennett', '2017-02-19', '2017-02-23', 0, 9999, 'PED'),
('bennett', '2017-02-20', '2017-02-23', 0, 8888, 'PED'),
('bruce', '2017-01-13', '2017-01-19', NULL, 1234, 'PED'),
('bruce', '2017-01-14', '2017-01-19', NULL, 7890, 'PED'),
('bruce', '2017-01-15', '2017-01-19', NULL, 7890, 'PED'),
('bruce', '2017-01-16', '2017-01-19', NULL, 8765, 'PED'),
('bruce', '2017-01-17', '2017-01-19', NULL, 6789, 'PED'),
('bruce', '2017-01-18', '2017-01-19', 1, 7890, 'PED'),
('bruce', '2017-01-19', '2017-01-19', NULL, 3456, 'PED'),
('bruce', '2017-01-20', '2017-01-20', 0, 6789, 'PED'),
('bruce', '2017-01-22', '2017-01-23', 0, 6789, 'PED'),
('bruce', '2017-01-23', '2017-01-23', 0, 10000, 'PED'),
('bruce', '2017-01-24', '2017-01-24', 0, 9999, 'PED'),
('bruce', '2017-01-25', '2017-01-25', 1, 9998, 'PED'),
('bruce', '2017-01-26', '2017-02-01', 1, 6789, 'PED'),
('bruce', '2017-01-29', '2017-02-14', 1, 222, 'PED'),
('bruce', '2017-01-30', '2017-02-01', 1, 6543, 'PED'),
('bruce', '2017-01-31', '2017-02-01', 1, 9000, 'PED'),
('bruce', '2017-02-01', '2017-02-14', 1, 5467, 'PED'),
('bruce', '2017-02-02', '2017-02-14', 1, 9999, 'PED'),
('bruce', '2017-02-03', '2017-02-14', 1, 9999, 'PED'),
('bruce', '2017-02-04', '2017-02-15', 1, 8765, 'PED'),
('bruce', '2017-02-05', '2017-02-20', 0, 444, 'PED'),
('bruce', '2017-02-06', '2017-02-16', 1, 7987, 'PED'),
('bruce', '2017-02-07', '2017-02-16', 1, 8768, 'PED'),
('bruce', '2017-02-08', '2017-02-16', 1, 9999, 'PED'),
('bruce', '2017-02-09', '2017-02-20', 1, 8, 'PED'),
('bruce', '2017-02-10', '2017-02-20', 1, 900, 'PED'),
('bruce', '2017-02-11', '2017-02-14', 1, 0, 'PED'),
('bruce', '2017-02-12', '2017-02-15', 1, 5643, 'PED'),
('bruce', '2017-02-13', '2017-02-15', 1, 7801, 'PED'),
('bruce', '2017-02-14', '2017-02-15', 1, 9000, 'PED'),
('bruce', '2017-02-15', '2017-02-16', 1, 8765, 'PED'),
('bruce', '2017-02-16', '2017-02-16', 1, 999, 'PED'),
('bruce', '2017-02-17', '2017-02-20', 1, 9999, 'PED'),
('bruce', '2017-02-18', '2017-02-20', 1, 10999, 'PED'),
('bruce', '2017-02-19', '2017-02-20', 1, 12345, 'PED'),
('bruce', '2017-02-20', '2017-02-20', 0, 9887, 'PED'),
('bruce', '2017-02-21', '2017-03-01', 1, 10000, 'PED'),
('bruce', '2017-02-22', '2017-03-02', 0, 9876, 'GAR'),
('bruce', '2017-02-24', '2017-03-02', 0, 8899, 'PED'),
('bruce', '2017-02-25', '2017-03-02', 1, 9876, 'PED'),
('bruce', '2017-02-26', '2017-03-02', 1, 8907, 'FIT'),
('bruce', '2017-02-27', '2017-03-02', 1, 9876, 'PED'),
('bruce', '2017-02-28', '2017-03-02', 0, 11000, 'ACT'),
('charlotte', '2017-02-21', '2017-02-22', 0, 10000, 'PED'),
('charlotte', '2017-02-24', '2017-03-02', 0, 3456, 'PED'),
('charlotte', '2017-02-25', '2017-03-02', 0, 4567, 'PED'),
('charlotte', '2017-03-02', '2017-03-02', 1, 7550, 'PED'),
('jamesy', '1970-01-01', '2017-01-25', 1, 6789, 'PED'),
('jamesy', '2017-01-20', '2017-02-16', 1, 11000, 'PED'),
('jamesy', '2017-01-21', '2017-02-16', 1, 9088, 'PED'),
('jamesy', '2017-01-22', '2017-02-16', 1, 9999, 'PED'),
('jamesy', '2017-01-23', '2017-02-16', 1, 9999, 'PED'),
('jamesy', '2017-01-24', '2017-02-16', 1, 9876, 'PED'),
('jamesy', '2017-01-25', '2017-01-25', 1, 2345, 'PED'),
('jamesy', '2017-02-01', '2017-02-14', 1, 7654, 'PED'),
('jamesy', '2017-02-04', '2017-02-16', 1, 8999, 'PED'),
('jamesy', '2017-02-05', '2017-02-16', 1, 9999, 'PED'),
('jamesy', '2017-02-06', '2017-02-16', 1, 12000, 'PED'),
('jamesy', '2017-02-07', '2017-02-16', 1, 14000, 'PED'),
('jamesy', '2017-02-09', '2017-02-16', 1, 9800, 'PED'),
('jamesy', '2017-02-10', '2017-02-16', 1, 9999, 'PED'),
('jamesy', '2017-02-11', '2017-02-16', 1, 8768, 'PED'),
('jamesy', '2017-02-12', '2017-02-16', 1, 9876, 'PED'),
('jamesy', '2017-02-17', '2017-02-28', 1, 9878, 'PED'),
('jamesy', '2017-02-18', '2017-02-28', 1, 9896, 'PED'),
('jamesy', '2017-02-19', '2017-02-28', 1, 9976, 'PED'),
('jamesy', '2017-02-20', '2017-02-28', 1, 9966, 'PED'),
('jamesy', '2017-02-21', '2017-02-28', 1, 9955, 'PED'),
('jamesy', '2017-02-23', '2017-02-28', 1, 9900, 'PED'),
('jamesy', '2017-02-24', '2017-02-28', 1, 9855, 'PED'),
('jamesy', '2017-02-25', '2017-02-28', 1, 9810, 'PED'),
('jamesy', '2017-02-26', '2017-02-28', 1, 10820, 'PED'),
('jamesy', '2017-02-27', '2017-02-28', 1, 10822, 'PED'),
('jamesy', '2017-02-28', '2017-02-28', 1, 9926, 'PED'),
('johnny', '2017-01-16', '2017-01-19', NULL, 6780, 'PED'),
('johnny', '2017-01-17', '2017-01-20', 0, 5678, 'PED'),
('johnny', '2017-01-18', '2017-01-19', NULL, 6789, 'PED'),
('johnny', '2017-01-19', '2017-01-19', NULL, 8906, 'PED'),
('johnny', '2017-01-20', '2017-01-20', 0, 3456, 'PED'),
('johnny', '2017-01-22', '2017-01-24', 0, 2345, 'PED'),
('johnny', '2017-01-23', '2017-01-26', 1, 600, 'PED'),
('johnny', '2017-01-24', '2017-01-24', 1, 8907, 'PED'),
('johnny', '2017-01-25', '2017-01-25', 1, 8900, 'PED'),
('johnny', '2017-01-30', '2017-02-01', 1, 7890, 'PED'),
('johnny', '2017-01-31', '2017-02-03', 1, 8954, 'PED'),
('johnny', '2017-02-01', '2017-02-05', 1, 9999, 'PED'),
('johnny', '2017-02-02', '2017-02-03', 1, 9999, 'PED'),
('johnny', '2017-02-03', '2017-02-05', 1, 8765, 'PED'),
('johnny', '2017-02-04', '2017-02-05', 1, 1234, 'PED'),
('johnny', '2017-02-06', '2017-02-23', 1, 9800, 'PED'),
('johnny', '2017-02-14', '2017-02-22', 1, 9000, 'PED'),
('johnny', '2017-02-21', '2017-02-23', 1, 9999, 'PED'),
('johnny', '2017-02-24', '2017-02-23', 0, 7658, 'PED'),
('sarah', '2017-01-13', '2017-01-19', NULL, 1234, 'PED'),
('sarah', '2017-01-14', '2017-01-19', NULL, 1234, 'PED'),
('sarah', '2017-01-19', '2017-01-19', NULL, 6789, 'PED'),
('seamus', '2017-01-20', '2017-01-25', 0, 7655, 'JAW'),
('seamus', '2017-01-21', '2017-01-25', 0, 6789, 'PED'),
('seamus', '2017-01-22', '2017-01-25', 0, 7654, 'PED'),
('seamus', '2017-01-23', '2017-01-25', 0, 6547, 'PED'),
('seamus', '2017-01-24', '2017-01-25', 0, 8765, 'PED'),
('topher', '2017-01-01', '2017-02-01', NULL, 5000, 'PED'),
('topher', '2017-01-02', '2017-02-02', NULL, 5555, 'PED'),
('topher', '2017-01-23', '2017-01-23', 0, 5678, 'PED'),
('topher', '2017-02-03', '2017-02-03', NULL, 5000, 'PED'),
('topher', '2017-02-04', '2017-02-04', NULL, 5555, 'PED'),
('topher', '2017-02-18', '2017-02-24', 0, 9999, 'PED'),
('topher', '2017-02-19', '2017-02-24', 0, 8796, 'PED'),
('topher', '2017-02-20', '2017-02-24', 0, 7658, 'PED'),
('topher', '2017-02-21', '2017-02-24', 0, 8765, 'PED'),
('topher', '2017-02-22', '2017-02-24', 0, 9999, 'PED'),
('topher', '2017-02-23', '2017-02-24', 0, 9876, 'PED'),
('topher', '2017-02-24', '2017-02-24', 0, 8769, 'PED');

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE IF NOT EXISTS `reference` (
  `referenceID` char(9) COLLATE utf8_general_mysql500_ci NOT NULL,
  `issue_date` date NOT NULL,
  `in_use` tinyint(1) NOT NULL,
  `practice` char(3) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`referenceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci COMMENT='Stores references to be checked on user creation. May not need to be kept';

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`referenceID`, `issue_date`, `in_use`, `practice`) VALUES
('0012b02bc', '2017-02-22', 0, 'AAA'),
('021c74373', '2017-02-22', 0, 'AAA'),
('03623ef9a', '2017-02-22', 0, 'AAA'),
('0382af906', '2017-02-22', 0, 'AAA'),
('0b991b66e', '2017-02-22', 0, 'ELM'),
('0bfab472f', '2017-02-22', 0, 'AAA'),
('0d9885863', '2017-02-22', 0, 'AAA'),
('0dd4241dc', '2017-02-21', 0, 'AAA'),
('1523d67a0', '2017-03-01', 0, 'ELM'),
('15b3d30c3', '2017-02-22', 0, 'AAA'),
('19a3f347e', '2017-02-22', 1, 'AAA'),
('1ee052a98', '2017-02-27', 1, 'ELM'),
('1f248cb9a', '2017-02-22', 0, 'AAA'),
('1fce72d72', '2017-02-22', 0, 'AAA'),
('20c147f3b', '2017-02-22', 0, 'AAA'),
('21e1f7eee', '2017-02-22', 0, 'AAA'),
('22cd88e08', '2017-02-22', 0, 'AAA'),
('23226e44a', '2017-02-27', 1, 'ELM'),
('23523769f', '2017-02-22', 0, 'AAA'),
('24316a492', '2017-02-22', 0, 'AAA'),
('2723c194f', '2017-02-22', 0, 'AAA'),
('2c7088ab7', '2017-02-22', 0, 'AAA'),
('2d92e8b62', '2017-02-22', 1, 'ELM'),
('2efdd0d48', '2017-02-22', 0, 'AAA'),
('2f1cf3fca', '2017-02-22', 0, 'AAA'),
('2ff783aec', '2017-02-22', 0, 'AAA'),
('301523cb4', '2017-02-27', 0, 'ELM'),
('3298b43fa', '2017-02-22', 0, 'AAA'),
('342c8b792', '2017-02-22', 0, 'ELM'),
('35bb2bd24', '2017-03-01', 0, 'ELM'),
('35c229f93', '2017-02-22', 0, 'AAA'),
('35e4a74c8', '2017-02-22', 0, 'AAA'),
('3738220a2', '2017-02-22', 0, 'AAA'),
('3801bfa3c', '2017-02-21', 0, 'AAA'),
('3b3808565', '2017-02-22', 0, 'AAA'),
('3baa029af', '2017-02-22', 0, 'ELM'),
('3e4d288c7', '2017-02-22', 0, 'AAA'),
('3e574e9de', '2017-02-22', 0, 'AAA'),
('3eb1946f8', '2017-02-22', 0, 'ELM'),
('3f4886cd0', '2017-02-27', 0, 'ELM'),
('4279fbc44', '2017-02-22', 0, 'ELM'),
('43b6b7243', '2017-02-22', 0, 'AAA'),
('46f9ed55d', '2017-02-27', 0, 'ELM'),
('4729476c6', '2017-02-22', 0, 'AAA'),
('4b07b256a', '2017-02-22', 0, 'AAA'),
('4bcd07558', '2017-02-22', 0, 'ELM'),
('4c3141f69', '2017-02-27', 0, 'ELM'),
('4f174d73d', '2017-02-23', 0, 'ELM'),
('51758ff61', '2017-02-22', 0, 'AAA'),
('52cf3d2f0', '2017-02-22', 0, 'AAA'),
('52e600149', '2017-02-22', 0, 'AAA'),
('531dc241d', '2017-02-22', 0, 'AAA'),
('548602ed5', '2017-02-22', 0, 'AAA'),
('55533c3de', '2017-02-22', 0, 'AAA'),
('574d298c8', '2017-02-22', 0, 'ELM'),
('59420c1a8', '2017-02-22', 0, 'AAA'),
('59723ffdb', '2017-02-22', 0, 'ELM'),
('5d0fa467b', '2017-02-27', 0, 'ELM'),
('5d68048f1', '2017-02-22', 0, 'ELM'),
('5d7d8eb8a', '2017-02-22', 0, 'AAA'),
('5e00b9486', '2017-02-27', 0, 'ELM'),
('5e7860669', '2017-02-22', 0, 'AAA'),
('5f3029246', '2017-02-22', 0, 'AAA'),
('6031aa7cc', '2017-02-21', 0, 'AAA'),
('60ee1bb98', '2017-02-27', 0, 'ELM'),
('60f90e340', '2017-02-22', 0, 'AAA'),
('61c583547', '2017-02-22', 0, 'AAA'),
('639cc7aeb', '2017-02-22', 0, 'AAA'),
('640399ba8', '2017-02-22', 0, 'AAA'),
('6507fd977', '2017-02-22', 0, 'AAA'),
('66b470ed5', '2017-02-22', 0, 'AAA'),
('66ddef2d4', '2017-02-22', 0, 'ELM'),
('688eb6272', '2017-02-22', 0, 'AAA'),
('69a2f31a7', '2017-02-22', 0, 'AAA'),
('69c5d34e5', '2017-02-22', 0, 'AAA'),
('6d208a933', '2017-02-22', 0, 'AAA'),
('6d36e0d64', '2017-02-23', 0, 'ELM'),
('6e4fba618', '2017-02-22', 0, 'AAA'),
('6ed3387d9', '2017-02-27', 0, 'ELM'),
('6f0c48eba', '2017-02-22', 0, 'AAA'),
('6fc225c97', '2017-03-01', 0, 'ELM'),
('6fe1fd843', '2017-02-22', 0, 'AAA'),
('7033c9e88', '2017-02-22', 0, 'AAA'),
('73366faf5', '2017-02-22', 0, 'ELM'),
('7622a93d0', '2017-02-22', 0, 'ELM'),
('763a57e68', '2017-02-22', 0, 'AAA'),
('783906e8a', '2017-02-22', 0, 'AAA'),
('78de7c141', '2017-02-22', 0, 'AAA'),
('79a5f80ac', '2017-02-22', 0, 'AAA'),
('7a5c81c2f', '2017-02-22', 0, 'ELM'),
('7c8172479', '2017-02-21', 0, 'AAA'),
('7e1889e21', '2017-02-22', 0, 'AAA'),
('7f8493f9a', '2017-02-22', 0, 'AAA'),
('804ee5a75', '2017-02-22', 0, 'AAA'),
('808bb3a8e', '2017-02-22', 0, 'AAA'),
('80cfad8eb', '2017-02-22', 0, 'AAA'),
('816631733', '2017-02-22', 0, 'AAA'),
('81bedd09e', '2017-02-22', 0, 'AAA'),
('825028129', '2017-02-22', 0, 'ELM'),
('82d11393b', '2017-02-22', 0, 'AAA'),
('832a090fe', '2017-02-22', 0, 'AAA'),
('8422e0ec7', '2017-02-27', 0, 'ELM'),
('85919f0e3', '2017-02-23', 0, 'ELM'),
('86457ef68', '2017-02-21', 0, 'AAA'),
('86a260e14', '2017-02-22', 0, 'AAA'),
('8835d3589', '2017-02-22', 0, 'ELM'),
('89cb91280', '2017-02-22', 0, 'ELM'),
('8c76d3c23', '2017-03-01', 0, 'ELM'),
('8de30b1db', '2017-02-22', 0, 'AAA'),
('8e1c1b1a5', '2017-02-22', 0, 'AAA'),
('8f7872510', '2017-02-22', 0, 'ELM'),
('9012d9f3d', '2017-02-22', 0, 'AAA'),
('91d4f623c', '2017-02-22', 0, 'AAA'),
('9232919ba', '2017-02-27', 0, 'ELM'),
('93056c3fb', '2017-02-22', 0, 'AAA'),
('9405b5c97', '2017-02-22', 0, 'AAA'),
('97fb2a09f', '2017-02-27', 0, 'ELM'),
('98f9c6949', '2017-02-27', 0, 'ELM'),
('9f2c57fb7', '2017-02-22', 0, 'AAA'),
('9f97aa915', '2017-02-22', 0, 'AAA'),
('a1219a9c1', '2017-02-27', 0, 'ELM'),
('a2609752f', '2017-02-22', 0, 'AAA'),
('a2622c23f', '2017-02-22', 0, 'AAA'),
('a32a45924', '2017-02-23', 0, 'ELM'),
('a4459cd3e', '2017-02-22', 0, 'AAA'),
('a6046cad0', '2017-02-27', 0, 'ELM'),
('a67ab2835', '2017-02-22', 0, 'AAA'),
('a68ff8bda', '2017-02-22', 0, 'AAA'),
('a6a921455', '2017-02-21', 0, 'AAA'),
('a80d69d61', '2017-02-23', 0, 'ELM'),
('a828f8821', '2017-02-22', 0, 'AAA'),
('a86b9e625', '2017-02-22', 0, 'ELM'),
('a98e33bd5', '2017-02-22', 0, 'ELM'),
('aa717bfe3', '2017-02-22', 0, 'AAA'),
('ad730efff', '2017-02-22', 0, 'AAA'),
('aeee34567', '2017-02-22', 0, 'AAA'),
('af520774f', '2017-02-22', 0, 'AAA'),
('afd64509c', '2017-02-22', 0, 'ELM'),
('aff9b4f31', '2017-02-22', 0, 'AAA'),
('b1268f370', '2017-02-22', 0, 'AAA'),
('b3fae6f26', '2017-02-22', 0, 'AAA'),
('b4b2f43ce', '2017-02-22', 0, 'AAA'),
('b4f6961ac', '2017-02-22', 0, 'AAA'),
('b570f1340', '2017-02-22', 0, 'AAA'),
('b8004002b', '2017-02-22', 0, 'ELM'),
('b80503024', '2017-02-22', 0, 'AAA'),
('b846f4823', '2017-02-22', 0, 'AAA'),
('babf0ebb1', '2017-02-22', 0, 'ELM'),
('bc28bbfa1', '2017-02-22', 0, 'AAA'),
('be0862fa3', '2017-02-22', 0, 'ELM'),
('be97163b5', '2017-02-22', 0, 'AAA'),
('bf973ee75', '2017-02-21', 0, 'AAA'),
('c0028daca', '2017-02-22', 0, 'AAA'),
('c058e431f', '2017-02-22', 0, 'AAA'),
('c0c4892be', '2017-02-21', 0, 'AAA'),
('c15be504e', '2017-02-27', 0, 'ELM'),
('c1f1e273d', '2017-02-27', 0, 'ELM'),
('c28d80848', '2017-02-22', 0, 'AAA'),
('c3402b7ff', '2017-02-22', 0, 'ELM'),
('c54d61c10', '2017-02-22', 0, 'ELM'),
('c58829916', '2017-02-22', 0, 'AAA'),
('c596f29d4', '2017-02-22', 0, 'ELM'),
('cb3934217', '2017-02-22', 0, 'AAA'),
('ccea46c6e', '2017-02-27', 0, 'ELM'),
('cdef73273', '2017-02-22', 0, 'AAA'),
('cef628271', '2017-02-22', 0, 'AAA'),
('cfa071b90', '2017-02-22', 0, 'AAA'),
('d10350cbb', '2017-02-22', 0, 'AAA'),
('d147a097d', '2017-02-22', 0, 'AAA'),
('d1c2b00e9', '2017-03-01', 0, 'ELM'),
('d2abe085e', '2017-02-22', 0, 'AAA'),
('d357b7d96', '2017-02-22', 0, 'AAA'),
('d70bbbea6', '2017-02-22', 0, 'AAA'),
('d727a2570', '2017-02-22', 0, 'AAA'),
('d76caa772', '2017-02-21', 0, 'AAA'),
('d9619d774', '2017-02-22', 0, 'AAA'),
('dbd106f01', '2017-02-21', 0, 'AAA'),
('ddb46ff5d', '2017-02-22', 0, 'AAA'),
('df6d0d9f6', '2017-02-22', 0, 'AAA'),
('df85e9aee', '2017-02-27', 0, 'ELM'),
('e093625de', '2017-02-22', 0, 'AAA'),
('e3291b0a8', '2017-02-22', 0, 'AAA'),
('e5198829f', '2017-02-22', 0, 'AAA'),
('e51a25332', '2017-02-22', 0, 'AAA'),
('e5eaa635e', '2017-02-22', 0, 'AAA'),
('e7c69f476', '2017-02-22', 0, 'AAA'),
('e8ca56077', '2017-02-22', 0, 'AAA'),
('e993534d0', '2017-02-22', 0, 'AAA'),
('ea2cd4332', '2017-02-27', 0, 'ELM'),
('ea59bb5d7', '2017-02-22', 0, 'ELM'),
('ea87a247a', '2017-02-22', 0, 'AAA'),
('ec628d3f6', '2017-02-27', 0, 'ELM'),
('ec868382b', '2017-02-22', 0, 'AAA'),
('ececd6174', '2017-02-22', 0, 'AAA'),
('ee548aff0', '2017-02-22', 0, 'AAA'),
('eeeef3421', '2017-02-22', 0, 'AAA'),
('f01534326', '2017-02-22', 0, 'AAA'),
('f4887cee9', '2017-02-27', 0, 'ELM'),
('fa21821b3', '2017-02-27', 0, 'ELM'),
('faad7045f', '2017-02-22', 0, 'AAA'),
('fb718b378', '2017-02-22', 0, 'AAA'),
('fdd82b036', '2017-02-27', 0, 'ELM');

-- --------------------------------------------------------

--
-- Table structure for table `reset`
--

CREATE TABLE IF NOT EXISTS `reset` (
  `token` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `time_issue` timestamp NOT NULL,
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `used` tinyint(1) NOT NULL,
  PRIMARY KEY (`token`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `reset`
--

INSERT INTO `reset` (`token`, `time_issue`, `username`, `used`) VALUES
('5c2830fb6f8094', '2017-02-16 21:04:24', 'johnny', 0),
('bd5398b5ebef7c', '2017-02-16 21:02:26', 'johnny', 0),
('d91495d9ac93b5', '2017-02-16 20:40:15', 'johnny', 0),
('f799e70171d29f', '2017-02-16 20:59:57', 'johnny', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `roleID` char(1) COLLATE utf8_general_mysql500_ci NOT NULL,
  `role_name` varchar(15) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `role_name`) VALUES
('R', 'researcher'),
('S', 'superuser'),
('U', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `targets`
--

CREATE TABLE IF NOT EXISTS `targets` (
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `date_set` date NOT NULL,
  `steps` int(11) NOT NULL,
  `days` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`,`date_set`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `targets`
--

INSERT INTO `targets` (`username`, `date_set`, `steps`, `days`) VALUES
('bennett', '2017-02-17', 9650, 0),
('bennett', '2017-02-24', 11150, 3),
('bruce', '2017-01-13', 6300, 0),
('bruce', '2017-01-22', 7800, 3),
('bruce', '2017-02-05', 7800, 5),
('bruce', '2017-02-19', 9300, 3),
('charlotte', '2017-02-21', 6050, 0),
('charlotte', '2017-03-02', 7550, 3),
('jamesy', '1970-01-01', 7850, 0),
('jamesy', '2017-01-25', 9350, 3),
('jamesy', '2017-02-08', 9350, 5),
('johnny', '2017-01-16', 6350, 0),
('johnny', '2017-01-23', 7850, 3),
('johnny', '2017-02-06', 7850, 5),
('johnny', '2017-02-20', 9350, 3),
('seamus', '2017-01-20', 7500, 0),
('seamus', '2017-02-10', 9000, 3),
('topher', '2017-02-18', 9150, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL COMMENT 'Should be hashed',
  `salt` varchar(50) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `pracID` char(3) COLLATE utf8_general_mysql500_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `pref_method` char(3) COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'PED',
  `other_method` varchar(15) COLLATE utf8_general_mysql500_ci NOT NULL,
  `roleID` char(1) COLLATE utf8_general_mysql500_ci NOT NULL,
  `referenceID` char(9) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `pref_method` (`pref_method`),
  KEY `roleID` (`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `salt`, `email`, `pracID`, `start_date`, `pref_method`, `other_method`, `roleID`, `referenceID`) VALUES
('bennet', '5e9d11a14ad1c8dd77e98ef9b53fd1ba', NULL, 'mynewuser@hotmail.com', 'AAA', '2017-01-16', 'PED', '', 'U', 'blahblah'),
('bennett', 'cbb11ed87dc8a95d81400c7f33c7c171', NULL, 'halverson@dollhouse.com', 'AAA', '2017-01-23', 'PED', '', 'U', 'hewoo'),
('bruce', '4d8f1c9031b85e566cf634e9c47e4eeb', NULL, 'bruce@doggo.com', 'AAA', '2017-01-11', 'PED', '', 'U', 'blahblah'),
('budgie', 'be56c9b098121c3eaca44344a8d4b858', NULL, 'budgie@wontbudge.com', 'AAA', '2017-01-16', 'PED', '', 'U', 'blahblah'),
('charlotte', '9724cf090601d83128d5ee96f36c4bf1', NULL, 'cwahlich@sgul.ac.uk', 'AAA', '2017-02-21', 'PED', '', 'R', 'myregistr'),
('jamesy', 'c1c748adc87fa41ecddd93f34d0335f3', NULL, 'barndogs@hhohoho.com', 'AAA', '2017-01-20', 'PED', '', 'U', 'blahblah'),
('johnny', 'f4eb27cea7255cea4d1ffabf593372e8', NULL, 'john@email.com', 'AAA', '2017-01-16', 'PED', '', 'U', 'blahblah'),
('sarah', '9e9d7a08e048e9d604b79460b54969c3', NULL, 'sarah@27.com', 'AAA', '2017-01-19', 'PED', '', 'U', 'blahblah'),
('seamus', 'a65f94ad5cb5e1bc45533b2cf19212e8', NULL, 'seamy@seamus.com', 'AAA', '2017-01-20', 'PED', '', 'U', 'blahblah'),
('test_reg_check4', '1fb6d516846449dd250f1e8cffe0a86e', NULL, 'reg_check4@reg.com', 'ELM', '2017-03-01', 'ZZZ', 'Sony Lifelog', 'U', '2d92e8b62'),
('topher', 'd82ea6273ee73c554cb35f9c8fb2d808', NULL, 'brink@dollhouse.com', 'AAA', '2017-01-23', 'PED', '', 'U', 'hewoo');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `readings`
--
ALTER TABLE `readings`
  ADD CONSTRAINT `readings_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `readings_ibfk_1` FOREIGN KEY (`method`) REFERENCES `methods` (`methodID`);

--
-- Constraints for table `reset`
--
ALTER TABLE `reset`
  ADD CONSTRAINT `reset_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `targets`
--
ALTER TABLE `targets`
  ADD CONSTRAINT `targets_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`pref_method`) REFERENCES `methods` (`methodID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`roleID`) REFERENCES `roles` (`roleID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: sarahkerry.co.uk.mysql:3306
-- Generation Time: Jun 26, 2017 at 03:16 PM
-- Server version: 10.1.22-MariaDB-1~xenial
-- PHP Version: 5.4.45-0+deb7u8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sarahkerry_co_uk_paceup`
--
CREATE DATABASE `sarahkerry_co_uk_paceup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sarahkerry_co_uk_paceup`;

-- --------------------------------------------------------

--
-- Table structure for table `age`
--

CREATE TABLE IF NOT EXISTS `age` (
  `ageID` int(2) NOT NULL,
  `age` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `age`
--

INSERT INTO `age` (`ageID`, `age`) VALUES
(40, '40-59 years'),
(60, '60-74 years'),
(75, '75 years or older'),
(40, '40-59 years'),
(60, '60-74 years'),
(75, '75 years or older');

-- --------------------------------------------------------

--
-- Table structure for table `email_purpose`
--

CREATE TABLE IF NOT EXISTS `email_purpose` (
  `purpose` char(1) COLLATE utf8_general_mysql500_ci NOT NULL,
  `purpose_name` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `email_purpose`
--

INSERT INTO `email_purpose` (`purpose`, `purpose_name`) VALUES
('W', 'Welcome'),
('R', 'Password Reset'),
('Q', 'Questionnaire'),
('B', 'Check in as fallen behind'),
('O', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `username` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL,
  `time_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `purpose` char(1) COLLATE utf8_general_mysql500_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`username`, `time_sent`, `purpose`, `email`) VALUES
('bruce', '2017-06-08 10:42:12', 'W', 'bruce@doggo.com'),
('SallyAnn123456', '2017-06-08 10:54:22', 'W', 'dhdjfk@hsks456.com'),
('doctorbuckles', '2017-06-08 11:03:40', 'Q', 'sarah.kerry@ymail.com'),
('doctorbuckles', '2017-06-08 11:05:10', 'R', 'sarah.kerry@ymail.com'),
('John', '2017-06-20 10:30:33', 'W', 'hello@gmail.com'),
('deletethis', '2017-06-20 10:38:21', 'W', 'malcolm@itm.com'),
('doctorbuckles', '2017-06-21 09:35:20', 'Q', 'sarah.kerry@ymail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ethnicity`
--

CREATE TABLE IF NOT EXISTS `ethnicity` (
  `ethID` varchar(1) COLLATE utf8_general_mysql500_ci NOT NULL,
  `ethnicity` varchar(40) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `ethnicity`
--

INSERT INTO `ethnicity` (`ethID`, `ethnicity`) VALUES
('W', 'White'),
('M', 'Mixed/multiple ethnic groups'),
('A', 'Asian/Asian British'),
('B', 'Black/African/Caribbean/Black British'),
('O', 'Other ethnic group'),
('W', 'White'),
('M', 'Mixed/multiple ethnic groups'),
('A', 'Asian/Asian British'),
('B', 'Black/African/Caribbean/Black British'),
('O', 'Other ethnic group');

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
('bruce', 2, 'I will gain lots of friends and become more handsome. Woof'),
('bruce', 3, 'woof woof'),
('bruce', 4, 'I am much fluffier now.  Woof'),
('bruce', 5, 'm tee dum'),
('bruce', 6, 'Me? So Handsome and so many friends. Friendship is so important to me. I am a lot fitter  '),
('bruce', 7, 'so handsome, so many friends'),
('bruce', 8, 'It is always fun to play fetch!'),
('bruce', 19, 'I am checking this  will everything after this disappear. No the quotation marks are removed. excellen'),
('charlotte', 3, 'Swim the channel'),
('charlotte', 10, 'If the weather is bad, then I will wear a raincoa'),
('johnny', 7, 'I want to change a note from the pas'),
('johnny', 8, 'I love being busy'),
('topher', 12, 'weeeekk 12'),
('topher', 13, 'Week 13 notes'),
('topher', 14, 'Here are my notes from week 14');

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
-- Table structure for table `questionnaire`
--

CREATE TABLE IF NOT EXISTS `questionnaire` (
  `username` varchar(30) COLLATE utf8_general_mysql500_ci NOT NULL,
  `increase_pa` tinyint(1) DEFAULT NULL,
  `inc_pa_comment` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `look_and_feel` tinyint(1) DEFAULT NULL,
  `userbility` tinyint(1) DEFAULT NULL,
  `functionality` tinyint(1) DEFAULT NULL,
  `content` tinyint(1) DEFAULT NULL,
  `navigation` tinyint(1) DEFAULT NULL,
  `other` tinyint(1) DEFAULT NULL,
  `other_f_freetext` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `app_used` varchar(2) COLLATE utf8_general_mysql500_ci NOT NULL,
  `use_app_comment` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `download` tinyint(1) DEFAULT NULL,
  `bugs` tinyint(1) DEFAULT NULL,
  `confusing` tinyint(1) DEFAULT NULL,
  `battery` tinyint(1) NOT NULL,
  `slow_app` tinyint(1) DEFAULT NULL,
  `visual` tinyint(1) DEFAULT NULL,
  `missing` tinyint(1) DEFAULT NULL,
  `recommend` tinyint(1) DEFAULT NULL,
  `app_other` tinyint(1) DEFAULT NULL,
  `improvement` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `questionnaire`
--

INSERT INTO `questionnaire` (`username`, `increase_pa`, `inc_pa_comment`, `look_and_feel`, `userbility`, `functionality`, `content`, `navigation`, `other`, `other_f_freetext`, `app_used`, `use_app_comment`, `download`, `bugs`, `confusing`, `battery`, `slow_app`, `visual`, `missing`, `recommend`, `app_other`, `improvement`) VALUES
('bruce', 1, 'Going for even more walks now, woof', 0, 1, 3, 3, 3, NULL, NULL, 'W', 'Paws dont work well with mobile phones', NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'Not enough dog pictures'),
('maggiesmith', 1, NULL, 3, 5, 2, 1, 4, NULL, NULL, '', '', NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `readings`
--

CREATE TABLE IF NOT EXISTS `readings` (
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `date_read` date NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
('bruce', '2017-01-13', '2017-01-19 00:00:00', NULL, 1234, 'PED'),
('bruce', '2017-01-14', '2017-01-19 00:00:00', NULL, 7890, 'PED'),
('bruce', '2017-01-15', '2017-01-19 00:00:00', NULL, 7890, 'PED'),
('bruce', '2017-01-16', '2017-01-19 00:00:00', NULL, 8765, 'PED'),
('bruce', '2017-01-17', '2017-01-19 00:00:00', NULL, 6789, 'PED'),
('bruce', '2017-01-18', '2017-01-19 00:00:00', 1, 7890, 'PED'),
('bruce', '2017-01-19', '2017-01-19 00:00:00', NULL, 3456, 'PED'),
('bruce', '2017-01-20', '2017-01-20 00:00:00', 0, 6789, 'PED'),
('bruce', '2017-01-22', '2017-01-23 00:00:00', 0, 6789, 'PED'),
('bruce', '2017-01-23', '2017-01-23 00:00:00', 0, 10000, 'PED'),
('bruce', '2017-01-24', '2017-01-24 00:00:00', 0, 9999, 'PED'),
('bruce', '2017-01-25', '2017-01-25 00:00:00', 1, 9998, 'PED'),
('bruce', '2017-01-26', '2017-02-01 00:00:00', 1, 6789, 'PED'),
('bruce', '2017-01-29', '2017-02-14 00:00:00', 1, 222, 'PED'),
('bruce', '2017-01-30', '2017-02-01 00:00:00', 1, 6543, 'PED'),
('bruce', '2017-01-31', '2017-02-01 00:00:00', 1, 9000, 'PED'),
('bruce', '2017-02-01', '2017-02-14 00:00:00', 1, 5467, 'PED'),
('bruce', '2017-02-02', '2017-02-14 00:00:00', 1, 9999, 'PED'),
('bruce', '2017-02-03', '2017-02-14 00:00:00', 1, 9999, 'PED'),
('bruce', '2017-02-04', '2017-02-15 00:00:00', 1, 8765, 'PED'),
('bruce', '2017-02-05', '2017-02-20 00:00:00', 0, 444, 'PED'),
('bruce', '2017-02-06', '2017-02-16 00:00:00', 1, 7987, 'PED'),
('bruce', '2017-02-07', '2017-02-16 00:00:00', 1, 8768, 'PED'),
('bruce', '2017-02-08', '2017-02-16 00:00:00', 1, 9999, 'PED'),
('bruce', '2017-02-09', '2017-02-20 00:00:00', 1, 8, 'PED'),
('bruce', '2017-02-10', '2017-02-20 00:00:00', 1, 900, 'PED'),
('bruce', '2017-02-11', '2017-02-14 00:00:00', 1, 0, 'PED'),
('bruce', '2017-02-12', '2017-02-15 00:00:00', 1, 5643, 'PED'),
('bruce', '2017-02-13', '2017-02-15 00:00:00', 1, 7801, 'PED'),
('bruce', '2017-02-14', '2017-02-15 00:00:00', 1, 9000, 'PED'),
('bruce', '2017-02-15', '2017-02-16 00:00:00', 1, 8765, 'PED'),
('bruce', '2017-02-16', '2017-02-16 00:00:00', 1, 999, 'PED'),
('bruce', '2017-02-17', '2017-02-20 00:00:00', 1, 9999, 'PED'),
('bruce', '2017-02-18', '2017-02-20 00:00:00', 1, 10999, 'PED'),
('bruce', '2017-02-19', '2017-02-20 00:00:00', 1, 12345, 'PED'),
('bruce', '2017-02-20', '2017-02-20 00:00:00', 0, 9887, 'PED'),
('bruce', '2017-02-21', '2017-03-01 00:00:00', 1, 10000, 'PED'),
('bruce', '2017-02-22', '2017-03-02 00:00:00', 0, 9876, 'GAR'),
('bruce', '2017-02-24', '2017-03-02 00:00:00', 0, 8899, 'PED'),
('bruce', '2017-02-25', '2017-03-02 00:00:00', 1, 9876, 'PED'),
('bruce', '2017-02-26', '2017-03-02 00:00:00', 1, 8907, 'FIT'),
('bruce', '2017-02-27', '2017-03-02 00:00:00', 1, 9876, 'PED'),
('bruce', '2017-02-28', '2017-03-02 00:00:00', 0, 11000, 'ACT'),
('bruce', '2017-03-04', '2017-03-06 00:00:00', 1, 8760, 'PED'),
('bruce', '2017-03-05', '2017-03-06 00:00:00', 1, 9800, 'PED'),
('bruce', '2017-03-06', '2017-03-06 00:00:00', 1, 9800, 'PED'),
('bruce', '2017-03-07', '2017-03-08 00:00:00', 1, 12000, 'PED'),
('bruce', '2017-03-08', '2017-03-10 00:00:00', 1, 9879, 'PED'),
('bruce', '2017-03-09', '2017-03-13 00:00:00', 1, 13000, 'PED'),
('bruce', '2017-03-12', '2017-03-16 00:00:00', 1, 9879, 'PED'),
('bruce', '2017-03-13', '2017-03-16 00:00:00', 1, 9870, 'PED'),
('bruce', '2017-03-16', '2017-03-20 00:00:00', 1, 8976, 'GAR'),
('bruce', '2017-03-19', '2017-03-20 00:00:00', 1, 9999, 'ACT'),
('bruce', '2017-03-20', '2017-03-20 00:00:00', 0, 9800, 'PED'),
('bruce', '2017-03-21', '2017-03-24 00:00:00', 1, 9999, 'PED'),
('bruce', '2017-03-22', '2017-03-29 23:00:00', 1, 9876, 'PED'),
('bruce', '2017-03-23', '2017-03-29 23:00:00', 1, 8754, 'PED'),
('bruce', '2017-03-26', '2017-03-29 23:00:00', 1, 9865, 'PED'),
('bruce', '2017-03-27', '2017-03-30 11:25:20', 1, 9807, 'PED'),
('bruce', '2017-04-02', '2017-04-13 10:36:42', 1, 14000, 'PED'),
('bruce', '2017-04-03', '2017-04-13 10:36:50', 1, 14321, 'PED'),
('bruce', '2017-04-04', '2017-04-13 10:36:58', 1, 15673, 'PED'),
('bruce', '2017-04-05', '2017-04-13 10:37:05', 1, 13289, 'PED'),
('bruce', '2017-04-06', '2017-04-13 10:37:13', 1, 12321, 'PED'),
('bruce', '2017-04-07', '2017-04-13 10:37:20', 1, 8768, 'PED'),
('bruce', '2017-04-09', '2017-04-13 10:36:29', 0, 9870, 'PED'),
('bruce', '2017-05-11', '2017-05-24 14:18:55', 0, 5678, 'PED'),
('bruce', '2017-05-14', '2017-05-24 11:14:38', 0, 7689, 'PED'),
('bruce', '2017-05-27', '2017-06-02 18:27:23', 1, 12678, 'PED'),
('bruce', '2017-06-01', '2017-06-03 12:09:54', 0, 8750, 'PED'),
('bruce', '2017-06-02', '2017-06-03 12:10:08', 0, 9000, 'PED'),
('bruce', '2017-06-03', '2017-06-06 16:38:48', 0, 1245, 'PED'),
('bruce', '2017-06-04', '2017-06-07 10:53:34', 1, 6548, 'PED'),
('bruce', '2017-06-05', '2017-06-06 10:01:02', 1, 2458, 'PED'),
('bruce', '2017-06-06', '2017-06-08 21:46:45', 1, 12000, 'PED'),
('bruce', '2017-06-18', '2017-06-22 13:33:22', 1, 9000, 'PED'),
('charlotte', '2017-02-21', '2017-02-22 00:00:00', 0, 10000, 'PED'),
('charlotte', '2017-02-22', '2017-06-14 14:08:43', 0, 9999, 'PED'),
('charlotte', '2017-02-24', '2017-03-02 00:00:00', 0, 3456, 'PED'),
('charlotte', '2017-02-25', '2017-03-02 00:00:00', 0, 4567, 'PED'),
('charlotte', '2017-03-01', '2017-06-14 14:07:53', 0, 9555, 'PED'),
('charlotte', '2017-03-02', '2017-06-14 14:08:17', 1, 9555, 'PED'),
('charlotte', '2017-03-23', '2017-03-24 00:00:00', 1, 10000, 'PED'),
('charlotte', '2017-04-03', '2017-04-25 15:02:34', 1, 8695, 'PED'),
('charlotte', '2017-04-06', '2017-04-13 15:43:22', 1, 8658, 'PED'),
('charlotte', '2017-04-20', '2017-04-26 12:55:06', 0, 9800, 'PED'),
('charlotte', '2017-04-21', '2017-04-26 12:55:17', 1, 13009, 'PED'),
('charlotte', '2017-05-05', '2017-05-18 12:33:11', 1, 12000, 'PED'),
('charlotte', '2017-05-07', '2017-05-18 12:33:34', 1, 15000, 'PED'),
('charlotte', '2017-05-18', '2017-05-18 12:53:02', 0, 678, 'PED'),
('charlotte', '2017-05-25', '2017-05-31 16:45:13', 1, 9860, 'PED'),
('charlotte', '2017-05-26', '2017-06-08 08:32:50', 1, 8756, 'PED'),
('charlotte', '2017-05-27', '2017-06-08 08:33:03', 1, 4568, 'PED'),
('charlotte', '2017-05-28', '2017-06-08 08:33:17', 1, 8756, 'PED'),
('charlotte', '2017-05-29', '2017-06-08 08:33:29', 1, 12345, 'PED'),
('charlotte', '2017-06-14', '2017-06-14 14:32:48', 0, 955, 'PED'),
('deletethis', '2017-06-20', '2017-06-20 10:38:42', 0, 1234, 'PED'),
('doctorbuckles', '2017-03-23', '2017-03-28 23:00:00', 0, 3456, 'ZZZ'),
('doctorbuckles', '2017-03-24', '2017-03-28 23:00:00', 0, 3452, 'ZZZ'),
('doctorbuckles', '2017-03-25', '2017-03-28 23:00:00', 0, 3333, 'ZZZ'),
('doctorbuckles', '2017-03-26', '2017-03-28 23:00:00', 0, 3452, 'ZZZ'),
('doctorbuckles', '2017-03-27', '2017-03-28 23:00:00', 0, 8765, 'ZZZ'),
('doctorbuckles', '2017-03-28', '2017-03-28 23:00:00', 0, 7864, 'ZZZ'),
('doctorbuckles', '2017-03-29', '2017-03-28 23:00:00', 0, 6574, 'ZZZ'),
('doctorbuckles', '2017-04-06', '2017-06-08 11:08:24', 1, 2458, 'ZZZ'),
('doctorbuckles', '2017-04-07', '2017-06-08 11:08:34', 0, 9578, 'ZZZ'),
('doctorbuckles', '2017-04-08', '2017-06-08 11:08:43', 0, 9653, 'ZZZ'),
('doctorbuckles', '2017-04-20', '2017-06-08 11:10:33', 1, 9856, 'ZZZ'),
('doctorbuckles', '2017-04-21', '2017-06-08 11:10:48', 0, 9865, 'ZZZ'),
('doctorbuckles', '2017-04-22', '2017-06-08 11:24:04', 0, 9856, 'ZZZ'),
('doctorbuckles', '2017-04-23', '2017-06-08 11:24:16', 0, 9653, 'ZZZ'),
('doctorbuckles', '2017-04-24', '2017-06-08 11:24:28', 0, 9653, 'ZZZ'),
('doctorbuckles', '2017-05-04', '2017-06-08 12:53:18', 0, 8456, 'ZZZ'),
('doctorbuckles', '2017-05-05', '2017-06-08 12:53:32', 0, 8673, 'ZZZ'),
('doctorbuckles', '2017-05-06', '2017-06-08 12:53:48', 0, 9999, 'ZZZ'),
('doctorbuckles', '2017-05-18', '2017-06-08 13:13:51', 0, 7000, 'ZZZ'),
('doctorbuckles', '2017-05-19', '2017-06-08 13:14:04', 0, 7000, 'ZZZ'),
('doctorbuckles', '2017-06-08', '2017-06-08 15:15:42', 0, 9999, 'ZZZ'),
('jamesy', '1970-01-01', '2017-01-25 00:00:00', 1, 6789, 'PED'),
('jamesy', '2017-01-20', '2017-02-16 00:00:00', 1, 11000, 'PED'),
('jamesy', '2017-01-21', '2017-02-16 00:00:00', 1, 9088, 'PED'),
('jamesy', '2017-01-22', '2017-02-16 00:00:00', 1, 9999, 'PED'),
('jamesy', '2017-01-23', '2017-02-16 00:00:00', 1, 9999, 'PED'),
('jamesy', '2017-01-24', '2017-02-16 00:00:00', 1, 9876, 'PED'),
('jamesy', '2017-01-25', '2017-01-25 00:00:00', 1, 2345, 'PED'),
('jamesy', '2017-02-01', '2017-02-14 00:00:00', 1, 7654, 'PED'),
('jamesy', '2017-02-04', '2017-02-16 00:00:00', 1, 8999, 'PED'),
('jamesy', '2017-02-05', '2017-02-16 00:00:00', 1, 9999, 'PED'),
('jamesy', '2017-02-06', '2017-02-16 00:00:00', 1, 12000, 'PED'),
('jamesy', '2017-02-07', '2017-02-16 00:00:00', 1, 14000, 'PED'),
('jamesy', '2017-02-09', '2017-02-16 00:00:00', 1, 9800, 'PED'),
('jamesy', '2017-02-10', '2017-02-16 00:00:00', 1, 9999, 'PED'),
('jamesy', '2017-02-11', '2017-02-16 00:00:00', 1, 8768, 'PED'),
('jamesy', '2017-02-12', '2017-02-16 00:00:00', 1, 9876, 'PED'),
('jamesy', '2017-02-17', '2017-02-28 00:00:00', 1, 9878, 'PED'),
('jamesy', '2017-02-18', '2017-02-28 00:00:00', 1, 9896, 'PED'),
('jamesy', '2017-02-19', '2017-02-28 00:00:00', 1, 9976, 'PED'),
('jamesy', '2017-02-20', '2017-02-28 00:00:00', 1, 9966, 'PED'),
('jamesy', '2017-02-21', '2017-02-28 00:00:00', 1, 9955, 'PED'),
('jamesy', '2017-02-23', '2017-02-28 00:00:00', 1, 9900, 'PED'),
('jamesy', '2017-02-24', '2017-02-28 00:00:00', 1, 9855, 'PED'),
('jamesy', '2017-02-25', '2017-02-28 00:00:00', 1, 9810, 'PED'),
('jamesy', '2017-02-26', '2017-02-28 00:00:00', 1, 10820, 'PED'),
('jamesy', '2017-02-27', '2017-02-28 00:00:00', 1, 10822, 'PED'),
('jamesy', '2017-02-28', '2017-02-28 00:00:00', 1, 9926, 'PED'),
('jamesy', '2017-03-01', '2017-06-14 14:35:25', 0, 9955, 'PED'),
('jamesy', '2017-03-02', '2017-06-14 14:35:41', 0, 9955, 'PED'),
('jamesy', '2017-03-03', '2017-06-14 14:37:24', 0, 9955, 'PED'),
('jamesy', '2017-03-04', '2017-06-14 14:37:44', 0, 9955, 'PED'),
('jamesy', '2017-03-05', '2017-06-14 14:38:28', 0, 9555, 'PED'),
('jamesy', '2017-03-22', '2017-06-14 14:38:46', 0, 9999, 'PED'),
('jamesy', '2017-03-23', '2017-06-14 14:42:43', 0, 10000, 'PED'),
('jamesy', '2017-03-24', '2017-06-14 14:43:02', 0, 10001, 'PED'),
('jamesy', '2017-04-12', '2017-06-14 14:45:18', 0, 11111, 'PED'),
('jamesy', '2017-04-13', '2017-06-14 14:45:37', 1, 11111, 'PED'),
('jamesy', '2017-04-14', '2017-06-14 14:45:53', 1, 11111, 'PED'),
('jamesy', '2017-04-15', '2017-06-14 14:46:47', 0, 11111, 'PED'),
('jamesy', '2017-04-16', '2017-06-14 14:47:01', 0, 11111, 'PED'),
('John', '2017-06-20', '2017-06-20 10:32:17', 0, 10000, 'PED'),
('johnny', '2017-01-16', '2017-01-19 00:00:00', NULL, 6780, 'PED'),
('johnny', '2017-01-17', '2017-01-20 00:00:00', 0, 5678, 'PED'),
('johnny', '2017-01-18', '2017-01-19 00:00:00', NULL, 6789, 'PED'),
('johnny', '2017-01-19', '2017-01-19 00:00:00', NULL, 8906, 'PED'),
('johnny', '2017-01-20', '2017-01-20 00:00:00', 0, 3456, 'PED'),
('johnny', '2017-01-22', '2017-01-24 00:00:00', 0, 2345, 'PED'),
('johnny', '2017-01-23', '2017-01-26 00:00:00', 1, 600, 'PED'),
('johnny', '2017-01-24', '2017-01-24 00:00:00', 1, 8907, 'PED'),
('johnny', '2017-01-25', '2017-01-25 00:00:00', 1, 8900, 'PED'),
('johnny', '2017-01-30', '2017-02-01 00:00:00', 1, 7890, 'PED'),
('johnny', '2017-01-31', '2017-02-03 00:00:00', 1, 8954, 'PED'),
('johnny', '2017-02-01', '2017-02-05 00:00:00', 1, 9999, 'PED'),
('johnny', '2017-02-02', '2017-02-03 00:00:00', 1, 9999, 'PED'),
('johnny', '2017-02-03', '2017-02-05 00:00:00', 1, 8765, 'PED'),
('johnny', '2017-02-04', '2017-02-05 00:00:00', 1, 1234, 'PED'),
('johnny', '2017-02-06', '2017-02-23 00:00:00', 1, 9800, 'PED'),
('johnny', '2017-02-14', '2017-02-22 00:00:00', 1, 9000, 'PED'),
('johnny', '2017-02-21', '2017-02-23 00:00:00', 1, 9999, 'PED'),
('johnny', '2017-02-24', '2017-02-23 00:00:00', 0, 7658, 'PED'),
('johnny', '2017-02-27', '2017-03-06 00:00:00', 1, 9999, 'PED'),
('johnny', '2017-03-02', '2017-03-06 00:00:00', 1, 9987, 'PED'),
('johnny', '2017-03-05', '2017-03-06 00:00:00', 1, 9869, 'PED'),
('johnny', '2017-03-06', '2017-03-17 00:00:00', 0, 1234, 'PED'),
('johnny', '2017-03-07', '2017-03-17 00:00:00', 1, 9999, 'PED'),
('johnny', '2017-03-08', '2017-03-17 00:00:00', 1, 8769, 'PED'),
('johnny', '2017-03-10', '2017-03-17 00:00:00', 1, 10000, 'PED'),
('johnny', '2017-03-13', '2017-03-17 00:00:00', 0, 7899, 'PED'),
('johnny', '2017-03-14', '2017-03-17 00:00:00', 1, 9807, 'PED'),
('johnny', '2017-03-15', '2017-03-30 15:04:42', 0, 9999, 'PED'),
('johnny', '2017-03-16', '2017-03-30 15:04:49', 0, 8769, 'PED'),
('johnny', '2017-03-17', '2017-03-30 15:04:57', 0, 10000, 'PED'),
('johnny', '2017-03-20', '2017-03-30 15:14:52', 1, 9999, 'PED'),
('johnny', '2017-03-27', '2017-03-30 15:13:36', 0, 12000, 'PED'),
('johnny', '2017-03-28', '2017-03-30 15:13:42', 1, 14000, 'PED'),
('johnny', '2017-03-29', '2017-03-30 15:13:48', 1, 11000, 'PED'),
('johnny', '2017-03-30', '2017-03-30 15:13:56', 1, 12500, 'PED'),
('johnny', '2017-03-31', '2017-05-26 10:02:14', 1, 9876, 'PED'),
('johnny', '2017-04-01', '2017-05-26 10:02:27', 1, 12765, 'PED'),
('johnny', '2017-04-10', '2017-05-26 10:05:28', 0, 14536, 'PED'),
('johnny', '2017-04-11', '2017-05-26 10:05:41', 0, 13498, 'PED'),
('johnny', '2017-04-12', '2017-05-26 10:05:55', 1, 12657, 'PED'),
('johnny', '2017-04-13', '2017-05-26 10:06:08', 1, 21309, 'PED'),
('johnny', '2017-04-15', '2017-05-26 10:06:31', 1, 19870, 'PED'),
('johnny', '2017-04-16', '2017-05-26 10:06:50', 1, 16473, 'PED'),
('sarahkerry', '2017-05-27', '2017-06-02 08:26:18', 0, 9856, 'PED'),
('sarahkerry', '2017-05-28', '2017-06-02 08:26:22', 0, 9563, 'PED'),
('sarahkerry', '2017-05-29', '2017-06-02 08:26:26', 0, 4562, 'PED'),
('sarahkerry', '2017-05-30', '2017-06-02 08:26:31', 0, 5796, 'PED'),
('sarahkerry', '2017-05-31', '2017-06-02 08:26:34', 0, 8543, 'PED'),
('sarahkerry', '2017-06-01', '2017-06-02 08:26:39', 0, 8569, 'PED'),
('sarahkerry', '2017-06-02', '2017-06-02 08:26:44', 0, 4562, 'PED'),
('sarahkerry', '2017-06-03', '2017-06-05 15:32:28', 0, 7400, 'PED'),
('sarahkerry', '2017-06-04', '2017-06-05 15:35:04', 0, 5642, 'PED'),
('sarahkerry', '2017-06-05', '2017-06-05 15:35:19', 0, 6744, 'PED'),
('tharris', '2017-06-02', '2017-06-08 07:01:52', 0, 14567, 'PED'),
('tharris', '2017-06-03', '2017-06-08 07:02:10', 0, 12458, 'PED'),
('tharris', '2017-06-04', '2017-06-08 07:02:25', 0, 8342, 'PED'),
('tharris', '2017-06-05', '2017-06-08 07:02:37', 0, 6438, 'PED'),
('tharris', '2017-06-06', '2017-06-08 07:02:57', 0, 12451, 'PED'),
('tharris', '2017-06-07', '2017-06-08 07:03:26', 0, 7348, 'PED'),
('tharris', '2017-06-08', '2017-06-09 07:35:25', 0, 12890, 'PED'),
('tharris', '2017-06-12', '2017-06-12 19:26:11', 0, 6047, 'PED'),
('topher', '2016-12-24', '2017-01-19 00:00:00', NULL, 8234, 'PED'),
('topher', '2016-12-25', '2017-01-19 00:00:00', NULL, 7890, 'PED'),
('topher', '2016-12-26', '2017-01-19 00:00:00', NULL, 7890, 'PED'),
('topher', '2016-12-27', '2017-01-19 00:00:00', NULL, 8765, 'PED'),
('topher', '2016-12-28', '2017-01-19 00:00:00', NULL, 6789, 'PED'),
('topher', '2016-12-29', '2017-01-19 00:00:00', 1, 7890, 'PED'),
('topher', '2016-12-30', '2017-01-19 00:00:00', NULL, 3456, 'PED'),
('topher', '2016-12-31', '2017-01-20 00:00:00', 0, 6789, 'PED'),
('topher', '2017-01-01', '2017-02-01 00:00:00', NULL, 5000, 'PED'),
('topher', '2017-01-02', '2017-02-02 00:00:00', NULL, 5555, 'PED'),
('topher', '2017-01-03', '2017-01-23 00:00:00', 0, 6789, 'PED'),
('topher', '2017-01-04', '2017-01-23 00:00:00', 0, 10000, 'PED'),
('topher', '2017-01-05', '2017-01-24 00:00:00', 0, 9999, 'PED'),
('topher', '2017-01-06', '2017-01-25 00:00:00', 1, 9998, 'PED'),
('topher', '2017-01-07', '2017-02-01 00:00:00', 1, 6789, 'PED'),
('topher', '2017-01-09', '2017-02-14 00:00:00', 1, 6222, 'PED'),
('topher', '2017-01-10', '2017-02-01 00:00:00', 1, 6543, 'PED'),
('topher', '2017-01-11', '2017-02-01 00:00:00', 1, 9000, 'PED'),
('topher', '2017-01-12', '2017-02-14 00:00:00', 1, 5467, 'PED'),
('topher', '2017-01-13', '2017-02-14 00:00:00', 1, 9999, 'PED'),
('topher', '2017-01-14', '2017-02-15 00:00:00', 1, 8765, 'PED'),
('topher', '2017-01-15', '2017-02-20 00:00:00', 0, 7444, 'PED'),
('topher', '2017-01-16', '2017-02-16 00:00:00', 1, 7987, 'PED'),
('topher', '2017-01-17', '2017-02-16 00:00:00', 1, 8768, 'PED'),
('topher', '2017-01-18', '2017-02-16 00:00:00', 1, 9999, 'PED'),
('topher', '2017-01-19', '2017-02-20 00:00:00', 1, 8999, 'PED'),
('topher', '2017-01-20', '2017-02-20 00:00:00', 1, 8900, 'PED'),
('topher', '2017-01-21', '2017-02-14 00:00:00', 1, 9900, 'PED'),
('topher', '2017-01-22', '2017-02-15 00:00:00', 1, 5643, 'PED'),
('topher', '2017-01-23', '2017-01-23 00:00:00', 0, 5678, 'PED'),
('topher', '2017-01-24', '2017-02-15 00:00:00', 1, 7801, 'PED'),
('topher', '2017-01-25', '2017-02-15 00:00:00', 1, 9000, 'PED'),
('topher', '2017-01-26', '2017-02-16 00:00:00', 1, 8765, 'PED'),
('topher', '2017-02-02', '2017-02-14 00:00:00', 1, 9999, 'PED'),
('topher', '2017-02-03', '2017-02-03 00:00:00', NULL, 11000, 'PED'),
('topher', '2017-02-04', '2017-02-04 00:00:00', NULL, 13555, 'PED'),
('topher', '2017-02-16', '2017-02-16 00:00:00', 1, 7999, 'PED'),
('topher', '2017-02-17', '2017-02-20 00:00:00', 1, 9999, 'PED'),
('topher', '2017-02-18', '2017-02-24 00:00:00', 0, 9999, 'PED'),
('topher', '2017-02-19', '2017-02-24 00:00:00', 0, 8796, 'PED'),
('topher', '2017-02-20', '2017-02-24 00:00:00', 0, 7658, 'PED'),
('topher', '2017-02-21', '2017-02-24 00:00:00', 0, 8765, 'PED'),
('topher', '2017-02-22', '2017-02-24 00:00:00', 0, 9999, 'PED'),
('topher', '2017-02-23', '2017-02-24 00:00:00', 0, 9876, 'PED'),
('topher', '2017-02-24', '2017-02-24 00:00:00', 0, 8769, 'PED'),
('topher', '2017-03-04', '2017-03-06 00:00:00', 1, 8760, 'PED'),
('topher', '2017-03-05', '2017-03-06 00:00:00', 1, 9800, 'PED'),
('topher', '2017-03-06', '2017-03-06 00:00:00', 1, 9800, 'PED'),
('topher', '2017-03-07', '2017-03-08 00:00:00', 1, 12000, 'PED'),
('topher', '2017-03-08', '2017-03-10 00:00:00', 1, 9879, 'PED'),
('topher', '2017-03-09', '2017-03-13 00:00:00', 1, 13000, 'PED'),
('topher', '2017-03-10', '2017-03-30 15:45:26', 1, 14000, 'PED'),
('topher', '2017-03-11', '2017-03-30 15:45:03', 1, 12870, 'PED'),
('topher', '2017-03-12', '2017-03-16 00:00:00', 1, 9879, 'PED'),
('topher', '2017-03-13', '2017-03-16 00:00:00', 1, 12870, 'PED'),
('topher', '2017-03-14', '2017-03-30 15:44:55', 1, 9999, 'PED'),
('topher', '2017-03-15', '2017-03-30 15:45:15', 0, 11000, 'PED'),
('topher', '2017-03-16', '2017-03-20 00:00:00', 1, 14976, 'GAR'),
('topher', '2017-03-19', '2017-03-20 00:00:00', 1, 9999, 'ACT'),
('topher', '2017-03-20', '2017-03-20 00:00:00', 0, 14800, 'PED'),
('topher', '2017-03-21', '2017-03-24 00:00:00', 1, 9999, 'PED'),
('topher', '2017-03-22', '2017-03-29 22:00:00', 1, 9876, 'PED'),
('topher', '2017-03-23', '2017-03-29 22:00:00', 1, 14054, 'PED'),
('topher', '2017-03-24', '2017-03-30 15:44:42', 1, 9800, 'PED'),
('topher', '2017-03-26', '2017-03-29 22:00:00', 1, 14865, 'PED'),
('topher', '2017-03-27', '2017-03-30 10:25:20', 1, 9807, 'PED'),
('topher', '2017-04-01', '2017-04-05 09:30:27', 0, 15370, 'PED'),
('topher', '2017-04-02', '2017-04-05 09:30:51', 0, 16890, 'PED'),
('topher', '2017-04-03', '2017-04-05 09:30:38', 0, 9870, 'PED'),
('topher', '2017-04-04', '2017-04-05 09:30:43', 0, 9870, 'PED'),
('topher', '2017-04-05', '2017-04-05 09:30:56', 0, 9833, 'PED'),
('topher', '2017-04-06', '2017-04-27 11:23:10', 0, 3452, 'PED'),
('topher', '2017-04-15', '2017-04-27 11:26:13', 0, 7584, 'PED'),
('topher', '2017-04-16', '2017-04-27 11:27:51', 1, 8720, 'PED');

--
-- Triggers `readings`
--
DROP TRIGGER IF EXISTS `setbase`;
DELIMITER //
CREATE TRIGGER `setbase` AFTER INSERT ON `readings`
 FOR EACH ROW INSERT INTO targets (username, date_set, steps, days)
                      SELECT getDays.username, getDays.start, getDays.base_steps, 0
                      FROM
			          (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
                      FROM (SELECT r.date_read, m.steps, r.username
                      FROM readings as r,
                      readings as m
                      WHERE r.date_read<= m.date_read AND DATEDIFF(m.date_read, r.date_read)<7 AND DATEDIFF(m.date_read, r.date_read)>=0 AND r.username= m.username) as getValues
                      GROUP BY getValues.date_read, getValues.username) as getDays
                      WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>6 AND DATEDIFF(CURDATE(), getDays.start)<=35 AND getDays.username NOT IN
                      (SELECT username FROM targets)
			          GROUP BY getDays.username
                      ORDER BY getDays.start LIMIT 1
//
DELIMITER ;
DROP TRIGGER IF EXISTS `setbasetoday`;
DELIMITER //
CREATE TRIGGER `setbasetoday` BEFORE INSERT ON `readings`
 FOR EACH ROW INSERT INTO targets (username, date_set, steps, days)
 SELECT getDays.username, getDays.start, getDays.base_steps, 0
  FROM (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
FROM (SELECT r.date_read, m.steps, r.username
FROM readings as r, readings as m
WHERE r.date_read<= m.date_read AND DATEDIFF(m.date_read, r.date_read)<7 AND DATEDIFF(m.date_read, r.date_read)>=0 AND r.username= m.username) as getValues
GROUP BY getValues.date_read, getValues.username) as getDays
WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>=6 AND DATEDIFF(CURDATE(), getDays.start)<=35 AND getDays.username NOT IN (SELECT username FROM targets) AND getDays.username IN (SELECT username FROM readings WHERE date_read=CURDATE())
GROUP BY getDays.username
ORDER BY getDays.start LIMIT 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE IF NOT EXISTS `reference` (
  `referenceID` char(11) COLLATE utf8_general_mysql500_ci NOT NULL,
  `issue_date` date NOT NULL,
  `in_use` tinyint(1) NOT NULL,
  `practice` char(3) COLLATE utf8_general_mysql500_ci NOT NULL,
  `consent` tinyint(4) NOT NULL,
  `date_rem` date DEFAULT NULL,
  `e_consent` tinyint(4) DEFAULT NULL,
  `e_consent_v` tinyint(4) DEFAULT NULL,
  `e_consent_a` tinyint(4) DEFAULT NULL,
  `e_consent_gp` tinyint(4) DEFAULT NULL,
  `e_consent_t` tinyint(4) DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `ethnicity` varchar(1) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  PRIMARY KEY (`referenceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci COMMENT='Stores references to be checked on user creation. May not need to be kept';

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`referenceID`, `issue_date`, `in_use`, `practice`, `consent`, `date_rem`, `e_consent`, `e_consent_v`, `e_consent_a`, `e_consent_gp`, `e_consent_t`, `gender`, `ethnicity`, `age`) VALUES
('0012b02bc', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('018a17a1be', '2017-05-31', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('021c74373', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('03623ef9a', '2017-02-22', 1, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0382af906', '2017-02-22', 1, 'AAA', 0, '0000-00-00', 1, 1, 1, 1, 1, 'M', 'M', 40),
('077184842', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0b991b66e', '2017-02-22', 0, 'ELM', 0, '0000-00-00', 1, 1, 1, 1, 1, 'F', 'A', 60),
('0bfab472f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0d9885863', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0dd4241dc', '2017-02-21', 1, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('104c4292a', '2017-03-19', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1275d9ea70', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1523d67a0', '2017-03-01', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('158dcc5295', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('15b3d30c3', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1690e6386b', '2017-03-24', 0, 'ELM', 0, NULL, 1, 1, 1, 1, 1, 'M', 'M', 60),
('19a3f347e', '2017-02-22', 1, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('19dbfbbd01', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('19dc83b17', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1ee052a98', '2017-02-27', 1, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1f248cb9a', '2017-02-22', 1, 'AAA', 1, '0000-00-00', 1, 1, 1, 1, 1, 'M', 'B', 75),
('1fce72d72', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('20c147f3b', '2017-02-22', 1, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('21e1f7eee', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('223d7d7dc', '2017-03-18', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('22ab399d1a', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('22cd88e08', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('23226e44a', '2017-02-27', 1, 'ELM', 0, '0000-00-00', 1, 1, 1, 1, 1, 'F', 'A', 40),
('23523769f', '2017-02-22', 1, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('24316a492', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('255727858e', '2017-05-31', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('260c1f9364', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2723c194f', '2017-02-22', 1, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('28a805e6f8', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2920a0a261', '2017-06-20', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2c2cdb5c66', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2c7088ab7', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2d92e8b62', '2017-02-22', 1, 'ELM', 0, '0000-00-00', 1, 1, 1, 1, 1, 'M', 'A', 40),
('2e036d4b14', '2017-05-31', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2efdd0d48', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2f1cf3fca', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2ff783aec', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('301523cb4', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('31f969b27', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3272dfeb7', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3298b43fa', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('32b472cf5e', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3336f0ae3a', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('340c20d4c8', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('342c8b792', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('35bb2bd24', '2017-03-01', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('35c229f93', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('35e4a74c8', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3643d67170', '2017-05-31', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3738220a2', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3801bfa3c', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('38841d2d1d', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('38d28c6298', '2017-06-20', 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3b3808565', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3baa029af', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3bb24bb6e7', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3e41a4ffd', '2017-03-08', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3e4d288c7', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3e574e9de', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3eb1946f8', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3ef37277e8', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3f4886cd0', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4279fbc44', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('43b6b7243', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('458c116121', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('46f9ed55d', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4729476c6', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4b07b256a', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4bcd07558', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4c3141f69', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4c6b3d8502', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4f174d73d', '2017-02-23', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('50d54bfe5a', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('51758ff61', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('52cf3d2f0', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('52e600149', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('531dc241d', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('548602ed5', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('55533c3de', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('55720f5dcf', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('574d298c8', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('580288327b', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('59420c1a8', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('59723ffdb', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5b53c2638', '2017-03-20', 0, 'ELM', 0, NULL, 1, 1, 1, 1, 1, 'F', 'M', 60),
('5bfc1d352', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5d0fa467b', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5d68048f1', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5d7d8eb8a', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5e00b9486', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5e7860669', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5edc78be77', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5f3029246', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6031aa7cc', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('60ee1bb98', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('60f90e340', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('61c583547', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('639cc7aeb', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('640399ba8', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6507fd977', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('66b470ed5', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('66ddef2d4', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6706ea6f97', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('688eb6272', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('69a2f31a7', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('69c5d34e5', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6adcd0e5a8', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6d208a933', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6d36e0d64', '2017-02-23', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6e4fba618', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6ed3387d9', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6f0c48eba', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6f5bea0861', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6fc225c97', '2017-03-01', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6fe1fd843', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7033c9e88', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('721160b672', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('73366faf5', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7622a93d0', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('763a57e68', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('783906e8a', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('78de7c141', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('79a5f80ac', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7a25afd17e', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7a3a4521c9', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7a5c81c2f', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7af83f4e47', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7be3dbde2c', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7c8172479', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7d57e0deb9', '2017-06-20', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7e1889e21', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7ed1d17ae', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('7f8493f9a', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('804ee5a75', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('808bb3a8e', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('80cfad8eb', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('816631733', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('81bedd09e', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('822cc4c41', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('825028129', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('82d11393b', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('830ee6eb1', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('832a090fe', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8422e0ec7', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('85919f0e3', '2017-02-23', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('86457ef68', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('86a260e14', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8835d3589', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('89cb91280', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('89cbe00024', '2017-06-20', 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8a06a09427', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8c76d3c23', '2017-03-01', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8de30b1db', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8e1c1b1a5', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8f7872510', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9012d9f3d', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('91d4f623c', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9232919ba', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('93056c3fb', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9405b5c97', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('94f6d8090f', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('96d92212f5', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('97fb2a09f', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('98f9c6949', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9eee84b82b', '2017-05-31', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9f2c57fb7', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9f97aa915', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9fabc574e7', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a1219a9c1', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a1d9b1233e', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a2609752f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a2622c23f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a32a45924', '2017-02-23', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a3cbc049b', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a3e8cf5188', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a4459cd3e', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a6046cad0', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a67ab2835', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a68ff8bda', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a6a921455', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a73f0445e8', '2017-06-20', 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a80d69d61', '2017-02-23', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a828f8821', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a86b9e625', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a98e33bd5', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('a9fe2a787', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('aa717bfe3', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('aba900aad4', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ad33a45ac6', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ad730efff', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ae42de9d31', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('aeee34567', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('af520774f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('afd64509c', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('aff9b4f31', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b1268f370', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b3a3fc0192', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b3d69c2193', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b3fae6f26', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b4b2f43ce', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b4f6961ac', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b570f1340', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b587fb8d35', '2017-06-20', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b5cbb13dea', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b60d73a1d1', '2017-06-20', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b8004002b', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b80503024', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('b846f4823', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ba5f4b3d0', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('babf0ebb1', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('bc28bbfa1', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('be0862fa3', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('be97163b5', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('bf973ee75', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c0028daca', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c058e431f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c0c4892be', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c10c89b785', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c15be504e', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c1f1e273d', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c203c2233', '2017-03-18', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c28d80848', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c3402b7ff', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c54d61c10', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c58829916', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c596f29d4', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('c8c7460344', '2017-06-20', 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cb3934217', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ccea46c6e', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cd7995f06d', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cdef73273', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cef628271', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cfa071b90', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d06f9b828', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d10350cbb', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d147a097d', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d1c2b00e9', '2017-03-01', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d2abe085e', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d357b7d96', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d70bbbea6', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d727a2570', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d72b6cbfd', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d737f8a9b1', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d76caa772', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('d9619d774', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('da629942e2', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('da864cb951', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('db783fd6d8', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('dbd0efab62', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('dbd106f01', '2017-02-21', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('dc4bb9e18d', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('dd36184e57', '2017-06-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ddb46ff5d', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('de12856640', '2017-05-23', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ded0731953', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('df6d0d9f6', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('df85e9aee', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e093625de', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e0edfe6851', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e1786b36b', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e284d1685b', '2017-06-01', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e2ec4b1d59', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e3291b0a8', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e5198829f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e51a25332', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e5eaa635e', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e7c69f476', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e83bfb75dd', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e8ca56077', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('e993534d0', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ea2cd4332', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ea59bb5d7', '2017-02-22', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ea87a247a', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ec19d6d5c', '2017-03-20', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ec628d3f6', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ec868382b', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ececd6174', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ed9997ae3a', '2017-06-01', 0, 'gry', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ee4fab0195', '2017-06-20', 0, 'AAA', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ee548aff0', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('eeaf30c03c', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('eeeef3421', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('f01534326', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('f4887cee9', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('f6df1dc78c', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('f7b2fdbf06', '2017-06-20', 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('fa21821b3', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('faad7045f', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('fabeb807c7', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('fafc7ac306', '2017-03-24', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('fb718b378', '2017-02-22', 0, 'AAA', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('fdab625a7d', '2017-05-31', 0, 'ELM', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('fdd82b036', '2017-02-27', 0, 'ELM', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reset`
--

CREATE TABLE IF NOT EXISTS `reset` (
  `token` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `time_issue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `used` tinyint(1) NOT NULL,
  PRIMARY KEY (`token`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `reset`
--

INSERT INTO `reset` (`token`, `time_issue`, `username`, `used`) VALUES
('0090f3470f8edd74965adc5561e45322', '2017-03-27 12:00:58', 'bruce', 0),
('0bc00d31351fb08a75d797e8fe870f35', '2017-03-27 11:59:27', 'bruce', 0),
('3ef98a6b0ff8b4c605269268a2f32a0b', '2017-03-27 12:01:01', 'bruce', 0),
('548591330114458d5d90688b5b35b884', '2017-03-27 11:59:31', 'bruce', 0),
('5c2830fb6f8094', '2017-02-16 21:04:24', 'johnny', 0),
('643a690f5751c747098e536775326b06', '2017-03-27 12:01:02', 'bruce', 0),
('6f9097cf1cc708caf4372fc508f87cfe', '2017-03-27 11:59:28', 'bruce', 0),
('bd5398b5ebef7c', '2017-02-16 21:02:26', 'johnny', 0),
('c13248654d881ebe83b5a395cc51c7f0', '2017-03-27 11:59:08', 'bruce', 0),
('c4e5b9d89b31e0bb0453c189df7003a7', '2017-03-27 11:59:19', 'bruce', 0),
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
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `username` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL,
  `session` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `timeout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`username`, `session`, `timeout`) VALUES
('charlotte', 'd108615349d53b49759ca9c6a942a9fa', '2017-06-22 16:30:27');

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
('bruce', '2017-01-13', 6300, 0),
('bruce', '2017-01-22', 7800, 3),
('bruce', '2017-02-05', 7800, 5),
('bruce', '2017-02-19', 9300, 3),
('bruce', '2017-03-12', 9300, 5),
('bruce', '2017-03-26', 9300, 6),
('bruce', '2017-04-09', 9300, 6),
('bruce', '2017-05-07', 9300, 6),
('bruce', '2017-05-21', 9400, 7),
('bruce', '2017-06-04', 8800, 7),
('charlotte', '2017-02-21', 6050, 0),
('charlotte', '2017-03-02', 7550, 3),
('charlotte', '2017-03-23', 7550, 5),
('charlotte', '2017-04-20', 9050, 3),
('charlotte', '2017-05-18', 9050, 5),
('charlotte', '2017-06-01', 9050, 6),
('doctorbuckles', '2017-03-23', 5300, 0),
('doctorbuckles', '2017-03-30', 6800, 3),
('doctorbuckles', '2017-04-13', 6800, 5),
('doctorbuckles', '2017-04-27', 6800, 3),
('doctorbuckles', '2017-05-11', 6800, 5),
('jamesy', '2017-01-25', 9350, 3),
('jamesy', '2017-02-08', 9350, 5),
('jamesy', '2017-02-22', 9350, 5),
('jamesy', '2017-03-08', 9350, 3),
('jamesy', '2017-03-29', 9350, 5),
('jamesy', '2017-04-19', 9350, 6),
('johnny', '2017-01-16', 6350, 0),
('johnny', '2017-01-23', 7850, 3),
('johnny', '2017-02-06', 7850, 5),
('johnny', '2017-02-20', 9350, 3),
('johnny', '2017-03-06', 9350, 5),
('johnny', '2017-03-20', 9350, 6),
('johnny', '2017-04-03', 9350, 6),
('johnny', '2017-04-17', 9350, 6),
('sarahkerry', '2017-05-27', 7400, 0),
('tharris', '2017-06-02', 10650, 0),
('tharris', '2017-06-12', 12150, 3),
('topher', '2016-12-24', 6000, 0),
('topher', '2016-12-31', 7500, 3),
('topher', '2017-01-14', 7500, 5),
('topher', '2017-01-28', 9000, 3),
('topher', '2017-02-11', 9000, 5),
('topher', '2017-02-25', 9000, 6),
('topher', '2017-03-11', 9000, 6),
('topher', '2017-03-25', 9000, 6),
('topher', '2017-04-08', 9000, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL COMMENT 'Should be hashed',
  `salt` varchar(50) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `forename` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL,
  `lastname` varchar(25) COLLATE utf8_general_mysql500_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT '',
  `pracID` char(3) COLLATE utf8_general_mysql500_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `pref_method` char(3) COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT 'PED',
  `other_method` varchar(15) COLLATE utf8_general_mysql500_ci NOT NULL,
  `roleID` char(1) COLLATE utf8_general_mysql500_ci NOT NULL,
  `referenceID` char(12) COLLATE utf8_general_mysql500_ci NOT NULL,
  `finish_show` tinyint(4) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `pref_method` (`pref_method`),
  KEY `roleID` (`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `salt`, `forename`, `lastname`, `email`, `pracID`, `start_date`, `pref_method`, `other_method`, `roleID`, `referenceID`, `finish_show`) VALUES
('bruce', '4d8f1c9031b85e566cf634e9c47e4eeb', NULL, 'bruce', 'wills', 'bruce@doggo.ft.com', 'AAA', '2017-01-11', 'PED', '', 'U', 'blahblah', 2),
('bumblebee', '65e42473a54b47fa09a1b7933b1effa8', NULL, 'bumble', 'the bee', 'bee@beehave.ft.com', 'AAA', '2017-03-17', 'ZZZ', '', 'R', '15b3d30c3', 0),
('caw', 'cbd0a68253814b7ed5132027068b1e82', 'RandomString', 'cheryl', 'watson', 'cwatson@sgul.ac.uk', 'AAA', '2017-06-01', 'PED', '', 'R', 'ad33a45ac6', 0),
('charlotte', '9724cf090601d83128d5ee96f36c4bf1', NULL, 'charlotte', 'wahlich', 'cwahlich@sgul.ac.uk', 'AAA', '2017-02-21', 'PED', '', 'S', '1f248cb9a', 0),
('deletethis', '89989c10cd895aca78e7be2ef381cf17', 'RandomString', 'malcolm', 'middle', 'malcolm@itm.com', 'ELM', '2017-06-20', 'PED', '', 'U', '6706ea6f97', 0),
('doctorbuckles', 'ef749ff9a048bad0dd80807fc49e1c0d', NULL, 'doctor', 'buckles', 'sarah.kerry@ymail.com', 'ELM', '2017-03-21', 'ZZZ', '', 'U', '5b53c2638', 0),
('iheartwalking', 'dc647eb65e6711e155375218212b3964', NULL, 'gerald', 'loves walking', 'geraldlovewalking@walking.love.com', 'ELM', '2017-03-29', 'JAW', '', 'U', '1690e6386', 0),
('jamesy', 'c1c748adc87fa41ecddd93f34d0335f3', NULL, '', '', 'barndogs@hhohoho.err.com', 'AAA', '2017-01-20', 'PED', '', 'U', 'blahblah', 0),
('john', 'b7751f53e7169bc3fcc541028e148933', 'RandomString', 'john', 'w', 'hello@gmail.com', 'AAA', '2017-06-20', 'PED', '', 'U', 'b60d73a1d1', 0),
('johnny', 'f4eb27cea7255cea4d1ffabf593372e8', NULL, '', '', 'john@email.email.com', 'AAA', '2017-01-16', 'PED', '', 'U', 'blahblah', 3),
('sarahkerry', '96272da54f4be25fdcb177fce5414684', NULL, 'sarah', 'kerry', 'sarah@kerry.madcap.com', 'ELM', '2017-05-31', 'PED', '', 'U', '19dbfbbd01', 0),
('tharris', '783d61ca7dcea20c061f50a6a5b75ff2', 'RandomString', 'tess', 'harris', 'tharris@sgul.ac.uk', 'AAA', '2017-06-02', 'PED', '', 'U', '7af83f4e47', 0),
('topher', 'd2695f450e0ccdbc7bdb69e7a6465e6d', NULL, '', '', 'brink@dollhouse.papa.com', 'AAA', '2016-12-23', 'PED', '', 'U', 'hewoo', 2);

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
  ADD CONSTRAINT `readings_ibfk_1` FOREIGN KEY (`method`) REFERENCES `methods` (`methodID`),
  ADD CONSTRAINT `readings_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

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

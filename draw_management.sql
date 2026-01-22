-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2026 at 04:13 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `draw_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(211) NOT NULL,
  `password` varchar(212) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `venu` varchar(255) DEFAULT NULL,
  `date_and_time` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `draw_date` date NOT NULL,
  `prize_name` varchar(255) NOT NULL,
  `prize_description` text,
  `prize_value` varchar(100) DEFAULT NULL,
  `winners_count` int(11) NOT NULL,
  `eligibility` text,
  `status` enum('active','inactive','completed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `venu`, `date_and_time`, `location`, `description`, `image`, `draw_date`, `prize_name`, `prize_description`, `prize_value`, `winners_count`, `eligibility`, `status`, `created_at`, `updated_at`) VALUES
(1, 'New Year Lucky Draw', 'Expo Center', '2026-01-20 18:00:00', 'Lahore', 'New Year special lucky draw event', 'draw.jpg', '2026-01-23', 'Honda Bike', 'Brand new Honda 125 bike', '150000 PKR', 3, 'Registered users only', 'completed', '2026-01-17 13:06:31', '2026-01-17 15:07:58'),
(2, 'new', 'hshsh', '2026-01-17 20:09:00', 'Lahore Airport', 'hhshs', 'draw.jpg', '2026-01-27', 'test', 'test', '150000', 2, 'ggsgs', 'completed', '2026-01-17 15:09:50', '2026-01-17 15:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `event_rsvp`
--

CREATE TABLE IF NOT EXISTS `event_rsvp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `status` enum('attend','maybe','decline') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rsvp` (`user_id`,`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event_rsvp`
--

INSERT INTO `event_rsvp` (`id`, `user_id`, `event_id`, `status`) VALUES
(1, 20, 1, 'attend');

-- --------------------------------------------------------

--
-- Table structure for table `lucky_draw_entries`
--

CREATE TABLE IF NOT EXISTS `lucky_draw_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_entry` (`user_id`,`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lucky_draw_entries`
--

INSERT INTO `lucky_draw_entries` (`id`, `user_id`, `event_id`, `entry_date`) VALUES
(2, 22, 2, '2026-01-17 15:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `lucky_draw_winners`
--

CREATE TABLE IF NOT EXISTS `lucky_draw_winners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `win_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lucky_draw_winners`
--

INSERT INTO `lucky_draw_winners` (`id`, `event_id`, `user_id`, `win_date`) VALUES
(4, 2, 22, '2026-01-17 15:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(202) NOT NULL,
  `password` varchar(250) NOT NULL,
  `mobile` varchar(212) NOT NULL,
  `city` varchar(213) NOT NULL,
  `type` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Pending',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `graduation_year` varchar(10) DEFAULT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `contact_details` text,
  `current_course` varchar(100) DEFAULT NULL,
  `year_of_study` varchar(50) DEFAULT NULL,
  `interests` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `city`, `type`, `status`, `date`, `graduation_year`, `degree`, `student_id`, `occupation`, `contact_details`, `current_course`, `year_of_study`, `interests`) VALUES
(20, 'Sumra', 'sumra@gmail.com', '123', '0300252653', 'Lahore', 'Student', 'Confirm', '2025-04-21 13:30:35', NULL, NULL, 'bc14020015', NULL, 'hh', 'bscs', '2', 'xdd'),
(21, 'Iqra', 'iqra@gmail.com', '12345', '03002526530', 'Lahore', 'Alumni', 'Confirm', '2025-04-22 01:27:47', '', '', '', '', '', NULL, NULL, NULL),
(22, 'Usman', 'usman@gmail.com', '12345', '064565', 'lahore', 'User', 'Pending', '2026-01-17 20:08:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2015 at 08:53 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vor`
--

-- --------------------------------------------------------

--
-- Table structure for table `scl_class_routine`
--

CREATE TABLE IF NOT EXISTS `scl_class_routine` (
`id` int(11) NOT NULL,
  `class` varchar(10) NOT NULL,
  `subject` varchar(15) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start` varchar(15) NOT NULL,
  `end` varchar(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `scl_class_routine`
--

INSERT INTO `scl_class_routine` (`id`, `class`, `subject`, `day`, `start`, `end`) VALUES
(1, '7', 'Chemestry', 'sunday', '9 AM', '9:40 AM');

-- --------------------------------------------------------

--
-- Table structure for table `scl_notices`
--

CREATE TABLE IF NOT EXISTS `scl_notices` (
`id` int(11) NOT NULL,
  `notice` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `scl_notices`
--

INSERT INTO `scl_notices` (`id`, `notice`) VALUES
(1, 'school 365 diner jonno off\r\n\r\nenjoy kids :p '),
(2, 'prappo vai crush khaise so shobai violin bajao :D ');

-- --------------------------------------------------------

--
-- Table structure for table `scl_principal`
--

CREATE TABLE IF NOT EXISTS `scl_principal` (
`id` int(11) NOT NULL,
  `name_title` varchar(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `nationality` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(30) NOT NULL,
  `qualification` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `joining_date` date NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scl_principal`
--

INSERT INTO `scl_principal` (`id`, `name_title`, `first_name`, `last_name`, `nationality`, `gender`, `address`, `qualification`, `date_of_birth`, `joining_date`, `mobile`, `email`, `about`) VALUES
(0, 'Prof.', 'Mehedi', 'Hassan', 'Bangladeshi', 'Male', 'Savar', 'Nothing', '1997-07-30', '2015-02-20', '+8801689025611', 'MHDH331@gmail.com', '420 principal');

-- --------------------------------------------------------

--
-- Table structure for table `scl_students`
--

CREATE TABLE IF NOT EXISTS `scl_students` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class` varchar(30) NOT NULL,
  `roll` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `scl_students`
--

INSERT INTO `scl_students` (`id`, `name`, `class`, `roll`, `gender`, `address`, `date_of_birth`, `mobile`, `email`, `image`) VALUES
(10, 'Mehedi Hassan', '7', 9, 'Male', '', '0000-00-00', '', '', '3707.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `scl_teachers`
--

CREATE TABLE IF NOT EXISTS `scl_teachers` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vor_admin`
--

CREATE TABLE IF NOT EXISTS `vor_admin` (
`id` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `last_login` varchar(15) NOT NULL,
  `registration_date` date NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `vor_admin`
--

INSERT INTO `vor_admin` (`id`, `full_name`, `username`, `password`, `type`, `email`, `last_login`, `registration_date`, `image`) VALUES
(1, 'Admin', 'admin', 'admin', 'admin', 'admin@mail.com', '::1', '2015-03-03', 'admin_1.jpg'),
(14, 'Mehedi Hassan', 'student_10', 'student_10', 'student', '', '::1', '2015-03-31', 'student_3707.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `vor_notify`
--

CREATE TABLE IF NOT EXISTS `vor_notify` (
`id` int(50) NOT NULL,
  `class` varchar(20) NOT NULL,
  `content` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `vor_notify`
--

INSERT INTO `vor_notify` (`id`, `class`, `content`, `time`, `status`) VALUES
(6, 'danger', 'admin loged in', 'Friday 27th ', 'read'),
(7, 'info', 'admin loged in', 'Friday 27th of February 2015 0', 'unread'),
(8, 'info', 'admin loged in', 'Friday 27th of February 2015 06:58:40 PM', 'unread'),
(9, 'info', 'prappo loged in', 'Friday 27th of February 2015 07:25:16 PM', 'unread'),
(10, 'info', 'admin loged in', 'Friday 27th of February 2015 07:25:51 PM', 'unread'),
(11, 'info', 'prappo loged in', 'Friday 27th of February 2015 07:27:35 PM', 'unread'),
(12, 'info', 'admin loged in', 'Friday 27th of February 2015 07:30:37 PM', 'unread'),
(13, 'info', 'prappo loged in', 'Friday 27th of February 2015 07:31:23 PM', 'unread'),
(14, 'info', 'admin loged in', 'Friday 27th of February 2015 07:31:41 PM', 'unread'),
(15, 'info', 'admin loged in', 'Sunday 1st of March 2015 05:35:53 AM', 'unread'),
(16, 'info', 'admin loged in', 'Sunday 1st of March 2015 07:28:54 AM', 'unread'),
(17, 'info', 'admin loged in', 'Monday 2nd of March 2015 05:50:03 AM', 'unread'),
(18, 'info', 'admin loged in', 'Monday 2nd of March 2015 06:15:17 AM', 'unread'),
(19, 'info', 'admin loged in', 'Monday 2nd of March 2015 07:02:39 AM', 'unread'),
(20, 'info', 'admin loged in', 'Monday 2nd of March 2015 08:48:24 AM', 'unread'),
(21, 'info', 'admin loged in', 'Monday 2nd of March 2015 10:08:32 AM', 'unread'),
(22, 'info', 'admin loged in', 'Monday 2nd of March 2015 12:10:18 PM', 'unread'),
(23, 'info', 'admin loged in', 'Monday 2nd of March 2015 04:28:34 PM', 'unread'),
(24, 'info', 'admin loged in', 'Monday 2nd of March 2015 04:51:14 PM', 'unread'),
(25, 'info', 'admin loged in', 'Monday 2nd of March 2015 06:00:40 PM', 'unread'),
(26, 'info', 'prappo loged in', 'Monday 2nd of March 2015 06:00:56 PM', 'unread'),
(27, 'info', 'admin loged in', 'Monday 2nd of March 2015 06:01:49 PM', 'unread'),
(28, 'info', 'mehedi loged in', 'Thursday 5th of March 2015 10:59:11 AM', 'unread'),
(29, 'info', 'admin loged in', 'Tuesday 31st of March 2015 01:29:30 PM', 'unread'),
(30, 'info', 'admin loged in', 'Tuesday 31st of March 2015 06:06:19 PM', 'unread'),
(31, 'info', 'admin loged in', 'Tuesday 31st of March 2015 06:49:16 PM', 'unread'),
(32, 'info', 'student_7 loged in', 'Tuesday 31st of March 2015 06:49:56 PM', 'unread'),
(33, 'info', 'admin loged in', 'Tuesday 31st of March 2015 06:51:29 PM', 'unread'),
(34, 'info', 'student_7 loged in', 'Tuesday 31st of March 2015 06:52:14 PM', 'unread'),
(35, 'info', 'admin loged in', 'Tuesday 31st of March 2015 06:52:24 PM', 'unread'),
(36, 'info', 'admin loged in', 'Tuesday 31st of March 2015 07:21:06 PM', 'unread'),
(37, 'info', 'student_10 loged in', 'Tuesday 31st of March 2015 07:25:00 PM', 'unread'),
(38, 'info', 'admin loged in', 'Tuesday 31st of March 2015 07:25:21 PM', 'unread'),
(39, 'info', 'student_10 loged in', 'Tuesday 31st of March 2015 08:22:17 PM', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `vor_settings`
--

CREATE TABLE IF NOT EXISTS `vor_settings` (
  `id` int(12) NOT NULL,
  `notify` varchar(10) NOT NULL,
  `home` varchar(255) NOT NULL,
  `header` varchar(20) NOT NULL,
  `foot` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vor_settings`
--

INSERT INTO `vor_settings` (`id`, `notify`, `home`, `header`, `foot`) VALUES
(1, 'on', '', 'My <span> Softwre ', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scl_class_routine`
--
ALTER TABLE `scl_class_routine`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scl_notices`
--
ALTER TABLE `scl_notices`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scl_principal`
--
ALTER TABLE `scl_principal`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scl_students`
--
ALTER TABLE `scl_students`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scl_teachers`
--
ALTER TABLE `scl_teachers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vor_admin`
--
ALTER TABLE `vor_admin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vor_notify`
--
ALTER TABLE `vor_notify`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vor_settings`
--
ALTER TABLE `vor_settings`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scl_class_routine`
--
ALTER TABLE `scl_class_routine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `scl_notices`
--
ALTER TABLE `scl_notices`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `scl_principal`
--
ALTER TABLE `scl_principal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scl_students`
--
ALTER TABLE `scl_students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `scl_teachers`
--
ALTER TABLE `scl_teachers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vor_admin`
--
ALTER TABLE `vor_admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `vor_notify`
--
ALTER TABLE `vor_notify`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

<?php
$query = "CREATE TABLE IF NOT EXISTS `scl_class_routine` (
`id` int(11) NOT NULL,
  `class` varchar(10) NOT NULL,
  `subject` varchar(15) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start` varchar(15) NOT NULL,
  `end` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `scl_exam_routine` (
`id` int(11) NOT NULL,
  `class` varchar(10) NOT NULL,
  `subject` varchar(15) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start` varchar(10) NOT NULL,
  `end` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `scl_notices` (
`id` int(11) NOT NULL,
  `notice` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `scl_principal` (`id`, `name_title`, `first_name`, `last_name`, `nationality`, `gender`, `address`, `qualification`, `date_of_birth`, `joining_date`, `mobile`, `email`, `about`) VALUES
(1, 'Prof.', 'Mehedi', 'Hassan', 'Bangladeshi', 'Male', '', '', '1997-07-30', '2015-04-18', '', 'principal@vor.com', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

ALTER TABLE `scl_class_routine`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `scl_exam_routine`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `scl_notices`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `scl_principal`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `scl_students`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `scl_teachers`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `scl_class_routine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scl_exam_routine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scl_notices`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scl_principal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

ALTER TABLE `scl_students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scl_teachers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";


$pdo = db_connect();
$pdo->query($query);
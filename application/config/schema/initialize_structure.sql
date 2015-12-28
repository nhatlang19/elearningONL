-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2015 at 04:04 PM
-- Server version: 5.5.44
-- PHP Version: 5.4.44-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `el`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

DROP TABLE IF EXISTS `academic_year`;
CREATE TABLE IF NOT EXISTS `academic_year` (
  `academic_id` int(11) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `academic_name` varchar(255) NOT NULL,
  PRIMARY KEY (`academic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `storage_answer_id` int(11) NOT NULL,
  `correct_answer` tinyint(4) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `storage_question_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT '0',
  PRIMARY KEY (`answer_id`),
  KEY `FK_answer_qid` (`topic_id`),
  KEY `FK_answer_sqid_sqid` (`storage_question_id`,`topic_id`),
  KEY `FK_answer` (`storage_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

DROP TABLE IF EXISTS `block`;
CREATE TABLE IF NOT EXISTS `block` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`class_id`),
  KEY `FK_class` (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
CREATE TABLE IF NOT EXISTS `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL COMMENT 'so phut',
  `published` tinyint(4) DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`exam_id`),
  UNIQUE KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `storage_question_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `mark` float NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`storage_question_id`,`topic_id`),
  KEY `FK_question_topic` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

DROP TABLE IF EXISTS `storage`;
CREATE TABLE IF NOT EXISTS `storage` (
  `storage_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subjects_id` int(11) DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`storage_id`),
  KEY `FK_storage` (`subjects_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `storage_answer`
--

DROP TABLE IF EXISTS `storage_answer`;
CREATE TABLE IF NOT EXISTS `storage_answer` (
  `storage_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `storage_question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `correct_answer` tinyint(4) NOT NULL DEFAULT '0',
  `hashkey` char(40) NOT NULL,
  PRIMARY KEY (`storage_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=374 ;

-- --------------------------------------------------------

--
-- Table structure for table `storage_question`
--

DROP TABLE IF EXISTS `storage_question`;
CREATE TABLE IF NOT EXISTS `storage_question` (
  `storage_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` varchar(255) NOT NULL,
  `hashkey` char(40) NOT NULL COMMENT '0: text, 1: image',
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `storage_id` int(11) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`storage_question_id`),
  UNIQUE KEY `hashkey` (`hashkey`),
  KEY `FK_storage_question` (`storage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_answer`
--

DROP TABLE IF EXISTS `student_answer`;
CREATE TABLE IF NOT EXISTS `student_answer` (
  `answer_student_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `answer` int(11) NOT NULL COMMENT 'cau tra loi cua hoc sinh',
  `number_question` int(11) DEFAULT '0',
  `student_mark_id` int(11) NOT NULL,
  PRIMARY KEY (`answer_student_id`),
  KEY `FK_answer_student` (`question_id`),
  KEY `FK_answer_student_info` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

DROP TABLE IF EXISTS `student_info`;
CREATE TABLE IF NOT EXISTS `student_info` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `indentity_number` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `username` (`username`),
  KEY `FK_student_info` (`class_id`),
  KEY `FK_student_info_topic` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=245 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_mark`
--

DROP TABLE IF EXISTS `student_mark`;
CREATE TABLE IF NOT EXISTS `student_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `score` double DEFAULT NULL,
  `number_correct` int(11) DEFAULT NULL,
  `is_mark` tinyint(4) DEFAULT '0',
  `ip_address` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique_student_topic` (`student_id`,`topic_id`),
  KEY `FK_student_mark` (`student_id`),
  KEY `FK_student_mark_topic_id` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `subjects_id` int(11) NOT NULL AUTO_INCREMENT,
  `subjects_name` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subjects_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `topic_manage_id` int(11) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`),
  KEY `FK_topic_topic_manage` (`topic_manage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `topic_book`
--

DROP TABLE IF EXISTS `topic_book`;
CREATE TABLE IF NOT EXISTS `topic_book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_manage_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `topic_files`
--

DROP TABLE IF EXISTS `topic_files`;
CREATE TABLE IF NOT EXISTS `topic_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_manage_id` int(11) NOT NULL,
  `folder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_topicManageId_classId` (`topic_manage_id`,`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `topic_manage`
--

DROP TABLE IF EXISTS `topic_manage`;
CREATE TABLE IF NOT EXISTS `topic_manage` (
  `topic_manage_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `exam_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `created_time` date NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `number_questions` int(11) DEFAULT NULL,
  `status` enum('ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `review` enum('SHOW','HIDE') NOT NULL DEFAULT 'HIDE',
  `subjects_id` int(11) NOT NULL,
  PRIMARY KEY (`topic_manage_id`),
  KEY `FK_topic_manage` (`exam_id`),
  KEY `FK_topic_manage_academic` (`academic_id`),
  KEY `published` (`published`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subjects_id` int(11) DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `role` int(11) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_users` (`subjects_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_manage_class`
--

DROP TABLE IF EXISTS `user_manage_class`;
CREATE TABLE IF NOT EXISTS `user_manage_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `user_id` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_manage_class` (`class_id`),
  KEY `FK_user_manage_class_username` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_answer` FOREIGN KEY (`storage_answer_id`) REFERENCES `storage_answer` (`storage_answer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_answer_sqid_sqid` FOREIGN KEY (`storage_question_id`, `topic_id`) REFERENCES `question` (`storage_question_id`, `topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `FK_class` FOREIGN KEY (`block_id`) REFERENCES `block` (`block_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_question_sqid` FOREIGN KEY (`storage_question_id`) REFERENCES `storage_question` (`storage_question_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `FK_question_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `FK_storage` FOREIGN KEY (`subjects_id`) REFERENCES `subjects` (`subjects_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `storage_question`
--
ALTER TABLE `storage_question`
  ADD CONSTRAINT `FK_storage_question` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`storage_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_answer`
--
ALTER TABLE `student_answer`
  ADD CONSTRAINT `FK_answer_student_info` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`);

--
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `FK_student_info` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_mark`
--
ALTER TABLE `student_mark`
  ADD CONSTRAINT `FK_student_mark` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_student_mark_topic_id` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_topic_topic_manage` FOREIGN KEY (`topic_manage_id`) REFERENCES `topic_manage` (`topic_manage_id`) ON DELETE CASCADE;

--
-- Constraints for table `topic_manage`
--
ALTER TABLE `topic_manage`
  ADD CONSTRAINT `FK_topic_manage` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_topic_manage_academic` FOREIGN KEY (`academic_id`) REFERENCES `academic_year` (`academic_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`subjects_id`) REFERENCES `subjects` (`subjects_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `user_manage_class`
--
ALTER TABLE `user_manage_class`
  ADD CONSTRAINT `FK_user_manage_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2016 at 05:05 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `el`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE IF NOT EXISTS `academic_year` (
  `academic_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `academic_name` varchar(255) NOT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int(11) NOT NULL,
  `storage_answer_id` int(11) NOT NULL,
  `correct_answer` tinyint(4) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `storage_question_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE IF NOT EXISTS `block` (
  `block_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `exam_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL COMMENT 'so phut',
  `published` tinyint(4) DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `storage_question_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `mark` float NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  `correct` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE IF NOT EXISTS `storage` (
  `storage_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subjects_id` int(11) DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storage_answer`
--

CREATE TABLE IF NOT EXISTS `storage_answer` (
  `storage_answer_id` int(11) NOT NULL,
  `storage_question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `correct_answer` tinyint(4) NOT NULL DEFAULT '0',
  `hashkey` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storage_question`
--

CREATE TABLE IF NOT EXISTS `storage_question` (
  `storage_question_id` int(11) NOT NULL,
  `question_name` text NOT NULL,
  `select_any` tinyint(4) NOT NULL DEFAULT '1',
  `hashkey` char(150) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `storage_id` int(11) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_answer`
--

CREATE TABLE IF NOT EXISTS `student_answer` (
  `answer_student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `answer` char(100) NOT NULL DEFAULT '' COMMENT 'cau tra loi cua hoc sinh',
  `number_question` int(11) DEFAULT '0',
  `student_mark_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE IF NOT EXISTS `student_info` (
  `student_id` int(11) NOT NULL,
  `indentity_number` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_mark`
--

CREATE TABLE IF NOT EXISTS `student_mark` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `score` double DEFAULT NULL,
  `number_correct` int(11) DEFAULT NULL,
  `is_mark` tinyint(4) DEFAULT '0',
  `ip_address` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_topic`
--

CREATE TABLE IF NOT EXISTS `student_topic` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `started` tinyint(4) NOT NULL DEFAULT '0',
  `finished` tinyint(4) NOT NULL DEFAULT '0',
  `student_mark_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `subjects_id` int(11) NOT NULL,
  `subjects_name` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topic_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `topic_manage_id` int(11) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topic_book`
--

CREATE TABLE IF NOT EXISTS `topic_book` (
  `book_id` int(11) NOT NULL,
  `topic_manage_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topic_files`
--

CREATE TABLE IF NOT EXISTS `topic_files` (
  `id` int(11) NOT NULL,
  `topic_manage_id` int(11) NOT NULL,
  `folder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topic_manage`
--

CREATE TABLE IF NOT EXISTS `topic_manage` (
  `topic_manage_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `exam_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `created_time` date NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `number_questions` int(11) DEFAULT NULL,
  `status` enum('ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `review` enum('SHOW','HIDE') NOT NULL DEFAULT 'HIDE',
  `flow` enum('NONE','START','END','') NOT NULL DEFAULT 'NONE',
  `subjects_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subjects_id` int(11) DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `role` int(11) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `subjects_id`, `published`, `deleted`, `role`, `modified`) VALUES
(1, 'Luan Nguyen', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'nhatlang19@gmail.com', NULL, 1, 0, 1, '2015-11-23 15:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_manage_class`
--

CREATE TABLE IF NOT EXISTS `user_manage_class` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `user_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`academic_id`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `FK_answer_qid` (`topic_id`),
  ADD KEY `FK_answer_sqid_sqid` (`storage_question_id`,`topic_id`),
  ADD KEY `FK_answer` (`storage_answer_id`);

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `FK_class` (`block_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`storage_question_id`,`topic_id`),
  ADD KEY `FK_question_topic` (`topic_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`storage_id`),
  ADD KEY `FK_storage` (`subjects_id`);

--
-- Indexes for table `storage_answer`
--
ALTER TABLE `storage_answer`
  ADD PRIMARY KEY (`storage_answer_id`);

--
-- Indexes for table `storage_question`
--
ALTER TABLE `storage_question`
  ADD PRIMARY KEY (`storage_question_id`),
  ADD UNIQUE KEY `hashkey` (`hashkey`),
  ADD KEY `FK_storage_question` (`storage_id`);

--
-- Indexes for table `student_answer`
--
ALTER TABLE `student_answer`
  ADD PRIMARY KEY (`answer_student_id`),
  ADD KEY `FK_answer_student` (`question_id`),
  ADD KEY `FK_answer_student_info` (`student_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `FK_student_info` (`class_id`),
  ADD KEY `FK_student_info_topic` (`password`);

--
-- Indexes for table `student_mark`
--
ALTER TABLE `student_mark`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Unique_student_topic` (`student_id`,`topic_id`),
  ADD KEY `FK_student_mark` (`student_id`),
  ADD KEY `FK_student_mark_topic_id` (`topic_id`);

--
-- Indexes for table `student_topic`
--
ALTER TABLE `student_topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjects_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `FK_topic_topic_manage` (`topic_manage_id`);

--
-- Indexes for table `topic_book`
--
ALTER TABLE `topic_book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `topic_files`
--
ALTER TABLE `topic_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_topicManageId_classId` (`topic_manage_id`,`class_id`);

--
-- Indexes for table `topic_manage`
--
ALTER TABLE `topic_manage`
  ADD PRIMARY KEY (`topic_manage_id`),
  ADD KEY `FK_topic_manage` (`exam_id`),
  ADD KEY `FK_topic_manage_academic` (`academic_id`),
  ADD KEY `published` (`published`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users` (`subjects_id`);

--
-- Indexes for table `user_manage_class`
--
ALTER TABLE `user_manage_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_manage_class` (`class_id`),
  ADD KEY `FK_user_manage_class_username` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `academic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `storage_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `storage_answer`
--
ALTER TABLE `storage_answer`
  MODIFY `storage_answer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `storage_question`
--
ALTER TABLE `storage_question`
  MODIFY `storage_question_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_answer`
--
ALTER TABLE `student_answer`
  MODIFY `answer_student_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_mark`
--
ALTER TABLE `student_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_topic`
--
ALTER TABLE `student_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subjects_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic_book`
--
ALTER TABLE `topic_book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic_files`
--
ALTER TABLE `topic_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic_manage`
--
ALTER TABLE `topic_manage`
  MODIFY `topic_manage_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_manage_class`
--
ALTER TABLE `user_manage_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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

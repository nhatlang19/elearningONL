ALTER TABLE `topic_manage` ADD `flow` ENUM('NONE','START','END') NOT NULL DEFAULT 'NONE' AFTER `review`;

ALTER TABLE `student_info` ADD `acedemic_id` int NOT NULL AFTER `class_id`;

ALTER TABLE `academic_year` ADD `default` TINYINT NOT NULL DEFAULT '0' AFTER `academic_name`;

CREATE TABLE IF NOT EXISTS `student_topic` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `started` tinyint(4) NOT NULL DEFAULT '0',
  `finished` tinyint(4) NOT NULL DEFAULT '0',
  `student_mark_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `storage` ADD `deleted` TINYINT NOT NULL DEFAULT '0' AFTER `published`;
ALTER TABLE `storage_question` CHANGE `hashkey` `hashkey` CHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
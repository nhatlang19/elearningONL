ALTER TABLE `topic_manage` ADD `flow` ENUM('NONE','START','END') NOT NULL DEFAULT 'NONE' AFTER `review`;

ALTER TABLE `student_info` ADD `acedemic_id` int NOT NULL AFTER `class_id`;

ALTER TABLE `academic_year` ADD `default` TINYINT NOT NULL DEFAULT '0' AFTER `academic_name`;



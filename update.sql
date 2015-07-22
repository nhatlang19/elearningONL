ALTER TABLE  `topic_manage` ADD  `status`  ENUM(  'ACTIVE',  'DELETED' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'ACTIVE';
ALTER TABLE  `topic_manage` ADD  `review` ENUM(  'SHOW',  'HIDE' ) NOT NULL DEFAULT  'HIDE';
ALTER TABLE  `student_mark` ADD  `ip_address` VARCHAR( 20 ) NOT NULL ;

-- 11072014
ALTER TABLE `student_mark` ADD `date` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL ;
ALTER TABLE `student_answer` ADD `student_mark_id` INT NOT NULL ;

-- 14072014
CREATE TABLE IF NOT EXISTS `topic_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_manage_id` int(11) NOT NULL,
  `folder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
ALTER TABLE `topic_files` ADD `dated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `topic_files` ADD UNIQUE `UNIQUE_topicManageId_classId` ( `topic_manage_id` , `class_id` ) COMMENT '';

ALTER TABLE `topic_manage` ADD `subjects_id` INT NOT NULL ;

-- need to create foreign key



ALTER TABLE `subjects` CHANGE `modified` `modified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `users` ADD `fullname` VARCHAR(255) NOT NULL AFTER `id`;


CREATE TABLE IF NOT EXISTS `student_topic` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `finished` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `student_topic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`topic_id`);
  
ALTER TABLE `student_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `student_topic` ADD `finished` TINYINT NOT NULL DEFAULT '0' AFTER `topic_id`;
ALTER TABLE `student_topic` ADD `student_mark_id` INT NOT NULL AFTER `finished`;


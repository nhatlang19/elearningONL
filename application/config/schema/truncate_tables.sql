SET FOREIGN_KEY_CHECKS = 0;
truncate table academic_year;
truncate table answer;
truncate table block;
truncate table class;
truncate table exam;
truncate table question;
truncate table storage;
truncate table storage_answer;
truncate table storage_question;
truncate table student_answer;
truncate table student_info;
truncate table student_topic;
truncate table student_mark;
truncate table subjects;
truncate table topic;
truncate table topic_book;
truncate table topic_files;
truncate table topic_manage;
truncate table user_manage_class;
SET FOREIGN_KEY_CHECKS = 1;

-- Xoá kho csdl
SET FOREIGN_KEY_CHECKS = 0;
truncate table question;
truncate table answer;
truncate table storage;
truncate table storage_answer;
truncate table storage_question;
truncate table student_answer;
truncate table student_topic;
truncate table student_info;
truncate table student_mark;
truncate table topic;
truncate table topic_book;
truncate table topic_files;
truncate table topic_manage;
truncate table user_manage_class;
SET FOREIGN_KEY_CHECKS = 1;


SET FOREIGN_KEY_CHECKS = 0;
truncate table storage_answer;
truncate table storage_question;
SET FOREIGN_KEY_CHECKS = 1;

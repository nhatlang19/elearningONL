<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Role
 */
define('ADMINISTRATOR', 1);
define('MANAGER', 10);
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('GROUP_CONCAT_MAX_LENGTH', 1000000);

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('LIST_STUDENT', 'Danh sách học sinh');
define('MANAGE_STUDENT', 'Quản lý học sinh');
define('ADD_STUDENT', 'Thêm học sinh');
define('EDIT_STUDENT', 'Chỉnh sửa học sinh');
define('IMPORT_STUDENT', 'Import học sinh');

// FRONTEND
define('EXAM_RESULT', 'Kết quả');
define('EXAM_QUOTE', 'Thi trắc nghiệm');

define('USERNAME', 'Tên đăng nhập');
define('PASSWORD', 'Mật khẩu');
define('NO_TOPIC', 'Hiện không có 1 đề thi nào. Vui lòng liên hệ giáo viên của bạn hay quản trị viên để tạo đề thi');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
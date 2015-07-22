<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @author nhox
 * refs: http://ellislab.com/codeigniter/user-guide/database/utilities.html
 */
class Mybackup {

	public function _do($download = true)
	{
		$CI =& get_instance();

		// Load the DB utility class
		$CI->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup =& $CI->dbutil->backup();

		// Load the file helper and write the file to your server
		$CI->load->helper('file');
		write_file(BACK_END_BACKUP_PATH_ROOT . NAME_BACKUP, $backup);

		if($download) {
			// Load the download helper and send the file to your desktop
			$CI->load->helper('download');
			force_download(NAME_BACKUP, $backup);
		}
	}

	/**
	 * SET FOREIGN_KEY_CHECKS = 0;
			
TRUNCATE `answer`;
TRUNCATE `question`;
TRUNCATE `storage`;
TRUNCATE `storage_answer`;
TRUNCATE `storage_question`;
TRUNCATE `student_answer`;
TRUNCATE `topic`;
TRUNCATE `topic_manage`;
SET FOREIGN_KEY_CHECKS = 1;
	 * @param unknown $tables
	 */
	public function _truncateTables($tables = array()) {
		$CI =& get_instance();
		
		if(!count($tables)) {
			$tables = $CI->db->list_tables();
			$CI->db->query("SET FOREIGN_KEY_CHECKS = 0");
			foreach($tables as $table) {
				$CI->db->truncate($table);
			}
			$CI->db->query("SET FOREIGN_KEY_CHECKS = 1");
		}
	}
	
	public function _dropTables($tables = array()) {
		$this->_truncateTables($tables);
		
		$CI =& get_instance();
	
		$CI->load->dbforge();
		if(!count($tables)) {
			$tables = $CI->db->list_tables();
			$CI->db->query("SET FOREIGN_KEY_CHECKS = 0");
			foreach($tables as $table) {
				$CI->dbforge->drop_table($table);
			}
			$CI->db->query("SET FOREIGN_KEY_CHECKS = 1");
		}
	}
}

/* End of file Someclass.php */
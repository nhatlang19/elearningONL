<?php
class Storage_question_model extends Ext_Model {
	public function __construct() {
		parent::__construct('storage_question', 'storage_question_id');
	}
	
	function getStorageQuestionAll($title = null, $subjects_id = 0, $storage_id = -1, $start = null, $count = null) {
		// start cache
		$this->db->start_cache();

		$this->db->select('sq.*, s.title');
		$this->db->from($this->table_name . ' as sq');
		$this->db->join('storage as s', 's.storage_id = sq.storage_id');
		$this->db->join('subjects as sub', 'sub.subjects_id = s.subjects_id', 'left');
		if($title) {
			$this->db->like('sq.question_name', $title);
		}
		
		if($subjects_id) {
			$this->db->where('s.subjects_id', $subjects_id);
		}
		
		if($storage_id > 0 ) {
			$this->db->where('sq.storage_id', $storage_id);
		}

		$query = $this->db->get();
		// stop cache
		$this->db->stop_cache();
		
		// get total records before filter by limit
		$this->table_record_count = $query->num_rows();
		
		$this->db->order_by('sq.question_name', 'asc');
		$this->db->order_by('sq.updated_time', 'desc');
				
		$this->db->group_by('sq.storage_question_id');
		
		if(!is_null($start)) {
			if(!is_null($count)) {
				$this->db->limit($count, $start);
			}
			else {
				$this->db->limit($start);
			}
		}

		$query = $this->db->get();
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$results = $query->result_array();
		}
		
		// flush cache
		$this->db->flush_cache();
		return $results;
	}
	
	function getStorageQuestionByStorageIdRandom($storage_id = -1, $num_rand = 0) {
		$results = array();
		if($storage_id != -1 && $num_rand) {
			$num_rand = intval($num_rand);
			
			$sql = "SELECT SUBSTRING_INDEX(GROUP_CONCAT(sq.storage_question_id ORDER BY RAND() SEPARATOR \"|||\"), \"|||\", $num_rand ) AS sqid";
			$sql .= " FROM " . $this->table_name . " as sq";
			$sql .= " WHERE sq.published = ?";
			$sql .= " AND sq.storage_id = ?";
			
			$query = $this->db->query($sql, array(1, $storage_id));
			
			if(!empty($query) && $query->num_rows() > 0) {
				$temp = $query->result_array();
				$results = array_pop($temp);
			}
		
		}
		return $results;
	}
	
	function countAllStoragePublished() {		
		$this->db->from($this->table_name);
		$this->db->where(array('published' =>1));
		return $this->db->count_all_results();
	}
}
<?php
class Class_model extends Ext_Model {
	public function __construct() {
		parent::__construct('class', 'class_id');
	}
	
	function getAllClass($title = NULL, $start = NULL, $count = NULL) {
		
		// start cache
		$this->db->start_cache();
		
		$this->db->select('c.*, b.title as block_name');
		$this->db->from($this->table_name . ' as c');
		$this->db->join('block as b', 'b.block_id = c.block_id');
		if($title) {
			$this->db->like('c.class_name', $title);
		}
		
		$query = $this->db->get();
		// stop cache
		$this->db->stop_cache();
		
		// get total records before filter by limit
		$this->table_record_count = $query->num_rows();
		
		$this->db->order_by('c.class_name', 'asc');
		
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
	
	public function loadClassByBlockid($block_id) {
		$filters = array();
		if($block_id)
			$filters = array('block_id' => $block_id);
		return $this->find($filters);
	}
}
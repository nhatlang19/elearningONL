<?php
class Student_info_model extends Ext_Model {
	const USER_ACTIVE = 'Active';
	const USER_DELETED = 'Deleted';
	
	public function __construct() {
		parent::__construct('student_info', 'student_id');
	}

	public function login($username, $password) {
		$data = null;

		$this->db->select('s.*, c.class_name');
		$this->db->from($this->table_name . ' as s');
		$this->db->join('class as c', 'c.class_id = s.class_id', 'left');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('status', self::USER_ACTIVE);
		$query = $this->db->get();

		$rows = $query->result();
		if($rows)
			$data = $rows[0];
		return $data;
	}
	
	function getAllStudents($name = NULL, $class_id = -1, $start = NULL, $count = NULL, $direction = 'asc' ) {
		// start cache
		$this->db->start_cache();
		
		$this->db->select('s.*, c.class_name');
		$this->db->from($this->table_name . ' as s');
		$this->db->join('class as c', 'c.class_id = s.class_id', 'left');
		if($name) {
			$this->db->like('s.fullname', $name);
		}
		if($class_id > -1) {
			$this->db->like('s.class_id', $class_id);
		}
		
		$query = $this->db->get();
		// stop cache
		$this->db->stop_cache();
		
		// get total records before filter by limit
		$this->table_record_count = $query->num_rows();
		
		$this->db->order_by('s.indentity_number', 'asc');
		
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
	
	function getMarkStudentsByClass($class_id) {
		$data = null;
		$this->db->select('sm.*, si.indentity_number, si.fullname, si.class_id, c.class_name');
		$this->db->from($this->table_name . ' as si');
		$this->db->join('student_mark as sm', 'si.student_id = sm.student_id', 'LEFT');
		$this->db->join('class as c', 'c.class_id = si.class_id');
		$this->db->where('si.class_id', $class_id);
	
		$this->db->order_by('si.indentity_number');
		$query = $this->db->get();
	
		$rows = $query->result_array();
		if($rows) {
			$data = $rows;
		}
		return $data;
	}
}
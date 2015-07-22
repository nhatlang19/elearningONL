<?php
class Academic_model extends Ext_Model {
	public function __construct() {
		parent::__construct('academic_year', 'academic_id');
	}
	
	function getAllAcademic($academic_name = NULL, $start = NULL, $count = NULL) {
		$filters = array();
		if($academic_name)
			$filters = array('academic_name like' => '%' . $academic_name . '%');
		return $this->find($filters, $start, $count, 'academic_name', 'desc');
	}
}
<?php
class Exam_model extends Ext_Model {
	public function __construct() {
		parent::__construct('exam', 'exam_id');
	}
	
	function getAllExam($title = NULL, $start = NULL, $count = NULL) {
		$filters = array();
		if($title)
			$filters = array('title like' => '%' . $title . '%');
		return $this->find($filters, $start, $count, 'title', 'asc');
	}
}
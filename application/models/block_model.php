<?php
class Block_model extends Ext_Model {
	public function __construct() {
		parent::__construct('block', 'block_id');
	}
	
	function getAllBlock($title = NULL, $start = NULL, $count = NULL) {
		$filters = array();
		if($title)
			$filters = array('title like' => '%' . $title . '%');
		return $this->find($filters, $start, $count, 'title', 'asc');
	}
}
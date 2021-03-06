<?php

class Class_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('class', 'class_id');
    }

    public function getAll($start = null, $count = null, $cached = true)
    {
        $this->db->join('block', 'block.block_id = class.block_id');
        $this->db->select('block.title');
        return parent::getAll($start, $count, $cached);
    }

    public function loadClassByBlockid($block_id)
    {
        return $this->find([
            'block_id' => $block_id
        ]);
    }
	
	public function getClassByClassName($className) {
		$filter_rules = array(
			'class_name' => $className
        );
        $result = $this->find($filter_rules);
        if (! empty($result)) {
            return $result[0];
        }
        
        return $result;
	}
}

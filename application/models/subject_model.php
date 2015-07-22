<?php

class Subject_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('subjects', 'subjects_id');
    }

    function getAllSubjects($subjects_name = NULL, $start = NULL, $count = NULL, $direction = 'asc')
    {
        $filters = array();
        if ($subjects_name)
            $filters = array(
                'subjects_name like' => '%' . $subjects_name . '%'
            );
        return $this->find($filters, $start, $count, 'subjects_name', $direction);
    }
}
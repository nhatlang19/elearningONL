<?php

class Student_mark_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('student_mark', 'id');
    }

    function getMarkStudents($listTopics)
    {
        $data = null;
        $this->db->select('sm.*, si.indentity_number, si.fullname, si.class_id, c.class_name');
        $this->db->from($this->table_name . ' as sm');
        $this->db->join('student_info as si', 'si.student_id = sm.student_id');
        $this->db->join('class as c', 'c.class_id = si.class_id');
        $this->db->where('sm.is_mark', 1);
        $this->db->where_in('sm.topic_id', $listTopics);
        
        $query = $this->db->get();
        
        $rows = $query->result_array();
        if ($rows) {
            $data = $rows;
        }
        return $data;
    }

    function getMarkStudentById($student_mark_id)
    {
        $this->db->select('sm.score, sm.number_correct');
        $this->db->from($this->table_name . ' as sm');
        $this->db->where('sm.is_mark', 1);
        $this->db->where('sm.id', $student_mark_id);
        
        $query = $this->db->get();
        return $query->row_array();
    }
}
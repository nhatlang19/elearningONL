<?php

class Student_info_model extends Ext_Model
{
    public function __construct()
    {
        parent::__construct('student_info', 'student_id');
    }

    public function login($username, $password)
    {
        $data = null;
        
        $this->db->select('s.*, c.class_name');
        $this->db->from($this->table_name . ' as s');
        $this->db->join('class as c', 'c.class_id = s.class_id', 'left');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        $rows = $query->result();
        if ($rows)
            $data = $rows[0];
        return $data;
    }

    function getAllStudents($class_id = -1)
    {
        $filter = [];
        if(!empty($class_id) && $class_id != -1) {
            $filter = [$this->table_name . '.class_id' => $class_id];
        }
        $this->db->select('c.class_name');
        $this->db->join('class as c', 'c.class_id = ' . $this->table_name . '.class_id', 'left');
        return $this->findAll($filter);
    }

    function getMarkStudentsByClass($class_id)
    {
        $data = null;
        $this->db->select('sm.*, si.indentity_number, si.fullname, si.class_id, c.class_name');
        $this->db->from($this->table_name . ' as si');
        $this->db->join('student_mark as sm', 'si.student_id = sm.student_id', 'LEFT');
        $this->db->join('class as c', 'c.class_id = si.class_id');
        $this->db->where('si.class_id', $class_id);
        
        $this->db->order_by('si.indentity_number');
        $query = $this->db->get();
        
        $rows = $query->result_array();
        if ($rows) {
            $data = $rows;
        }
        return $data;
    }
}
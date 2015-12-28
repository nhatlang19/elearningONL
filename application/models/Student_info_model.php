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
        $this->db->where('s.username', $username);
        $this->db->where('s.password', $password);
        $this->db->where('s.deleted', self::DELETED_NO);
        $query = $this->db->get();
        
        $rows = $query->result();
        if ($rows)
            $data = $rows[0];
        return $data;
    }
    
    public function isExistsStudent($indentity_number, $class_id) {
        $data = null;
        
        $this->db->select('s.id');
        $this->db->from($this->table_name . ' as s');
        $this->db->where('s.indentity_number', $indentity_number);
        $this->db->where('s.class_id', $class_id);
        $this->db->where('s.deleted', self::DELETED_NO);
        $query = $this->db->get();
        
        $rows = $query->result();
        pr($rows);exit;
        return count($rows) ? true : false;
    }

    function getAllStudents($class_id = -1)
    {
        $filter = [];
        if(!empty($class_id) && $class_id != -1) {
            $filter = [$this->table_name . '.class_id' => $class_id];
        }
        $this->db->select('c.class_name');
        $this->db->join('class as c', 'c.class_id = ' . $this->table_name . '.class_id', 'left');
        $this->db->where($this->table_name . '.deleted', self::DELETED_NO);
        return $this->findAll($filter);
    }

    function getMarkStudentsByClass($class_id)
    {
        $data = null;
        $this->db->select('sm.*, si.indentity_number, si.fullname, si.class_id, c.class_name');
        $this->db->from($this->table_name . ' as si');
        $this->db->join('student_mark as sm', 'si.student_id = sm.student_id', 'LEFT');
        $this->db->join('class as c', 'c.class_id = si.class_id', 'LEFT');
        $this->db->where('si.class_id', $class_id);
        
        $this->db->order_by('cast(si.indentity_number as unsigned)');
        $query = $this->db->get();
        
        $rows = $query->result();
        if ($rows) {
            $data = $rows;
        }
        return $data;
    }
}
<?php

class Academic_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('academic_year', 'academic_id');
    }
    
    public function getDefaultValue() {
        $data = null;
        
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('default', 1);
        $query = $this->db->get();
        
        $rows = $query->result();
        if ($rows)
            $data = $rows[0];
        return $data;
    }
}
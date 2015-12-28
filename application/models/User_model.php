<?php

class User_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('users', 'username');
    }

    function getAllUser($username = NULL, $start = NULL, $count = NULL)
    {
        // start cache
        $this->db->start_cache();
        
        $this->db->select('u.*, s.subjects_name');
        $this->db->from($this->table_name . ' as u');
        $this->db->join('subjects as s', 's.subjects_id = u.subjects_id');
        if ($username) {
            $this->db->like('u.username', $title);
        }
        $this->db->where('u.role', 10);
        $query = $this->db->get();
        // stop cache
        $this->db->stop_cache();
        
        // get total records before filter by limit
        $this->table_record_count = $query->num_rows();
        
        $this->db->order_by('u.username', 'asc');
        
        if (! is_null($start)) {
            if (! is_null($count)) {
                $this->db->limit($count, $start);
            } else {
                $this->db->limit($start);
            }
        }
        
        $query = $this->db->get();
        $results = array();
        if (! empty($query) && $query->num_rows() > 0) {
            $results = $query->result();
        }
        
        // flush cache
        $this->db->flush_cache();
        return $results;
    }

    function get_user($username, $password)
    {
        $data = null;
        
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get();
        
        $rows = $query->result();
        if ($rows)
            $data = $rows[0];
        return $data;
    }

    function update_password($id, $pass)
    {
        $data['password'] = md5($pass);
        $this->db->where('username', $id);
        $this->db->update($this->table_name, $data);
    }
}

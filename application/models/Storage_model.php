<?php

class Storage_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('storage', 'storage_id');
    }

    function exportData($storage_id = 0)
    {
        $results = array();
        if ($storage_id) {
            $this->db->select('sq.question_name
			, GROUP_CONCAT(sa.answer SEPARATOR "|||") AS answer, GROUP_CONCAT(sa.correct_answer) as correct_answer');
            $this->db->from('storage_question as sq');
            $this->db->join('storage_answer as sa', 'sa.hashkey = sq.hashkey');
            $this->db->where('sq.storage_id', $storage_id);
            
            $this->db->order_by('sq.question_name', 'asc');
            $this->db->group_by('sq.question_name');
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                $results = $query->result();
            }
        }
        return $results;
    }

    function getStorageList($subjects_id = 0, $count = NULL, $start = NULL)
    {
        // start cache
        $this->db->start_cache();
        
        $this->db->select('s.storage_id, s.title, s.updated_time, s.published, sub.subjects_name
		, (select count(*) from storage_question as sq where sq.storage_id = s.storage_id and sq.deleted = 0) as num_question');
        $this->db->from('storage as s');
        $this->db->join('subjects as sub', 'sub.subjects_id = s.subjects_id', 'left');
        
        if ($subjects_id) {
            $this->db->where('s.subjects_id', $subjects_id);
        }
        $this->db->where('s.deleted', self::DELETED_NO);
        $query = $this->db->get();
        
        // stop cache
        $this->db->stop_cache();
        
        // get total records before filter by limit
        $this->table_record_count = $query->num_rows();
        
        $this->db->order_by('s.updated_time', 'desc');
        $this->db->group_by('s.storage_id');
        
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

    function getStoragePublishedByUser($subjects_id = 0)
    {
        $subjects_id = (int) $subjects_id;
        
        $filter = [
            'published' => self::PUBLISHED,
            'deleted' => self::DELETED_NO
        ];
        if ($subjects_id) {
            $filter['subjects_id'] = (int) $subjects_id;
        }
        $this->db->select('(select count(*) from storage_question as sq where sq.storage_id = ' . $this->table_name . '.storage_id and sq.deleted = 0) as num_question');
        
        return $this->findAll($filter, null, null, 'title', 'asc');
    }
  
    
    
    function count()
    {
        return $this->db->count_all_results();
    }
    
    public function getById($storageId) {
        return $this->find_by_pkey($storageId);
    }
}
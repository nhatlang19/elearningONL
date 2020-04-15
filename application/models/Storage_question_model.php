<?php
class Storage_question_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('storage_question', 'storage_question_id');
    }
    
    public function getAll($start = null, $count = null, $subjects_id = 0)
    {
        $this->db->join('storage as s', 's.storage_id = sq.storage_id', "LEFT");
        $this->db->select('sq.*, s.title');
        $this->db->from($this->table_name . ' as sq');
        $this->db->group_by('sq.storage_question_id');
        
        if ($subjects_id) {
            $this->db->where('s.subjects_id', $subjects_id);
        }
        
        $this->db->where('s.published', PUBLISHED);
        $this->db->where('s.deleted', DELETED_NO);
        $this->db->where('sq.deleted', DELETED_NO);
        
        $filters = [];
        return $this->findAll($filters, $start, $count);
    }

    function getStorageQuestionAll($title = null, $subjects_id = 0, $storage_id = -1, $start = null, $count = null)
    {
        // start cache
        $this->db->start_cache();
        
        $this->db->select('sq.*, s.title');
        $this->db->from($this->table_name . ' as sq');
        $this->db->join('storage as s', 's.storage_id = sq.storage_id');
        $this->db->join('subjects as sub', 'sub.subjects_id = s.subjects_id', 'left');
        if ($title) {
            $this->db->like('sq.question_name', $title);
        }
        
        if ($subjects_id) {
            $this->db->where('s.subjects_id', $subjects_id);
        }
        
        if ($storage_id > 0) {
            $this->db->where('sq.storage_id', $storage_id);
        }
        
        $query = $this->db->get();
        // stop cache
        $this->db->stop_cache();
        
        // get total records before filter by limit
        $this->table_record_count = $query->num_rows();
        
        $this->db->order_by('sq.question_name', 'asc');
        $this->db->order_by('sq.updated_time', 'desc');
        
        $this->db->group_by('sq.storage_question_id');
        
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
            $results = $query->result_array();
        }
        
        // flush cache
        $this->db->flush_cache();
        return $results;
    }

    function getStorageQuestionByStorageIdRandom($storage_id = -1, $num_rand = 0)
    {
        $results = array();
        if ($storage_id != - 1 && $num_rand) {
            $num_rand = intval($num_rand);
            
            $sql = "SELECT SUBSTRING_INDEX(GROUP_CONCAT(sq.storage_question_id ORDER BY RAND() SEPARATOR \"|||\"), \"|||\", $num_rand ) AS sqid";
            $sql .= " FROM " . $this->table_name . " as sq";
            $sql .= " WHERE sq.published = ?";
            $sql .= " AND sq.storage_id = ?";
            $sql .= " AND sq.deleted = ?";
            
            $query = $this->db->query($sql, array(1, $storage_id, DELETED_NO));
            
            if (! empty($query) && $query->num_rows() > 0) {
                $temp = $query->result_array();
                $results = array_pop($temp);
            }
        }
        return $results;
    }

    function countAllStoragePublished()
    {
        $this->db->from($this->table_name);
        $this->db->where(array(
            'published' => PUBLISHED,
            'deleted' =>  DELETED_NO
        ));
        return $this->db->count_all_results();
    }
    
    function getCountByStorageId($storage_id) {
        $this->db->from($this->table_name);
        $this->db->where(array(
            'storage_id' => $storage_id,
            'published' => PUBLISHED,
            'deleted' =>  DELETED_NO
        ));
        return $this->db->count_all_results();
    }
    
    function getAllByHashkey($hashKeys)
    {
        $this->db->where_in('hashkey', $hashKeys);
        return $this->findAll();
    }
    
    public function loadDataInfile($filename) {

        $local = empty(getenv("CLEARDB_DATABASE_URL")) ? 'LOCAL ' : '';

        $query = "LOAD DATA " . $local . "INFILE '$filename'" . 
                 " IGNORE" .
                 " INTO TABLE {$this->table_name}" . 
                 " FIELDS TERMINATED BY '|' ".
                 " LINES TERMINATED BY '\n' ".
                 " (question_name,storage_id,hashkey,select_any) ;";
        
        $this->db->query($query);
        
        @unlink($filename);
    }
    
    public function deleteQuestion($id) {
        $data = $this->find_by_pkey($id);
        if(empty($data)) {
            return;
        }
        
        $hash = md5($data->storage_id . '_' . $data->question_name . '_' . DELETED_YES . '_' . $data->updated_time);
        return $this->update_by_pkey($id, ['deleted' => DELETED_YES, 'hashkey' => $hash]);
    }
}
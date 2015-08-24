<?php

class Storage_answer_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('storage_answer', 'storage_answer_id');
    }

    function deleteByStorageId($storage_question_id)
    {
        $filters = array(
            'storage_question_id' => $storage_question_id
        );
        $this->delete($filters);
    }

    function getAnswerByStorageQuestionId($storageId)
    {
        $where['storage_question_id'] = $storageId;
        
        return $this->findByFilter($where);
    }
    
    function getAnswerByHashKey($hashKey)
    {
        $where['hashkey'] = $hashKey;
        return $this->findByFilter($where);
    }
    
    function getAnswerBySqid($storage_question_id = NULL)
    {
        $results = array();
        if ($storage_question_id) {
            
            // $this->db->select('GROUP_CONCAT(sa.answer SEPARATOR "|||") AS answer
            // , GROUP_CONCAT(sa.correct_answer SEPARATOR "|||") AS correct_answer
            // , GROUP_CONCAT(sa.storage_answer_id SEPARATOR "|||") AS storage_answer_id
            // , sa.storage_question_id
            // ');
            $this->db->select('sa.*');
            $this->db->from($this->table_name . ' as sa');
            $this->db->where_in('sa.storage_question_id', $storage_question_id);
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                $results = $query->result_array();
            }
        }
        return $results;
    }
    
    public function loadDataInfile($filename) {
        $query = "LOAD DATA INFILE '$filename'" .
        " IGNORE" .
        " INTO TABLE {$this->table_name}" .
        " FIELDS TERMINATED BY '|' ".
        " LINES TERMINATED BY '\n' ".
        " (correct_answer,answer,hashkey) ;";
        $this->db->query($query);
        
        @unlink($filename);
    }
    
    public function deleteByHash($hashKeys) {
        $this->db->where_in('hashkey', $hashKeys);
        $this->db->delete($this->table_name);
    }
}
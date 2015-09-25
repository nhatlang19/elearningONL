<?php
class Student_topic_model extends Ext_Model {
    public function __construct()
    {
        parent::__construct('student_topic', 'id');
    }
    
    public function getTopicStudent($topic_manage_id, $student_id) {
        
        $this->db->select('t.*');
        $this->db->join('topic as t', 't.topic_id = ' . $this->table_name  . '.topic_id');
        $this->db->where('t.topic_manage_id', $topic_manage_id);
        $this->db->where($this->table_name  . '.student_id', $student_id);
        
        $result = $this->findAll();
        if (! empty($result)) {
            return $result[0];
        }
        
        return $result;
    }
    
    public function createData($student_id, $topic_id) {
        $data = array(
            'student_id' => $student_id, 
            'topic_id' => $topic_id
        );
        return $this->create($data);
    }
    
    public function updateFinished($student_id, $topic_id, $student_mark_id) {
        $filters = array(
            'student_id' => $student_id,
            'topic_id' => $topic_id
        );
        
        $data = array(
            'finished' => 1  , 
            'student_mark_id' => $student_mark_id
        );
        
        $this->update($filters, $data);
    }
}
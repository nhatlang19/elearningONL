<?php

class Student_answer_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('student_answer', 'answer_student_id');
    }

    public function getAnswerOfStudentId($student_id, $topic_id, $student_mark_id)
    {
        $where = array(
            'student_id' => $student_id,
            'topic_id' => $topic_id,
            'student_mark_id' => $student_mark_id
        );
        $this->db->where($where);
        
        $this->db->order_by('number_question', 'ASC');
        $this->db->select('question_id, answer, number_question');
        $query = $this->db->get($this->table_name);
        
        $results = array();
        if (! empty($query) && $query->num_rows() > 0) {
            $results = $query->result_array();
        }
        
        return $results;
    }
}
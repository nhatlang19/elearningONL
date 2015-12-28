<?php

class Score_model extends Ext_Model
{

    function scoring($topic_id = 0, $student_id = null, $student_mark_id)
    {
        $results = array();
        if ($topic_id) {
            $this->db->select('stu_ans.student_id, q.correct, `stu_ans`.`answer`, count(*) as number_correct');
            $this->db->from('question AS q');
            $this->db->join('student_answer AS stu_ans', 'stu_ans.question_id = q.storage_question_id', 'left');
            $this->db->join('student_info AS si', 'si.student_id = stu_ans.student_id', 'left');
            $this->db->where_in('q.topic_id', $topic_id);
            $this->db->where_in('stu_ans.topic_id', $topic_id);
            $this->db->where('q.`correct` = `stu_ans`.`answer`');
            // $this->db->where('si.is_mark', 0);
            if ($student_id) {
                $this->db->where('si.student_id', $student_id);
            }
            $this->db->where('stu_ans.student_mark_id', $student_mark_id);
            
            $this->db->order_by('si.student_id', 'ASC');
            $this->db->order_by('q.number', 'ASC');
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                if ($student_id) {
                    $results = $query->row_array();
                } else {
                    $results = $query->result_array();
                }
            }
//             echo $this->db->last_query();exit;
        }
        return $results;
    }

    function update_data($data)
    {
        $this->table_name = 'student_info';
        $this->score_model->update_batch($data, 'student_id');
    }
}
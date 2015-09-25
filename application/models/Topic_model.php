<?php

class Topic_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('topic', 'topic_id');
    }

    function getNumberQuestion($topic_id)
    {
        $this->db->select('tm.number_questions');
        $this->db->from($this->table_name . ' AS t');
        $this->db->join('topic_manage AS tm', 'tm.topic_manage_id = t.topic_manage_id');
        $this->db->where('t.topic_id', $topic_id);
        $query = $this->db->get();
        if (! empty($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->number_questions;
        }
        return 0;
    }

    function getTopicByTopicManageId($topic_manage_id)
    {
        $results = array();
        if ($topic_manage_id) {
            $this->db->select('t.*');
            $this->db->from('topic as t');
            $this->db->where('t.topic_manage_id', $topic_manage_id);
            $this->db->order_by('t.code', 'asc');
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                $results = $query->result_array();
            }
        }
        return $results;
    }

    function getTopicByTopicManageIdRandom($topic_manage_id)
    {
        $results = array();
        if ($topic_manage_id) {
            $this->db->select('t.*, tm.title');
            $this->db->from('topic as t');
            $this->db->join('topic_manage AS tm', 'tm.topic_manage_id = t.topic_manage_id');
            $this->db->where('t.topic_manage_id', $topic_manage_id);
            $this->db->order_by('rand()');
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                $temp = $query->result();
                $results = $temp[0];
                unset($temp);
            }
        }
        return $results;
    }

    /**
     * Lay du lieu ko co cau tra loi
     * 
     * @param int $topic_id            
     * @return multitype: array
     */
    function getDataNoCorrectAnswer($topic_id = 0)
    {
        $results = array();
        if ($topic_id) {
            $this->db->query("SET SESSION group_concat_max_len = " . GROUP_CONCAT_MAX_LENGTH . ";");
            
            $this->db->select('sq.storage_question_id, sq.question_name, q.number, GROUP_CONCAT(sa.answer SEPARATOR "|||") AS answer');
            $this->db->from('question AS q');
            $this->db->join('answer AS a', 'a.storage_question_id = q.storage_question_id');
            $this->db->join('storage_question AS sq', 'sq.storage_question_id = q.storage_question_id');
            $this->db->join('storage_answer AS sa', 'sa.storage_answer_id = a.storage_answer_id');
            $this->db->where('q.topic_id', $topic_id);
            $this->db->where('a.topic_id', $topic_id);
            $this->db->order_by('q.number', 'ASC');
            $this->db->group_by('sq.storage_question_id');
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                $results = $query->result();
            }
        }
        return $results;
    }

    /**
     *
     * lay du lieu de xuat file doc
     * 
     * @param unknown_type $topic_id            
     */
    function getData($topic_id = 0)
    {
        $results = array();
        if ($topic_id) {
            $this->db->query("SET SESSION group_concat_max_len = " . GROUP_CONCAT_MAX_LENGTH . ";");
            
            $this->db->select('sq.storage_question_id, sq.question_name, q.number, GROUP_CONCAT(sa.answer SEPARATOR "|||") AS answer
			, GROUP_CONCAT(a.correct_answer) AS correct_answer');
            $this->db->from('question AS q');
            $this->db->join('answer AS a', 'a.storage_question_id = q.storage_question_id');
            $this->db->join('storage_question AS sq', 'sq.storage_question_id = q.storage_question_id');
            $this->db->join('storage_answer AS sa', 'sa.storage_answer_id = a.storage_answer_id');
            $this->db->where('q.topic_id', $topic_id);
			$this->db->where('a.topic_id', $topic_id);
            $this->db->order_by('q.number', 'ASC');
            $this->db->group_by('sq.storage_question_id');
            
            $query = $this->db->get();
            
            if (! empty($query) && $query->num_rows() > 0) {
                $results = $query->result_array();
            }
        }
        return $results;
    }
}
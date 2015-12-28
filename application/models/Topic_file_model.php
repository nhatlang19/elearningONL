<?php

class Topic_file_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('topic_files', 'id');
    }

    function getFilesTopicManageId($topic_manage_id)
    {
        $this->db->select('tf.*, c.class_name');
        $this->db->from($this->table_name . ' as tf');
        $this->db->where('tf.topic_manage_id', $topic_manage_id);
        $this->db->join('class as c', 'c.class_id = tf.class_id');
        $query = $this->db->get();
        return $query->result_array();
    }
}
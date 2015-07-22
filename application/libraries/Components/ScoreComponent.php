<?php

class ScoreComponent
{

    var $_CI;

    function __construct()
    {
        $this->_CI = & get_instance();
        
        $this->_CI->load->model('topic_model');
        $this->_CI->load->model('score_model');
        $this->_CI->load->model('student_mark_model');
        
        $this->_CI->load->library('commonobj');
    }

    public function calScore($topic_id, $student_id, $student_mark_id)
    {
        $number_question = $this->_CI->topic_model->getNumberQuestion($topic_id);
        // lay so cau tra loi dung tat ca hoc sinh co topic_id = 19
        $result = $this->_CI->score_model->scoring($topic_id, $student_id, $student_mark_id);
        
        $data = array();
        $data['score'] = 0;
        $data['number_correct'] = 0;
        $data['is_mark'] = 1; // Đã chấm điểm
        $data['ip_address'] = $this->_CI->commonobj->getIpAddress();
        if (count($result) && $number_question) {
            // tính ra điểm
            $score = $this->_CI->commonobj->funcScoring(SCORE_MAX, $number_question, $result['number_correct']);
            
            $data['score'] = $score;
            $data['number_correct'] = $result['number_correct'];
        }
        // cập nhật điểm số và số câu trả lời đúng vào db
        $filters = array(
            'id' => $student_mark_id
        );
        $this->_CI->student_mark_model->update($filters, $data);
    }
}
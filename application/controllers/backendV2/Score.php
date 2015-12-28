<?php

/**
 * @author nhox
 * @deprecated Quản lý điểm số của học sinh
 */
class Score extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('score_model');
        $this->load->model('topic_model');
        
        $this->load->library('commonobj');
    }

    function lists()
    {
        $this->index();
    }

    function index()
    {}

    /**
     * chấm điểm
     */
    function auto_scoring($topic_manage_id, $number_question)
    {
        // lay tat ca topic_id theo topic_manage_id
        $topics = $this->topic_model->getTopicByTopicManageId($topic_manage_id);
        foreach ($topics as $topic) {
            $topic_id = $topic['topic_id'];
            
            // lay so cau tra loi dung tat ca hoc sinh co topic_id = 19
            $arrays = $this->score_model->scoring($topic_id);
            if (count($arrays)) {
                foreach ($arrays as $key => $value) {
                    
                    // tính ra điểm
                    $score = Commonobj::funcScoring(SCORE_MAX, $number_question, $value['number_correct']);
                    
                    $arrays[$key]['score'] = $score;
                    $arrays[$key]['is_mark'] = 1; // Đã chấm điểm
                }
                // cập nhật điểm số và số câu trả lời đúng vào db
                $this->score_model->update_data($arrays);
            }
        }
        redirect(BACKEND_V2_TMPL_PATH . 'topic/lists');
    }

    /**
     */
    function export()
    {}
}
<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class StorageQuestion extends Ext_Controller
{
    protected $mainModel = 'storage_question_model';
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('storage_model');
        $this->load->model('storage_question_model');
        $this->load->model('storage_answer_model');
    }

    public function lists()
    {
        $header['title'] = 'Quản lý kho câu hỏi';
        $subject_id = (int)$this->getUserInfo()->subjects_id;

        // get data
        $per_page = 10;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $data = [];
        $data['lists'] = $this->storage_question_model->getAll($segment, $per_page, $subject_id);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage_questions/lists', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }
    
    public function delete($id = null) {
        if($this->input->is_ajax_request() && $id) {
            $id = intval($id);
            $this->storage_question_model->deleteQuestion($id);
            $this->sendAjax();
        } else {
            show_404();
        }
    }

    public function save()
    {
        $id = intval($this->input->post('id'));
        if ($this->input->post()) {
            $data['question_name'] = trim(addslashes($this->input->post('question_name')));
            $data['storage_id'] = intval($this->input->post('storage'));
            
            // answer for text
            $answers = $this->input->post('answer_name');
            $correct_answers = $this->input->post('correct_answer');
            
            $invalidQuestionName = empty($data['question_name']);
            $invalidCorrectAnswer = empty($correct_answers) || !count($correct_answers);
            $invalidAnswer = empty($answers) || !count($answers);
            if($invalidQuestionName || $invalidCorrectAnswer || $invalidAnswer) {
                if($invalidQuestionName) {
                    $this->sendAjax(1, 'Câu hỏi không thể rỗng');
                } elseif($invalidCorrectAnswer) {
                    $this->sendAjax(1, 'Phải có ít nhất 1 câu trả lời đúng');
                } elseif($invalidAnswer) {
                    $this->sendAjax(1, 'Phải có ít nhất 1 câu trả lời');
                } 
            } else {
                $hash = md5($data['storage_id'] . '_' . $data['question_name']);
                $data['hashkey'] = $hash;
                
                // save into storage table
                if ($id) {
                    $storage_question_id = $id;
                    $this->storage_question_model->update_by_pkey($id, $data);
                } else {
                    $storage_question_id = $this->storage_question_model->create_ignore($data);
                }
                unset($data);
                // save into storage_answer
                $data['storage_question_id'] = $storage_question_id;
                $data['hashkey'] = $hash;
                $this->storage_answer_model->deleteByHash([$hash]);
                
                
                
                // duyet danh sach cau tra loi va luu db
                $idx = 0;
                foreach ($answers as $answer) {
                    if ($answer) {
                        if (in_array($idx, $correct_answers)) {
                            $data['correct_answer'] = 1;
                        } else {
                            $data['correct_answer'] = 0;
                        }
                        $data['answer'] = addslashes($answer);
                        $this->storage_answer_model->create($data);
                        $idx ++;
                    }
                }
                
                if ($storage_question_id) {
                    $this->sendAjax();
                } else {
                    $this->sendAjax(1, 'Câu hỏi đã tồn tại');
                }
            }
        }
    }

    public function view($id = null)
    {
        $qid = intval($id);
        
        $data['storage_questions'] = $this->storage_question_model->find_by_pkey($qid);
        $data['storage_answer'] = $this->storage_answer_model->getAnswerByHashKey($data['storage_questions']->hashkey);
        $this->load->view(BACKEND_V2_TMPL_PATH . 'storage_questions/load_info_question', $data);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm câu hỏi';
        
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa câu hỏi';
            $data['id'] = $id;
            $data['storage_question'] = $this->storage_question_model->find_by_pkey($id);
            $data['storage_answer'] = $this->storage_answer_model->getAnswerByHashKey($data['storage_question']->hashkey);
        }
        
        $data['title'] = $header['title'];
        $data['storage'] = $this->storage_model->getStoragePublishedByUser($this->getUserInfo()->subjects_id);
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage_questions/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
}

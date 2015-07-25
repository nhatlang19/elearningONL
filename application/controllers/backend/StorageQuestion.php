<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class StorageQuestion extends Ext_Controller
{

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
        
        // get data
        $per_page = 20;
        $txt_search = $this->input->post('txt_search');
        $storage_id = $this->input->post('storage_id');
        $segment = $this->uri->segment(self::_URI_SEGMENT);
        
        $user = $this->getUserInfo();
        
        $base_url = base_url() . BACK_END_TMPL_PATH . 'storage-question/lists';
        $data['storage_questions'] = $this->storage_question_model->getStorageQuestionAll($txt_search, $user->subjects_id, $storage_id, $segment, $per_page);
        
        $config = $this->configPagination($base_url, $this->storage_question_model->table_record_count, $per_page, self::_URI_SEGMENT);
        $this->pagination->initialize($config);
        
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'storage_questions/lists', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }

    public function delete($id)
    {
        $id = intval($id);
        $this->storage_question_model->delete_by_pkey($id);
        redirect(BACK_END_TMPL_PATH . 'storage-question/lists');
    }

    public function save()
    {
        $id = intval($this->input->post('id'));
        
        if ($this->input->post()) {
            
            $data['question_name'] = addslashes($this->input->post('question_name'));
            $data['storage_id'] = intval($this->input->post('storage'));
            $type = intval($this->input->post('type'));
            $data['type'] = $type;
            
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
            $this->storage_answer_model->deleteByStorageId($storage_question_id);
            
            if (! $type) {
                // answer for text
                $answers = $this->input->post('answer_name');
                $correct_answer = $this->input->post('correct_answer');
            } else {
                // answer for image
                $answers = $this->input->post('ImagePath');
                $correct_answer = $this->input->post('checkbox1');
            }
            
            // duyet danh sach cau tra loi va luu db
            $idx = 0;
            foreach ($answers as $answer) {
                if ($answer) {
                    if ($idx == $correct_answer) {
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
                redirect(BACK_END_TMPL_PATH . 'storage-question/lists');
            } else {
                $newdata = array(
                    'error' => 'Câu hỏi đã tồn tại'
                );
                
                $this->session->set_userdata($newdata);
                $task = $this->input->post('task');
                if ($task == 'add') {
                    redirect(BACK_END_TMPL_PATH . 'storage-question/edit');
                } else {
                    redirect(BACK_END_TMPL_PATH . 'storage-question/edit/' . $id);
                }
            }
        }
    }

    public function view()
    {
        if($this->input->is_ajax_request()) {
            $qid = intval($this->input->post('qid'));
            
            $data['storage_questions'] = $this->storage_question_model->find_by_pkey($qid);
            $data['storage_answer'] = $this->storage_answer_model->getAnswerByStorageQuestionId($qid);
            $this->load->view(BACK_END_TMPL_PATH . 'storage_questions/load_info_question', $data);
        } else {
            show_404();
        }
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm câu hỏi';
        
        $data = array();
        $data['task'] = 'add';
        
        if ($id) {
            $header['title'] = 'Chỉnh sửa câu hỏi';
            $data['task'] = 'edit';
            $data['id'] = $id;
            $data['storage_questions'] = $this->storage_question_model->find_by_pkey($id);
            $data['storage_answer'] = $this->storage_answer_model->getAnswerByStorageQuestionId($id);
        }
        
        $data['storage'] = $this->storage_model->getStorageAllByUser($this->getUserInfo()->subjects_id);
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'storage_questions/edit', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }
}

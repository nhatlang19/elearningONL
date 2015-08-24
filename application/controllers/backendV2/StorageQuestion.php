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
//         // get data
//         $per_page = 20;
//         $txt_search = $this->input->post('txt_search');
           $subject_id = (int)$this->getUserInfo()->subjects_id;
//         $segment = $this->uri->segment(self::URI_SEGMENT);
        
//         $user = $this->getUserInfo();
        
//         $base_url = base_url() . BACKEND_V2_TMPL_PATH . 'storage-question/lists';
//         $data['storage_questions'] = $this->storage_question_model->getStorageQuestionAll($txt_search, $user->subjects_id, $storage_id, $segment, $per_page);
        
//         $config = $this->configPagination($base_url, $this->storage_question_model->table_record_count, $per_page, self::URI_SEGMENT);
//         $this->pagination->initialize($config);
        
//         $data['pagination'] = $this->pagination;
        
//         $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage_questions/lists', $data, TRUE);
//         $this->loadTemnplateBackend($header, $content);

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
            $this->storage_question_model->delete_by_pkey($id);
//             $this->lphcache->cleanCacheByFunction($this->storage_question_model->table_name, 'getAll');
            $this->sendAjax();
        } else {
            show_404();
        }
    }

    public function save()
    {
        $id = intval($this->input->post('id'));
        
        if ($this->input->post()) {
            
            $data['question_name'] = addslashes($this->input->post('question_name'));
            $data['storage_id'] = intval($this->input->post('storage'));
            
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
            
            // answer for text
            $answers = $this->input->post('answer_name');
            $correct_answer = $this->input->post('correct_answer');
            
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
                redirect(BACKEND_V2_TMPL_PATH . 'storage-question/lists');
            } else {
                $newdata = array(
                    'error' => 'Câu hỏi đã tồn tại'
                );
                
                $this->session->set_userdata($newdata);
                $task = $this->input->post('task');
                if ($task == 'add') {
                    redirect(BACKEND_V2_TMPL_PATH . 'storage-question/edit');
                } else {
                    redirect(BACKEND_V2_TMPL_PATH . 'storage-question/edit/' . $id);
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
        $data['storage'] = $this->storage_model->getStorageAllByUser($this->getUserInfo()->subjects_id);
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage_questions/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
}

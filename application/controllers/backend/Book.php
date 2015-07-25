<?php

class Book extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('topic_model');
        $this->load->model('topic_book');
        $this->load->model('topic_manage_model');
        
        $this->load->library('commonobj');
    }

    function index()
    {}

    function edit($id = null)
    {
        $title = 'Thêm ';
        $data = array();
        $task = 'add';
        if ($id) {
            $title = 'Chỉnh sửa';
            $task = 'edit';
            // $data['storage'] = $this->storage_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        if ($this->input->post()) {
            pr($this->input->post());
            exit();
            $task = $this->input->post('task', 'add');
            
            $id = (int) $this->input->post('id', 0);
            $value['title'] = addslashes($this->input->post('title'));
            
            $subjects_id = $this->getUserInfo()->subjects_id;
            if ($subjects_id) {
                $value['subjects_id'] = $subjects_id;
            } else {
                $value['subjects_id'] = (int) $this->input->post('subjects_id');
            }
            
            if ($task == 'add') {
                
                $this->storage_model->create($value);
            } else {
                $this->storage_model->update_by_pkey($id, $value);
            }
            unset($value);
            redirect(BACK_END_TMPL_PATH . 'storage/lists');
        }
        
        $header['title'] = $title;
        $data['title'] = $title;
        $data['task'] = $task;
        $data['user'] = $this->getUserInfo();
        $data['topic_manage'] = $this->topic_manage_model->getAllTopicManage();
        $content = $this->load->view(BACK_END_TMPL_PATH . 'book/edit', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }
}
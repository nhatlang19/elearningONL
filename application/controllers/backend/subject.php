<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * class môn học
 * 
 * @author nhox
 *        
 */
class Subject extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('subject_model');
    }

    function lists()
    {
        $header['title'] = 'Quản lý môn học';
        
        // get data
        $per_page = 10;
        $title = $this->input->post('title');
        $data = array();
        
        $segment = $this->uri->segment(self::_URI_SEGMENT);
        
        $base_url = base_url() . BACK_END_TMPL_PATH . 'subject/lists';
        
        $data['lists'] = $this->subject_model->getAllSubjects($title, $segment, $per_page);
        
        $config = $this->configPagination($base_url, $this->subject_model->table_record_count, $per_page, self::_URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'subject/lists', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm môn học';
        $task = 'add';
        
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa môn học';
            $data['subject'] = $this->subject_model->find_by_pkey($id);
            $data['id'] = $id;
            $task = 'edit';
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data['subjects_name'] = $this->input->post('subjects_name');
            
            if (! $id) {
                // save into subject table
                $this->subject_model->create($data);
            } else {
                $this->subject_model->update_by_pkey($id, $data);
            }
            unset($data);
            
            redirect(BACK_END_TMPL_PATH . 'subject/lists');
        }
        
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $content = $this->load->view(BACK_END_TMPL_PATH . 'subject/edit', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }
}

/* End of file subject.php */
/* Location: ./application/controllers/subject.php */
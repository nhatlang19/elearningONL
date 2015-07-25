<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * class kỳ thi
 * 
 * @author nhox
 *        
 */
class Exam extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('exam_model');
    }

    public function lists()
    {
        $header['title'] = 'Quản lý hình thức thi';
        
        // get data
        $per_page = 10;
        $title = $this->input->post('title');
        $data = array();
        
        $segment = $this->uri->segment(self::_URI_SEGMENT);
        
        $base_url = base_url() . BACK_END_TMPL_PATH . 'exam/lists';
        
        $data['lists'] = $this->exam_model->getAllExam($title, $segment, $per_page);
        
        $config = $this->configPagination($base_url, $this->exam_model->table_record_count, $per_page, self::_URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'exam/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm hình thức thi';
        $task = 'add';
        
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa hình thức thi';
            $data['exam'] = $this->exam_model->find_by_pkey($id);
            $data['id'] = $id;
            $task = 'edit';
        }
        
        if ($this->input->post()) {
            $id = intval($this->input->post('id'));
            
            $data['title'] = addslashes($this->input->post('title'));
            $data['time'] = intval($this->input->post('time'));
            
            if (! $id) {
                // save into exam table
                $this->exam_model->create_ignore($data);
            } else {
                $this->exam_model->update_by_pkey($id, $data);
            }
            
            unset($data);
            
            redirect(BACK_END_TMPL_PATH . 'exam/lists');
        }
        
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $content = $this->load->view(BACK_END_TMPL_PATH . 'exam/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function published()
    {}

    public function unpublished()
    {}
}

/* End of file storage.php */
/* Location: ./application/controllers/storage.php */